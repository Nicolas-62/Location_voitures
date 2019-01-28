<?php
require('connect.php');

function afficheErreur($erreur){
    if(!empty($erreur)){
        $formerror = 'Un des champs n\'est pas correctement rempli veuillez remplir correctement le formulaire';
    }else{
        $formerror = false;
    }
    return $formerror;
}
function getMessage($message)
{
    if($message == 'erreur_devis'){
        $info = '<p>Vous n\' avez pas encore réalisé de devis, sélectionnez vos choix dans le formulaire suivant</p>';
    }else if($message == 'facture'){
         $info = '<p>Votre réservation est enregistrée, vous pouvez télécharger la facture ici :</p>
                    <form action="generate_pdf.php" target="_blank"><button type="submit" class="btn btn-success">Facture</button></form>';
    }

    else{
        $info = false;
    }
    return $info;
}
function getAgence()
{
    $db = dbconnect(); 
    $agence = $db->query('SELECT * FROM Agence'); 
    return $agence;
}
function getAgenceSelected($agence_selected)
{
    if(!empty($agence_selected))
    {
        $db = dbconnect(); 
        $data_agences = $db->prepare('SELECT Nom_AG, Rue_AG, Ville_AG, CP_AG, Tel_AG FROM Agence WHERE Nom_AG = :Nom_AG');
        $data_agences->execute([
            'Nom_AG' => $agence_selected]);
        $data_agence = $data_agences->fetch();

    }else{
        $data_agence = false;
    }
    return $data_agence;
}

function setAgenceAdmin($agence_modified)
{
    $db = dbconnect(); 
    if(!empty($agence_modified)){
        $verif_agence = $db->prepare('SELECT Nom_AG FROM Agence WHERE Nom_AG=:Nom_AG');
            $verif_agence->execute([
                'Nom_AG' => $agence_modified
            ]);
            $agence_verify = $verif_agence->fetch();

            if($agence_verify){
                $insert_agence = $db->prepare('UPDATE Agence SET Rue_AG=:Rue_AG, Ville_AG=:Ville_AG, CP_AG=:CP_AG, Tel_AG=:Tel_AG WHERE Nom_AG=:Nom_AG ');
                $insert_agence->execute([ 
                    'Rue_AG' => $_POST['Rue_AG'], 
                    'Ville_AG' => $_POST['Ville_AG'], 
                    'CP_AG' => $_POST['CP_AG'], 
                    'Tel_AG' => $_POST['Tel_AG'],
                    'Nom_AG' => $agence_modified
                ]);

            }else{
                $verif_agence = $db->prepare('INSERT INTO Agence(Nom_AG, Rue_AG, Ville_AG, CP_AG, Tel_AG) VALUES (:Nom_AG, :Rue_AG, :Ville_AG, :CP_AG, :Tel_AG)');
                $verif_agence->execute([ 
                    'Rue_AG' => $_POST['Rue_AG'], 
                    'Ville_AG' => $_POST['Ville_AG'], 
                    'CP_AG' => $_POST['CP_AG'], 
                    'Tel_AG' => $_POST['Tel_AG'],
                    'Nom_AG' => $_POST['Nom_AG']
                ]);
            }
            $message_agence_valide = '<p>L\'agence a bien été enregistrée</p>';
            return $message_agence_valide;
    }else{
        return false;
    }
}
function getIdAdmin(){

    $db = dbconnect();
    $id = $db->query('SELECT Mel_User FROM Espace_User');
    return $id;
}
function setDroit($login, $droit_user)
{
    $db = dbconnect(); 
    if(!empty($login)){
        $req = $db->prepare('SELECT Mel_User, Pass_User FROM Espace_User WHERE Mel_User = :Mel_User');
        $req->execute([
            'Mel_User' => $login
            ]);
        $log = $req->fetch();

        if (isset($log)) {
            $change_droit = $db->prepare('UPDATE Espace_User SET Droit_User=:Droit_User WHERE Mel_User=:Mel_User');
            $change_droit->execute([
                'Droit_User' => $droit_user,
                'Mel_User' => $login
            ]);
            $message_droit_modif = '<p>Les droits de l\'utilisateur ont bien été modifiés</p>';
            return $message_droit_modif;
        }else{
            $message_droit_modif = '<p>Cet utilisateur n\'existe pas</p>';
            return $message_droit_modif;
        }
    }else{
        return false;
    }
}
function nb_jour($date_debut, $date_fin)
{
    $dateD = strtotime($date_debut);
    $dateF = strtotime($date_fin);
    $diff = $dateF-$dateD;
     $retour = array();
 
    $tmp = $diff;
    $retour['second'] = $tmp % 60;
 
    $tmp = floor( ($tmp - $retour['second']) /60 );
    $retour['minute'] = $tmp % 60;
 
    $tmp = floor( ($tmp - $retour['minute'])/60 );
    $retour['hour'] = $tmp % 24;
 
    $tmp = floor( ($tmp - $retour['hour'])  /24 );
    $retour['day'] = $tmp+1;
 
    return $retour['day'];
}
function devis($prix_jour, $nb_jour)
{
    $pHT = ($prix_jour * $nb_jour);
    $devis= ($pHT+($pHT*0.2));
    return $devis;
}
function tourisme_categorie($ag_depart, $categorie)
{
    $db = dbconnect();
      $tourisme = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        WHERE Num_AG = (SELECT Num_AG FROM Agence WHERE Nom_AG = ?) 
        AND  Modele.Num_Cat = ?
        ORDER BY Prix_Jour_Mod
        '); // les "?" correspondent aux variables dont dépent la requête, ici le nom de l'agence de départ et la catégorie du véhicule, on les retrouvent dans la ligne suivante

    $tourisme->execute(array($ag_depart, $categorie));

    return $tourisme;
}
function nb_tranche($prix_devis, $droit_user, $nb_locations)
{
    
   if($droit_user == 1 && $nb_locations>2){
        if($prix_devis >= 50 && $prix_devis <= 100){
            $nb_tranche = 2;
        }elseif($prix_devis >= 100 && $prix_devis <= 500){
            $nb_tranche = 3;
        }elseif($prix_devis >= 500 && $prix_devis <= 1000){
            $nb_tranche = 4;
        }elseif($prix_devis >= 1000 && $prix_devis <= 1500){
            $nb_tranche = 5;
        }elseif($prix_devis >= 1500 && $prix_devis <= 2000){
            $nb_tranche = 6;
        }elseif($prix_devis >= 2000){
            $nb_tranche = 6;
        }
    }else{
        $nb_tranche = 1;
    }
    return $nb_tranche;
}
function choixbouton($i)
{
     if($i == 0){      

        $bouton = 'Identifiez-vous pour réserver';

     }else {

        $bouton = 'Réserver';  

     }
    return $bouton;
}

