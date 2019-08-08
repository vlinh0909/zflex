<?php
namespace ZFlex\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class CategoryForm extends Form
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
		)->add(
			array(
				'name' => 'image',
				'type' => 'hidden',
				'attributes' => array(
					'class' => 'image-media'
				),
				'options' => array(
					'label' => 'Avatar',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			)
				)
			)
		)
		->add(
			array(
				'name' => 'order_by',
				'type' => 'number',
				'attributes' => array(
					'class' => 'form-control',
					'value' => 0
				),
				'options' => array(
					'label' => 'Order By',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			)
				)
			)
		)
		->add(
			array(
				'name' => 'name',
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control slug-js'	
				),
				'options' => array(
					'label' => 'Label',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			),
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
				'name' => 'code',
				'required' => true,
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')	
				),
				'validators' => array(
					array('name' => 'NotEmpty'),
					\ZFlex\Framework\Validator::NoRecordExists('categories','code')
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
					\ZFlex\Framework\Validator::NoRecordExists('categories','name')
				)
			)
		);
	}
}