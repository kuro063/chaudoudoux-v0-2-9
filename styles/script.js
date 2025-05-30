  // Tri dynamique de tableau HTML
  // Auteur : Copyright © 2015 - Django Blais
  // Source : http://trucsweb.com/tutoriels/Javascript/tableau-tri/
  // Sous licence du MIT.
  function twInitTableau() {
    // Initialise chaque tableau de classe « avectri »
       [].forEach.call( document.getElementsByClassName("avectri"), function(oTableau) {
       var oEntete = oTableau.getElementsByTagName("tr")[0];
       var nI = 1;
  	  // Ajoute à chaque entête (th) la capture du clic
  	  // Un picto flèche, et deux variable data-*
  	  // - Le sens du tri (0 ou 1)
  	  // - Le numéro de la colonne
      [].forEach.call( oEntete.querySelectorAll("th"), function(oTh) {
        oTh.addEventListener("click", twTriTableau, false);
        oTh.setAttribute("data-pos", nI);
        if(oTh.getAttribute("data-tri")=="1") {
         oTh.innerHTML += "<span class=\"flecheDesc\"></span>";
        } else {
          oTh.setAttribute("data-tri", "0");
          oTh.innerHTML += "<span class=\"flecheAsc\"></span>";
        }
        // Tri par défaut
        if (oTh.className=="selection") {
          oTh.click();
        }
        nI++;
      });
    });
  }
  
  function twInit() {
    twInitTableau();
  }
  function twPret(maFonction) {
    if (document.readyState != "loading"){
      maFonction();
    } else {
      document.addEventListener("DOMContentLoaded", maFonction);
    }
  }
  twPret(twInit);

  function twTriTableau() {
    // Ajuste le tri
    var nBoolDir = this.getAttribute("data-tri");
    this.setAttribute("data-tri", (nBoolDir=="0") ? "1" : "0");
    // Supprime la classe « selection » de chaque colonne.
    [].forEach.call( this.parentNode.querySelectorAll("th"), function(oTh) {oTh.classList.remove("selection");});
    // Ajoute la classe « selection » à la colonne cliquée.
    this.className = "selection";
    // Ajuste la flèche
    this.querySelector("span").className = (nBoolDir=="0") ? "flecheAsc" : "flecheDesc";

    // Construit la matrice
    // Récupère le tableau (tbody)
    var oTbody = this.parentNode.parentNode.parentNode.getElementsByTagName("tbody")[0]; 
    var oLigne = oTbody.rows;
    var nNbrLigne = oLigne.length;
    var aColonne = new Array(), i, j, oCel;
    for(i = 0; i < nNbrLigne; i++) {
      oCel = oLigne[i].cells;
      aColonne[i] = new Array();
      for(j = 0; j < oCel.length; j++){
        aColonne[i][j] = oCel[j].innerHTML;
      }
    }

    // Trier la matrice (array)
    // Récupère le numéro de la colonne
    var nIndex = this.getAttribute("data-pos");
    // Récupère le type de tri (numérique ou par défaut « local »)
    var sFonctionTri = (this.getAttribute("data-type")=="num") ? "compareNombres" : "compareLocale";
    // Tri
    aColonne.sort(eval(sFonctionTri));
    // Tri numérique
    function compareNombres(a, b) {return a[nIndex-1] - b[nIndex-1];}
    // Tri local (pour support utf-8)
    function compareLocale(a, b) {return a[nIndex-1].localeCompare(b[nIndex-1]);}
    // Renverse la matrice dans le cas d’un tri descendant
    if (nBoolDir==0) aColonne.reverse();
    
    // Construit les colonne du nouveau tableau
    for(i = 0; i < nNbrLigne; i++){
      aColonne[i] = "<td>"+aColonne[i].join("</td><td>")+"</td>";
    }

    // assigne les lignes au tableau
    oTbody.innerHTML = "<tr>"+aColonne.join("</tr><tr>")+"</tr>";
  }
