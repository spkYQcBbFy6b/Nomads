<?php
// Changed to PDO 2018-12-15 by Karsten Maske

// ENCRIPT PASSWORD
function password_encrypt($pass)
{
 return(md5($pass));
}
// ------------------------------------------------------------------------------------------------------------------------------
// PASSWORD CONFIRMATION
function password_validation($pass1, $pass2)
{
 if($pass1 == $pass2)
 {
  $out = TRUE;
 }
 else
 {
  $out = FALSE;
 }
 return $out;
}
// ------------------------------------------------------------------------------------------------------------------------------
// VERIFY IF PASSWORD IS GOOD
function checkPassword($pass)
{
 if (strlen($pass) < 4 OR strlen($pass) > 32)
 {
  $out = FALSE;
 }
 else
 {
  $out = TRUE;
 }
 return $out;
}
// ------------------------------------------------------------------------------------------------------------------------------
// EMAIL CONFIRMATION
function email_validation($email1, $email2)
{
 if ($email1 == $email2)
 {
  $out = TRUE;
 }
 else
 {
  $out = FALSE;
 }
 return $out;
}
// ------------------------------------------------------------------------------------------------------------------------------
// VALIDATE IF USERNAME IS GOOD
function usernameSyntax($username)
{
  $out = TRUE;

  // check special chars
  if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)){
    $out = FALSE;
  }

  // check for spaces
  if ( preg_match('/\s/',$username) )
  {
    $out = FALSE;
  }

  // count characters
  if (strlen($username) > 16 OR strlen($username) < 4)
  {
    $out = FALSE;
  }
  return $out;
}
// ------------------------------------------------------------------------------------------------------------------------------
// VALIDATE IF USERNAME IS FREE
function isUsernameFree($username)
{
 include("includes/dbConnect.php");
echo"<br><br><br><br>";
$DB->dbcheck();
 $q1="SELECT `username` FROM `user` WHERE `username`=?";
 $e1=$DB->prepare($q1);
 if(!$e1->execute(array($username)))
 {
exit("FEHLER: registration_functions: function isUsernameFree()");
 }
 
 if($e1->rowCount() > 0)
 {
  return(FALSE);
 }
 else
 {
  return(TRUE);
 }
}
// ------------------------------------------------------------------------------------------------------------------------------
// VALIDATE IF EMAIL IS TAKEN
function isEmailFree($email)
{
 include("includes/dbConnect.php");

 $q1="SELECT `email` FROM `user` WHERE `email`=?";
 $e1=$DB->prepare($q1);
 if(!$e1->execute(array($email)))
 {
exit("FEHLER: registration_functions: function isEmailFree()");
 }
 
 if($e1->rowCount() > 0)
 {
  return(FALSE);
 }
 else
 {
  return(TRUE);
 }
}
// ------------------------------------------------------------------------------------------------------------------------------
// SEND REGISTRATION EMAIL
function sendRegistrationEmail($email,$username)
{
 include("includes/dbConnect.php");

 $q1="SELECT * FROM `user_token` WHERE `token_username`=?";
 $e1=$DB->prepare($q1);
 if(!$e1->execute(array($username)))
 {
exit("FEHLER: registration_functions: function sendRegistrationEmail()");
 }
 $tokenA = $e1->fetch(PDO::FETCH_ASSOC);

 $activationLink = "http://nomads.followarmy.com/?view=activation&token=" . $tokenA['token_token'];
 $to = $email;
 $subject = "Nomads - Verify your email.";
 $message = "
   <html>
     <body>
       Welcome to Nomads ".$username.".<br>
       <br>
       Your account is ready for activation.<br>
       To activate your account and start playing please click on the link below.<br>
       <a href='".$activationLink."'>".$activationLink."</a><br>
       <br>
       If you have any questions please check our issues tab on the official GitHub and submit a request.<br>
       <a href='https://github.com/Alphabetus/Nomads'>Official Github</a><br>
       Thank you, have fun.
       <br>
       <br>
     </body>
   </html>
 ";
 $header = 'From: contact@followarmy.com' . "\r\n" .
   'Reply-To: contact@followarmy.com' . "\r\n" .
   'Content-Type: text/html; charset=ISO-8859-1' . "\r\n" .
   'X-Mailer: PHP/' . phpversion();

 if(mail($to, $subject, $message, $header))
 {
  return(TRUE);
 }
 else
 {
  return(FALSE);
 }
}
// ------------------------------------------------------------------------------------------------------------------------------
// CREATE NEW USER
function createUser($username,$email,$password)
{
 include("includes/dbConnect.php");

 $createdDate = getTime();

 $q1="INSERT INTO `user` (`username`,`email`,`password`,`createdAt`) VALUES (?,?,?,?)";
 $e1=$DB->prepare($q1);
 if(!$e1->execute(array($username,$email,$password,$createdDate)))
 {
exit("FEHLER: registration_functions: function createUser() #1");
 }

 // deal with activation token
 $token = uniqid();

 $q2="INSERT INTO `user_token` (`token_username`,`token_token`) VALUES (?,?)";
 $e2=$DB->prepare($q2);
 if($e2->execute(array($username,$token)))
 {
  return(TRUE);
 }
 else
 {
exit("FEHLER: registration_functions: function createUser() #2");
 }
}
// ------------------------------------------------------------------------------------------------------------------------------
// ACTIVATE USER AND DELETE TOKEN
function activateUser($token)
{
 include("includes/dbConnect.php");

 $q1="SELECT * FROM `user_token` WHERE `token_token`=?";
 $e1=$DB->prepare($q1);
 if(!$e1->execute(array($token)))
 {
exit("FEHLER: registration_functions: function activateUser() #1");
 }
 $tokenA=$e1->fetch(PDO::FETCH_ASSOC);
 $user = $tokenA['token_username'];

  // get user table and activate it, delete user token
 $q2="DELETE FROM `user_token` WHERE (`token_token`=?) AND (`token_username`=?)";
 $e2=$DB->prepare($q2);
 if(!$e2->execute(array($token,$user)))
 {
exit("FEHLER: registration_functions: function activateUser() #2");
 }

 $q3="UPDATE `user` SET `active`=1 WHERE `username`=?";
 $e3=$DB->prepare($q3);
 if($e3->execute(array($user)))
 {
  return(TRUE);
 }
 else
 {
exit("FEHLER: registration_functions: function activateUser() #3");
 }
}
// ------------------------------------------------------------------------------------------------------------------------------
?>