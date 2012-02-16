<?php
class ProgramController extends Zend_Controller_Action
{
	
	public function init()
	{
		/**
		 * @var Zend_Controller_Action_Helper_ContextSwitch
		 */
		$contextSwitch = $this->getHelper('contextSwitch');
		
		$contextSwitch
		->addActionContext('export', array('xml', 'json', 'csv'))
		->initContext();
		
		/**
		 * @var Zend_Controller_Action_Helper_AjaxContext
		 */
		$ajaxContext = $this->getHelper('ajaxContext');
		
		$ajaxContext
		->addActionContext('list', array('html'))
		->addActionContext('create', array('html'))
		->initContext();
	}

	public function indexAction()
	{
		$this->view->assign(array(
			'page' => $this->_getParam('page'),
			'orderBy' => $this->_getParam('order-by'),
			'order' => $this->_getParam('order')
		));
	}

	public function listAction()
	{
		$dbTableProgram = new Worksample_Model_DbTable_Program();
		
		$dbSelectProgram = $dbTableProgram->select();
		
		$columns = array_combine(array('#', 'Date', 'Start time', 'Lead text', 'Name', 'B-line', 'Synopsis', 'Url'), $dbTableProgram->info('cols'));
		
		$order = strtolower($this->_getParam('order')) == 'desc' ? 'DESC' : 'ASC';
		
		$orderBy = $this->_getParam('order-by');
		
		if(!in_array($orderBy, $columns)) {
			$orderBy = current($columns);
		}
		
		$dbSelectProgram->order($orderBy . ' ' . $order);
		
		$paginator = Zend_Paginator::factory($dbSelectProgram);
		
		$pageNumber = (int) $this->_getParam('page');
		
		$paginator
		->setCurrentPageNumber($pageNumber ? $pageNumber : 1)
		->setItemCountPerPage(20);
		
		$this->view->assign(array(
			'programs' => $paginator,
			'columns' => $columns,
			'orderBy' => $orderBy,
			'order' => $order
		));
	}

	public function createAction()
	{
		$dbTableProgram = new Worksample_Model_DbTable_Program();
		
		$request = $this->getRequest();
		
		/**
	 	 * @var Zend_Form
		 */
	    $form = $this->view->form = new Worksample_Form_Program();
		
		$form->setAction($this->_helper->url('create', 'program', null, array('format' => 'html')));
		
		if($request->isPost() && $form->isValid($request->getPost())) {
			$values = $form->getValues();
			
			$dbTableProgram->insert($values);
		}
	}

	public function updateAction()
	{
		
	}

	public function deleteAction()
	{
		$dbTableProgram = new Worksample_Model_DbTable_Program();
		
		if($id = $this->_getParam('id')) {
			if($rowProgram = $dbTableProgram->find($id)->current()) {
				$rowProgram->delete();
			}
		}
	}

	public function exportAction()
	{
		$dbTableProgram = new Worksample_Model_DbTable_Program();
		
		$this->view->programs = $dbTableProgram->fetchAll()->toArray();
		
		/**
		 * @var Zend_Controller_Action_Helper_ContextSwitch
		 */
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		
		$format = strtolower($this->_getParam('format'));
		
		if($contextSwitch->hasContext($format)) {
			$date = Zend_Date::now();
		
			$dateString = $date->toString('yyyy-MM-dd_HH-mm-ss');
			
			$filename = 'export-' . $dateString . '.' . $format;
			
			$this->getResponse()->setHeader('Content-Disposition', 'attachment; filename=' . $filename);
		}
	}

}