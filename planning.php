
<?php session_start(); ?>
<!doctype html>
<html lang="FR">
<head>
  <meta charset="UTF-8">
  <script src="./styles/geo-api.js"></script>
  <script defer type="module">
    import { getDistance } from "./styles/geo-api.js";
    (async () => {
  const tab = document.getElementById("tabHeures");
  for (const line of tab.rows) {
    const firstTd = line.querySelector("td");
    if (!line.querySelector("th") && firstTd && firstTd.textContent.trim() !== "") {
      const addr_can = line.querySelectorAll("td")[11].textContent.trim();
      const addr_fam = line.querySelectorAll("td")[6].textContent.trim();
      const addr_chau = "22 rue jean Guéhenno, 35700, Rennes";

      const dist_can_fam = line.querySelectorAll("td")[7];
      const dist_chau_fam = line.querySelectorAll("td")[8];

      if (addr_fam) {
        dist_can_fam.textContent = await getDistance(addr_can, addr_fam) + " Km";
      }

      dist_chau_fam.textContent = await getDistance(addr_chau, addr_fam) + " Km";
      console.log(addr_fam)


    }
  }
})();
  </script>
</head>
<body>

<?php

 include 'vues/v_entete.php'; 
 require_once("include/fct.inc.php");
 require_once ("include/class.pdoBdChaudoudoux.inc.php"); 
 $num=lireDonneeUrl('num');

 $tabErreurs = array();
 $user= obtenirNumConnecte();
 if($user==null)
 {
    $user='root';
 }
 $pdoChaudoudoux = new PdoBdChaudoudoux("localhost", "bdchaudoudoux", "root","");
 $nomSal=$pdoChaudoudoux->trouverNomSal($num);
 if ($num!=99999)
 {
    $lesCreneaux=$pdoChaudoudoux->obtenirCreneaux($num);
 }
 else
 {
    $numFam= lireDonneeUrl('numFam');
    $lesCreneaux=$pdoChaudoudoux->obtenirCreneauxFam($numFam);
 }
 $lesFam=$pdoChaudoudoux->obtenirNbHeures($num);
 $sal=$pdoChaudoudoux->obtenirDetailsSalarie($num);
 if (isset($_POST['dispo']))
 {
    $rechCompl= lireDonneePost('rechCompl');
    $archive= lireDonneePost('chkArchive');
    $dispo= lireDonneePost('dispo');
    $observ= lireDonneePost('observ');
    $pdoChaudoudoux->changerdepuiPlaning($num, $dispo, $rechCompl, $archive, $observ);
 }
?>


<h5>

<?php
 if ($pdoChaudoudoux->horsedt($num))
 {    
    echo 'CETTE INTERVENANTE A DES CRENEAUX HORS DE L\'EMPLOI DU TEMPS';
 }
 if ($sal[0]['arretTravail_Intervenants']==1)
 {
    echo '   SALARIE EN ARRET DE TRAVAIL ACTUELLEMENT';
 }
 $nomJF=$sal[0]['nomJF_Candidats'];
?> 


</h5>

<?php
 $jour= array(0=>'0',1=>'lundi',2=>'mardi',3=>'mercredi', 4=>'jeudi',5=>'vendredi',6=>'samedi',7=>'dimanche');
?>

<a href="#" class="btn btn-md btn-secondary display-4" style="float:right; font-weight: bold;" onclick="javascript:window.print()">Imprimer</a>

