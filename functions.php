<?php 
include_once "header.php";
include_once "footer.php";

function get_clean_year($seasonId){
	echo substr(strval($seasonId), 0, 4); 
	echo "/"; 
	echo substr(strval($seasonId), -2, 2); 
}

function get_clean_league($leaguename){
	if ($leaguename === "National Hockey League") {
		$league = 'NHL';
	} else{
		$league = $leaguename;				
	}
	return $league;
}

function team_colors($teamname){
  include 'resources/colorswitch/colors.php';
  foreach ($colors as $key => $value) {
  	if ($key === $teamname) {
	  	$teamcolors = array();
	  	foreach ($value as $name => $color) {
	  		$teamcolors[$name] = $color;
	  	}
	  	return $teamcolors;
  	}
  }
}

function get_hyphenated($words){
   	$hypenatedword = strtolower(str_replace(" ", "-", $words));
    return $hypenatedword;
}

function convert_camelcase($source){
  return ucfirst(preg_replace('/(?<!^)([A-Z][a-z]|(?<=[a-z])[^a-z]|(?<=[A-Z])[0-9_])/', ' $1', $source));
}