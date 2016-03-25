<?php 
include_once "resources/get_playerinfo.php";

if($playerId = isset($_GET["playerId"])) { 
	$playerId = $_GET["playerId"]; 
}else { $playerId = '8447400'; } 

$playerinfo = get_playerinfo($playerId);

$pageTitle = $playerinfo['fullName'].' - '.$playerinfo['currentTeam'];
get_head("$pageTitle"); ?>



<body>
<header>
	<?php
	$teamname = $playerinfo['currentTeam'];
	$teamcolors = team_colors($teamname);
	if(count($teamcolors) == '3') {
	include "resources/colorswitch/three.php";
	}elseif(count($teamcolors) == '4'){
	include "resources/colorswitch/four.php";
	}elseif(count($teamcolors) == '5'){
	include "resources/colorswitch/five.php";
	}else{
	include "resources/colorswitch/two.php";
	} ?>
	<img class="player-banner-bg " alt="<?php echo $playerinfo['fullName'];?> Header Background" src="<?php get_player_header_bg($playerinfo['id']); ?>">
		<div class="player-banner grid">
			<?php 	// is player a rookie?
				if ($playerinfo['rookie'] == '1') { // if player is a rookie, add rookie icon to player banner ?>
					<img class="player-is-rookie" alt="Player Is A Rookie" src="css/images/rookie.png" height="150" width="150">
			<?php } // end is player a rookie?
				get_player_headshot($playerinfo);
			?>
		</div>
</header>
<section class="player-info">
	<div class="player-top-info">
		<div class="player-name-team"  data-player-team="<?php echo $playerinfo['currentTeam']; ?>">
		  <?php echo "<h1 class='player-name' data-player-name='".$playerinfo['fullName']."'>".$playerinfo['fullName']."</h1>"; //get player name ?>			
		  <?php if (isset($playerinfo["currentTeam"])) { //Get Player Team
		  		echo "<h3 class='team-name' data-player-team='".$playerinfo['currentTeam']."'><a href='../nhl-stats/team.php?'>".$playerinfo['currentTeam']."</a></h3>"; 			
		  } else {
		  		echo "<h3 class='team-name'>&nbsp;</h3>";
		  } ?>
		</div>

		<div class="player-physical">
		  <?php echo "<h3 class='player-height m-1of3'>".$playerinfo['height']."</h3>"; //get player hieght ?>			
		  <?php echo "<h3 class='player-weight m-1of3'>".$playerinfo['weight']." lbs</h3>"; //get player weight ?>
		  <?php //get player dominant hand
			if ($playerinfo['shootsCatches']=='R') {
			  echo "<h3 class='player-hand m-1of3'>Right Handed</h3>";
			}elseif ($playerinfo['shootsCatches']=='L') {
			  echo "<h3 class='player-hand m-1of3'>Left Handed</h3>";
			} //end get player dominant hand?>			
		</div>

		<div class="player-num-pos ">
		  <?php echo "<h3 class='player-number'>".$playerinfo['primaryNumber']."</h3>"; //get player number ?>			
		  <?php echo "<h3 class='player-position'>".$playerinfo['primaryPosition']['name']."</h3>"; //get player position ?>			
		</div>

	</div>

	<div class="player-bottom-info">
		<div class="player-birthdate "> <?php
			echo "<h3 class='player-info-label'>Birthdate: </h3>";
			echo "<h3 class='player-dob'>".$playerinfo['birthDate']."</h3>"; ?> 
		</div>

		<div class="player-age"> <?php
			if (isset($playerinfo['currentAge'])) {
				echo "<h3 class='player-info-label'>Age: </h3>";				
				echo "<h3 class='player-years-old'>".$playerinfo['currentAge']."</h3>";
			} ?> 
		</div>	

		<div class="player-birthplace"> <?php
			echo "<h3 class='player-info-label'>Birthplace: </h3>";				
			echo "<h3 class='player-birthplace-city'>".$playerinfo['birthCity'].", ".$playerinfo['birthCountry']."</h3>";				?> 
		</div> 
	</div>
</section>

<div class="stripes-top"></div>	

<section class="player-stats" id="player-career-totals">
  	<h2 class="section-title">Career Totals</h2>
    <?php get_player_career_totals($playerinfo); ?>
</section>

<section class="player-stats" id="player-season-splits">	
  	<h2 class="section-title">Season Splits</h2>
  	<?php season_splits_html($playerinfo); ?>
</section>

<?php get_footer(); ?>
</body>