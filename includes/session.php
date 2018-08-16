<?php

session_start();
$_SESSION['MAXVAL'] = findMaxId();

function findMaxId(){
  global $database;
  $the_max_val =  $database->query("SELECT MAX(id) as max_id FROM owners");
  $row = mysqli_fetch_assoc($the_max_val);
  $max_id=$row['max_id'];
  return $max_id;
}

 ?>
