<?php ob_start(); ?>




<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <h2>Vos dernières locations</h2>
    </div>


    <?php $nb_points = 0; while ($data = $location->fetch()) { ?>



    <div class="col-xs-12 col-md-4 col-lg-4"> 
        <div class="mr-1 card">
            <div class="card-title" style="text-align: center">RESERVATION DU  <?= $data['date_location'] ?><br></div>
            <div class="divider"></div>
            <div class="card-img"> <!--MARQUE ET MODELE DE VOITURE + IMAGE--></div>
            <div class="card-body">
                Agence de Réservation : <?= $data['Nom_AG'] ?><br>
                Départ : <?= $data['date_debut_location'] ?><br>
                Retour : <?= $data['date_fin_location'] ?><br>
                Véhicule : <?= $data['Marq_Mod'] .' | '.$data['Nom_Mod'] ?><br>
                Montant : <?= $data['Pu_TTC_Loc'] ?> € <br>
                Duree de la location : <?= $data['Duree_Loc'] ?> jours
            </div>
        </div>
    </div>



    <?php $nb_points = $nb_points + $data['Nb_Tr_Pt']; } ?>
    <div class="row">
        <h5>Votre nombre de points cumulés : <?= $nb_points; ?> points</h5>
    </div>
</div>

<?php $compte_fidele = ob_get_clean() ?>


