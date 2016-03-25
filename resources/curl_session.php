<?php 
function curl_session($queryType, $id){
	// Setting up query 
		// set url to query type
		if ($queryType == 'people') {
		  $playerId = $id;
		  $statsurl = 'https://statsapi.web.nhl.com/api/v1/'.$queryType.'/'.$playerId.'?';
		  // Set query parameters
		  $data =  array('expand' => 'person.stats',
					     'stats'  => 'yearByYear,careerRegularSeason',
					    );
		  // turn $data array into query string
		  $query = http_build_query($data);
		  // concatenate query string to url, get expanded stats too
		  $url = $statsurl.$query.'&expand=stats.team&site=en_nhl';
		  //echo $query;
		}elseif ($queryType == 'teams') {
		  $teamId = $id;
		  $url = 'https://statsapi.web.nhl.com/api/v1/'.$queryType;			
		}elseif ($queryType == 'standings') {
		  $teamId = $id;
		  $url = 'https://statsapi.web.nhl.com/api/v1/'.$queryType;			
		}
	// Using query to request & recieve Player Information
		//  Initiate CURL Session
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL, $url);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
		// convert json encoded string to arrays, set as $teams
		$obj = json_decode($result, true);	
		return $obj;
}

function curl_session_stats($teamId){
// Setting up query 
		// set url
		$statsurl = 'http://www.nhl.com/stats/rest/grouped/teams/season/teamsummary';

	// Using query to request & recieve Player Information
		//  Initiate CURL Session
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$statsurl);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
		// convert json encoded string to arrays, set as $player
		$seasons = json_decode($result, true);	
		$seasonNode = $seasons['data'];

		$statsTeamSeason = array();
		foreach ($seasonNode as $key => $value) {
			if ($seasonNode[$key]['teamId'] == $teamId) {
				$statsTeamSeason[$key] = $value;

			}
		}
		return $statsTeamSeason;	
}


