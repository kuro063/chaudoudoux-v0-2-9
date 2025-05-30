<?php
if(lireDonneeUrl('uc')=='annuSalarie'){
?>
<!-- MAIL TOUS LES INTERVENANTS PRESTATAIRE -->
<?php if($action=='mailIntervPrest'){?>
  <legend style="color:black; margin-top : 50px; text-align: center">ADRESSES MAIL DE TOUS LES INTERVENANTS PRESTATAIRES</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a en tout : <?php echo $nbAdresse ?> intervenants prestataires </h3>
  <div style="column-count: 4; margin-left:10px; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  $i = 1;
  foreach ($adressesPrest as $adressePrest){
      if (isset($adressePrest['email_Candidats']) && $adressePrest['email_Candidats']!="" ) /*{echo '<i>'.$adressePrest['nom_Candidats'].', '.$adressePrest['prenom_Candidats'].'</i> : <b>'.$adressePrest['email_Candidats'].'</b>'?><br><?php ;}*/{echo '<b>'.$adressePrest['email_Candidats'].'</b>'?><br><?php ;}
  }
}
?>
 </div>
 
<!-- Mission 4 Hugo -->
 <!-- MAIL TOUS LES INTERVENANTS PRESTATAIRE ACTUELLEMENT-->
<?php if($action=='mailIntervPrestAct'){?>
  <legend style="color:black; margin-top : 50px; text-align: center">ADRESSES MAIL DE TOUS LES INTERVENANTS PRESTATAIRES - ACTUELLEMENT</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a en tout : <?php echo $nbAdresse ?> intervenants prestataires </h3>
  <div style="column-count: 4; margin-left:10px; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  $i = 1;
  foreach ($adressesPrest as $adressePrest){
      if (isset($adressePrest['email_Candidats']) && $adressePrest['email_Candidats']!="" ) /*{echo '<i>'.$adressePrest['nom_Candidats'].', '.$adressePrest['prenom_Candidats'].'</i> : <b>'.$adressePrest['email_Candidats'].'</b>'?><br><?php ;}*/{echo '<b>'.$adressePrest['email_Candidats'].'</b>'?><br><?php ;}
  }
}
?>
 </div>
<!-- Mission 4 Hugo -->

<!-- MAIL INTERVENANTS PRESTATAIRE GE + TOUT  -->
<?php if($action=='mailIntervPrestGE'){?>
  <legend style="color:black; margin-top : 50px; text-align: center">ADRESSES MAIL DES INTERVENANTS PRESTATAIRES - GARDE ENFANT</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a : <?php echo $nbAdresse ?> intervenants prestataire faisant de la garde d'enfant ou (ménage + garde d'enfant) </h3>
  <div style="column-count: 4; margin-left:10px; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  $i = 1;
  foreach ($adressesPrest as $adressePrest){
      if (isset($adressePrest['email_Candidats']) && $adressePrest['email_Candidats']!="" ) /*{echo '<i>'.$adressePrest['nom_Candidats'].', '.$adressePrest['prenom_Candidats'].'</i> : <b>'.$adressePrest['email_Candidats'].'</b>'?><br><?php ;}*/{echo '<b>'.$adressePrest['email_Candidats'].'</b>'?><br><?php ;}
  }
}
?>

<!-- MAIL INTERVENANTS PRESTATAIRE GE + TOUT ACTUELLEMENT -->
<?php if($action=='mailIntervPrestGEAct'){?>
  <legend style="color:black; margin-top : 50px; text-align: center">ADRESSES MAIL DES INTERVENANTS PRESTATAIRES - GARDE ENFANT - ACTUELLEMENT</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a : <?php echo $nbAdresse ?> intervenants prestataire faisant de la garde d'enfant ou (ménage + garde d'enfant) </h3>
  <div style="column-count: 4; margin-left:10px; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  $i = 1;
  foreach ($adressesPrest as $adressePrest){
      if (isset($adressePrest['email_Candidats']) && $adressePrest['email_Candidats']!="" ) /*{echo '<i>'.$adressePrest['nom_Candidats'].', '.$adressePrest['prenom_Candidats'].'</i> : <b>'.$adressePrest['email_Candidats'].'</b>'?><br><?php ;}*/{echo '<b>'.$adressePrest['email_Candidats'].'</b>'?><br><?php ;}
  }
}
?>

 </div>
<!-- Mission 4 Hugo -->

