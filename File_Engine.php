<?php
   $path=$_SERVER['PATH_INFO'];
   //echo $path;
   $arr = explode('.',$path);
   $extension = $arr[1];
   $filetype=str_ireplace('/',' ',trim($arr[0]));
   $file_arr = explode(' ',trim($filetype));
   $type = $file_arr[0];
   $filename = $file_arr[1];
   //echo $filename."<br>";
   //echo $_COOKIE[$filename];
   $base_url = $_COOKIE['base_url'];
   if(!isset($_COOKIE[$filename]))
   {
      header("location: $base_url/Access_Denied?reason=wrong-uri");
      exit();
   }
   if(!isset($_COOKIE['folder']))
   {
      header("location: $base_url/Not_Found?reason=not-permitted");
      exit();
   }
   $folder =$_COOKIE['folder'];
   
   $location = "$folder/".$type."s/".$filename.".".$extension;
   
   if(!file_exists($location))
   {
      header("location: $base_url/Not_Found?reason=does-not-exist");
      exit();
   }

   if($type == "doc")
   {
      $type= "application";
   }


   if($type == "video")
   {
      header("Content-Type:$type/$extension");
      header('Accept-Ranges: bytes');
      header('Content-Length: '. filesize($location));

      header("Content-Disposition: inline;");
      header("Content-Range: bytes ".filesize($location));
      header("Content-Transfer-Encoding: binary\n");
      header('Connection: close');
   }
   else
   {
      header("Content-Type:$type/$extension");
      header("Content-Length: ". filesize($location));
   }

   
   readfile($location);
   exit();?>