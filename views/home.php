<?php
$page_data = array(
    'agences' => array()
);

while ($agence = $agence_list->fetch()) {
    array_push($page_data['agences'], array(
        'nom' => $agence['Nom_AG']
    ));
}
$agence_list->closeCursor();
?>

<style>
body {
    background-image: url("./images/road.jpg");
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    /*overflow: hidden;*/
}
</style>

<div>

    <!--Title row-->
    <div id="fond" class="row">
        <div class="col-lg-12 titletour my-4">
            <div class="card mt-2" id="acc">
                <div class="mt-3">
                    <h4>Vous souhaitez louer une voiture ?<br> Vous êtes au bon endroit !</h4>        
                    <p><?= $message_accueil ?></p>
                </div>
            </div>    
        </div>
    </div>
    <!--/.Title row-->

    <!--Search row-->
    <div class="row">
        <div class="col-lg-12">
            <!--Form card-->
            <div class="card" id="acc">
                <div class="card-body">
                    <form action="./index.php?action=vehicules" method="post">

                        <div class="row">
                            <!-- Agence et date -->
                            <div class="col-xs-12 col-md-8">

                                <div class="row">
                                    <!-- Agence départ -->
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="ag_depart">Agence de départ : </label>
                                            <select class="form-control" id="ag_depart" name="ag_depart" required>
                                                <option value="">--Selectionner--</option>
                                                <?php foreach ($page_data['agences'] as $agence): ?>
                                                    <option value="<?=$agence['nom'] ?>"><?=$agence['nom'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Date départ -->
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                           <label for="date_depart">Date de départ :</label> 
                                           <input class="form-control" type="text" id="date_depart" name="date_depart" required>
                                           <!-- <input type="text" id="date_depart" name="date_depart"> -->
                                     </div><!--  <label for="to">to</label>
                                     <input type="text" id="to" name="to"> -->
                                 </div>
                             </div>

                             <div class="row">
                                <!-- Agence arrivée -->
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="ag_arrivee">Agence de retour : </label>
                                        <select class="form-control" id="ag_arrivee" name="ag_arrivee" required>
                                            <option value="">--Selectionner--</option>
                                            <?php foreach ($page_data['agences'] as $agence): ?>
                                                <option value="<?=$agence['nom'] ?>" ><?=$agence['nom'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Date arrivée -->
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                      <label for="date_arrivee">Date de retour : </label>
                                      <input class="form-control" type="text" id="date_arrivee" name="date_arrivee" required>
                                  </div>
                              </div>
                          </div>

                      </div>

                      <!-- catégorie -->
                          <div class="col-xs-12 col-md-4">
                                <div class="row">

                                    <div class="offset-xs-4 offset-md-4 col-xs-4 col-md-4">

                                    <label for="exampleRadios1">Catégorie</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="categorie" id="tourisme" value="1" checked="">
                                            <label class="form-check-label" for="tourisme">
                                                Tourisme
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="categorie" id="utilitaire" value="7">
                                            <label class="form-check-label" for="utilitaire">
                                                Utilitaire
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mt-1 titletour">
                            <button type="submit" class="btn btn-info">Valider</button>
                            <button type="reset" class="btn btn-secondary">Tout effacer</button>
                        </div>

                </form>
             </div>
        </div>
    <!--/.Form card-->
    </div>
</div>
<!--/.Search row-->
</div>

