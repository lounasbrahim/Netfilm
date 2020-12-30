<?php 
    require_once("includes/header.php") ;

    $preview = new PreviewProvider($con, $userLoggedIn);
    echo $preview->createPreveiwVideo(null);

    $cotagorycontainer = new CategoryContainers($con , $userLoggedIn);
    echo $cotagorycontainer->showAllCategories()
?>


 

</div>
</body>
</html> 