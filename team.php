<?php
include_once "resources/get_teaminfo.php";
include_once "resources/get_roster.php";

if($teamId = isset($_GET["teamId"])) { 
	$teamId = $_GET["teamId"]; 
}else { $teamId = '24'; } 
if($seasonId = isset($_GET["seasonId"])) { 
	$seasonId = $_GET["seasonId"]; 
}else { $seasonId = '20152016'; } 

$teaminfo = get_teaminfo($teamId, $seasonId);

$teamlogo = 'http://cdn.nhle.com/nhl/images/logos/teams/'.$teaminfo[$teamId]['abbreviation'].'_logo.svgz';
$teamname = $teaminfo[$teamId]["name"];
$teamcolors = team_colors($teamname);
get_head($teamname);
?>

<body>
<?php
	if(count($teamcolors) == '3') {
	include "resources/colorswitch/three.php";
	}elseif(count($teamcolors) == '4'){
	include "resources/colorswitch/four.php";
	}elseif(count($teamcolors) == '5'){
	include "resources/colorswitch/five.php";
	}else{
	include "resources/colorswitch/two.php";
} ?>
<header class="team">
		<div class="team-info">
		<h1 class="team-name"><?php echo $teamname ; ?></h1>
		<div>
			<h6 class="team-info-bio"><span class="label">Arena: </span><?php echo $teaminfo[$teamId]['venue']['name']; ?></h6>
			<h6 class="team-info-bio"><span class="label">Conference: </span><?php echo $teaminfo[$teamId]['conference']['name']; ?></h6>
			<h6 class="team-info-bio"><span class="label">Division: </span><?php echo $teaminfo[$teamId]['division']['name']; ?></h6>
		</div>
	</div>
	<img class="single-team-logo" src="<?php echo $teamlogo; ?>" alt="<?php echo $teamname; ?>">
</header>

<div class="stripes-top"></div>

<section class="teaminfo" id="team-roster">
  <h2 class="section-title">Team roster</h2>
  <?php get_team_roster_html($seasonId, $teamId);?>
</section>

<section class="teaminfo" id="team-leaders">
<h2 class="section-title">Team Stats</h2>
<?php get_current_roster_stats_html($seasonId, $teamId); ?>
</section>

<section class="teaminfo" id="team-seasons">
<h2 class="section-title">Historical Stats</h2>
<?php get_teamstats($teamId); ?>
</section>

<?php get_footer(); ?>
</body>