<?php 
include_once "functions.php";
include_once "resources/curl_session.php";

function get_teaminfo($teamId, $seasonId){
// get team info w/ CURL	
$teams = curl_session('teams', $teamId, $seasonId);

/*?><pre><?php var_dump($teams); ?></pre><?php*/
  // set variable $teaminfo as empty array
  $teaminfo = array();
	foreach ($teams['teams'] as $key => $value) {
		$teaminfo[$value['id']] = $value;
	}	
  return $teaminfo;
}


function get_teamstats($teamId){
	$statsTeamSeason = curl_session_stats($teamId);
		//Sort seasons by year
		$seasonsort = array();
		foreach ($statsTeamSeason as $key => $value) {
			//$seasonsort[$key] = $value;
			$seasonsort[$value['seasonId']] = $value;
			krsort($seasonsort);
		} 
		?>
		<div class="stats-labels">
			<span class="stats-label" id="season-title-label">Year</span>
			<span class="stats-label center-stats" id="season-games-label">Games</span>
			<span class="stats-label center-stats" id="season-points-label">Points</span>
			<span class="stats-label center-stats" id="season-wins-label">Wins</span>
			<span class="stats-label center-stats" id="season-losses-label">Losses</span>
			<span class="stats-label center-stats" id="season-otloss-tie-label">OT Loss*</span>
			<span class="stats-label center-stats" id="season-more-label">&nbsp;</span>
		</div>
		<?php
		foreach ($seasonsort as $season => $stats) {	
			if ($stats != NULL){ ?>
				<div class="season" id="<?php echo $stats['seasonId']; ?>"> 

					<div class="season-stats season-stats-upper">
						<div class="season-stats-total" id="season-title-<?php get_clean_year($stats['seasonId']); ?>"><a href="team.php?seasonId=<?php echo $stats['seasonId'];?>&teamId=<?php echo $teamId;?>"><h3><?php get_clean_year($stats['seasonId']); ?></h3></a></div>
						<div class="season-stats-total center-stats" id="season-games-<?php get_clean_year($stats['seasonId']); ?>"><?php echo $stats["gamesPlayed"];?></div>
						<div class="season-stats-total center-stats" id="season-points-<?php get_clean_year($stats['seasonId']); ?>"><?php echo $stats["points"];?></div>
						<div class="season-stats-total center-stats" id="season-wins-<?php get_clean_year($stats['seasonId']); ?>"><?php echo $stats["wins"];?></div>
						<div class="season-stats-total center-stats" id="season-losses-<?php get_clean_year($stats['seasonId']); ?>"><?php echo $stats["losses"];?></div>
						<?php // check if season used ties or loser point
						if ($stats['seasonId'] <= '20042005') { ?>
							<div class="season-stats-total center-stats" id="season-ties-<?php get_clean_year($stats['seasonId']); ?>"><?php echo $stats["ties"];?></div>
						<?php }else{ ?>
							<div class="season-stats-total center-stats" id="season-otlosses-<?php get_clean_year($stats['seasonId']); ?>"><?php echo $stats["otLosses"];?></div>
						<?php } ?>
						<div class="season-stats-total center-stats" id="season-more-stats-<?php get_clean_year($stats['seasonId']); ?>">
						  <a class="see-more" onclick="toggle_visibility('<?php echo $stats['seasonId']; ?>-expand')" ></a>
						</div>
					</div>

					<div class="season-stats-lower stats-table" id="<?php echo $stats['seasonId']; ?>-expand">
						<div class="stats-row">
							<div class="stats-record" id="goalsagainst-<?php echo $stats['seasonId']; ?>">Goals For: <span class="stats-record-stat"><?php echo $stats["goalsFor"];?></span></div>
							<div class="stats-record" id="goalsafor-<?php echo $stats['seasonId']; ?>">Goals Against: <span class="stats-record-stat"><?php echo $stats["goalsAgainst"];?></span></div>
							<div class="stats-record" id="shotsforpergame-<?php echo $stats['seasonId']; ?>">Shots For Per Game: <span class="stats-record-stat"><?php echo round($stats["shotsForPerGame"], 2);?></span></div>
							<div class="stats-record" id="pkpctg-<?php echo $stats['seasonId']; ?>">Penalty Kill: <span class="stats-record-stat"><?php echo round($stats["pkPctg"], 2);?>%</span></div>		
						</div>
						<div class="stats-row">
							<div class="stats-record" id="goalsagainstpergame-<?php echo $stats['seasonId']; ?>">Goals For Per Game: <span class="stats-record-stat"><?php echo round($stats["goalsForPerGame"], 2);?></span></div>
							<div class="stats-record" id="goalsforpergame-<?php echo $stats['seasonId']; ?>">Goals Against Per Game: <span class="stats-record-stat"><?php echo round($stats["goalsAgainstPerGame"], 2);?></span></div>						
							<div class="stats-record" id="shotsagainstpergame-<?php echo $stats['seasonId']; ?>">Shots Against Per Game: <span class="stats-record-stat"><?php echo round($stats["shotsAgainstPerGame"], 2);?></span></div>
							<div class="stats-record" id="pppctg-<?php echo $stats['seasonId']; ?>">Power Play: <span class="stats-record-stat"><?php echo round($stats["ppPctg"], 2);?>%</span></div>
						</div>

					</div>

				</div> <?php 
			
			} 
		}
		?><?php
}

?>