<?php 
$teamcolors = team_colors($teamname);
$colorOne = $teamcolors['colorOne'];
$colorTwo = $teamcolors['colorTwo'];
$colorThree = $teamcolors['colorThree'];
?>
<script type="text/javascript">
$(document).ready(function() {
jQuery("header, footer, .team-info, .player-info, .stripes, .team-logo, .season:nth-child(even), .player-season:nth-child(even)").css("background-color", "#<?php echo $colorOne; ?>");
jQuery(".career-stat").css("color",  "#<?php echo $colorOne; ?>")
jQuery(".team-name, .player-name, span.stats-record-stat").css("color", "#<?php echo $colorTwo; ?>");
jQuery(".team-info, .copyright").css("color", "#<?php echo $colorThree; ?>");
jQuery(".stripes-top, .stripes").css("border-top-color","#<?php echo $colorTwo; ?>");
jQuery(".stripes-bottom").css("border-bottom-color","#<?php echo $colorTwo; ?>");
<?php if ($colorThree == 'FFFFFF') { ?>
jQuery(".stripes-top, .stripes").css("border-bottom-color","#<?php echo $colorOne; ?>");
jQuery(".stripes-bottom").css("border-top-color","#<?php echo $colorOne; ?>");
jQuery(".player-name").css("text-shadow", "1px 1px #000, 3px 3px #<?php echo $colorThree; ?>");
<?php }else{ ?>
jQuery(".stripes-top, .stripes, .season:nth-child(even), .player-season:nth-child(even)").css("border-bottom-color","#<?php echo $colorThree; ?>");
jQuery(".stripes-bottom, .season:nth-child(even), .player-season:nth-child(even)").css("border-top-color","#<?php echo $colorThree; ?>");
jQuery(".player-name").css("text-shadow", "1px 1px #000, 3px 3px #<?php echo $colorThree; ?>");
<?php } ?>											
});
</script>