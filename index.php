<?php
  /*
  name: sniper routing engine
  version:1.0;
  Author: Evans Mwenda Munene
  Email:evansmwenda006@gmail.com
  description: {
    1.Based on mvc model
    2.Routes urls and prevents direct access ot pages
    3.Able to deny access to specified image, video and document 
      files for users who don't meet predefined criteria eg.not logged in.
  }

  NB: please report any bugs to email above.
  */ 



   session_Start();
  // $_SESSION['id']=1;
  //session_unset();
  //session_destroy();
  include_once "./system/Config.php";
  $system_folder = Config::$the_system_folder;
  include_once "./$system_folder/Loader.php";

  $loader = new Loader;
  $request_uri=$_SERVER['REQUEST_URI'];
  $deny_absolutes_paths = $loader->is_path_absolute($request_uri);
  if($deny_absolutes_paths)
  {
    header("Access forbidden",false,403);
    $path ="/Access_Denied";

  }else
  {
    $path=isset($_SERVER['PATH_INFO']) ?$_SERVER['PATH_INFO']: "/";
  }
  require_once "./$system_folder/Engine.php";
  $router = new Router($path);
  ?>