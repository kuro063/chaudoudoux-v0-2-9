<?php error_reporting(0);
// vérification du droit d'accès au cas d'utilisation
if ( ! estConnecte() ) {
    ajouterErreur("L'accès à cette page requiert une authentification !", $tabErreurs);
    include('vues/v_erreurs.php');
}
// var_dump($_POST)
?>
<script type="text/javascript">



  function ajoutEnf() {
    var tableau = document.getElementById("tableEnfant");
    var nblignes = tableau.rows.length;
    document.getElementById("nbEnfants").value = nblignes;
    var ligne = tableau.insertRow(-1);
    cell = ligne.insertCell(0);
    cell.innerHTML = "<input type=\"text\" class=\"donnees\" name=\"nomEnf"+(nblignes)+"\" size=\"15\">";
    cell = ligne.insertCell(1);
    cell.innerHTML = "<input type=\"text\" class=\"donnees\" name=\"prenomEnf"+(nblignes)+"\" size=\"15\">";
    cell = ligne.insertCell(2);
    cell.innerHTML = "<input type=\"date\" class=\"donnees\" name=\"dateNaiss"+(nblignes)+"\" value=\"\" />";
    cell = ligne.insertCell(3);
    cell.innerHTML = "";
  }
</script>



<div id="contenu" style="overflow-x:hidden;padding: 0px 10px 0px 10px;margin-bottom:50px">
  <h1 style="text-align:center">Fiche de la famille <?php $noms = "";
  foreach ($parents as $parent){
  if($noms != $parent['nom_Parents']."-")
  $noms.=$parent['nom_Parents']."-";
  }
  $noms=substr($noms, 0, strlen($noms)-1);
  echo $noms; 
  echo ' ('.$num.')';?>
  </h1>



<form id="formModifFamille" enctype="multipart/form-data" action="index.php?uc=annuFamille&amp;action=validerModifFamille&amp;num=<?php echo $num?>" method="post">
  <div id="corpsForm" style="border : none">


<fieldset>
<legend class="alignText">INFORMATIONS ADMINISTRATIVES</legend>



<p>
<!--div de gauche pour mandataire-->
<div style="border-color: black;  display: flex; flex-direction: row;width: 100%">
<div style ="border-color: black;  display: flex; flex-direction: column;width: 45%; border: solid black 1px; margin-right: 10%">


<p>
<label class="container1" for="chkMand1" style="margin-left:20px;margin-top:20px;font-size:1.1em">Mandataire Régulier
<input type="radio" name="chkMand" id="chkMand1" value="1" <?php if($mand==1 && $reg=="REG"){echo 'checked';}?>/>
<span class="checkmark1"></span>
</label><br>
</p>

<p>
<label class="container1" for="chkMand2" style="margin-left:20px;margin-top:20px;font-size:1.1em">Mandataire Occasionnel
<input type="radio" name="chkMand" id="chkMand2" value="2" <?php if($mand==1 && $reg=="OCC"){echo 'checked';}?>/>
<span class="checkmark1"></span>
</label><br>
</p>

<p>
<label class="container1" for="chkMand0" style="margin-left:20px;margin-top:20px;font-size:1.1em">N'EST PAS MANTADAIRE (coché par défaut)
<input type="radio" name="chkMand" id="chkMand0" value="0" <?php if($mand==0 && $reg==""){echo 'checked';}?>/>
<span class="checkmark1"></span>
</label>
</p>

<p>
  <label for="option" style="margin-left:20px;font-size:1.1em">Option : </label>
  <select name="option">
    <option value="" <?php if ($option==""){echo 'selected';} ?> >Aucune</option>
    <option value="ADM"<?php if ($option=="ADM"){echo 'selected';} ?>>ADM</option>
    <option value="FS"<?php if ($option=="FS"){echo 'selected';} ?>>Paie</option>
  </select>
</p>


<p>
  <label for="sortieMand" style="margin-left:20px;font-size:1.1em">Date de fin mandataire :</label>
  <input type="date" name="sortieMand" value="<?php echo $sortieMand?>"/>
</p>

</div>
                        
<!--div de droite pour prestataire-->
<div style="border-color: black;  display: flex; flex-direction: column;width:45%; border: solid black 1px">
<div style="border-color: black;  display: flex; flex-direction: row;width:100%;">  
<p style ="font-weight: bold; width: 50%">
<label>PRESTATAIRE MENAGE</label>
<input  type="checkbox" name="chkMen" value="1" <?php if($mena==1){echo 'checked ';}?> style="width:30px; height:30px"/>
</p><p style ="font-weight: bold; width: 50%">

<label for ="chkGE">PRESTATAIRE GARDE D'ENFANTS</label>
<input type="checkbox" name="chkGE" value="1" <?php if($ge==1){echo 'checked';}?> style="width:30px;height:30px"/></p> </div>
<div style=" display: flex; flex-direction: row-reverse;width:100%;"><div style="width:50%;">

<p>
<label for="txtPge">PGE : </label>
<input id="txtPge" name="txtPge" maxlength="20" value="<?php echo filtreChainePourNavig($pge)?>"  />
</p>

<p>
<label for="dateSortiePGE">Date de fin Prestataire GE : </label>
<input type='date' id="dateSortiePGE" name="dateSortiePGE" maxlength="20" value="<?php echo $sortiePGE;?>" />
</p>

</div>



<div style="width:50%;">
<p>
<label for="txtPm">PM : </label>
<input id="txtPm" name="txtPm" maxlength="20" value="<?php echo filtreChainePourNavig($pm)?>" />
</p>


<p>
<label for="dateSortiePM">Date de fin Prestataire M : </label>
<input type='date' id="dateSortiePM" name="dateSortiePM" maxlength="20" value="<?php echo $sortiePM;?>"  />
</p>

</div>
</div>
</div>
</div>


<p style='margin-left: 25%'>
<label for="gardePart" style="font-size:1.5em">Garde partagée ? </label>
<input type="checkbox" value="1" name="gardePart" id="gardePart" onclick="afficher1()" <?php if ($gardePart==1) echo 'checked';?> style="width:30px; height:30px"/>
</p>

<input type="hidden" value="<?php echo lireDonneeUrl('num')?>" name="num1"/>
<p style="margin-left: 25%" id="gardePartListe">
<label for="avecPart" style="font-size:1.5em">Avec la famille :</label>
<input name="avecPart" id="txtavec" list="avecPart" class="form-control input-sm" value="<?php if($garde['famille1']!=$num) {echo $garde['famille1'];} else echo $garde['famille2']?>" style="height:10px; width: 18%;"/>
<datalist id ="avecPart">
<option value="" selected>Famille</option>
<?php foreach ($lesFamilles as $uneFam)
{
  $numFam=$uneFam['numero_Famille'];
  $nomFam=$pdoChaudoudoux->obtenirNomFamille($numFam);
  echo '<option value="'.$numFam.'">';  echo $nomFam; if($numFam!=9999){echo ' '.$numFam.' ';} echo '</option>';
}?>
</datalist>
</p>
<br> <br> <br>

