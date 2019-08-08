<?php
namespace ZFlex\Framework;

use Exception;

class Gallery extends Framework
{

	protected $elements = array();
	protected $folder_path;
	protected $current_path = '';

	public function __construct()
	{
		@session_start();
		if(!isset($_SESSION['media_current_path']))
		{
			$_SESSION['media_current_path'] = '';
		}
	}

	public function countItemInFolder($dir)
	{
		if (is_dir($dir)) 
	     { 
	        $number = count(scandir($dir)) - 2;
	     } 
		return $number;
	}

	public function search($key)
	{

	}

	public function setFolderPath($folder_path)
	{
		$this->folder_path = $folder_path;
	}

	public function getFolderPath()
	{
		$this->folder_path;
		if(!$this->folder_path)
		{
			// Service Locator | Zend 2
			$sm = $this->getServiceLocator();
			$path = $sm->get('config')['upload_location_img'];
			/*
			$path = //code
			*/
			$this->setFolderPath($path);
		}
		return $this->folder_path;
	}

	public function getFullDir()
	{
		$this->setCurrentPath($_SESSION['media_current_path']);
		return $this->getFolderPath().$this->getCurrentPath();
	}

	public function createFolder($name_folder)
	{
		$new_folder = $this->getFullDir().$name_folder;
		if (!is_dir($new_folder)) {
		    mkdir($new_folder, 0777, true);
		}
	}

	public function rename($old_name,$new_name)
	{
		$dir_old_name = $this->getFullDir().$old_name;
		$dir_new_name = $this->getFullDir().$new_name;
		if(is_dir($dir_old_name) || file_exists($dir_old_name))
		{
			rename($dir_old_name,$dir_new_name);
		}
	}

	public function delete($dir)
	{
		if (is_dir($dir)) {
	        $scn = scandir($dir);
	        foreach ($scn as $files) {
	            if ($files !== '.') {
	                if ($files !== '..') {
	                    if (!is_dir($dir . '/' . $files)) {
	                        unlink($dir . '/' . $files);
	                    } else {
	                        rmdir($dir . '/' . $files);
	                    }
	                }
	            }
	        }
	    }
	}

	public function deleteFolder($folder_name)
	{
		$dir = $this->getFullDir().$folder_name;
		if (is_dir($dir)) {
	        $scn = scandir($dir);
	        foreach ($scn as $files) {
	            if ($files !== '.') {
	                if ($files !== '..') {
	                    if (!is_dir($dir . '/' . $files)) {
	                        unlink($dir . '/' . $files);
	                    } else {
	                       	$this->delete($dir . '/' . $files);
	                        rmdir($dir . '/' . $files);
	                    }
	                }
	            }
	        }
	    }
	    return rmdir($dir);
	}

	public function getBackPath($current_path)
	{
		if($current_path !== ''):
            $arr = explode('/',$current_path);
            foreach($arr as $k => $v)
            {
                if(!$v)
                {
                    unset($arr[$k]);
                }
            }
            $str = '';
            $count = count($arr);
            if($count == 1)
            {
                $str = '';
            }
            else
            {
                $key_number = $count - 2;
                for($i = 0;$i <= $key_number;$i++)
                {
                    $str .= $arr[$i].'/';
                }
                
            }
            return $str;
        else:
        	throw new Exception('Current Path is not set !');
			die;
        endif;
	}

	public function setCurrentPath($path)
	{
		$this->current_path = $path;
		$_SESSION['media_current_path'] = $path;
	}

	public function getCurrentPath()
	{
		if($this->current_path === null)
		{
			$this->setCurrentPath($_SESSION['media_current_path']);
		}
		return $this->current_path;
	}

	public function setElementsArray($dir) { 

	   	$result = array(); 

	   	$cdir = scandir($dir); 
	   	foreach ($cdir as $key => $value) 
	   	{ 
	      if (!in_array($value,array(".",".."))) 
	      { 
	         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
	         { 
	            $result['folder.con'][] = $value;
	         } 
	         else 
	         { 
	            $result[] = $value; 
	         } 
	      } 
	   	} 
	   $this->elements = $result;
	} 

	public function getElementsArray()
	{
		$dir = $this->getFolderPath().$this->getCurrentPath().'\\';
		if(!is_dir($dir))
		{
			throw new Exception("DIRECTORY NOT CORRECT");
			die;
		}
		$elements = array();
		if(!$this->elements)
		{
			$this->setElementsArray($dir);
		}
		// Folder
		if(isset($this->elements['folder.con']))
		{
			$folders = $this->elements['folder.con'];
			foreach($folders as $key => $value)
			{
				$elements['folder.con'][] = array(
					'name' => $value,
					'items' => $this->countItemInFolder($dir.$value)
				);
			}
		}
		foreach($this->elements as $key => $value)
		{
			if($key !== "folder.con")
			{
				$elements[] = array(
					'name' => basename($dir.$value),
					'size' => filesize($dir.$value) / 1024, // KB
					'mime' => getimagesize($dir.$value)['mime'],
					'time' => date('h:i:s d/m/Y',filemtime($dir.$value))
				); 
			}
		}
		return $elements;
	}
}