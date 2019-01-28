// Fonctions JQuery :

// Calendrier page d'accueil

$(document).ready(function(){

  // Mise en fraçais du calendrier :
  $.datepicker.regional['fr'] = {
      closeText: 'Fermer',
      prevText: 'Précédent',
      nextText: 'Suivant',
      currentText: 'Aujourd\'hui',
      monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
      monthNamesShort: ['Janv.','Févr.','Mars','Avril','Mai','Juin','Juil.','Août','Sept.','Oct.','Nov.','Déc.'],
      dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
      dayNamesShort: ['Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.'],
      dayNamesMin: ['D','L','M','M','J','V','S'],
      weekHeader: 'Sem.',
      dateFormat: 'dd-mm-yy',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''
  };
  $.datepicker.setDefaults($.datepicker.regional['fr']);

  // fonction pour le calendrier :
  $(function(){
    var dateFormat = "dd-mm-yy",
    date_depart = $("#date_depart")
    .datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      numberOfMonths: 1,
      minDate: new Date
    })
    .on("change", function(){
      date_arrivee.datepicker( "option", "minDate", getDate( this ));
    }),
    date_arrivee = $("#date_arrivee").datepicker({
      defaultDate: "+2d",
      changeMonth: true,
      numberOfMonths: 1,
      minDate: new Date
    })
    .on("change", function(){
      date_depart.datepicker("option", "maxDate", getDate( this ));
    }); 
    function getDate(element){
      var date;
      try{
        date = $.datepicker.parseDate( dateFormat, element.value );

      }catch( error ){
        date = null;
      }  
      return date;
    }
  });
// fin calendrier

// carte des agences
  // $('.fullmap').css({
  //               width : '600px',
  //               height : '350px'}).gmap3();
  // $(‘.fullmap > img’).css( ‘max-width’, ‘none’);
});

// Fonctions Javascript :

// Vérification formulaire page devis

function surligne(champ, erreur)
{
  if(erreur){
    champ.style.backgroundColor = "#fba";

  }else{
    champ.style.backgroundColor = "";
  }
}
function verifNom(champ){
  var regex = /^[a-zA-Zàâéèëêïîôùüçœ\'’ -]{2,25}$/;

  if(!regex.test(champ.value)){
    surligne(champ, true);
    document.getElementById("erreur_nom").innerHTML ="Votre nom ne peut pas comporter de chiffres <br> Il faut au minimum deux caractères !   ";
    return false;

  }else{
    surligne(champ, false);
    return true;
	}
}
function verifPrenom(champ){
  var regex = /^[a-zA-Zàâéèëêïîôùüçœ\'’ -]{2,25}$/;

  if(!regex.test(champ.value)){
    surligne(champ, true);
    document.getElementById("erreur_prenom").innerHTML ="Votre nom ne peut pas comporter de chiffres <br> Il faut au minimum deux caractères !   ";
    return false;

  }else{
    surligne(champ, false);
    return true;
  }
}
function verifAdresse(champ){
  var NewRegex = /^[a-zA-Z0-9àâéèëêïîôùüçœ\'’ ._ ,]{5,60}$/;

  if(!NewRegex.test(champ.value)){
    surligne(champ, true);
    document.getElementById("erreur_Adresse").innerHTML ="Votre adresse doit comporter un numéro et le nom de la rue.";
    return false;

  }else{
    surligne(champ, false);
    return true;
  }
}
function verifVille(champ){
  var regex = /^[a-zA-Zàâéèëêïîôùüçœ\'’ -]{2,25}$/;

  if(!regex.test(champ.value)){
    surligne(champ, true);
    document.getElementById("erreur_Ville").innerHTML ="Entrez le nom de votre ville.";
    return false;
  }else{
    surligne(champ, false);
    return true;
  }
}
function verifCP(champ){
   var regex = /^([0-9]{5})$/;

  if(!regex.test(champ.value)){    
    surligne(champ, true);
    document.getElementById("erreur_cp").innerHTML ="ex : 59000 ";
    return false;
  }else{
    surligne(champ, false);
    return true;
  }
}
function verifTel(champ){
   var regex = /^0[1-9]([-. ]?[0-9]{2}){4}$/;

  if(!regex.test(champ.value)){
    surligne(champ, true);
    document.getElementById("erreur_tel").innerHTML="Exemple : votre numéro doit commencer par 0 et comporter 10 chiffres en tout.";
    return false;
  }else{
    surligne(champ, false);
    return true;
  }
}
function verifForm(f){
  var NomOk = verifNom(f.Nom);

  var PrenomOk = verifPrenom(f.Prenom);

  var  AdresseOk = verifAdresse(f.voie);

  var VilleOk = verifVille(f.ville);

  var CPOk = verifCP(f.cp);

  var TelOk = verifTel(f.Num_Tel);

  if(NomOk && PrenomOk && AdresseOk && VilleOk && CPOk && TelOk){
  return true;

  }else{
    alert("Veuillez remplir correctement tous les champs.");
    return false;
  }
}

// Vérification formulaire page paiement :

function verifCarte(champ){
   var regex =  /^[0123456789]{16}$/;

  if(!regex.test(champ.value)){
    surligne(champ, true);
    document.getElementById("erreur_carte").innerHTML="Votre numéro doit comporter 16 chiffres en tout !";
    return false;

  }else{
    surligne(champ, false);
    return true;
  }
}
function verifCrypto(champ){
   var regex =  /^[0123456789]{3}$/;

  if(!regex.test(champ.value)){
    surligne(champ, true);
    document.getElementById("erreur_crypto").innerHTML="Votre numéro doit comporter 3 chiffres en tout !";
    return false;

  }else{
    surligne(champ, false);
    return true;
  }
}
function verifPaiement(f){
  var numCarteOk = verifCarte(f.carte_number); 

  var cryptoOk = verifCrypto(f.carte_crypto);

  if(numCarteOk && cryptoOk){
    return true;

  }else{
    alert("Veuillez remplir correctement tous les champs.");
    return false;
  }
}