<p style='margin-left: 25%'>
<label style="font-size: 1.5em;">ARCHIVE (TOUS TYPES DE PRESTATION) </label>
      <input type="checkbox" id="archive" style="width: 30px; height: 30px;" name="archive" value="1" onclick="afficher2()" <?php if($archive==1) {echo 'checked';}?>/>
                                </p>
                                <p style='margin-left: 25%'>
                                  <label for="dateSortie" id="labDateSortie" style ="font-size: 1.5em;">Date de sortie : </label>
                                  <input type="date" id="dateSortie" class="form-control input-sm" style="height:10px; width: 18%;" name="dateSortie" <?php echo 'value="'.substr($dateSortie,0,10).'"'; ?> />
    			                    </p>
                              <br> <br> <br>
                              
                              <p style='margin-left: 25%'>
                                <label style="font-size: 1.5em;">A pourvoir ?  </label>
                                <input type="hidden" name="aPourvoir" value="0" />
                                <input type="checkbox" id="aPourvoir" style="width: 30px; height: 30px;" name="aPourvoir" value="1" onclick="afficher3();suppPourvoir()" <?php if($aPourvoir==1) {echo 'checked';}  ?> />
                              </p>
                              <div style='overflow: hidden; margin-left: 25%;'>
                                <p style='margin-left: 25; float: left;'>
                                  
                                <label for="MPourvoir" id="labMPourvoir" style="font-size: 1em;">MÉNAGE </label><!--case à cocher pour le ménage -->
                                <input type="hidden" name="MPourvoir" value="0"/>
                                <input type="checkbox" id="MPourvoir" style="width: 30px; height: 30px;" name="MPourvoir" value='1' onclick="afficher3();suppMenage()" 
                                <?php if($MPourvoir==1) {echo 'checked';} ?>/>
                                
                                <br>
                                <label for="dateMPourvoir" id="labDateMPourvoir" style ="font-size: 1em;">Date à Pourvoir : </label><!--date pour le ménage -->
                                <input type="date" id="dateMPourvoir" class="form-control input-sm" style="height:10px;width: 200px;" name="dateMPourvoir" 
                                <?php if($dateMPourvoir!="0000-00-00") {echo 'value="'.$dateMPourvoir.'"';} ?> />
                                <input class="btn-secondary btn valider" type="button" id='bouton_date_PM' value="Date de Fin Prévue: " onclick="changeinfo(this.id);" hidden><!-- date possible-->
                                <br>
                              </p></div>
                              
                              <fieldset id="disponibiliteM" class="center" style="width: 55%; margin: 0 auto;">
                                <p><strong>DEMANDES DE LA FAMILLE POUR LE MENAGE :</strong></p> 
                                
                                <div id='divGlobal' style="display: flex; align-items: flex-end; flex-direction: row; gap: 8px; flex-wrap: wrap;">
                                 <div>
                                  <label>Le :&nbsp;</label>
                                  <select id="slctJour" name="slctJourM" onchange="gererJour()"> <!--onchange() permet de faire appel à un évènement à select-->
                                    <option value="jour" selected>Jour</option>
                                    <option value="sans importance">Sans importance</option>
                                    <option value="lundi">Lundi</option>
                                    <option value="mardi">Mardi</option>
                                    <option value="mercredi">Mercredi</option>
                                    <option value="jeudi">Jeudi</option>
                                    <option value="vendredi">Vendredi</option>
                                    <option value="samedi">Samedi</option>
                                    <option value="dimanche">Dimanche</option>
                                  </select>
                                </div>
                                
                                <!--Le 2nd select est caché il utilise une fonction pour apparraître-->
                                <div id="exceptionJourDiv" style="display: none;">
                                  <label>Exception :</label>
                                  <select id="exceptionJour" name="exceptionJour">
                                    <option value="" selected disabled>Choisir un jour</option>
                                    <option value="sans importance">Sans importance</option>
                                    <option value="lundi">Sauf Lundi</option>
                                    <option value="mardi">Sauf Mardi</option>
                                    <option value="mercredi">Sauf Mercredi</option>
                                    <option value="jeudi">Sauf Jeudi</option>
                                    <option value="vendredi">Sauf Vendredi</option>
                                    <option value="samedi">Sauf Samedi</option>
                                    <option value="dimanche">Sauf Dimanche</option>
                                  </select>
                                 </div>
                                 <div>
                                  <label>de :</label> 
                                  <select name="HdebM">
                                    <?php for ($i=0; $i<24;++$i){?>
                                      <option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option>
                                      <?php }?>
                                    </select>
                                    <select name="minDebM">
                                      <option value='00'>00</option>
                                      <option value='15'>15</option>
                                      <option value='30'>30</option>
                                      <option value='45'>45</option>
                                    </select>
                                  </div>

                                  <div>
                                    <label>à :</label>
                                    <select name="HfinM">
                                      <?php for ($i=0; $i<24;++$i){?>
                                        <option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option>
                                        <?php }?>
                                      </select>
                                      
                                      <select name="minFinM">
                                        <option value='00'>00</option>
                                        <option value='15'>15</option>
                                        <option value='30'>30</option>
                                        <option value='45'>45</option>
                                      </select>
                                    </div>  
                                    <div>  
                                      <label for="frequence">Une semaine sur :</label>
                                      <input name="frequenceM" value="1" size='1' required/>
                                    </div>
                                    <div>
                                      <label for="heureSem">Nombre d'heures/sem :</label>
                                      <input  type="number" name="heureSem" step="any" min="0" max="100" required style="width: 40px;"/>
                                    </div>

                                    <div>
                                      <label for="heureInt">Heures/Intervention :</label>
                                      <input  type="number" name="heureInt" step="any" min="0" max="100" required style="width: 40px;"/>
                                    </div>
                                      <!-- <input type='button' onclick='resetM()' value="Réinitialiser"/> -->
                                  </div>
                                  <!-- Conteneur pour les créneaux ajoutés -->
                                  <div id="ajoutM">
                                    <!-- Les nouveaux créneaux ajoutés apparaîtront ici -->
                                  </div>
                                      

<!-- https://code-boxx.com/add-html-code-in-javascript/ -->

<input type="button" id='ajoutC' onclick='ajoutCreneauxM()' value='+'/>
<input type="button" id='suppC' onclick='suppCreneauxM()' value='-'/>

</fieldset>

<script>
  function ajoutGererJour(selectElem) {
  // Récupère l'id numérique du créneau à partir de l'id du select
  const id = selectElem.id.replace('slctJour', '');
  const exceptionDiv = document.getElementById('exceptionJourDiv' + id);

  if (selectElem.value == 'sans importance') {
    exceptionDiv.style.display = 'block';
  } else {
    exceptionDiv.style.display = 'none';
  }
}

 //Fonction utiliser pour faire appraître le 2nd select après la condition "Sans importance"                            
  function gererJour() {
    const selectJour = document.getElementById('slctJour');
    const exceptionDiv = document.getElementById('exceptionJourDiv');

    if (selectJour.value == 'sans importance') {
      exceptionDiv.style.display = 'block';
    } else {
      exceptionDiv.style.display = 'none';
    }
  }

