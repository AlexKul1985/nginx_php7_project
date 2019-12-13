<?php
$root = str_replace("/config","",__DIR__);

define("ROOT", $root);
define("VIEW", $root."/view");
define("TMP", $root."/tmp");
define("CACHE", TMP."/cache");

?>