
<?php
/* @var $nom string */
/* @var $prenom string */
/* @var $libOption string */
/* @var $adr string */
/* @var $codePostal string */
/* @var $ville string */
/* @var $tel string */
/* @var $email string */
if($issalarie==false){$dateNaiss = new DateTime($dateNaiss);}?>

<!-- Division pour le contenu principal -->

    <div id="contenu" style="margin-bottom:50px">
    <h1 style="text-align:center">Fiche de <?php echo filtreChainePourNavig($titre)." ".filtreChainePourNavig(strtoupper($nom)) ; ?>&nbsp;<?php echo filtreChainePourNavig($prenom) ; ?></h1>
   <?php  if($issalarie==false){?> <form id="frmCandid" action="index.php?uc=annuCandid&amp;action=validerModifCandid&amp;num=<?php echo $num; ?>" method="post"><?php } 
   else {?> <form id="frmSalarie" enctype="multipart/form-data" action="index.php?uc=annuSalarie&amp;action=ValiderModifSalarie&amp;num=<?php echo $num; ?>" method="post"><?php } ?>
<?php
        if ( nbErreurs($tabErreurs) != 0 ) {
          echo toHtmlErreurs($tabErreurs);
        } 
 ?>
<?php
        if ( !empty($messageInfo) ) {?>
            <p class="info"><?php echo $messageInfo; ?></p>
<?php   } 
 ?>
  <div id="corpsForm">
      <br/><?php if ($issalarie==true){?>
    <div style="display:flex; flex-direction:row;" >
  <fieldset  style="display: flex; flex-direction: column; width: 45%">

  <legend>INFORMATIONS SPÉCIFIQUES AU SALARIÉ</legend>
    
    <p>
      <label for="txtID" style="font-size: 1.5em;">Numéro salarié : </label>
      <input type="text" id="txtID" name="txtID"  cols="10" value="<?php echo filtreChainePourNavig($idSalarie) ; ?>"/>
    </p>
    
    <p>
      <label for="dateEntree" style="font-size: 1.5em;">Date d'entrée : </label>
      <input type="date" id="dateEntree" name="dateEntree" <?php if (!is_null($dateEntree)){?>value="<?php echo filtreChainePourNavig($dateEntree) ; ?>"<?php }?> />
    </p>
    <br> <br>
    <p>
      <label for="chkArchive" style="font-size: 1.5em;">Archive ?  </label>
      <input type='hidden' name='chkArchive' value='0' />
      <input type="checkbox" id="chkArchive" style="width: 30px; height: 30px;" name="chkArchive" <?php if($issalarie==true){echo 'onclick="afficher()"';}?> value="1" <?php if($archive==1) {echo 'checked';}?>>
      <label for="dateSortie" style="font-size: 1.5em;" id="labDateSortie">Date de sortie : </label>
      <input type="date" id="dateSortie" name="dateSortie" <?php if (!is_null($dateSortie)){?>value="<?php echo filtreChainePourNavig($dateSortie) ; ?>"<?php }?>/>
    
    </p>


    <p>
      <label for="chkTemporaire" id="labTemporaire" style="font-size: 1.5em;" >Archive temporaire </label>
      <input type="checkbox" id="chkTemporaire" style="width: 30px; height: 30px;" name="chkTemporaire" value="1" onclick="afficher2()" <?php if($archiveTemporaire==1) {echo 'checked';}?>>
    </p>
    <p>
      <label id="labFinArchive" style="font-size: 1.5em;" >jusqu'à </label>
      <input type="month" id="dateFinArchive" name="dateFinArchive"  value="<?php echo substr($dateFinArchiveTemporaire, 0 , -3); ?>">
    </p>
      
        <br> <br>
    <p>
        <label for="chkArret" style="font-size: 1.5em;">Arrêt de travail ?  </label>
      <input type="checkbox" id="chkArret" style="width: 30px; height: 30px;" name="chkArret" value="1" onclick="afficher3()" <?php if($arret==1) {echo 'checked';}?>/>
    
        <label for="finArret" style="font-size: 1.5em;" id="labFinArret" >Date de fin d'arrêt:  </label>
        <input type="date" id="finArret"  name="finArret" <?php echo 'value="'.$dateFinArret.'"'; ?> />
    </p>

    <br> <br> <br>

    <p>
      <label for="txtCertifs">Certifications : </label>
      <textarea id="txtCertifs" name="txtCertifs"  cols="70" ><?php echo filtreChainePourNavig($certifs) ; ?></textarea>
    </p>
    </fieldset>
      </br>
  <?php }
  if($issalarie==false){echo '<fieldset style="display: flex; flex-direction: column; width: 100%;">';}else{      
    echo '<fieldset style="display: flex; flex-direction: column; width: 45%; margin-left:10%;">';    
  }
    ?>
      <!-- On peut retrouver la mention IM correspondant au ménage dans le code suivant -->
      <!-- Il s'agit d'un reste de code ancien qui spérait les disponibilités ménages et GE -->
      <!-- La mention est restée même si le code suivant ne correpsond plus uniquement au ménage -->
                    <legend><strong>AJOUTER DES DISPONIBILITES :</legend></p>

                      <div id='divIM'> <!-- Ici la mention en question -->
                      &nbsp;
                      <?php 
                          //Permet de cocher/décocher la checkbox qui dit si l'intervenant est disponible
                          //mais ne sais pas encore quand
                          $numCandidat=lireDonneeUrl('num');
                          if($issalarie){
                            $dispoM=$pdoChaudoudoux->ObtenirDispoMenage($num);
                            $dispoGE=$pdoChaudoudoux->ObtenirDispoGE($num);
                          }
                          else {
                            $dispoM=$pdoChaudoudoux->ObtenirDispoCandidMenage($num);
                            $dispoGE=$pdoChaudoudoux->ObtenirDispoCandidGE($num);
                            
                          }
                          $chkDispoInconnue = false;
                          foreach ($dispoM as $key => $uneDispoM){
                              $jourM=$uneDispoM['jour'];
                              $hDebM=$uneDispoM['heureDebut'];
                              $hFinM=$uneDispoM['heureFin'];
                              if($jourM=="dimanche" && $hFinM=="01:01:00" && $hDebM=="01:01:00"){
                                  $chkDispoInconnue = true;
                              }
                          }
                          foreach ($dispoGE as $key => $uneDispoGE){
                            $jourGE=$uneDispoGE['jour'];
                            $hDebGE=$uneDispoGE['heureDebut'];
                            $hFinGE=$uneDispoGE['heureFin'];
                            if($jourGE=="dimanche" && $hFinGE=="01:01:00" && $hDebGE=="01:01:00"){
                                $chkDispoInconnue = true;
                            }
                        }
                      ?>
                      <label for="chkDispoInconnue"> Disponibilités en attente : </label>
                      <input type="checkbox" id="chkDispoInconnue" name="chkDispoInconnue" value="1" <?php if($chkDispoInconnue == true){echo "checked";}?>/> 
                      <br/><br/>
                      <label>Type : &nbsp; </label>
                      <select name ="slctType">
                        <option value="typeDefault" selected>Type</option>
                        <option value="typeGE">Garde d'enfant</option>
                        <option value ="typeMenage">Ménage</option>
                        <option value="doubleType">GE & Ménage</option>
                      </select>
                      <label>Le : &nbsp; </label>
                      <select name="slctJourIM" > <!-- Ici la mention en question -->
                        <option value="jour" selected>Jour</option>
                        <option value="lundi">Lundi</option>
                        <option value="mardi">Mardi</option>
                        <option value="mercredi">Mercredi</option>
                        <option value="jeudi">Jeudi</option>
                        <option value="vendredi">Vendredi</option>
                        <option value="samedi">Samedi</option>
                        <option value="dimanche">Dimanche</option>
                      </select>
                      <label>de : &nbsp; </label>
                        <select name="HdebIM"> <!-- Ici la mention en question -->
                        <?php for ($i=0; $i<24;++$i){?>
                        <option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option>
                        <?php }?>
                        </select>
                        
                        <select name="minDebIM">  <!-- Ici la mention en question -->
                            <option value='00'>00</option>
                            <option value='15'>15</option>
                            <option value='30'>30</option>
                            <option value='45'>45</option>
                        </select>
                        
                        <label>à : &nbsp; </label>
                      <select name="HfinIM">  <!-- Ici la mention en question -->
                      <?php for ($i=23; $i>=0;--$i){?>
                          <option value="<?php if($i>10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option>
                      <?php }?>
                      </select>
                      
                      <select name="minFinIM">  <!-- Ici la mention en question -->
                          <option value='45'>45</option>
                          <option value='30'>30</option>
                          <option value='15'>15</option>
                          <option value='00'>00</option>
                      </select>
                      
                      <label for="frequenceIM">Une semaine sur :</label>  <!-- Ici la mention en question -->
                      <input name="frequenceIM" value="1" size='1' required/> <!-- Ici la mention en question -->
                      
                      <!-- <input type="button" onclick='resetM()' value="Réinitialiser"/> -->
                      
                      
                      
                  </br>
                    </div>
                    
                    
                    <input type="button" onclick='ajoutCreneauxIM()' value='+'/> <!-- Ici la mention en question -->
                    <input type="button" onclick='suppCreneauxIM()' value='-'/> <!-- Ici la mention en question -->
       
                    <?php echo str_repeat("<br/>", 5) //sert à créer un espacement : saut de 5 lignes ?>
                    <legend><strong>DISPONIBILITES POUR LE MENAGE: </legend></p>
                    
                    <style>
                      table,td,tr{
                        border: 1px solid black;
                        text-align:center;
                      }
                    </style>
                      
                      <table style=width:90%;>
                        <thead> 
                          <th style=background-color:#fff;> Activité </th>
                          <th style=background-color:#fff;> Jour / Horaires </th>
                          <th style=background-color:#fff;> Fréquence de la prestation </th>
                          <th style=background-color:#fff;> Modifier </th>
                          <th style=background-color:#fff;> Supprimer </th>
                          
                        </thead>
                        
                        <tbody><?php
                        $numCandidat=lireDonneeUrl('num');

                        //SI intervenant 
                        if($issalarie){
                          //On met des dispos dans la colonne numero_Intervenant
                          $dispoM=$pdoChaudoudoux->ObtenirDispoMenage($num);
                          $dispoGE=$pdoChaudoudoux->ObtenirDispoGE($num);
                        }
                        //Sinon
                        else {
                          //On met des dispos dans la colonne numero_Candidat
                          $dispoM=$pdoChaudoudoux->ObtenirDispoCandidMenage($num);
                          $dispoGE=$pdoChaudoudoux->ObtenirDispoCandidGE($num);
                        }

         
                        foreach ($dispoM as $key => $uneDispoM){
                          $jourM=$uneDispoM['jour'];
                          $hDebM=$uneDispoM['heureDebut'];
                          $hFinM=$uneDispoM['heureFin'];
                          $frequenceM=$uneDispoM['frequence'];
                          $activite=$uneDispoM['activite'];
                          $id=$uneDispoM['id'];
                          if($jourM=="dimanche" && $hFinM=="01:01:00" && $hDebM=="01:01:00"){
                            continue;
                          }
                          //$numFamille=$uneDispoM['numero'];
                          echo "<tr>";
                            echo "<td> Menage </td>";
                            echo "<td> <strong>".$jourM." - ".$hDebM." à ".$hFinM."<br><br></strong> </td>";
                            echo "<td> Une semaine sur ".$frequenceM."</td>";
                            echo '<td> <a href="index.php?uc=annuSalarie&amp;action=modifierDispoInterv&amp;numDispo='.$id.'">Modifier</a> </td>';
                            echo '<td> <a href="index.php?uc=annuSalarie&amp;action=supprimerDispoInterv&amp;numDispo='.$id.'">Supprimer</a> </td>';
                            // pour ajout de numFamille, mettre dans le lien au dessus après le numDemande='.$id.'&amp
                          echo '</tr>';
                          
                          
                          
                        }
                        echo "</tbody>";
                        ?>

                        </table> <?php echo str_repeat("<br/>", 3) ?>
                        <legend><strong>DISPONIBILITES POUR LA GARDE D'ENFANTS: </legend></p>
                        
                        <table style=width:90%;>
                          <thead>
                            
                            <th style=background-color:#fff;> Activité </th>
                            <th style=background-color:#fff;> Jour / Horaires </th>
                            <th style=background-color:#fff;> Fréquence de la prestation </th>
                            <th style=background-color:#fff;> Modifier </th>
                            <th style=background-color:#fff;> Supprimer </th>
                            
                            
                          </thead>
                          
                          <tbody><?php
 
                          foreach ($dispoGE as $key => $uneDispoGE){
                            $jourGE=$uneDispoGE['jour'];
                            $hDebGE=$uneDispoGE['heureDebut'];
                            $hFinGE=$uneDispoGE['heureFin'];
                            $frequenceGE=$uneDispoGE['frequence'];
                            $activite=$uneDispoGE['activite'];
                            $id=$uneDispoGE['id'];
                            if($jourGE=="dimanche" && $hFinGE=="01:01:00" && $hDebGE=="01:01:00"){
                              continue;
                            }
                            //$numFamille=$uneDispoGE['numero'];
                            echo "<tr>";
                              echo "<td> Garde d'enfants </td>";
                              echo "<td><strong> ".$jourGE." - ".$hDebGE." à ".$hFinGE."<br><br> </strong></td>";
                              echo "<td> Une semaine sur ".$frequenceGE." </td>";
                              echo '<td> <a href="index.php?uc=annuSalarie&amp;action=modifierDispoInterv&amp;numDispo='.$id.'">Modifier</a> </td>';
                              echo '<td> <a href="index.php?uc=annuSalarie&amp;action=supprimerDispoInterv&amp;numDispo='.$id.'&amp">Supprimer</a> </td>';
                              // pour ajout de numFamille, mettre dans le lien au dessus après le numDemande='.$id.'&amp       
                            echo '</tr>';
                          }
                echo "</tbody>"; 
                echo "</table>";?>
    
                  </fieldset>
                  <?php if($issalarie==false){echo '</fieldset>';
                  

                    }else{echo '</div>';}?>
  <?php echo str_repeat("<br/>", 4) ?>
  
  
  <div style="display: flex; flex-direction: row;  ">

  <fieldset  style="display: flex; flex-direction: column; width: 45%">
    <legend>INFORMATIONS PERSONNELLES</legend>
    <p>
      <label for="slctTitre">Titre : </label>
      <select id="slctTitre" name="slctTitre">
        <option value="MR" <?php if ($titre == "MR"){ echo "selected";} ?> >MR.</option>
        <option value="MME" <?php if ($titre == "MME"){ echo "selected";} ?> >MME.</option>
      </select>
    </p>
    <p>
      <label for="txtNom" >Nom *: </label>
      <input id="txtNom" name="txtNom" size="20" required maxlength="50" value="<?php echo $nom; ?>"/>
    </p>
    <p>
        <label for="nomJF">Nom de jeune fille : </label>
        <input type="text" name="nomJF" size="20" value="<?php echo $nomJF?>"/>
    </p>
    <p>
      <label for="txtPrenom">Prenom *: </label>
      <input id="txtPrenom" name="txtPrenom" size="20" required maxlength="50" value="<?php echo $prenom; ?>"/>
    </p>
    <p>
      <label for="dateNaiss">Date de naissance : </label>
      <input type="date" id="dateNaiss" name="dateNaiss" value="<?php echo filtreChainePourNavig($dateNaiss->format('Y-m-d')); ?>" />
    </p>
    <p>
    <label for="txtLieuNaiss">Lieu de naissance : </label>
    <input id="txtLieuNaiss" name="txtLieuNaiss" size="20" maxlength="20" value="<?php echo $lieuNaiss; ?>"/>
  </p>
  <p>
    <label for="txtPaysNaiss">Pays de naissance : </label>
    <input id="txtPaysNaiss" name="txtPaysNaiss" size="20" maxlength="20" value="<?php echo $paysNaiss; ?>"/>
  </p>
  <p>
    <label for="txtNatio">Nationalité : </label>
    <input id="txtNatio" name="txtNatio" size="20" maxlength="25" value="<?php echo $natio; ?>"/>
  </p>
  <p>
    <label for="txtTS">Titre de séjour : </label>
    <input id="txtTS" name="txtTS" maxlength="15" size="15" onfocusout="verifNumTel()" value="<?php echo $numTS; ?>"/>
  </p>
  <p>
      <label for="dateTS"> Date d'expiration du titre de séjour : </label>
      <input type="date" id="dateTS" name="dateTS" <?php if (!is_null($dateTS)){?>value="<?php echo filtreChainePourNavig($dateTS) ; ?>"<?php }?> />
    </p>
  <p>
    <label for="txtNumSS">N° de sécurité sociale : </label>
    <input id="txtNumSS" name="txtNumSS" maxlength="40" size="20" onfocusout="verifNumTel()" value="<?php echo $numSS; ?>"/>
  </p>
  <p>
    <label for="txtMutuelle">Mutuelle :</label>
    <input id="txtMutuelle" name="txtMutuelle" maxlength="40" size="15" value="<?php echo $mutuelle; ?>"/>
  </p>
  <p>
    <label for="chkCMU" style="font-size: 1.5em;">CMU :</label>
    <input id="chkCMU" name="chkCMU" style="width: 30px; height: 30px;" type="checkbox" value="1" <?php if($cmu==1) {echo "checked";} ?>/>
  </p>
  <p>
      <label for="slctSitFam">Situation familiale : </label>
      <select id="slctSitFam" name="slctSitFam">
        <option value="CELIBATAIRE" <?php if ($sitFam == "CELIBATAIRE") {echo "selected";} ?> >Célibataire</option>
        <option value="EN COUPLE" <?php if ($sitFam == "EN COUPLE") {echo "selected";} ?> >En couple</option>
        <option value="MARIE" <?php if ($sitFam == "MARIE") {echo "selected";} ?> >Marié(e)</option>
        <option value="PACSE" <?php if ($sitFam == "PACSE") {echo "selected";} ?> >Pacsé(e)</option>
        <option value="VEUF" <?php if ($sitFam == "VEUF") {echo "selected";} ?> >Veuf(ve)</option>
      </select>
    </p>
  </fieldset>
  <br/>
  <fieldset style="display: flex; flex-direction: column; margin-left: 10%; width: 45%">
  <legend>COORDONNÉES</legend>
  <p>
    <label for="txtAdr">Adresse : </label>
    <input id="txtAdr" name="txtAdr" maxlength="50" size="70" value="<?php echo $adresse; ?>"/>
  </p>



  <p>
  	<label for="txtVille">Ville : </label>
          <input list="my-select" type="text" id="txtVille" name="txtVille" value="<?php echo $ville; ?>" >

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
  	<input  id="txtCp" list="my--select" name="txtCp" size="5" maxlength="5" pattern="^[0-9]{5}$" value="<?php echo $cp; ?>"/>

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

  afficher();
  afficher2();
  afficher3();

  
    function afficher() {

      chkBox = document.getElementById("chkArchive");
      console.log(chkBox);
  
if(chkBox!=null){
  valeur = document.getElementById("chkArchive").checked;
  console.log(valeur);
 
  if (valeur == true) {
    document.getElementById("labTemporaire").hidden = false;
    document.getElementById("chkTemporaire").hidden = false;

    document.getElementById("dateSortie").hidden = false;
    document.getElementById("labDateSortie").hidden = false;
    

    afficher2();
    
  } else {
    document.getElementById("labTemporaire").hidden = true;
    document.getElementById("chkTemporaire").hidden = true;
    
    document.getElementById("dateFinArchive").hidden = true;
    document.getElementById("labFinArchive").hidden = true;

    document.getElementById("dateSortie").hidden = true;
    document.getElementById("labDateSortie").hidden = true;
    document.getElementById("dateSortie").value = "";
    
  }
}
}
function afficher2() {
  checkbox=document.getElementById("chkTemporaire");

  if(checkbox!=null){

  valeur = document.getElementById("chkTemporaire").checked;
  if (valeur == true) {
    document.getElementById("dateFinArchive").hidden = false;         
    document.getElementById("labFinArchive").hidden = false;
  } else {
    document.getElementById("dateFinArchive").hidden = true;
    document.getElementById("labFinArchive").hidden = true;
  }}

}
function afficher3() {
  checkbox=document.getElementById("chkArret");
  if(checkbox!=null){
  valeur = document.getElementById("chkArret").checked;
  if (valeur == true) {
    document.getElementById("finArret").hidden = false;         
    document.getElementById("labFinArret").hidden = false;
    
  } else {
    document.getElementById("finArret").hidden = true;
    document.getElementById("labFinArret").hidden = true;
    document.getElementById("finArret").value = "";
  }}
}

