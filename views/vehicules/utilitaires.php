<!-- div class="container">
    <! Title row -->
   <!--  <div class="row">
    <div class="col-lg-12 mt-5"> --> 
        <h1 class="mb-5">Nos utilitaires</h1>
        <!-- </div>
        </div> -->
        <!-- /Title row -->

        <!-- Vehicules row -->
        <div class="row vfrow">
            <?php
                $vehicules_dipo =false;
                foreach ($utilitaire_query as $vehicule) { 
                    if(!empty($vehicule)){ $vehicules_dipo =true; ?>


                <div class="col-xs-12 col-md-4">
                    <div class="card" style="width: 20rem">
                        <!-- Afficher les données des véhicules -->
                        <img class="card-img-top" src="<?=$vehicule['Img_Mod'] ?>" alt="Image véhicule">
                        <h3 class="card-title text-center"><?= $vehicule['Marq_Mod'] ?> | <?= $vehicule['Nom_Mod'] ?></h3>
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Carburant : <?= $vehicule['Nom_Carbu'] ?></li>
                            <li class="list-group-item">Volume : <?= $vehicule['Vol_Ut'] ?> m3</li>
                            <li class="list-group-item">Charge utile : <?= $vehicule['Charg_Ut'] ?> kg</li>
                            <li class="list-group-item">Longueur interne : <?= $vehicule['Long_Ut'] ?> m</li>
                            <li class="list-group-item">Largeur interne : <?= $vehicule['Larg_Ut'] ?> m</li>
                            <li class="list-group-item">Hauteur interne: <?= $vehicule['Haut_Ut'] ?> m</li>
                            <li class="list-group-item">Prix journalier : <?= $vehicule['Prix_Jour_Mod'] ?> €</li>
                            
                        </ul>
                        
                        
                        <!-- ici on créé des 'formulaires cachés qui enverrons données de la requête !-->
                        <form action="./index.php?action=devis" method="post">
                            <input type="hidden" name="Marq_Mod" value="<?= $vehicule['Marq_Mod'] ?>">
                            <input type="hidden" name="Nom_Mod" value="<?= $vehicule['Nom_Mod'] ?>">
                            <input type="hidden" name="Prix_Jour_Mod" value="<?= $vehicule['Prix_Jour_Mod'] ?>">
                            <input type="hidden" name="Num_Car" value="<?= $vehicule['Num_Car'] ?>">
                            <input type="hidden" name="Nom_Cat" value="<?= $vehicule['Nom_Cat'] ?>">
                            <input type="hidden" name="Nom_Carbu" value="<?= $vehicule['Nom_Carbu'] ?>">
                            <input type="hidden" name="Vol_Ut" value="<?= $vehicule['Vol_Ut'] ?>">
                            <input type="hidden" name="Charg_Ut" value="<?= $vehicule['Charg_Ut'] ?>">
                            <input type="hidden" name="Long_Ut" value="<?= $vehicule['Long_Ut'] ?>">
                            <input type="hidden" name="Larg_Ut" value="<?= $vehicule['Larg_Ut'] ?>">
                            <input type="hidden" name="Haut_Ut" value="<?= $vehicule['Haut_Ut'] ?>">
                            <input type="hidden" name="devis" value="2">


                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-info">Valider</button>
                                <a class="btn btn-secondary" href="./index.php?action=accueil" role="button">Annuler</a>
                            </div>
                        </form>


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


 <!-- </div> -->
