<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

require_once JPATH_COMPONENT .'/helpers/job.php';

class EstipressViewAccred extends JViewLegacy
{
	function display($tpl=null)
	{
		$app = JFactory::getApplication();
		$this->state	= $this->get('State');
		$this->pagination	= $this->get('Pagination');
		$this->searchterms	= $this->state->get('filter.search');
		$this->user = JFactory::getUser();
		$this->limitstart=$this->state->get('limitstart');

		//retrieve task list from model
		$model = new EstipressModelAccred();
		$this->accred = $model->listItems();
			
		EstipressHelpersEstipress::addSubmenu('accred');
		$this->sidebar = JHtmlSidebar::render();

		$this->addToolbar();

		//display
		return parent::display($tpl);
	} 

    /**
     * Add the page title and toolbar.
     */
    protected function addToolbar()
    {
        // Get the toolbar object instance
        $bar = JToolBar::getInstance('toolbar');
		JToolbarHelper::title(JText::_('Gestion des accréditations : Liste des accréd.'));
        JToolbarHelper::addNew('member.add');
		JToolbarHelper::deleteList('Etes-vous sûr de vouloir supprimer le(s) membre(s)? Ceci supprimera également toutes les tranches horaires alloues à ce dernier. Alors?', 'members.deleteListMember');
    }
}