<?php 
 if (lireDonneeUrl('num')!=99999)
 {
?>
<strong>    
    <h2 style ='text-transform:none;padding-left:1%'><?php str_replace('é','&eacute;' , $nomSal); str_replace('è','&egrave;' , $nomSal);echo $nomSal.' ';?>- <?php echo $sal[0]['ville_Candidats']?> <a style="float:right; font-weight: bold;" class="btn btn-md btn-secondary display-4" href="index.php?uc=interventions&amp;action=voirDetailIntervSalarie&amp;num=<?php echo $num;?>">Modifier</a><br/> </h2><h5 style="float:left">
<?php
 if ($sal[0]['vehicule_Candidats']==0)
 {
    echo 'SANS VOITURE';
 }
 else
 {
    echo 'VOITURE';
 }
?>
<?php
 if ($sal[0]['expBBmoins1a_Candidats']==1)
 {
    echo ' Expérience moins de 3 ans';
 }
?>

</h5>

<?php  
 if(lireDonneeUrl('num')!='99999')
 {
?>
<h5 style='margin-left:40%'>E-mail : <?php echo $sal[0]['email_Candidats']?></h5>
<h5 style="float:right">Tel 1 : <?php echo $sal[0]['telPortable_Candidats'].'<br/>Tel 2 : '.$sal[0]['telFixe_Candidats'];?></h5> <?php } else { ?><h2 style='text-align: center'>A POURVOIR <?php echo date('r')?></h5><?php }}?><table style="border: solid black 1px;text-align: center; border-collapse:collapse; width : 100%; max-height: 50%;">
    <tr style="border: solid black 1px; border-collapse:collapse; "><th style="width:2%"></th><th style="border: solid black 1px; border-collapse:collapse;width: 16.333%">LUNDI</th><th style="border: solid black 1px; border-collapse:collapse;width: 16.333%">MARDI</th><th style="border: solid black 1px; border-collapse:collapse;width: 16.333%">MERCREDI</th><th style="border: solid black 1px; border-collapse:collapse;width: 16.333%">JEUDI</th><th style="border: solid black 1px; border-collapse:collapse;width: 16.333%">VENDREDI</th><th style="border: solid black 1px; border-collapse:collapse;width: 16.333%">SAMEDI</th>
        <?php
        
        for($i=5;$i<23;++$i){ // Correspond aux heure affiché sur la première colonne.
        for ($k=0;$k<60; $k+=15)// Correspond aux minute affiché sur la première colonne
        {$b="0"; if ($i<10){$j=$b.$i;} else {$j=$i;} if ($k<10){$c=$b.$k;} else {$c=$k;}
        for ($a=0; $a<7; ++$a){
            /*
            Correspond à la première colonne qui affiche les horraires
            */
            $creneau=false;
            if ($a==0){echo '<tr>';}
            if ($a==0 && $k==0) {echo '<td style="vertical-align:top;" >'.$j.':'.$c.'</td>';}
            if ($a==0 && $k!=0){echo '<td></td>';}
            foreach ($lesCreneaux as $unCreneau){
                if ((int)substr($unCreneau['hDeb_Proposer'],3,2)==15){$minDeb=0.25;}elseif ((int)substr($unCreneau['hDeb_Proposer'],3,2)==30){$minDeb=0.5;} elseif((int)substr($unCreneau['hDeb_Proposer'],3,2)==45){$minDeb=0.75;} else {$minDeb=0;} // On récupere les heure de début et on les format.
                if ((int)substr($unCreneau['hFin_Proposer'],3,2)==15){$minFin=0.25;}elseif ((int)substr($unCreneau['hFin_Proposer'],3,2)==30){$minFin=0.5;} elseif((int)substr($unCreneau['hFin_Proposer'],3,2)==45){$minFin=0.75;} else {$minFin=0;} // On récupere les heure de fin et on les format.
                $diffdate=(4*((int)substr($unCreneau['hFin_Proposer'],0,2))+4*$minFin)-(4*((int)substr($unCreneau['hDeb_Proposer'],0,2))+4*$minDeb); //On fait une soustraction entre l'heure de début et l'heure de fin et on obtient la différence.
                if ($unCreneau['hDeb_Proposer']==$j.':'.$c.':00' && $unCreneau['jour_Proposer']==$jour[$a]){
                    if ($creneau==false){ 
                        $bgcolorM ='#e3fcfc';
                        $bgcolorP ='#ffbfcf';
                        echo '<td ';
                        if ($unCreneau['idADH_TypeADH']=='MAND'){echo ' style="background-color:'.$bgcolorM.';border:1px solid black;';}
                        elseif($unCreneau['idADH_TypeADH']=='PREST'){echo ' style="background-color:'.$bgcolorP.';border:1px dotted black;';}
                        else{echo ' style="background-color: #ddd9da;border:1px dashed black;';}
                        echo 'border-collapse:collapse; font-size: 1.3em"';
                        echo ' rowspan="'.$diffdate.'">';
                        
                    }
                    else
                    {
                        echo'<div style="border:double"></div>';
                    }
                    echo $unCreneau['hDeb_Proposer'].'-'.$unCreneau['hFin_Proposer'].'<br/>'.$unCreneau['modalites_Proposer'].'<br/>';
                    if ($unCreneau['idADH_TypeADH']!='DISP'){echo $unCreneau['idADH_TypeADH'].' ';}?><?php
                    if ($unCreneau['idPresta_Prestations']!='DISP'){echo $unCreneau['idPresta_Prestations'];}?><br/><?php
                    echo $pdoChaudoudoux->obtenirNomFamille($unCreneau['numero_Famille']).'<br/>';
                    if ($unCreneau['frequence_Proposer']>1){echo 'Une semaine sur '.$unCreneau['frequence_Proposer'].'<br/>';}
                    if ($unCreneau['idADH_TypeADH']=='MAND' && $unCreneau['idPresta_Prestations']=='ENFA'){ echo $unCreneau['numero_Famille'];}
                    elseif ($unCreneau['idADH_TypeADH']=='PREST' && $unCreneau['idPresta_Prestations']=='ENFA'){ echo $pdoChaudoudoux->obtenirPGE($unCreneau['numero_Famille']);}
                    else {echo $pdoChaudoudoux->obtenirPM($unCreneau['numero_Famille']);}
                    $creneau=true;
                    if ($unCreneau['dateFin_Proposer']!='0000-00-00'){
                        echo '<br/>Date de fin : '.$unCreneau['dateFin_Proposer'];}

                    if ($creneau == false){
                        echo '</td>';
                    }
                    
                }
                if ($unCreneau['hDeb_Proposer']<=$j.':'.$c.':00'&&$unCreneau['hFin_Proposer']>$j.':'.$c.':00'&&$unCreneau['jour_Proposer']==$jour[$a])
                {$creneau=true;}
                }
                
               if ($creneau==false && $a!=0)
                {
                    echo '<td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse"></td> ';
                    
                }
                if ($a==7){echo '</tr>';}
            }
            }
        
        }?>
        </table>
