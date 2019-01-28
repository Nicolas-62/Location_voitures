<div class="container">
    <h1>Devis</h1>
</div>
<!-- ERREUR -->
    <?php if (!empty($message_erreur)) {?>
    <div class="alert alert-danger" role="alert"><?=$message_erreur; } ?></div>
    <!-- /ERREUR -->
<form action="index.php?action=identification_paiement" method="POST" onsubmit="verifForm(this)">
      <div class="container">
          <div class="card-deck mb-3 text-center">
            <div class="card mb-4 box-shadow">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">Véhicule</h4>
                  </div>
                    <div class="card-body">
                      <ul class="list-unstyled mt-1 mb-4">
                        <li><?=$_SESSION['Marq_Mod'] ?> | <?=$_SESSION['Nom_Mod'] ?></li>
                        <li>Catégorie : <?=$_SESSION['Nom_Cat'] ?></li>
                        <li>Carburant : <?= $_SESSION['Nom_Carbu'] ?></li>

                        <?php if($_SESSION['devis'] == 1){ ?>

                        <li>Toit : <?= $_SESSION['Toit_Tou'] ?></li>
                        <li>Climatisation : <?= $_SESSION['Clim_Tou'] ?></li>
                        <li>Nombre de Bagages : <?= $_SESSION['Nb_Bagage_Tou'] ?></li>
                        <li>GPS : <?= $_SESSION['GPS_Tou'] ?></li>
                        <li>Nombre de Places : <?= $_SESSION['Nb_Place_Tou'] ?></li>
                        
                        <?php }else if ($_SESSION['devis'] == 2){ ?>

                        <li>Volume Utile : <?= $_SESSION['Vol_Ut'] ?></li>
                        <li>Charge Utile : <?= $_SESSION['Charg_Ut'] ?></li>
                        <li>Longueur Interne : <?= $_SESSION['Long_Ut'] ?></li>
                        <li>Largueur Interne : <?= $_SESSION['Larg_Ut'] ?></li>
                        <li>Hauteur Interne : <?= $_SESSION['Haut_Ut'] ?></li>
                        <li>Prix estimé : <?=$_SESSION['prix_devis'].'€' ?></li>
                    </ul>
                    <?php } ?>
                  </div>
                </div>
            <div class="card mb-4 box-shadow">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">Agence</h4>
              </div>
              <div class="card-body">
                <ul class="list-unstyled mt-3 mb-4">
                    <li>Agence de départ : <?=$_SESSION['ag_depart'] ?> </li>
                    <li>Agence d'arrivée : <?=$_SESSION['ag_arrivee'] ?></li>
                    <li>Date de départ : <?=$_SESSION['date_depart'] ?> </li>
                    <li>Date d'arrivée : <?=$_SESSION['date_arrivee'] ?></li>
                    <li>Durée de la location : <?=$_SESSION['nb_jour'] ?>jour(s)</li>
                </ul>
                <div class="container justify-center">
                  <div class="card mx-auto">
                    <div class="card-body">
                      <ul class="list-unstyled mt-3 mb-4">
                        <li>Prix estimé : <?=$_SESSION['prix_devis'].'€' ?></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    <?= $devis_formulaire ?>
			    <div class="container form-inline">
		    		<button class="btn btn-info mr-1 mb-3" type="submit"><?=  $input_id ?></button>
</form>	
			    		 <form action="index.php?action=accueil" method="post">  
  							<button class="btn btn-secondary" type="submit" action="index.php?action=accueil" method="">Annuler</button>   
  						</form>
					</div>
				</div>
	        </div>	           
       </div>
    </div>
