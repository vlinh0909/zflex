<?php
namespace ZFlex\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class RentForm extends Form
{
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
				'name' => 'username',
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control'	
				),
				'options' => array(
					'label' => 'Username',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			),
				)
			)
		)
		->add(
			array(
				'name' => 'password',
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control'	
				),
				'options' => array(
					'label' => 'Password',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			),
				)
			)
		)
		->add(
			array(
				'name' => 'category',
				'type' => 'select',
				'attributes' => array(
					'class' => 'form-control'	
				),
				'options' => array(
					'label' => 'Category',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			),
				)
			)
		)
		->add(
			array(
				'name' => 'description',
				'type' => 'textarea',
				'attributes' => array(
					'class' => 'form-control',
					'rows' => 5
				),
				'options' => array(
					'label' => 'Description',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			),
				)
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
		)
		->add(
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
				'name' => 'category',
				'required' => true,
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')	
				),
				'validators' => array(
					array('name' => 'NotEmpty')
				)
			)
		);
		$input->add(
			array(
				'name' => 'username',
				'required' => true,
				'required' => true,
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')	
				),
				'validators' => array(
					array('name' => 'NotEmpty')
				)
			)
		);
		$input->add(
			array(
				'name' => 'password',
				'required' => true,
				'required' => true,
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')	
				),
				'validators' => array(
					array('name' => 'NotEmpty')
				)
			)
		);
		$input->add(
			array(
				'name' => 'description',
				'required' => false,
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')	
				)
			)
		);
	}
}