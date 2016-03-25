<?php
include_once "functions.php";
include_once "resources/curl_session.php";


function get_playerinfo($playerId){
// get player info w/ CURL
$player = curl_session($queryType = 'people', $playerId);
	// set variable $playerinfo as empty array
	$playerinfo = array();
	//parse player information 
		foreach ($player[people][0] as $key => $value) {
			if ($key == 'primaryPosition') {
				$playerinfo[$key] = $value;
			}elseif ($key == 'currentTeam') {
				$playerinfo[$key] = $value[name];
			}elseif ($key == 'active' && $value == '') {
				$playerinfo[$key] = $value;
			}elseif ($key == 'rookie' && $value == ''){
				$playerinfo[$key] = $value;
			}elseif ($key == 'stats') {
				$playerinfo[$key] = $value;

			}else{
				$playerinfo[$key] = $value;
			}
		}
		return $playerinfo;
}

function get_player_headshot($playerinfo){
	$bgUrl = 'https://nhl.bamcontent.com/images/headshots/current/168x168/';
	$file_headers = @get_headers($bgUrl.$playerinfo['id'].'.jpg');
	
	if($file_headers[0] == 'HTTP/1.1 404 Not Found'){ 
	// see if the players header action shot 404's, if yes get default BG ?>
	<img class="player-headshot" alt="<?php echo $playerinfo['fullName'];?> Headshot" src="css/images/default.jpg">
	<? } else{ // if it does not 404 get player action shot ?>
	<img class="player-headshot" alt="<?php echo $playerinfo['fullName'];?> Headshot" src="https://nhl.bamcontent.com/images/headshots/current/168x168/<?php echo $playerinfo['id'];?>.jpg" srcset="https://nhl.bamcontent.com/images/headshots/current/168x168/<?php echo $playerinfo['id'];?>.jpg 200w, https://nhl.bamcontent.com/images/headshots/current/168x168/<?php echo $playerinfo['id'];?>@2x.jpg 400w, https://nhl.bamcontent.com/images/headshots/current/168x168/<?php echo $playerinfo['id'];?>@3x.jpg 600w" sizes="(min-width:640px) 600px, 300px" >
	<?php }
}



