<?php
namespace ZFlex\Framework\Extensions;

class ExtensionsRegistrar
{
	const MODULE = 'module';

	public function register($type, $extensionName , $path)
	{
		if($type == self::MODULE)
		{
			return "ok";
		}
	}
}