
<div id="france">
	<h1 class="mb-5">Nos agences</h1>

	<div class="carte">
				<!-- <div class="fullmap"></div> -->
		<div class="row">
			<div class="col-lg-12">
				<div id="agence" class="p-3 bg-info text-white col-lg-5">
					Chercher une agence
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<form class="p-3 bg-light text-white col-lg-5" action="index.php?action=agences" method="post">
					<div class="form-inline">
						<label for="recherche"></label>
						<input type="text"  class="form-control col-lg-7" placeholder="Ville" list="modifier_agence" name="select_agence" id="select_agence">
						<datalist id="modifier_agence">
							<?php
							while ($data_select = $agence->fetch())
								{ ?> 
									<option value="<?=$data_select['Nom_AG'] ?>"><?=$data_select['Nom_AG'] ?></option>
									<?php } $agence->closeCursor();?>
								</datalist>

								<div class="offset-lg-1 col-lg-2">
									<button type="submit" class="my-3 btn btn-info">Rechercher</button>
								</div>		
							</div>	
						</form>				
					</div>
				</div>
				<div class="mt-5 row " <?php if(empty($_POST['select_agence'])){ echo 'hidden';}?> >
					<div class="offset-lg-1 offset-xs-1 offset-md-1">
						<div class="card border-dark mb-3" style="max-width: 18rem;">
						<div class="card-header">Cnam Location <?= $data_agence['Ville_AG'] ?></div>
							<div class="card-body text-dark">
								<section class="card-text">
									<p><?= $data_agence['Rue_AG'] ?></p>
									<p><?= $data_agence['CP_AG'] ?> <?= $data_agence['Ville_AG'] ?></p>
									<p>Tel : <?= $data_agence['Tel_AG'] ?></p>
									<p>Horaires : <br>
									Du Lundi au Samedi de 8h00 à 19h00</p>
								</section>
							</div>
						</div>
					</div>
				</div>
			</div>

