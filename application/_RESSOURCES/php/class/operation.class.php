<?php
/**
 *
 */
class Operation extends DATABASE
{
  private $test;
  private $criteres;
    function __construct()
    {
      DATABASE::getConnection();
    }

  public function test(){
    $test = DATABASE::getMatchData("pays",[["id","2"],["code","8"]]);
    $this->test = $test;
    return $test;
  }

  public function getCriteres(){
    $this->criteres = DATABASE::getAllMatchData("criteres",[["etat","1"]]);
    return $this->criteres;
  }

  public function getSousCriteres(){
    return DATABASE::getAllMatchData("sous_criteres",[["etat",1]]);
  }

  public function getSousCritereOfCritere($j){
    return DATABASE::getAllMatchData("sous_criteres",[["id_critere",$j]]);
  }

  public function getCountry(){
    return DATABASE::getAllMatchData("pays",[["etat","1"]]);
  }

  public function getCurrentCountry($id){
    return DATABASE::getMatchData("pays",[["id",$id],["etat","1"]]);
  }

  public function getNbrColumnOfTable(){
    if(!isset($this->criteres)){
      $this->criteres = $this->getCriteres();
    }
    return c_count($this->criteres);
  }

  public function getNbrLineOfTable(){
    $nbrLines=0;
    $nbrcln=$this->getNbrColumnOfTable();
    for($i=0;$i<$nbrcln;$i++){
      $idCrOfCurrentSCR = $this->criteres[$i]["id"];
      $tcri = c_count($this->getSousCritereOfCritere($idCrOfCurrentSCR));
      if($tcri>$nbrLines){
        $nbrLines = $tcri;
      }
    }
    return $nbrLines;
  }

 public function getEvaluationINGRMC($val){
   if($val==0){
     return "Neutre";
   }
   if($evaluation = DATABASE::getMatchData("evaluation_ingrmc",[["min_val",$val],["max_val",$val]],"performance_de_gouvernance",["<=",">"]))
   {
     return $evaluation["performance_de_gouvernance"];
   }else {
     return "UNDEFINED";
   }

 }


 public function getAppreciationSousCritaire($val){
   if($val==0){
     return "Neutre";
   }
   if($performance = DATABASE::getMatchData("appreciation_sous_critaire",[["min_val",$val],["max_val",$val]],"appreciation",["<=",">"])){
     return $performance["appreciation"];
   }else{
     return "UNDEFINED";
   }
 }


}


 ?>
