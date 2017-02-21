<?php
	require 'function/functions.php';
	$a = new AddUser;
	$object = $_POST['object'];
	$object_array = json_decode($object,true);
	echo json_encode($a->createUser($object_array['userName'],$object_array['e-mail'],$object_array['phoneTel'],$object_array['password']));

?>