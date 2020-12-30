<?php

    class Account{
        private $con ;
        private $errorArray = array();
        
        public function __construct( $con ){
            $this->con = $con ;
        }

        public function updateDetails($fn , $ln, $em, $un ){
            $this->validateFirstName( $fn );
            $this->validateLastName( $ln );
            $this->validateNewEmail( $em, $un );

            if (empty($this->errorArray)){
                $query = $this->con->prepare("UPDATE users SET firstName=:fn 
                    , lastName=:ln , email=:em WHERE username=:un");
                $query->bindValue(":fn" , $fn);
                $query->bindValue(":ln" , $ln);
                $query->bindValue(":em" , $em);
                $query->bindValue(":un" , $un);
                
                return $query->execute();

            }else{
               return false;
            }
        }   
            
        private function validateOldPassword($oldpw , $un){
    
           


        }

        public function updatePassword($oldpw , $newpw, $newpw2, $un ){

            $oldpw =  hash("sha512" , $oldpw);

            $query = $this->con->prepare( "SELECT * FROM users WHERE username=:un AND  password=:oldpw " );
            $query->bindValue(":oldpw" , $oldpw);
            $query->bindValue(":un" , $un);
            $query->execute();

            if ($query->rowCount() == 0){
                array_push($this->errorArray, Constants::$passwordinvalid);
            }
            
            if ( $newpw != $newpw2 ){
                array_push( $this->errorArray, Constants::$passwordDontMatch );
                return;
            }
            
            if ( strlen( $newpw ) < 5 || strlen( $newpw ) > 25 ){
                array_push( $this->errorArray , Constants::$passwordLength );
                return;
            }

            if (empty($this->errorArray)){
                $newpw = hash("sha512", $newpw);
                $query = $this->con->prepare("UPDATE users SET password=:newpw 
                    WHERE username=:un");
                $query->bindValue(":newpw" , $newpw);
                $query->bindValue(":un" , $un);

                return $query->execute();

            }else{
               return false;
            }
        }

        

        public function register( $fn , $ln, $un, $em, $em2, $pw, $pw2 ){
            $this->validateFirstName( $fn );
            $this->validateLastName( $ln );
            $this->validateuserName( $un );
            $this->validateEmails( $em, $em2  );
            $this->validatePasswords( $pw, $pw2  );

            if (empty($this->errorArray)){
                return $this->insterUserDetails( $fn , $ln, $un, $em, $pw );
            }

            return false;
        }

        public function login ( $un , $pw ){
            $pw = hash("sha512" , $pw);

            $query = $this->con->prepare( "SELECT * FROM users WHERE username=:un AND  password=:pw " );
            $query->bindValue(":pw" , $pw);
            $query->bindValue(":un" , $un);
            $query->execute();

            if ( $query->rowCount() == 0 ){
                array_push( $this->errorArray , Constants::$loginFailed );
                return false;
            }
            return true;
        }

        private function validateFirstName( $fn ){
            if ( strlen( $fn ) < 2 || strlen( $fn ) > 25 ){
                array_push( $this->errorArray , Constants::$firstNamecharacters );
            }
        }

        public function validateLastName( $ln ){
            if ( strlen( $ln ) < 2 || strlen( $ln ) > 25 ){
                array_push( $this->errorArray , Constants::$lastNamecharacters );
            }
        }

        public function validateuserName( $un ){
            
            
            if ( strlen( $un ) < 2 || strlen( $un ) > 25 ){
                array_push( $this->errorArray , Constants::$userNamecharacters );
                return;
            }

            $query = $this->con->prepare( "SELECT * FROM users WHERE username=:un " );
            $query->bindValue(":un" , $un);

            $query->execute();

            if ( $query->rowCount() != 0 ){
                array_push( $this->errorArray , Constants::$usernameTaken );
            }
        }
         
        public function validateNewEmail( $em, $un ){
             if ( ! filter_var( $em, FILTER_VALIDATE_EMAIL ) ){
                array_push( $this->errorArray, Constants::$emailInvalid );
                return;
            } 
            $query = $this->con->prepare( "SELECT * FROM users WHERE email=:em and username != :un " );
            $query->bindValue( ":em" , $em );
            $query->bindValue( ":un" , $un );

            $query->execute();

            if ( $query->rowCount() != 0 ){
                array_push( $this->errorArray , Constants::$emailTaken );
            }
        
        }

        public function validateEmails( $em, $em2 ){
            if ( $em != $em2 ){
                array_push( $this->errorArray, Constants::$emailDontMatch );
                return;
            }

            if ( ! filter_var( $em, FILTER_VALIDATE_EMAIL ) ){
                array_push( $this->errorArray, Constants::$emailInvalid );
                return;
            } 
         
            $query = $this->con->prepare( "SELECT * FROM users WHERE email=:em " );
            $query->bindValue( ":em" , $em );

            $query->execute();

            if ( $query->rowCount() != 0 ){
                array_push( $this->errorArray , Constants::$emailTaken );
            }
        }



        private function validatePasswords( $pw, $pw2 ){
            if ( $pw != $pw2 ){
                array_push( $this->errorArray, Constants::$passwordDontMatch );
                return;
            }
            
            if ( strlen( $pw ) < 5 || strlen( $pw ) > 25 ){
                array_push( $this->errorArray , Constants::$passwordLength );
                return;
            }
        }

        private function insterUserDetails( $fn , $ln, $un, $em, $pw ){
            $pw = hash("sha512" , $pw); 
            $query = $this->con->prepare( "INSERT INTO users ( firstName, lastName, username, email, password ) VALUES ( :fn , :ln, :un, :em, :pw )	");
            $query->bindValue(":fn", $fn );
            $query->bindValue(":ln", $ln );
            $query->bindValue(":un", $un );
            $query->bindValue(":em", $em );
            $query->bindValue(":pw", $pw );
            return $query->execute();
        }

        public function getError( $error ){
            if (in_array( $error , $this->errorArray )){
                return "<span class='errorMessage'> $error </span>" ; 
            }
        }

        public function getFirstError(){
            if (! empty($this->errorArray)){
                return $this->errorArray[0];
            }
        }

             
    
    }

?>