<?php 
	require_once("includes/header.php");


 	if (! isset($_GET['id'])) {
 		ErrorMessage::show ("Pas de ID dans l'url");
 	}
  	
  	$entityId = $_GET["id"];
  	$entity = new Entity($con , $entityId);
  	$entityName = $entity->getName();
  	$entityThumbnail = $entity->getThumbnail();
  	$entityPreview = $entity->getPreview();



 	  $preview = new PreviewProvider($con, $userLoggedIn);
    echo $preview->createPreveiwVideo($entity);

    $seasonProvider = new SeasonProvider($con, $userLoggedIn);
    echo $seasonProvider->create($entity);

   $categoryContainers = new CategoryContainers($con, $userLoggedIn);
    echo $categoryContainers->showCategory($entity->getCategoryId() , "Vous pourriez aussi aimer " );
    
 ?>