var suppCreneauxM = () =>{
  var divId = document.getElementById("M"+idM+"");
  console.log(divId);
  idM-- ;
  console.log(idM);
  if (idM===0){
    alert('Vous ne pouvez plus rien effacer');
  }
  divId.remove();
}

var suppCreneauxGE = () =>{
  var divGE = document.getElementById("GE"+idGE+"");
  //console.log(divGE);
  idGE-- ;
  console.log(idGE);
  if (idGE===0){
    alert('Vous ne pouvez plus rien effacer');
  }
  divGE.remove();
}

var ajoutCreneauxGE = () => {
  let idGE = generateIdGE();
  
  var html="<div id='GE"+idGE+"'>";
  html += "<label>Le : &nbsp;&nbsp; </label>";
  html +="<select name='slctJourGE"+idGE+"' name='slctJour"+idGE+"'>";
  html +="<option value='jour' selected>Jour</option>";
  html +="<option value='sans importance'>Sans importance</option>";
  html +="<option value='lundi'>Lundi</option>";
  html +="<option value='mardi'>Mardi</option>";
  html +="<option value='mercredi'>Mercredi</option>";
  html +="<option value='jeudi'>Jeudi</option>";
  html +="<option value='vendredi'>Vendredi</option>";
  html +="<option value='samedi'>Samedi</option>";
  html +="<option value='dimanche'>Dimanche</option>";
  html +="</select>"; 
  html +="<label>&nbsp;de : &nbsp;&nbsp;</label>";
  let optionsDeb = "";
for (let i = 0; i < 24; i++) {
    optionsDeb += "<option value='" + i + "'>" + i + "</option>";
}
html +=parent.innerHTML = "<select name='HDebGE"+idGE+"'>" + optionsDeb + "</select> ";
  html +="<select name='minDebGE"+idGE+"'> ";
  html +="<option value='00'>00</option>";
  html +="<option value='15'>15</option>";
  html +="<option value='30'>30</option>";
  html +="<option value='45'>45</option>";
  html +="</select>";
  html +=" <label>  à :   &nbsp; </label> ";
  let options = "";
for (let i = 0; i < 24; i++) {
    options += "<option value='" + i + "'>" + i + "</option>";
}
html +=parent.innerHTML = "<select name='HfinGE"+idGE+"'>" + options + "</select> ";

  html +="<select name='minFinGE"+idGE+"'>";
  html +="<option value='00'>00</option>";
  html +="<option value='15'>15</option>";
  html +="<option value='30'>30</option>";
  html +="<option value='45'>45</option>";
  html +="</select>";
  html +="<label for='frequence'>&nbsp;Une semaine sur : </label> ";
  html +="<input name='frequenceGE"+idGE+"' value='1' size='1' required/>";
  
  var divGlobal =document.getElementById('divGE');
  divGlobal.innerHTML += html;
  
  
}

let idGE = 0;
function generateIdGE() {
    return ++idGE;
}
//adapter cette fonction pour pouvoir reset les valeurs de chaque ligne 
function resetGE(){
                        var selects = document.getElementById('divGE').getElementsByTagName("select");
                        for (var i = 0; i < selects.length; i++) {
                          selects[i].selectedIndex = 0; 
                          
                        }
                      }
                      function resetM(){
                        var selects = document.getElementById('divGlobal').getElementsByTagName("select");
                        for (var i = 0; i < selects.length; i++) {
                          selects[i].selectedIndex = 0; 
                          
                        }
                      }
      </script>
                          
                          <br>
                       
          <p style='margin-left: 25%; float: top;'>
            <label for="GEPourvoir" id="labGEPourvoir" style="font-size: 1em;">GARDE D'ENFANTS </label>
            <input type="hidden" name="GEPourvoir" value="0"/>
            <input type="checkbox" id="GEPourvoir" style="width: 30px; height: 30px;" value="1" name="GEPourvoir" onclick="afficher3();suppGE()" 
            <?php if($GEPourvoir==1) {echo 'checked';} ?>/>

            <!-- <script>
              function valueGEPourvoir(){
            if(document.getElementById('GEPourvoir').checked==true){document.getElementById('GEPourvoir').value=1;}else{document.getElementById('GEPourvoir').value=0;}}
            function valueMPourvoir(){
            if(document.getElementById('MPourvoir').checked==true){document.getElementById('MPourvoir').value=1;}else{document.getElementById('MPourvoir').value=0;}} 

            </script>-->
            
                  <select name="type_prestation" id="type_prestation" >
                  	<option>Prestataire</option>
                  	<option <?php if ($GEPourvoir==2) {
                      echo("selected");
                    }?>>Mandataire</option>
                  </select><br>
                  <label for="dateGEPourvoir" id="labDateGEPourvoir" style ="font-size: 1em;">Date à Pourvoir : </label>
                  <input type="date" id="dateGEPourvoir" class="form-control input-sm" style="height:10px;width: 200px;" name="dateGEPourvoir" 
                  <?php if($dateGEPourvoir != "0000-00-00") {echo 'value="'.$dateGEPourvoir.'"';} ?> />
                  <input class="btn-secondary btn valider" type="button" id='bouton_date_PGE' value="Date de Fin Prévue: " onclick="changeinfo(this.id);" hidden><!-- date possible-->
                <br>

<script>
  function suppMenage(){
    if(document.getElementById('MPourvoir').checked==false){
      var div=document.getElementById('Menage').hidden=true;
    }else{
      var div=document.getElementById('Menage').hidden=false;

    }
  }
  function suppGE(){
    if(document.getElementById('GEPourvoir').checked==false){
      var div=document.getElementById('GardeEnfants').hidden=true;
    }else{
      var div=document.getElementById('GardeEnfants').hidden=false;

    }
  }
  function suppPourvoir(){
    if(document.getElementById('GEPourvoir').checked==false){
      var divGE=document.getElementById('GardeEnfants').hidden=true;
      var divM=document.getElementById('Menage').hidden=true;
    }else{
      var divGE=document.getElementById('GardeEnfants').hidden=false;
      var divM=document.getElementById('Menage').hidden=false;
    }

  }
