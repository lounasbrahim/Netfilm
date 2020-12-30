<?php 
    require_once("includes/header.php") ;

    $preview = new PreviewProvider($con, $userLoggedIn);
    echo $preview->createMoviesPreviewVideo(null);

    $cotagorycontainer = new CategoryContainers($con , $userLoggedIn);
    echo $cotagorycontainer->showMoviesCategories()
?>


 

</div>
</body>
</html> 