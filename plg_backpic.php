<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.Contact
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

class PlgContentBackpic extends JPlugin {
	protected $db;

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
				 
			$db->setQuery($query);
			$row = $db->loadAssoc();
			// echo "</br> image : " . $row['pic'];
			$row['pic'] = htmlspecialchars($row['pic']);
			$row['width'] = htmlspecialchars($row['width']);
			$row['height'] = htmlspecialchars($row['height']);
			
			$doc = JFactory::getDocument();
			$UrlSite = JURI::root();
			$doc->addStyleDeclaration("
			body {background: url('{$UrlSite}{$row['pic']}') no-repeat;background-size: {$row['width']} {$row['height']};}
			");
		
	}
	

}
