<?php 
	include_once("includes/header.php");
 ?>

 <div class="textboxConatainer">
 	<input type="text" class="searchInput" placeholder="Rechercher...">
 </div>

 <div class="results"></div>

 <script>
 	var	username ="<?php echo $userLoggedIn ;?>"
 	var timer;

 	$(".searchInput").keyup(function(){
 		clearTimeout(timer);
 		timer = setTimeout(function(){
 			var val = $(".searchInput").val();
 			if (! val == ""){
				$.post("ajax/getSearch.php" , { term : val , username: username }, function(data){
 						$(".results").html(data);
 				})
 			}
 			else{
 				$(".results").html("helloo nothing there");
 			}
 		
 		}, 2000)
 	})
 
 </script>