function get_player_header_bg($playerId){
	$bgUrl = 'https://nhl.bamcontent.com/images/actionshots/';
	$file_headers = @get_headers($bgUrl.$playerId.'.jpg');
	// see if the players header action shot 404's, if yes get default BG
	if($file_headers[0] == 'HTTP/1.1 404 Not Found'){
	echo 'https://nhl.bamcontent.com/images/arena/default/8.jpg';
	} else{
	// if it does not 404 get player action shot
	echo $bgUrl.$playerId.'.jpg';
	}
}
function get_player_career_totals($playerinfo){
$careerRegularSeason = array();
$stats = $playerinfo['stats'][1][splits][0][stat];
if ($playerinfo['stats'][1]['type']['displayName'] == 'careerRegularSeason') { 
	foreach ($stats as $key => $value) { 
		$careerRegularSeason[$key] = $value;
	} ?>

<div class="career-regular-season-stats">

	<?php if ($playerinfo['primaryPosition']["code"] != "G") {  //PLAYER IS NOT GOALIE  ?>
		
		<div class="career-stat-label-row">
			<?php 
			$sort_stats_by = array('games', 'goals','assists', 'points', 'plusMinus', 'shots', 'shotPct', 'hits', 'blocked', 'shifts', 'gameWinningGoals', 'overTimeGoals', 'powerPlayGoals', 'powerPlayPoints', 'shortHandedGoals', 'shortHandedPoints',  'timeOnIce', 'evenTimeOnIce', 'powerPlayTimeOnIce', 'shortHandedTimeOnIce', 'penaltyMinutes', 'timeOnIcePerGame', 'evenTimeOnIcePerGame', 'powerPlayTimeOnIcePerGame', 'shortHandedTimeOnIcePerGame' );	
			$statsSorted = array_replace(array_flip($sort_stats_by), $careerRegularSeason);
			$i=0;
			foreach ($statsSorted as $key => $value) { 
				$i++;
				if (in_array($key, $sort_stats_by)){

				if ($i%5 == 0) { ?>
					<div id="<?php echo $key; ?>" class="career-stat-holder">
						<p class="career-stat-label"><?php echo convert_camelcase($key); ?></p>
						<p class="career-stat"><?php echo $value; ?></p>
					</div>
					</div><div class="career-stat-label-row"><?php
				}else{?>
						<div id="<?php echo $key; ?>" class="career-stat-holder">
							<p class="career-stat-label"><?php echo convert_camelcase($key); ?></p>
							<p class="career-stat"><?php echo $value; ?></p>
						</div><?php
						} //end if 
					} // end if
				 } //end foreach?>
		</div>

	<?php } else{ //PLAYER IS GOALIE ?>	
		<div class="career-stat-label-row">
			<?php 
			$sort_stats_by = array("games", "gamesStarted", "wins", "losses", "ot", "ties", "shutouts", "saves", "savePercentage", "shotsAgainst", "goalsAgainst", "goalAgainstAverage", "evenShots", "evenSaves", "powerPlayShots", "powerPlaySaves", "shortHandedShots", "shortHandedSaves", "timeOnIce", "timeOnIcePerGame");	
			$statsSorted = array_replace(array_flip($sort_stats_by), $careerRegularSeason);
			$i=0;
			foreach ($statsSorted as $key => $value) { 
				$i++;
				if (in_array($key, $sort_stats_by)){

				if ($i%5 == 0) { ?>
					<div id="<?php echo $key; ?>" class="career-stat-holder">
						<p class="career-stat-label"><?php echo convert_camelcase($key); ?></p>
						<p class="career-stat"><?php echo $value; ?></p>
					</div>
					</div><div class="career-stat-label-row"><?php
				}else{?>
						<div id="<?php echo $key; ?>" class="career-stat-holder">
							<p class="career-stat-label"><?php echo convert_camelcase($key); ?></p>
							<p class="career-stat"><?php echo $value; ?></p>
						</div><?php
						} //end if 
					} // end if
				 } //end foreach?>
		</div>
	<?php
	} // end if goalie?>
</div> <?php 
	}
}

function get_player_stats($playerinfo){
$playerStats = array();
$playerStatsArray = $playerinfo['stats'][0]['splits'];
	foreach ($playerStatsArray as $key => $value) {
		$playerStats[$key] = $value;
	}
	return $playerStats;
}

