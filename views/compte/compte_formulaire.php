<?php ob_start(); ?>
<div class="row">
	<div class="card mt-3 col-md-5">
		<form action="compte_login.php?action=login" method="post">
			<legend>Identification</legend>
			<div class="form-group">
				<div class="col-md-8 mb-3">
					<label for="login_mail">Adresse E-mail</label>
					<input type="email" name="login" class="form-control" id="login_mail" aria-describedby="emailHelp" placeholder="Entrez votre e-mail">
					<small id="emailHelp" class="form-text text-muted">Ne partagez pas votre e-mail et votre mot de passe.</small>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-8 mb-3">
					<label for="pass">Mot de passe</label>
					<input type="password" class="form-control" id="pass" name="pass" placeholder="Entrez votre mot de passe">
				</div>
			</div>
			<div class="row ml-2">
				<form action="index.php?action=accueil" method="post">
					<button class="btn btn-info" type="submit">Se Connecter</button>			    
				</form>
			</div>
		</form>
	</div>
	<div class="card mt-3 offset-md-1 col-md-5">
		<form action="compte_login.php?action=create_login" method="post">
			<legend>Nouveau Compte</legend>
			<div class="form-group">
				<div class="col-md-8 mb-3">
					<label for="sign_mail">Adresse E-mail</label>
					<input type="email" name="login" class="form-control" id="sign_mail" aria-describedby="emailHelp" placeholder="Entrez votre e-mail">
					<small id="emailHelp" class="form-text text-muted">Ne partagez pas votre e-mail et votre mot de passe.</small>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-8 mb-3">
					<label for="sign_pass">Mot de passe</label>
					<input type="password" class="form-control" id="sign_pass" name="pass" placeholder="Entrez votre mot de passe">
				</div>
			</div>
			<div class="row ml-2">
				<form action="index.php?action=accueil" method="post">
					<button class="btn btn-info" type="submit">Créer un compte</button>	                
				</form>
			</div>
		</form>
	</div>
</div>
<?php $compte_formulaire = ob_get_clean(); ?>