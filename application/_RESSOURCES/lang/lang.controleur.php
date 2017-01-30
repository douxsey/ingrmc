<?php
	$lang_defined = ["fr","en"];
	if(isset($lang)){

		if(in_array($lang,$lang_defined)){
			$including_lang = $path_ref_lang."/".$lang;
		}else{
			$including_lang = $path_ref_lang."/".$default_lang;
		}
	}else{
		$including_lang = $path_ref_lang."/".$default_lang;
	}
	require_once($including_lang.".php");
?>
