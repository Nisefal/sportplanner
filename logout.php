<?php
/**
 * Created by PhpStorm.
 * User: kolya
 * Date: 11/7/2018
 * Time: 5:39 PM
 */

include "config.php";

setcookie("sid", '', time()-1000, "/", $baseUrl);
setcookie("uid", '', time()-1000, "/", $baseUrl);
setcookie("gid", '', time()-1000, "/", $baseUrl);

header("Location: index.php");exit();