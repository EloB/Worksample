<?php
class Worksample_Form_Program extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		
		$this->setAttrib('class', 'form-horizontal');
		
		$elementDate = new Zend_Form_Element_Text('date', array(
			'label' => _('Enter a date'),
			'placeholder' => 'yyyy-mm-dd',
			'required' => true,
			'validators' => array(
				new Zend_Validate_Date()
			)
		));
		
		$elementStartTime = new Zend_Form_Element_Text('start_time', array(
			'label' => _('Enter a start-time'),
			'placeholder' => 'hh:mm',
			'description' => _(''),
			'required' => true,
			'validators' => array(
				new Worksample_Validate_Time()
			)
		));
		
		$elementLeadText = new Zend_Form_Element_Textarea('leadtext', array(
			'label' => _('Enter a lead text'),
			'rows' => 2,
			'required' => true
		));
		
		$elementName = new Zend_Form_Element_Text('name', array(
			'label' => _('Enter a name'),
			'required' => true
		));
		
		$elementBline = new Zend_Form_Element_Text('b_line', array(
			'label' => _('Enter a b-line'),
			'required' => true
		));
		
		$elementSynopsis = new Zend_Form_Element_Textarea('synopsis', array(
			'label' => _('Enter a synopsis'),
			'rows' => 2,
			'required' => true
		));
		
		$elementUrl = new Zend_Form_Element_Text('url', array(
			'label' => _('Enter a url'),
			'required' => true,
			'validators' => array(
				new Worksample_Validate_Url()
			)
		));
		
		$elementReset = new Zend_Form_Element_Reset('reset', array(
			'label' => _('Cancel'),
			'class' => 'btn btn-large'
		));
		
		$elementSubmit = new Zend_Form_Element_Submit('submit', array(
			'label' => _('Save'),
			'class' => 'btn btn-large btn-primary'
		));
		
		$this->setElements(array(
			$elementDate,
			$elementStartTime,
			$elementLeadText,
			$elementName,
			$elementBline,
			$elementSynopsis,
			$elementUrl
		));
		
		$this->setDecorators(array(
			'FormElements',
			'HtmlTag',
			'Form'
		));
		
		$this->setElementDecorators(array(
			'ViewHelper',
			array('Description', array('class' => 'help-block')),
			array('Errors', array('class' => 'alert alert-error help-block')),
			array(array('InputWrap' => 'HtmlTag'), array('class' => 'controls')),
			array('Label', array('class' => 'control-label')),
			array(array('AllWrap' => 'HtmlTag'), array('class' => 'control-group'))
		));
	}
}