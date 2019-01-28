
<h1 class="mb-5">Paiement</h1>

<form action="index.php?action=validation_paiement" method="post" onsubmit="return verifPaiement(this)">

    <!-- FORMULAIRE DE PAIEMENT -->
    <div class="mt-5 card">
        <div class="card-header entete">
            <div class="panel-heading"><img src="images/lock.png"> Paiement sécurisé </div> 
        </div>
        
        <div class="mt-4 card-block"> 
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-lg-12"><strong>Type de carte</strong></div>
                    <div class="col-lg-12">
                        <select id="CreditCardType" name="CreditCardType" class="form-control input-sm">
                            <option value="VISA">VISA</option>
                            <option value="CB">CB</option>
                            <option value="MASTERCARD">MASTERCARD</option>
                            <option value="AMERICAN_EXPRESS">AMERICAN EXPRESS</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12"><strong>Numéro de carte :</strong></div>
                    <div class="col-lg-12">
                        <input type="text" class="form-control" name="carte_number" value="" onchange="verifCarte(this)">
                        <small id="erreur_carte"></small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12"><strong>Cryptogramme :</strong></div> 
                    <div class="col-lg-12">
                        <input type="text" class="form-control" name="carte_crypto" value="" onchange="verifCrypto(this)">
                        <small id="erreur_crypto"></small>
                    </div>
                </div>
                <div class="form-inline">
                    <div class="col-lg-12">
                        <strong>Date d'expiration</strong>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <select class="custom-select mb-2 mr-sm-2 mb-sm-0" name="">
                            <option value="">Mois</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <select class="custom-select mb-2 mr-sm-2 mb-sm-0" name="">
                            <option value="">Année</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2026</option>
                            <option value="2025">2027</option>
                            <option value="2025">2028</option>
                            <option value="2025">2029</option>
                            <option value="2025">2030</option>
                            <option value="2025">2031</option>
                            <option value="2025">2032</option>
                            <option value="2025">2033</option>
                            <option value="2025">2034</option>
                            <option value="2025">2035</option>
                            <option value="2025">2036</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="mx-auto">
            <div class="form-inline my-3">
                <button type="submit" class="btn btn-info">Réserver</button>
                <form action="index.php?action=accueil" method="post">  
                    <button class="ml-2 btn btn-secondary" type="submit" action="index.php?action=accueil" method="">Annuler</button>   
                </form>                
            </div>
        </div>
    </div>
</form>

    <!--CREDIT CART PAYMENT END-->
