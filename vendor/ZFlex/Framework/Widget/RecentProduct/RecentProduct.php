<?php
namespace ZFlex\Framework\Widget\RecentProduct;

class RecentProduct extends \ZFlex\Framework\Framework
{
	protected $number; 

	public function widgetLoad()
	{
		$this->number = $this->widgetGetValue(null);
	}

	public function widgetDetails()
	{
		return array(
			'name' => 'Recent Product',
			'author' => 'Vũ Lĩnh'
		);
	}

	public function widgetForm()
	{
		return array(
			array(
				'name' => 'number_display',
				'type' => 'number',
				'label' => 'Number',
				'value' => $this->widgetValue('number')
			)
		);
	}

	
}