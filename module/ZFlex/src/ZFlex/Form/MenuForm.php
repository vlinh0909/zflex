<?php
namespace ZFlex\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class MenuForm extends Form{


	public function __construct($name)
	{
		parent::__construct($name);
		$this->addElements();
		$this->addInputFilter();
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
        			),
				)
			)
		)
		->add(
			array(
				'name' => 'code',
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control slug-js-convert'	
				),
				'options' => array(
					'label' => 'Code',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			),
				)
			)
		)
		->add(
			array(
				'name' => 'data',
				'type' => 'textarea',
				'attributes' => array(
					'id' => 'nestable-output',
					'cols' => '100',
					'rows' => '15',
					'class' => 'hidden'
				),
			)
		)
		->add(
			array(
				'name' => 'status',
				'type' => 'select',
				'attributes' => array(
					'class' => 'form-control'	
				),
				'options' => array(
					'label' => 'Status',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			),
        			'value_options' => array(
        				'1' => 'Kích hoạt',
        				'0' => 'Vô hiệu hóa'	
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
					\ZFlex\Framework\Validator::NoRecordExists('menus','name')
				)
			)
		);
		$input->add(
			array(
				'name' => 'code',
				'required' => true,
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				),
				'validators' => array(
					array('name' => 'NotEmpty'),
					\ZFlex\Framework\Validator::NoRecordExists('menus','code')
				)
			)
		);
		$input->add(
			array(
				'name' => 'data',
				'required' => true,
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				),
				'validators' => array(
					array('name' => 'NotEmpty'),
				)
			)
		);
	}
}