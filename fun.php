<?php
//prettyDate($date);
function prettyDate($date){
	$time = strtotime($date);
	$now = time();
	$ago = $now - $time;
	if($ago < 60){
		$when = round($ago);
		$s = ($when == 1)?"second":"seconds";
		return "$when $s";
	}elseif($ago < 3600){
		$when = round($ago / 60);
		$m = ($when == 1)?"minute":"minutes";
		return "$when $m";
	}elseif($ago >= 3600 && $ago < 86400){
		$when = round($ago / 60 / 60);
		$h = ($when == 1)?"hour":"hours";
		return "$when $h";
	}elseif($ago >= 86400 && $ago < 2629743.83){
		$when = round($ago / 60 / 60 / 24);
		$d = ($when == 1)?"day":"days";
		return "$when $d";
	}elseif($ago >= 2629743.83 && $ago < 31556926){
		$when = round($ago / 60 / 60 / 24 / 30.4375);
		$m = ($when == 1)?"month":"months";
		return "$when $m";
	}else{
		$when = round($ago / 60 / 60 / 24 / 365);
		$y = ($when == 1)?"year":"years";
		return "$when $y";
	}
}

//Add value in Database array
function add_array($v,$a) {

$array=explode(',',$a);
//check if value is already in array
if (!in_array($v, $array)){array_push($array,$v);}
return implode(',',$array);

}

//Remove value in Database array
function remove_array($v,$a) {

$array=explode(',',$a);
//check if value is already in array
if (in_array($v, $array)){
$key=array_search($v,$array);
array_splice($array,$key,1);
}
return implode(',',$array);

}

//Check value in Database array
function check_in_array($v,$a) {

$array=explode(',',$a);
//check if value is already in array
if (in_array($v, $array)){
return true;
}
else {
return false;
}

}

//Convert Database value to array
function to_array($v) {

$array=explode(',',$v);
array_splice($array,0,1);

return $array;

}

?>