<?php if (lireDonneeUrl('num')!=99999){?><div style="float:left; display: flex; flex-direction: column">
               
                
<div>
    <table> <tr> <td>
        <table  style="border: solid black 1px; border-collapse:collapse; text-align: center; min-width: 70%" id="tabHeures" >
            <tr style="border: solid black 1px; border-collapse:collapse;"><th style="border: solid black 1px; border-collapse:collapse;">M</th><th style="border: solid black 1px; border-collapse:collapse;">PM</th><th style="border: solid black 1px; border-collapse:collapse;">PGE</th><th style="border: solid black 1px; border-collapse:collapse;">Prestation/Adhésion</th><th style="border: solid black 1px; border-collapse:collapse;">Famille</th><th style="border: solid black 1px; border-collapse:collapse;">Nombre d'heures</th><th style="border: solid black 1px; border-collapse:collapse;">Adresse</th><th style="border: solid black 1px; border-collapse:collapse;">Distance intervenant</th><th style="border: solid black 1px; border-collapse:collapse;">Distance Chaudoudoux</th><th style="border: solid black 1px; border-collapse:collapse;">Tel</th><th style="border: solid black 1px; border-collapse:collapse;">Tel Domicile</th><th style="border: solid black 1px; border-collapse:collapse; display: none">Adresse Candidats</th>
            </tr>
            <?php $totH=0;
            foreach ($lesFam as $uneFam)
            {
                if ($uneFam['numero_Famille']!='9999'){
                $fam=$pdoChaudoudoux->obtenirNomFamille($uneFam['numero_Famille']);
                $lesPrestM=$pdoChaudoudoux->obtenirTimeDiffPrestM($num, $uneFam['numero_Famille']);
                $lesPrestGE=$pdoChaudoudoux->obtenirTimeDiffPrestGE($num, $uneFam['numero_Famille']);
                $lesMand=$pdoChaudoudoux->obtenirTimeDiffMand($num, $uneFam['numero_Famille']);
                $tot=0;
                $totPrest=0;
                if ($uneFam['idADH_TypeADH']=='PREST' && $uneFam['idPresta_Prestations']=='MENA'){
                foreach ($lesPrestM as $unPrestM){
                    $freq=$unPrestM['frequence_Proposer'];
                $hPrest= (int)substr($unPrestM['nb_heures'], 0,2);
                $minPrest= (int)substr($unPrestM['nb_heures'],3,2);
                if ($minPrest==30){$minPrest=0.5;} elseif($minPrest==15){$minPrest=0.25;}elseif($minPrest==45){$minPrest=0.75;}else{$minPrest=0;}
                $totPrest+=(($hPrest+$minPrest)/$freq);
                
                }}if ($uneFam['idADH_TypeADH']=='PREST' && $uneFam['idPresta_Prestations']=='ENFA'){
                foreach ($lesPrestGE as $unPrestGE){
                $freq=$unPrestGE['frequence_Proposer'];
                $hPrest= (int)substr($unPrestGE['nb_heures'], 0,2);
                $minPrest= (int)substr($unPrestGE['nb_heures'],3,2);
                if ($minPrest==30){$minPrest=0.5;} elseif($minPrest==15){$minPrest=0.25;}elseif($minPrest==45){$minPrest=0.75;}else{$minPrest=0;}
                $totPrest+=(($hPrest+$minPrest)/$freq);
                
                }}
                if ($uneFam['idADH_TypeADH']=='MAND'){
                foreach ($lesMand as $unMand){
                $freq=$unMand['frequence_Proposer'];
                $hMand= (int)substr($unMand['nb_heures'], 0,2);
                $minMand= (int)substr($unMand['nb_heures'],3,2);
                if ($minMand==30){$minMand=0.5;} elseif($minMand==15){$minMand=0.25;}elseif($minMand==45){$minMand=0.75;}else{$minMand=0;}
                $tot+=(($hMand+$minMand)/$freq);
                
                }}
                $adresseFam= $uneFam['adresse_Famille'];
                $cpFam = $uneFam['cp_Famille'];
                $villeFam = $uneFam['ville_Famille'];
                $adresseCan = $sal[0]['adresse_Candidats'];
                $cpCan = $sal[0]['cp_Candidats'];
                $villeCan = $sal[0]['ville_Candidats'];
                $tel=$pdoChaudoudoux->obtenirTelMaman($uneFam['numero_Famille']);
                $telDom=$uneFam['telDom_Famille'];
                echo '<tr style="border: solid black 1px; border-collapse:collapse;"><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse">'.$uneFam['numero_Famille'].'</td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse">'.$uneFam['PM_Famille'].'</td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse">'.$uneFam['PGE_Famille'].'</td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse">'.$uneFam['idADH_TypeADH'].' '.$uneFam['idPresta_Prestations'].'<td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse">'.$fam.'</td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse">'; if ($uneFam['idADH_TypeADH']=='PREST') {echo $totPrest;} elseif ($uneFam['idADH_TypeADH']=='MAND'){echo $tot.'H';} echo '</td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse">'.$adresseFam.' '.$cpFam.' '.$villeFam .'</td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse"><img style="max-width:30px;" src="./styles/img/loading.gif"></img></td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse"><img style="max-width:30px;" src="./styles/img/loading.gif"></img></td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse">'.$tel.'</td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse">'.$telDom.'</td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse ; display: none">'.$adresseCan.' '.$cpCan.' '.$villeCan .'</td></tr>';
                if (isset($totPrest)) {$totH+=$totPrest;}}
}?>
            <tr style="border: solid black 1px; border-collapse:collapse;"><td><td></td><td></td><td></td><td></td><td><strong><?php echo 'Total prestataire : '.$totH;?></strong></td></tr>
        </table></strong>   
        </td> <td>
            <table style="border: solid black 1px; border-collapse:collapse; text-align: center; min-width: 70%" id="tabHeures"> 
            <tr style="border: solid black 1px; border-collapse:collapse;"><th style="border: solid black 1px; border-collapse:collapse;">eMail (mère en priorité) </th> </tr>
            <?php
                foreach ($lesFam as $uneFam)
                {
                    if ($uneFam['numero_Famille']!='9999'){
                        $mailmere=$pdoChaudoudoux->obtenirMailMaman($uneFam['numero_Famille']);
                        $mailpere=$pdoChaudoudoux->obtenirMailPapa($uneFam['numero_Famille']); ?>
                        <tr style="border: solid black 1px; border-collapse:collapse;"> <?php
                            if ((is_null($mailpere) == TRUE || $mailpere == "") && (is_null($mailmere) == TRUE || $mailmere == "")){
                                ?> <td bgcolor="#EA8282"> <br> <?php
                            /*} else if ((is_null($mailpere) == TRUE || $mailpere == "") || (is_null($mailmere) == TRUE || $mailmere == "")) {
                                ?> <td> <?php
                                $mail = $mailmere." ".$mailpere;
                                echo $mail;*/
                            } else {
                                ?> <td> <?php
                                if (is_null($mailmere) == TRUE || $mailmere == "") {
                                    echo $mailpere;
                                } else {
                                    echo $mailmere;
                                }
                            }
                            
                        ?> </td> </tr>
                        <?php
                    }
                }?>
            <tr> <td> <br> </td> </tr>
            </table>
        </td> </tr> </table>
        </div>
<?php }?><br/>
<?php if (lireDonneeUrl('action')=='resAdvSearchI')// resAdvSearchI
    { ?> 
        <form action="planning.php?action=resAdvSearchI&amp;num=<?php echo $num;?>" method="post">
    <?php } else { ?>
        <form action="planning.php?num=<?php echo $num;?>" method="post">
    <?php } ?>
                     
    <label class="container" for="rechCompl" style="font-size:1.2em">RECHERCHE COMPLEMENT
    <input type="checkbox" value="1" name="rechCompl" id="rechCompl" <?php if($pdoChaudoudoux->obtenirRechCompl($num)==1) {echo 'checked';}?>/><br>
    <span class="checkmark"></span>
    </label>

    <label class="container" for='chkArchive' style='font-size:1.2em'>INTERVENANT ARCHIVE
    <input type='checkbox' name='chkArchive' id='chkArchive' value='1' <?php if($pdoChaudoudoux->obtenirArchive($num)==1){echo 'checked';}?>/>
    <span class="checkmark"></span>
    </label>
    <table style="border: solid black 1px; border-collapse:collapse; text-align: center; min-width: 70%" id="tabHeures">
    <tr style="border: solid black 1px; border-collapse:collapse;"> <th style="border: solid black 1px; border-collapse:collapse;"> Disponibilités </th> <th style="border: solid black 1px; border-collapse:collapse;"> Observations </th> </tr>
    <tr style="border: solid black 1px; border-collapse:collapse;"> <th style="border: solid black 1px; border-collapse:collapse;">

    <?php
    //Nombre de caractère de disponibilités
    $nbCarDispos = strlen($pdoChaudoudoux->obtenirDispo($num));
    //On compte le nombre de lignes à laisser dans l'affichage
    //Le 70 correspond au nombre "cols" du champs textearea, il s'agit du nb de caractères par ligne
    $nbRowsDispos = round(($nbCarDispos / 70),0)+3;

    //Si le nb de lignes est trop bas, on le met à 5 minimum
    if ($nbRowsDispos<5){
        $nbRowsDispos = 5;
    }
    ?>

    <textarea name="dispo" cols="70" rows="<?php echo $nbRowsDispos ?>"><?php echo $pdoChaudoudoux->obtenirDispo($num);?></textarea><br>
    </th> <th style="border: solid black 1px; border-collapse:collapse;">
    
    <?php 
    //Nombre de caractère d'observation 
    $nbCarObserv = strlen($pdoChaudoudoux->obtenirObserv($num));
    //On compte le nombre de lignes à laisser dans l'affichage
    //Le 70 correspond au nombre "cols" du champs textearea, il s'agit du nb de caractères par ligne
    $nbRowsObserv = round(($nbCarObserv / 70),0)+3;

    //Si le nb de lignes est trop bas, on le met à 5 minimum
    if($nbRowsObserv<5){
        $nbRowsObserv = 5;
    }
    ?>

    <textarea name="observ" cols="70" rows="<?php echo $nbRowsObserv ?>"><?php echo $pdoChaudoudoux->obtenirObserv($num);?></textarea>
    </th> </tr> </table>
    <input style ="background-color:#FFFFBB; width:1059px;" type ="submit" value="Enregistrer" />
    <br> <br> <br> <br> <br> <br>
