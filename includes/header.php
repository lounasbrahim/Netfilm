<?php   
    require_once("includes/config.php");
    require_once("includes/classes/PreviewProvider.php");
    require_once("includes/classes/Entity.php");
    require_once("includes/classes/CategoryContainers.php");
    require_once("includes/classes/EntityProvider.php");
    require_once("includes/classes/VideoProvider.php");
    require_once("includes/classes/ErrorMessage.php");
    require_once("includes/classes/SeasonProvider.php");
    require_once("includes/classes/Video.php");
    require_once("includes/classes/Season.php");
    require_once("includes/classes/User.php");



    if ( ! isset( $_SESSION["userLoggedIn"] ) ){
        header("Location: register.php"); 
    }       
    $userLoggedIn = $_SESSION["userLoggedIn"] ;
?>

<!DOCTYPE html> 
<html>
<head>
	<title>Beivenus a NETFILM</title>
    <link rel="stylesheet" href="assets/style/style.css">
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://kit.fontawesome.com/dd25ff0fb6.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <div class="wrapper">


<?php 
if (! isset( $hideNav )){
    include_once("includes/navBar.php");
}

 ?>