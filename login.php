<?php
	require 'function/functions.php';
	$a = new Verify;
	$object = $_POST['object'];
	$object_array = json_decode($object,true);
	$result = $a->verifyUser($object_array['username'],$object_array['password']);
	echo json_encode($result);
	?>