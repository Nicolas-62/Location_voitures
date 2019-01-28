
<?php ob_start(); 

?>
<div class="container">
      <legend class="titletour">Coordonnées</legend>
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="Civ">Civilité</label>
            <select class="form-control" id="Civ" name="Civ" value="<?= $data['Civ_Cli'] ?>">
            <option>M.</option>
            <option>Mme</option>
          </select>
          </div>
          <div class="col-md-4 mb-3">
            <label for="Nom">Nom</label>
            <input type="text" class="form-control" id="Nom" name="Nom" placeholder="Nom" value="<?= $data['Nom_Cli'] ?>" onchange="verifNom(this)">
            <small id="erreur_nom"></small>
          </div>

          <div class="col-md-4 mb-3">
 
              <label for="Prenom">Prénom</label>    
              <input type="text" class="form-control" id="Prenom" name="Prenom" value="<?= $data['Prenom_Cli'] ?>" onchange="verifPrenom(this)" placeholder="Prenom" aria-describedby="validationTooltipUsernamePrepend">
              <small id="erreur_prenom"></small>
            </div>
          </div>

        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="voie">Adresse</label>
            <input type="text" class="form-control" id="voie" name="voie" placeholder="Rue ..." value="<?= $data['Rue_Cli'] ?>" onchange="verifAdresse(this)">
            <small id="erreur_Adresse"></small>
          </div>
          <div class="col-md-3 mb-3">
            <label for="Ville">Ville</label>
            <input type="text" class="form-control" id="ville" name="ville" value="<?= $data['Ville_Cli'] ?>" placeholder="Ville" onchange="verifVille(this)">
            <small id="erreur_Ville"></small>
          </div>
          <div class="col-md-3 mb-3">
            <label for="cp">Code Postal</label>
            <input type="text" class="form-control" id="cp" name="cp" value="<?= $data['CP_Cli'] ?>" placeholder="Code Postal" onchange="verifCP(this)">
            <small id="erreur_cp"></small>
        </div>
        <div class="col-md-3 mb-3">
            <label for="Num_Tel">Téléphone</label>
            <input type="text" class="form-control" id="Num_Tel" name="Num_Tel" value="<?= $data['Tel_Cli'] ?>" placeholder="" onchange="verifTel(this)" >
            <small id="erreur_tel"></small>
          </div>
        </div>

        <div class="form-group">
          <div class="form-check">
            <input type="checkbox" name="CGU" class="form-check-input" value="1" id="CGU">
            <label for="CGU"> En cochant cette case, j'accepte les CGU. <strong>Vous devez cocher cette case pour poursuivre la réservation.</strong></label>
             <?= $input_fidele ?>  
             <div class="row">
             <button type="reset" class="btn btn-secondary">Effacer</button>
             </div>
          </div>


<?php $devis_formulaire = ob_get_clean(); ?>