<?php
namespace ZFlex\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class CustomForm extends Form
{
	public function __construct($name)
	{
		parent::__construct($name);
	}
}