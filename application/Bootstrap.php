<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initViewHelpers() {
		/**
		 * @var Zend_View
		 */
		$view = $this->bootstrap('view')->getResource('view');
		
		/**
		 * @var Zend_View_Helper_HeadMeta
		 */
		$headMeta = $view->getHelper('HeadMeta');
		
		/**
		 * @var Zend_View_Helper_HeadLink
		 */
		$headLink = $view->getHelper('HeadLink');
		
		/**
		 * @var Zend_View_Helper_HeadScript
		 */
		$headScript = $view->getHelper('HeadScript');
		
		/**
		 * @var Zend_View_Helper_FormErrors
		 */
		$formErrors = $view->getHelper('FormErrors');
		
		$headMeta
		->appendHttpEquiv('X-UA-Compatible', 'IE=edge,chrome=1')
		->appendName('viewport', 'width=device-width, initial-scale=1.0');
		
		$headLink
		->appendStylesheet('/css/bootstrap' . ($this->getEnvironment() == 'production' ? '.min' : '') . '.css', false)
		->appendStylesheet('/css/bootstrap-responsive' . ($this->getEnvironment() == 'production' ? '.min' : '') . '.css', false)
		->appendStylesheet('/css/layout.css', false);
		
		$headScript
		->appendFile('/js/modernizr.min.js');
		
		$formErrors
		->setElementStart('<div%s><a class="close" href="#" data-dismiss="alert">×</a><ul class="unstyled"><li>')
		->setElementEnd('</li></ul></div>');
		
		/**
		 * @var Zend_Controller_Action_Helper_ViewRenderer 
		 */
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		
		$viewRenderer->setView($view);
		
		/**
		 * @var Zend_Controller_Action_Helper_ContextSwitch
		 */
		$contextSwitch = Zend_Controller_Action_HelperBroker::getStaticHelper('ContextSwitch');
		
		$contextSwitch->addContext('csv', array(
			'suffix'    => 'csv',
			'headers'   => array('Content-Type' => 'text/csv')
		));
		
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator.phtml');
		
		return $view;
	}
	
	protected function _initResourceLoader() {
		$this->getResourceLoader()->addResourceTypes(array(
			'validate' => array(
				'namespace' => 'Validate',
				'path' => 'validators'
			),
			'filter' => array(
				'namespace' => 'Filter',
				'path' => 'filters'
			)
		));
	}
}