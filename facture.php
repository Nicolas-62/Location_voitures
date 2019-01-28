<?php
session_start();
$db = dbconnect();

/* recuperation des numéros d'agence et d'utilisateur */

$agence_depart = $db->prepare('SELECT Num_AG FROM Agence WHERE Nom_AG = ? ');
$agence_depart->execute([$_SESSION['ag_depart']]);
$agence_departs = $agence_depart->fetch();

$agence_arrivee = $db->prepare('SELECT Num_AG FROM Agence WHERE Nom_AG = ? ');
$agence_arrivee->execute([$_SESSION['ag_arrivee']]);
$agence_arrivees = $agence_arrivee->fetch();

$numero_client = $db->prepare('SELECT Num_User FROM Espace_User WHERE Mel_User = ?');
$numero_client->execute([$_SESSION['login']]);
$numero_clients = $numero_client->fetch();

/* calcul du nombre de locations de l'utilisateur */

$nb_location = $db->prepare('SELECT COUNT(*) as nb_loc FROM Location WHERE Num_User = ?');
$nb_location->execute([$numero_clients['Num_User']]);
$nb_locations = $nb_location->fetch();
$_SESSION['nb_loc'] = $nb_locations['nb_loc'];

/* calcul du nombre de points pour la location traitée */

$Num_Tr_Pt = nb_tranche($_SESSION['prix_devis'], $_SESSION['Droit_User'], $nb_locations['nb_loc']);
$_SESSION['Num_Tr_Pt'] = $Num_Tr_Pt;

/* transformation des dates pour les rentrer dans la base de donnée */

$_SESSION['date_depart'] = date("Y-m-d", strtotime($_SESSION['date_depart']));
$_SESSION['date_arrivee'] = date("Y-m-d", strtotime($_SESSION['date_arrivee']));

/* Enregistrement de la location */

