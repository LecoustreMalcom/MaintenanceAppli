function verifDeconnexion(){
    var reponse = confirm("Voulez-vous vous déconnecter ?");
    if (reponse){
        window.location.href = "?deconnexion=1";
    }
}
