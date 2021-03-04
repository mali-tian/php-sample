<?php
function sanitizePassword($inputText)
{
  $inputText = strip_tags($inputText);
  return $inputText;
}

function sanitizeFormatUsername($inputText)
{
  $inputText = strip_tags($inputText); // get rid of some html elements
  $inputText = str_replace(" ", "", $inputText); // replace all empty spaces by empty string 
  return $inputText;
}

function sanitizeFormString($inputText)
{
  $inputText = strip_tags($inputText); // get rid of some html elements
  $inputText = str_replace(" ", "", $inputText); // replace all empty spaces by empty string 
  $inputText = ucfirst(strtolower($inputText)); // capital the string 
  return $inputText;
}

if (isset($_POST['registerButton'])) {
  $username = sanitizeFormatUsername($_POST['username']);

  $firstName = sanitizeFormatUsername($_POST['firstName']);

  $lastName = sanitizeFormatUsername($_POST['lastName']);

  $email = sanitizeFormString($_POST['email']);

  $email2 = sanitizeFormString($_POST['email2']);

  $password = sanitizePassword($_POST['password']);

  $password2 = sanitizePassword($_POST['password2']);

  $wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);

  echo $wasSuccessful;
  if ($wasSuccessful == true) {
    header("location: index.php"); // redirect to index page
  }
}