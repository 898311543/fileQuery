<?php
//class Autoloader
spl_autoload_register(function($className){
	$className = $className;
	//concern.
	$path = "function/{$className}.php";
	if (file_exists($path)) {
		require_once($path);
	}
	else{
		die("The file $path could not be found.");
	}
});
?>