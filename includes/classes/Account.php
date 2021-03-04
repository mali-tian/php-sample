<?php
class Account
{

  private $con;
  private $errorArray;
  public function __construct($con)
  {
    $this->con = $con;
    $this->errorArray = array();
  }

  public function register($username, $firstName, $lastName, $email, $email2, $password, $password2)
  {
    $this->validateUsername($username);
    $this->validateFirstname($firstName);
    $this->validateLastname($lastName);
    $this->validateEmail($email, $email2);
    $this->validatePassword($password, $password2);

    if (empty($this->errorArray) == true) {
      return $this->insertUserDetails($username, $firstName, $lastName, $email, $password);
    } else {
      return false;
    }
  }

  public function login($username, $password)
  {
    $encryptedPw = md5($password);

    echo $encryptedPw;

    $query = mysqli_query($this->con, "SELECT * FROM users where username='$username' AND password='$encryptedPw'");

    if (mysqli_num_rows($query) >= 1) {
      return true;
    } else {
      array_push($this->errorArray, Constants::$loginFail);
      return false;
    }
  }

  public function getError($error)
  {
    if (!in_array($error, $this->errorArray)) {
      $error = "";
    }

    return "<span class='errorMessage'>$error</span>";
  }

  private function insertUserDetails($username, $firstName, $lastName, $email, $password)
  {
    $encryptedPw = md5($password);
    $profilePic = "assets/images/profile-pics/head_emerald.png";
    $date = date("Y-m-d");
    $result = mysqli_query($this->con, "INSERT INTO users (username, firstName, lastName, email, password, signUpDate, profilePic) VALUES ('$username', '$firstName', '$lastName', '$email', '$encryptedPw', '$date', '$profilePic')");

    return $result;
  }

  private function validateUsername($username)
  {
    if (strlen($username) > 25 || strlen($username) < 5) {
      array_push($this->errorArray, Constants::$usernameCharacters);
      return;
    }

    $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$username'");

    if (mysqli_num_rows($checkUsernameQuery) != 0) {
      array_push($this->errorArray, Constants::$usernameTaken);
      return;
    }
  }

  private function validateFirstname($firstName)
  {
    if (strlen($firstName) > 25 || strlen($firstName) < 2) {
      array_push($this->errorArray, Constants::$firstNameCharacters);
      return;
    }
  }

  private function validateLastname($lastName)
  {
    if (strlen($lastName) > 25 || strlen($lastName) < 2) {
      array_push($this->errorArray, Constants::$lastNameCharacters);
      return;
    }
  }

  private function validateEmail($email, $email2)
  {
    if ($email != $email2) {
      array_push($this->errorArray, Constants::$emailDoNotMatch);
      return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      array_push($this->errorArray, Constants::$emailInvalid);
      return;
    }
    //TODO: check the email is not used
    $checkEmailTaken = mysqli_query($this->con,  "SELECT email FROM users WHERE email='$email'");

    if (mysqli_num_rows($checkEmailTaken) != 0) {
      array_push($this->errorArray, Constants::$emailTaken);
      return;
    }
  }

  private function validatePassword($password, $password2)
  {
    if ($password != $password2) {
      array_push($this->errorArray, Constants::$passwordsDoNotMatch);
      return;
    }

    if (preg_match('/[^A-Za-z0-9]/', $password)) {
      array_push($this->errorArray, Constants::$passwordsNotAlphanumeric);
      return;
    }

    if (strlen($password) > 23 || strlen($password) < 2) {
      array_push($this->errorArray, Constants::$passwordsCharacters);
      return;
    }
  }
}