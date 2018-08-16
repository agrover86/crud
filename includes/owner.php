<?php
require_once("db_object.php");

class Owner extends Db_object{
  //define table in database
  protected static $db_table = "owners";
  //define  array of table fields
  protected static $db_table_fields = array('id','businessname','firstname','surname','email','telephone');
  // define public properties of owner class
  // Business Name,First Name, Last Name, Email
  public $id;
  public $businessname;
  public $firstname;
  public $surname;
  public $email;
  public $telephone;


} // End of Class

?>
