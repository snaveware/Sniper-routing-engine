<?php
include "../system/config.php";
$config = new Config();
$base_url = $config->base_url;
 header("location: $base_url/access_denied");
 ?>