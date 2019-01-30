<?php
error_reporting(Null);
header("Content-Type: application/json");
require_once('minestat.php');

$mcservers = array(
	"snapecraft.net" => array(25565,7001,7002,7003)
);
$webservers = array(
	"snapecraft.net"
);
echo("{");
echo('"tags":["mc", "HTTP"],');

// MC
echo('"mc": {');
foreach ($mcservers as $k => $v) {
    
	$i = 0;
	foreach($v as $port) {
		echo '"'.$k.':'.$port.'": '.getRunningMC($k, $port);
		$i = $i + 1;
		if($i < sizeof($v)) {
			echo ",";
		}
		
		
	}
	
}
echo "},";
//MC ENDE

//HTTP
echo('"HTTP": {');
$i = 0;
foreach ($webservers as $k) {
    
	
	
	echo '"'.$k.'":'.getRunningWeb($k);
	$i = $i + 1;
	if($i < sizeof($webservers)) {
		echo ",";
	}
		
		
	
	
}

echo "}";
//HTTP ENDE



echo "}";
function getRunningMC($server, $port) {
	try {
		$server = new MCServerStatus($server, $port);
		if($server->online)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	} catch (Exception $ex) {
		return 1;
	}
	
}

function getRunningWeb($url) {
  $timeout = 10;
  $ch = curl_init();
  curl_setopt ( $ch, CURLOPT_URL, $url );
  curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
  $http_respond = curl_exec($ch);
  $http_respond = trim( strip_tags( $http_respond ) );
  $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
  if ( ( $http_code == "200" ) || ( $http_code == "302" ) ) {
    return 1;
  } else {
    // return $http_code;, possible too
    return 0;
  }
  curl_close( $ch );
	
}

?>