</form>


<!--- BOUTONS --->
<div class="divCenter">

    <!--- BOUTON PRECEDENT / SUIVANT CLASSIQUE --->
    <?php if(lireDonneeUrl('action')!='resAdvSearchI'){?>

        <a href="planning.php?num=<?php echo $pdoChaudoudoux->trouverPrecedent($sal[0]['nom_Candidats'])?>" style="font-weight: bold;left:30%;width:210px" class="btn btn-md btn-secondary display-4 stickyBtn">Précédent</a>

        <a style="font-weight: bold;left:57.5%;width:210px" href="planning.php?num=<?php echo $pdoChaudoudoux->trouverProchain($sal[0]['nom_Candidats'])?>" class="btn btn-md btn-secondary display-4 stickyBtn">Suivant</a>

    <?php } ?>


     <!--- BOUTON PRECEDENT / SUIVANT DE LA RECHERCHE AVANCEE--->

     
     <?php $stack = $_SESSION['stack'];

     foreach($stack as $key => $numSalarie)
     {
         if ($numSalarie == $num) {
            $indexSalarie = $key;
         }
     }
        ?>

    <?php if (lireDonneeUrl('action')=='resAdvSearchI')// resAdvSearchI
    {?>

        <?php if ($indexSalarie > 0) {?>

        <a href="planning.php?action=resAdvSearchI&amp;num=<?php echo $stack[$indexSalarie-1]?>" style="font-weight: bold;left:30%;width:210px" class="btn btn-md btn-secondary display-4 stickyBtn">Précédent</a>
            <?php } ?>

            <?php if ($indexSalarie < count($stack)-1) {?>
        <a href="planning.php?action=resAdvSearchI&amp;num=<?php echo $stack[$indexSalarie+1]?>" style="font-weight: bold;left:57.5%;width:210px" class="btn btn-md btn-secondary display-4 stickyBtn">Suivant</a>
        <?php } ?>
    <?php }?>

    <script>
    public function goBack() {
    window.history.back();
    }
    </script>

    <?php 
        $_SESSION['numeroElementListeSearch']++;
    ?> 

    <!--- BOUTON RETOUR--->
    
    <input type="button" class="btn retour stickyBtn" style="left:45%;width:175px" value="RETOUR" onclick="self.close()">


</div>
</body>
</html>
