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
class EstipressHelpersUser
{	
	public static function getProfilEstipress($userId = 0)
	{
		if ($userId == 0)
		{
			$user   = JFactory::getUser();
			$userId = $user->id;
		}

		// Get the dispatcher and load the user's plugins.
		$dispatcher = JEventDispatcher::getInstance();
		JPluginHelper::importPlugin('user');

		$data = new JObject;
		$data->id = $userId;
		
		// Trigger the data preparation event.
		$dispatcher->trigger('onContentPrepareData', array('com_users.estipress', &$data));

		return $data;
	}
}