</script>

                 <style>
                 
                    p{
                      font-size:x-large;
                    }
                    .center {
                     
                     
                     clear: left;
                   }
                    
                    </style>
                    <fieldset id="disponibiliteGE" class="center"  style="width: 55%; margin: 0 auto;">
                    <p><strong>DEMANDES DE LA FAMILLE POUR LA GARDE D'ENFANTS :</strong></p>
                    
                      <div id='divGE'>
                        
                      
                      <label>Le : &nbsp; </label>
                      <select name="slctJourGE" id="slctJourGE">
                        <option value="jour" selected>Jour</option>
                        <option value="sans importance">Sans importance</option>
                        <option value="lundi">Lundi</option>
                        <option value="mardi">Mardi</option>
                        <option value="mercredi">Mercredi</option>
                        <option value="jeudi">Jeudi</option>
                        <option value="vendredi">Vendredi</option>
                        <option value="samedi">Samedi</option>
                        <option value="dimanche">Dimanche</option>
                  </select>
                      <label>de : &nbsp; </label>
                        <select name="HdebGE">
                        <?php for ($i=0; $i<24;++$i){?>
                        <option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option>
                        <?php }?>
                        </select>
                        
                        <select name="minDebGE">
                            <option value='00'>00</option>
                            <option value='15'>15</option>
                            <option value='30'>30</option>
                            <option value='45'>45</option>
                        </select>
                        
                        <label>à : &nbsp; </label>
                      <select name="HfinGE">
                      <?php for ($i=0; $i<24;++$i){?>
                          <option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option>
                      <?php }?>
                      </select>
                      
                      <select name="minFinGE">
                          <option value='00'>00</option>
                          <option value='15'>15</option>
                          <option value='30'>30</option>
                          <option value='45'>45</option>
                      </select>
                      
                      <label for="frequenceGE">Une semaine sur :</label>
                      <input name="frequenceGE" value="1" size='1' required/>
                      
                      <!-- <input type="button" onclick='resetGE()' value="Réinitialiser"/> -->
                      
                      
                      
                    </div>
                   
                    <input type="button" id='ajoutC' onclick='ajoutCreneauxGE()' value='+'/>
                    <input type="button" id='suppC' onclick='suppCreneauxGE()' value='-'/>
                  </fieldset>
           
              </div>  
    			    </p>
            </fieldset>
            <div id="Menage">
            <legend>DEMANDES POUR LE MENAGE DE<strong> <?php $noms = "";
  foreach ($parents as $parent){
  if($noms != $parent['nom_Parents']."-")
  $noms.=$parent['nom_Parents']."-";
  }
  $noms=substr($noms, 0, strlen($noms)-1);
  echo $noms; 
  echo ' ('.$num.')</strong>';?></legend>
            <style>

              table,th,td,tr{
                border: 1px solid black;
                text-align:center;
                
              }
              
              
              
              </style>
            <table id="menagePourvoi" style="width:55%;" >
              <thead>
                
                <th> PM </th>
                <th> Ville </th>
                <th> Quartier </th>

                <th> Activité </th>
                
                <th> Jour / Horaires </th>
                <th> Fréquence de la prestation </th>
                <th> Nombre d'heures <br> par <br> semaines</th>
                <th> Nombre d'heures <br> par <br> intervention</th>
                
                <th> Modifier </th>
                <th> Supprimer </th>
              </thead>
              
                    <tbody><?php
                $demandesM=$pdoChaudoudoux->obtenirDemandesM($num);
                $saufString = '';
                
                // var_dump( $demandesM);
                
                foreach ($demandesM as $key => $uneDemandeM)
                {
                  $jourM=$uneDemandeM['jour'];
                  if(!is_null($uneDemandeM['jourException'])){
                    $jourException=$uneDemandeM['jourException'];
                    $saufString = 'SAUF';
                  }
                  
                  $hDebM=$uneDemandeM['heureDebut'];
                  $hFinM=$uneDemandeM['heureFin'];
                  $frequenceM=$uneDemandeM['frequence'];
                  $activite=$uneDemandeM['activite'];
                  $id=$uneDemandeM['id'];
                  $ville=$uneDemandeM['ville_Famille'];
                  $PM=$uneDemandeM['PM_Famille'];
                  $quartier=$uneDemandeM['quartier_Famille'];

                  $timeDebut  = explode(':', $hDebM);
                  $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);
      
                  $timeFin  = explode(':', $hFinM);
                  $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
                  
                  if(!is_null($uneDemandeM['heureSemaine'])){
                    $heurSem=$uneDemandeM['heureSemaine'];
                  }
                  if(!is_null($uneDemandeM['heureIntervention'])){
                    $heurInt=$uneDemandeM['heureIntervention'];
                  }
                  
                  //$numFamille=$uneDemandeM['numero'];
                  echo "<tr>";
                  echo "<td> ".$PM." </td>";
                  echo "<td> ".$ville." </td>";
                  echo "<td> ".$quartier." </td>";
                  echo "<td> Menage </td>";
                  echo "<td> <strong>".$jourM." ".$saufString." ".$jourException." - ".$hDebM." à ".$hFinM."<br><br> </strong></td>";
                  echo "<td> Une semaine sur ".$frequenceM." </td>";
                  echo "<td>".$heurSem." h</div></td>";
                  echo "<td>".$heurInt." h</div></td>";
                  echo '<td> <a href="index.php?uc=annuFamille&amp;action=modifierDemandeFamille&amp;numDemande='.$id.'">Modifier</a> </td>';
                  echo '<td> <a href="index.php?uc=annuFamille&amp;action=supprimerDemandeFamille&amp;numDemande='.$id.'">Supprimer</a> </td>';
                  // pour ajout de numFamille, mettre dans le lien au dessus après le numDemande='.$id.'&amp
                  
                  echo '</tr>';

                  
                
                }
echo "</tbody>";

                    ?>
                    </table>
                    <br/>
                      </div>
                      <div id="GardeEnfants">
                    <table>

<legend>DEMANDES POUR LA GARDE D'ENFANTS DE<strong> <?php $noms = "";
foreach ($parents as $parent){
if($noms != $parent['nom_Parents']."-")
$noms.=$parent['nom_Parents']."-";
}
$noms=substr($noms, 0, strlen($noms)-1);
echo $noms; 
echo ' ('.$num.')</strong>';?></legend>
          <style>

            table,th,td,tr{
              border: 1px solid black;
              text-align:center;
              
            }
            
          </style>
          <table style="width:55%;">
          <thead>
              <th> PGE </th>
              <th> Ville </th>
              <th> Quartier </th>
              <th> Activité </th>
              <th> Jour / Horaires </th>
              <th> Fréquence de la prestation </th>
              <th> Nombre d'heures <br> par <br> intervention</th>
              <th> Modifier </th>
              <th> Supprimer </th>

          </thead>
          
                  <tbody><?php
              $demandesGE=$pdoChaudoudoux->obtenirDemandesGE($num);
                  foreach ($demandesGE as $key => $uneDemandeGE)
                      {
                        $jour=$uneDemandeGE['jour'];
                        $hDeb=$uneDemandeGE['heureDebut'];
                        $hFin=$uneDemandeGE['heureFin'];
                        $frequence=$uneDemandeGE['frequence'];
                        $activite=$uneDemandeGE['activite'];
                        $id=$uneDemandeGE['id'];
                        $ville=$uneDemandeGE['ville_Famille'];
                        $PGE=$uneDemandeGE['PGE_Famille'];
                        $quartier=$uneDemandeGE['quartier_Famille'];
                        //$numFamille=$uneDemandeM['numero'];
                        $timeDebut  = explode(':', $hDeb);
                        $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

                        $timeFin  = explode(':', $hFin);
                        $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);

                        $somme=($minutesFin-$minutesDebut)/$frequence;
                        echo "<tr>";
                        echo "<td> ".$PGE." </td>";
                        echo "<td> ".$ville." </td>";
                        echo "<td> ".$quartier." </td>";

                        echo "<td> Garde d'enfants </td>";
                        echo "<td><strong> ".$jour." - ".$hDeb." à ".$hFin."<br><br></strong></td>";
                        echo "<td> Une semaine sur ".$frequence."</td>";
                        echo "<td> ".($somme/60)." </td>";

                        echo '<td> <a href="index.php?uc=annuFamille&amp;action=modifierDemandeFamille&amp;numDemande='.$id.'">Modifier</a> </td>';
                        echo '<td> <a href="index.php?uc=annuFamille&amp;action=supprimerDemandeFamille&amp;numDemande='.$id.'">Supprimer</a> </td>';
                        // pour ajout de numFamille, mettre dans le lien au dessus après le numDemande='.$id.'&amp
                        
                        echo '</tr>';

                        
                         
                      }
