<?php

require('controler.php');


try {


	if(!empty($_GET['action'])){

		if($_GET['action'] == 'test'){
			afficheTest(); // page permettant la generation aléatoire des immatriculations dans la bdd, accès par l'URL

		}else if($_GET['action'] == 'accueil'){
			session_start();
			if(!empty($_SESSION['pdf'])){
				showHome('facture');
			}else{
				showHome('');
			}	
		}else if($_GET['action'] == 'nos_vehicules'){
			session_start();
			afficheVehicules();

		}else if($_GET['action'] == 'contact'){
			session_start();
			afficheContact();

		}else if($_GET['action'] == 'fidelite'){
			session_start();
			afficheProgFidele();

		}else if($_GET['action'] == 'confidentialite'){
			session_start();
			afficheConfidentialite();

		}else if($_GET['action'] == 'faq'){
			session_start();
			afficheFAQ();

		}else if($_GET['action'] == 'agences'){
			session_start();

			if(!empty($_POST['select_agence'])){
					afficheAgences($_POST['select_agence']);
			}else{
					afficheAgences('');
			}
		}else if($_GET['action'] == 'cnam_car'){
			session_start();
			afficheNotreHistoire();

		}else if($_GET['action'] == 'mentions'){
			session_start();
			afficheMentions();

		}else if($_GET['action'] == 'login' || $_GET['action'] == 'create_login'){			
			identification();

	//----------------------------------------------------------------------------------------------------------------//		

		}else if($_GET['action'] == 'espace_perso'){ //ESPACE COMPTE
			session_start();

			if(!empty($_SESSION['Droit_User']) && $_SESSION['Droit_User'] == 1){
				afficheEspaceFidele($_SESSION['login']);

			}else if(!empty($_SESSION['Droit_User']) && $_SESSION['Droit_User'] == 2){

				if(!empty($_POST['select_agence'])){
					afficheEspaceAdmin($_POST['select_agence'], '', '','' );

				}else if(!empty($_POST['Nom_AG'])){
					afficheEspaceAdmin('', $_POST['Nom_AG'],'' ,'');

				}else if(!empty($_POST['login'])){
					afficheEspaceAdmin('', '', $_POST['login'], $_POST['droit_user']);

				}else{
					afficheEspaceAdmin('', '', '', '');
				}
			}else{
				afficheEspaceId();
			}
	//----------------------------------------------------------------------------------------------------------------//

		}else if ($_GET['action'] == 'vehicules'){ // CHOIX DU VEHICULE
			session_start();
			if(isset($_SESSION['login'])){
				$_SESSION = [
				'login' => $_SESSION['login'], 
				'Droit_User' => $_SESSION['Droit_User']]; // on supprime le devis precèdent si il existe on garde la connexion si elle existe
			}else{
				$_SESSION = [];
			}
			
			$_SESSION['ag_depart'] = $_POST['ag_depart'];
			$_SESSION['ag_arrivee'] = $_POST['ag_arrivee'];
			$_SESSION['date_depart'] = $_POST['date_depart'];
			$_SESSION['date_arrivee'] = $_POST['date_arrivee'];
			$_SESSION['categorie'] = $_POST['categorie'];

			if (!empty($_POST['categorie']) && $_POST['categorie'] == 1){
				selectTourisme($_POST['ag_depart']);

			}else if(!empty($_POST['categorie']) && $_POST['categorie'] == 7){
				selectUtilitaire($_POST['ag_depart']);
				
			}else{
				echo 'Impossible d\'afficher les véhicules';
				echo "<br><a href=\"index.php\">cliquez ici pour retourner à l'accueil</a>";
				?><pre><?php print_r($GLOBALS);?></pre><?php
			}
	//----------------------------------------------------------------------------------------------------------------//

		}else if($_GET['action'] == 'devis'){ // AFFICHE LE DEVIS ET : LE FORMULAIRE OU LE BOUTON IDENTIFIEZ VOUS
			session_start();

			if(empty($_POST['devis']) && empty($_SESSION['devis'])){
				showHome('erreur_devis');

			}else if(empty($_SESSION['devis'])){ //le devis n'existe pas encore

				$devis = calculeDevis($_SESSION['date_depart'], $_SESSION['date_arrivee'], $_POST['Prix_Jour_Mod']);
				$_SESSION['nb_jour'] =$devis[0];
				$_SESSION['prix_devis'] = $devis[1];
				$_SESSION['Marq_Mod'] = $_POST['Marq_Mod'];
				$_SESSION['Nom_Mod'] = $_POST['Nom_Mod'];
				$_SESSION['Nom_Cat'] = $_POST['Nom_Cat'];
				$_SESSION['Nom_Carbu'] = $_POST['Nom_Carbu'];
				$_SESSION['devis'] = $_POST['devis'];
				$_SESSION['Num_Car'] = $_POST['Num_Car'];

					if($_SESSION['devis'] == 1){ // la voiture choisie est une voitures de tourisme
						$_SESSION['Toit_Tou'] = $_POST['Toit_Tou'];
						$_SESSION['Clim_Tou'] = $_POST['Clim_Tou'];
						$_SESSION['Nb_Bagage_Tou'] = $_POST['Nb_Bagage_Tou'];
						$_SESSION['GPS_Tou'] = $_POST['GPS_Tou'];
						$_SESSION['Nb_Place_Tou'] = $_POST['Nb_Place_Tou'];

					}else if($_SESSION['devis'] == 2){ // la voiture choisie est un utilitaire
						$_SESSION['Vol_Ut'] = $_POST['Vol_Ut'];
						$_SESSION['Charg_Ut'] = $_POST['Charg_Ut'];
						$_SESSION['Long_Ut'] = $_POST['Long_Ut'];
						$_SESSION['Larg_Ut'] = $_POST['Larg_Ut'];
						$_SESSION['Haut_Ut'] = $_POST['Haut_Ut'];	
					}
						if(isset($_SESSION['login']) && isset($_SESSION['Droit_User'])){ // LE CLIENT EST LOGGE
							afficheDevisFormulaire($_SESSION['Droit_User'], $_SESSION['login'], '');

						}else{
							afficheDevis();
						}
			}else if(!empty($_SESSION['login']) && !empty($_SESSION['devis']) && isset($_SESSION['Droit_User'])){ // Le devis existe et le client est loggé
				afficheDevisFormulaire($_SESSION['Droit_User'], $_SESSION['login'], '');
				
			}else if(!empty($_SESSION['devis'])){ // Le devis existe et le client est pas loggé
				afficheDevis();
				
			}else{
				showHome('erreur_devis');
			}
	//----------------------------------------------------------------------------------------------------------------//

		}else if($_GET['action'] == 'identification_paiement'){ // AFFICHE SOIT L'ESPACE COMPTE POUR S'IDENTIFIER SOIT L'ESPACE DE PAIEMENT SI DEJA IDENTIFIE
			session_start();

			if(isset($_SESSION['login'])){

				preg_match("#^[a-zA-Zàâéèëêïîôùüçœ\'’ -]{2,25}$#", $_POST['Nom'], $resultNom);
				preg_match("#^[a-zA-Zàâéèëêïîôùüçœ\'’ -]{2,25}$#", $_POST['Prenom'], $resultPrenom);
				preg_match("#^[a-zA-Zàâéèëêïîôùüçœ\'’ -]{2,25}$#", $_POST['ville'], $resultVille);
				preg_match("#^[a-zA-Z0-9àâéèëêïîôùüçœ\'’ ._ ,]{5,60}$#", $_POST['voie'], $resultVoie);
				preg_match("#^0[1-9]([-. ]?[0-9]{2}){4}$#", $_POST['Num_Tel'], $resultTel);
				preg_match("#^[0-9]{5}$#", $_POST['cp'], $resultCP);


				if(!empty($resultNom) && !empty($resultPrenom) && !empty($resultVille) && !empty($resultVoie) && !empty($resultTel) && !empty($resultCP)){

					if(!empty($_POST['CGU'])){

						$_SESSION['Nom'] = mb_strtoupper($_POST['Nom']);
						$_SESSION['Prenom'] = mb_strtoupper($_POST['Prenom']);	
						$_SESSION['ville'] = mb_strtoupper($_POST['ville']);	
						$_SESSION['voie'] = mb_strtoupper($_POST['voie']);	
						$_SESSION['Num_Tel'] = $_POST['Num_Tel'];
						$_SESSION['cp'] = $_POST['cp'];		
						$_SESSION['Civ'] = mb_strtoupper($_POST['Civ']);


						if($_SESSION['Droit_User'] == 0){
							$_SESSION['fidele'] = $_POST['fidele'];
							affichePagePaiement();

						}else{
							affichePagePaiement();
						}
					}else{
						header('Location: index.php?action=devis');
					}
				}else{
					$erreur_formulaire = true;
					afficheDevisFormulaire($_SESSION['Droit_User'], $_SESSION['login'], $erreur_formulaire);
				}
			}else{
				afficheEspaceId();
			}

	//----------------------------------------------------------------------------------------------------------------//

		}else if($_GET['action'] == 'validation_paiement'){
			afficheValidationPaiement();

		}else if($_GET['action'] == 'deconnexion'){
			deconnexion();		
		}
		else if($_GET['action'] == 'pdf'){
			createPdf();		
		}
	}else{
		showHome('');
	}

}catch(Exception $e) {
    // $errorMessage = $e->getMessage();
    require('views/errorView.php');
}

