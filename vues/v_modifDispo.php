<div id="contenu">
<?php 
    if(lireDonneeUrl('action')=='modifierDispoInterv'){
        $jour=$laDispo[0]['jour'];
        $hDeb=$laDispo[0]['heureDebut'];
        $hFin=$laDispo[0]['heureFin'];
        $frequence=$laDispo[0]['frequence'];
        $activite=$laDispo[0]['activite'];

        $divHdeb = explode(':',$hDeb);
        $divHfin = explode(':',$hFin);
        
        ?>

        <style>

            table,td,tr{
                border: 1px solid black;
                text-align:center;
            }
        </style>
        <h2> Les modifications vont être appliquées à la disponibilité suivante : </h2><br/>
        <?php
        //On affiche la disponibilité que l'on veut modifier
        echo "
        <table style='width:30%;' >
            <thead>
                <th> Activité </th>
                <th> Jour / Horaires </th>
                <th> Fréquence de la prestation </th>
            </thead>
            <tbody>
                <tr>
                    <td> $activite </td>
                    <td>$jour - $hDeb à $hFin <br/><br/></td>
                    <td> Une semaine sur $frequence </td>
                </tr>
            </tbody>
        </table>
        <br/>"; ?>

    
        <div id='divGlobal'>
        <h2> Modification de la disponibilité : </h2><br/>
        <form id="frmSalarie" enctype="multipart/form-data" action="index.php?uc=annuSalarie&amp;action=validerDispoInterv&amp;numDispo=<?php echo $numDispo; ?>" method="post">
        <label>Le :&nbsp;</label>
                                  <select id="slctJour" name="slctJour"> <?php
                                  //Si le jour de la disponibilité à modifier est 'lundi'
                                    if($jour=='lundi'){
                                        //alors on pré-sélectionne l'<option> 'lundi'
                                        echo('<option value="lundi" selected>Lundi</option>');}
                                    else{
                                        //Sinon, on met l'<option> 'lundi' sans qu'elle soit pré-sélectionnée
                                        echo('<option value="lundi">Lundi</option>');}
                                    //Même principe pour tout les autres jours
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
                                  
                                  de : 
                                  <select name="Hdeb">
                                    <?php 
                                        for ($i=0; $i<24;++$i){
                                            //c'est l'<option> qui sera pré-sélectionnée
                                            $valueSelected = "";
                                            //On vérifie si l'heure de la disponibilité est égal à $i
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
                                    //On regarde si le nombre de minute du début de la disponibilité à modifier vaut '00'
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
                                    
                                    à :
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
                                      
                                      <?php echo("<label for='frequence'>Une semaine sur :</label>
                                      <input name='frequence' value='$frequence' size='1' required/>"); ?>
                                      
                                    </div> 
                                    <p>
    			<input class="btn valdier btn-secondary" type="submit" name="btnValider" style="position:fixed;text-align:center;bottom:0px;left:0px" value="VALIDER" />
    		    </p>
    		    <p>
                <button style="position:fixed;bottom:0px;right:0px" class="retour btn" onclick="history.go(-1);">RETOUR</button>
                </p>
        </form>
                                                                      
        
     <?php }