<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $nom string */
/* @var $prenom string */
/* @var $libOption string */
/* @var $adr string */
/* @var $codePostal string */
/* @var $ville string */
/* @var $tel string */
/* @var $email string */

?>
<!-- Division pour le contenu principal -->
<div id="contenu" style="overflow-x:hidden;padding: 0px 10px 0px 10px;margin-bottom:60px">
<h1 style="text-align:center">Nouveau candidat</h1>
<form id="frmPerso" enctype="multipart/form-data" action="index.php?uc=annuCandid&amp;action=validerAjoutCandid" method="post">

<?php
  if ( nbErreurs($tabErreurs) != 0 ) {
      echo toHtmlErreurs($tabErreurs);
    } ?>
<?php
        if ( !empty($messageInfo) ) {?>
            <p class="info"><?php echo $messageInfo; ?></p>
<?php } ?>

<div id="corpsForm" style="border:none">
  <fieldset>
    
    <!--<div style="display: flex; flex-direction: row">
    <div style="display: flex; flex-direction: column">-->

    <legend class="alignText" method="post">INFORMATIONS PERSONNELLES </legend>
    <p>
      <label for="slctTitre">Titre : </label>
      <select id="slctTitre" name="slctTitre">
        <option value="MR" >MR.</option>
        <option value="MME" selected>MME.</option>
      </select>
    </p>

    <p>
      <label for="txtNom">Nom :* </label>
      <input id="txtNom" name="txtNom" size="30" required/>
    </p>

    <p>
        <label  method="post" for="nomJF">Nom de jeune fille : </label>
        <input  method="post" type="text" name="nomJF" size="20"/>
    </p>

    <p>
      <label for="txtPrenom">Prenom :* </label>
      <input id="txtPrenom" name="txtPrenom" size="20" required/>
    </p>

  <p>
    <label for="txtAdr">Adresse : </label>
    <input id="txtAdr" name="txtAdr" maxlength="255" size="70"/>
  </p>


  
  <p>
    <label for="txtVille">Ville : </label>
    <input list="my-select" type="text" name="txtVille" id="txtVille">

    <datalist id="my-select"></datalist>
  </p>
  <script>
    var array =  <?php echo(file_get_contents("./assets/apicommunes/communes.json"));?>;
    var mySelect = document.getElementById('my-select');

    for (i = 0; i < array.length; i++){
        var opt = document.createElement('option');
        opt.value = (array[i].nom);
        opt.innerHTML = (array[i].nom);
        mySelect.appendChild(opt);
    }
  </script>

