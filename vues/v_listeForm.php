<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $lesFamilles array */

?>
<!-- Division pour le contenu principal -->

    <script> 

    window.onload = function()
    {
        document.getElementById("ajoutFormationForm").style.display='none';
    };
    </script>

    <div id="contenu">

    <h3 class="d-flex justify-content-center">Répertoire des formations intra-chaudoudoux</h3>

        <div class="container p-3">
            <div class="row">
                <div class="col text-center">
                <button onclick="ajouterFormation()" type="button" class="btn btn-outline-primary"> CLIQUEZ POUR AJOUTER UNE FORMATION </button>
                </div>
            </div>
        </div>

        <script> 
        function ajouterFormation()
                    {
                        if(document.getElementById("ajoutFormationForm").style.display=='none') {
                            document.getElementById("ajoutFormationForm").style.display='';
                        }
                        else {
                            document.getElementById("ajoutFormationForm").style.display='none';
                        }
                    }
        </script>

        <div id="ajoutFormationForm" class="row justify-content-center" style="margin-bottom:2%;"> 

            <form id="formForm" method="post" action="index.php?uc=formations&amp;action=ajoutForm">
            
                <fieldset> <legend> <h3 style="color:white" class="ml-3 pt-1">Ajout d'une formation</h3> </legend>
                    <label class="ml-3" style="font-size:large; font-weight: bold;" for="idForm">Nom de la formation :</label>
                    <input type="text" name="nomForm" required size="100"/><br/>

                    <label class="ml-3" style="font-size:large; font-weight: bold;" for="dureeForm">Année de la formation :</label>
                    <input type="text" name="dureeForm" maxlength="15"/><br/>

                    <label class="ml-3" style="font-size:large; font-weight: bold;" for="typeForm">Type de formation :</label>

                <select class="mb-1 ml-3 btn-sm btn-info" id="typeForm" name="typeForm">
                    <option value="MANDATAIRE" selected>Mandataire</option>
                    <option value="PRESTATAIRE" >Prestataire</option>

                </select> <br/>

                <label class="ml-3" style="font-size:large;font-weight:bold;" id="orgaFormIntitule" for="orgaForm">Organisme de formation :</label>
                <input id="orgaFormText" type="text" name="orgaForm" maxlength="100"/><br/>

                    <label class="ml-3" style="font-size:large; font-weight: bold;" for="descForm">Description :</label><br/>
                    <textarea class="ml-3" name="descForm" maxlength="500" cols="70" placeholder="La formation débute le... L'objectif est de..."></textarea><br/>

                    <label class="ml-3" style="font-size:large; font-weight: bold;" for="remForm">Formation rémunérée ?</label>
                    <input style="width:15px;height:15px;" type="checkbox" value="1" name="remForm" checked/>

                </fieldset>

                    <fieldset>
                    <input style="width:23.5%;" class="btn-warning boutonReinitialiser" type="reset"/>
                    <input style="width:76%;" class="btn-secondary boutonEnvoyer" type="submit"/>
                    </fieldset>

            </form>

            <style>

            .boutonReinitialiser:hover {
                background-color:red;
                color:white;
                font-weight: bold;
            }

            .boutonEnvoyer:hover {
                background-color:green;
                color:white;
                font-weight: bold;
            }
            
            </style>

            </div>

            <div class="d-flex justify-content-center"> <h3>Formations Mandataires</h3> </div>
         
        <table class="sortable zebre" id="listeFamilles">
      
            <tr class="btn-secondary">
            <th>Nom Formation</th><th style="column-width:8rem">Année</th><th>Description formation</th><th>Organisme</th><th style="column-width:7rem">Type</th><th>Remunération</th> <!-- <th style="column-width:7rem">Modifier</th> -->
            </tr>
<?php
      
    foreach($lesFormationsM as $uneFormationM) {
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

            <td> <a style="color:black" href="index.php?uc=formations&amp;action=voirListFormIndividu&amp;num=<?php echo $num;?>"> <?php echo $nomForm;?> <img width="4%" style="float:right;" src="images\fleche.svg" alt="bootstrap"> </a> <?php if (lireDonneeUrl('num') == $num) {
            include("vues/v_detailListe.php"); } ?> </td><td style="text-align:center"><?php echo $duree; ?></td><td><?php echo $desc;?></td><td><?php echo $orga;?></td>
            <td style="text-align:center"><?php echo $type;?></td><td style="text-align:center"><?php echo $rem; ?></td><td style="column-width:7rem; text-align:center"><a style="color:rgb(150,24,11); font-weight:bold;" href="index.php?uc=formations&amp;action=modifForm&amp;num=<?php echo $num;?>">Modifier</a></td>
        </tr>
            
      <?php
    }?>
      </table>

    <div class="mt-5 d-flex justify-content-center"> <h3>Formations Prestataires</h3> </div>

    <table class="sortable zebre" id="listeFamilles">
    <tr class="btn-secondary">
        <th>Nom Formation</th><th style="column-width:8rem">Année</th><th>Description formation</th><th>Organisme</th><th style="column-width:7rem">Type</th><th>Remunération</th>
    </tr>
<?php      
    foreach($lesFormations as $uneFormation) {
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
            <td> <a style="color:black" href="index.php?uc=formations&amp;action=voirListFormIndividu&amp;num=<?php echo $num;?>#<?php echo $num?>"> <?php echo $nomForm;?> <img width="4%" style="float:right;" src="images\fleche.svg" alt="bootstrap"> </a> <?php if (lireDonneeUrl('num') == $num) {
            include("vues/v_detailListe.php"); } ?></td><td style="text-align:center"><?php echo $duree; ?></td><td><?php echo $desc;?></td><td><?php echo $orga;?></td>
            <td style="text-align:center"><?php echo $type;?></td><td style="text-align:center"><?php echo $rem; ?></td><td style="column-width:7rem; text-align:center"><a style="color:rgb(150,24,11); font-weight:bold;" href="index.php?uc=formations&amp;action=modifForm&amp;num=<?php echo $num;?>">Modifier</a></td>
        </tr>
            
      <?php
    }?>
      </table>
