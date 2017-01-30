<?php
	
	if(file_exists("../../_CONFIG/conf.php")){
		require_once("../../_CONFIG/conf.php");
	}else{
		die("Erreur : CHEMIN INTROUVABLE");
	}
 ?>
<!DOCTYPE>
<html>
	<header>
		<meta charset="UTF-8" />
			<script src="<?php echo $path_ref;?>/js/jquery.min.js"></script>
			<link rel="stylesheet" href="<?php echo $path_ref;?>/libs/bootstrap/css/bootstrap.min.css" />
			<script src="<?php echo $path_ref;?>/libs/bootstrap/js/bootstrap.min.js"></script>
