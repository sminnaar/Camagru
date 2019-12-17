<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=PROOT?>css/custom.css">
    <link rel="icon" href="img/icons/Camagru_SLeMeem.png"/>

    <title><?=$this->siteTitle();?></title>
	<?=$this->content('head');?>
  </head>
  <body class="black">
	<?php  include('header.php'); ?>
		<?=$this->content('body'); ?>
	<?php include('footer.php'); ?>
  </body>
</html>
