<?php error_reporting(0);
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $etudiant array
 */
?>
 
  <div id="contenu">

          <div id="btns" style="display: flex; flex-direction: row; width:100%"><?php
 if($issalarie==false) { 
 $dateNaiss = new DateTime($dateNaiss);?>
      <p>
        <a class="btn btn-md btn-secondary display-4" style="float:right" href="index.php?uc=annuCandid&amp;action=demanderModifCandid&amp;num=<?php echo $num; ?>">Modifier</a>
      
        &nbsp;<a class="btn btn-md btn-secondary display-4" style="float:right" href="index.php?uc=annuCandid&amp;action=decisionCandid&amp;num=<?php echo $num; ?>">Accepter/Refuser</a></p>
 <?php } if ($issalarie!=false) {
 ?>
<!-- Division pour le contenu principal -->
            <a class="btn btn-md btn-secondary display-4" style="float:right;" href="index.php?uc=annuSalarie&amp;action=voirDetailSalarie&amp;num=<?php echo $pdoChaudoudoux->trouverPrecedent($nom); ?>">Précédent</a>
            <a class="btn btn-md btn-secondary display-4" href="planning.php?num=<?php echo $num;?>" target="_blank"> Voir le planning </a><br/><br/>
            <a class="btn btn-md btn-secondary display-4" href="index.php?uc=interventions&amp;action=voirDetailIntervSalarie&amp;num=<?php echo $num;?>">Voir le détail des prestations de ce salarié</a>
                

            <a class="btn btn-md btn-secondary display-4"  href="index.php?uc=annuSalarie&amp;action=demanderModifSalarie&amp;num=<?php echo $num; ?>">Modifier</a>
            <a style="float:right" class="btn btn-md btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=voirFamillesBesoins&amp;num=<?php echo $num;?>">Matching Familles</a>
            
           <!--- Le bouton SUPPRIMER est opérationnel mais pas affiché pour des raisons de sécurité car seul admin devrait pouvoir l'utiliser --->
           <!--- <a class="btn btn-md btn-danger display-4"  href="index.php?uc=annuSalarie&amp;action=demanderSupprimerSalarie&amp;num=<?php /* echo $num; */ ?>">SUPPRIMER</a> --->

            <a class="btn btn-md btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=ficheMail&amp;type=salarie&amp;num=<?php echo $num; ?>">Fiche Mail</a>
			<a style="float:left" class="btn btn-md btn-secondary display-4" href="index.php?uc=annuFamille&amp;action=voirEmailPrefabI&amp;num=<?php echo $num; ?>">Mail présentation <br/> famille</a>
            <a class="btn btn-md btn-secondary display-4" style="float:right" href="index.php?uc=annuSalarie&amp;action=voirDetailSalarie&amp;num=<?php echo $pdoChaudoudoux->trouverProchain($nom);?>">Suivant</a>
         <?php }?> 
