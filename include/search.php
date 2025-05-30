<?php 
class Search{   		
    private $monPdo;
    /**
     * Crée l'instance de PDO qui sera sollicitée
     * par toutes les méthodes de la classe
     */				
    public function __construct($serveur, $bdd, $user, $mdp){
        // crée la chaîne de connexion mentionnant le type de sgbdr, l'hôte et la base

        $chaineConnexion = 'mysql:host=' . $serveur . ';dbname=' . $bdd;
        // demande que le dialogue se fasee en utilisant l'encodage utf-8
        // et le mode de gestion des erreurs soit les exceptions
        $params = array (   PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", 
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        // crée une instance de PDO (connexion avec le serveur MySql) 
        $this->monPdo = new PDO($chaineConnexion, $user, $mdp, $params); 
    }
    public function _destruct(){
        $this->monPdo = null;
    }

    //Ensemble des fonctions de recherche

public function rechSimple($categ, $name, $quoi){
    $name = "%".$name."%";
    if ($categ == "Famille"){
        $req = "SELECT distinct Famille.numero_Famille,Pere.nom_Parents as nom1, Mere.nom_Parents as nom2 from Famille join Parents as Pere on Famille.numero_Famille=Pere.numero_Famille join Parents as Mere on Famille.numero_Famille=Mere.numero_Famille left join Proposer on Famille.numero_Famille=Proposer.numero_Famille where Pere.nom_Parents like :name or Mere.nom_Parents like :name or Pere.prenom_Parents like :name or Mere.prenom_Parents like :name or famille.numero_Famille like :name or Mere.email_Parents like :name or Pere.email_Parents like :name or famille.PM_Famille like :name or famille.PGE_Famille like :name or numAlloc_Famille like :name or telDom_Famille like :name order by nom1 asc, nom2 asc;";
    } else if ($categ == "Interv"){
        $req = "SELECT ".$quoi." from Candidats as C join Intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where C.nom_Candidats like :name or C.prenom_Candidats like :name or C.email_Candidats like :name or I.idSalarie_Intervenants like :name or C.nomJF_Candidats like :name GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC;" ;
    } else if ($categ == "Candid"){
        $req = "SELECT distinct * from Candidats where (nom_Candidats like :name or prenom_Candidats like :name or email_Candidats like :name or nomJF_Candidats like :name) and (candidatureRetenue_Candidats not like 'Accepté') order by nom_Candidats asc;";
    }
  /*  else if ($categ=="Fact"){
        $req="SELECT idFact_Factures, montantFact_Factures, factures.numero_Famille as numFam, dateFact_Factures, Pere.nom_Parents as nom1, Mere.nom_Parents from factures JOIN famille on factures.numero_Famille=famille.numero_Famille join Parents as Pere on Famille.numero_Famille=Pere.numero_Famille join Parents as Mere on Famille.numero_Famille=Mere.numero_Famille where idFact_Factures like '%:name%' order by dateFact_Factures desc";
    }*/
    
    $cmd=$this->monPdo->prepare($req);
    $cmd->bindValue(":name", $name);
    $cmd->execute();
    if ($categ == "Interv"){
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
    } else {
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
    }
        
    $cmd->closeCursor();
    return $lignes;
}
public function rechAdvFamille($type, $besoin, $age, $partage, $logement, $superficie, $vehicule, $archive, $villeETcp, $champ, $rech, $date) {
    $filtres = "";
    $compt = 0;

    
    if(($type == 0 || $type == 1) && $type != '') {
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($type == 0){
            $filtres .= "((proposer.dateFin_Proposer >'".date('Y-m-d')."' or proposer.dateFin_Proposer='0000-00-00') and proposer.idADH_TypeADH='PREST')";
        } else {
            $filtres .= "((proposer.dateFin_Proposer >'".date('Y-m-d')."' or proposer.dateFin_Proposer='0000-00-00') and proposer.idADH_TypeADH='MAND')";
        }
        $compt++;
    }
    if(($besoin == 0 || $besoin == 1) && $besoin != '') {
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($besoin == 0){
            $filtres .= "((proposer.dateFin_Proposer >'".date('Y-m-d')."' or proposer.dateFin_Proposer='0000-00-00') and proposer.idPresta_Prestations='ENFA')";
        } else {
            $filtres .= "((proposer.dateFin_Proposer >'".date('Y-m-d')."' or proposer.dateFin_Proposer='0000-00-00') and proposer.idPresta_Prestations='MENA')";
        }
        $compt++;
    }
    if(($age == 0 || $age == 1 || $age == 2) && $age != '') {
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($date == ""){
            $date = date('Y-m-d');
        } else {
            $date = $date . "-01-01";
        }
        $datecompar = strtotime($date.' +1 year');
        if ($age == 0){
            $datemoin1 = strtotime($date.' -1 year');
            $filtres .= "enfants.dateNaiss_Enfants > '". date('Y-m-d', $datemoin1)."' AND enfants.dateNaiss_Enfants > '". $datecompar."' AND enfants.concernGarde_Enfants = 1";
        } else if ($age == 1) {
            $datemoin3 = strtotime($date.' -3 year');
            $filtres .= "enfants.dateNaiss_Enfants > '". date('Y-m-d', $datemoin3)."' AND enfants.dateNaiss_Enfants > '". $datecompar."' AND enfants.concernGarde_Enfants = 1";
        } else {
            $dateplus3 = strtotime($date.' -3 year');
            $filtres .= "famille.numero_Famille NOT IN (SELECT famille.numero_Famille FROM `famille` join enfants on enfants.numero_Famille = famille.numero_Famille WHERE enfants.dateNaiss_Enfants > '". date('Y-m-d', $dateplus3)."' AND enfants.dateNaiss_Enfants > '". $datecompar."') AND enfants.concernGarde_Enfants = 1 ";
        }
        $compt++;
    }
    if(($partage == 0 || $partage == 1) && $partage != '') {
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($partage == 0) {
            $filtres .= "famille.gardePart_Famille=0";
        } else {
            $filtres .= "famille.gardePart_Famille=1";
        }
        $compt++;
    }
    if(($logement == 0 || $logement == 1) && $logement != '') {
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($logement == 0) {
            $filtres .= "famille.typeLogement_Famille = 'MAISON'";
        } else {
            $filtres .= "famille.typeLogement_Famille = 'APPARTEMENT'";
        }
        $compt++;
    }
    if(($superficie == 0 || $superficie == 1 || $superficie == 2 || $superficie == 3) && $superficie != '') {
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($superficie == 0) {
            $filtres .= "famille.superficie_Famille < 50";
        } else if ($superficie == 1) {
            $filtres .= "famille.superficie_Famille > 50 AND famille.superficie_Famille < 100";
        } else if ($superficie == 2) {
            $filtres .= "famille.superficie_Famille > 100 AND famille.superficie_Famille < 150";
        } else {
            $filtres .= "famille.superficie_Famille > 150 ";
        }
        $compt++;
    }
    if(($vehicule == 0 || $vehicule == 1) && $vehicule != '') {
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($vehicule == 0) {
            $filtres .= "famille.vehicule_Famille = 1";
        } else {
            $filtres .= "famille.vehicule_Famille = 0";
        }
        $compt++;
    }
    if(($archive == 0 || $archive == 1) && $archive != '') {
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($archive == 0) {
            $filtres .= "famille.archive_Famille = 1";
        } else {
            $filtres .= "famille.archive_Famille = 0";
        }
        $compt++;
    }
    if($villeETcp[0] != '' && $villeETcp[0] != '0' && $villeETcp[1] != '' && $villeETcp[1] != '0' ) {
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $ville=$villeETcp[0];
        $cp=$villeETcp[1];
        $filtres .= "famille.cp_Famille like '".$cp."' AND famille.ville_Famille like '".$ville."'";
        $compt++;
    }
    if ($champ != "" && $rech != ""){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if (strpos($champ,'Famille')){
            $filtres .= "famille.".$champ." like '%".$rech."%'";
        } else if (strpos($champ,'Enfants')){
            $filtres .= "enfants.".$champ." like '%".$rech."%'";
        } else if (strpos($champ,'Parents')){
            $filtres .= "parents.".$champ." like '%".$rech."%'";
        }
        
        $compt++;
    }
    $req = "SELECT distinct famille.numero_Famille"
            . " from famille "
            . "join parents on parents.numero_Famille = famille.numero_Famille " 
            . "join enfants on enfants.numero_Famille = famille.numero_Famille " 
            . "left join partage on partage.famille1 = famille.numero_Famille "
            . "join proposer on proposer.numero_Famille = famille.numero_Famille"
            . $filtres." group by numero_Famille"
            . " order by famille.numero_Famille;";
    $cmd=$this->monPdo->prepare($req);
    $cmd->execute();
    $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
    $cmd->closeCursor();
    return $lignes;
}

public function rechAdvInterv($DB, $EMT, $TC, $exp, $enfHand, $rennes, $vehicule, $rechCompl, $statutPro, $sitFam, $permis, $mutuelle, $archive, $cp, $titre, $nom, $prenom, $age, $lieuNaiss, $lieuNaissF, $paysNaiss, $paysNaissF, $lieuNaissC, $paysNaissC, $champ, $rech, $modifplanning, $modiffiche, $quoi){
    $filtres = "";
    $compt = 0;
    if(($DB == 1 || $DB == 0) && $DB != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($DB == 0){
            $filtres .= "((dateFin_Proposer >'".date('Y-m-d')."' or dateFin_Proposer='0000-00-00') and proposer.idADH_TypeADH='MAND')";
        } else {
            $filtres .= "((dateFin_Proposer >'".date('Y-m-d')."' or dateFin_Proposer='0000-00-00') and proposer.idADH_TypeADH='PREST')";
        }
        $compt++;
    }
    if(($mutuelle == 1 || $mutuelle == 0 || $mutuelle == "CMU") && $mutuelle != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($mutuelle == "CMU"){
            $filtres .= "C.CMU_Candidats='1'";
        } else if ($mutuelle == 0){
            $filtres .= "(C.mutuelle_Candidats='0' OR C.mutuelle_Candidats='')";
        } else {
            $filtres .= "NOT (C.mutuelle_Candidats='0' OR C.mutuelle_Candidats='')";
        }
        $compt++;
    }
    if(($EMT == 'ENFANTuni' || $EMT == 'MENAGEuni'||$EMT=='TOUT'|| $EMT=='ENFANTtout'|| $EMT=='MENAGEtout') && $EMT != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if($EMT=='ENFANTuni'){
        $filtres .= "C.travailVoulu_Candidats = 'ENFANT' ";}
        if($EMT=='MENAGEuni'){
        $filtres .= "C.travailVoulu_Candidats = 'MENAGE' ";}
        if($EMT=='ENFANTtout'){
        $filtres .= "(C.travailVoulu_Candidats = 'ENFANT' OR ";}
        if($EMT=='MENAGEtout'){
        $filtres .= "(C.travailVoulu_Candidats = 'MENAGE' OR ";}
        if($EMT=='TOUT' || $EMT=='ENFANTtout' || $EMT=='MENAGEtout'){
            $filtres .= "C.travailVoulu_Candidats = 'TOUT' ";
            if($EMT=='ENFANTtout' || $EMT=='MENAGEtout'){
                $filtres .= ")";} }
        $compt++;
    }

    if(($TC == 'ENFA' || $TC == 'MENA') && $TC != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "(idPresta_Prestations='".$TC."' and  (dateFin_Proposer >'".date('Y-m-d')."' or dateFin_Proposer='0000-00-00'))";
        $compt++;
    }

    if(($exp == 1 || $exp == 0) && $exp != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "C.expBBmoins1a_Candidats=".$exp." ";
        $compt++;
    }
    if(($enfHand == 1 || $enfHand == 0) && $enfHand != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "C.enfantHand_Candidats=".$enfHand." ";
        $compt++;
    }
    if(($rennes == 1 || $rennes == 0) && $rennes != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if($rennes==1){
        $filtres .= "C.ville_Candidats like '%RENNES%' ";}
        if($rennes==0){
        $filtres .= "C.ville_Candidats not like '%RENNES%' ";}
        $compt++;
    }
    if(($vehicule == 1 || $vehicule == 0) && $vehicule != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "C.vehicule_Candidats=".$vehicule." ";
        $compt++;
    }
    if(($archive == 1 || $archive == 0) && $archive != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "I.archive_Intervenants=".$archive." ";
        $compt++;
    }
    if(($permis == 1 || $permis == 0) && $permis != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "C.permis_Candidats=".$permis." ";
        $compt++;
    }
    if(($rechCompl == 1 || $rechCompl == 0) && $rechCompl != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "I.rechCompl_Intervenants=".$rechCompl." ";
        $compt++;
    }
    if(($statutPro == 1 || $statutPro == 0) && $statutPro != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($statutPro == 1) {
            $filtres .= "C.statutPro_Candidats='ETUDIANT'";
        } else {
            $filtres .= "C.statutPro_Candidats='PROFESSIONNEL'";
        }
        $compt++;
    }
    if(($sitFam == "CELIBATAIRE" || $sitFam == "MARIE" || $sitFam == "EN COUPLE" || $sitFam == "VEUF" || $sitFam == "PACSE") && $sitFam != '' ){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "C.situationFamiliale_Candidats LIKE '".$sitFam."'";
        
        $compt++;
    }
    if(($cp == "1" || $cp == "2" || $cp == "3") && $cp != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($cp == 1){
            $filtres .= "C.cp_Candidats='35000'";
        } else if ($cp == 2){
            $filtres .= "C.cp_Candidats='35200'";
        } else if ($cp == 3){
            $filtres .= "C.cp_Candidats='35700'";
        }
        
        $compt++;
    }
    if(($titre == "MR" || $titre == "MME" ) && $titre != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "C.titre_Candidats='".$titre."'";
        
        
        $compt++;
    }
    if($nom != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "C.nom_Candidats like '%".$nom."%'";
        
        
        $compt++;
    }

    if($prenom != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "C.prenom_Candidats like '%".$prenom."%'";
        
        
        $compt++;
    }
    if(($age == "1" || $age == "2" || $age == "3") && $age != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $stop_date = date("Y-m-d H:i:s");
        if ($age == 1){
            $date = date('Y-m-d H:i:s', strtotime($stop_date . ' -22 year'));
            $filtres .= "C.dateNaiss_Candidats > '".$date."'";
        } else if ($age == 2){
            $date1 = date('Y-m-d H:i:s', strtotime($stop_date . ' -22 year'));
            $date2 = date('Y-m-d H:i:s', strtotime($stop_date . ' -50 year'));
            $filtres .= "C.dateNaiss_Candidats <= '".$date1."' and C.dateNaiss_Candidats >= '".$date2."'";
        } else if ($age == 3){
            $date = date('Y-m-d H:i:s', strtotime($stop_date . ' -50 year'));
            $filtres .= "C.dateNaiss_Candidats < '".$date."'";
        }
        
        $compt++;
    }
    if($lieuNaiss != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($lieuNaissC == 1){
            $filtres .= "C.lieuNaiss_Candidats like '%".$lieuNaiss."%'";
        } else if ($lieuNaissC == 0){
            $filtres .= "C.lieuNaiss_Candidats not like '%".$lieuNaiss."%'";
        }
        
        
        
        $compt++;
    }
    
    if(($lieuNaissF == "1" || $lieuNaissF == "0") && $lieuNaissF != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($lieuNaissF == 1){
            $filtres .= "C.lieuNaiss_Candidats != ''";
        } else if ($lieuNaissF == 0){
            $filtres .= "C.lieuNaiss_Candidats = ''";
        }
        
        $compt++;
    }
    
    if($paysNaiss != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($paysNaissC == 1){
            $filtres .= "C.paysNaiss_Candidats like '%".$paysNaiss."%'";
        } else if ($paysNaissC == 0){
            $filtres .= "C.paysNaiss_Candidats not like '%".$paysNaiss."%'";
        }
        
        
        $compt++;
    }
    
    if(($paysNaissF == "1" || $paysNaissF == "0") && $paysNaissF != ''){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        if ($paysNaissF == 1){
            $filtres .= "C.paysNaiss_Candidats != ''";
        } else if ($paysNaissF == 0){
            $filtres .= "C.paysNaiss_Candidats = ''";
        }
        
        $compt++;
    }


    if ($champ != "" && $rech != ""){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "C.".$champ." like '%".$rech."%'";
        $compt++;
    }
    if ($modifplanning != ""){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "proposer.dateModif_Proposer LIKE '".$modifplanning."%' ";
    } 
    if ($modiffiche != ""){
        if($compt >= 1){
            $filtres .= " and ";
        } else {
            $filtres .= " where ";
        }
        $filtres .= "I.dateModif_Intervenants LIKE '%".$modiffiche."%' ";
    } 
    $filtres .= " and ";
    $filtres .= "C.numCandidat_Candidats != 9999 ";
    $req = "SELECT ".$quoi." from Candidats as C join Intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats join proposer on I.numSalarie_Intervenants=proposer.numSalarie_Intervenants".$filtres."GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC";
    $cmd=$this->monPdo->prepare($req);
    $cmd->execute();
    $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
    $cmd->closeCursor();
    return $lignes;
}


}
?>