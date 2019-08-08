<?php
namespace ZFlexPL\Navigation;

use Zend\Navigation\Service\DefaultNavigationFactory;

class ZFlexPLNavigationFactory extends DefaultNavigationFactory
{
	protected function getName()
	{
		return 'zflex';
	}
}