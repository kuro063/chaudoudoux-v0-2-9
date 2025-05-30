<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $lesFamilles array */

?>
<!-- Division pour le contenu principal -->
    


    <h2 style="text-align: center">Liste des assemblées générales</h2>
        <form id="formForm" method="post" action="index.php?uc=annuFamille&amp;action=ajoutAssembGen">

        <fieldset>
        <legend>AJOUT D'ASSEMBLÉE GÉNÉRALE</legend>
            
            <!--<label for="idForm">Nom de l'assemblée générale</label>
            <input type="text" name="nomForm" required size="20"/><br/>-->
            
            <label for="dureeForm" style="font-size:1.5em">Année en cours</label>
            <input type="text" name="dureeForm" size="10"/>
            <input type="submit"/>
        </fieldset>
        </form>

    
    <?php /*
    $a = array ($lesAssembGen);
    print_r ($a);*/
    ?>

    <div>


    <fieldset style="position:absolute;left:40%">
    <?php for($k=0;$k<1;++$k)
    { ?>
    <label for="assembGen"><strong>Historique annuel des AG : </strong></label>
        <input name="assembGen<?php echo $k;?>" list="assembGen<?php echo $k;?>">
        <datalist id="assembGen<?php echo $k;?>">
            <option value="" selected>AG</option>
            <?php foreach ($lesAssembGen as $uneAG)
            {
                $anneeAG=$uneAG['annee'];
                echo '<option value="'.$anneeAG.'">'; echo '</option>';
            }?>
        </datalist>
    <?php } ?>
    
    </fieldset>


    <!-- Barre de recherche sur la page actuelle -->

    <div class="search_box">
        <form action="" id="form2">
            <div>
                <input type="text" id="search">
                <input type="submit" id="submit_form" onclick="checkInput()" value="Rechercher">
            </div>
        </form>
    </div>

    <script>
        function checkInput() {
            var query = document.getElementById('search').value;
            window.find(query);
            return true;
        }
    </script>

    

    
   
    <!--
    <h5>Liste des de toutes les familles</h5>
  
        <table class="sortable zebre" id="listeFamilles">
        <tr class="btn-secondary">
            <th>M</th>
            <th>PM</th>
            <th>PGE</th>
            <th>REG</th>
            <th>Famille</th>
            <th>Adresse</th>
            <th>CP</th>
        </tr>
    -->
    

    
 
    
    <div style="display: flex; flex-direction: column; margin-right :100px">
    <?php include 'v_listeFamilles.php';?>
    </div>

    <div style="display: flex; flex-direction: row-reverse;">
    <div style="display: flex; flex-direction: column;margin-right:40px">
    
    <!--
    <h5>Liste des familles participantes</h5>
    
    
        <table class="sortable zebre" id="listeFamilles">
        <tr class="btn-secondary">
            <th>M</th>
            <th>PM</th>
            <th>PGE</th>
            <th>REG</th>
            <th>Famille</th>
            <th>Adresse</th>
            <th>CP</th>
        </tr>
    -->
    
    
    
    <button style="position:fixed;bottom:0px;left:0px" class="retour btn " onclick="history.go(-1);">ENREGISTRER</button>



<?php      
    /*foreach($lesFormationsM as $uneFormationM) {
        $num=$uneFormationM['idForm_Formations'];
        $nomForm=$uneFormationM['intitule_Formations'];
        $duree=$uneFormationM['duree_Formations'];
        $desc=$uneFormationM['description_Formations'];
        $orga=$uneFormationM['organisme_Formations'];
        $rem=$uneFormationM['remuneration_formation'];
    if ($rem ==1) {$rem='OUI';} else if($rem==0) {$rem='NON';} else {$rem='NC';} 
        $type= $uneFormationM['type_Formations'];
        ?>
        <tr>
            <td><?php echo $nomForm;?></td><td><?php echo $duree; ?></td><td><?php echo $desc;?></td><td><?php echo $orga;?></td>
            <td><?php echo $type;?></td><td><?php echo $rem; ?></td><td><a href="index.php?uc=formations&amp;action=modifForm&amp;num=<?php echo $num;?>">Modifier</a></td>
        </tr>
            
      <?php
    }?>
      </table>*/
      
?>



    








    <!--
    <h5>Formations Prestataires</h5>
    <table class="sortable zebre" id="listeFamilles">
    <tr class="btn-secondary">
    <th>Nom Formation</th><th>Année</th><th>Description formation</th><th>Organisme</th><th>Type</th><th>Remunération</th><th>Modifier</th>
    </tr>
    -->
    <?php      
    /*foreach($lesFormations as $uneFormation) {
        $num=$uneFormation['idForm_Formations'];
        $nomForm=$uneFormation['intitule_Formations'];
        $duree=$uneFormation['duree_Formations'];
        $desc=$uneFormation['description_Formations'];
        $orga=$uneFormation['organisme_Formations'];
        $rem=$uneFormation['remuneration_formation'];
    if ($rem ==1) {$rem='OUI';} else if($rem==0) {$rem='NON';} else {$rem='NC';} 
        $type= $uneFormation['type_Formations'];
        ?>
        <tr>
            <td><?php echo $nomForm;?></td><td><?php echo $duree; ?></td><td><?php echo $desc;?></td><td><?php echo $orga;?></td>
            <td><?php echo $type;?></td><td><?php echo $rem; ?></td><td><a href="index.php?uc=formations&amp;action=modifForm&amp;num=<?php echo $num;?>">Modifier</a></td>
        </tr>
            
      <?php
    }?>
      </table>*/