var suppCreneauxIM = () =>{

var divId = document.getElementById("IM"+idM+"");
idM-- ;
console.log(idM);
if (idM===0){
  alert('Vous ne pouvez plus rien effacer');
}
divId.remove();


}


let idGE = 0;
function generateIdGE() {
    return ++idGE;
}
//adapter cette fonction pour pouvoir reset les valeurs de chaque ligne, ancienne fonction pour reset une ligne de plusieurs select
/*
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
*/
let idM = 0;
function generateIdM() {
    return ++idM;
}

var ajoutCreneauxIM = () => {
  let idM = generateIdM();
  
  var html="<div id='IM"+idM+"'>";

html +=parent.innerHTML= "<label>Type :&nbsp;&nbsp </label>";
  html +="<select name='slctType"+idM+"'>";
  html +="<option value='typeDefault' selected>Type</option>";
  html +="<option value='typeGE'>Garde d'enfant</option>";
  html +="<option value='typeMenage'>Ménage</option>";
  html +="<option value='doubleType'>GE & Ménage</option>";
  html +="</select>";
  html += "<label> &nbsp Le :&nbsp;&nbsp;&nbsp;</label>";

html +=parent.innerHTML ="<select name='slctJourIM"+idM+"'>";
  html +="<option value='jour' selected>Jour</option>";
  html +="<option value='lundi'>Lundi</option>";
  html +="<option value='mardi'>Mardi</option>";
  html +="<option value='mercredi'>Mercredi</option>";
  html +="<option value='jeudi'>Jeudi</option>";
  html +="<option value='vendredi'>Vendredi</option>";
  html +="<option value='samedi'>Samedi</option>";
  html +="<option value='dimanche'>Dimanche</option>";
  html +="</select>"; 
  html +=" de : &nbsp;&nbsp;";
  let optionsDeb = "";
for (let i = 0; i < 24; i++) {
    optionsDeb += "<option value='" + i + "'>" + i + "</option>";
}
html +=parent.innerHTML = "<select name='HDebIM"+idM+"'>" + optionsDeb + "</select> ";
  html +="<select name='minDebIM"+idM+"'>";
  html +="<option value='00'>00</option>";
  html +="<option value='15'>15</option>";
  html +="<option value='30'>30</option>";
  html +="<option value='45'>45</option>";
  html +="</select>";
  html +=" à :&nbsp;&nbsp;&nbsp;";
  let options = "";
for (let i = 0; i < 24; i++) {
    options += "<option value='" + i + "'>" + i + "</option>";
}
html +=parent.innerHTML = "<select name='HfinIM"+idM+"'>" + options + "</select> ";

  html +="<select name='minFinIM"+idM+"'>";
  html +="<option value='00'>00</option>";
  html +="<option value='15'>15</option>";
  html +="<option value='30'>30</option>";
  html +="<option value='45'>45</option>";
  html +="</select>";
  html +="<label for='frequence'> &nbsp Une semaine sur :&nbsp;&nbsp;</label>";
  html +="<input name='frequenceIM"+idM+"' value='1' size='1' required/>";
  
  
  var divGlobal =document.getElementById('divIM');
  divGlobal.innerHTML += html;
  
  
}
  </script>
  
  <p>
    <label for="txtQuart">Quartier : </label>
    <input id="txtQuart" name="txtQuart"  size="20" maxlength="50" value="<?php echo $quartier; ?>"/>
  </p>

  <p>
    <label for='secteurFamille'> Secteur de Rennes (centre ) : </label>
    <select name="slctSecteur">
      <?php
        if($secteurCandidat == "Aucun"){echo("<option value='Aucun' selected>AUCUN</option>");}
        else{ echo("<option value='Aucun'>AUCUN</option>"); }

        if($secteurCandidat == "Nord"){echo("<option value='Nord' selected>NORD</option>");}
        else{ echo("<option value='Nord'>NORD</option>"); }
        
        if($secteurCandidat == "Est"){echo("<option value='Est' selected>EST</option>");}
        else{ echo("<option value='Est'>EST</option>"); }

        if($secteurCandidat == "Sud"){echo("<option value='Sud' selected>SUD</option>");}
        else{ echo("<option value='Sud'>SUD</option>"); }
        
        if($secteurCandidat == "Ouest"){echo("<option value='Ouest' selected>OUEST</option>");}
        else{ echo("<option value='Ouest'>OUEST</option>"); }            
       ?>
    </select>
  </p>

  
  <p>
    <label for="txtPort">Téléphone Portable : </label>
    <input id="txtPort" name="txtPort" maxlength="14" size="10" onfocusout="verifNumTel()"  value="<?php echo $telPort; ?>" onsubmit="verifNumTel()"/>

  </p>
  <p>
    <label for="txtFixe">Téléphone fixe : </label>
    <input id="txtFixe" name="txtFixe" maxlength="14" size="10" onfocusout="verifNumTel()" value="<?php echo $telFixe; ?>"/>
  </p>
  <p>
    <label for="txtUrg">Téléphone en cas d'urgence: </label>
    <input id="txtUrg" name="txtUrg" maxlength="14" size="10" onfocusout="verifNumTel()" value="<?php echo $telUrg; ?>"/>
  </p>
  <p>
    <label for="txtEmail" accesskey="t">E-mail : </label>
    <input type="text" id="txtEmail" name="txtEmail" size="40" maxlength="40"value="<?php echo $email; ?>"/>
  </p>
  </fieldset></div>
  <br/>
  <div style="display: flex; flex-direction: row;  ">
  <fieldset  style="display: flex; flex-direction: column; width: 45%">
    <legend>INFORMATIONS PROFESSIONNELLES</legend>
    <p>
      <label for="slctStatPro">Statut professionnel : </label>
      <select id="slctStatPro" name="slctStatPro">
        <option value="ETUDIANT" <?php if ($statutPro == "ETUDIANT") {echo "selected";} ?> >Etudiant</option>
        <option value="PROFESSIONNEL" <?php if ($statutPro == "PROFESSIONNEL") {echo "selected";} ?> >Professionnel</option>
        <option value="PRO <26ans" <?php if ($statutPro == "PRO <26ans") {echo "selected";} ?> >Pro <26ans</option>
      </select>
    </p>
    <p>
    <label for="chkStatutHandicap" style="font-size: 1.5em;">Statut handicapé :</label>
    <input id="chkStatutHandicap" name="chkStatutHandicap" style="width: 30px; height: 30px;" type="checkbox" value="1" <?php if($statutHandicap==1) {echo "checked";} ?>/>
  </p>
    <p>
      <label for="txtDip">Diplômes : </label>
      <textarea id="txtDip" name="txtDip"  maxlength="150" cols="70"><?php echo $diplomes; ?></textarea>
    </p>
    <p>
      <label for="txtQualifs">Qualifications : </label>
      <textarea id="txtQualifs" name="txtQualifs" maxlength="100" cols="70"><?php echo $qualifs; ?></textarea>
    </p>
    <p>
        <label for="travailVoulu">Enfants/Ménage/Tout :</label>
        <select name="travailVoulu">
            <option value="ENFANT" <?php if($trav =="ENFANT") {echo 'selected';}?>>Garde d'enfants</option>
            <option value="MENAGE" <?php if($trav =="MENAGE") {echo 'selected';}?>>Ménage</option>
            <option value="TOUT"<?php if($trav =="TOUT") {echo 'selected';}?>>Tout</option>
            <option value="EMPLOYÉ"<?php if($trav =="EMPLOYÉ") {echo 'selected';}?>>Employé</option>
        </select>
      </br>
      <?php if($issalarie==true) {  ?>
      <label for="repassage"> Repassage: </label>
      <input type="hidden" name="repassage" value='0'/>
      <input type="checkbox" name="repassage" value='1' <?php if($repassage==1) {echo 'checked';}  ?> />
     <?php }?>
    </p>
    <p>
      <label for="txtDispo">Disponibilités : </label>
      <textarea id="txtDispo" name="txtDispo" maxlength="1000" cols="100" rows="7  "><?php echo $dispo; ?></textarea>
    </p>
    <p>
      <label for="txtObs">Observations : </label>
      <textarea id="txtObs" name="txtObs" maxlength="1000" cols="100" rows="7"><?php echo $observ; ?></textarea>
    </p>
    <p>
      <label for="chkPermis">Permis :</label>
      <input type="checkbox" id="chkPermis" name="chkPermis" value="1" <?php if ($permis == 1) { echo "checked";} ?> />
    </p>
    <p>
      <label for="chkVehicule">Vehicule :</label>
      <input type="checkbox" id="chkVehicule" name="chkVehicule" value="1" <?php if ($vehicule == 1) {echo "checked";} ?> />
    </p>
  </fieldset></br>
  <br/><?php if ($issalarie==true){?>

  <fieldset style="display: flex; flex-direction: column; margin-left:10%;width: 45%">
  <legend>INFORMATIONS SPÉCIFIQUES AU SALARIÉ</legend>
       
        
  <p>
      <label for="txtTauxH">Taux Horaire demandé : </label>
      <input id="txtTauxH" name="txtTauxH" maxlength="5" size="5" value="<?php echo filtreChainePourNavig($tauxH) ; ?>" />
    </p>
    <p>
      <label for="nbHsem">Nombre d'heures par semaines recherché: </label>
      <input id="nbHsem" name="nbHsem" maxlength="5" size="50" value="<?php echo filtreChainePourNavig($nbHeureSem) ; ?>" />
    </p>
    <p>
      <label for="nbHmois">Nombre d'heures par mois recherché: </label>
      <input id="nbHmois" name="nbHmois" maxlength="5" size="50" value="<?php echo filtreChainePourNavig($nbHeureMois) ; ?>" />
    </p>
        <p>
      <label for="suivi">Suivi intervenant : </label>
      <textarea name="suivi"><?php echo filtreChainePourNavig($suivi) ; ?></textarea>
    </p>
    <p>
      <label for="chkComplH" style="font-size: 1.5em;">Recherche compléments d'heures :</label>
      <input type="checkbox" style="width: 30px; height: 30px;" id="chkComplH" name="chkComplH" value="1" 
      <?php if ( $rechCompl == 1 ) {echo 'checked';} ?> />
    </p>
    <p>
      <label for="chkPSC1" style="font-size: 1.5em;">PSC1 à proposer:</label>
      <input type="checkbox" style="width: 30px; height: 30px;" id="chkPSC1" name="chkPSC1" value="1" 
      <?php if ( $psc1 == 1 ) echo 'checked="checked"'; ?> />
    </p>
    <p>
      <label style="font-size: 1.5em;">Expérience avec les enfants de moins de trois ans : </label>
      <input name="chkExp1a" value='1' style="width: 30px; height: 30px;" type='checkbox' <?php if ($expBBmoins1a==1) echo 'checked';?> />
    </p>
    <p>
      <label style="font-size: 1.5em;">Expérience avec les enfants handicapés </label>
      <input name="chkEnfHand" style="width: 30px; height: 30px;" type='checkbox' value="1" <?php if($enfHand==1) {echo 'checked';} ?> />
    </p>
                    </div>
                  </br>
  <?php } ?>
  
      </table>
          <?php /*  <fieldset>
                            <legend>Ajout de documents</legend>
                            <?php for($i=0;$i<10;$i++){
                                if ($i%2==0){echo '<br/>';}?>                                
                            <input type="file" name="<?php echo $i;?>"/><?php }?><br/>
                            <label for="CV">CV</label>
                            <input type="file" name="CV"/>
                                           }               </fieldset>*/?>
  </div>
                                          </div>
 
  
    <input class="btn valider btn-secondary" style="position:fixed;bottom:0px;left:0px" id="cmdOk" type="submit" value="VALIDER" />
  
    <button style="position:fixed;bottom:0px;right:0px" class="retour btn" onclick="history.go(-1);">RETOUR</button>
  
  </form>
</div>      