<div id="contenu">
<?php 
    if (lireDonneeUrl('action')=='modifierDemandeFamille'){

        $jour=$laDemande[0]['jour'];
        $exceptionJour=$laDemande[0]['jourException'];
        $heureSem=$laDemande[0]['heureSemaine'];
        $hDeb=$laDemande[0]['heureDebut'];
        $hFin=$laDemande[0]['heureFin'];
        $frequence=$laDemande[0]['frequence'];
        $activite=$laDemande[0]['activite'];
        //print_r($laDemande);

        //On divise l'heure en morceaux
        $divHdeb = explode(':',$hDeb);
        $divHfin = explode(':',$hFin);
        ?>

        <style>
            table,td,tr{
                border: 1px solid black;
                text-align:center;
            }
        </style>

        <h2> Les modifications vont être appliquées au besoin suivant : </h2><br/>
        <?php
        //On affiche le besoin que l'on veut modifier
        echo "
        <table style='width:30%;' >
            <thead>
                <th> Activité </th>
                <th> Jour / Horaires </th>
                <th> Fréquence de la prestation </th>
                <th> Nombre d'heures </th>
            </thead>
            <tbody>
                <tr>
                    <td> $activite </td>
                    <td>$jour $exceptionJour - $hDeb à $hFin <br/><br/></td>
                    <td> Une semaine sur $frequence </td>
                    <td> $heureSem h </td>
                </tr>
            </tbody>
        </table>
        <br/>"; ?>

        <script>
            //Fonction utiliser pour faire appraître le 2nd select après la condition "Sans importance"                            
            function gererJour() {
                const selectJour = document.getElementById('slctJour');
                const exceptionDiv = document.getElementById('exceptionJourDiv');
                const exceptionSelect = document.getElementById('exceptionJour');

                if (selectJour.value == 'sans importance') {
                exceptionDiv.style.display = 'block';
                } else {
                exceptionDiv.style.display = 'none';
                    if (exceptionSelect) {
                        exceptionSelect.value = ""; // Vide la sélection
                    }
                }
            }
            // Appel automatiquement la fonction au chargement de la page
            window.addEventListener('DOMContentLoaded', gererJour);
        </script> 

        <div id='divGlobal'>
        <h2> Modification du besoin : </h2><br/>                     
        <form id="formModifFamille" enctype="multipart/form-data" action="index.php?uc=annuFamille&amp;action=validerDemandeFamille&amp;numDemande=<?php echo $numDemande?>" method="post">
            <div style="display: flex; gap: 10px; align-items: flex-end;">
                                <div>
                                <label>Le :&nbsp;</label>
                                  <select id="slctJour" name="slctJour" onchange="gererJour()"> <?php
                                    //Si le jour du besoin à modifier est 'sans importance'
                                    if($jour=='sans importance'){
                                        //alors on pré-sélectionne l'<option> 'sans importance
                                        echo('<option value="sans importance" selected>Sans importance</option>');}
                                    else{
                                        //Sinon, on met l'<option> 'sans importance' sans qu'elle soit pré-sélectionnée
                                        echo('<option value="sans importance">Sans importance</option>');}
                                    //Même principe pour tout les autres jours
                                    if($jour=='lundi'){
                                        echo('<option value="lundi" selected>Lundi</option>');}
                                    else{
                                        echo('<option value="lundi">Lundi</option>');}
                                    if($jour=='mardi'){
                                        echo('<option value="mardi" selected>Mardi</option>');}
                                    else {
                                        echo('<option value="mardi">Mardi</option>');}
                                    if($jour=='mercredi'){
                                        echo('<option value="mercredi" selected>Mercredi</option>');}
                                    else {
                                        echo('<option value="mercredi">Mercredi</option>');}
                                    if($jour=='jeudi'){
                                        echo('<option value="jeudi" selected>Jeudi</option>');}
                                    else {
                                        echo('<option value="jeudi">Jeudi</option>');}
                                    if($jour=='vendredi'){
                                        echo('<option value="vendredi" selected>Vendredi</option>');}
                                    else{
                                        echo('<option value="vendredi">Vendredi</option>');} 
                                    if($jour=='samedi'){
                                        echo(' <option value="samedi" selected>Samedi</option>');}
                                    else{
                                        echo(' <option value="samedi">Samedi</option>');}
                                    if($jour=='dimanche'){
                                        echo('<option value="dimanche" selected>Dimanche</option>');}
                                    else{
                                        echo('<option value="dimanche">Dimanche</option>');} ?>
                                  </select>
                                </div>

                                <div id="exceptionJourDiv" style="display: none;">
                                  <label>Exception :&nbsp;</label>
                                  <select id="exceptionJour" name="exceptionJour"> <?php
                                    if($exceptionJour=='SANS importance'){
                                        echo('<option value="sans importance" selected>Sans importance</option>');}
                                    else{
                                        echo('<option value="sans importance">Sans importance</option>');}

                                    if($exceptionJour=='lundi'){
                                        echo('<option value="lundi" selected>Sauf Lundi</option>');}
                                    else{
                                        echo('<option value="lundi">Sauf Lundi</option>');}

                                    if($exceptionJour=='mardi'){
                                        echo('<option value="mardi" selected>Sauf Mardi</option>');}
                                    else {
                                        echo('<option value="mardi">Sauf Mardi</option>');}

                                    if($exceptionJour=='mercredi'){
                                        echo('<option value="mercredi" selected>Sauf Mercredi</option>');}
                                    else {
                                        echo('<option value="mercredi">Sauf Mercredi</option>');}

                                    if($exceptionJour=='jeudi'){
                                        echo('<option value="jeudi" selected>Sauf Jeudi</option>');}
                                    else {
                                        echo('<option value="jeudi">Sauf Jeudi</option>');}

                                    if($exceptionJour=='vendredi'){
                                        echo('<option value="vendredi" selected>Sauf Vendredi</option>');}
                                    else{
                                        echo('<option value="vendredi">Sauf Vendredi</option>');} 

                                    if($exceptionJour=='samedi'){
                                        echo(' <option value="samedi" selected>Sauf Samedi</option>');}
                                    else{
                                        echo(' <option value="samedi">Sauf Samedi</option>');}

                                    if($$exceptionJour=='dimanche'){
                                        echo('<option value="dimanche" selected>Sauf Dimanche</option>');}
                                    else{
                                        echo('<option value="dimanche">Sauf Dimanche</option>');} ?>
                                  </select>
                                </div>
                                <div>
                                  <label> de :</label> 
                                  <select name="Hdeb">
                                    <?php 
                                        for ($i=0; $i<24;++$i){
                                            //c'est l'<option> qui sera pré-sélectionnée
                                            $valueSelected = "";
                                            //On vérifie si l'heure du besoin est égal à $i
                                            if($divHdeb[0]==('0'.$i) || $divHdeb[0]==$i){
                                                //Si oui, $i sera la valeure pré-sélectionnée
                                                if($i<10){$valueSelected ='0'.$i;}
                                                else{$valueSelected = $i;}
                                                echo("<option value='$valueSelected' selected>$i</option>");}
                                            //Si non, $i sera une simple <option> non pré-sélectionnée
                                            else{
                                                ?><option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option> <?php }
                                            } ?>

                                    </select>
                                    <select name="minDeb"> <?php
                                        //On regarde si le nombre de minute du début du besoin à modifier vaut '00'
                                        if($divHdeb[1]=='00'){
                                            //Si oui, l'<option> est pré-sélctionnée
                                            echo("<option value='00' selected>00</option>");}
                                        else{
                                            //Si non, elle n'est pas pré-sélectionnée
                                            echo("<option value='00'>00</option>");}
                                        //Même principe que pour '00'
                                        if($divHdeb[1]=='15'){
                                            echo("<option value='15' selected>15</option>");}
                                        else{
                                            echo("<option value='15'>15</option>");}
                                        if($divHdeb[1]=='30'){
                                            echo("<option value='30' selected>30</option>");}
                                        else{
                                            echo(" <option value='30'>30</option>");}
                                        if($divHdeb[1]=='45'){
                                            echo("<option value='45' selected>45</option>");}
                                        else{
                                            echo("<option value='45'>45</option>");} ?>
                                      
                                    </select>                               
                                    <label> à :</label>
                                    <select name="Hfin">
                                      <?php 
                                        for ($i=0; $i<24;++$i){
                                            $valueSelected = "";
                                            if($divHfin[0]==('0'.$i) || $$divHfin[0]==$i){
                                                if($i<10){$valueSelected ='0'.$i;}
                                                else{$valueSelected = $i;}
                                                echo("<option value='$valueSelected' selected>$i</option>");}
                                            else{
                                                ?><option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option> <?php }
                                            } ?>
                                      
                                      </select>
                                 
                                      <select name="minFin"> <?php
                                      if($divHfin[1]=='00'){
                                            echo("<option value='00' selected>00</option>");}
                                        else{
                                            echo("<option value='00'>00</option>");}
                                        if($divHfin[1]=='15'){
                                            echo("<option value='15' selected>15</option>");}
                                        else{
                                            echo("<option value='15'>15</option>");}
                                        if($divHfin[1]=='30'){
                                            echo("<option value='30' selected>30</option>");}
                                        else{
                                            echo(" <option value='30'>30</option>");}
                                        if($divHfin[1]=='45'){
                                            echo("<option value='45' selected>45</option>");}
                                        else{
                                            echo("<option value='45'>45</option>");} ?>

                                      </select>
                                </div>
                                <div>
                                      <?php echo("<label for='frequence'>Une semaine sur :</label>
                                      <input name='frequence' value='$frequence' size='1' required/>"); ?>
                                </div>
                                <div>
                                      <?php echo("<label for='heureSem'>Nombre d'heures/sem :</label>
                                      <input type='number' name='heureSem' value='$heureSem' step='any' min='0' max='100' required style='width: 60px;'/>"); ?>                                
                                </div>
                                </div>  
            </div> 
                                    <p>
    			<input class="btn valdier btn-secondary" type="submit" name="btnValider" style="position:fixed;text-align:center;bottom:0px;left:0px" value="VALIDER" />
    		    </p>
    		    <p>
                <button style="position:fixed;bottom:0px;right:0px" class="retour btn" onclick="history.go(-1);">RETOUR</button>
                </p>
        </form>                                                               
     <?php   
    }