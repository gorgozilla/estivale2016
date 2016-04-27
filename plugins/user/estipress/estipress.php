<?php
 /**
  * @version		
  * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
  * @license		GNU General Public License version 2 or later; see LICENSE.txt
  */
 
 defined('JPATH_BASE') or die;
 
  /**
   * An example custom profile plugin.
   *
   * @package		Joomla.Plugins
   * @subpackage	user.profile
   * @version		1.6
   */
  class plgUserEstipress extends JPlugin
  {
	/**
	 * @param	string	The context for the data
	 * @param	int		The user id
	 * @param	object
	 * @return	boolean
	 * @since	1.6
	 */
	function onContentPrepareData($context, $data)
	{
		// Check we are manipulating a valid form.
		if (!in_array($context, array('com_users.estipress','com_users.profile','com_users.registration','com_users.user','com_admin.profile'))){
			return true;
		}
 
		$userId = isset($data->id) ? $data->id : 0;
 
		// Load the profile data from the database.
		$db = JFactory::getDbo();
		$db->setQuery(
			'SELECT profile_key, profile_value FROM #__user_profiles' .
			' WHERE user_id = '.(int) $userId .
			' AND profile_key LIKE \'estipress.%\'' .
			' ORDER BY ordering'
		);
		$results = $db->loadRowList();
 
		// Check for a database error.
		if ($db->getErrorNum()) {
			$this->_subject->setError($db->getErrorMsg());
			return false;
		}
 
		// Merge the profile data.
		$data->estipress = array();
		foreach ($results as $v) {
			$k = str_replace('estipress.', '', $v[0]);
			$data->estipress[$k] = json_decode($v[1], true);
		}
 
		return true;
	}
 
	/**
	 * @param	JForm	The form to be altered.
	 * @param	array	The associated data for the form.
	 * @return	boolean
	 * @since	1.6
	 */
	function onContentPrepareForm($form, $data)
	{
		// Load user_profile plugin language
		$lang = JFactory::getLanguage();
		$lang->load('plg_user_estipress', JPATH_ADMINISTRATOR);
 
		if (!($form instanceof JForm)) {
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}
		// Check we are manipulating a valid form.
		if (!in_array($form->getName(), array('com_users.profile', 'com_users.registration','com_users.user','com_admin.profile'))) {
			return true;
		}
		if ($form->getName()=='com_users.profile')
		{
			// Add the profile fields to the form.
			JForm::addFormPath(dirname(__FILE__).'/profiles');
			$form->loadFile('profile', false);
			
			if ($this->params->get('profile-require_firstname', 1) > 0) {
				$form->setFieldAttribute('firstname', 'required', $this->params->get('profile-require_firstname') == 2, 'estipress');
			} else {
				$form->removeField('firstname', 'estipress');
			}
			
			if ($this->params->get('profile-require_lastname', 1) > 0) {
				$form->setFieldAttribute('lastname', 'required', $this->params->get('profile-require_lastname') == 2, 'estipress');
			} else {
				$form->removeField('lastname', 'estipress');
			}

			if ($this->params->get('profile-require_media', 1) > 0) {
				$form->setFieldAttribute('media', 'required', $this->params->get('profile-require_media') == 2, 'estipress');
			} else {
				$form->removeField('media', 'estipress');
			}
			
			if ($this->params->get('profile-require_typemedia', 1) > 0) {
				$form->setFieldAttribute('type_media', 'required', $this->params->get('profile-require_typemedia') == 2, 'estipress');
			} else {
				$form->removeField('type_media', 'estipress');
			}
			
			if ($this->params->get('profile-require_fonction', 1) > 0) {
				$form->setFieldAttribute('fonction', 'required', $this->params->get('profile-require_fonction') == 2, 'estipress');
			} else {
				$form->removeField('fonction', 'estipress');
			}
			
			if ($this->params->get('profile-require_tirage', 1) > 0) {
				$form->setFieldAttribute('tirage', 'required', $this->params->get('profile-require_tirage') == 2, 'estipress');
			} else {
				$form->removeField('tirage', 'estipress');
			}
			
			if ($this->params->get('profile-require_zonediff', 1) > 0) {
				$form->setFieldAttribute('zone_diffusion', 'required', $this->params->get('profile-require_zonediff') == 2, 'estipress');
			} else {
				$form->removeField('zone_diffusion', 'estipress');
			}
			
			if ($this->params->get('profile-require_sitemedia', 1) > 0) {
				$form->setFieldAttribute('site_media', 'required', $this->params->get('profile-require_sitemedia') == 2, 'estipress');
			} else {
				$form->removeField('site_media', 'estipress');
			}
			
			if ($this->params->get('profile-require_datespresence', 1) > 0) {
				$form->setFieldAttribute('dates_presence', 'required', $this->params->get('profile-require_datespresence') == 2, 'estipress');
			} else {
				$form->removeField('dates_presence', 'estipress');
			}
			
			if ($this->params->get('profile-require_deminterviews', 1) > 0) {
				$form->setFieldAttribute('demande_interviews', 'required', $this->params->get('profile-require_deminterviews') == 2, 'estipress');
			} else {
				$form->removeField('demande_interviews', 'estipress');
			}
		}
 
		//In this example, we treat the frontend registration and the back end user create or edit as the same. 
		elseif ($form->getName()=='com_users.registration' || $form->getName()=='com_users.user' )
		{		
			// Add the registration fields to the form.
			JForm::addFormPath(dirname(__FILE__).'/profiles');
			$form->loadFile('profile', false);
			
			if ($this->params->get('register-require_firstname', 1) > 0) {
				$form->setFieldAttribute('firstname', 'required', $this->params->get('register-require_firstname') == 2, 'estipress');
			} else {
				$form->removeField('firstname', 'estipress');
			}
			
			if ($this->params->get('register-require_lastname', 1) > 0) {
				$form->setFieldAttribute('lastname', 'required', $this->params->get('register-require_lastname') == 2, 'estipress');
			} else {
				$form->removeField('lastname', 'estipress');
			}
			
			if ($this->params->get('register-require_media', 1) > 0) {
				$form->setFieldAttribute('media', 'required', $this->params->get('register-require_media') == 2, 'estipress');
			} else {
				$form->removeField('media', 'estipress');
			}
			
			if ($this->params->get('register-require_typemedia', 1) > 0) {
				$form->setFieldAttribute('type_media', 'required', $this->params->get('register-require_typemedia') == 2, 'estipress');
			} else {
				$form->removeField('type_media', 'estipress');
			}
			
			if ($this->params->get('register-require_fonction', 1) > 0) {
				$form->setFieldAttribute('fonction', 'required', $this->params->get('register-require_fonction') == 2, 'estipress');
			} else {
				$form->removeField('fonction', 'estipress');
			}
			
			if ($this->params->get('register-require_tirage', 1) > 0) {
				$form->setFieldAttribute('tirage', 'required', $this->params->get('register-require_tirage') == 2, 'estipress');
			} else {
				$form->removeField('tirage', 'estipress');
			}
			
			if ($this->params->get('register-require_zonediff', 1) > 0) {
				$form->setFieldAttribute('zone_diffusion', 'required', $this->params->get('register-require_zonediff') == 2, 'estipress');
			} else {
				$form->removeField('zone_diffusion', 'estipress');
			}
			
			if ($this->params->get('register-require_sitemedia', 1) > 0) {
				$form->setFieldAttribute('site_media', 'required', $this->params->get('register-require_sitemedia') == 2, 'estipress');
			} else {
				$form->removeField('site_media', 'estipress');
			}
			
			if ($this->params->get('register-require_datespresence', 1) > 0) {
				$form->setFieldAttribute('dates_presence', 'required', $this->params->get('register-require_datespresence') == 2, 'estipress');
			} else {
				$form->removeField('dates_presence', 'estipress');
			}
			
			if ($this->params->get('register-require_deminterviews', 1) > 0) {
				$form->setFieldAttribute('demande_interviews', 'required', $this->params->get('register-require_deminterviews') == 2, 'estipress');
			} else {
				$form->removeField('demande_interviews', 'estipress');
			}
		}			
	}
 
	function onUserAfterSave($data, $isNew, $result, $error)
	{
		$userId	= JArrayHelper::getValue($data, 'id', 0, 'int');
 
		if ($userId && $result && isset($data['estipress']) && (count($data['estipress'])))
		{
			try
			{
				$db = JFactory::getDbo();
				$db->setQuery('DELETE FROM #__user_profiles WHERE user_id = '.$userId.' AND profile_key LIKE \'estipress.%\'');
				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}
 
				$tuples = array();
				$order	= 1;
				foreach ($data['estipress'] as $k => $v) {
					$tuples[] = '('.$userId.', '.$db->quote('estipress.'.$k).', '.$db->quote(json_encode($v)).', '.$order++.')';
				}

				$db->setQuery('INSERT INTO #__user_profiles VALUES '.implode(', ', $tuples));
				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}
			}
			catch (JException $e) {
				$this->_subject->setError($e->getMessage());
				return false;
			}
		}
 
		return true;
	}
 
	/**
	 * Remove all user profile information for the given user ID
	 *
	 * Method is called after user data is deleted from the database
	 *
	 * @param	array		$user		Holds the user data
	 * @param	boolean		$success	True if user was succesfully stored in the database
	 * @param	string		$msg		Message
	 */
	function onUserAfterDelete($user, $success, $msg)
	{
		if (!$success) {
			return false;
		}
 
		$userId	= JArrayHelper::getValue($user, 'id', 0, 'int');
 
		if ($userId)
		{
			try
			{
				$db = JFactory::getDbo();
				$db->setQuery(
					'DELETE FROM #__user_profiles WHERE user_id = '.$userId .
					" AND profile_key LIKE 'estipress.%'"
				);
 
				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}
			}
			catch (JException $e)
			{
				$this->_subject->setError($e->getMessage());
				return false;
			}
		}
 
		return true;
	}
 
 
 }
 
 ?>