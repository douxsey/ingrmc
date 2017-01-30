<?php
function c_count($val,$cast = "int"){
  switch ($cast) {
    case 'int':
      return (int)count($val);
    break;
    case 'float':
      return (float)count($val);
    default:
      return (int)count($val);
    break;
  }
}

/*
fonction qui verifi un operateur
*/
function isOperator($op){
  $tabOperator = ["<","<=","=",">",">=","!="];
  if(in_array($op,$tabOperator)){
    return true;
  }else{
    return false;
  }
}

function secure($val,$type="text"){
	switch($type){
		case "text":
			return htmlspecialchars(trim($val));
		break;
		case "int":
			return intval(trim($val));
		break;
		case "float":
			return floatval(trim($val));
		break;
		default:
			return htmlspecialchars(trim($val));
		break;
	}


}
 ?>