<!-- MAIL INTERVENANTS PRESTATAIRE MENAGE + TOUT -->
<?php if($action=='mailIntervPrestMen'){?>
  <legend style="color:black; margin-top : 50px; text-align: center">ADRESSES MAIL DES INTERVENANTS PRESTATAIRES - MENAGE</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a : <?php echo $nbAdresse ?> intervenants prestataires faisant du ménage ou (ménage + garde d'enfant) </h3>
  <div style="column-count: 4; margin-left:10px; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  $i = 1;
  foreach ($adressesPrest as $adressePrest){
      if (isset($adressePrest['email_Candidats']) && $adressePrest['email_Candidats']!="" ) /*{echo '<i>'.$adressePrest['nom_Candidats'].', '.$adressePrest['prenom_Candidats'].'</i> : <b>'.$adressePrest['email_Candidats'].'</b>'?><br><?php ;}*/{echo '<b>'.$adressePrest['email_Candidats'].'</b>'?><br><?php ;}
  }
}
?>
 </div>

 <!-- MAIL INTERVENANTS PRESTATAIRE MENAGE + TOUT ACTUELLEMENT-->
<?php if($action=='mailIntervPrestMenAct'){?>
  <legend style="color:black; margin-top : 50px; text-align: center">ADRESSES MAIL DES INTERVENANTS PRESTATAIRES - MENAGE - ACTUELLEMENT</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a : <?php echo $nbAdresse ?> intervenants prestataires faisant du ménage ou (ménage + garde d'enfant) </h3>
  <div style="column-count: 4; margin-left:10px; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  $i = 1;
  foreach ($adressesPrest as $adressePrest){
      if (isset($adressePrest['email_Candidats']) && $adressePrest['email_Candidats']!="" ) /*{echo '<i>'.$adressePrest['nom_Candidats'].', '.$adressePrest['prenom_Candidats'].'</i> : <b>'.$adressePrest['email_Candidats'].'</b>'?><br><?php ;}*/{echo '<b>'.$adressePrest['email_Candidats'].'</b>'?><br><?php ;}
  }
}
?>
 </div>
<!-- Mission 4 Hugo -->


<?php if($action=='mailIntervMand'){?>
  <legend style="text-align:center">ADRESSES MAIL DES INTERVENANTS MANDATAIRES</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a : <?php echo $nbAdresse ?> intervenants mandataires</h3>
  <div style="column-count: 4; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  foreach ($adressesMand as $adresseMand){
      if (isset($adresseMand['email_Candidats']) && $adresseMand['email_Candidats']!="" ) /*{echo '/*<i>'.$adresseMand['nom_Candidats'].', '.$adresseMand['prenom_Candidats'].'</i> : <b>'.$adresseMand['email_Candidats'].'</b>'?><br><?php ;}*/{echo '<b>'.$adresseMand['email_Candidats'].'</b>'?><br><?php ;}
  }
}
?>
 </div>

 <?php if($action=='mailIntervSansDispo'){?>
  <legend style="text-align:center">ADRESSES MAIL DES INTERVENANTS EN ATTENTE DE DISPONIBILITÉS</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a : <?php echo $nbAdresse ?> intervenants dont les disponibilités n'ont pas encore été saisies :</h3>
  <div style="column-count: 4; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  foreach ($adressesIntervSansDispo as $adresseMand){
      if (isset($adresseMand['email_Candidats']) && $adresseMand['email_Candidats']!="" ) /*{echo '/*<i>'.$adresseMand['nom_Candidats'].', '.$adresseMand['prenom_Candidats'].'</i> : <b>'.$adresseMand['email_Candidats'].'</b>'?><br><?php ;}*/{echo '<b>'.$adresseMand['email_Candidats'].'</b>'?><br><?php ;}
  }
}
?>
 </div>










 <?php if($action=='mailIntervMandAct'){?>
  <legend style="text-align:center">ADRESSES MAIL DES INTERVENANTS MANDATAIRES - ACTUELLEMENT</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a : <?php echo $nbAdresse ?> intervenants mandataires</h3>
  <div style="column-count: 4; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  foreach ($adressesMand as $adresseMand){
      if (isset($adresseMand['email_Candidats']) && $adresseMand['email_Candidats']!="" ) /*{echo '/*<i>'.$adresseMand['nom_Candidats'].', '.$adresseMand['prenom_Candidats'].'</i> : <b>'.$adresseMand['email_Candidats'].'</b>'?><br><?php ;}*/{echo '<b>'.$adresseMand['email_Candidats'].'</b>'?><br><?php ;}
  }
}
?>
 </div>

<?php if($action=='mailIntervDisp'){?>
  <legend style="text-align:center">ADRESSES MAIL DES INTERVENANTS DISPONIBLES</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a : <?php echo $nbAdresse ?> intervenants disponibles</h3>
  <div style="column-count: 4; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  foreach ($adressesDisp as $adresseDisp){
      if (isset($adresseDisp['email_Candidats']) && $adresseDisp['email_Candidats']!="" ) /*{echo '<i>'.$adresseDisp['nom_Candidats'].', '.$adresseDisp['prenom_Candidats'].'</i> : <b>'.$adresseDisp['email_Candidats'].'</b>'?><br><?php ;}*/{echo '<b>'.$adresseDisp['email_Candidats'].'</b>'?><br><?php ;}
  }
}
?>
 </div>

