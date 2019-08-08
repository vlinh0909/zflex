<?php 
namespace ZFlex\Framework\Plugin;

use ZFlex\Framework\Framework;

class Plugin extends Framework
{

	public function getPlugins()
	{
		$sm = $this->getServiceLocator();
		$dir = $sm->get('config')['location_plugins'];
    	$plugins = array();
    	$files = scandir($dir);
    	if(is_dir($dir)){
	    	foreach($files as $file)
	    	{
	    		if (strpos($file, '.') === false) {
	    			if(!empty($this->checkCommentPlugin($file)))
	    			{
	    				$plugins[] = $file;
	    			}
				}
	    	}
    	}
    	return $plugins;
	}

	public function checkCommentPlugin($file)
	{
		$sm = $this->getServiceLocator();
		$dir = $sm->get('config')['location_plugins'];
	   	$_dir = $dir.$file;
	    if ($dh = opendir($_dir)){
	    	$tokens =  @token_get_all(@file_get_contents($_dir."/".$file.".php"));
	    	$_comments = array();
			foreach($tokens as $token) {
			    if($token[0] == T_COMMENT || $token[0] == T_DOC_COMMENT) {
			        $_comments[] = $token[1];
			    }
			}
			if(!empty($_comments)) $comment =  $_comments[0];
			closedir($dh);
		}
		if(!empty($comment))
		{
			return $comment;
		}
	}

	public function getCommentPlugin($file)
	{
		$comments = $this->checkCommentPlugin($file);
		if(!empty($comments))
		{
			
				$array_comments = explode("\n", $comments);

				array_shift($array_comments);
		    	array_pop($array_comments);

		    	foreach($array_comments as $comment)
		    	{
		    		$_comment = explode(": ", $comment);
		    		$str = $_comment[1];
		    		$arr[$_comment[0]] =  $str;
		    		
		    	}
		    	$array = array();
		    	$array[] = [
		    		'Plugin Name' => (!empty($arr['Plugin Name'])) ? $arr['Plugin Name'] : '',
		    		'Plugin URI' => (!empty($arr['Plugin URI'])) ? $arr['Plugin URI'] : '',
		    		'Description' => (!empty($arr['Description'])) ? $arr['Description'] : '',
		    		'Version' => (!empty($arr['Version'])) ? $arr['Version'] : '',
		    		'Author' => (!empty($arr['Author'])) ? $arr['Author'] : '',
		    		'Author URI' => (!empty($arr['Author URI'])) ? $arr['Author URI'] : '',
		    	];
	    	return $array;
		}

    	
	}

}