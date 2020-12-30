<?php
    require_once( "includes/classes/FormSanitizer.php" );
    require_once( "includes/config.php" );
    require_once( "includes/classes/Account.php" );
    require_once( "includes/classes/Constants.php" );

    $account = new Account($con);

    if (isset( $_POST["submitButton"] ) ){
        $firstName = FormSanitizer::sanitizeFormString( $_POST['firstName'] );
        $lastName = FormSanitizer::sanitizeFormString( $_POST['lastName'] );
        $username = FormSanitizer::sanitizeFormUsername( $_POST['username'] );
        $email = FormSanitizer::sanitizeFormEmail( $_POST['email'] );
        $email2 = FormSanitizer::sanitizeFormEmail( $_POST['email'] );
        $password = FormSanitizer::sanitizeFormPassword( $_POST['password'] );
        $password2 = FormSanitizer::sanitizeFormPassword( $_POST['password2'] );
    
        $success = $account->register( $firstName, $lastName,  $username, $email,  $email2, $password, $password2 );

        if ($success){
            $_SESSION["userLoggedIn"] = $username;
            header("Location: index.php");
        }
    }
    
    function getInputValue( $inputValue ){
            if ( isset( $_POST[ $inputValue ] ) ){
                echo $_POST[ $inputValue ];
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
                    <h3>S'enrigestrer</h3>
                    <span>Pour creér votre compte NETFILM</span>
                </div>


                <form method="POST" action="">

                    <?php echo $account->getError( Constants::$firstNamecharacters ); ?>
                    <input type="text" name="firstName" placeholder="Prénom" value='<?php  getInputValue( "firstName" ); ?>' required>
                    
                    <?php echo $account->getError( Constants::$lastNamecharacters ); ?>
                    <input type="text" name="lastName" placeholder="Nom" value='<?php  getInputValue( "lastName" ); ?>' required >
                    
                    <?php echo $account->getError( Constants::$userNamecharacters ); ?>
                    <?php echo $account->getError( Constants::$usernameTaken ); ?>
                    <input type="text" name="username" placeholder="Username" value='<?php  getInputValue( "username" ); ?>' required >

                    <?php echo $account->getError( Constants::$emailDontMatch ); ?>
                    <?php echo $account->getError( Constants::$emailInvalid ); ?>
                    <?php echo $account->getError( Constants::$emailTaken ); ?>
                    <input type="email" name="email" placeholder="Email" value='<?php  getInputValue( "email" ); ?>' required >
                    <input type="email" name="email2" placeholder="Confirmer votre Email" value='<?php  getInputValue( "email2" ); ?>' required >
                    
                    <?php echo $account->getError( Constants::$passwordDontMatch ); ?>
                    <?php echo $account->getError( Constants::$passwordLength ); ?>
                    <?php echo $account->getError( Constants::$emailTaken ); ?>

                    <input type="password" name="password" placeholder="Mot de passe" required >
                    <input type="password" name="password2" placeholder="Mot de passe" required >
                    <input type="submit" name="submitButton" value="Envoyer" required >
                </form>

                <a href="login.php" class="signInMessage">Vous avez déja un compte ? Identifiez-vous ici !</a>
            
            </div>
        
        </div>



    </body>

</html>