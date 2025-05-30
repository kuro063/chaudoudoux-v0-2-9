    <div id="contenu">


            <form id="formForm" method="post" action="index.php?uc=formations&amp;action=validerModifForm&amp;num=<?php echo $num ?>&amp;nomForm=<?php echo $nom ?>&amp;descForm=<?php echo $desc ?>&amp;orgaForm=<?php echo $orga ?>&amp;remForm=<?php echo $rem ?>&amp;typeForm=<?php echo $type ?>&amp;dureeForm=<?php echo $duree ?>">
            <fieldset><legend>Modifier la formation</legend>
                <label for="idForm">Nom de la formation</label>
                <input type="text" name="nomForm" required size="100" value="<?php echo $nom;?>"/><br/>
                
                <input type="hidden" name="dureeForm" value="<?php echo $duree;?>"/><br/>
                <label for="typeForm">Type de formation :</label>
            <select id="typeForm" name="typeForm">
                <option value="MANDATAIRE" <?php if($type=='MANDATAIRE') echo 'selected'?>>Mandataire</option>
                <option value="PRESTATAIRE" <?php if($type=='PRESTATAIRE') echo 'selected'?>>Prestataire</option>
            </select>
            <label for="orgaForm">Organisme de formation</label>
            <input type="text" name="orgaForm" maxlength="100" value="<?php echo $orga;?>"/><br/>
                <label for="descForm">Description :</label><br/>
                <textarea name="descForm" maxlength="500" cols="70" placeholder="La formation débute le... L'objectif est de..."><?php echo $desc;?></textarea><br/>
                <label for="remForm">Formation rémunérée ?</label>
                <input type="checkbox" value="1" name="remForm" <?php if($rem==1) echo'checked';?>/>
                <input type="hidden" name="num" value="<?php echo lireDonneeUrl('num')?>"/>
            </select>
            </fieldset>
            <fieldset>
                <input type="reset"/>
                <input type="submit"/>
            </fieldset>
        </form>
    </div>