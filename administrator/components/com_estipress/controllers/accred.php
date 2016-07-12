<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class EstipressControllerAccred extends JControllerAdmin
{
	public $formData = null;
	public $model = null;
	public $search_text = null;
	
	public function execute($task=null)
	{
		$app      = JFactory::getApplication();
		$modelName  = $app->input->get('model', 'Accred');

		// Required objects 
		$input = JFactory::getApplication()->input; 
		// Get the form data 
		$this->formData = new JRegistry($input->get('jform','','array')); 

		//Get model class
		$this->model = $this->getModel($modelName);

		if($task=='deleteListAccred'){
			$this->deleteListAccred();
		}else{
			$this->display();
		}
	}
	
	public function deleteListAccred()
	{
		$app      = JFactory::getApplication();
		$return = array("success"=>false);
        $ids    = JRequest::getVar('cid', array(), '', 'array');
		
        if (empty($ids)) {
            JError::raiseWarning(500, JText::_('JERROR_NO_ITEMS_SELECTED'));
        }
        else 
		{
			foreach($ids as $id){
				$this->model->delete($id);
			}
			$app->redirect( $_SERVER['HTTP_REFERER']);
        }
	}
}