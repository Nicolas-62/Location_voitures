<?php
ob_start();
?>

<div class="container">
    <div class="row">
        <!-- TITRE DE PAGE -->
        <div class="col-lg-12">
            <h2>Espace administrateur</h2>
            <hr class="style13">
        </div>
        <!-- /TITRE DE PAGE -->
    </div>

    <?= $message_agence ?>
    <?= $message_droit ?>

    <div class="row">
        <!-- MODIFIER UNE AGENCE COL1 -->
        <div class="col-xs-12 col-md-6 titletour">
            <div class="content1">
                <h4>MODIFIER UNE AGENCE</h4>
                <br>
                <form action="index.php?action=espace_perso" method="post">
                    <div class="col-xs-12 col-md-8 offset-md-2 text-center">
                        Nom de l'agence à modifier :
                        <input type="text" class="form-control form-control-sm" list="modifier_agence" name="select_agence" id="select_agence">
                        <datalist id="modifier_agence">
                            <?php
                            while ($data_select = $agence->fetch())
                                { ?>
                                    <option value="<?=$data_select['Nom_AG'] ?>"><?=$data_select['Nom_AG'] ?></option>
                                    <?php } $agence->closeCursor();?>
                                </datalist>
                            </div>
                            <button type="submit" name="valider" class="btn btn-info btn-sm mt-2" value="Valider">Valider</button><!-- classe info-->
                        </form>
                        <!-- /MODIFIER UNE AGENCE COL1-->
                        <hr class="style1">
                        <!-- MODIFICATION DROITS USER -->

                        <form action="index.php?action=espace_perso" method="post">
                            <div class="col-xs-12 col-md-8 offset-md-2 titletour">

                                <h4>MODIFIER LES DROITS D'UN UTILISATEUR</h4>
                                <br>
                                <label for="login">Identifiant du compte :</label>
                                <input type="text" list="modifier_droit" class="form-control form-control-sm" name="login" id="login" placeholder="E-mail">
                                <datalist id="modifier_droit">
                                    <?php
                                    while ($data_select = $IdUser->fetch())
                                     { ?> 
                                        <option value="<?=$data_select['Mel_User'] ?>"><?=$data_select['Mel_User'] ?></option>
                                        <?php } $IdUser->closeCursor();?>
                                    </datalist>
                                    <form>
                                        <label class="radio-inline">
                                            <input type="radio" name="droit_user" id="occasionnel" value="0" checked>
                                            Occasionnel
                                        </label>
                                        <br>
                                        <label class="radio-inline">
                                            <input type="radio" name="droit_user" id="fidele" value="1">
                                            Fidèle
                                        </label>
                                        <br>
                                        <label class="radio-inline">
                                            <input type="radio" name="droit_user" id="admin" value="2">
                                            Administrateur
                                        </label>
                                    </form>
                                    <br>
                                    <button type="submit" class="btn btn-info btn-sm mt-2" value="Valider">Valider</button> <!-- changer classes boutons -->
                                    <button type="reset" class="btn btn-secondary btn-sm mt-2" value="Annuler">Effacer</button>

                                </div>
                            </form>
                        </div>
                        <!-- /MODIFICATION DROITS USER -->
                    </div>



                    <!-- AJOUTER UNE AGENCE COL2-->
                    <div class="col-xs-12 col-md-6 titletour">
                        <h4> AJOUTER/MODIFIER UNE AGENCE</h4>
                        <br>
                        <form action="index.php?action=espace_perso" method="post">
                            <div class="col-xs-12 col-md-8 offset-md-2 text-center">
                                <label for="Nom_AG">Nom de l'agence à modifier :</label>
                                <input type="text" class="form-control form-control-sm" name="Nom_AG" id="Nom_AG" size="20" value="<?= $data_agence['Nom_AG'] ?>">

                                <!-- VOIE mettre mt-1 -->
                                <label for="Rue_AG" class="mt-1">Voie :</label>
                                <input type="text" class="form-control form-control-sm" name="Rue_AG" id="Rue_AG" size="20" value="<?= $data_agence['Rue_AG'] ?>">
                                <!-- / VOIE -->

                                <!-- VILLE mettre mt-1 -->
                                <label for="Ville_AG" class="mt-1">Ville :</label>
                                <input type="text" class="form-control form-control-sm" name="Ville_AG" id="Ville_AG" size="10" value="<?= $data_agence['Ville_AG'] ?>">
                                <!-- VILLE -->

                                <!-- CP mettre mt-1 -->
                                <label for="CP_AG" class="mt-1">Code postal :</label>
                                <input type="text" class="form-control form-control-sm" name="CP_AG" id="CP_AG" size="6" value="<?= $data_agence['CP_AG'] ?>">
                                <!-- /CP -->

                                <!--TEL mettre mt-1 -->
                                <label for="Tel_AG" class="mt-1">Téléphone :</label>
                                <input type="text" class="form-control form-control-sm" name="Tel_AG" id="Tel_AG" size="10" value="<?= $data_agence['Tel_AG'] ?>">
                                <!-- /TEL -->
                            </div>
                            <button type="submit" class="btn btn-info btn-sm mt-2" value="Valider"> Valider </button>
                            <button type="reset" class="btn btn-secondary btn-sm mt-2" value="Annuler"> Effacer </button>
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <?php $compte_admin = ob_get_clean(); ?>