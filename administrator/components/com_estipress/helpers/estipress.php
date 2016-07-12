<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_estipress
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Estipress component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_estipress
 * @since       1.6
 */
class EstipressHelpersEstipress extends JHelperContent
{
	public static $extension = 'com_estipress';

	/**
	 * @return  JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_estipress';
		$level = 'component';

		$actions = JAccess::getActions('com_estipress', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
	
	public static function addSubmenu($vName)
    {
        JHtmlSidebar::addEntry(
            'Liste des accréditations',
            'index.php?option=com_estipress&view=accred',
            $vName == 'accred'
        );
    }
}