/*function test_form(nom, prenom)
{
	if(nom.value=="")
   		{
			alert('Vous devez écrire un message !')
       		nom.focus();return false 
		}
	if(prenom.value=="")
		{
			alert('Vous devez taper un pseudo !')
       		prenom.focus();return false
		}
	return true
}*/  window.addEventListener("load", initGestionEvenements); // affecte la fonction initGestionEvenements au chargement de la page
var index=0;
    function initGestionEvenements () {

       var leForm = document.forms[0] ; // désigne le premier formulaire de la page, à adapter si besoin
       var leForm1 = document.forms[1] ;
       var leForm2 = document.forms[2] ;
       if ( leForm != null ) // ce premier formulaire existe-t-il bien ?

       {

             leForm.addEventListener("submit", traiteFormSubmit); // affecte la fonction traiteFormSubmit lors du déclenchement de l'évt submit sur le formulaire
       }           
        if ( leForm1 != null ) // ce premier formulaire existe-t-il bien ?

       {

             leForm1.addEventListener("submit", traiteFormSubmit); // affecte la fonction traiteFormSubmit lors du déclenchement de l'évt submit sur le formulaire

       }           
        if ( leForm2 != null ) // ce premier formulaire existe-t-il bien ?

       {

             leForm2.addEventListener("submit", traiteFormSubmit); // affecte la fonction traiteFormSubmit lors du déclenchement de l'évt submit sur le formulaire

       }           
    }
  function traiteFormSubmit(evt) {

       var ok ;

       ok = window.confirm("Confirmez-vous l'envoi des données ?");

       if ( !ok )

       {

             evt.preventDefault(); // annule l'événement submit sur le formulaire

       }           

    }   

 /* 
  function champsupp(evt)
  { index++;
      while (index <10)
      {
      var selectLabel=document.createElement('label');
      selectLabel.setAttribute('for','slctJour');
      selectLabel.text="le :";
      var select = document.createElement('select');
      select.setAttribute('name', 'slctJour'+index);
      var lundi= document.createElement('option');
      lundi.setAttribute('value', 'lundi');
      var mardi= document.createElement('option');
      mardi.setAttribute('value', 'mardi');
      var mercredi= document.createElement('option');
      mercredi.setAttribute('value', 'mercredi');
      var jeudi= document.createElement('option');
      mercredi.setAttribute('value', 'jeudi');
      var vendredi= document.createElement('option');
      vendredi.setAttribute('value', 'vendredi');
      var samedi= document.createElement('option');
      samedi.setAttribute('value', 'samedi');
      var dimanche= document.createElement('option');
      dimanche.setAttribute('value', 'dimanche');
      lundi.text="Lundi";
      mardi.text="Mardi";
      mercredi.text="Mercredi";
      jeudi.text="Jeudi";
      vendredi.text="Vendredi";
      samedi.text="Samedi";
      dimanche.text="Dimanche";
      select.add(lundi);
      select.add(mardi);
      select.add(mercredi);
      select.add(jeudi);
      select.add(vendredi);
      select.add(samedi);
      select.add(dimanche);
      var selectLabel1=document.createElement('label');
      selectLabel1.text="de :";
      var Hdeb = document.createElement('select');
      Hdeb.setAttribute('name', 'Hdeb'+index);
      for (i=0;i<25;++i){
      if (i<10){
          var k='0'+i;
      } else {k=i;}}
      Hdeb.add(document.createElement('option').setAttribute('value', k));
      var minDeb = document.createElement('select');
      minDeb.setAttribute('name', 'minDeb'+index);
      minDeb.add(document.createElement('option').setAttribute('value', '00'));
      minDeb.add(document.createElement('option').setAttribute('value', '30'));
      var selectLabel2=document.createElement('label');
      selectLabel2.text="à :";
      var Hfin = document.createElement('select');
      Hfin.setAttribute('name', 'Hfin'+index);
      for (i=0;i<25;++i){
      if (i<10){
          var k='0'+i;
      } else {k=i;}}
      Hdeb.add(document.createElement('option').setAttribute('value', k));
      var minFin = document.createElement('select');
      minFin.setAttribute('name', 'minFin'+index);
      minFin.add(document.createElement('option').setAttribute('value', '00'));
      minFin.add(document.createElement('option').setAttribute('value', '30'));
      }
  }*/
/*function sur()
{
           var ok;
    window.confirm("Etes vous sûr ?");
           if ( !ok )

       {

             event.preventDefault(); // annule l'événement submit sur le formulaire

       }    
}*/
  var element=document.getElementById('archive');
