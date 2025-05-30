<?php
$nbFamilles=$pdoChaudoudoux->obtenirNbFamilles();
$nbIntervenants=$pdoChaudoudoux->obtenirNbIntervenants();
$entree= $pdoChaudoudoux->obtenirNbEntree();
$sorties= $pdoChaudoudoux->obtenirNbSorties();
$lesFamA=$pdoChaudoudoux->obtenirFamillesAArchiver();
$lesInco=$pdoChaudoudoux->trouverIncoherence();
$nbEnfants=$pdoChaudoudoux->countEnfants();
$nbEnfants3=$pdoChaudoudoux->countEnfants3();
$lesIncoInt=$pdoChaudoudoux->trouverIncoherenceInt();?> 
<!-- Division principale -->
<section class="cid-qWb2j0ccdv mbr-fullscreen mbr-parallax-background" id="header2-2d">

    <div class="container align-center">

        <div class="row justify-content-md-center"><?php if ($pdoChaudoudoux->finArretAVenir()){ echo '<h2 style="color:red; ">DES ARRETS DE TRAVAIL SE TERMINENT CE MOIS-CI !</h2>';}?>

            <div style='display :flex; flex-direction: row'>

                <a href="index.php?uc=annuFamille&action=incoherence">
                    <div style='display :flex; flex-direction: column; border: solid red 1px;padding:30px;height:100%'>
                        
                        <p class="mbr-text pb-3 mbr-fonts-style display-5" style="color: black"> <strong>Les familles suivantes sont ARCHIVÉES et sont toujours PRÉSENTES dans les plannings des intervenantes :</strong>
                        <table style="border:solid 1px black; color: black; margin: auto" class="tabQuadrille mbr-text pb-3 mbr-fonts-style display-5">
                            <tr><th style="border:solid 1px black;">Code client</th><th style="border:solid 1px black;">Noms</th><th style="border:solid 1px black;">Intervenant</th></tr>
                            <?php foreach ($lesInco as $uneInco){
                                $numInt=$uneInco['numSalarie_Intervenants'];
                                $numFam=$uneInco['numero_Famille'];
                                $sal=$uneInco['nom_Candidats'];
                                echo '<tr><td style="border:solid 1px black;">'.$numFam.'</td><td style="border:solid 1px black;"><a style="color: black; text-decoration: underline; " href="index.php?uc=annuFamille&action=voirDetailFamille&num='.$numFam.'">'.$pdoChaudoudoux->obtenirNomFamille($numFam).'</a></td><td style="border:solid 1px black;"><a style="color: black; text-decoration: underline; "href="index.php?uc=annuSalarie&action=voirDetailSalarie&num='.$numInt.'">'.$sal.'</a></td></tr>';
                            }?>
                        </table></p></div></a>
                        <a href="index.php?uc=annuFamille&action=familleaarchiver">
                    <div style='display: flex; flex-direction: column;border: solid red 1px; padding: 30px;height:100%'>
                        <p class="mbr-text pb-3 mbr-fonts-style display-5" style="color: black"><strong> Les familles qui ont une date de SORTIE sont : </strong>
                        <table style="border:solid 1px black; color:black; margin-top: 115px" class="tabQuadrille mbr-text pb-3 mbr-fonts-style display-5">
                            <tr><th style="border:solid 1px black;">Code client</th><th style="border:solid 1px black;">Noms</th><th style="border:solid 1px black;">Date de sortie</th><th style="border:solid 1px black;">Date de fin PGE</th><th style="border:solid 1px black;">Date de fin PM</th><th style="border:solid 1px black;">Date de fin Mand</th><th style="border:solid 1px black;">Type d'adhésion</th><th style="border:solid 1px black;">Intervenant</th></tr>
                        
                        
                        
                        <?php foreach ($lesFamA as $uneFamA){
                            $numFam=$uneFamA['numero_Famille'];
                            $dateSortie=dateToString($uneFamA['dateSortie_Famille']);  if ($dateSortie == '00/00/0000' || $dateSortie=="//") $dateSortie="";
                            $idADH="";
                            $sortieMand=dateToString($uneFamA['sortieMand_Famille']); if ($sortieMand == '00/00/0000'|| $sortieMand=="//") $sortieMand="";
                            $sortiePM=dateToString($uneFamA['sortiePM_Famille']);if ($sortiePM == '00/00/0000'||$sortiePM=="//") $sortiePM="";
                            $sortiePGE=dateToString($uneFamA['sortiePGE_Famille']);if ($sortiePGE == '00/00/0000'||$sortiePGE=="//") $sortiePGE="";
                            if ($uneFamA['prestM_Famille']==1 || $uneFamA['prestGE_Famille']==1){$idADH.=' PRESTATAIRE';}
                            if ($uneFamA['mand_Famille']==1){$idADH.=' MANDATAIRE';}
                            echo '<tr><td style="border:solid 1px black;">'.$numFam.'</td><td style="border:solid 1px black;"><a style="color: black; text-decoration: underline; "href="index.php?uc=annuFamille&action=voirDetailFamille&num='.$numFam.'">'.$pdoChaudoudoux->obtenirNomFamille($numFam).'<a/></td><td style="border:solid 1px black;">'.$dateSortie.'</td><td style="border:solid 1px black;">'.$sortiePGE.'</td><td style="border:solid 1px black;">'.$sortiePM.'</td><td style="border:solid 1px black;">'.$sortieMand.'</td><td style="border:solid 1px black;">'.$idADH.'</td><td style="border:solid 1px black;">'; $lesSal=$pdoChaudoudoux->obtenirSalariePresent($numFam); foreach ($lesSal as $unSal){echo '<a style="color: black; text-decoration: underline; "href="index.php?uc=annuSalarie&action=voirDetailSalarie&num='.$unSal['numSalarie_Intervenants'].'">'.$unSal['nom_Candidats'];} echo '<a/></td></tr>';
                        }?>
                        </table></p>

                        </div></a>

                        <a href="index.php?uc=annuSalarie&action=IncoherenceInt">
                        <div style='display :flex; flex-direction: column; border: solid red 1px;padding:30px;height:100%'>
                        <p class="mbr-text pb-3 mbr-fonts-style display-5" style="color: black"> 
                        <strong>Les intervenants suivants sont ARCHIVÉS et sont toujours PRÉSENTS dans les plannings des familles :</strong>
                        <table style="border:solid 1px black; color: black;" class="tabQuadrille mbr-text pb-3 mbr-fonts-style display-5">
                        <tr><th style="border:solid 1px black;">Code client</th><th style="border:solid 1px black;">Noms</th><th style="border:solid 1px black;">Famille</th></tr>
                        <?php foreach ($lesIncoInt as $uneIncoInt){
                            if($uneIncoInt['numero_Famille']!='9999'){  //On ne prend pas en compte la famille "PAS DISPONIBLE"
                                $numInt=$uneIncoInt['numSalarie_Intervenants'];
                                $Int=$uneIncoInt['nom_Candidats'];
                                $numFam=$uneIncoInt['numero_Famille'];
                                echo '<tr><td style="border:solid 1px black;">'.$numInt.'</td><td style="border:solid 1px black";><a style="color: black; text-decoration: underline; "href="index.php?uc=annuSalarie&action=voirDetailSalarie&num='.$numInt.'">'.$Int.'</a></td><td style="border:solid 1px black;"><a style="color: black; text-decoration: underline; "href="index.php?uc=annuFamille&action=voirDetailFamille&num='.$numFam.'">'.$pdoChaudoudoux->obtenirNomFamille($numFam).'</a></td></tr>';
                            }
                        }?>
                        </table></p></div></a></div>


                
                <p class="mbr-text pb-3 mbr-fonts-style display-5" style="color: black">Bienvenue sur l'application de gestion de la maison des chaudoudoux. Nous avons actuellement dans la base
                <em><?php echo $nbFamilles-1; ?></em>
                familles et
                <em><?php echo $nbIntervenants; ?></em>
                Intervenants. Soit
                <?php echo $nbEnfants; ?>
                enfants dont
                <?php echo $nbEnfants3; ?>
                enfants de moins de trois ans.&nbsp;
                Depuis le 1er jour du mois, il y a eu <?php echo $entree;?> entrées et <?php echo $sorties; ?> sorties de familles. </p>



            <div class="mbr-section-btn"><a class="btn btn-md btn-secondary display-4" href="page7.html#toggle1-2e"><span class="mbri-search mbr-iconfont mbr-iconfont-btn"></span>Foire aux questions</a></div>

            
        </div>
    </div>
    