</div> <?php /*
 <!--         <tr>
              <td class="libelle">Prestation(s) :</td>
              <td><?php /*foreach ($prestations as $presta) {
				  //print_r($presta);
				  echo $presta['type_Prestations']."<br/>";
			  }</td>
 
 </tr>-->             */?>
      
      <div class="container-fluid" id="content10-a" style="color:white;margin:0.5%;padding:1%; background-color:#333333"> <!--Vincent-->

        <div class="row"> 

          <div style="text-align:center;" class="col-5 border-primary">
                
          <br><h1 style="text-decoration:underline white;">Fiche de <?php echo filtreChainePourNavig($titre)." ".filtreChainePourNavig(strtoupper($nom)).""; if (isset($nomJF)&& $nomJF!=""){echo ' née '.$nomJF;} ?>&nbsp;<?php echo filtreChainePourNavig($prenom) ; ?></h1>

              <?php if ($issalarie==true) 
            {?>
            <h4> Numéro salarié : <?php echo $idSalarie; ?> </h4>
            <h6> <br/> ARCHIVÉ : <?php if($archive==1){echo 'OUI';}else {echo 'NON';}?> <br><br> FICHE INTERVENANT MODIFIÉ LE : <?php echo $dateModif;?>  <?php if ($arret==1) echo 'En arrêt de travail jusqu\'au '.dateToString($dateFinArret) ?> </h6> <?php
            }?>

          </div>
          <div style=" border-left: 4px solid white; display: inline-block; height: auto; margin: 0 20px;"> </div>
         
          <div style="text-align:center;" class="col">

          <br> <h2 style="text-decoration:underline white; text-align:center;"> Inscription à une formation </h2>

            <?php if ($issalarie==true)
            {?>
              <form style="text-align:center;" id="frmAttForm" method="post" action="index.php?uc=annuSalarie&amp;action=validForm">

              <label for="numForm" style="font-size: 1.2em"> <br> <h2> TYPE: </h2> </label> <br>
                <select onclick='afficher()' onchange='resetChamp()' id="numForm" name="numForm">
                <option value="PRESTATAIRE"> Prestataire </option>
                <option value="MANDATAIRE" selected> Mandataire </option>
                </select>

              <!-- à retravailler-->

              <script>
                function afficher() {
                valeur = document.getElementById('numForm').value;

                if (valeur == 'PRESTATAIRE') 
                {
                  document.getElementById('menuListeFamille').hidden = true;
                }
                else {
                  document.getElementById('menuListeFamille').hidden = false;
                }
                }
                function resetChamp() {
                  document.getElementById("familleForm").value = "";
                }
                
                </script>

                <div id='menuListeFamille'> 
                <?php for($k=0;$k<1/*4*/;++$k)
                {?>
                      <br> <label for="famille"><strong>Choix de la famille</strong></label><br>
                          <input id="familleForm" name="familleForm" list="famille<?php echo $k;?>">
                      <datalist id="famille<?php echo $k;?>">
                          <option value="" selected>Famille</option>
                        <?php $lesFamilles=$pdoChaudoudoux->obtenirNomsFamille(); 
                        foreach ($lesFamilles as $uneFam)
                        {
                          $numFam=$uneFam['numero_Famille'];
                          $nomFam=$pdoChaudoudoux->obtenirNomFamille($numFam);
                          echo '<option value="'.$numFam.'">';  echo $nomFam; if($numFam!=9999){echo ' '.$numFam.' ';} echo '</option>';
                        } ?>
                      </datalist>
   
                  <?php
                }?>

                </div>  

                <br> <label for="numForm" style="font-size: 1.2em"> <br> <h2> NOM DE LA FORMATION </h2> </label> <br>
                <select id="numForm" name="numForm" style="width: 200px">
            <?php foreach ($lesFormations as $uneFormation)
                {
                  $numForm=$uneFormation['idForm_Formations'];
                  $nomForm=$uneFormation['intitule_Formations'];
              ?> <option value="<?php echo $numForm;?>"><?php echo $nomForm;?></option>
          <?php }?>
                </select>
            
              <input type="hidden" id="numSal" name="numSal" value="<?php echo $num;?>"/> <br>
                
              <!--- BOUTON D'ENVOIE DES DONNEES--->
              <input style="margin:1%;color:rgb(70,164,4);font-weight: bold;" type="submit" value="VALIDER">
            </form>

        
                <?php  
            } 
            else {echo "</ul>";?><tr>
                Date d'entretien :
                <?php if (isset ($dateEnt)){echo dateToString($dateEnt);}} ?> 
          </div>

          
          <!-- DEBUT -->
          <?php if ($issalarie==true)
            {?>
          <div style=" border-left: 4px solid white; display: inline-block; height: auto; margin: 0 100px;"> </div>
          
            <div style="text-align:center;" class="col">

            <label class="container1" for="entretiens" >AFFICHER LES ENTRETIENS 
                <input type="checkbox" name="entretiens" id="entretiens" value="1" onclick="afficher()">
                <span class="checkmark1"></span>
          </label> <br>
          <div id="menuEntretiens">
            <h2 style="text-decoration:underline white; text-align:center;"> <br> AJOUTER UN ENTRETIEN</h2>
            <form style="text-align:center;" id="ajoutEntretien" method="post" action="index.php?uc=annuSalarie&amp;action=ajoutEntretien">
              <label class="container1" for="EProf" >PROFESSIONNEL <span style="color:#FF0000;"> Obligatoire </span>
                <input type="radio" name="typeEntretien" id="EProf" value="1">
                <span class="checkmark1"></span>
              </label> <br>

              <label class="container1" for="EIndi">INDIVIDUEL
                <input type="radio" name="typeEntretien" id="EIndi" value="0">
                  <span class="checkmark1"></span>
              </label> <br>

              <strong> Date de l'entretien </strong> <br>
              <input type="date" id="date" name="dateEntretien">
              <input type="hidden" id="numSal" name="numSal" value="<?php echo $num;?>"/><br>
              <input style="margin:1%;color:rgb(70,164,4);font-weight: bold;" type="submit" value="AJOUTER">
            </form>
            <br>
            <form style="text-align:center;" id="ajoutCommentaire" method="post" action="index.php?uc=annuSalarie&amp;action=ajoutCommentaire">
              <input type="hidden" id="numSal" name="numSal" value="<?php echo $num;?>"/>
              <h2 style="text-decoration:underline white; text-align:center;"> <br> LISTE DES ENTRETIENS</h2>
              <select id="listEntretien" name="listEntretien" onchange="afficherCom()">
              <?php
                foreach($lesEntretiens as $unEntretiens) { 
                  $dateEntretien = new DateTime($unEntretiens["date"]);
                  if ($unEntretiens["pro"] == 1){
                    ?> <option style="color:#FF0000" value="<?php echo $unEntretiens["num"]."-".$unEntretiens["commentaire"] ?>"><?php
                  
                  } else {
                    ?> <option value="<?php echo $unEntretiens["num"]."-".$unEntretiens["commentaire"] ?>"><?php
                  } 
                  echo $unEntretiens["num"].") ". $dateEntretien->format('d/m/Y');
                  
                    ?>
                  </option>
                <?php }  ?>
              </select> <br>
              <strong> Commentaire </strong> <br>
              <textarea name="com" id="com" cols="40" style="height:180px;width:260px" ></textarea>
              <input style="margin:1%;color:rgb(70,164,4);font-weight: bold;" type="submit" value="ENREGISTRER LE COMMENTAIRE">
            </form> 
            
            
            <!-- FIN -->
            <br>
            
           

            

            <form style="text-align:center;" id="supEntretien" method="post" action="index.php?uc=annuSalarie&amp;action=supEntretien">
              <input type="hidden" id="numSal" name="numSal" value="<?php echo $num;?>">
              <input style="margin:1%;color:rgb(164,4,4);font-weight: bold;" type="submit" value="SUPPRIMER LE DERNIER Entretien">
            </form>
          </div>
          <?php  
            } ?>

            <script>
              function afficherCom() {
                var table = document.getElementById('listEntretien').value.split("-");
                if (table[1] != undefined){
                  document.getElementById('com').value = table[1];
                }
                
              }
              var table = document.getElementById('listEntretien').value.split("-");
              if (table[1] != undefined){
                document.getElementById('com').value = table[1];
              }
              afficher();
              function afficher() {
                valeur = document.getElementById("entretiens").checked;

                if (valeur == true) {
                  document.getElementById("menuEntretiens").hidden = false;
                } else {
                  document.getElementById("menuEntretiens").hidden = true;
                }
              }
            </script>






              <!--- A FAIRE PLUS TARD (Simon) --->
              <?php /* 

              <br> <h2 style="text-decoration:underline white; text-align:center;"> DATES D'ENTRETIEN </h2>

              <p> L'entretien suivant est fixé 2 ans après le dernier entretien : </p>

              <form style="text-align:center;" id="frmEntretien" method="post" action="index.php?uc=annuSalarie&amp;action=validEntretien">

                <p>
                <label for="premierEntretien">Date du premier entretien :  </label>
                <input type="date" id="premierEntretien" class="form-control input-sm" name="premierEntretien" />
                </p>

                <input type="hidden" id="numSal" name="numSal" value="<?php echo $num;?>"/> <br>

                <div class="form-example">
                <input style="margin:1%;color:rgb(70,164,4);font-weight:bold;" type="submit" value="MODIFIER">
                </div>

              </form>

              <!--- La date du prochain entretien est fixée automatiquement à 2 ans plus tard par rapport au premier entretien --->
                <p>
                <label for="twoYearEntretien">Date du prochain entretien (2 ans):  </label>
                <label type="date" id="twoYearEntretien" class="form-control input-sm" name="twoYearEntretien" <?php echo 'value="'.$datePremierEntretien.'"'; ?> />
                </p>

              <!--- La date du prochain bilan est fixée automatiquement tous les 6 ans --->
                <p>
                <label for="sixYearEntretien">Date du prochain entretien (Bilan 6 ans) :  </label>
                <label type="date" id="sixYearEntretien" class="form-control input-sm" name="sixYearEntretien" <?php echo 'value="'.$datePremierEntretien.'"'; ?> />
                </p>
              */ ?>
            </div>

          </div>

           

          
         
      </div>

                              
                              
