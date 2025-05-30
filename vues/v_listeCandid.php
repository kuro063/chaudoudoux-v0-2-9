<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $lesEtudiants array */
?>
<!-- Division pour le contenu principal -->
    <div id="contenu">
  
           <h1 class="alignText">LISTE DES CANDIDAT(E)S<?php if ($archive==1) {echo ' Refusé(e)s';}?></h1>
      <table class="sortable zebre" id="listeCandid">
          <thead>
        <tr class="btn-secondary">
            <th>Nom</th><th>Prénom</th><th>Adresse</th><th>Code Postal</th><th>Ville</th><th>Quartier</th><th>Véhicule</th><th>Email</th><th>Téléphone</th><th>ENFANTS/MÉNAGE/TOUT</th><th>Disponibilités</th><th>Diplômes</th><th>Statut Professionnel</th><th>Date d'entretien</th><?php if ($archive==1) {echo "<th>Raison</th>";}?><th>Décision</th>
        </tr>
          </thead><tbody>
<?php      
    foreach ($lesCandidats as $unCandidat) {
        $num = $unCandidat["numCandidat_Candidats"];
        $nom = $unCandidat["nom_Candidats"];
        $prenom = $unCandidat["prenom_Candidats"];
        $adresse=$unCandidat["adresse_Candidats"];
        $cp= $unCandidat["cp_Candidats"];
        $ville=$unCandidat["ville_Candidats"];
        $quartier=$unCandidat["Quartier_Candidats"];
        $vehicule=$unCandidat["vehicule_Candidats"];
        $tel="<strong>".$unCandidat["telPortable_Candidats"]."</strong><br/>".$unCandidat["telFixe_Candidats"];
        $dispo=$unCandidat['disponibilites_Candidats'];
        $email=$unCandidat['email_Candidats'];
        $diplome=$unCandidat['diplomes_Candidats'];
        $dateEnt=$unCandidat['dateEntretien_Candidats'];
        $dateNaiss = new DateTime($unCandidat["dateNaiss_Candidats"]);
        $natio = $unCandidat["nationalite_Candidats"];
        $statutPro = $unCandidat["statutPro_Candidats"];
        $travailVoulu = $unCandidat["travailVoulu_Candidats"];
     if ($archive==1){$raison = $unCandidat["candidatureRetenue_Candidats"];}
if (isset($dateEnt)){
            $ckent= substr($dateEnt, 0,4).substr($dateEnt, 5,2).substr($dateEnt, 8,2).'000000';
        }?>
       <tr>
           <td>
                <a href="index.php?uc=annuCandid&amp;action=voirDetailCandid&amp;num=<?php echo $num; ?>"><?php echo $nom; ?></a>
           </td>
           <td><?php echo $prenom ; ?></td>
           <td><?php echo $adresse;?></td>
           <td><?php echo $cp;?></td>
           <td><?php echo $ville;?></td>
           <td><?php echo $quartier;?></td>
           <td><?php if ($vehicule==0) {echo 'NON';} else {echo 'OUI';}?></td>
           <td><?php echo $email;?></td>
           <td><?php echo $tel;?></td>
           <td><?php echo $travailVoulu;?></td>
           <td><?php echo $dispo;?></td>
           <td><?php echo $diplome;?></td>
           <td><?php /*if($statutPro == 'ETUD'){
            echo "Etudiant";
            } else if ($statutPro == 'PRO'){
              echo "Professionnel";
            }*/echo strtoupper($statutPro); ?></td>
           <td sorttable_customkey='<?php echo $ckent;?>'><?php echo dateToString($dateEnt);?></td>
           
           <?php if ($archive==1){
           echo '<td>'.$raison.'</td>';}?>
           
            <td>
                <a href="index.php?uc=annuCandid&amp;action=decisionCandid&amp;num=<?php echo $num; ?>">Accepter/Refuser</a>
           </td>
       </tr>
<?php
}
?>



























    <!--Vincent bouton vers le haut de page--> 
 <button class="button" onclick="topFunction()" id="topBtn"><img src="../images/toTop.png" width="60"></button>

 <script>
 window.onscroll = function() {scrollFunction()};

 function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("topBtn").style.display = "block";
  } else {
    document.getElementById("topBtn").style.display = "none";
  }
 }
 function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
 }
</script>
    </tbody>
    </table>
    </div>