$insert_fact = $db->prepare('INSERT INTO Location(Date_Loc, Date_Debut_Loc, Date_Fin_Loc, Duree_Loc, Pu_TTC_Loc, Num_User, Num_AG, Num_Car, Num_AG_Agence, Num_Tr_Pt)
					VALUES(now(), :Date_Debut_Loc, :Date_Fin_Loc, :Duree_Loc, :Pu_TTC_Loc, :Num_User, :Num_AG, :Num_Car, :Num_AG_Agence,  :Num_Tr_Pt)');
$insert_fact->execute([
	'Date_Debut_Loc' => $_SESSION['date_depart'],
	'Date_Fin_Loc' => $_SESSION['date_arrivee'],
	'Duree_Loc' => $_SESSION['nb_jour'],
	'Pu_TTC_Loc' => $_SESSION['prix_devis'],
	'Num_User' => $numero_clients['Num_User'],
	'Num_AG' => $agence_departs['Num_AG'],
	'Num_Car' => $_SESSION['Num_Car'],
	'Num_AG_Agence' => $agence_arrivees['Num_AG'],
	'Num_Tr_Pt' => $Num_Tr_Pt
]);

/* affectation véhicule dans l'agence d'arrivée */

$change_agence = $db->prepare('UPDATE Car SET Num_AG=:Num_AG WHERE Num_Car=:Num_Car');
$change_agence->execute([
	'Num_AG' => $agence_arrivees['Num_AG'],
	'Num_Car' => $_SESSION['Num_Car']
]);

/* enregistrement du type de carte utilisé par le client */

$type_carte = $db->prepare('UPDATE Espace_User SET Carte_User=:Carte_User WHERE Mel_User=:Mel_User');
$type_carte->execute([
	'Carte_User' => $_POST['type_carte'],
	'Mel_User' => $_SESSION['login']

]);

/* enregistrement/mise à jour des données personnelles du client fidèle */

if(isset($_SESSION['fidele']) && $_SESSION['fidele'] == 1){
	$insert_coordonnees = $db->prepare('INSERT INTO Client_Fidele(Civ_Cli, Nom_Cli, Prenom_Cli, Rue_Cli, Ville_Cli, CP_Cli, Tel_Cli, Num_User) VALUES(:Civ_Cli, :Nom_Cli, :Prenom_Cli, :Rue_Cli, :Ville_Cli, :CP_Cli, :Tel_Cli, :Num_User)');
	$insert_coordonnees->execute([
		'Civ_Cli' => $_SESSION['Civ'],
		'Nom_Cli' => $_SESSION['Nom'],
		'Prenom_Cli' => $_SESSION['Prenom'],
		'Rue_Cli' => $_SESSION['voie'],
		'Ville_Cli' => $_SESSION['ville'],
		'CP_Cli' => $_SESSION['cp'],
		'Tel_Cli' => $_SESSION['Num_Tel'],
		'Num_User' => $numero_clients['Num_User']
	]);

	$change_droit = $db->prepare('UPDATE Espace_User SET Droit_User = 1 WHERE Num_User = ?');
	$change_droit->execute([$numero_clients['Num_User']]);
	$_SESSION['Droit_User'] = 1;

}else if (!isset($_SESSION['fidele'])){
	$update_coordonnees = $db->prepare('UPDATE Client_Fidele SET Civ_Cli=:Civ_Cli, Nom_Cli=:Nom_Cli , Prenom_Cli=:Prenom_Cli, Rue_Cli=:Rue_Cli, Ville_Cli=:Ville_Cli, CP_Cli=:CP_Cli, Tel_Cli=:Tel_Cli WHERE Num_User=:Num_User');
	$update_coordonnees->execute([
		'Civ_Cli' => $_SESSION['Civ'],
		'Nom_Cli' => $_SESSION['Nom'],
		'Prenom_Cli' => $_SESSION['Prenom'],
		'Rue_Cli' => $_SESSION['voie'],
		'Ville_Cli' => $_SESSION['ville'],
		'CP_Cli' => $_SESSION['cp'],
		'Tel_Cli' => $_SESSION['Num_Tel'],
		'Num_User' => $numero_clients['Num_User']
	]);
}

/* recupère la location qu'on vient d'enregistrer (préparation des données pour le pdf) */

$numero_location = $db->prepare('SELECT * FROM Location WHERE Num_User =:Num_User AND Num_Loc=(SELECT MAX(Num_Loc) FROM Location WHERE Num_User=:Num_User)');
$numero_location->execute([
	'Num_User' => $numero_clients['Num_User']]);
$loc = $numero_location->fetch();

/* recupère les données de l'agence concernée */

$infos_ag = $db->prepare('SELECT * FROM Agence WHERE Num_AG=:Num_AG');
$infos_ag->execute([
	'Num_AG' => $agence_departs['Num_AG']
]);
$info_ag = $infos_ag->fetch();

/* transformation des dates pour affichage et recalcul des montants */

$cli = $_SESSION;
$loc['Date_Loc'] = date("d-m-Y à H:i:s", strtotime($loc['Date_Loc']));
$cli['date_depart'] = date("d-m-Y", strtotime($cli['date_depart']));
$cli['date_arrivee'] = date("d-m-Y", strtotime($cli['date_arrivee']));

$prix_Ht = ($cli['prix_devis']/(1+0.2));
$prix_Tva = $cli['prix_devis']-$prix_Ht;

$prix = [
	'HT' => $prix_Ht,
	'TVA' => $prix_Tva,
	'TTC' => $cli['prix_devis']	
];

/* Generation du pdf */

require('tfpdf/tfpdf.php');

$pdf = new tFPDF();
$pdf->AddPage();
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('DejaVuB', '', 'DejaVuSansCondensed-Bold.ttf',true);

$pdf->Ln();
$pdf->Image('images/logo_final.png',10,10,-450);

$pdf->Cell(95, 10, "");
$pdf->SetFont('DejaVu','',14);
$pdf->Cell(95, 10, "Facture n°".$loc['Num_Loc']."", 0, 1, 'R');
$pdf->SetFont('DejaVu','',12);
$pdf->Cell(95, 10, "");
$pdf->Cell(95, 5, "Établie le ".$loc['Date_Loc']."", 0, 1, 'R');
$pdf->Ln();
$pdf->Cell(95, 5, "Agence de ".$info_ag['Nom_AG']."",0,2);
$pdf->Cell(95, 5, "".$info_ag['Rue_AG']."",0,2);
$pdf->Cell(95, 5, "".$info_ag['Ville_AG']."",0,2);
$pdf->Cell(95, 5, "".$info_ag['CP_AG']."",0,2);
$pdf->Cell(95, 5, "Tél : ".$info_ag['Tel_AG']."",0,2);
$pdf->Cell(115, 10);
$pdf->SetFont('DejaVuB', '', 12);
$pdf->Cell(75, 5, "".$cli['Civ']." ".$cli['Nom']." ".$cli['Prenom']."", 0, 2, 'L');
$pdf->SetFont('DejaVu','',12);
$pdf->Cell(75, 5, "".$cli['voie']."", 0, 2, 'L');
$pdf->Ln();
$pdf->Cell(115, 10);
$pdf->Cell(75, 5, "".$cli['cp']." ".$cli['ville']."", 0, 2, 'L');
$pdf->Cell(75, 8,'','',0,1);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(95, 10, "n° client : ".$numero_clients['Num_User']."", 0, 1, 'L');
$pdf->Cell(95, 10, "Agence de départ", 'LT', 0, 'L');
$pdf->Cell(95, 10, "".$cli['ag_depart']."", 'RT', 1, 'L');
$pdf->Cell(95, 10, "Agence de retour", 'L', 0, 'L');
$pdf->Cell(95, 10, "".$cli['ag_arrivee']."", 'R', 1, 'L');
$pdf->Cell(95, 10, "Date de départ", 'L', 0, 'L');
$pdf->Cell(95, 10, "".$cli['date_depart']."", 'R', 1, 'L');
$pdf->Cell(95, 10, "Date de retour", 'L', 0, 'L');
$pdf->Cell(95, 10, "".$cli['date_arrivee']."", 'R', 1, 'L');
$pdf->Cell(95, 10, "Durée de la location en jour ", 'L', 0, 'L');
$pdf->Cell(95, 10, "".$cli['nb_jour']."", 'R', 1, 'L');
$pdf->Cell(95, 10, "n° de véhicule  ", 'L', 0, 'L');
$pdf->Cell(95, 10, "".$cli['Num_Car']."", 'R', 1, 'L');
$pdf->Cell(95, 10, "Modèle  ", 'L', 0, 'L');
$pdf->Cell(95, 10, "".$cli['Marq_Mod']." ".$cli['Nom_Mod']."", 'R', 1, 'L');
$pdf->Cell(95, 10, "Categorie", 'L', 0, 'L');
$pdf->Cell(95, 10, "".$cli['Nom_Cat']."", 'R', 1, 'L');
$pdf->Cell(95, 10, "Carburant", 'LB', 0, 'L');
$pdf->Cell(95, 10, "".$cli['Nom_Carbu']."", 'RB', 1, 'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('DejaVuB', '', 12);
$pdf->Cell(95, 10, "", 0, 0, 'R');
$pdf->Cell(95, 10, "Montants en € :", 0, 1, 'R');
$pdf->Cell(95, 10, "PRIX H.T  ", 1, 0, 'R');
$pdf->Cell(95, 10, "".$prix['HT']."", 1, 1, 'R');
$pdf->Cell(95, 10, "T.V.A 20.0% ", 1, 0, 'R');
$pdf->Cell(95, 10, "".$prix['TVA']."", 1, 1, 'R');
$pdf->Cell(95, 10, "PRIX TTC", 1, 0, 'R');
$pdf->Cell(95, 10, "".$prix['TTC']."", 1, 1, 'R');

/* insertion pdf dans variable de session, retour à l'accueil */

$_SESSION['pdf'] = serialize($pdf);

$_SESSION = [
	'login' => $_SESSION['login'],
	'Droit_User' => $_SESSION['Droit_User'],
	'pdf' => $_SESSION['pdf']
];
header('Location: index.php?action=accueil');

