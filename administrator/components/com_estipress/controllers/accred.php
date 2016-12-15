<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/** Include PHPExcel */
require_once JPATH_COMPONENT .'/lib/PHPExcel.php';
require_once JPATH_COMPONENT .'/helpers/user.php';

class EstipressControllerAccred extends JControllerAdmin
{
	public $formData = null;
	public $model = null;
	public $userEstipress = null;
	
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
		}elseif($task=='exportAccred'){
			$this->exportAccred();
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
	
	public function exportAccred()
	{
		$app      = JFactory::getApplication();
		$this->accred = $this->model->listItems();
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Estivale Open Air")
									 ->setLastModifiedBy("Estivole")
									 ->setTitle("Export Estipress")
									 ->setSubject("Export des accrdéitations Estipress");
									 
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle("Export");

		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("A1", "Estivale Open Air 2016 - Liste des accréditations")
					->setCellValue("A3", "Nom")
					->setCellValue("B3", "Email")
					->setCellValue("C3", "Média")
					->setCellValue("D3", "Type média")
					->setCellValue("E3", "Fonction")
					->setCellValue("F3", "Zone diffusion")
					->setCellValue("G3", "Dates présence");
		
		// Add data
		for ($i = 4; $i < count($this->accred)+4; $i++) {
			$dates_presence='';
			$userId = $this->accred[$i-4]->user_id; 
			$userProfile = $this->model->getProfileEstipress($userId);
			for($x=0; $x<count($userProfile->estipress['dates_presence']); $x++){ 
				$dates_presence .= $userProfile->estipress['dates_presence'][$x].', '; 
			}
			
			$objPHPExcel->getActiveSheet()
						->setCellValue("A".$i, $userProfile->estipress['firstname'].' '.$userProfile->estipress['lastname'])
						->setCellValue("B".$i, $userProfile->estipress['email'])
						->setCellValue("C".$i, $userProfile->estipress['media'])
						->setCellValue("D".$i, $userProfile->estipress['type_media'])
						->setCellValue("E".$i, $userProfile->estipress['fonction'])
						->setCellValue("F".$i, $userProfile->estipress['zone_diffusion'])
						->setCellValue("G".$i, $dates_presence);
		}
		// Redirect output to a client’s web browser (Excel2007)
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-Disposition: attachment;filename=\"01simple.xlsx\"");
		header("Cache-Control: max-age=0");
		// If you"re serving to IE 9, then the following may be needed
		header("Cache-Control: max-age=1");
		// If you"re serving to IE over SSL, then the following may be needed
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header ("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); // always modified
		header ("Cache-Control: cache, must-revalidate"); // HTTP/1.1
		header ("Pragma: public"); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$objWriter->save("php://output");
		exit;
	}
}