</section>

<section class="engine"><a href="https://mobirise.me/c">free website builder</a></section><section class="toggle1 cid-qWb2VzR3Pk" id="toggle1-2e">

    

    
        <div class="container">
            <div class="media-container-row">
                <div class="col-12 col-md-8">
                    <div class="section-head text-center space30">
                       <h2 class="mbr-section-title pb-5 mbr-fonts-style display-2">FAQ
                        </h2>
                    </div>
                    <div class="clearfix"></div>
                    <div id="bootstrap-toggle" class="toggle-panel accordionStyles tab-content">
                        
                        <div class="card">
                            <div class="card-header" role="tab" id="headingTwo">
                                <a role="button" class="collapsed panel-title text-black" data-toggle="collapse" data-parent="#accordion" data-core="" href="#collapse2_39" aria-expanded="false" aria-controls="collapse2">
                                    <h4 class="mbr-fonts-style display-5">
                                        <span class="sign mbr-iconfont mbri-arrow-down inactive"></span>&nbsp;Ajout de familles, candidats et intervenants</h4>
                                </a>

                            </div>
                            <div id="collapse2_39" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body p-4">
                                    <p class="mbr-fonts-style panel-text display-7">
                                       L'ajout de familles se fait dans l'onglet familles, de même pour les candidats. La création d'un nouveau salarié passe d'abord par la création d'un candidat, puis son acceptation.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree">
                                <a role="button" class="collapsed panel-title text-black" data-toggle="collapse" data-parent="#accordion" data-core="" href="#collapse3_39" aria-expanded="false" aria-controls="collapse3">
                                    <h4 class="mbr-fonts-style display-5">
                                        <span class="sign mbr-iconfont mbri-arrow-down inactive"></span>&nbsp;Comment attribuer un intervenant à une famille ?&nbsp;</h4>
                                </a>
                            </div>
                            <div id="collapse3_39" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body p-4">
                                    <p class="mbr-fonts-style panel-text display-7">Vous trouverez dans l'onglet intervenants un lien pour attribuer un salarié à une famille. Les différentes options vous sont proposées. Attention : En cas d'intervention sur deux jours (ex : 21h - 3h du matin) : Vous devez attribuer deux interventions, une de 21h à 24h, et l'autre de 0h à 3h le lendemain Vous pouvez également visualiser dans l'onglet interventions toutes les interventions, en cours et passées. Vous pouvez les valider lorsque le contrat est terminé ou lorsque la famille et l'intervenant sont d'accord pour que la prestation ait lieu. Il est possible de voir un planning personnalisé et le détail des interventions en cliquant sur un intervenant.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree">
                                <a role="button" class="collapsed panel-title text-black" data-toggle="collapse" data-parent="#accordion" data-core="" href="#collapse4_39" aria-expanded="false" aria-controls="collapse4">
                                    <h4 class="mbr-fonts-style display-5">
                                        <span class="sign mbr-iconfont mbri-arrow-down inactive"></span>&nbsp;Les tarifs ont été modifiés, comment faire ?</h4>
                                </a>
                            </div>
                            <div id="collapse4_39" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body p-4">
                                    <p class="mbr-fonts-style panel-text display-7">
                                       Pour la modification des tarifs et la création de nouveaux utilisateurs, vous devez vous adresser au directeur, qui peut les modifier.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree">
                                <a role="button" class="collapsed panel-title text-black" data-toggle="collapse" data-parent="#accordion" data-core="" href="#collapse5_39" aria-expanded="false" aria-controls="collapse5">
                                    <h4 class="mbr-fonts-style display-5">
                                        <span class="sign mbr-iconfont mbri-arrow-down inactive"></span>&nbsp;Une erreur en anglais s'affiche, que se passe-t-il ?</h4>
                                </a>
                            </div>
                            <div id="collapse5_39" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body p-4">
                                    <p class="mbr-fonts-style panel-text display-7">
                                       Erreur "Duplicate entry for key primary" : Vous avez certainement saisi un identifiant (tel que le numéro M) qui existait déjà, recommencez votre saisie. Si ça ne fonctionne toujours pas, vérifiez que vous n'avez pas entré de lettres dans un espace qui n'est pas destiné à en recevoir (tel que le n° de CAF), ou de caractères spéciaux (!?#/).</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree">
                                <a role="button" class="collapsed panel-title text-black" data-toggle="collapse" data-parent="#accordion" data-core="" href="#collapse6_39" aria-expanded="false" aria-controls="collapse6">
                                    <h4 class="mbr-fonts-style display-5">
                                        <span class="sign mbr-iconfont mbri-arrow-down inactive"></span> Comment exporter la base de donnée ?</h4>
                                </a>
                            </div>
                            <div id="collapse6_39" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body p-4">
                                    <p class="mbr-fonts-style panel-text display-7">
                                       Pour exporter la base de donnée : <br>1) tapez dans la barre d'adresse <a href="http://localhost/phpmyadmin" target="_blank">"localhost/phpmyadmin"</a> <br> 2) sélectionnez la base de donnée "bdchaudoudoux" <br> 3) cliquez sur le bouton "Exporter" <br> 4) cliquez sur le bouton "Exécuter" </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree">
                                <a role="button" class="collapsed panel-title text-black" data-toggle="collapse" data-parent="#accordion" data-core="" href="#collapse7_39" aria-expanded="false" aria-controls="collapse6">
                                    <h4 class="mbr-fonts-style display-5">
                                        <span class="sign mbr-iconfont mbri-arrow-down inactive"></span> Comment importer la base de donnée sur un ordinateur portable ? solution 1 plus rapide </h4>
                                </a>
                            </div>
                            <div id="collapse7_39" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body p-4">
                                    <p class="mbr-fonts-style panel-text display-7">
                                    Pour importer une base de donnée : <br> 1) tapez dans la barre d'adresse <a href="http://localhost/phpmyadmin" target="_blank">"localhost/phpmyadmin"</a> <br> 2) supprimez la base précedente en cliquant sur "Base de données"<br> 3) cochez la case "bdchaudoudoux" <br> 4) cliquez sur "supprimer" <br> 5) créé une nouvelle base en cliquant sur "Nouvelle base de données" <br> 6) nommez-la "bdchaudoudoux" dans le champ "Nom de base de données" <br> 7) cliquez sur "Creer"<br> 8) cliquez sur "Importer" <br> 9) cliquez sur "Choisir un fichier" <br> 10) sélectionnez le fichier précédemment exporter "bdchaudoudoux.sql" <br> 11) cliquez sur "Exécuter" </p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree">
                                <a role="button" class="collapsed panel-title text-black" data-toggle="collapse" data-parent="#accordion" data-core="" href="#collapse8_39" aria-expanded="false" aria-controls="collapse6">
                                    <h4 class="mbr-fonts-style display-5">
                                        <span class="sign mbr-iconfont mbri-arrow-down inactive"></span> Comment importer la base de donnée sur un ordinateur portable ? solution 2 plus sûre</h4>
                                </a>
                            </div>
                            <div id="collapse8_39" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body p-4">
                                    <p class="mbr-fonts-style panel-text display-7">
                                    Pour importer une base de donnée : <br> 1) tapez dans la barre d'adresse  <a href="http://localhost/phpmyadmin" target="_blank">"localhost/phpmyadmin"</a> <br> 2) supprimez la base précedente en cliquant sur "Base de données"<br> 3) cliquez sur le nom "bdchaudoudoux" <br> 4) renommez la base précedente en cliquant sur "Opération" <br> 5) renommez la en "bdchaudoudoux-AAAAMMJJ" dans la zone "Renommer la base de données en"  <br> 6) cliquez sur "Exécuter" <br> 7) cliquez sur "Importer" <br> 8) cliquez sur "Choisir un fichier" <br> 9) sélectionnez le fichier précédemment exporter "bdchaudoudoux.sql" <br> 10) cliquez sur "Exécuter" </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>