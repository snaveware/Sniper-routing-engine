<?php
   /*
      NB: Every code you write is actually executed in the index.php of the root folder.
          For this reason, all relative urls you provide should be in relation to the index.php.
   */
   class Config 
   {
      public $base_url="http://localhost/sniper";

      /* 
         Changing the folder that contains core files including this one.
      
      NB: if for any reason you change the system folder, make sure you update
      header statements in 
      1.index.php of root folder approximately line number 20.

      To change the system folder,change the values of
      1.public $system_folder
      2.public static $the_system_folder.
      that are below.
       */
      public $system_folder = "system";
      public static $the_system_folder = "system";


      /*the folder that contains images,videos and pdf documents
      it should not contain static css and javascript file.
      This folder should contain folders called
      1. docs -this should have pdf documents.
      2.images -this should have images.
      3. videos -this should contain your videos.
      it should also contain a .htaccess folder with value of "deny from all";
      */
      public $default_files_folder = "assets/files";
    

      public $controllers_folder="Application/controllers";
      public $models_folder = "Application/models";
      public $views_folder ="Application/views";
      public $helpers_folder = "Application/helpers";
      public $libraries_folder="Application/libraries";
      public $__404page="Not_Found";
      public $deny_absolute_paths=true;
      public $file_engine = "File_Engine";
      public function route_regex()
      {
         //regex
         /*
         add regular expressions which you want to pass as a parameter to routes
         NB: the regular expression should not have forward slashes(/);
         why?->forward slashes are used by the routing engine to decipher the requested url.
         Including them in the regex interferes with this process
         */
         $regex = array();
         $regex[':any']= ".*";
         $regex[':num'] = "[0-9]+";
         $regex[':string'] = "[a-zA-Z]+";
         
         return $regex;
      }

      public function routes($method)
      {
         
         //regex=:any,:number,:string
         //can add more routes here
         /*
         first parameter is the controller
         second parameter is the method in the controller(index is the default method)
         all other parameters are sent to the method as an array
         */ 

         $GET_routes=array();
         $GET_routes['/']="Home";
         $GET_routes['/image/:any']="File/image/:1";
         $GET_routes['/video/:any'] ="File/video/:1";
         $GET_routes['/doc/:any'] = "File/document/:1";
         $GET_routes['/image/:any/:any'] = "File/image/:1/:2";
         $GET_routes['/video/:any/:any'] = "File/video/:1/:2";
         $GET_routes['/doc/:any/:any'] = "File/document/:1/:2";

         $POST_routes = array();

         $PUT_routes = array();

         $DELETE_routes  = array();

         switch ($method?strtolower($method) : $method) {
            case 'post':
               return $POST_routes;
               break;
            case 'put':
               return $PUT_routes;
               break;
            
            case "delete" :
               return $DELETE_routes;
               break;
            
            default:
               return $GET_routes;
               break;
         }
         
      }
      public function database()
      {
         $db= array();
         /*
         change database configurations
         mysql database
         pdo connection are used
         */

         $db["host"]="localhost";
         $db["user"] = "root";
         $db["password"]="";
         $db["name"]="newdb";

         return $db;
      }
      public function restrict()
      {
         $folders=array();
         /*
         add file folders which you dont want a basic user to have access to.
         These folders should have images,videos,and docs subfolders.
         example
         $folders['folder name']= 'the method in authenticator 
         library that will be called to authenticate a call to the folder';*/
         return $folders;
      }
   }//end class

?>