<?php if ($issalarie==true){           ?>
                                          
 <div style="display: flex; flex-direction: row;">  <div style="display: flex; flex-direction: column;">  <h5 style="font-size: 1.5em">Informations salarié</h5>
    <table class="tabNonQuadrille" style="width:90%">
     <tr>
        <td class="libelle">Date d'entrée :</td>
        <td><?php   echo $dateEntree->format('d/m/Y');?></td>
      </tr>
                          <tr>
                              <td class="libelle">Date de sortie :</td>
                              <td><?php  if($dateSortie!=0000-00-00 && isset($dateSortie))echo dateToString($dateSortie); ?></td>
                          </tr>
                          <tr>
                              <td class="libelle">Taux horaire :</td>
                              <td><?php echo filtreChainePourNavig($tauxH); ?></td>
                          </tr>
                          <tr>
                              <td class="libelle">Nombre d'heures par semaine :</td>
                              <td><?php echo filtreChainePourNavig($nbHeureSem); ?></td>
                          </tr>
                          <tr>
                              <td class="libelle">Nombre d'heures par mois :</td>
                              <td><?php echo filtreChainePourNavig($nbHeureMois); ?></td>
                          </tr>
                          <tr>
                            <td class="libelle">Recherche complément d'heures :</td>
                            <td><?php if($rechCompl == 1){
                              echo "Oui";
                              } else {
                                echo "Non";
                                } ?></td>
                          </tr>
                          <tr>
                            <td class="libelle">PSC1 à proposer :</td>
                            <td><?php if($psc1 == 1){
                              echo "Oui";
                              } else {
                                echo "Non";
                                } ?></td>
                          </tr>
                                      <tr>
                            <td class="libelle">Suivi :</td>
                            <td><?php echo $suivi; ?>
                            </td>
                          </tr>
                        </table>
                        <p>
                          <!--<a class="retour btn btn-md btn-secondary display-4" style="position:fixed;bottom:0px;right:0px" href="index.php?uc=annuCandid&amp;action=voirTousCandid">Retour</a>-->
                          <button style="position:fixed;bottom:0px;right:0px" class="retour btn" onclick="history.go(-1);">RETOUR</button>
                        </p>
                        
                    </div>
                    
                      
                      
                      <?php  } else {?><div style="display: flex; flex-direction: row;">    <?php }?>
