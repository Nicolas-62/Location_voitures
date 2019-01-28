<!-- <div id="tourismeContainer">
    <! Title row -->
    <!-- <div class="row">
        <div class="col-lg-12">
            <div class="titletour">  -->
                <h1 class="mb-5">Nos véhicules de tourisme</h2>
            <!-- </div>
        </div>
    </div> -->
    <!-- /Title row -->
    <!-- Vehicules row -->
    <div class="row vfrow">
        <?php
            $vehicules_dipo =false;
            foreach ($tourisme_query as $vehicule) { 
                if(!empty($vehicule)){ $vehicules_dipo =true; ?>


                <div class="col-xs-12 col-md-4">
                    <div class="card" style="width: 20rem">
                        <!-- Afficher les données des véhicules -->
                        <img class="card-img-top" src="<?=$vehicule['Img_Mod'] ?>" alt="Image véhicule">
                        <h3 class="card-title text-center"><?= $vehicule['Marq_Mod'] ?> | <?= $vehicule['Nom_Mod'] ?></h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Catégorie : <?=$vehicule['Nom_Cat'] ?></li>
                            <li class="list-group-item">Carburant : <?=$vehicule['Nom_Carbu'] ?></li>
                            <?php if ($vehicule['Toit_Tou'] != ''):?>
                                <li class="list-group-item">Type de toit : <?=$vehicule['Toit_Tou'] ?></li>
                            <?php endif; ?>
                            <li class="list-group-item">Climatisation : <?=$vehicule['Clim_Tou'] ?></li>
                            <li class="list-group-item">Nombre de Bagages : <?=$vehicule['Nb_Bagage_Tou'] ?></li>
                            <li class="list-group-item">GPS : <?= $vehicule['GPS_Tou'] ?></li>
                            <li class="list-group-item">Nombre de Places : <?=$vehicule['Nb_Place_Tou'] ?></li>
                            <li class="list-group-item">Prix journalier : <?=$vehicule['Prix_Jour_Mod'] ?> €</li>
                        </ul>
                        <!-- /Afficher les données des véhicules -->

                        <!--Devis form-->
                        <form action="index.php?action=devis" method="post">
                            <input type="hidden" name="Marq_Mod" value="<?= $vehicule['Marq_Mod'] ?>">
                            <input type="hidden" name="Nom_Mod" value="<?= $vehicule['Nom_Mod'] ?>">
                            <input type="hidden" name="Prix_Jour_Mod" value="<?= $vehicule['Prix_Jour_Mod'] ?>">
                            <input type="hidden" name="Nom_Cat" value="<?= $vehicule['Nom_Cat'] ?>">
                            <input type="hidden" name="Nom_Carbu" value="<?= $vehicule['Nom_Carbu'] ?>">
                            <input type="hidden" name="Toit_Tou" value="<?= $vehicule['Toit_Tou'] ?>">
                            <input type="hidden" name="Clim_Tou" value="<?= $vehicule['Clim_Tou'] ?>">
                            <input type="hidden" name="Nb_Bagage_Tou" value="<?= $vehicule['Nb_Bagage_Tou'] ?>">
                            <input type="hidden" name="GPS_Tou" value="<?= $vehicule['GPS_Tou'] ?>">
                            <input type="hidden" name="Nb_Place_Tou" value="<?= $vehicule['Nb_Place_Tou'] ?>">
                            <input type="hidden" name="Num_Car" value="<?= $vehicule['Num_Car'] ?>">
                            <input type="hidden" name="devis" value="1">

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-info">Valider</button>
                                <a class="btn btn-secondary" href="./index.php?action=accueil" role="button">Annuler</a>
                            </div>
                        </form>
                        <!--/.Devis form-->
                    </div>
                </div>
               <!-- /Afficher les données des véhicules -->
            <?  }
            } //end for
            if($vehicules_dipo == false){ ?>
                <h3 class="mb-5">Il n'y a pas de d'utilitaires disponibles à cette date</h3>
                <a class="btn btn-secondary" href="./index.php?action=accueil" role="button">Retour</a>
    <?php   } ?>
    </div>
    <!-- /Vehicules row -->
    <!-- </div> -->




