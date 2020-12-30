<?php
	require_once("includes/header.php");

	if (! $_GET["id"]){
		ErrorMessage::show("Pas de ID dans la page");
	}

	$id = $_GET["id"];

	$previewProvider = new PreviewProvider($con, $userLoggedIn);
	echo $previewProvider->createCategoyPreviewVideo($id);

	$categoryContainers = new CategoryContainers($con, $userLoggedIn);
	echo $categoryContainers->showCategory($id);

	

?>
