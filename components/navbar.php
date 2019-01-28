<header>
    
    <nav class="navbar navbar-inverse navbar-expand-md navbar-dark fixed-top bg-light" id="nav">
        <a class="navbar-brand" href="./index.php?action=accueil">
            <img src="./images/logo_blanc.png" width="200" height="53" alt="">
        </a>

        <!--Collapse button-->
        
        <button type="button" class="navbar-toggler"  data-toggle="collapse" data-target="#sandwich" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!--Navigation-->
        <div class="collapse navbar-collapse" id="sandwich">
            <ul class="navbar-nav ml-auto">
                <!--Accueil-->
                <li class="nav-item active">
                    <a class="nav-link" href="index.php?action=accueil">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <!--/.Acceuil-->
                <!--Menu-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Menu
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="index.php?action=accueil">Accueil</a>
                        <a class="dropdown-item" href="index.php?action=nos_vehicules"> Nos véhicules</a>
                        <a class="dropdown-item" href="index.php?action=agences"> Nos agences</a>
                        <a class="dropdown-item" href="index.php?action=devis">Devis</a>
                        <a class="dropdown-item" href="index.php?action=espace_perso">Mon compte</a>
                        <a class="dropdown-item" href="index.php?action=faq">Des questions ?</a>
                        <a class="dropdown-item" href="index.php?action=fidelite">Programme fidélité</a>
                        <a class="dropdown-item" href="index.php?action=cnam_car">Qui sommes-nous ?</a>
                        <a class="dropdown-item" href="index.php?action=mentions">Mentions légales</a>
                        <a class="dropdown-item" href="index.php?action=confidentialite">Confidentialité</a>
                        <a class="dropdown-item" href="index.php?action=contact">Contact</a>
                    </div>
                </li>
                <!--/.Menu-->
                <?php if(!empty($_SESSION['login'])){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=deconnexion" style="color: white !important;">Déconnexion</a>

                </li>      
                <?php }else{ ?>
                <!--Connexion-->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Connexion</a>
                </li>
                <!--/.Connexion-->
                <?php } ?>
            </ul>
        </div>
        <!--/.Navigation-->
    </nav>
    <!--Login modal-->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Mon compte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="compte_login.php?action=login" method="post"><!-- Formulaire -->
                        <div class="form-group"> 
                            <label for="login">E-mail</label>
                            <input type="email" class="form-control" name="login" id="login">
                        </div>
                        <div class="form-group">
                            <label for="pass">Mot de passe</label>
                            <input type="password" class="form-control" name="pass" id="pass"">
                        </div>
                        <button type="submit" class="btn btn-info">Connexion</button>
                    </form><!-- Formulaire -->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="compte_login.php">Nouveau client ? Inscription</a>
                </div>

            </div>

        </div>
    </div>
    <!-- </div> -->

</header>
<!--/.Login modal-->
<main class="container" role="main" style=" min-height: 100%">
