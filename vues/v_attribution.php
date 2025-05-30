
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
<!--<div id="contenu">-->
     
<form method='post' action='index.php?uc=attribution&amp;action=validInterv'>
    <!--<fieldset style="width: 50%; margin: 10px;">-->

        <legend style="text-align:center"><strong>ATTRIBUTION INTERVENTION</strong></legend>
        <input name="interv" type="hidden" value="<?php echo lireDonneeUrl('num')?>">
                
        <!--
        <label for="presta"><strong>Prestation : </strong></label>
        <select name="presta">
            <option value="" selected></option>
            <option value="BURO">Bureau</option>
            <option value="MENA">Ménage</option>
            <option value="ENFA" >Garde d'enfants</option>
        </select>
        -->
                
    <!--</fieldset>-->

    <label for="presta" style="font-size:1.3em;text-align:center"><strong>PRESTATION UNIQUE POUR LA PAGE : </strong></label>
        <select name="presta">
            <option value="" selected></option>
            <option value="BURO">Bureau</option>
            <option value="MENA">Ménage</option>
            <option value="ENFA" >Garde d'enfants</option>
        </select>
        <br>

        <i>VOUS POUVEZ ATTRIBUER <strong>4</strong> FAMILLES SUR CETTE PAGE POUR UN TYPE DE PRESTATION</i>
            
        <?php for($k=0;$k<4;++$k) { /*if($k%2==0){echo '<div style="display:flex; flex-direction:row;">';}*/ /*4 fois le formulaire d'attribution, pour l'instant mit à 1*/?>

    <fieldset style="width: 45%; margin: 5%;">
                
        

        <label for="famille"><strong>Choix de la famille : </strong></label>
        <input name="famille<?php echo $k;?>" list="famille<?php echo $k;?>">
           
        <datalist id="famille<?php echo $k;?>">
            <option value="" selected>Famille</option>
            <?php foreach ($lesFamilles as $uneFam)
            {
                $numFam=$uneFam['numero_Famille'];
                $nomFam=$pdoChaudoudoux->obtenirNomFamille($numFam);
                echo '<option value="'.$numFam.'">';  echo $nomFam; if($numFam!=9999){echo ' '.$numFam.' ';} echo '</option>';
            }?>
        </datalist>
        <?php /*}*/?>
        <br>


        <label for="idADH<?php echo $k;?>"><strong>Type d'adhésion : </strong></label>
        <select name="idADH<?php echo $k;?>">
            <option value=""></option>
            <option value="PREST">Prestataire</option>
            <option value="MAND">Mandataire</option>
        </select>
        <br/>

        <label for="dateDeb"><strong>Date de début prévue :</strong></label>
        <input type="date" name="dateDeb<?php echo $k;?>" />
        <br/>

        <label for="dateFin"><strong>Date de fin prévue :</strong></label>
        <input type="date" name="dateFin<?php echo $k;?>"/>


        <?php for($v=0;$v<5;++$v){?>
        <div>


        <label>Le :&nbsp;</label>
        <select name="slctJour<?php echo $k.$v;?>">
            <option value="jour" selected>Jour</option>
            <option value="lundi">Lundi</option>
            <option value="mardi">Mardi</option>
            <option value="mercredi">Mercredi</option>
            <option value="jeudi">Jeudi</option>
            <option value="vendredi">Vendredi</option>
            <option value="samedi">Samedi</option>
            <option value="dimanche">Dimanche</option>
        </select>
            
        de : 
        <select name="Hdeb<?php echo $k.$v;?>">
        <?php for ($i=0; $i<25;++$i){?>
        <option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option>
        <?php }?>
        </select>

        <select name="minDeb<?php echo $k.$v;?>">
            <option value='00'>00</option>
            <option value='15'>15</option>
            <option value='30'>30</option>
            <option value='45'>45</option>
        </select>

        à :
        <select name="Hfin<?php echo $k.$v;?>">
        <?php for ($i=0; $i<25;++$i){?>
            <option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option>
        <?php }?>
        </select>

        <select name="minFin<?php echo $k.$v;?>">
            <option value='00'>00</option>
            <option value='15'>15</option>
            <option value='30'>30</option>
            <option value='45'>45</option>
        </select>

        <label for="frequence">Une semaine sur :</label>
        <input name="frequence<?php echo $k.$v;?>" value="1" size='1' required/>

        <label for='modalites<?php echo $k;?>'>Modalités :</label>         
        <textarea maxlength="200" name="modalites<?php echo $k.$v;?>"></textarea></div><?php } ?>

    </fieldset>
        <?php if($k%2==1){echo '</div>';} }?>
        
        <?php
    /*<fieldset class="lien">
        <legend> Envoi des fiches </legend>
        <input type="checkbox" selected name="cv"/>
        <label for="cv">Envoi du CV & lettre de motivation à la famille</label><br/>
        <input type="checkbox" selected name="ficheFam"/>
        <label for="ficheFam">Envoi de la fiche de la famille à l'intervenant</label>
    </fieldset>*/
        ?>

        <!--<input type="reset" style="margin-bottom:50px"/>()-->
        <!--class="btn btn-md btn-secondary display-4" style="position:fixed; bottom:0px; left:0px"-->
        <input class="btn btn-secondary display-4" type="submit" style="position:fixed; bottom:0px; left:0px;width:13%;font-size:2em" onsubmit='window.open("planning.php?num=<?php echo $num?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400");'/>
</form>