echo "</tbody>";

             ?>
                    </table>
                    <br/>
                    </div>
                    <br/><br/>

  			<fieldset>
  				<legend>Informations des parents</legend>
  				<br/>


<table id="tableParent" class="donnees" style="width:100%">
<tr>
<th>Papa/Maman</th>
<th>Titre</th>
<th>Nom</th>
<th>Prenom</th>
<th>Tel. portable</th>
<th>Tel. pro</th>
<th>Email</th>
<th>Profession</th>
<th>Suppr.</th>
</tr>

<?php
	$compt = 1;
	foreach ($parents as $parent) {
?>
<tr>
          <td><?php if ($compt==2) echo 'Papa'; elseif($compt==1) echo 'Maman';?><td><select class="donnees" name="slctTitreParents<?php echo $compt; ?>">
            <option value="MR" <?php if($parent['titre_Parents'] == 'MR') {echo "selected";}?> >MR.</option>
            <option value="MME" <?php if($parent['titre_Parents'] == 'MME') {echo "selected";}?> >MME</option>     
          </select>
          <td><input type="text" class="donnees" name="nomParent<?php echo $compt; ?>" size="35" value="<?php echo $parent['nom_Parents'];?>"></td>
					<td><input type="text" size="25" class="donnees" name="prenomParent<?php echo $compt; ?>" size="15" value="<?php echo $parent['prenom_Parents']; ?>"></td>
					<td><input type="tel" size="25" class="donnees" name="telPort<?php echo $compt; ?>" size="10" maxlength="15" value="<?php echo $parent['telPortable_Parents']; ?>" ></td>
					<td><input type="tel" size="25" class="donnees" name="telPro<?php echo $compt; ?>" size="10" maxlength="15" value="<?php echo $parent['telTravail_Parents']; ?>" ></td>
					<td><input type="text" size="25" class="donnees" name="email<?php echo $compt; ?>" size="15" value="<?php echo $parent['email_Parents'] ; ?>"></td>
					<td><input type="text"  size="25" class="donnees" name="prof<?php echo $compt; ?>" size="15" value="<?php echo $parent['profession_Parents'] ; ?>"></td>
					<td><input type="checkbox" class="donnees" name="chkSupprPar<?php echo $compt; ?>" value="1"></center></td>
</tr>


<?php
		$compt++;
	}
        while ($compt <= 2) {?>
<tr><td><?php if ($compt==2) echo 'Papa'; elseif($compt==1) echo 'Maman';?></td><td><select class="donnees" name="slctTitreParents<?php echo $compt; ?>">
            <option value="MR" >MR.</option>
            <option value="MME" >MME</option>     
          </select>
          <td><input type="text" class="donnees" name="nomParent<?php echo $compt; ?>" size="15" ></td>
					<td><input type="text" size="25" class="donnees" name="prenomParent<?php echo $compt; ?>" size="15"></td>
					<td><input type="tel" size="25" class="donnees" name="telPort<?php echo $compt; ?>" size="10" maxlength="15"  ></td>
					<td><input type="tel" size="25" class="donnees" name="telPro<?php echo $compt; ?>" size="10" maxlength="15"  ></td>
					<td><input type="text" size="25" class="donnees" name="email<?php echo $compt; ?>" size="15" ></td>
                                        <td><input type="text" size="25" class="donnees" name="prof<?php echo $compt; ?>" size="15"></td></tr>
<?php
    $compt++;
	}
?>
  				</table>
  				<br/>
  			</fieldset>
  			<br/>
  			<fieldset>
  				<legend>Informations enfants</legend>
  				<br/>
  				<table id="tableEnfant" class="donnees">
                                    <tr><th>Nom</th><th>Prenom</th><th>Date de naissance</th><th>Concerné par la garde</th></tr>
