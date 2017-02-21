<?php

$path = "static/";
require 'function/functions.php';
$object = $_POST['object'];
$object_array = json_decode($object,true);
$token = $object_array['token'];
$a = new Token_verify;
if(!($a->verify_token($token))){
	die();
}
$dir_iterator = new RecursiveDirectoryIterator($path);
$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
$num = 0;
$return_data = array();
$fileList = array();
foreach ($iterator as $v) {
	$each_one = array();
	$each_one['flieName'] = $v->getBasename();
	$each_one['filesize'] =  $v -> getSize();
	$each_one['url'] = "http://".$_SERVER['HTTP_HOST']."/".$path.($v->getBasename());
	$num ++;
	$fileList[] = $each_one;
}
$return_data["fileCount"] = $num;
$return_data['fileList'] = $fileList;
echo json_encode($return_data);

	?>