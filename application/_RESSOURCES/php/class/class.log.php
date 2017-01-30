<?php
  class log extends DATABASE
{

    private $pseudo;
    private $id_compte;
    private $id_personne;
    private $id_acces;

    //creation de la session

     function __construct($pseudo,$password){
      $tables = ["compte","etat_civil","acces"];
      $joinFilter = [["compte.id_etat_civil","etat_civil.id"],["compte.id_acces","acces.id"]];
      $champs = " compte.id as idCompte , compte.pseudo , compte.etat,acces.* , acces.id as idAcess , etat_civil.* , etat_civil.id as idPersonne";
      $filter_array = [["col"=>"compte.pseudo","cond"=>" = ","val"=>$pseudo],
                       ["col"=>"compte.password","cond"=>" = ","val"=>$password],
                       ["col"=>"compte.etat","cond"=>" >= ","val"=>"1"]
                     ];
      if($compte = DATABASE::getInnerData($tables,$joinFilter,$champs,$filter_array,false)){

        $this->pseudo = $compte["pseudo"];
        $this->id_compte = $compte["idCompte"];
        $this->id_personne = $compte["idPersonne"];
        $this->id_acces = $compte["idAcess"];

        $_SESSION["pseudo"] = $this->pseudo;
        $_SESSION["id_compre"] = $this->id_compte;
        $_SESSION["id_personne"] = $this->id_personne;
        $_SESSION["id_acces"] = $this->id_acces;
      }

      return $compte;

    }

    public function reload($pseudo,$password){
      $tables = ["compte","etat_civil","acces"];
      $joinFilter = [["compte.id_etat_civil","etat_civil.id"],["compte.id_acces","acces.id"]];
      $champs = " compte.id as idCompte , compte.pseudo , compte.etat,acces.* , acces.id as idAcess , etat_civil.* , etat_civil.id as idPersonne";
      $filter_array = [["col"=>"compte.pseudo","cond"=>" = ","val"=>$pseudo],
                       ["col"=>"compte.password","cond"=>" = ","val"=>$password],
                       ["col"=>"compte.etat","cond"=>" >= ","val"=>"1"]
                     ];
      if($compte = DATABASE::getInnerData($tables,$joinFilter,$champs,$filter_array,false)){

        $this->pseudo = $compte["pseudo"];
        $this->id_compte = $compte["idCompte"];
        $this->id_personne = $compte["idPersonne"];
        $this->id_acces = $compte["idAcess"];

        $_SESSION["pseudo"] = $this->pseudo;
        $_SESSION["id_compre"] = $this->id_compte;
        $_SESSION["id_personne"] = $this->id_personne;
        $_SESSION["id_acces"] = $this->id_acces;
      }

      return $compte;

    }

    public function start_Session(){
      $sess_started = false;
      if($this->id_compte){
        $_SESSION["pseudo"] = $this->pseudo;
        $_SESSION["id_compre"] = $this->id_compte;
        $_SESSION["id_personne"] = $this->id_personne;
        $_SESSION["id_acces"] = $this->id_acces;
        $sess_started = true;
      }
      return $sess_started;
    }

  }

 ?>
