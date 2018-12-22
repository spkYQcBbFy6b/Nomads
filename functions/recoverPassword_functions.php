<?php
// Changed to PDO 2018-12-15 by Karsten Maske

// RECOVER PASSWORD ENGINE
function recoverUserPassword($email)
{
 include "functions/registration_functions.php";
 include("includes/dbConnect.php");

 $q1="SELECT `password`,`email`,`active`,`username` FROM `user` WHERE (`email`=?) AND (`active`=?)";
 $e1=$DB->prepare($q1);
 if(!$e1->execute(array($email,1)))
 {
exit("FEHLER: recoverPassword_functions: function recoverUserPassword() #1");
 }

 if ($e1->rowCount() < 1)
 {
  return(FALSE);
 }

 $z1=$e1->fetch(PDO::FETCH_ASSOC);
 $username = $z1['username'];

 // VALIDATIONS MUST BE ABOVE THIS LINE

 // generate new password
 $genPass = genPassword();
 $encryptedPass = password_encrypt($genPass);

 // write new password
 $q2="UPDATE `user` SET `password`=? WHERE `email`=?";
 $e2=$DB->prepare($q2);
 if(!$e2->execute(array($encryptedPass,$email)))
 {
exit("FEHLER: recoverPassword_functions: function recoverUserPassword() #2");
 }

 // send email with new password
 $to = $email;
 $subject = "Nomads - Password reset.";
 $message = "
   <html>
     <body>
       Hello ".$username.".<br>
       <br>
       Your password has been reseted upon your request.<br>
       Your new password is: <b>".$genPass."</b>.<br>
       You can now login using your regular username.<br>
       <br>
       <b>Please be aware that this password was randomly generated, however you should change it as soon as possible.</b><br>
       <br>
       If you have any questions please reach us by email at:<br>
       <a href='mailto:contact@followarmy.com'>contact@followarmy.com</a><br>
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
// GENERATE NEW PASSWORD
function genPassword(){
  $salt1 = rand(0,9);
  $salt2 = rand(0,9);
  $salt3 = rand(0,9);
  $salt4 = rand(0,9);
  $salt5 = rand(0,9);
  $salt6 = rand(0,9);
  $newPass = $salt1 . $salt2 . $salt3 . $salt4 . $salt5 . $salt6;
  $out = $newPass;
  return $out;
}
?>