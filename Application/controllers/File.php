<?php
session_start();
class File extends Loader{
   public function image($parameters)
   {
      $name;
      $folder;
      $base_url = $this->base_url;
      $should_authenticate=$this->should_authenticate($parameters);
      
      if($should_authenticate)
      {
         $folder = $name=$parameters[0];
         $name = $name=$parameters[1];
         $authorized = $this->authenticator($folder);
         if(!$authorized)
         {
            header("location: $base_url/Access_Denied?reason=Dont-have-permission"); 
            exit();
         }      
      }else
      {
         $folder = $this->default_files_folder;
         $name = $name=$parameters[0];
      }
      

      $cookie_name = current(explode('.',$name));
      setcookie($cookie_name,"1",time()+10,'/');
      setcookie("base_url",$base_url,time()+10,'/');
      setcookie('folder',$folder,time()+10,'/');
      
      $file_engine = $this->file_engine;
      header("location: $base_url/$file_engine/image/$name");
   }
   public function video($parameters)
   {
      $name;
      $folder;
      $base_url = $this->base_url;
      $should_authenticate=$this->should_authenticate($parameters);
      
      if($should_authenticate)
      {
         $folder = $name=$parameters[0];
         $name = $name=$parameters[1];
         $authorized = $this->authenticator($folder);
         if(!$authorized)
         {
            header("location: $base_url/Access_Denied?reason=Dont-have-permission"); 
            exit();
         }      
      }else
      {
         $folder = $this->default_files_folder;
         $name = $name=$parameters[0];
      }
      

      $cookie_name = current(explode('.',$name));
      setcookie($cookie_name,"1",time()+10,'/');
      setcookie("base_url",$base_url,time()+10,'/');
      setcookie('folder',$folder,time()+10,'/');

      $file_engine = $this->file_engine;
      header("location: $base_url/$file_engine/video/$name");
      
   }
   public function document($parameters)
   {
      $name;
      $folder;
      $base_url = $this->base_url;
      $should_authenticate=$this->should_authenticate($parameters);
      
      if($should_authenticate)
      {
         $folder = $name=$parameters[0];
         $name = $name=$parameters[1];
         $authorized = $this->authenticator($folder);
         if(!$authorized)
         {
            header("location: $base_url/Access_Denied?reason=Dont-have-permission"); 
            exit();
         }      
      }else
      {
         $folder = $this->default_files_folder;
         $name = $name=$parameters[0];
      }

      
      $cookie_name = current(explode('.',$name));
      setcookie($cookie_name,"1",time()+10,'/');
      setcookie("base_url",$base_url,time()+10,'/');
      setcookie('folder',$folder,time()+10,'/');
      
      $file_engine = $this->file_engine;
      header("location: $base_url/$file_engine/doc/$name");
   }
   private function should_authenticate($parameters)
   {
      $base_url = $this->base_url;
      if(count($parameters)==2)
      {
         return true;
      }
      elseif(count($parameters) ==1)
      {
         return false;
      }
      else
      {
        header("location: $base_url/Not_Found?reason=wrong-url"); 
        exit();
      }
   }
   private function authenticator($folder)
   {
      $folders= $this->restrict();
      $method=$folders[$folder];
      $this->library('Authenticator');
      $autheniticator = new Authenticate;
      $authorized = $autheniticator->$method();
      return $authorized;
   }
}