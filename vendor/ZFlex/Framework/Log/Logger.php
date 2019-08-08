<?php

namespace ZFlex\Framework\Log;

use Zend\Log\Writer\Stream;
use Zend\Log\Logger as ZendLogger;

class Logger extends \ZFlex\Framework\Framework
{

	const WRITE = './data/log/';

	const LOGIN_HISTORY = 'login_history.log';
	const HACKER_BUG = 'hacker_bug.log';

	public static function write($type,$message,$level)
	{		
		$writer = new Stream(self::WRITE.$type);
		$logger = new ZendLogger();
		$logger->addWriter($writer);
		$logger->log($level,$message);
	}
}