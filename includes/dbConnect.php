<?php
if(!class_exists('NomadsPDO'))
{
class NomadsPDO extends PDO
{
 private $engine;
 private $host;
 private $db;
 private $user;
 private $pw;
 private $dns;

 public function __construct()
 {
  $db=array();

  $db['dbengine'] = 'mysql';
  $db['dbhost'] = 'localhost';
  $db['dbport'] = 3306;
  $db['dbname'] = 'nomads';
  $db['dbuser'] = 'nomads';
  $db['dbuserpw'] = 'nomads';

  $this->engine = $db['dbengine'];
  $this->host = $db['dbhost'];
  $this->port = $db['dbport'];
  $this->db = $db['dbname'];
  $this->user = $db['dbuser'];
  $this->pw = $db['dbuserpw'];
  $dns = $this->engine.':dbname='.$this->db.";charset=utf8;host=".$this->host;

  try
  {
   parent::__construct( $dns, $this->user, $this->pw );
  }
  catch(Exception $e)
  {
   exit('No SQL');
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