<?php
$compt = 1; 
	foreach ($enfants as $enfant) {
?>
					<tr><td><input type="text"  size="25" class="donnees" name="nomEnf<?php echo $compt; ?>" size="15" value="<?php echo $enfant['nom_Enfants']; ?>"></td>
  					<td><input type="text" size="25" class="donnees" name="prenomEnf<?php echo $compt; ?>" size="15" value="<?php echo $enfant['prenom_Enfants']; ?>"></td>
  					<td><input type="date" class="donnees" name="dateNaisEnf<?php echo $compt; ?>" value="<?php echo date('Y-m-d', strtotime($enfant['dateNaiss_Enfants'])); ?>" /></td>
            <td><input type="checkbox" class="donnees" name="concernGarde<?php echo $compt;?>" value="1" <?php if ($enfant['concernGarde_Enfants']==1){ echo "checked";}?> style="height: 30px; width:30px;"/></td>
          </tr>
            
<?php
		$compt++;
	}
                                        for ($i=1; $i<4;++$i){?>
					<tr><td><input type="text" size="25" class="donnees" name="nomEnf<?php echo $compt; ?>" size="15" ></td>
  					<td><input type="text" size="25" class="donnees" name="prenomEnf<?php echo $compt; ?>" size="15"></td>
  					<td><input type="date" class="donnees" name="dateNaisEnf<?php echo $compt; ?>"  /></td>
                                        <td><input type="checkbox" value="1" class="donnees" name="concernGarde<?php echo $compt;?>" style="height: 30px; width:30px;"/></td>
                                        <td></td></tr><?php $compt++; }?>
  				</table>
          <br/>
  			</fieldset>
                        <fieldset>
    			<legend>Informations de la famille</legend>
    			  
                                  		
                        <div style='display:flex; flex-direction: row; margin-right:10%' > 
                             <div style='display:flex; flex-direction: column; margin-right:10%; width:45%' > 
                                
                                
                        
  				<p>
  				  	<label for="txtAdr">Adresse : </label>
  				  	<input id="txtAdr" name="txtAdr" maxlength="255" size="40" value="<?php echo filtreChainePourNavig($adresse) ; ?>" />
  				</p>


          <p>
          	<label for="txtVille">Ville : </label>
                  <input id="txtVille" name="txtVille" list="my-select" type="text" size="25" value="<?php echo filtreChainePourNavig($ville) ; ?>" >

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
            	<input  id="txtCp" list="my--select" name="txtCp" size="5" maxlength="5" pattern="^[0-9]{5}$" value="<?php echo filtreChainePourNavig($cp) ; ?>"/>

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

        <? //var_dump($secteurFamille);?>
          <p>
            <label for='secteurFamille'> Secteur de Rennes (centre) : </label>
            <select name="slctSecteur">
              <?php 
              if($secteurFamille == "Aucun"){echo("<option value='Aucun' selected>AUCUN</option>");}
              else{ echo("<option value='Aucun'>AUCUN</option>"); }

              if($secteurFamille == "Nord"){echo("<option value='Nord' selected>NORD</option>");}
              else{ echo("<option value='Nord'>NORD</option>"); }
              
              if($secteurFamille == "Est"){echo("<option value='Est' selected>EST</option>");}
              else{ echo("<option value='Est'>EST</option>"); }

              if($secteurFamille == "Sud"){echo("<option value='Sud' selected>SUD</option>");}
              else{ echo("<option value='Sud'>SUD</option>"); }
              
              if($secteurFamille == "Ouest"){echo("<option value='Ouest' selected>OUEST</option>");}
              else{ echo("<option value='Ouest'>OUEST</option>"); }            
              ?>
            </select>
          </p>
  				<p>
  				  	<label for="txtQuart">Quartier : </label>
  				  	<input id="txtQuart" name="txtQuart"  size="25" value="<?php echo filtreChainePourNavig($quart) ; ?>" />
  				</p>
                                
  				<p>
  				  	<label for="txtFixe">Téléphone domicile : </label>
  				  	<input type="tel" id="txtFixe" name="txtFixe" maxlength="14" size="15" value="<?php echo filtreChainePourNavig($tel) ; ?>"/>
  				</p>
  				<p>
      				<label for="chkVehicule">Véhicule nécessaire :</label>
      				<input type="checkbox" id="chkVehicule" name="chkVehicule" value="1" 
      				<?php if ( $vehicule == 1 ) echo 'checked="checked"'; ?> />
    			</p>
                        <p>             
                 <label for="enfHand">Enfant handicapé dans la famille :</td>
                <input type="checkbox" name="enfHand" value='1' <?php if($enfHand==1) {echo 'checked';}?>/></td>
                        </p>
                        <p>
                        <label for="txtQuart">Remarques : </label>
                        <textarea id="txtRemarques" name="txtRemarques"  cols="70" rows="5" maxlength="1000"> <?php echo $remarque;?></textarea>
                        </p></div> <div style='display:flex; flex-direction: column; width:45%' > 
                       <p>
      				<label for="txtBus">Ligne de bus : </label>
      				<input type="text" id="txtBus" name="txtBus" size="15" value="<?php echo $ligneBus; ?>"/>
    			</p>
                        <p>
      				<label for="arretBus">Arrêt de bus : </label>
      				<input type="text" id="arretBus" name="arretBus" size="40" value="<?php echo filtreChainePourNavig($arretBus) ; ?>"/>
    			</p>
                            <p>
      				<label for="dateEntree">Date d'entrée : </label>
      				<input type="date" id="dateEntree" name="dateEntree" value="<?php echo filtreChainePourNavig($dateEntree->format('Y-m-d')) ; ?>" />
    			</p>
                            <p>	<label for="txtNumAlloc">N° CAF : </label>
  				  	<input id="txtNumAlloc" name="txtNumAlloc" maxlength="20" size="18" value="<?php echo filtreChainePourNavig($numAlloc) ; ?>" />
  				</p>
  				<p>
  				  	<label for="txtNumURSSAF">N° URSSAF : </label>
  				  	<input id="txtNumURSSAF" name="txtNumURSSAF" maxlength="20" value="<?php echo filtreChainePourNavig($numURSSAF) ; ?>" />
  				</p>
                        <p>
                            <label for="modePaiement">Mode de paiement : </label>
                            <select name="modePaiement">
                                <option value="CHEQUE" <?php if($modePaiement=='CHEQUE') echo 'selected';?>>CHEQUE</option>
                                <option value="PRELEVEMENT"<?php if($modePaiement=='PRELEVEMENT') echo 'selected';?>>PRELEVEMENT</option>
                                <option value="CESU"<?php if($modePaiement=='CESU') echo 'selected';?>>CESU</option>
                            </select>
                        </p>
                        
                       
                        <p>
                        <label for="txtQuart">Observations / demandes :</label>
                        <textarea id="txtObs" name="txtObs"  cols="70" rows="5" maxlength="1000"><?php echo $observ;?></textarea>
                        </p>
                        <p>
                        <label for="suivi">Suivi Famille : </label>
                        <textarea name="suivi"><?php echo filtreChainePourNavig($suivi) ; ?></textarea>
                        </p></div></div>
    			
<?php /* 
	$compt = 0;
	foreach ($presta as $prestation) {
		$compt++;
    $typePresta = $prestation['idPresta_Prestations'];
    $prestMand = $prestation['idADH_TypeADH'];
    $regularite = $prestation['regu_Proposer'];
    $codeCli=$prestation['codeCli_Proposer'];
    $codePresta = $prestation['codePresta_Proposer'];
    $nameInterv = $prestation['nom']." ".$prestation['prenom'];
?>
          <p>
            <label for="slctPrestMand"> Prestations <?php echo $compt; ?>: </label>
    				<select name="slctPrestMand<?php echo $compt; ?>">
    					<option value="NONE" >-------</option>
						<option value="PREST" <?php if($prestMand == "PREST") echo "selected";?> >Prestataire</option>
						<option value="MAND"<?php if($prestMand == "MAND") echo "selected";?> >Mandataire</option>
					  </select>
					  <select name="slctPresta<?php echo $compt; ?>">
					  	<option value="NONE" >-------</option>
					  	<option value="ENFA" <?php if($typePresta == "ENFA") echo "selected";?> >Garde d'enfants</option>
					  	<option value="MENA" <?php if($typePresta == "MENA") echo "selected";?> >Ménage</option>
					  </select>
					  <select name="slctRegularite<?php echo $compt; ?>">
					  	<option value="OCC" <?php if($regularite == "OCC") echo "selected";?> >Occasionnel</option>
					  	<option value="REG" <?php if($regularite == "REG") echo "selected";?> >Régulier</option>
					  </select><br/>
            <input id="txtCodCli" name="txtCodCli<?php echo $compt; ?>" size="10" maxlength="10" value="<?php echo $codeCli; ?>" placeholder="Code adhérent"/>
            <input id="txtCodPresta" name="txtCodPresta<?php echo $compt; ?>" size="10" maxlength="10" value="<?php echo $codePresta; ?>" placeholder="Code prestation"/>
            <input type="text" list="listInterv<?php echo $compt; ?>" name="interv<?php echo $compt; ?>" placeholder="Intervenant" value="<?php echo $nameInterv; ?>"/>
            <datalist id="listInterv<?php echo $compt; ?>">
              <select>
<?php
    foreach ($interv as $int) {
      $numInterv = $int["numSalarie"];
      $nom = $int["nom"];
      $prenom = $int["prenom"];
?>
                <option value="<?php echo $nom.' '.$prenom;?>"></option>
<?php 
    }
?>
              </select>
            </datalist>
            <input type="text" size="10" maxlength="9" name="txtSession" placeholder="Période" />
            <input type="hidden" name="numFamille" value="<?php echo $num; ?>">
            <br/>
          </p>
<?php
	
	if ($compt < 2) {
		for ($i=$compt+1; $i<=2;$i++){
?>        
          <p>  
            <label for="slctPrestMand"> Prestations <?php echo $i; ?>: </label>
    				<select name="slctPrestMand<?php echo $compt+$i; ?>">
    					<option value="NONE" selected>-------</option>
						<option value="PREST" >Prestataire</option>
						<option value="MAND">Mandataire</option>
					</select>
					<select name="slctPresta<?php echo $compt+$i; ?>">
						<option value="NONE" selected>-------</option>
						<option value="ENFA">Garde d'enfants</option>
						<option value="MENA">Ménage</option>
					</select>
					<select name="slctRegularite<?php echo $compt+$i; ?>">
					<option value="NONE" selected>-------</option>
						<option value="OCC">Occasionnel</option>
						<option value="REG">Régulier</option>
					</select><br/>
          <input id="txtCodCli" name="txtCodCli<?php echo $compt+$i; ?>" size="10" maxlength="10" placeholder="Code adhérent"/>
          <input id="txtCodPresta" name="txtCodPresta<?php echo $compt+$i; ?>" size="10" maxlength="10" placeholder="Code prestation"/>
          <input type="text" list="listInterv" name="interv<?php echo $compt+$i; ?>" placeholder="Intervenant" />
            <datalist id="listInterv">
              <select>
<?php
  foreach ($interv as $int) {
    $num = $int["numSalarie"];
    $nom = $int["nom"];
    $prenom = $int["prenom"];
?>
                <option value="<?php echo $nom.' '.$prenom;?>"></option>
<?php 
      }
?>
              </select>
            </datalist>
            <input type="text" size="10" maxlength="9" name="txtSession" placeholder="Période" />
            <input type="hidden" name="numFamille" value="<?php echo $num; ?>"><br/>
          </p>
<?php
		}
	}} */
