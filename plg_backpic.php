<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.Contact
 * @version		0.2
 * @copyright   Copyright (C) 2016 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * &@license    https://trangell.com
 */

defined('_JEXEC') or die;

//use Joomla\Registry\Registry;
class PlgContentPlg_Backpic extends JPlugin {
	protected $db;
	protected $autoloadLanguage = true;

	public function onContentPrepare() {
		if (JRequest::getVar('option')==='com_content' && JRequest::getVar('view')==='article') {
			$articleId = JRequest::getInt('id');
			//$db =& JFactory::getDBO();
		}else {
			return false;	
		}
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			
		
			$query->select('*');
			$query->from('#__backpic');
			$query->where('article_id = ' . $articleId);
			$query->where('published = 1');
			$query->where('type = 1');
				 
			$db->setQuery($query);
			$row = $db->loadAssoc();

			if ($row['published'] == 1 AND $row['type'] == 1) {
				
				$row['pic'] 			= htmlspecialchars($row['pic'], ENT_QUOTES, 'UTF-8');
				$row['width'] 			= htmlspecialchars($row['width'], ENT_QUOTES, 'UTF-8');
				$row['height'] 			= htmlspecialchars($row['height'], ENT_QUOTES, 'UTF-8');
				$row['custom'] 			= htmlspecialchars($row['custom'], ENT_QUOTES, 'UTF-8');
				$row['menudbid']		= htmlspecialchars($row['menudbid'], ENT_QUOTES, 'UTF-8');
				$row['template_name']	= htmlspecialchars($row['template_name'], ENT_QUOTES, 'UTF-8');

				//echo $row['template_name'];

				if (!empty($row['template_name']) AND !empty($row['template_name'] == 0)) {

					$selectsetTemplate = JFactory::getApplication();
			 		$selectsetTemplate->setTemplate("{$row['template_name']}", null);
				}
			
			$doc = JFactory::getDocument();
			$UrlSite = JURI::root();
				if (!empty($row['pic'])) {
					$doc->addStyleDeclaration("
						body {background: url('{$UrlSite}{$row['pic']}') no-repeat ;background-size: {$row['width']} {$row['height']};}
				");
				}
				
				if (!empty($row['custom'])) {
					$doc->addStyleDeclaration("
						{$row['custom']}
				");
				}
			}
			

	}	

}



