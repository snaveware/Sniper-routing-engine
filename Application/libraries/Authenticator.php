<?php
include_once "$system_folder/Loader.php";
class Authenticate extends Loader
{
   public function logged_in()
   {
      $logged_in = isset($_SESSION['id'])?true:false;
      return $logged_in;

   }
}

?>