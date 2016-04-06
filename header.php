<?php 
function get_head($pagetitle){ ?>
<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <?php $pathtoproject = 'http://pathToProject.com/'; ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $pathtoproject?>css/style.css" />
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
  <title><?php echo $pagetitle; ?></title>
</head>
<?php }
?>
