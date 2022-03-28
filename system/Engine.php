<?php
include_once "./$system_folder/Config.php";
class Router extends Config
{
   private $path;
   public function __construct($path,$method)
   {
      $this->path = $path;
      $__path = $this->determine_path();
      $this->route($__path);
   }

   private function determine_path()
   {

      $__path;
      $path = $this->path;
      $routes = $this->routes(null);
      $regex = $this->route_regex();
      foreach ($routes as $key => $value) {

         $regex_variable = 0;
         $successful_iterations = 0;
         if($key=="/")
         {
            $key_array=array($key);
         }
         else
         {
            $key_str= str_ireplace('/',' ',$key);
            $key_array= explode(' ',trim($key_str));
         }
      
         $value_str = str_ireplace('/',' ',$value);
         $value_array = explode(' ',trim($value_str));
      
         if($path == "/")
         {
            $path_array= array($path);
         }
         else
         {
            $path_str = str_ireplace('/',' ',$path);
            $path_array= explode(' ',trim($path_str));
      
         }
      
         if(count($path_array) == count($key_array))
         {
            if($path_array[0] == $key_array[0] && count($path_array) ==1)
            {
               $successful_iterations++;
            }
            elseif($path_array[0] == $key_array[0] &&count($path_array)>1)
            {
               $successful_iterations++;
               $i;
               for($i=1;$i<count($path_array);$i++)
               {
                  $path_matches= $key_array[$i]==$path_array[$i]?true:false;
      
                  $has_regex= array_key_exists($key_array[$i],$regex)?true:false;
                  
                  if($path_matches)
                  {
                     $successful_iterations++;
                  }
                  elseif($has_regex)
                  {
                     $expression =  $regex[$key_array[$i]];
                     $is_match=preg_match("/$expression/i",$path_array[$i]);
                     
                     if( $is_match)
                     {
                        $regex_variable++;
                        $value = str_ireplace(":$regex_variable",$path_array[$i],$value);
                        $successful_iterations++;
                     }
                  }
                  else{
                     echo "error";
                  }
                  
               }
            }
           
         }
      
         if($successful_iterations==count($path_array))
         {
            $__path= $value;
         }
      }
      
      if(!isset($__path))
      {
         $__path=$path;
      }

      
      return $__path;
   }//end method 




   private function route($__path)
   {
      $controllers_folder = $this->controllers_folder;
      $__404page = $this->__404page;


      $_path = str_ireplace('/',' ',$__path);
      $__path_array = explode(' ',trim($_path));

      $__controller = ucwords($__path_array[0]);
      $controller = trim($__controller);

      $method;
      if(count($__path_array)<2)
      {
         $method = "index";
      }else
      {
         $method=trim($__path_array[1]);
      }

      $parameters = array();

      if (count($__path_array)>2)
      {
         $i;
         for($i=2;$i<count($__path_array);$i++)
         {
            array_push($parameters,$__path_array[$i]);
         }
      }
      $controller_page = "./$controllers_folder/$controller.php";
      $controller_object;


      if(file_exists($controller_page))
      {
         include_once"$controller_page";
         $controller_object = new $controller;
      }
      else
      {
         include_once"./$controllers_folder/$__404page.php";
         $controller_object = new $__404page;
         $method= "index";
         $parameters = array();
      }


      if(count($parameters)>0)
      {
         $controller_object->$method($parameters);
      }else
      {
         $controller_object->$method();
      }
   }//end method
}//end class

?>