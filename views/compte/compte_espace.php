<!-- <div class="container"> -->	
	<h1>Mon Compte</h1>
	
	<div>
		<!-- ERREUR -->
		<?php if (!empty($_SESSION['message_erreur'])) {?>
		<div class="alert alert-danger" role="alert"><?=$_SESSION['message_erreur'] ?></div>
		<?php $_SESSION['message_erreur'] = false; }?>
		<!-- /ERREUR -->
		<?php if(!empty($_SESSION['login'])){ ?>
			<h5>Vous êtes connecté</h5>
		<?php } ?>
	</div>
	<!-- </div> -->

	<?= $compte_formulaire ?>
	<?= $compte_fidele ?>
	<?= $compte_admin ?>