<p>
  	<label for="txtCp">Code postal : </label>
  	<input  id="txtCp" list="my--select" name="txtCp" size="5" maxlength="5" pattern="^[0-9]{5}$" />

    <datalist id="my--select"></datalist>
  </p>
  <script>
    var array =  <?php echo(file_get_contents("./assets/apicommunes/communes.json"));?>;

    var menuVilles = document.getElementById("txtVille");
    menuVilles.addEventListener("blur" , function(){
        removeCp();
        obtCp();      
    });

        var mySelect = document.getElementById('my--select');

    function removeCp(){
        var options = mySelect.querySelectorAll("option");
        for (o = options.length-1 ; o>=0 ; o--) {
            mySelect.removeChild(options[o]);
        } 
        document.getElementById('txtCp').value = "";
    }

    function obtCp(){
        var ville = document.getElementById("txtVille").value;
        for (i = 0; i < array.length; i++){
            if (array[i].nom == ville){
                if(array[i].codesPostaux.length == 1){
                  document.getElementById("txtCp").value = array[i].codesPostaux[0];
                }else{
                    for (u = 0; u < array[i].codesPostaux.length ; u++) {
                        var opt = document.createElement('option');
                        opt.value = (array[i].codesPostaux[u]);
                        opt.innerHTML = (array[i].codesPostaux[u]);
                        mySelect.appendChild(opt);
                    }
                }
                
            }
        }
    }
  </script>
  <p>
    <label for='secteurCandidat'> Secteur de Rennes (centre) : </label>
    <select name="slctSecteur">
      <option value="Aucun" selected>Aucun</option>
      <option value="Nord">Nord</option>
      <!-- <option value="Nord-Est">Nord Est</option> -->
      <option value="Est">Est</option>
      <!-- <option value="Sud-Est">Sud Est</option> -->
      <option value="Sud">Sud</option>
      <!--<option value="Sud-Ouest">Sud Ouest</option> -->
      <option value="Ouest">Ouest</option>
      <!--<option value="Nord-Ouest">Nord Ouest</option> -->
    </select>
  </p>
  <p>
    <label for="txtQuart">Quartier : </label>
    <input id="txtQuart" name="txtQuart"  size="20" />
  </p>
  <p>
    <label for="txtPort">Téléphone portable : </label>
    <input id="txtPort" name="txtPort" maxlength="15" size="10" onfocusout="verifNumTel()"/>
  </p>
  <p>
    <label for="txtFixe">Téléphone fixe : </label>
    <input id="txtFixe" name="txtFixe" maxlength="15" size="10" onfocusout="verifNumTel()"/>
  </p>
  <p>
    <label for="txtUrg">Téléphone en cas d'urgence : </label>
    <input id="txtUrg" name="txtUrg" maxlength="15" size="10" onfocusout="verifNumTel()"/>
  </p>
  <p>
    <label for="txtEmail" accesskey="t">E-mail : </label>
    <input id="txtEmail" name="txtEmail" size="30"/>
  </p>
  </div>
  <!--<div style="display: flex; flex-direction: column; margin-left: 10%;margin-top:30px">-->
    <p>
      <label for="dateNaiss">Date de naissance :* </label>
      <input type="date" id="dateNaiss" name="dateNaiss" required/>
    </p>
    <p>
    <label for="txtLieuNaiss">Lieu de naissance : </label>
    <input id="txtLieuNaiss" name="txtLieuNaiss" size="20"/>
  </p>
  <p>
    <label for="txtPaysNaiss">Pays de naissance : </label>
    <input id="txtPaysNaiss" name="txtPaysNaiss" size="20"/>
  </p>
  <p>
    <label for="txtNumSS">N° de sécurité sociale : </label>
    <input id="txtNumSS" name="txtNumSS" maxlength="25" size="25"/>
  </p>
    <p>
    <label for="txtMutuelle">Mutuelle : </label>
    <input id="txtMutuelle" name="txtMutuelle" maxlength="40" size="15"/>
  </p>
    <p>
    <label for="chkCMU">CMU : </label>
    <input id="chkCMU" name="chkCMU" type="checkbox" value="1" />
  </p>
  <p>
    <label for="txtNatio">Nationalité : </label>
    <input id="txtNatio" name="txtNatio" size="20"/>
  </p>
   <p>
    <label for="txtTS">Titre de séjour : </label>
    <input id="txtTS" name="txtTS" maxlength="10" onblur="verifNumTel()" size="10"/>
  </p>
      <p>
      <label for="slctStatPro">Statut professionnel : </label>
      <select id="slctStatPro" name="slctStatPro">
        <option value="ETUDIANT">Etudiant</option>
        <option value="PROFESSIONNEL">Professionnel</option>
        <option value="PRO <26ans">Pro <26ans</option>
      </select>
    </p>
  <p>
      <label for="slctSitFam">Situation familiale : </label>
      <select id="slctSitFam" name="slctSitFam">
        <option value="CELIBATAIRE">Célibataire</option>
        <option value="EN COUPLE">En couple</option>
        <option value="MARIE">Marié(e)</option>
        <option value="PACSE">Pacsé(e)</option>
        <option value="VEUF">Veuf(ve)</option>
      </select>
    </p>
    <br/></div></div>
  </fieldset>

  <br/>




  
  <fieldset style="margin-bottom:30px">
    <legend class="alignText">INFORMATIONS PROFESSIONNELLES</legend>
    <p>
      <label for="txtDip">Diplômes : </label>
      <textarea id="txtDip" name="txtDip"  cols="70" ></textarea>
    </p>
    <p>
      <label for="txtQualifs">Qualifications : </label>
      <textarea id="txtQualifs" name="txtQualifs"  cols="70" ></textarea>
    </p>
    <p>
        <label for="travailVoulu">Enfants/Ménage/Tout :</label>
        <select name="travailVoulu">
            <option value="ENFANT">Garde d'enfants</option>
            <option value="MENAGE">Ménage</option>
            <option value="TOUT">Tout</option>
            <option value="EMPLOYÉ">Employé</option>
        </select>
    </p>
    <p>
      <label for="chkPermis">Permis :</label>
      <input type="checkbox" id="chkPermis" name="chkPermis" value="1" />
    </p>
    <p>
      <label for="chkVehicule">Vehicule :</label>
      <input type="checkbox" id="chkVehicule" name="chkVehicule" value="1" />
    </p>
    <p>
      <label for="txtObs">Observations : </label>
      <textarea id="txtObs" name="txtObs" rows="2" cols="70"></textarea>
    </p>
     <p>
      <label for="txtDispo">Disponibilités : </label>
      <textarea id="txtDispo" name="txtDispo"  cols="70" ></textarea>
    </p>
    <br>
  </br>
                  
                      
  </fieldset>
  </div>
  
   <input class="btn valider btn-secondary" style="position:fixed; bottom:0px;left:0px" id="cmdOk" type="submit" value="AJOUTER" />

  
<button style="position:fixed;bottom:0px;right:0px" class="retour btn" onclick="history.go(-1);">RETOUR</button>
  
  </form>
</div>      


