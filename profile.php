<?php 
	require_once("includes/header.php");
	require_once("includes/classes/Account.php");
	require_once("includes/classes/FormSanitizer.php");
	require_once("includes/classes/Constants.php");

	$detailsMessage = "";
	$passwordMessage="";

 
	if (isset($_POST["saveDetailsButton"])){

		$account = new Account($con); 
		
		$fristName = FormSanitizer::sanitizeFormString($_POST['fristName']);
		$lastName = FormSanitizer::sanitizeFormString($_POST['lastName']);
		$email = FormSanitizer::sanitizeFormEmail($_POST['email']);

		if ($account->updateDetails($fristName, $lastName, $email, $userLoggedIn)){
			 $detailsMessage = "<div class='alertSuccess'>
                            Vos Cordnées sont mis A jour
                </div>";
		}
		else{
			$errorMessage = $account->getFirstError();

			$detailsMessage = "<div class='alertError'>
								$errorMessage	
							</div>";
		}
	}

	if (isset($_POST["savePasswordButton"])){

		$account = new Account($con); 
		
		$oldPassword = FormSanitizer::sanitizeFormPassword($_POST['oldPassword']);
		$newPassword = FormSanitizer::sanitizeFormPassword($_POST['newPassword']);
		$newPassword2 = FormSanitizer::sanitizeFormPassword($_POST['newPassword2']);

		if ($account->updatePassword($oldPassword, $newPassword, $newPassword2, $userLoggedIn)){
			 $passwordMessage = "<div class='alertSuccess'>
                            Vos Cordnées sont mis A jour
                </div>";
		}
		else{
			$errorMessage = $account->getFirstError();

			$passwordMessage = "<div class='alertError'>
								$errorMessage	
							</div>";
		}
	}

?>


<div class="settingsContainer column">

	<div class="formSection">
		<form  method="POST">
			<h2>Détails Utilisateur</h2>
			
			<?php $user = new User($con, $userLoggedIn);   
			$fristName =  isset($_POST["fristName"]) ? $_POST["fristName"] : $user->getFirstName() ;
			$lastName =  isset($_POST["lastName"]) ? $_POST["lastName"] : $user->getFirstName();
			$email = isset($_POST["email"]) ? $_POST["email"] : $user->getFirstName();

			?>

			<input type="text" name="fristName" placeholder="Prénom" value="<?php echo $fristName;?>">
			<input type="text" name="lastName" placeholder="Nom" value="<?php echo $lastName;?>">
			<input type="email" name="email" placeholder="Email" value="<?php echo $email;?>">

			<div class="Message">
				<?php echo $detailsMessage;?>

			</div>

			<input type="submit" name="saveDetailsButton" value="Enregistrer">
		</form>	
	</div>

	<div class="formSection">
		<form  method="POST">	
			<h2>Changer de Mot de passe</h2>
			<input type="password" name="oldPassword" placeholder="Ancien Mot de passe">
			<input type="password" name="newPassword" placeholder="Nouveau Mot de passe">
			<input type="password" name="newPassword2" placeholder="Confirmer le Mot de pass">
			
			<div class="Message">
				<?php echo $passwordMessage;?>

			</div>

			<input type="submit" name="savePasswordButton" value="Enregistrer">
		</form>
	</div>


</div>