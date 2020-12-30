<?php 
    require_once("includes/header.php") ;

    $preview = new PreviewProvider($con, $userLoggedIn);
    echo $preview->createTvshowPreviewVideo(null);

    $cotagorycontainer = new CategoryContainers($con , $userLoggedIn);
    echo $cotagorycontainer->showTVShowCategories()
?>


 

</div>
</body>
</html> 