<?php
error_reporting(E_ALL);
date_default_timezone_set('Europe/Berlin');
// ##########################
// Install
// created 2019-01-02
// by Karsten Maske
// ##########################
// Installing the browsergame.
// Database and database user with password must exist, required priviliges granted.
// Upload files including existing structure to webspace, e. g. <example.com>/Nomads
//   ( replace <example.com> with your domain name ).
// !! The source actually uses the dir /Nomads/ in several places.
//    This will be simplified in future so that one var can be used to specify the dir.
// Call http://www.example.com/Nomads/install.php and follow the required steps.
// After install, install.php should be deleted or at least renamed. Otherwise any call will possibly re-install.
// Some of the following defines will be needed in the game scripts.

define('INCLUDESDIR','/includes/');
define('CONNECTDATAFILE','dbConnectData.php');
define('CONNECTDBFILE',INCLUDESDIR.CONNECTDATAFILE);
define('CONNECTFILE',INCLUDESDIR.'dbConnect.php');

define('DUMPFILESDIR','/SQLdump/');
define('TABLESCREATEFILE','.'.DUMPFILESDIR.'Nomads-init.sql.php');

if(!isset($_REQUEST['step']))
{
 $step=1;
}
else
{
 $step=(int)$_REQUEST['step'];
}

$out='<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Install Nomads browsergame</title>
<style type="text/css">
html,body{margin:0px; padding:0px;}
body{background-image:radial-gradient(circle,white 0%,blue 100%);}
a{color:black; text-decoration:underline;}
button{cursor:pointer;}
#wrapper{width:100%; height:100%; display:block;}
.bold{font-weight:bold;}
.center{margin:0 auto;}
.italic{font-style:italic;}
.red{color:red;}
.w80p{width:80%;}
</style>
</head>
<body>
<div id="wrapper">
 <div class="w80p center">
  <h3>Installing Nomads browsergame</h3><hr>';

