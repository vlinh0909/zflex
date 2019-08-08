<?php 
namespace ZFlex\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Script extends AbstractHelper
{
	public function CbxToggle($name)
	{
		return "<script>function toggle(source) {checkboxes = document.getElementsByName('$name');for(var i=0, n=checkboxes.length;i<n;i++) {checkboxes[i].checked = source.checked;}}</script>";
	}
}