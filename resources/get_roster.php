<?php
include_once "functions.php";

function get_team_roster($seasonId, $teamId){
	// set url to curl
	$rosterurl = 'http://www.nhl.com/stats/rest/grouped/skaters/season/skatersummary?cayenneExp=seasonId='.$seasonId.'%20and%20gameTypeId=2%20and%20teamId='.$teamId.'';
		//  Initiate CURL Session
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL, $rosterurl);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
		// convert json encoded string to arrays, set as $roster of players 
		$roster = json_decode($result, true);	
		// return roster to use
		return $roster;
}



function get_roster_headshot($playerid){
	$bgUrl = 'https://nhl.bamcontent.com/images/headshots/current/168x168/';
	$file_headers = @get_headers($bgUrl.$playerid.'.jpg');
	if($file_headers[0] == 'HTTP/1.1 404 Not Found'){ 
	// see if the players headershot 404's, if yes get default ?>
	<img class="roster-headshot" alt="<?php echo $playerid;?> Headshot" src="css/images/default.jpg">
	<? } else{ // if it does not 404 get player headshot ?>
	<img class="roster-headshot" alt="<?php echo $playerid;?> Headshot" src="https://nhl.bamcontent.com/images/headshots/current/168x168/<?php echo $playerid;?>.jpg">
	<?php }
}

function get_team_roster_html($seasonId, $teamId){
	$roster = get_team_roster($seasonId, $teamId);
	?><div class="team-headshots"><?php
	$defense = array(); $forwards = array();
	foreach ($roster["data"] as $key => $player) { 
		if ($player["playerPositionCode"] !== "D") {
		$forwards[$key] = $player;
		}else {
 		$defense[$key] = $player;
		} ?>
	<?php 	 
	}//end foreach ?>
	<div class="players-table">	
		<h2 class="position-title">FORWARDS</h2>
		<div class="forwards-row"><?php $i=0;
			foreach ($forwards as $key => $player) { $i++; 
				if ($i % 6 == 0) { ?>
						<a class="player" data-player="<?php echo get_hyphenated($player["playerName"]); ?>" data-position="<?php echo $player["playerPositionCode"];?>" href="player.php?playerId=<?php echo $player["playerId"]; ?>">
						<div id="<?php echo get_hyphenated($player["playerName"]); ?>" class="player-headshot"><?php get_roster_headshot($player["playerId"]); ?></div>
						<div class="player-headshot-info">
							<h4 class="player-firstname"><?php echo $player["playerFirstName"]; ?></h4>
							<h4 class="player-lastname"><?php echo $player["playerLastName"]; ?></h4>
						</div>
						</a> 
					</div><div class="table-row-spacing"></div><div class="forwards-row">
				<?php } else { ?>
						<a class="player" data-player="<?php echo get_hyphenated($player["playerName"]); ?>" data-position="<?php echo $player["playerPositionCode"];?>" href="player.php?playerId=<?php echo $player["playerId"]; ?>">
						<div id="<?php echo get_hyphenated($player["playerName"]); ?>" class="player-headshot"><?php get_roster_headshot($player["playerId"]); ?></div>
						<div class="player-headshot-info">
							<h4 class="player-firstname"><?php echo $player["playerFirstName"]; ?></h4>
							<h4 class="player-lastname"><?php echo $player["playerLastName"]; ?></h4>
						</div>
						</a> 					
				<?php }?>

			<?php } // end offense foreach?>
		</div>
		<div class="table-row-spacing"></div>
		<h2 class="position-title">DEFENSE</h2>
		<div class="defense-row"><?php $i = 0;
			foreach ($defense as $key => $player) { $i++; 
				if ($i % 6 == 0) {?>
					<a class="player" data-player="<?php echo get_hyphenated($player["playerName"]); ?>" data-position="<?php echo $player["playerPositionCode"];?>" href="player.php?playerId=<?php echo $player["playerId"]; ?>">
					<div id="<?php echo get_hyphenated($player["playerName"]); ?>" class="player-headshot"><?php get_roster_headshot($player["playerId"]); ?></div>
					<div class="player-headshot-info">
						<h4 class="player-firstname"><?php echo $player["playerFirstName"]; ?></h4>
						<h4 class="player-lastname"><?php echo $player["playerLastName"]; ?></h4>
					</div>
					</a>
					</div><div class="table-row-spacing"></div><div class="defense-row">
				<?php } else { ?>
					<a class="player" data-player="<?php echo get_hyphenated($player["playerName"]); ?>" data-position="<?php echo $player["playerPositionCode"];?>" href="player.php?playerId=<?php echo $player["playerId"]; ?>">
					<div id="<?php echo get_hyphenated($player["playerName"]); ?>" class="player-headshot"><?php get_roster_headshot($player["playerId"]); ?></div>
					<div class="player-headshot-info">
						<h4 class="player-firstname"><?php echo $player["playerFirstName"]; ?></h4>
						<h4 class="player-lastname"><?php echo $player["playerLastName"]; ?></h4>
					</div>
					</a> 
				<?php }
			} // end defense foreach?>
		</div>
	</div> 
</div>	<?php 
}

