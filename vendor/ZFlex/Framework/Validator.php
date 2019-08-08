<?php
namespace ZFlex\Framework;

class Validator
{
	public static function NoRecordExists($db_name,$field)
	{
		return array(
			'name' => 'Db\NoRecordExists',
			'options' => array(
				'table' => ZFLEX_DB_PREFIX.$db_name,
		        'field' => $field,
		        'adapter' => new \Zend\Db\Adapter\Adapter(
		        	array(
				    'driver' => 'Mysqli',
				    'database' => DBNAME,
				    'username' => USER,
				    'password' => PASS
					)
				)
			)
		);
	}

	public static function NoRecordExistsEdit($form,$name,$id)
	{
		if(is_array($name)):
			foreach($name as $_name):
			$key =(Int) count($form->getInputFilter()->get($_name)->getValidatorChain()->getValidators()) - 1;
			$form->getInputFilter()->get($_name)->getValidatorChain()->getValidators()[$key]['instance']->setExclude('id != ' . $id);
			endforeach;
		else:
			$key =(Int) count($form->getInputFilter()->get($name)->getValidatorChain()->getValidators()) - 1;
			$form->getInputFilter()->get($name)->getValidatorChain()->getValidators()[$key]['instance']->setExclude('id != ' . $id);
		endif;
	}
}