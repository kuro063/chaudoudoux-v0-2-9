<style>

              
table,td,tr{
border: 1px solid black;
text-align:center;

}


</style>

            
                    <?php
                              echo "<legend>TABLEAU DES BESOINS DES FAMILLES </legend>";
                              
                              echo "<table id='tabloFamille' style='width:100%;'>";
                              echo "<thead>";
                              echo "<th> Numero de la famille </th>";
                              echo "<th> PGE de la famille </th>";
                              echo "<th> PM de la famille </th>";
                              echo "<th> Nom de la famille </th>";
                              echo "<th> Activité </th>";
                              echo "<th> Jour / Horaires </th>";
                              echo "<th> Fréquence de la prestation </th>";
                              echo "<th> Supprimer le besoin </th>";
                              echo "</thead>";
                              echo "<tbody>";
                              foreach ($lesBesoinsDesFamilles as $key => $unBesoinFamille)
                              
                              { 
                                //print_r($unBesoinFamille); echo("<br/>");
                                                              
                                $jourI=$unBesoinFamille['jourI']; //Jour de disponibilité intervenant
                                $jourF=$unBesoinFamille['jourF']; //Jour du besoin famille
                                $nomFamille=$unBesoinFamille['nom_Parents'];
                                $numFamille=$unBesoinFamille['numero_famille'];
                                $hDeb=$unBesoinFamille['heureDebut'];
                                $PM=$unBesoinFamille['PM_Famille'];
                                $PGE=$unBesoinFamille['PGE_Famille'];
                                
                                $hFin=$unBesoinFamille['heureFin'];
                                $frequence=$unBesoinFamille['frequence'];
                                $activite=$unBesoinFamille['activite'];
                                $id=$unBesoinFamille['id'];
                                
                                echo "<tr>";
                                echo "<td class='dispo'>".$numFamille."</td>";
                                echo "<td class='dispo'>".$PGE."</td>";
                                echo "<td class='dispo'>".$PM."</td>";  
                                echo "<td class='dispo'><a href='index.php?uc=annuFamille&action=voirDetailFamille&amp;num=$numFamille'</a>".$nomFamille."</td>";
                                echo "<td class='dispo'>".$activite." </td>";
                                if($jourF=='sans importance'){
                                  echo "<td class='dispo'> ".$jourI." - ".$hDeb." à ".$hFin." <br/>(Jour sans importance pour la famille)<br></td>";}
                                else  { 
                                  echo "<td class='dispo'> ".$jourI." - ".$hDeb." à ".$hFin."<br><br></td>";}
                                echo "<td class='dispo'> une semaine sur ".$frequence."  </td>";
                                echo '<td class="dispo"> <a href="index.php?uc=annuSalarie&amp;action=supprimerDemandeFamille&amp;numBesoin='.$id.'">Supprimer</a> </td>';
                                echo '</tr>';
                                
                                echo "</tbody>";
                              }
                              echo "</table>";
                              
echo '<button style="position:fixed;bottom:0px;right:0px" class="retour btn" onclick="history.go(-1);">RETOUR</button>';

                              ?>