<?php 
	if(isset($_GET["page"])){
	
		$page = secure($_GET["page"]);
	
	}else{
		header("Location:index.php?page="$default_page);
	}
?>