?>
				
    			<p>
      				<label for="chkAG">Participe à l'assemblée générale :</label>
      				<input type="checkbox" id="chkAG" name="chkAG" value="1" 
                                <?php if ( $ag == 1 ){ echo 'checked="checked"';} ?> />
    			</p>
    			
  			</fieldset>
                        <fieldset>
    			<legend>Description du domicile</legend>
          <div style ='display: flex; flex-direction: row; width: 100%'><p>
                        <div style ='display: flex; flex-direction: column; width:50%'>
                                <strong> <label for="maison">MAISON/ </label><br/>
                        <input type="radio" id="maison" name="typeLogement" value="MAISON" <?php if ($typeLogement=='MAISON') {echo 'checked';}?>/></p><p>
                        <label for="appart">APPARTEMENT </label><br/>
                        <input type="radio" id="appart" name="typeLogement" value="APPARTEMENT" <?php if ($typeLogement=='APPARTEMENT') {echo 'checked';}?>/></strong></p>
                        <p style="width: 60%">
                            <label for="superficie">Superficie du logement (en m²):</label>
                            <input size="1" name="superficie" value="<?php echo $superficie;?>"/>
                        </p>
                        <p style="width: 60%">
                            <label for="nbEtages">Nombre d'étages :</label>
                            <input size="1" name="nbEtages" value="<?php echo $nbEtages;?>"/>
                        </p>
                      
                        </div>
                        <div style ='display: flex; flex-direction: column; margin-left:10%; width:50%'>
                        <p style="width: 60%">
                            <label for="nbChambres">Nombre de chambres :</label>
                            <input size="1" name="nbChambres" value="<?php echo $nbChambres;?>"/>
                        </p>
                        <p style="width: 60%">
                            <label for="nbSDB">Nombre de salles de bain </label>
                            <input size="1" name="nbSDB" value="<?php echo $nbSDB;?>"/>
                        </p>
                        <p style="width: 60%">
                            <label for="nbSani">Nombre de sanitaires :</label>
                            <input size="1" name="nbSani" value="<?php echo $nbSani;?>"/>
                        </p>
                        <p style="width: 60%">
                            <label for="repassage">Repassage :</label>
                            <input type="checkbox" name="repassage" value="1" <?php if($repassage==1) echo 'checked'; ?>/>
                        </p>
                        </div>
                      </div>
                        </fieldset><?php /*
                                  <fieldset>
                            <legend>Ajout de documents</legend>
                            <?php for($i=0;$i<10;$i++){
                                if ($i%2==0){echo '<br/>';}?>                                
                            <input type="file" name="<?php echo $i;?>"/><?php }?><br/>
                            <label for="Fiche_Famille">Fiche famille</label>
                            <input type="file" name="Fiche_Famille"/>
                        </fieldset>*/?>
    	</div>
    	<p>
    			<input class="btn valdier btn-secondary" type="submit" name="btnValider" style="position:fixed;text-align:center;bottom:0px;left:0px" value="VALIDER" />
    		</p>
    		<p>
             <button style="position:fixed;bottom:0px;right:0px" class="retour btn" onclick="history.go(-1);">RETOUR</button>
      </p>
    	
    </form>
</div>

<script type="text/javascript">
dateTempAPourvoir_GE = "<?php echo $dateTempAPourvoir_GE; ?>";
dateTempAPourvoir_M = "<?php echo $dateTempAPourvoir_MEN; ?>";

afficher1();
afficher2();
afficher3();

let idM = 0;
function generateIdM() {
    return ++idM;
}

