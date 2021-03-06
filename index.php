<?php 
include_once "functions.php";
include_once "resources/get_teaminfo.php";
include_once "resources/get_standings.php";

$pageTitle = "Welcome to Numbers & Stuff";
get_head("$pageTitle"); ?>

<body>
<header><?php echo $pageTitle; ?></header>
<div class="stripes-top"></div>
  <section class="standings">
  	<h2 class="section-title">Standings</h2>
  	<?php get_standings_by_division(); ?>
  </section>

  <section class="team-pucks">
	<h2 class="section-title">Teams</h2>
  	<?php get_team_links();?>
  </section>

<?php get_footer(); ?>
</body>