element.addEventListener('change', function()
{
    window.alert("Merci d'entrer une date d'entrée / sortie et de vérifier que toutes les informations sont à jour.\n\
    Pensez à mettre à jour le planning et à l'imprimer");
});
function verifNumTel()
{
    var ok = true;
    var txtPort = document.getElementById("txtPort");
    if (txtPort.value.length < 10)
    {
       txtPort.style.backgroundColor = "rgb(255,0,0)";
    }
    var txtFixe = document.getElementById("txtFixe");
    if (txtFixe.value.length < 10)
    {
        txtFixe.style.backgroundColor = "rgb(255,0,0)";

    }
    var txtUrg=document.getElementById("txtUrg");
    if ( txtUrg.value.length < 10)
    {
       txtUrg.style.backgroundColor = "rgb(255,0,0)";

    }

    var txtTS = document.getElementById("txtTS");
    if ( txtTS.value.length <9)
    {
        txtTS.style.backgroundColor = "rgb(255,0,0)";

    }
    var numSS= document.getElementById("txtNumSS");
        if ( numSS.value.length < 15)
            {
    
        numSS.style.backgroundColor = "rgb(255,0,0)";

    }
    var txtCp= document.getElementById("txtCp");
    if(Number.isNaN(txtCp)||txtCp.value.length < 5)
    {
          txtCp.style.backgroundColor = "rgb(255,0,0)";
    }
    return ok;
    }
  function changeForm1() {
		var dec = document.getElementById("decision").elements["btnDecision"].value;
		if(dec == "non") {
			document.getElementById("raison").setAttribute("style", "display:block");
                        document.getElementById("ok").setAttribute("style", "display:none");
		} else if (dec == "oui") {
			document.getElementById("raison").setAttribute("style", "display:none");
                        document.getElementById("ok").setAttribute("style", "display:block");
		} else {
			document.getElementById("raison").setAttribute("style", "display:none");
                        document.getElementById("ok").setAttribute("style", "display:block");
		}
	}
function changeForm() {
		var typePers = document.getElementById("formType").elements["categ"].value;
		//alert("id+categ+value="+document.getElementById("formType").elements["categ"].value+" - "+typePers);
		switch (typePers) {
			case "Famille" :
				document.getElementById("filtreFam").setAttribute("style", "display:block");
				document.getElementById("filtreInterv").setAttribute("style", "display:none");
				document.getElementById("filtreCandid").setAttribute("style", "display:none");
                                document.getElementById("filtreFact").setAttribute("style", "display:none");
				break;

			case "Interv" :
				document.getElementById("filtreInterv").setAttribute("style", "display:block");
				document.getElementById("filtreFam").setAttribute("style", "display:none");
				document.getElementById("filtreCandid").setAttribute("style", "display:none");
                                document.getElementById("filtreFact").setAttribute("style", "display:none");
				break;
		
			case "Candid" :
				document.getElementById("filtreInterv").setAttribute("style", "display:none");
				document.getElementById("filtreFam").setAttribute("style", "display:none");
                                document.getElementById("filtreFact").setAttribute("style", "display:none");
				document.getElementById("filtreCandid").setAttribute("style", "display:block");
				break;
                            case "Fact" :
                                document.getElementById("filtreInterv").setAttribute("style", "display:none");
				document.getElementById("filtreFam").setAttribute("style", "display:none");
				document.getElementById("filtreCandid").setAttribute("style", "display:none");

			default :
				document.getElementById("filtreInterv").setAttribute("style", "display:none");
				document.getElementById("filtreFam").setAttribute("style", "display:none");
				document.getElementById("filtreCandid").setAttribute("style", "display:none");
                                document.getElementById("filtreFact").setAttribute("style", "display:block");
				break;
		}
}

	function codeCli() {
		var codeCli = document.getElementById("formFam").elements["btnCodeCli"].value;
		switch(codeCli) {
			case "oui" :
				document.getElementById("txtCodCli").setAttribute("style", "display:inline");
				break;

			case "non" : 
				document.getElementById("txtCodCli").setAttribute("style", "display:none");
				break;

			default : 
				document.getElementById("txtCodCli").setAttribute("style", "display:none");
				break;
                }}
            var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("navbar").style.top = "0";
  } else {
    document.getElementById("navbar").style.top = "-50px";
  }
  prevScrollpos = currentScrollPos;
}

window.alert = function() {};