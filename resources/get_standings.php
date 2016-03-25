<?php
include_once "resources/curl_session.php";
function get_standings(){
	$standings = curl_session('standings', '');
	$currentstandings = array();
	$divisons = array();
	foreach ($standings["records"] as $conference => $standings) {
		$currentstandings[$standings["division"]["name"]] = $standings;
	}
	return $currentstandings;
}

function get_divisions(){
	$currentstandings = get_standings();
  	$divisions = array();
  	foreach ($currentstandings as $key => $value) {
  		$divisions[$key] = $key;
  	}
  	return $divisions;
}


function get_standings_by_division(){
	$currentstandings = get_standings();
	$divisions = get_divisions();
	$divisionstandings = array();

	foreach ($currentstandings as $division => $divisionstandings) { ?>

		<div class="division" id="<?php echo $division;?>">
			<h3 class='division-title'><?php echo $division; ?></h3>
			<div class="division-standings stats-table" id="<?php echo $division;?>-table"> 
				<div class="team-records-header">
					<div class="team-records-header-label">Team</div>
					<div class="team-records-header-label">G</div>
					<div class="team-records-header-label">W</div>
					<div class="team-records-header-label">L</div>
					<div class="team-records-header-label">OT</div>
					<div class="team-records-header-label">PTS</div>
				</div> <?php
			foreach ($divisionstandings["teamRecords"] as $key => $value) { ?>

				<div class="team-records stats-row-stripes" id="<?php echo get_hyphenated($value["team"]["name"]);?>">
					<div class="team-record stats-record team-name" id="<?php echo get_hyphenated($value["team"]["name"]);?>-team-name">
						<a href="team.php?teamId=<?php echo $value["team"]["id"];?>"><?php echo $value["team"]["name"];?></a>
					</div>
					
					<div class="team-record stats-record team-games" id="<?php echo get_hyphenated($value["team"]["name"]);?>-team-games"><?php echo $value["gamesPlayed"];?></div>
					<div class="team-record stats-record team-wins" id="<?php echo get_hyphenated($value["team"]["name"]);?>-team-wins"><?php echo $value["leagueRecord"]["wins"];?></div>
					<div class="team-record stats-record team-losses" id="<?php echo get_hyphenated($value["team"]["name"]);?>-team-losses"><?php echo $value["leagueRecord"]["losses"];?></div>
					<div class="team-record stats-record team-ot" id="<?php echo get_hyphenated($value["team"]["name"]);?>-team-ot"><?php echo $value["leagueRecord"]["ot"];?></div>
					<div class="team-record stats-record team-points" id="<?php echo get_hyphenated($value["team"]["name"]);?>-team-points"><?php echo $value["points"];?></div>
				</div><?php
			} //end foreach?>
			</div>

		</div><?php
	}

}



function get_teams_array(){
	$currentstandings = get_standings();
	$allteamsarray = array();

	foreach ($currentstandings as $key => $value) {
  		foreach ($currentstandings[$key] as $divs => $teams) {	
  				if ($divs == "teamRecords") {
  					foreach ($teams as $key => $value) {
  						$allteamsarray[$value["team"]["id"]] = $value["team"]["name"];
  					}
  				}
  		}
  	}
  	return $allteamsarray;	
}

function get_team_links(){
$allteamsarray = get_teams_array();
$teams = curl_session('teams', '');
$allteams = $teams['teams'];
	foreach ($allteams as $team => $value) { ?>
	<a class="logo-links <?php echo strtolower($value['conference']['name']); ?> <?php echo strtolower($value['division']['name']); ?>" id="<?php echo get_hyphenated($value['name']); ?>-puck" href="team.php?teamId=<?php echo $value['id']; ?>">
	  <img class="team-logo" src="<?php echo 'http://cdn.nhle.com/nhl/images/logos/teams/'.$value["abbreviation"].'_logo.svgz'; ?>" alt="<?php echo $value['name']; ?>">
	</a> <?php echo "\n";
	} // end foreach team
}

?>