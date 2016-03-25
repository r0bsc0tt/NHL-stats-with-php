<?php 
$teamcolors = team_colors($teamname);
$colorOne = $teamcolors['colorOne'];
$colorTwo = $teamcolors['colorTwo'];
?>
<script type="text/javascript">
$(document).ready(function() {
jQuery("header, footer, .team-info, .player-info, .team-logo, .season:nth-child(even)").css("background-color", "#<?php echo $colorOne; ?>");	
jQuery(".stripes").css("background-color", "#<?php echo $colorTwo; ?>");
jQuery(".team-name, .team-info, .copyright").css("color", "#<?php echo $colorTwo; ?>");
jQuery(".career-stat").css("color", "#<?php echo $colorOne; ?>")
jQuery(".team-name, .player-name").css("text-shadow", "none");
jQuery(".season:nth-child(even), .player-season:nth-child(even)").css("border", "none");
jQuery(".stripes-top, .season:nth-child(even), .player-season:nth-child(even)").css("border-top-color","#<?php echo $colorTwo; ?>");
jQuery(".stripes-top, .stripes").css("border-bottom-color","#<?php echo $colorOne; ?>");
jQuery(".stripes-bottom, .stripes").css("border-top-color","#<?php echo $colorOne; ?>");
jQuery(".stripes-bottom").css("border-bottom-color","#<?php echo $colorTwo; ?>");											
});
</script>