function get_current_roster_stats_html($seasonId, $teamId){
$roster = get_team_roster($seasonId, $teamId);
?><div class="team-leaders-stats"> 	
	<div class="player-stats-table">
		<div class="player-stats-table-header">
			<div class="player-stat-header">First Name</div>
			<div class="player-stat-header">Last Name</div>
			<div class="player-stat-header">Position</div>
			<div class="player-stat-header">Games</div>
			<div class="player-stat-header">Points</div>
			<div class="player-stat-header">Goals</div>
			<div class="player-stat-header">Assists</div>
			<div class="player-stat-header">PIM</div>
			<div class="player-stat-header">Shots</div>
			<div class="player-stat-header">Plus/Minus</div>
			<div class="player-stat-header">PP Goals</div>
			<div class="player-stat-header">PP Assists</div>
			<div class="player-stat-header">PP Points</div>
			<div class="player-stat-header">SH Goals</div>
			<div class="player-stat-header">SH Assists</div>
			<div class="player-stat-header">SH Points</div>
		</div>
		<?php foreach ($roster["data"] as $key => $player) { ?>
		<div data-player="<?php echo get_hyphenated($player["playerName"]); ?>" class="player-stat-row">
			<div class="player-stat"><?php echo $player["playerFirstName"]; ?></div>
			<div class="player-stat"><?php echo $player["playerLastName"]; ?></div>
			<div class="player-stat"><?php echo $player["playerPositionCode"]; ?></div>
			<div class="player-stat"><?php echo $player["gamesPlayed"]; ?></div>
			<div class="player-stat"><?php echo $player["points"]; ?></div>
			<div class="player-stat"><?php echo $player["goals"]; ?></div>	
			<div class="player-stat"><?php echo $player["assists"]; ?></div>
			<div class="player-stat"><?php echo $player["penaltyMinutes"]; ?></div>
			<div class="player-stat"><?php echo $player["shots"]; ?></div>	
			<div class="player-stat"><?php echo $player["plusMinus"]; ?></div>
			<div class="player-stat"><?php echo $player["ppGoals"]; ?></div>
			<div class="player-stat"><?php echo ($player["ppPoints"])-($player["ppGoals"]); ?></div>	
			<div class="player-stat"><?php echo $player["ppPoints"]; ?></div>
			<div class="player-stat"><?php echo $player["shGoals"]; ?></div>
			<div class="player-stat"><?php echo ($player["shPoints"])-($player["shGoals"]); ?></div>
			<div class="player-stat"><?php echo $player["shPoints"]; ?></div>								
		</div><?php 
	} // end foreach ?>
	</div>
</div><?php 
}