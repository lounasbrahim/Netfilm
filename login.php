<?php
    require_once( "includes/classes/FormSanitizer.php" );
    require_once( "includes/config.php" );
    require_once( "includes/classes/Account.php" );
    require_once( "includes/classes/Constants.php" );
    $account = new Account($con);

    if( isset($_POST["submitButton"]) ){
        $username = FormSanitizer::sanitizeFormUsername( $_POST['username'] );
        $password = FormSanitizer::sanitizeFormPassword( $_POST['password'] );

        $success = $account->login( $username, $password );

        if ($success){
            $_SESSION["userLoggedIn"] = $username;
            header("Location: index.php");
        }
    }

    function getInputValue($inputValue){ 
        if ( isset( $_POST[$inputValue] ) ){
            echo $_POST[$inputValue] ;
        }
    }
?>
<!DOCTYPE html >
<html>
    <head>    
        <title>Bienvenue a NETFILM</title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css"
    </head>

    <body>
        
        <div class="signInContainer">

            <div class="column">

                <div class="header">
                    <img src="assets/images/logo.png">
                    <h3>S'identifier</h3>
                    <span>Pour continuer vers votre compte NETFILM</span>
                </div>


                <form method="POST" action="">
                
                    <?php echo $account->getError( Constants::$loginFailed ); ?>
                    <input type="text" name="username" placeholder="Username" value='<?php  getInputValue("username"); ?>' required >
                    <input type="password" name="password" placeholder="Mot de passe" required >
                    <input type="submit" name="submitButton" value="Envoyer" required >
                </form>

                <a href="register.php" class="signInMessage">Vous n'avez pas encore de compte ? Enrigestrez-vous ici !</a>
            
            </div>
        
        </div>



    </body>

</html>