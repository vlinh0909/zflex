<?php
namespace ZFlex\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class MemberForm extends Form{


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
				'name' => 'email',
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control'	
				),
				'options' => array(
					'label' => 'Email',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			),
        			'exclude' => true,
				)
			)
		)
		->add(
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
        			'exclude' => true
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
				'name' => 'fullname',
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control'	
				),
				'options' => array(
					'label' => 'Fullname',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			),
				)
			)
		)
		->add(
			array(
				'name' => 'permission',
				'type' => 'select',
				'attributes' => array(
					'class' => 'form-control'	
				),
				'options' => array(
					'label' => 'Permission',
					'label_attributes' => array(
          			  	'class' => 'box-left-title',
        			)
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
				'name' => 'email',
				'required' => true,
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')	
				),
				'validators' => array(
					array('name' => 'NotEmpty'),
					array('name' => 'EmailAddress'),
					\ZFlex\Framework\Validator::NoRecordExists('members','email')
				)
			)
		);
		$input->add(
			array(
				'name' => 'username',
				'required' => true,
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				),
				'validators' => array(
					array('name' => 'NotEmpty'),
					array(
						'name' => 'StringLength',
						'options' => array(
							'min' => '5',
							'max' => '20'	
						)
					),
					\ZFlex\Framework\Validator::NoRecordExists('members','username')
				)
			)
		);
		$input->add(
			array(
				'name' => 'password',
				'required' => true,
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')	
				),
				'validators' => array(
					array('name' => 'NotEmpty'),
					array(
						'name' => 'StringLength',
						'options' => array(
							'min' => '5',
							'max' => '20'	
						)
					)
				)
			)
		);
		$input->add(
			array(
				'name' => 'fullname',
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
				'name' => 'image',
				'required' => true,
				'validators' => array(
					array('name' => 'NotEmpty')
				)
			)
		);
	}
}