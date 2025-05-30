<!--<body class="staticPages">-->
<div style="margin-top:5%">


<!--<h4>MODIFICATIONS POSSIBLES ACTUELLEMENT DANS LE PLANNING</h4>-->
<fieldset>
<form method="post" action="index.php?uc=interventions&amp;action=validerModifInterv">

    <?php if (lireDonneeUrl('num')==99999){?>

        <label for="numSal">Salarié :</label>
        <input list="sal" name="numSal" type="text" value="99999"/>
        <datalist id="sal">
    <?php foreach($lesSal as $unSal){
            $numSalListe=$unSal['numSalarie'];
            $nomSalListe=$unSal['nom'];
            $prenomSalListe=$unSal['prenom'];
            $idSalListe=$unSal['idSalarie'];
            echo '<option value='.$numSalListe.'>'.$nomSalListe.' '.$prenomSalListe.' '.$idSalListe.'</option>';
    } ?>
        </datalist>
    <?php }

    else {

    ?>
    
    <input type="hidden" name="numSal" value="<?php echo $numSal; ?>"/>

    <?php } ?>


    <!-- à retravailler FAIT-->
    <fieldset>
        <input name="interv" type="hidden" value="<?php echo lireDonneeUrl('num')?>">

        <!--<label for="presta"><strong>Prestation :</strong></label>
        <select name="presta">
            <option value="" selected></option>
            <option value="BURO">Bureau</option>
            <option value="MENA">Ménage</option>
            <option value="ENFA">Garde d'enfants</option>
        </select>-->
    </fieldset><br>


    <!-- <div style="display: flex; flex-direction: row-reverse;">
    <div style="flex-direction: column;margin-right:40px; border-style:solid; padding:1%;">
    
    <h4><u><strong>MODIFICATIONS IMPOSSIBLES ACTUELLEMENT DANS LE PLANNING</strong></u></h4><br><br>


     ???
    <strong>DANS CE CAS, VOUS DEVEZ TERMINER LA PRESTATION ET LA RESSAISIR TOTALEMENT.</strong>


    </div>   --> 


    <div style="font-size:1.2em;flex-direction:column; margin-right:5%;border-style:solid; padding:1%; margin-left:5%">

    <h4><u><strong>MODIFICATIONS POSSIBLES ACTUELLEMENT DANS LE PLANNING</strong></u></h4><br><br>

    <!-- à retravailler -->

    <label for="famille"><strong>Choix de la famille (modifiable depuis janvier 2022):</strong></label><br>
    <input id="newnumFam" value="<?php echo $numFam ?>" name="famille" list="famille">
    <datalist id="famille">
        <?php foreach ($lesFamilles as $uneFam){
            $numFam=$uneFam['numero_Famille'];
            $nomFam=$pdoChaudoudoux->obtenirNomFamille($numFam);
            echo '<option value="'.$numFam.'">';  echo $nomFam; if($numFam!=9999){echo ' '.$numFam.' ';} echo '</option>';
        } ?>
    </datalist>
   

    <br><br>

    <label for="idADH"><strong>Type d'adhésion</strong></label>
    <select name="idADH">
        <option value="PREST" <?php if($idADH=="PREST") echo "selected";?>>Prestataire</option>
        <option value="MAND" <?php if($idADH=="MAND") echo "selected";?>>Mandataire</option>
    </select><br><br>

    <!--FAIT-->
    <label for="idPresta"><strong>Prestation (modifiable depuis janvier 2021) : </strong></label>
    <select name="idPresta">
        <option value="" <?php if($idPresta=="") echo "selected";?>></option>
        <option value="BURO" <?php if($idPresta=="BURO") echo "selected";?>>Bureau</option>
        <option value="MENA" <?php if($idPresta=="MENA") echo "selected";?>>Ménage</option>
        <option value="ENFA" <?php if($idPresta=="ENFA") echo "selected";?>>Garde d'enfants</option>
    </select><br><br>

    <!-- à retravailler-->
    <label for="dateDeb"><strong>Date de début (sécurisé depuis Janvier 2022):</strong></label> 
    <input type="date" name="dateDeb" value="<?php if(isset($dateDeb)){echo $dateDeb;}?>" ><strong> Date de début à valider avant la date de fin de façon à ce que la date de fin ne soit pas antérieur à la date de début. </strong><br/><br/>      <?php /*echo $k;*/?><!--"/>-->
    
    
    <!-- Modifiable depuis janvier 2021 --->
    <label for="dateFin"><strong>Date de fin (modifiable depuis janvier 2021) : </strong></label>
    <input type="date" name="dateFin" value="<?php if(isset($dateFin)){echo $dateFin;}?>" min="<?php echo $dateDeb;  ?>" ><br/><br/>

    <label for="jour"><strong>Le : </strong></label>
    <select name="jour">
        <option value="lundi" <?php if($jour=="lundi") echo "selected";?>>Lundi</option>
        <option value="mardi" <?php if($jour=="mardi") echo "selected";?>>Mardi</option>
        <option value="mercredi"<?php if($jour=="mercredi") echo "selected";?>>Mercredi</option>
        <option value="jeudi"<?php if($jour=="jeudi") echo "selected";?>>Jeudi</option>
        <option value="vendredi"<?php if($jour=="vendredi") echo "selected";?>>Vendredi</option>
        <option value="samedi"<?php if($jour=="samedi") echo "selected";?>>Samedi</option>
        <option value="dimanche"<?php if($jour=="dimanche") echo "selected";?>>Dimanche</option>
    </select><br><br>

    <label for="hDeb"><strong>De : </strong></label>
    <select name="hDeb">
        <?php for ($i=0; $i<25;$i++){?>
        <option value="<?php echo $i;?>" <?php if($hDeb==$i) echo "selected";?>><?php echo $i;?></option>
        <?php } ?>
    </select>

    <label for="minDeb"><strong> : </strong></label>
    <select name="minDeb">
        <?php for ($j=0;$j<60;$j+=15){?>
        <option value="<?php echo $j?>" <?php if($minDeb==$j) echo "selected";?>><?php echo $j;?></option>
       <?php } ?>
    </select>

    <label for="hFin"><strong> à </strong></label>
    <select name="hFin">
        <?php for ($i=0; $i<25;$i++){?>
        <option value="<?php echo $i;?>" <?php if($hFin==$i) echo "selected";?>><?php echo $i;?></option>
        <?php } ?>
    </select>

    <label for="minFin"><strong> : </strong></label>
    <select name="minFin">
        <?php for ($j=0;$j<60;$j+=15){?>
        <option value="<?php echo $j?>" <?php if($minFin==$j) echo "selected";?>><?php echo $j;?></option>
     <?php } ?>
    </select><br><br>

    <label for="freq"><strong>Une semaine sur (modifiable depuis janvier 2022):</strong></label><br>
    <input id="freq" type="number" name="freq" value="<?php echo $freq;?>" min="1" size="2"/><br/><br/>

    <label for="modalites"><strong>Modalités :</strong></label><br>
    <textarea name="modalites" cols="50" style="height:100px"><?php echo $modalites ?></textarea>
    <br><br>

    <input class="btn valider btn-secondary" style="width:175px;margin-left:35%" type="submit" value="VALIDER"/>
    
    </div>
    
    </div>

    <input type="hidden" name="numFam" value="<?php echo $numFam?>"/><!--num famille-->
    <input type="hidden" name="numSalAncien" value="<?php echo $numSal?>"/><!--num salarié-->

    <input type="hidden" name="idPrestaAncien" value="<?php echo $idPresta?>"/><!--prestation-->
    <input type="hidden" name="numFamAncien" value="<?php echo $numFam?>"/><!--num famille-->
    <input type="hidden" name="idADHAncien" value="<?php echo $idADH?>"/><!--adhésion-->
    <input type="hidden" name="dateDebAncien" value="<?php echo $dateDeb?>"/><!--date de début-->
    <input type="hidden" name="dateFinAncien" value="<?php echo $dateFin?>"/><!--date de début-->
    <input type="hidden" name="hDebAncien" value="<?php echo $hDeb.':'.$minDeb.':00'?>"/><!--heure de début-->
    <input type="hidden" name="hFinAncien" value="<?php echo $hFin.':'.$minFin.':00'?>"/><!--heuere de fin-->
    <input type="hidden" name="jourAncien" value="<?php echo $jour?>"/><!--jour-->
    
    
              
    </form>
    </fieldset>
</div>
<button style="position:fixed;bottom:0px;left:0px;color:white" class="retour btn" onclick="history.go(-1);">RETOUR</button>
</body>