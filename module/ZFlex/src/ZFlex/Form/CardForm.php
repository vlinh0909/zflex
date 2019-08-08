<?php
namespace ZFlex\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class CardForm extends Form
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
				'name' => 'seri',
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control'	
				),
				'options' => array(
					'label' => 'Số Serial'
				)
			)
		)
		->add(
			array(
				'name' => 'pin',
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control'	
				),
				'options' => array(
					'label' => 'Mã Thẻ Cào'
				)
			)
		)
		->add(
			array(
				'name' => 'card-type',
				'type' => 'select',
				'attributes' => array(
					'class' => 'form-control'	
				),
				'options' => array(
					'label' => 'Loại thẻ',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			),
        			'value_options' => array(
        				'' => 'Chọn loại thẻ',
        				'1' => 'Viettel',
        				'2' => 'Mobi',
        				'3' => 'Vina',
        				'4' => 'Gate'
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
				'name' => 'card-type',
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
				'name' => 'seri',
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
				'name' => 'pin',
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
	}
}