if($step==1)
{
 $out.='This will install all needed tables into the database.';
 $out.='<br>';
 $out.='Database and database user with password must exist, required priviliges granted.';
 $out.='<br>';
 $out.='Existing tables with same names will be deleted and re-created.';
 $out.='<br>';
 $out.='Tables will be populated with required data.';
 $out.='<br><br>';
 $out.="<span class=\"bold italic\">Step #$step: Enter the required informations.</span><br><br>";

 $step++;
 $out.="<form action=\"?step=$step\" method=\"POST\" accept-charset=\"utf-8\">";
  $out.='<table>';
   $out.='<tr><td>Database</td><td><input type="text" name="txDb" placeholder="Database name"></td></tr>';
   $out.='<tr><td>Database user</td><td><input type="text" name="txDbuser" placeholder="Database user name"></td></tr>';
   $out.='<tr><td>Database user password</td><td><input type="password" name="txDbuserpw" placeholder="Database user password"></td></tr>';
   $out.='<tr><td>Database host</td><td><input type="text" name="txDbhost" value="localhost"></td></tr>';
   $out.='<tr><td>Database engine</td><td><input type="text" name="txDbengine" value="MySQL"></td></tr>';
   $out.='<tr><td>Database port</td><td><input type="text" name="txDbport" value="3306"></td></tr>';
   $out.='<tr><td>Database charset</td><td><input type="text" name="txDbcharset" value="utf8"></td></tr>';
   $out.='<tr><td>OK, let\'s go</td><td><button name="btnGo">GO!</button></td></tr>';
  $out.='</table>';
 $out.='</form>';
}
elseif($step==2)
{
// db name, db user and db user password required.
// host, engine, port and charset will be set to defaults if missing.

 $db['name']=trim($_REQUEST['txDb']);
 $db['user']=trim($_REQUEST['txDbuser']);
 $db['userpw']=trim($_REQUEST['txDbuserpw']);
 $db['host']=trim($_REQUEST['txDbhost']);
 $db['engine']=trim($_REQUEST['txDbengine']);
 $db['port']=trim($_REQUEST['txDbport']);
 $db['charset']=trim($_REQUEST['txDbcharset']);

 if((!$db['name']) OR (!$db['user']) OR (!$db['userpw']))
 {
  exit("Step $step: ERROR: DB name, DB user and DB user password required.");
 }

 $db['host']=($db['host'])?$db['host']:'localhost';
 $db['engine']=($db['engine'])?$db['engine']:'MySQL';
 $db['port']=($db['port'])?$db['port']:'3306';
 $db['charset']=($db['charset'])?$db['charset']:'utf8';

 $a='<' . '?' .'php'. "\n";
 $a.="\$db=array();\n";
 $a.="\$db['dbname'] = '".$db['name']."';\n";
 $a.="\$db['dbuser'] = '".$db['user']."';\n";
 $a.="\$db['dbuserpw'] = '".$db['userpw']."';\n";
 $a.="\$db['dbhost'] = '".$db['host']."';\n";
 $a.="\$db['dbengine'] = strtolower('".$db['engine']."');\n";
 $a.="\$db['dbport'] = ".$db['port'].";\n";
 $a.="\$db['dbcharset'] = '".$db['charset']."';\n";
 $a.='?' . '>';

 $i=file_put_contents('.'.CONNECTDBFILE,$a);
 if($i<1)
 {
  exit("Step #$step: FATAL ERROR: Could not create ".CONNECTDBFILE.".");
 }

 $out.="<h3>Step #$step: Success! ".CONNECTDBFILE." written.</h3>";
 $out.='<br>';

 $step++;
 $out.="<a href=\"?step=$step\">Continue to check DB-connection.</a>";
}
elseif($step==3)
{
 $out.="<h3>Step #$step: Connecting to database ... </h3>";
 $out.='<br>';

 if(file_exists('./'.CONNECTFILE))
 {
  $DB=NULL;
  include('./'.CONNECTFILE);
  if($DB)
  {
   $out.='... successful!';
   $out.='<br><br><br>';
   $step++;
   $out.="<a href=\"?step=$step\">Continue to create tables. This <span class=\"italic\">may</span> take some seconds, so click only once and wait for the result.</a>";
  }
  else
  {
   exit("Step #$step: FATAL ERROR: Could not create DB-object.");
  }
 }
 else
 {
  exit("Step $step: ERROR: missing ".CONNECTFILE);
 }
}
elseif($step==4)
{
 $out.="<h3>Step #$step: Creating tables ... </h3>";
 $out.='<br>';
 if(file_exists(TABLESCREATEFILE))
 {
  $DB=NULL;
  include('./'.CONNECTFILE);
  if($DB)
  {
   include(TABLESCREATEFILE);
  }
  else
  {
   exit("Step #$step: FATAL ERROR: Could not create DB-object.");
  }

  $out.='... successful!';
  $out.='<br><br>';
  $step++;
  $out.="<a href=\"?step=$step\">Continue to create an account.</a>";
 }
 else
 {
  exit("Step $step: ERROR: missing ".TABLESCREATEFILE);
 }
}
elseif($step==5)
{
 $out.="<h3>Step #$step: Creating an active account</h3>";
 $out.='<br>';

 $out.="You can decide wether or not an active account shall be created. By creating one you don't have to wait for activation mail (but you don't check the functionality of activation). ";
 $out.='<br>';
 $out.='For creating an account, fill in the required data. Beware of type errors. Remember or write down your data; they will not be shown any more.';
 $out.='<br>';
 $step++;
 $out.="<form action=\"?step=$step\" method=\"POST\" accept-charset=\"utf-8\">";
  $out.='<table>';
   $out.='<tr><td>Username</td><td><input type="text" name="txUn" placeholder="your username"></td></tr>';
   $out.='<tr><td>Password</td><td><input type="password" name="txPw" placeholder="your password"></td></tr>';
   $out.='<tr><td>Email</td><td><input type="email" name="txEm" placeholder="your emailadress"></td></tr>';
   $out.='<tr><td>OK, let\'s go</td><td><button name="btnGo">Create Account!</button></td></tr>';
  $out.='</table>';
 $out.='</form>';


 $out.='<br><br>';
 $step++;
 $out.="<a href=\"?step=$step\">You can skip this step</a>";
}
elseif($step==6)
{
 $out.="<h3>Step #$step: Creating an active account ... </h3>";
 $out.='<br>';
 if(file_exists('./'.CONNECTFILE))
 {
  if(file_exists('./functions/registration_functions.php'))
  {
   include('./functions/registration_functions.php');

   $DB=NULL;
   include('./'.CONNECTFILE);
   if($DB)
   {
    $un=trim($_REQUEST['txUn']);
    $pw=password_encrypt($_REQUEST['txPw']);
    $em=trim($_REQUEST['txEm']);

    if((!$un) OR (!$pw) OR (!$em))
    {
     exit("Step #$step: ERROR: username, password and email required.");
    }

    $q1="INSERT INTO `user` (`username`,`email`,`password`,`active`) VALUES (?,?,?,1)";
    $e1=$DB->prepare($q1);
    if($e1->execute(array($un,$em,$pw)))
    {
     $out.='... successful!';
     $out.='<br><br>';
     $step++;
     $out.="<a href=\"?step=$step\">Continue to the last step.</a>";
    }
    else
    {
     exit("Step #$step: ERROR: Could not create account.");
    }
   }
   else
   {
    exit("Step #$step: FATAL ERROR: Could not create DB-object.");
   }
  }
  else
  {
   exit("Step $step: ERROR: missing './functions/registration_functions.php");
  }
 }
 else
 {
  exit("Step $step: ERROR: missing ".CONNECTFILE);
 }
}
elseif($step==7)
{
 $out.="<h3>Step #$step: Deleting install.php</h3>";
 $out.='<br>';

 $out.='You can decide whether or not the install.php shall be deleted (if possible). If your project is presented to the public it is recommended to delete anything that is installation related; check for it and delete manually if necessary. Otherwise <enter lot of fun facts here>.';
 $out.='<br><br>';

 $step++;

 $out.="<a href=\"?step=$step&del=1\">Delete install.php (if possible)</a>";
 $out.='<br><br>';
 $out.="<a href=\"?step=$step\">Skip this step</a>";
}
elseif($step==8)
{
 if(isset($_REQUEST['del']))
 {
  if((int)$_REQUEST['del']==1)
  {
   rename('install.php','installOLD.php'.microtime(TRUE));
   //unlink('install.php');
  }
 }

 $out.="DONE!";
 $out.='<br><br>';
 $out.="<a href=\"/Nomads/index.php\">You can jump to your browsergame and login or register a new account.</a>";
}

 $out.='</div>'; // .w80p.center
$out.='</div>'; // #wrapper
$out.='</body></html>';

echo $out;

?>
