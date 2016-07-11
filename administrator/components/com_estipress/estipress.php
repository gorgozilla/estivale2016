<?php // No direct access

defined('_JEXEC') or die;
//load classes
JLoader::registerPrefix('Estipress', JPATH_COMPONENT);
//Load styles and javascripts
EstipressHelpersStyle::load();

$controller	= JControllerLegacy::getInstance('Estipress');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();