function choixFormulaire($droit_user, $login)
{
    
    if(!empty($login) && !empty($droit_user) && $droit_user == 1){
        $bd = dbconnect();
        $client_fideles = $bd->prepare('SELECT * FROM Client_Fidele WHERE Num_User = (SELECT Num_User FROM Espace_User WHERE Mel_User = ?)');
        $client_fideles->execute(array($login));
        $data = $client_fideles->fetch();
    }
    else{
        $data = false;
    }
    return $data;

}
function boutonFidele($droit_user)
{
    if(isset($droit_user) && $droit_user == 1){

        $fidele = false;
        
    }else {
        $fidele = '
            <p>Voulez-vous faire partie du programme de fidélité ? Profitez d\'avantages sur vos réservations. Vous n\'aurez plus à remplir vos coordonnées par la suite.<br>
            <label for="fidele">Souhaitez-vous participer au programme de fidélité ?</label>
            <input type="radio" name="fidele" value="1" id="fidele_oui"><label for="fidele_oui">OUI</label>
            <input type="radio" name="fidele" value="0" id="fidele_non" checked=""><label for="fidele_non">NON</label></p>';
    }
    return $fidele;
}

function getLocation($login)
{
    $db = dbconnect();
        $info_location = $db->prepare('
            SELECT Pu_TTC_Loc, Nb_Tr_Pt, Duree_Loc, Nom_Mod, Marq_Mod, Nom_AG, DATE_FORMAT(Date_Loc, \'%d-%m-%Y\') AS date_location, DATE_FORMAT(Date_Debut_Loc, \'%d-%m-%Y\') AS date_debut_location, DATE_FORMAT(Date_Fin_Loc, \'%d-%m-%Y\') AS date_fin_location FROM Location
            JOIN Points 
            ON Points.Num_Tr_Pt = Location.Num_Tr_Pt
            JOIN Car
            ON Car.Num_Car = Location.Num_Car
            JOIN Modele
            ON Modele.Num_Mod = Car.Num_Mod 
            JOIN Agence
            ON Agence.Num_AG = Location.Num_AG
            WHERE Num_User = (SELECT Num_User FROM Espace_User WHERE Mel_User = ?)
            ORDER BY Date_loc DESC
            ');
        $info_location->execute([$login]);
        return $info_location;

}
function getTourisme($ag_depart)
{
    $tourisme = [];
    $db = dbconnect();
      $tourisme1 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 1
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme1->execute(array($ag_depart));
    $modele1 = $tourisme1->fetch();
    array_push($tourisme, $modele1);

      $tourisme2 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 2
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme2->execute(array($ag_depart));
    $modele2 = $tourisme2->fetch();
    array_push($tourisme, $modele2);

      $tourisme3 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 3
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme3->execute(array($ag_depart));
    $modele3 = $tourisme3->fetch();
    array_push($tourisme, $modele3);

      $tourisme4 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 4
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme4->execute(array($ag_depart));
    $modele4 = $tourisme4->fetch();
    array_push($tourisme, $modele4);


      $tourisme5 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 5
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme5->execute(array($ag_depart));
    $modele5 = $tourisme5->fetch();
    array_push($tourisme, $modele5);    

      $tourisme6 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 6
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme6->execute(array($ag_depart));
    $modele6 = $tourisme6->fetch();
    array_push($tourisme, $modele6);    

      $tourisme7 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 7
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme7->execute(array($ag_depart));
    $modele7 = $tourisme7->fetch();
    array_push($tourisme, $modele7);    

      $tourisme8 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 8
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme8->execute(array($ag_depart));
    $modele8 = $tourisme8->fetch();
    array_push($tourisme, $modele8);    

      $tourisme9 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 9
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme9->execute(array($ag_depart));
    $modele9 = $tourisme9->fetch();
    array_push($tourisme, $modele9);    

      $tourisme10 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 10
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme10->execute(array($ag_depart));
    $modele10 = $tourisme10->fetch();
    array_push($tourisme, $modele10);    

      $tourisme11 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 11
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme11->execute(array($ag_depart));
    $modele11 = $tourisme11->fetch();
    array_push($tourisme, $modele11);
 

      $tourisme12 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 12
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme12->execute(array($ag_depart));
    $modele12 = $tourisme12->fetch();
    array_push($tourisme, $modele12);    

      $tourisme13 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 13
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme13->execute(array($ag_depart));
    $modele13 = $tourisme13->fetch();
    array_push($tourisme, $modele13);    

      $tourisme14 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Tourisme
        ON Tourisme.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 14
        ORDER BY Prix_Jour_Mod
        LIMIT 1
        ');
    $tourisme14->execute(array($ag_depart));
    $modele14 = $tourisme14->fetch();
    array_push($tourisme, $modele14);    

    return $tourisme;
}
function getUtilitaire($ag_depart)
{
    $utilitaire = [];
    $db = dbconnect();
      $utilitaire1 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Utilitaire
        ON Utilitaire.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 15
        ORDER BY Prix_Jour_Mod
        LIMIT 1
           ');

    $utilitaire1->execute(array($ag_depart));
    $modele15 = $utilitaire1->fetch();
    array_push($utilitaire, $modele15);

      $utilitaire2 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Utilitaire
        ON Utilitaire.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 16
        ORDER BY Prix_Jour_Mod
        LIMIT 1
           ');
    $modele16 = $utilitaire2->fetch();
    array_push($utilitaire, $modele16);

      $utilitaire3 = $db->prepare('
        SELECT * FROM Car
        JOIN Carburant
        ON Carburant.Num_Carbu = Car.Num_Carbu
        JOIN Modele
        ON Modele.Num_Mod = Car.Num_Mod
        JOIN Utilitaire
        ON Utilitaire.Num_Mod = Modele.Num_Mod
        JOIN Categorie
        ON Categorie.Num_Cat = Modele.Num_Cat
        Join Agence
        ON Agence.Num_AG = Car.Num_AG
        WHERE Nom_AG = ? 
        AND  Car.Num_Mod = 17
        ORDER BY Prix_Jour_Mod
        LIMIT 1
           ');

    $modele17 = $utilitaire3->fetch();
    array_push($utilitaire, $modele17);
    return $utilitaire;
}
