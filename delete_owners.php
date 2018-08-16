<?php include("includes/init.php"); ?>

<?php
if(empty($_GET['id'])){
  redirect('index.php');
}
$owner= Owner::find_by_id($_GET['id']);

if($owner){

  $owner->delete();
  redirect('index.php');


} else{
  redirect('index.php');
}

 ?>