var ajoutCreneauxM = () => {
  let idM = generateIdM();
  var html = "<div id='M"+idM+"' style='display: flex; flex-direction: row; gap: 7px; align-items: flex-end;'>";
  html +="<div>";
  html += "<label>Le :&nbsp;&nbsp;</label>";
  html += "<select id='slctJour"+idM+"' name='slctJourM"+idM+"' onchange='ajoutGererJour(this)'>";
  html += "<option value='jour' selected>Jour</option>";
  html += "<option value='sans importance'>Sans importance</option>";
  html += "<option value='lundi'>Lundi</option>";
  html += "<option value='mardi'>Mardi</option>";
  html += "<option value='mercredi'>Mercredi</option>";
  html += "<option value='jeudi'>Jeudi</option>";
  html += "<option value='vendredi'>Vendredi</option>";
  html += "<option value='samedi'>Samedi</option>";
  html += "<option value='dimanche'>Dimanche</option>";
  html += "</select>";
  html +="</div>";

  html +="<div id='exceptionJourDiv"+idM+"' style='display: none;'>";
  html += "<label>Exception :&nbsp;&nbsp;</label>";
  html += "<select id='exceptionJour"+idM+"' name='exceptionJour"+idM+"'>";
  html += "<option value='' selected disabled>Choisir un jour</option>";
  html += "<option value='sans importance'>Sans importance</option>";
  html += "<option value='lundi'>Sauf Lundi</option>";
  html += "<option value='mardi'>Sauf Mardi</option>";
  html += "<option value='mercredi'>Sauf Mercredi</option>";
  html += "<option value='jeudi'>Sauf Jeudi</option>";
  html += "<option value='vendredi'>Sauf Vendredi</option>";
  html += "<option value='samedi'>Sauf Samedi</option>";
  html += "<option value='dimanche'>Sauf Dimanche</option>";
  html += "</select>";
  html +="</div>";

  html +="<div>";
  html += "<label>de :&nbsp;</label>";
  html += "<select name='HDebM"+idM+"'>";
  for (let i = 0; i < 24; i++) {
    html += "<option value='" + (i<10 ? '0'+i : i) + "'>" + i + "</option>";
  }
  html += "</select>&nbsp;";
  html += "<select name='minDebM"+idM+"'>";
  html += "<option value='00'>00</option>";
  html += "<option value='15'>15</option>";
  html += "<option value='30'>30</option>";
  html += "<option value='45'>45</option>";
  html += "</select>";
  html +="</div>";

  html +="<div>";
  html += "<label>à :&nbsp;</label>";
  html += "<select name='HfinM"+idM+"'>";
  for (let i = 0; i < 24; i++) {
    html += "<option value='" + (i<10 ? '0'+i : i) + "'>" + i + "</option>";
  }
  html += "</select>&nbsp;";
  html += "<select name='minFinM"+idM+"'>";
  html += "<option value='00'>00</option>";
  html += "<option value='15'>15</option>";
  html += "<option value='30'>30</option>";
  html += "<option value='45'>45</option>";
  html += "</select>";
  html +="</div>";

  html +="<div>";
  html += "<label for='frequence'>Une semaine sur&nbsp;:&nbsp;</label>";
  html += "<input name='frequenceM"+idM+"' value='1' size='1' required/>";
  html +="</div>";
  
  html +="<div>";
  html += "<label for='heureSem'>Nombre d'heures/sem&nbsp;:&nbsp;</label>";
  html += "<input type='number' name='heureSem"+idM+"' step='any' min='0' max='100' required style='width: 60px;'/>";
  html += "</div>";

  html +="<div>";
  html += "<label for='heureInt'>Heures/Intervention&nbsp;:&nbsp;</label>";
  html += "<input type='number' name='heureInt"+idM+"' step='any' min='0' max='100' required style='width: 60px;'/>";
  html += "</div>";

  var divAjoutM = document.getElementById('ajoutM');
  divAjoutM.insertAdjacentHTML('beforeend', html);
}

  function afficher1() {
  valeur = document.getElementById("gardePart").checked;

  if (valeur == true) {        
    document.getElementById("gardePartListe").hidden = false;
    
  } else {
    document.getElementById("gardePartListe").hidden = true;
    document.getElementById("txtavec").value = "";
  }
}
function afficher2() {
  valeur = document.getElementById("archive").checked;

  if (valeur == true) {        
    document.getElementById("dateSortie").hidden = false;
    document.getElementById("labDateSortie").hidden = false;
  } else {
    document.getElementById("dateSortie").hidden = true;
    document.getElementById("labDateSortie").hidden = true;
    document.getElementById("dateSortie").value = "";
  }
}

function afficher3() {//fonction pour l'affichage des options de à pourvoir
  valeur = document.getElementById("aPourvoir").checked;
  valeurM = document.getElementById("MPourvoir").checked;
  valeurGE = document.getElementById("GEPourvoir").checked;
  document.getElementById("disponibiliteM").hidden = true;
  document.getElementById("disponibiliteGE").hidden = true;


  if (valeur == true) {        
    document.getElementById("MPourvoir").hidden = false;
    document.getElementById("labMPourvoir").hidden = false;
    document.getElementById("GEPourvoir").hidden = false;
    document.getElementById("labGEPourvoir").hidden = false;
    if (valeurM == true) {
      document.getElementById("labDateMPourvoir").hidden = false;
      document.getElementById("dateMPourvoir").hidden = false;
      document.getElementById("disponibiliteM").hidden = false;

      if(dateTempAPourvoir_M != ""){
        document.getElementById("bouton_date_PM").hidden = false;
      }
      else{
        document.getElementById("bouton_date_PM").hidden = true;
      }
    }
    else {
      document.getElementById("dateMPourvoir").hidden = true;
      document.getElementById("labDateMPourvoir").hidden = true;
      document.getElementById("dateMPourvoir").value = "";
      document.getElementById("bouton_date_PM").hidden = true;
      document.getElementById("disponibiliteM").hidden = true;

    }
    if (valeurGE == true) {
      document.getElementById("labDateGEPourvoir").hidden = false;
      document.getElementById("dateGEPourvoir").hidden = false;
      document.getElementById("type_prestation").hidden = false;
      document.getElementById("disponibiliteGE").hidden = false;

      if(dateTempAPourvoir_GE != ""){
        document.getElementById("bouton_date_PGE").hidden = false;
      }
      else{
        document.getElementById("bouton_date_PGE").hidden = true;
      }
    }
    else {
      document.getElementById("dateGEPourvoir").hidden = true;
      document.getElementById("labDateGEPourvoir").hidden = true;
      document.getElementById("type_prestation").hidden = true;
      document.getElementById("dateGEPourvoir").value = "";
      document.getElementById("bouton_date_PGE").hidden = true;
      document.getElementById("disponibiliteGE").hidden = true;

    }
    
    
  } else {
    document.getElementById("MPourvoir").hidden = true;
    document.getElementById("MPourvoir").checked = false;
    document.getElementById("labMPourvoir").hidden = true;
    document.getElementById("GEPourvoir").hidden = true;
    document.getElementById("GEPourvoir").checked = false;
    document.getElementById("labGEPourvoir").hidden = true;
    document.getElementById("dateMPourvoir").hidden = true;
    document.getElementById("dateMPourvoir").value = "";
    document.getElementById("labDateMPourvoir").hidden = true;
    document.getElementById("dateGEPourvoir").hidden = true;
    document.getElementById("dateGEPourvoir").value = "";
    document.getElementById("labDateGEPourvoir").hidden = true;
    document.getElementById("type_prestation").hidden = true;
    document.getElementById("bouton_date_PM").hidden = true;
    document.getElementById("bouton_date_PGE").hidden = true;
  }
}

if(dateTempAPourvoir_GE != ""){
  document.getElementById("bouton_date_PGE").value = document.getElementById("bouton_date_PGE").value + dateTempAPourvoir_GE.split("-").reverse().join("/");
}
if(dateTempAPourvoir_M != ""){
  document.getElementById("bouton_date_PM").value = document.getElementById("bouton_date_PM").value + dateTempAPourvoir_M.split("-").reverse().join("/");
}

function changeinfo(id){
  if(id=="bouton_date_PGE"){
    document.getElementById("dateGEPourvoir").value = dateTempAPourvoir_GE;
  }
  if(id=="bouton_date_PM"){
    console.log("done");
    document.getElementById("dateMPourvoir").value = dateTempAPourvoir_M;
    console.log("done");
  }
  
  
}
</script>