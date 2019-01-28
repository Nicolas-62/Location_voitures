<div>

    <!--Title-->
    <h1> Nos véhicules </h1>
    <!--/.Title-->

    <!--Vehicules-->
    <div class="row vehiculesfrow">
        <?php while ($vehicule = $tourisme_query[$i]->fetch()) { ?>

            <!--Vehicule template-->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-title">
                        <p class="namev mt-3"><?= $vehicule['Marq_Mod'] ?> | <?= $vehicule['Nom_Mod'] ?></p>
                        <hr style="bottom">
                    </div>
                    <div class="card-img">
                        <div class="titletour">
                            <img src="<?=$vehicule['Img_Mod'] ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!--/.Vehicule template-->

        <?php } ?>
    </div>
    <!--/.Vehicules-->
</div>
