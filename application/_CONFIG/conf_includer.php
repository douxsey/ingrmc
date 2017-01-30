<?php
require_once($path_ref_class."/DATABASE.class.php");
require_once($path_ref_class."/Operation.class.php");

  switch ($page) {
    case 'login':
        if(file_exists($path_conf_lang)){
            require_once($path_conf_lang);
        }else{
            $indefinedFile[] = "configuration des langues";
        }
        if(file_exists($path_ref_class."/class.log.php")){
          require_once($path_ref_class."/class.log.php");
        }else {
            $indefinedFile[] = "class log";
        }
          break;

    default:
      break;
  }

 ?>
