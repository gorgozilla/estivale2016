<?php
 
defined('JPATH_BASE') or die;
 
jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * Custom Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	        com_my
 * @since		1.6
 */
class JFormFieldAccred extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Members';
 
	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	public function getOptionsDays()
	{
		$arr = array(
			JHTML::_('select.option', '29 juillet', JText::_('29 juillet') ),
			JHTML::_('select.option', '30 juillet', JText::_('30 juillet') ),
			JHTML::_('select.option', '31 juillet', JText::_('31 juillet') ),
			JHTML::_('select.option', '01', JText::_('01 août') )
		);
 
		return $arr;
	}
	
	public function getOptionsSex()
	{
		$arr = array(
			JHTML::_('select.option', 'M', JText::_('Masculin')),
			JHTML::_('select.option', 'F', JText::_('Féminin'))
		);
 
		return $arr;
	}
	
	public function getOptionsCamping()
	{
		$arr = array(JHTML::_('select.option', '1', 'Dors au camping' ));
		return $arr;
	}
}