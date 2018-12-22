<?php
// Changed to PDO 2018-12-15 by Karsten Maske

// CHANGE PASSWORD ACTION
function changePassword($oldPass,$newPass,$newPass2)
{
 include("includes/dbConnect.php");

 include "functions/registration_functions.php";

 $id = getUserID();
 $oldPass = password_encrypt($oldPass);
 $out=FALSE;

 // validate password length
 if(!checkPassword($newPass))
 {
  return(FALSE);
 }

 // validate new passwords match
 if(!password_validation($newPass,$newPass2))
 {
  return(FALSE);
 }

 // validate old password
 $q1="SELECT `id`,`password` FROM `user` WHERE (`id`=?) AND (`password`=?)";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($id,$oldPass)))
 {
  if($e1->rowCount()<1)
  {
   return(FALSE);
  }

  // change passwords
  $newPass = password_encrypt($newPass);
  $q2="UPDATE `user` SET `password`=? WHERE `id`=?";
  $e2=$DB->prepare($q2);
  if($e2->execute(array($newPass,$id)))
  {
   return(TRUE);
  }
  else
  {
exit("FEHLER: accountSettings_functions: function changePassword() #2");
  }
 }
 else
 {
exit("FEHLER: accountSettings_functions: function changePassword() #1");
 }
}
// ---------------------------------------------------------------------------------------------------------
// CHANGE EMAIL ACTION
function changeUserEmail($newMail)
{
 include("includes/dbConnect.php");
 include "functions/registration_functions.php";
 $id = getUserID();

 // validate new email
 if (!isEmailFree($newMail))
 {
  return(FALSE);
 }

 // change email
 $q1="UPDATE `user` SET `email`=?,`active`=0 WHERE `id`=?";
 $e1=$DB->prepare($q1);
 if(!$e1->execute(array($newMail,$id)))
 {
exit("FEHLER: accountSettings_functions: function changeUserEmail() #1");
 }

 // create activation token
 $q2="SELECT `id`,`username` FROM `user` WHERE `id`=?";
 $e2=$DB->prepare($q2);
 if(!$e2->execute(array($id)))
 {
exit("FEHLER: accountSettings_functions: function changeUserEmail() #2");
 }
 else
 {
  $z2=$e2->fetch(PDO::FETCH_ASSOC);
  $username = $z2['username'];
  $token = uniqid();

  $q3="INSERT INTO `user_token` (`token_username`,`token_token`) VALUES (?,?) ON DUPLICATE KEY UPDATE `token_token`=?";
  $e3=$DB->prepare($q3);
  if(!$e3->execute(array($username,$token,$token)))
  {
exit("FEHLER: accountSettings_functions: function changeUserEmail() #3");
  }

  // send activation email
  $activationLink = "http://nomads.followarmy.com/?view=activation&token=" . $token;
  $to = $newMail;
  $subject = "Nomads - Email changed.";
  $message = "
    <html>
      <body>
        Hello ".$username.".<br>
        <br>
        You requested an email change on your account.<br>
        To reactivate your account and resume playing please click on the link below.<br>
        <a href='".$activationLink."'>".$activationLink."</a><br>
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
}
// ---------------------------------------------------------------------------------------------------------
// DELETE ACCOUNT ACTION
function deleteUser($pass)
{
 include("includes/dbConnect.php");
 include "functions/registration_functions.php";

 // validate password
 $pass = password_encrypt($pass);
 $uID = getUserID();

 $q1="SELECT `id`,`password` FROM `user` WHERE (`password`=?) AND (`id`=?)";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($pass,$uID)))
 {
  if($e1->rowCount()<1)
  {
   return(FALSE);
  }
 }
 else
 {
exit("FEHLER: accountSettings_functions: function deleteUser() #1");
 }

 // validations should be placed above this line
 // validations done > delete session

 $q2="DELETE FROM `user_session` WHERE `session_userID`=?";
 $e2=$DB->prepare($q2);
 if($e2->execute(array($uID)))
 {
  // validations done > delete user
  $q3="DELETE FROM `user` WHERE `id`=?";
  $e3=$DB->prepare($q3);
  if($e3->execute(array($uID)))
  {
   return(TRUE);
  }
  else
  {
exit("FEHLER: accountSettings_functions: function deleteUser() #3");
  }
 }
 else
 {
exit("FEHLER: accountSettings_functions: function deleteUser() #2");
 }
}
// ---------------------------------------------------------------------------------------------------------
?>