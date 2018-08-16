<?php

class Db_object{
  protected static $db_table ="owners";

  // find all records in table
  public static function find_all() {
    return static::find_by_query("SELECT * FROM ". static::$db_table ." ");

  }

  // find table row by id (read)
  public static function find_by_id($id) {
     global $database;

     $the_result_array =  static::find_by_query("SELECT * FROM ".static::$db_table." WHERE id=".$id." LIMIT 1");
     return !empty($the_result_array) ? array_shift($the_result_array):false;
  }

//  A method to return a table row as an object array with table attributes as keys
  public static function find_by_query($sql){
    global $database;
    $result_set = $database->query($sql);
    $the_object_array = [];
    while($row = mysqli_fetch_array($result_set)){
      $the_object_array[] = static::instantiation($row);
    }
    return $the_object_array;
  }

// A method to create an instance of an object and assign row attributes to it
  public static function instantiation($the_record){
   $calling_class = get_called_class();
    $the_object = new  $calling_class;
    foreach ($the_record as $the_attribute => $value) {
      if($the_object->has_the_attribute($the_attribute)){
          $the_object->$the_attribute = $value;
      }
    }
    return $the_object;
  }

 // A method to check whether row attribute exists in object properties
  private function has_the_attribute($the_attribute){
     $object_properties = get_object_vars($this);
     return array_key_exists($the_attribute,$object_properties);
  }

//  A method to creates an array of clean input properties
  protected function clean_properties(){
    global $database;
    $clean_properties = array();
    foreach ($this->properties() as $key => $value) {
        $clean_properties[$key] = $database->escape_string($value);
      }
    return $clean_properties;
  }

// A method to see if a property exists in the table field
    protected function properties(){
      $properties = array();
      foreach (static::$db_table_fields as $db_field) {
         if(property_exists($this, $db_field)){
              $properties[$db_field] = $this->$db_field;
         }
      }
      return $properties;
    }


// Create method
    public function create(){
       global $database;

       $properties = $this->clean_properties();

       $sql = "INSERT INTO ".static::$db_table."(".implode(",",array_keys($properties)).")";
       $sql .=" VALUES ('".implode("','",array_values($properties))."')";


       if($database->query($sql)){
         $this->id = $database->the_insert_id();
         return true;
       } else {
         return false;
       }
    }

    // Create method
        public function update_entries(){
           global $database;

           $properties = $this->clean_properties();

           $sql = "INSERT INTO ".static::$db_table."(".implode(",",array_keys($properties)).")";
           $sql .=" VALUES ('".implode("','",array_values($properties))."')";


           if($database->query($sql)){
             return true;
           } else {
             return false;
           }
        }

        public function highest_id(){
          global $database;
          $sql = "SELECT MAX(id) FROM ".static::$db_table."";
          $result = $database->query($sql);
          $row = $database->fetch_row($result);
          $highest_id = $row[0];
          return $highest_id;

          }


    // Update Method

    public function update(){
      global $database;

      $properties = $this->clean_properties();
      $properties_pairs = array();

      foreach ($properties as $key => $value) {
          $properties_pairs [] = "{$key}='{$value}'";
      }

      $sql = "UPDATE  ".static::$db_table." SET ";
      $sql .= implode(", ",$properties_pairs);

      $sql.= " WHERE id =".$database->escape_string($this->id);

      $database->query($sql);

      return (mysqli_affected_rows($database->connection) ==1) ? true: false;

    }

   // Delete Method

    public function delete(){

     global $database;

     $sql  = "DELETE  FROM ".static::$db_table." ";
     $sql .= " WHERE id=".$database->escape_string($this->id);
     $sql .= " LIMIT 1";
     $database->query($sql);
     return (mysqli_affected_rows($database->connection) ==1) ? true: false;

    }

} // End of class


?>
