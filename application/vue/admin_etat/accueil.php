<?php
  if(isset($_SESSION["pseudo"])){
    echo "session succes";
    $op = new Operation();
	  $test= $op->getCountry();
    var_dump($test);

    
  }else{
    echo "session failled";
  }

 ?>