function season_splits_html($playerinfo){
	if ($playerinfo['primaryPosition']["code"] != "G") {  //PLAYER IS NOT GOALIE  	
			$playerStats = array_reverse (get_player_stats($playerinfo)); ?> 
			<div class="player-stats-labels">
				<div class="player-stats-label" id="season-id-label">Season</div>
			  	<div class="player-stats-label" id="season-league-label">League</div>
			  	<div class="player-stats-label" id="season-team-label">Team</div>
			  	<div class="player-stats-label center-stats" id="season-games-label">Games</div>
			  	<div class="player-stats-label center-stats" id="season-goals-label">Goals</div>
			  	<div class="player-stats-label center-stats" id="season-assists-label">Assists</div>
			  	<div class="player-stats-label center-stats" id="season-points-label">Points</div>
			  	<div class="player-stats-label center-stats" id="season-pim-label">PIM</div>
			  	<div class="player-stats-label center-stats" id="season-more-label">&nbsp;</div>
			</div>
			<?php foreach ($playerStats as $season => $stats) { $uniqueSeasonId = $stats["season"].'-'.get_clean_league($stats["league"]["name"]).'-'.get_hyphenated($stats["team"]["name"]); ?>
			<div class="player-season" id="<?php echo $uniqueSeasonId; ?>">
			  <div class="player-season-top-stats">
				<div class="player-season-record season-id" id="<?php echo $uniqueSeasonId; ?>-id"><?php echo get_clean_year($stats["season"]); ?></div>
				<div class="player-season-record season-league" id="<?php echo $uniqueSeasonId; ?>-league"><?php echo get_clean_league($stats["league"]["name"]); ?></div>
				<div class="player-season-record season-team" id="<?php echo $uniqueSeasonId; ?>-team">
					<?php if ($stats["league"]["name"] == "National Hockey League") {?>
						<a href="team.php?teamId=<?php echo $stats["team"]["id"];?>&seasonId=<?php echo $stats["season"];?>"><?php echo $stats["team"]["name"]; ?></a>
					<?php } else { echo $stats["team"]["name"]; }?>
				</div>
				<div class="player-season-record season-games center-stats" id="<?php echo $uniqueSeasonId; ?>-games"><?php echo $stats["stat"]["games"]; ?></div>
				<div class="player-season-record season-goals center-stats" id="<?php echo $uniqueSeasonId; ?>-goals"><?php echo $stats["stat"]["goals"]; ?></div>
				<div class="player-season-record season-assists center-stats" id="<?php echo $uniqueSeasonId; ?>-assists"><?php echo $stats["stat"]["assists"]; ?></div>
				<div class="player-season-record season-points center-stats" id="<?php echo $uniqueSeasonId; ?>-points"><?php echo $stats["stat"]["points"]; ?></div>
				<div class="player-season-record season-pim center-stats" id="<?php echo $uniqueSeasonId; ?>-pim"><?php echo $stats["stat"]["pim"]; ?></div>
				<?php if ($stats["league"]["name"] == "National Hockey League") {?>
				<div class="player-season-record season-see-more center-stats"  id="<?php echo $uniqueSeasonId; ?>-see-more">
				<a class="see-more" onclick="toggle_stats('<?php echo $uniqueSeasonId; ?>-expand')" ></a>
				</div><?php }else{?>
				<div class="player-season-record season-see-more">&nbsp;</div><?php } //end if NHL ?>
			  </div>
					
			<?php 
			//expand stats if leauge is NHL and stats area available
			if ($stats["league"]["name"] == "National Hockey League") { ?>
			  <div class="player-season-bottom-stats" id="<?php echo $uniqueSeasonId; ?>-expand">
				<div class="player-seasons-expand">
					<div class="player-seasons-expand-row">
						<div class="player-season-record-stat left-stats">Plus/Minus: <span><?php echo $stats["stat"]["plusMinus"]; ?></span></div>
						<div class="player-season-record-stat center-stats">Shots: <span><?php echo $stats["stat"]["shots"]; ?></span></div>
						<div class="player-season-record-stat center-stats">Shot %: <span><?php echo $stats["stat"]["shotPct"]; ?></span></div>
						<div class="player-season-record-stat right-stats">OT Goals:  <span><?php echo $stats["stat"]["overTimeGoals"]; ?></span></div>
						<div class="player-season-record-stat right-stats">Game Winning Goals: <span><?php echo $stats["stat"]["gameWinningGoals"]; ?></span></div>
					</div>
				</div>

				<div class="player-seasons-expand">
					<div class="player-seasons-expand-row">
						<div class="player-season-record-stat left-stats">Shifts: <span><?php echo $stats["stat"]["shifts"]; ?></span></div>
						<div class="player-season-record-stat center-stats">Blocked: <span><?php echo $stats["stat"]["blocked"]; ?></span></div>
						<div class="player-season-record-stat center-stats">Hits: <span><?php echo $stats["stat"]["hits"]; ?></span></div>
						<div class="player-season-record-stat right-stats">Total TOI:  <span><?php echo $stats["stat"]["timeOnIce"]; ?></span></div>				
						<div class="player-season-record-stat right-stats">Even TOI:  <span><?php echo $stats["stat"]["evenTimeOnIce"]; ?></span></div>
					</div>
				</div>

				<div class="player-seasons-expanded-title"><h5>Powerplay</h5></div>
				<div class="player-seasons-expand" id="powerplay-splits-<?php echo $uniqueSeasonId; ?>">
					<div class="player-season-record-stat">PP Points:  <span><?php echo $stats["stat"]["powerPlayPoints"]; ?></span></div>
					<div class="player-season-record-stat">PP Goals:  <span><?php echo $stats["stat"]["powerPlayGoals"]; ?></span></div>
					<div class="player-season-record-stat">PP Assists:  <span><?php echo ($stats["stat"]["powerPlayPoints"])-($stats["stat"]["powerPlayGoals"]); ?></span></div>
					<div class="player-season-record-stat">PP TOI:  <span><?php echo $stats["stat"]["powerPlayTimeOnIce"]; ?></span></div>
				</div>

				<div class="player-seasons-expanded-title"><h5>Shorthanded</h5></div>
				<div class="player-seasons-expand" id="shorthanded-splits-<?php echo $uniqueSeasonId; ?>">
					<div class="player-season-record-stat">SH Points:  <span><?php echo $stats["stat"]["shortHandedPoints"]; ?></span></div>
					<div class="player-season-record-stat">SH Goals:  <span><?php echo $stats["stat"]["shortHandedGoals"]; ?></span></div>
					<div class="player-season-record-stat">SH Assists:  <span><?php echo ($stats["stat"]["shortHandedPoints"])-($stats["stat"]["shortHandedGoals"]); ?></span></div>
					<div class="player-season-record-stat">SH TOI:  <span><?php echo $stats["stat"]["shortHandedTimeOnIce"]; ?></span></div>
				</div>
			  </div>
			<?php } // end expanded stats for NHL ?>
			</div>
			<?php } // end foreach 
	}else{ //PLAYER IS  A GOALIE
			$playerStats = array_reverse (get_player_stats($playerinfo));?> 
			<div class="player-stats-labels">
				<div class="player-stats-label" id="season-id-label">Season</div>
			  	<div class="player-stats-label" id="season-league-label">League</div>
			  	<div class="player-stats-label" id="season-team-label">Team</div>
			  	<div class="player-stats-label center-stats" id="season-games-label">Games</div>
			  	<div class="player-stats-label center-stats" id="season-goals-label">Wins</div>
			  	<div class="player-stats-label center-stats" id="season-assists-label">Losses</div>
			  	<div class="player-stats-label center-stats" id="season-points-label">Save %</div>
			  	<div class="player-stats-label center-stats" id="season-pim-label">GAA</div>
			  	<div class="player-stats-label center-stats" id="season-more-label">&nbsp;</div>
			</div>
			<?php foreach ($playerStats as $season => $stats) { $uniqueSeasonId = $stats["season"].'-'.get_clean_league($stats["league"]["name"]).'-'.get_hyphenated($stats["team"]["name"]); ?>
			<div class="player-season" id="<?php echo $uniqueSeasonId; ?>">
			  <div class="player-season-top-stats">
				<div class="player-season-record season-id" id="<?php echo $uniqueSeasonId; ?>-id"><?php echo get_clean_year($stats["season"]); ?></div>
				<div class="player-season-record season-league" id="<?php echo $uniqueSeasonId; ?>-league"><?php echo get_clean_league($stats["league"]["name"]); ?></div>
				<div class="player-season-record season-team" id="<?php echo $uniqueSeasonId; ?>-team">
					<?php if ($stats["league"]["name"] == "National Hockey League") {?>
						<a href="team.php?teamId=<?php echo $stats["team"]["id"];?>&seasonId=<?php echo $stats["season"];?>"><?php echo $stats["team"]["name"]; ?></a>
					<?php } else { echo $stats["team"]["name"]; }?>
				</div>
				<div class="player-season-record season-games center-stats" id="<?php echo $uniqueSeasonId; ?>-games"><?php echo $stats["stat"]["games"]; ?></div>
				<div class="player-season-record season-goals center-stats" id="<?php echo $uniqueSeasonId; ?>-wins"><?php echo $stats["stat"]["wins"]; ?></div>
				<div class="player-season-record season-assists center-stats" id="<?php echo $uniqueSeasonId; ?>-losses"><?php echo $stats["stat"]["losses"]; ?></div>
				<div class="player-season-record season-points center-stats" id="<?php echo $uniqueSeasonId; ?>-savepct"><?php echo $stats["stat"]["savePercentage"]; ?></div>
				<div class="player-season-record season-pim center-stats" id="<?php echo $uniqueSeasonId; ?>-gaa"><?php echo $stats["stat"]["goalAgainstAverage"]; ?></div>
				<?php if ($stats["league"]["name"] == "National Hockey League") {?>
				<div class="player-season-record season-see-more center-stats"  id="<?php echo $uniqueSeasonId; ?>-see-more">
				<a class="see-more" onclick="toggle_stats('<?php echo $uniqueSeasonId; ?>-expand')" ></a>
				</div><?php }else{?>
				<div class="player-season-record season-see-more">&nbsp;</div><?php } //end if NHL ?>
			  </div>
					
			<?php 
			//expand stats if leauge is NHL and stats area available
			if ($stats["league"]["name"] == "National Hockey League") { ?>
			  <div class="player-season-bottom-stats" id="<?php echo $uniqueSeasonId; ?>-expand">
				<div class="player-seasons-expand">
					<div class="player-seasons-expand-row">
						<?php // check if season used ties or OTloser
						if ($stats['season'] <= '20042005') { ?>
						<div class="player-season-record-stat left-stats">Ties: <span><?php echo $stats["stat"]["ties"]; ?></span></div>
						<?php }else{ ?>
						<div class="player-season-record-stat left-stats">OT: <span><?php echo $stats["stat"]["ot"]; ?></span></div>						
						<?php } ?>
						<div class="player-season-record-stat right-stats">Shutouts:  <span><?php echo $stats["stat"]["shutouts"]; ?></span></div>
						<div class="player-season-record-stat left-stats">Saves: <span><?php echo $stats["stat"]["saves"]; ?></span></div>
						<div class="player-season-record-stat center-stats">Shots Against: <span><?php echo $stats["stat"]["shotsAgainst"]; ?></span></div>
						<div class="player-season-record-stat center-stats">Goals Against: <span><?php echo $stats["stat"]["goalsAgainst"]; ?></span></div>
						<div class="player-season-record-stat right-stats">Time on Ice: <span><?php echo $stats["stat"]["timeOnIce"]; ?></span></div>
					</div>
				</div>

				<div class="player-seasons-expand">
					<div class="player-seasons-expand-row">
						<div class="player-season-record-stat">Even Shots:  <span><?php echo $stats["stat"]["evenShots"]; ?></span></div>
						<div class="player-season-record-stat">Even Saves:  <span><?php echo $stats["stat"]["evenSaves"]; ?></span></div>
						<div class="player-season-record-stat">PP Shots:  <span><?php echo $stats["stat"]["powerPlayShots"]; ?></span></div>
						<div class="player-season-record-stat">PP Saves:  <span><?php echo $stats["stat"]["powerPlaySaves"]; ?></span></div>
						<div class="player-season-record-stat">SH Shots:  <span><?php echo $stats["stat"]["shortHandedShots"]; ?></span></div>
						<div class="player-season-record-stat">SH Saves:  <span><?php echo $stats["stat"]["shortHandedSaves"]; ?></span></div>
					</div>
				</div>

			  </div>
			<?php } // end expanded stats for NHL ?>
			</div>
			<?php } // end foreach 
	} 
}