<?php
	//Definition du path
	$path_including = "../..";
	$path_ref = $path_including."/_RESSOURCES";
	$path_ref_conf = $path_including."/_CONFIG";
	$path_ref_class = $path_including."/_RESSOURCES/php/class";
	$path_conf_lang = $path_including."/_RESSOURCES/lang/lang.controleur.php";
	$path_ref_lang = $path_including."/_RESSOURCES/lang/langue";
	//Inclde des fichiers de configurations
	if(file_exists($path_ref_conf."/conf_var.php")){
			require_once($path_ref_conf."/conf_var.php");
	}else {
			$indefinedFile[] = "configuration des variables";
	}
	if(file_exists($path_ref_conf."/conf_func.php")){
			require_once($path_ref_conf."/conf_func.php");
	}else {
			$indefinedFile[] = "configuration des fonctions";
	}
	if(file_exists($path_ref_conf."/conf_infos_appli.php")){
		require_once($path_ref_conf."/conf_infos_appli.php");
	}else {
		$indefinedFile[] = "configuration de l'application";
	}
	if(file_exists($path_ref_conf."/conf_includer.php")){
		require_once($path_ref_conf."/conf_includer.php");
	}else {
		$indefinedFile[] = "includeur";
	}

	if(isset($indefinedFile)){
		echo "<br/>";
		foreach ($indefinedFile as $indefFile) {
			echo "ERREUR :: {$indefFile}<br/>";
		}
		die();
	}

?>
