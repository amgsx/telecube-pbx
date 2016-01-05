<?php
require("../init.php");

$name = $_POST["pk"];
$field = str_replace("-".$_POST["pk"], "", $_POST["name"]);
$value = $_POST["value"];

$q = "update sip_devices set ".$field." = ? where name = ?;";
$data = array($value, $name);
$res = $Db->pdo_query($q,$data,$dbPDO);

//header("HTTP/1.0 400 Bad Request");

// no need to reload for non critical changes
$noreload = array("label","bar_mobile","bar_13","bar_fixed","bar_int");
if(!in_array($field, $noreload)){
	// let's reset the realtime cache
	$reset = `sudo /usr/sbin/asterisk -rx "sip prune realtime $name"`;
	$reset = `sudo /usr/sbin/asterisk -rx "sip show peer $name load"`;
}

echo "ok";
?>