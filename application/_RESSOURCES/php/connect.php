<?php
		//connection à la base de données
		try{
			$bdd = new PDO('mysql:host = localhost;dbname=ingrmc','root','');
			}
			catch(Exeption $e)
			{
				die('Erreur :');
			}	
	?>