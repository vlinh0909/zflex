<?php
namespace ZFlex\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class MediaForm extends Form{


	public function __construct($name)
	{
		parent::__construct($name);
		$this->addElements();
		$this->addInputFilter();
		$this->setAttribute('class', 'formMedia');
	}

	public function addElements()
	{
		$this->add(
			array(
				'name' => 'image',
				'type' => 'file',
				'attributes' => array(
					'class' => 'form-control-file imageMedia',
					'multiple' => 'multiple',
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
				'name' => 'image',
				'required' => true,
				'validators' => array(
					array('name' => 'File\IsImage'),
				)
			)
		);
	}
}