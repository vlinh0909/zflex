<?php
namespace ZFlex\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class RoleForm extends Form
{
	public function __construct($name)
	{
		parent::__construct($name);
		$this->addElements();
	}

	public function addElements()
	{
		$this->add(
			array(
				'name' => 'name',
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control slug-js'	
				),
				'options' => array(
					'label' => 'Name',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			)
				)
			)
		)
		->add(
			array(
				'name' => 'slug',
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control slug-js-convert'	
				),
				'options' => array(
					'label' => 'Slug',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			)
				)
			)
		)->add(
			array(
			    'type' => 'csrf',
			    'name' => 'csrf',
			    'options' => array(
		            'csrf_options' => array(
		                'timeout' => 600
		            )
		     	)
		 	)
		);
	}

	public function addInputFilter()
	{
		$input = new InputFilter;
		$this->setInputFilter($input);
		$input->add(
			array(
				'name' => 'csrf',
				'required' => true,
				'validators' => array(
					array('name' => 'Csrf')
				)
			)
		);
		$input->add(
			array(
				'name' => 'name',
				'required' => true, 
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				),
				'validators' => array(
					array('name' => 'NotEmpty'),
					\ZFlex\Framework\Validator::NoRecordExists('roles','name')
				)
			)
		);	
		$input->add(
			array(
				'name' => 'slug',
				'required' => true, 
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				),
				'validators' => array(
					array('name' => 'NotEmpty'),
					\ZFlex\Framework\Validator::NoRecordExists('roles','slug')
				)
			)
		);	
	}
}