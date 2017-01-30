<?php
	class Pays{
		private $id;
		private $pays;
		private $regions;
		private $departements;
		private $lang;
		
		//Constructure
		public function _construct($bdd,$id=null,$pays=null,$tab_format=true){
			$this->id = $id;
			$this->pays;
			switch($tab_format){
				case true:
					$this->regions = array();
					$this->departements = array()
				break;
				case false:
					$this->regions = '';
					$this->departements  = '';
				break;
			}
		}
	
		//recuperation du pays
		
		public function getCountry(){
			if($this->pays){
				return $this->pays;
			}else{
				return null;
			}
		}

		//recuperation de l'id
		
		public function getId(){
			if($this){
				return $this->id;
			}else{
				return 0;
			}
		}
		
		//recuperation des regions d'un pays
		public function getRegions(){
			if($this->pays){
			  
			}else if($this->id){
				//recuperation des 
			}
		}
	
	//recuperation des regions d'un pays
		public function getRegions(){
			if($this->pays){
			  
			}else if($this->id){
				//recuperation des 
			}
		}
	
	
	
	
	
	}


 ?>