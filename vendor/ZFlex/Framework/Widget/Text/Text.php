<?php
namespace ZFlex\Framework\Widget\Text;

class Text extends \ZFlex\Framework\Framework
{
	protected $name; 
	protected $content;

	public function widgetLoad()
	{
		$this->name = $this->widgetGetValue('name');
		$this->content = $this->widgetGetValue('content');
	}

	public function widgetDetails()
	{
		return array(
			'name' => 'Text',
			'author' => 'Vũ Lĩnh',
		);
	}

	public function widgetForm()
	{
		return array(
			array(
				'name' => 'name_html',
				'type' => 'text',
				'label' => 'Name',
				'value' => $this->widgetValue('name')
			),
			array(
				'name' => 'content_html',
				'type' => 'textarea',
				'label' => 'Content',
				'value' => $this->widgetValue('content')
			)
		);
	}
}