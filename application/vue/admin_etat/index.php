<?php
	session_start();
	if(isset($_GET["page"])){
		$page = htmlspecialchars($_GET["page"]);
		require_once("header.php");

		$thisSection ="admin_etat";

		$pages = scandir("./");
		$exectionPage = ["header.php","footer.php","index.php"];
		if(!in_array($page.".php",$exectionPage) AND in_array($page.".php",$pages) ){
			require_once($page.".php");
			if(file_exists("../../controleur/".$thisSection."/".$page.".func.php")){
				require_once("../../controleur/".$thisSection."/".$page.".func.php");
			}
		}else{
			header("Location:index.php?page=".$default_page);
		}
		require_once("footer.php");
	}else{
		header("Location:index.php?page=".$default_page);
	}
 ?>
