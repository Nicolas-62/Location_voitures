<?php
require ('model.php');

// cette fonction devrait être dans model.php :

function calculeDevis($date_depart, $date_arrivee, $prix_jour_mod)
{
    $nb_jour = nb_jour($date_depart, $date_arrivee); 
    $prix_devis = devis($prix_jour_mod , $nb_jour);
    return $devis = [$nb_jour, $prix_devis ];
} 

function showHome($message) {
	$message_accueil = getMessage($message);
    $agence_list = getAgence();
    // $sticky_footer = true;
    $title = 'Cnam Car Location de voitures';
    require ('./components/header.php');
    require ('./components/navbar.php');
    require ('./views/home.php');
    require ('./components/footer.php');
}
function selectTourisme($ag_depart)
{
	$tourisme_query = getTourisme($ag_depart);
    $title = 'Voitures de trourisme';
    require ('./components/header.php');
    require ('./components/navbar.php');
	require ('./views/vehicules/tourisme.php');
    require('./components/footer.php');
}
function selectUtilitaire($ag_depart)
{
	$utilitaire_query = getUtilitaire($ag_depart);
    $title = 'Utilitaires';
    require ('./components/header.php');
    require ('./components/navbar.php');
    require ('./views/vehicules/utilitaires.php');
    require('./components/footer.php');
}

function afficheDevisFormulaire($droit_user, $login, $erreur) {
    $message_erreur = afficheErreur($erreur);
	$input_id = choixbouton(1);
	$data = choixFormulaire($droit_user, $login);
	$input_fidele = boutonFidele($droit_user);
    $title = 'Devis';
    require ('./components/header.php');
    require ('./components/navbar.php');
	require('./views/devis/devis_formulaire.php');
	require('./views/devis/devis.php');
    require('./components/footer.php');
}

function afficheDevis() {
	$input_id = choixbouton(0);
	// $sticky_footer = true;
	$input_fidele = false;
	$devis_formulaire = false;
    $title = 'Devis';
    require ('./components/header.php');
    require ('./components/navbar.php');
	require('./views/devis/devis.php');
    require('./components/footer.php');
}

function identification()
{
	require('compte_login.php');
}
function afficheEspaceId()
{
    $title = 'Identification';
    require ('./components/header.php');
    require ('./components/navbar.php');
	require('./views/compte/compte_formulaire.php');
	$compte_fidele = false;
	$compte_admin = false;
	require('./views/compte/compte_espace.php');
    require('./components/footer.php');
}
function afficheEspaceFidele($login)
{
    $title = 'Espace Fidèle';
    require ('./components/header.php');
    require ('./components/navbar.php');
	$location = getLocation($login);
	require('./views/compte/compte_fidele.php');
	$compte_formulaire = false;
	$compte_admin = false;
	require('./views/compte/compte_espace.php');
    require('./components/footer.php');
}
function afficheEspaceAdmin($agence_selected, $agence_modified, $login, $droit_user)
{
    $title = 'Espace Administrateur';
	$agence = getAgence();
	$IdUser = getIdAdmin();
	$data_agence = getAgenceSelected($agence_selected);
	$message_agence = setAgenceAdmin($agence_modified);
	$message_droit = setDroit($login, $droit_user);
	$compte_formulaire = false;
	$compte_fidele = false;
    $title = 'Mon compte';
    require ('./components/header.php');
    require ('./components/navbar.php');
	require('./views/compte/compte_admin.php');
	require('./views/compte/compte_espace.php');
    require('./components/footer.php');
}


function affichePagePaiement()
{
    $title = 'Paiement';
	// $sticky_footer = true;
    require ('./components/header.php');
    require ('./components/navbar.php');
	require ('./views/paiement.php');
    require ('./components/footer.php');
}
function afficheValidationPaiement()
{
	require('facture.php');
}
function afficheVehicules()
{
    $title = 'Nos véhicules';
    require ('./components/header.php');
    require ('./components/navbar.php');
	require('./views/vehicules/vehicules.php');
    require ('./components/footer.php');
}
function afficheFAQ()
{
    $title = 'Des questions ?';
    require ('./components/header.php');
    require ('./components/navbar.php');
	require('./views/faq.php');
    require ('./components/footer.php');

}
function afficheConfidentialite()
{
    $title = 'Politique de confidentialité';
    require ('./components/header.php');
    require ('./components/navbar.php');
	require('./views/confidentialite.php');
    require ('./components/footer.php');

}
function afficheAgences($agence_selected)
{
    $title = 'Nos agences';
	$agence = getAgence();
	$data_agence = getAgenceSelected($agence_selected);
    // $sticky_footer = true;
    require ('./components/header.php');
    require ('./components/navbar.php');
	require('./views/agences.php');
	require ('./components/footer.php');
}
function afficheMentions()
{
    $title = 'Mentions Légales';
    require ('./components/header.php');
    require ('./components/navbar.php');
	require('./views/mentions_legales.php');
    require ('./components/footer.php');
}
function afficheNotreHistoire()
{
    $title = 'Qui sommes nous';
    require ('./components/header.php');
    require ('./components/navbar.php');
	require('./views/notre_histoire.php');
    require ('./components/footer.php');
}
function afficheTest()
{
	require('test.php');
}
function afficheProgFidele()
{
    $title = 'Programme de fidelité';
    require ('./components/header.php');
    require ('./components/navbar.php');
	require('./views/prog_fidele.php');
    require ('./components/footer.php');
}
function afficheContact()
{
    $title = 'Contact';
    require ('./components/header.php');
    require ('./components/navbar.php');
    require('./views/contact.php');
    require ('./components/footer.php');
}
function createPdf()
{
    require('generate_pdf.php');
}
function deconnexion()
{
	$_SESSION = [];
	session_destroy();
	setcookie(session_name(), 0, time(), '/');
	header('Location: index.php');
}

// function supprimeDevisClient();
// {
// 	$session = [];
// 	return $session;
// }