<div style="display:flex;flex-direction: column;"><h5 style="font-size: 1.5em">Informations personnelles</h5>
       <table class="tabNonQuadrille"style="width:90%">
           
           <tr>
                <td class="libelle">Date de naissance :</td>
                <td><?php echo filtreChainePourNavig($dateNaiss->format('d/m/Y')); ?></td>
            </tr>
            <tr>
                <td class="libelle">Lieu de naissance :</td>
                <td><?php echo filtreChainePourNavig($lieuNaiss)." (".filtreChainePourNavig($paysNaiss).")"; ?></td>
            </tr>
            <tr>
                <td class="libelle">Nationalité :</td>
                <td><?php echo filtreChainePourNavig($natio); ?></td>
            </tr>
             <tr>
              <td class="libelle">Numéro de titre de séjour :</td>
              <td><?php echo filtreChainePourNavig($numTS) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">Date d'expiration du titre de séjour :</td>
              <td> <?php if($dateTS!=0000-00-00 && isset($dateTS)) echo dateToString($dateTS); ?></td>
            </tr>
            <tr>
              <td class="libelle">Numéro de Sécurité Sociale :</td>
              <td><?php echo filtreChainePourNavig($numSS) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">Mutuelle :</td>
              <td><?php echo filtreChainePourNavig($mutuelle)?></td>
            </tr>
            <tr>
              <td class="libelle">CMU :</td>
              <td><?php if ($cmu==0){echo"Non" ;} else {echo "Oui";}?></td>
            </tr>
            <tr>
              <td class="libelle">Situation familiale :</td>
              <td><?php echo filtreChainePourNavig($sitFam);?>
              </td>
            </tr>
            <tr>
              <td class="libelle">Adresse :</td>
              <td><?php echo filtreChainePourNavig($adresse) ; ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><?php echo filtreChainePourNavig($cp); ?>&nbsp;<?php echo filtreChainePourNavig($ville) ; ?></td><br/>
            </tr>
            <tr><td>&nbsp;</td><td><?php echo filtreChainePourNavig($quartier);?></tr>
            <tr>
              <td class="libelle">Tél. :</td>
              <td>Portable : <?php echo filtreChainePourNavig($telPort) ; ?><br>Fixe : <?php echo filtreChainePourNavig($telFixe);?><br>Urgences : <?php echo filtreChainePourNavig($telUrg);?></td>
            </tr>
            <tr>
              <td class="libelle">Email :</td>     
              <td><a href="mailto:<?php echo filtreChainePourNavig($email) ;?>"><?php echo filtreChainePourNavig($email) ; ?></a></td>
            </tr>
       </table></div>
               <br/><div style="display:flex;flex-direction: column;">
           <h5 style="font-size: 1.5em">Informations professionnelles</h5>
           <table class="tabNonQuadrille" style="width:90%">
            
            <tr>
              <td class="libelle">Statut professionnel :</td>
              <td><?php echo strtoupper($statutPro) ?></td>
            </tr>
            <tr>
              <td class="libelle">Statut handicapé :</td>
              <td><?php if ($statutHandicap==0){echo"Non" ;} else {echo "Oui";} ?></td>
            </tr>
            <tr>
              <td class="libelle">Diplômes :</td>
              <td><?php echo filtreChainePourNavig($diplomes) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">Qualifications :</td>
              <td><?php echo filtreChainePourNavig($qualifs) ; ?></td>
            </tr>
            </tr>
              <td class="libelle">Enfants/Ménage/Tout:</td>
              <td><?php echo filtreChainePourNavig($trav) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">Expérience avec les enfants de moins de trois ans :</td>
              <td><?php if($expBBmoins1a == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?></td>
            </tr>
            <tr>
              <td class="libelle">Enfants handicapés ?</td>
              <td><?php if($enfantHand == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?></td>
            </tr>
            <tr>
                <td class="libelle">Disponibilités :</td>
                <td><?php echo filtreChainePourNavig($dispo); ?></td>
            </tr>
            <tr>
                <td class="libelle">Observations :</td>
                <td><?php echo filtreChainePourNavig($observ); ?></td>
            </tr>
             
          
           <tr>
              <td class="libelle">Permis :</td>
              <td><?php if($permis == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?></td>
            </tr>
            <tr>
              <td class="libelle">Véhicule :</td>
              <td><?php if($vehicule == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?></td>
            </tr>
           </table>
           <h5 style="font-size: 1.5em">Formations suivies : </h5>
            <table class="tabNonQuadrille" style="width:90%">
               <?php if ($issalarie==true){ ?> <?php if (isset($lesF)) {foreach ($lesF as $unF)
                                  {
                                      $nomForm=$unF['intitule_Formations'];
                                      $typeForm=$unF['type_Formations'];
                                      $nomFamille=$unF['numFamille'];
                                      $numeroDeLaFormation = $unF['idForm_Formations'];
                                      $affichageFamille = $pdoChaudoudoux->obtenirNomFamille($nomFamille);

                                      if  ($affichageFamille == 'MAISON DES CHAUDOUDO') {
                                        $affichageFamille = 'LA MAISON DES CHAUDOUDOUX';
                                      }

                                      echo '<tr><td class="libelle">  &bull;  '.$nomForm.' <span style="font-weight:normal;">('.$typeForm.')</span> - <span style="text-decoration: underline; color:#008000;">'.$affichageFamille.'</span></td> <td style="width:5%"> <a href="index.php?uc=annuSalarie&amp;action=demanderSupprimerFormation&amp;num='.$num.'&amp;numForm='.$numeroDeLaFormation.'" style="font-weight:bold; color:red;"> X </a> </td></tr>';
                                      }}}?></table></div>

                                      
          <?php /*  $nb_fichier = 0;
                echo '<ul>';
          if ($dossier = opendir('Documents/Candidats_intervenants/'.$nom.' '.$prenom.' '.$telPort))
          {
              
            while(false !== ($fichier = readdir($dossier)))
            {
                if( $fichier != '..' && $fichier != '.' && $fichier != 'index.php')
                {
                    $nb_fichier++; // On incrémente le compteur de 1
                    echo '<li><a href="Documents/Candidats_intervenants/'.$nom.' '.$prenom.' '.$telPort.'/'.$fichier.'">'.$fichier.'</a></li>';
                }// On ferme le if (qui permet de ne pas afficher index.php, etc.)
 
            } // On termine la boucle
              echo '</ul><br />';
        echo 'Il y a <strong>' . $nb_fichier .'</strong> fichier(s) dans le dossier';
 
        closedir($dossier);
         }
      
 

 
        else {
        echo 'Le dossier n\' a pas pu être ouvert';}

*/

  $adresse= str_replace(' ', '%20', $adresse)."%20".$cp.'%20'.str_replace(' ', '%20', $ville)   
           ?>   <iframe frameborder="0" style="border:0; width: 30%;" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0Dx_boXQiwvdz8sJHoYeZNVTdoWONYkU&amp;q=<?php echo $adresse;?>" allowfullscreen=""></iframe>
            </div>
            </div>
          <fieldset style="display: flex; flex-direction: column; width: 50%; margin-left:0%;">
          <legend><strong>DISPONIBILITES POUR LE MENAGE: </legend></p>
                    
                    <style>
                      
                      table,th,td,tr{
                        border: 1px solid black;
                        text-align:center;
                        
                      }
                      
                    </style>
                      
                      <table style = margin-left:1%;width:75%;>
                        <thead>
                          
                          <th> Activité </th>
                          <th> Jour / Horaires </th>
                          <th> Fréquence de la prestation </th>
                          
                        </thead>
                        
                        <tbody><?php
                        $num=lireDonneeUrl('num');
                        
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
                        
                        foreach ($dispoM as $key => $uneDispoM)
                        {
                          $jourM=$uneDispoM['jour'];
                          
                          $hDebM=$uneDispoM['heureDebut'];
                          $hFinM=$uneDispoM['heureFin'];
                          $frequenceM=$uneDispoM['frequence'];
                          $activite=$uneDispoM['activite'];
                          $id=$uneDispoM['id'];
                          //$numFamille=$uneDispoM['numero'];
                          echo "<tr>";
                          echo "<td> Menage </td>";
                          echo "<td> <strong>".$jourM." - ".$hDebM." à ".$hFinM."<br><br></strong> </td>";
                          echo "<td> Une semaine sur ".$frequenceM."</td>";
                          
                          // pour ajout de numFamille, mettre dans le lien au dessus après le numDemande='.$id.'&amp
                          echo '</tr>';
                          
                          
                          
                        }
                        echo "</tbody>";
                        ?>

                        </table> <?php echo str_repeat('<br>',2); ?>
                        <legend><strong>DISPONIBILITES POUR LA GARDE D'ENFANTS: </strong></legend></p>
                        <table style = margin-left:1%;;width:75%;>
                          <thead>
                            
                            <th> Activité </th>
                            <th> Jour / Horaires </th>
                            <th> Fréquence de la prestation </th>
                            
                          </thead>
                          
                          <tbody><?php
 
                          foreach ($dispoGE as $key => $uneDispoGE)

                          {
                            $jourGE=$uneDispoGE['jour'];
                            $hDebGE=$uneDispoGE['heureDebut'];
                            $hFinGE=$uneDispoGE['heureFin'];
                            $frequenceGE=$uneDispoGE['frequence'];
                            $activite=$uneDispoGE['activite'];
                            $id=$uneDispoGE['id'];
                            //$numFamille=$uneDispoGE['numero'];
                            echo "<tr>";
                            echo "<td> Garde d'enfants </td>";
                            echo "<td><strong> ".$jourGE." - ".$hDebGE." à ".$hFinGE."<br><br> </strong></td>";
                            echo "<td> Une semaine sur ".$frequenceGE." </td>";
                            // pour ajout de numFamille, mettre dans le lien au dessus après le numDemande='.$id.'&amp
                            echo '</tr>';
                          } ?>
                </tbody>
                </table>        
                </fieldset>
<?php echo str_repeat('<br>',3); ?>