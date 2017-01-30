<?php
  /**
   * Gestion des requettes dans la base de donnees
   */
  class DATABASE extends PDO
  {
    static $base =  "ingrmc";
    static $bdd;


    //Connection a la base de donnees
    static function getConnection(){
      try{
         DATABASE::$bdd = new PDO('mysql:host = localhost;dbname='.DATABASE::$base.'','root','');
      }
      catch(Exeption $e)
      {
        die('Erreur :');
      }
    }

    /* Enregistrement des données dans la base de données
        Utilisation : registreToBdd(bdd, table_name, [[champ1,valeur_champ1],[champ2,valeur_champ1],...]);
    */
    function  registreToBdd($bdd,$table,$tabRegisted){
    	$nbrChamp = count($tabRegisted);
    	$realValues = array();
    	$str_insert_column  = "(";
    	$str_values = "VALUES (";
    	$sep = " ";
    	for ($i = 0; $i < $nbrChamp ; $i++)
    	{
    		$str_insert_column .= $sep.trim($tabRegisted[$i][0]);
    		$str_values .= $sep.":valeur".$i;
    		$realValues[":valeur".$i] = $tabRegisted[$i][1];
    		$sep = ",";
    	}
    	$str_values .= " )";
    	$str_insert_column .= " )";
    	$req = $bdd->prepare("INSERT INTO ".$table." ".$str_insert_column.$str_values);
    	if($req->execute($realValues)){
    		return $bdd->lastInsertId();
    	}else{
    		return 0;
    	}
    }

    /*
      Recuperation d'un enter à l'aide d'un identifiant
    */
    public function getInfosLineWithId($table,$champ,$id,$idVal,$all =false){
    	$query = DATABASE::$bdd->prepare("SELECT {$champ} FROM {$table} WHERE {$id} = :id");
    	if($query->execute(array('id' =>$idVal))){
    		if($all)
    			$Infos = $query->fetchAll(PDO::FETCH_ASSOC);
    		else
    			$Infos = $query->fetch(PDO::FETCH_ASSOC);
    		if($Infos)
    			return $Infos;
    		return false;
    	}
    	return false;
    }

    /*
      Recuperation personnalisé
    */

    public function getMatchData($table,$tabData,$champ="*",$operators=array(),$ordre="",$all=false){
      $str_req = "";
      $tempVal = array();
      $sep = '';
      for($i=0;$i< c_count($tabData);$i++) {
        if(c_count($tabData[$i]==2)){
          if($i+1 > c_count($operators)){
            $tempOp = "=";
          }else{
            if(isOperator($operators[$i])){
              $tempOp = $operators[$i];
            }else{
               die("Operateur non pris en charge !!!");
            }
          }

          $str_req .= $sep.$tabData[$i][0]." ".$tempOp." :valeur$i ";
          $tempVal["valeur$i"] = $tabData[$i][1];
          $sep = " AND ";
        }else{
          die("Tableau incorrect: <br/>
            SYNTAXE : [[champ1,donnee1],[champ2,donnee2],...] !!!");
        }
      }
      //Execution de la requette
      $requete = DATABASE::$bdd->prepare("SELECT {$champ} FROM {$table} WHERE ".$str_req." ".$ordre);
      if($requete->execute($tempVal)){
        if($all)
          $Infos = $requete->fetchAll(PDO::FETCH_ASSOC);
        else
          $Infos = $requete->fetch(PDO::FETCH_ASSOC);
        if($Infos)
          return $Infos;
        return false;

      }
    }
    public function getAllMatchData($table,$tabData,$champ="*",$operators=array(),$ordre="",$all=true){
      return $this->getMatchData($table,$tabData,$champ,$operators,$ordre,$all);
    }

    /*
    Vérification dans un base de donnees
    */
    public function verify($table,$tabData,$getQuery = false,$champs = "*"){
      if ($data = $this->getMatchData($table,$tabData,$champs)) {
        if($getQuery){
          return $data;
        }else{
          return true;
        }
      }else{
        return false;
      }
    }

    /*
      Fonction qui recupere les infos d'une table
    */
    public function getAllInfosTable($table,$champ,$ordre=""){
    	$query = DATABASE::$bdd->prepare("SELECT {$champ} FROM {$table} {$ordre}");
    	if($query->execute()){
    			$Infos = $query->fetchAll(PDO::FETCH_ASSOC);
    		if($Infos)
    			return $Infos;
    		return false;
    	}
    	return false;
    }


    /*
      Fonction pour la mise à jour des données
    */
    public function updateBd($table,$champs,$valeurs,$conditionChamp,$conditionValeur)
    {
        $nbChamp = count($champs);
        $str_req = "";
        $arrayVal = array();
        for($i =0 ; $i < $nbChamp; $i++)
        {
            $tempVal = ":valeur".$i;
            $str_req .= $champs[$i]."=".$tempVal."".(($i+1 == $nbChamp)?" ":",");
            $arrayVal[$tempVal] = $valeurs[$i];
        }
      	$tempCondition = ":conditionValeur1";
        $req = DATABASE::$bdd->prepare("UPDATE $table SET ".$str_req." WHERE ".$conditionChamp."=".$tempCondition."") ;
       	$arrayVal[$tempCondition] = $conditionValeur;

        $reqUp = $req->execute($arrayVal);
        $req->closeCursor();
        return $reqUp;
    }



    // filter array format array (array("col"=>"idCommissariat","cond"=>" = ","val" = > 1),array("col"=>"idGrade","cond"=>" < ","val" = > 4));
    public function getInnerData($tables,$joinFilter,$champs,$filter_array,$all=true,$direJoinner = " INNER JOIN ")
    {
        $resultMap = DATABASE::pdo_array_map($filter_array);
        /*$req = $bdd->prepare("SELECT agent.matricule,agent.id,etat_civil.* FROM ".
                              "`agent` INNER JOIN etat_civil ON etat_civil.id = agent.idPersonne $resultMap[req] ")
        */
        $innerJoin = DATABASE::filter_join($tables,$joinFilter,$direJoinner);
        $req = DATABASE::$bdd->prepare("SELECT {$champs} $innerJoin $resultMap[req] ");

        $req->execute($resultMap["mapped_array"]);
    		if ($all)
    		{
    			return $req->fetchAll(PDO::FETCH_ASSOC);
    		}
    		else
    		{

    			return $req->fetch(PDO::FETCH_ASSOC);
    		}
    }
    public function getOuterData($tables,$joinFilter,$champs,$filter_array,$all = false)
    {
    	$resultMap = DATABASE::pdo_array_map($filter_array);
    	/*$req = $bdd->prepare("SELECT agent.matricule,agent.id,etat_civil.* FROM ".
    												"`agent` INNER JOIN etat_civil ON etat_civil.id = agent.idPersonne $resultMap[req] ")
    	*/
    	$innerJoin = DATABASE::filter_join($tables,$joinFilter," LEFT OUTER JOIN ");
    	$req = DATABASE::$bdd->prepare("SELECT {$champs} $innerJoin $resultMap[req] ");

    	$req->execute($resultMap["mapped_array"]);
    	if ($all)
    	{
    		return $req->fetchAll(PDO::FETCH_ASSOC);
    	}
    	else
    	{

    		return $req->fetch(PDO::FETCH_ASSOC);
    	}
    }
    public function filter_join($table,$val,$joinType = " INNER JOIN ")
    {
        //
        $req = "";
        $valCnt = count($val);
        $tableCnt = count($table);
        if ($valCnt > 0 && $tableCnt > 0 )
        {
            $req = " FROM {$table[0]} ";
            $sep = $joinType;
            for ($i=0; $i < $valCnt; $i++) {
                $req .= $sep.$table[$i + 1]." ON ".$val[$i][0]." = ".$val[$i][1];

            }
        }
        return $req;
    }
    public function filter_select($cat,$filter_array,$column_order = "id")
    {
    		/*
    			 filter_array =  array(array("column"=>"","condition"=>"","value"=>""))
    		*/

    		$data = false;

    		$result= DATABASE::pdo_array_map($filter_array);
    		$where = $result["req"];
    		$mapped_array = $result["mapped_array"];
    		$req = "SELECT * FROM $cat $where ORDER BY $column_order DESC";
    		$reponse = DATABASE::$bdd->prepare($req);

    		$reponse->execute($mapped_array);
    		$data = $reponse->fetchAll(PDO::FETCH_ASSOC);

    		return $data;
    }
    public function pdo_array_map($filter_array)
    {
       /*
           filter_array =  array(array("column"=>"","condition"=>"","value"=>""))
           map the given array to a pdo_execute array and a prepared WHERE string
        */
        $taille_filter = count($filter_array);
        $data = false;
        $sql_array = array();
        $where = "WHERE 1";
        $delimiter = " AND ";

        for($i = 0; $i < $taille_filter ;$i++)
        {
            $where .= " $delimiter {$filter_array[$i]["col"]} {$filter_array[$i]["cond"]} :list$i ";
    				$delimiter = (isset($filter_array[$i]["connector"]) AND !empty($filter_array[$i]["connector"]))?$filter_array[$i]["connector"]:" AND ";
            $sql_array["list".$i] = secure($filter_array[$i]["val"]);
        }

        return ["req"=>$where,"mapped_array"=>$sql_array];

    }

  }

 ?>
