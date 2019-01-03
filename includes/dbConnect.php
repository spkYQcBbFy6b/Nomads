<?php

if(!class_exists('NomadsPDO'))
{
class NomadsPDO extends PDO
{
 private $engine;
 private $host;
 private $port;
 private $charset;
 private $db;
 private $user;
 private $pw;
 private $dns;

 public function __construct()
 {
  $db=array();
include(CONNECTDATAFILE);
  $this->engine = $db['dbengine'];
  $this->host = $db['dbhost'];
  $this->port = $db['dbport'];
  $this->db = $db['dbname'];
  $this->user = $db['dbuser'];
  $this->pw = $db['dbuserpw'];
  $this->charset = $db['dbcharset'];
  $dns=strtolower($this->engine).':dbname='.$this->db.";charset=".$this->charset.";host=".$this->host;

  try
  {
   parent::__construct( $dns, $this->user, $this->pw );
  }
  catch(Exception $e)
  {
   exit('No SQL. '.$e->getMessage());
  }
  $this->pw = '';
  $this->user = '';
  $this->db = '';
 }
}
} // ENDE if(!class_exists('NomadsPDO'))

try
{
 $DB=new NomadsPDO();
}
catch (PDOexception $e)
{
 echo"Fehler beim Erstellen der Datenbank-Klasse:<br>".$e->getMessage();
 exit();
}
$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>