<?php if($action=='mailIntervArchiv'){?>
  <legend style="text-align:center">ADRESSES MAIL DES INTERVENANTS ARCHIVÉS</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a : <?php echo $nbAdresse ?> intervenants archivés</h3>
  <div style="column-count: 4; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  foreach ($adressesArchi as $adresseArchi){
      if (isset($adresseArchi['email_Candidats']) && $adresseArchi['email_Candidats']!="" ) /*{echo '<i>'.$adresseArchi['nom_Candidats'].', '.$adresseArchi['prenom_Candidats'].'</i> : <b>'.$adresseArchi['email_Candidats'].'</b>'?><br><?php ;}*/{echo '<b>'.$adresseArchi['email_Candidats'].'</b>'?><br><?php ;}
  }
}
?>
 </div>

<?php
}
?>



<?php
if(lireDonneeUrl('uc')=='annuFamille'){
?>


<?php if($action=='mailFamPrestGE'){?>
  <legend style="margin-top : 50px; text-align:center">ADRESSES MAIL DES FAMILLES PRESTATAIRES GARDE D'ENFANTS</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a : <?php echo $nbAdresse ?> familles prestataires - GE</h3>
  <div style="column-count: 4; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  foreach ($adressesPrest as $adressePrest){
      if (isset($adressePrest['email_Parents']) && $adressePrest['email_Parents']!="" ) /*{echo '<i>'.$adressePrest['nom_Parents'].', '.$adressePrest['prenom_Parents'].'</i> : <b>'.$adressePrest['email_Parents'].'</b>'?><br><?php ;}*/{echo '<b>'.$adressePrest['email_Parents'].'</b>'?><br><?php ;}
  }
}
?>
 </div>


 <?php if($action=='mailFamPrestMen'){?>
  <legend style="margin-top : 50px; text-align:center">ADRESSES MAIL DES FAMILLES PRESTATAIRES MÉNAGE</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a : <?php echo $nbAdresse ?> familles prestataires - MÉNAGE</h3>
  <div style="column-count: 4; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  foreach ($adressesPrest as $adressePrest){
      if (isset($adressePrest['email_Parents']) && $adressePrest['email_Parents']!="" ) /*{echo '<i>'.$adressePrest['nom_Parents'].', '.$adressePrest['prenom_Parents'].'</i> : <b>'.$adressePrest['email_Parents'].'</b>'?><br><?php ;}*/{echo '<b>'.$adressePrest['email_Parents'].'</b>'?><br><?php ;}
  }
}
?>
 </div>


<?php if($action=='mailFamMand'){?>
  <legend style="margin-top : 50px; text-align:center">ADRESSES MAIL DES FAMILLES MANDATAIRES</legend>
  <h3 style="margin:10px; font-size: 1.2em"> Il y a : <?php echo $nbAdresse ?> familles mandataires</h3>
  <div style="column-count: 4; margin-bottom: 50px; border-style: solid; border-width: 2px">
  <?php
  foreach ($adressesMand as $adresseMand){
      if (isset($adresseMand['email_Parents']) && $adresseMand['email_Parents']!="" ) /*{echo '<i>'.$adresseMand['nom_Parents'].', '.$adresseMand['prenom_Parents'].'</i> : <b>'.$adresseMand['email_Parents'].'</b>'?><br><?php ;}*/{echo '<b>'.$adresseMand['email_Parents'].'</b>'?><br><?php ;}
  }
}
?>
 </div>

<?php
}
?>

<p>
  <legend style="text-align:center">Nous n'avons pas les adresses des personnes suivantes</legend>
  <?php
  if(lireDonneeUrl('uc')=='annuFamille'){ ?>
        <h4 style="margin-left:200px;margin-right:100px"> Tous : </h4>
        <p style="margin-left:200px;margin-right:100px">
    <?php
    foreach ($adressesVides as $adresseVide){
        echo '<i>'.$adresseVide['nom_Parents'].', '.$adresseVide['prenom_Parents'].'</i><b> | </b>'; 
        }?>
      </p>
  </p>
 <?php } 
 if (lireDonneeUrl('uc')=='annuSalarie'){ ?>
  <h4 style="margin-left:200px;margin-right:100px"> Tous : </h4>
    <p style="margin-left:200px;margin-right:100px"><?php
  foreach ($adressesVides as $adresseVide){
    echo '<i>'.$adresseVide['nom_Candidats'].', '.$adresseVide['prenom_Candidats'].'</i><b> | </b>';
  } ?>
  </p> <?php
 } ?>
  
<button style="position:fixed;bottom:0px;left:0px" class="btn btn-md btn-secondary display-4" onclick="history.go(-1);">RETOUR</button>




<!--Vincent bouton vers le haut de page--> 
<button class="button" onclick="topFunction()" id="topBtn"><img src="../images/toTop.png" width="60"></button>

<script>
 window.onscroll = function() {scrollFunction()};

 function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("topBtn").style.display = "block";
  } else {
    document.getElementById("topBtn").style.display = "none";
  }
 }

 function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
 }
</script>

<!--<a style="position:fixed">COPIER</a>-->



      