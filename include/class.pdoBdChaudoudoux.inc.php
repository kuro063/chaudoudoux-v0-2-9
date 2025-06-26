<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO pour l'application Gestion de données
 * @package default
 * @author Peyrot Edouard
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */
class PdoBdChaudoudoux{   		
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

    //Ensemble des fonctions pour les utilisateurs
    /**
     * Retourne les informations d'un utilisateur
     * @param string $login 
     * @param string $mdp
     * @return array id, nom et prénom sous la forme d'un tableau associatif 
    */ 
    public function obtenirInfosUser($login, $mdp){
        //$req = "SELECT id, nom, prenom from users "
                      // . "where id=? and mdp_sha1=?";  
		$req = "SELECT id, nom, prenom, mdp from users "
                      . "where id=?";
        $cmd = $this->monPdo->prepare($req);
        // valorisation des deux marqueurs interrogatifs pour login et mdp
        $cmd->bindValue(1, $login);
        // $cmd->bindValue(2, sha1($mdp));
        // exécution de la requête puis récupération de la ligne résultat
        $cmd->execute();
        $ligne = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
		
		if(password_verify($mdp, $ligne['mdp'])){
			$_SESSION['id']=$ligne['id'];
			return $ligne;	
		}
    }
    public function obtenirMdpUser($id){
        // $req = "SELECT mdp_sha1 from users where id=?";
		$req = "SELECT mdp from users where id=?";
        $cmd = $this->monPdo->prepare($req);
        // valorisation des deux marqueurs interrogatifs pour login et mdp
        $cmd->bindValue(1, $id);
        // exécution de la requête puis récupération de la ligne résultat
        $cmd->execute();
        $ligne = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;
    }
    public function modifierMDP($new_mdp, $login){
        $req = "UPDATE users set mdp=?, mdp_sha1=sha1(?) where id=?";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $new_mdp);
        $cmd->bindValue(2, $new_mdp);
        $cmd->bindValue(3, $login);
        $cmd->execute();
        $nbUtilAffecte = $cmd-> rowCount();
        return $nbUtilAffecte == 1;
    }
  
    public function suppLigneDemande($id){
        $req="DELETE FROM besoinsfamille WHERE id=:id ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('id', $id);
        $cmd->execute();
        $cmd->closeCursor();
       }
       public function suppLigneDispo($id){
        $req="DELETE FROM besoinsfamille WHERE id=:id ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('id', $id);
        $cmd->execute();
        $cmd->closeCursor();
       }
           
    
public function archiverIntervention($numSal, $numFam, $hDeb, $dateDeb, $idPresta, $idADH, $jour, $hFin)
{
    $req='update proposer set dateFin_Proposer=now(), statut_Proposer="Effectué" where numSalarie_Intervenants=:numSal
     and numero_Famille=:numFam and hDeb_Proposer=:hDeb and dateDeb_Proposer=:dateDeb and idPresta_Prestations=:idPresta
      and idADH_typeADH=:idADH and jour_Proposer=:jour and hFin_Proposer=:hFin';
    
    
    $cmd=$this->monPdo->prepare($req);
    $cmd->bindValue('numSal',$numSal);
    $cmd->bindValue('numFam',$numFam);
    $cmd->bindValue('hDeb',$hDeb);
    $cmd->bindValue('jour',$jour);
    $cmd->bindValue('hFin',$hFin);
    $cmd->bindValue('dateDeb',$dateDeb);
    $cmd->bindValue('idPresta',$idPresta);
    $cmd->bindValue('idADH',$idADH);
    $cmd->execute();
    $cmd->closeCursor();
}





    //ensemble des fonctions retives aux salariés
    /*
    Retourne l'ensemble des salariés de Chaudoudoux
    @param array $filtres
    @return array tableau des salariés, sous forme de tableau associatif
    */
    public function changerdepuiPlaning($num, $dispo,$rechCompl, $archive, $observ){
        $req = "update candidats set disponibilites_Candidats=:dispo, observations_Candidats=:observ where numCandidat_Candidats in (SELECT candidats_numCandidat_Candidats from intervenants where numSalarie_Intervenants=:num); update intervenants set archive_Intervenants=:archive,rechCompl_Intervenants=:rechCompl where numSalarie_Intervenants=".$num.";";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->bindValue('dispo', $dispo);
        $cmd->bindValue('archive', $archive);
        $cmd->bindValue('rechCompl', $rechCompl);
        $cmd->bindValue('observ', $observ);

        $cmd->execute();
        $cmd->closeCursor();
    }
    public function horsedt($num){
        $res=false;
        $req = "SELECT count(*) from proposer where numSalarie_Intervenants=:num and (hDeb_Proposer<'05:00:00' or hFin_Proposer>'22:00:00' or jour_Proposer='dimanche') and (dateFin_Proposer>date(now()) or dateFin_Proposer='0000-00-00')";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['count(*)'];
        if ($lignes>0){
            $res = true;
        }
        return $res;
    }

    public function obtenirListeSalarieSELECT($quoi){ 
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }

    public function obtenirListeSalariecomplH($quoi){
        $req = "SELECT ".$quoi." FROM candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 AND rechCompl_Intervenants=1 GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function obtenirModifPrest($quoi){
        $moisactuel = date('Y-m');
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 AND I.numSalarie_Intervenants in (SELECT numSalarie_Intervenants from proposer where idADH_TypeADH='PREST' and dateModif_Proposer LIKE '". $moisactuel."%') GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    /* function obsolète */
    public function obtenirTotalListeModif10J(){/*nb modifiés derniers 10 jours*/
        $req = "SELECT distinct count(*) from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats 
        where numSalarie_Intervenants in (SELECT numSalarie_Intervenants from proposer where idADH_TypeADH='PREST' 
        and timediff(dateModif_Proposer,now())<10)";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['count(*)'];
        return $lignes; 
    }
    public function obtenirListeSalarieArret($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats 
        where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 and arretTravail_Intervenants=1 GROUP BY C.numCandidat_Candidats 
        ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function obtenirListeSalarie($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats 
        where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 and I.numSalarie_Intervenants
         not in (SELECT numSalarie_Intervenants from proposer where dateFin_Proposer>date(now()) or dateFin_Proposer='0000-00-00' 
         and numero_Famille<>'9999') GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function obtenirListeSalarieRennes($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 AND UPPER(ville_Candidats)='RENNES' GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function obtenirListeSalarieHorsRennes($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 and UPPER(ville_Candidats)<>'RENNES' GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function obtenirListeSalarieEnfHand($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=0 and enfantHand_Candidats=1 GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function obtenirListeSalarieMoins3a($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 and expBBmoins1a_Candidats=1 GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function obtenirListeSalarieGEP($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats join proposer as P on P.numSalarie_Intervenants=I.numSalarie_Intervenants where I.archive_Intervenants=0 and P.idADH_TypeADH='PREST' and C.travailVoulu_Candidats='ENFANT' GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function obtenirListeSalarieGEM($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats join proposer as P on P.numSalarie_Intervenants=I.numSalarie_Intervenants where I.archive_Intervenants=0 and P.idADH_TypeADH='MAND' and C.travailVoulu_Candidats='ENFANT' GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function obtenirListeSalarieVehicule($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 and vehicule_Candidats=1 GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function obtenirListeSalariePlace($quoi){
        $req= "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats join proposer as P on P.numSalarie_Intervenants=I.numSalarie_Intervenants where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 AND P.numSalarie_Intervenants in (SELECT numSalarie_Intervenants from proposer where (dateFin_Proposer>=date(now()) or dateFin_Proposer='0000-00-00' and numero_Famille<>'9999')) GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function obtenirListeSalarieIncoherence($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats join proposer as P on P.numSalarie_Intervenants=I.numSalarie_Intervenants join famille on famille.numero_Famille=P.numero_Famille where I.archive_Intervenants=1 and famille.archive_Famille<>1 AND P.numSalarie_Intervenants in (SELECT numSalarie_Intervenants from proposer where (dateFin_Proposer>=date(now()) or dateFin_Proposer='0000-00-00' and numero_Famille<>'9999')) GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC;" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function obtenirEnfantsHand($num){
     $req = "SELECT count(enfantHand_Famille)from famille where numero_Famille=:num";
      $cmd = $this->monPdo->prepare($req);
      $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $lignes=$lignes['count(enfantHand_Famille)'];
        if ($lignes >0){
            $phrase = "Handicap";
        }else {$phrase="";}
        $cmd->closeCursor();
        return $phrase;       
    }
    public function obtenirNumeroSalarie($num){
        $req="SELECT idSalarie_Intervenants from intervenants where numSalarie_Intervenants=:num";
         $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetch();
        if (isset($lignes)) {$lignes=$lignes['idSalarie_Intervenants'];}
        else {$lignes="";}
        $cmd->closeCursor();
        return $lignes;
    }
    public function obtenirNumerosFamille($num)
    {
        $req="SELECT numero_Famille, REG_Famille, PM_Famille, PGE_Famille from famille where numero_Famille=:num";
         $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        return $lignes;
    }

    public function obtenirNumFormation($num)
    {
        $req="SELECT numero_Famille, REG_Famille, PM_Famille, PGE_Famille from famille where numero_Famille=:num";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        return $lignes;
    }
    public function obtenirTarifs()
    {
        $req= "SELECT * from tarifs";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function ajoutUtil($nom, $prenom, $id, $mdp, $mdpSha1)
    {
        
        $req="insert into users values (:id, :nom, :prenom, :mdp, :mdpSha1);";
        $req.="create user '".$id."'@'localhost' identified by '';"
                . "grant all on *.* to '".$id."'@'localhost'; flush privileges";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('nom', $nom);
        $cmd->bindValue('prenom', $prenom);
        $cmd->bindValue('id', $id);
        $cmd->bindValue('mdp', $mdp);
        $cmd->bindValue('mdpSha1', $mdpSha1);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function ajoutBesoins($num, $jour, $hDeb,$hFin, $activite, $freq, $jourException, $heureSem)
    {
        
        $req="INSERT INTO besoinsfamille(numero_famille,jour, exception, heureDebut, heureFin, activite, frequence, heureSemaine)
        VALUES (:num,:jour,:jourException,:heureDebut,:heureFin,:activite,:frequence,:heureSem);";

        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->bindValue('jour', $jour);
        $cmd->bindValue('jourException', $jourException);
        $cmd->bindValue('heureDebut', $hDeb);
        $cmd->bindValue('heureFin', $hFin);
        $cmd->bindValue('activite', $activite);
        $cmd->bindValue('frequence', $freq);
        $cmd->bindValue('heureSem', $heureSem);
        $cmd->execute();
        $cmd->closeCursor();
    }
    
    public function ajoutDispo($num, $jour, $hDeb,$hFin, $activite,$freq)
    {
        
        $req="INSERT INTO disponibilitesintervenants(numero_Intervenant,jour,heureDebut,heureFin,activite,frequence) VALUES (:num,:jour,:heureDebut,:heureFin,:activite,:frequence,:dateModif);";

        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->bindValue('jour', $jour);
        $cmd->bindValue('heureDebut', $hDeb);
        $cmd->bindValue('heureFin', $hFin);
        $cmd->bindValue('activite', $activite);
        $cmd->bindValue('frequence', $freq);
        $cmd->execute();
        $cmd->closeCursor();
    }

    public function ajoutDispoCandidat($num, $jour, $hDeb,$hFin, $activite,$freq)
    {
        $req="INSERT INTO disponibilitesintervenants(numero_Candidat,jour,heureDebut,heureFin,activite,frequence) VALUES (:num,:jour,:heureDebut,:heureFin,:activite,:frequence);";

        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->bindValue('jour', $jour);
        $cmd->bindValue('heureDebut', $hDeb);
        $cmd->bindValue('heureFin', $hFin);
        $cmd->bindValue('activite', $activite);
        $cmd->bindValue('frequence', $freq);
        $cmd->execute();
        $cmd->closeCursor();
    }











    /*modif tarif*/
    public function modifTar($tarAModif, $libelleTar, $montantTar) {
        $req="update tarifs set libelle_Tarifs=:libelleTar, montant_Tarifs=:montantTar where id_Tarifs=:tarAModif";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('libelleTar', $libelleTar);
        $cmd->bindValue('montantTar', $montantTar);
        $cmd->bindValue('tarAModif', $tarAModif);
        $cmd->execute();
        $cmd->closeCursor();
    }
    /*ajouter tarif*/
    public function ajoutTar($libelleTar,$montantTar){
        $req="insert into tarifs (libelle_Tarifs, montant_Tarifs) values (:libelleTar, :montantTar)";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('libelleTar', $libelleTar);
        $cmd->bindValue('montantTar', $montantTar);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function suppTar($tarASupp)
    {
        $req="delete from tarifs where id_Tarifs=:tarASupp";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('tarASupp', $tarASupp);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function supEntretien($numSal)
    {
        $req="delete from entretiens where numSalarie_Intervenants=:numSal order by date desc limit 1";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numSal', $numSal);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function PlaceOuNon($num){
        $req="SELECT count(*) from proposer where numSalarie_Intervenants=:num and (dateFin_Proposer>now() or dateFin_Proposer='0000-00-00')";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['count(*)'];
        if ($lignes>0){$res=1;} else { $res=0;}
        return $res;
    }
    /*archive*/
    public function obtenirListeSalarieArchive($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=1 and I.numSalarie_Intervenants in (SELECT numSalarie_Intervenants from proposer) GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }

    public function obtenirListeSalarieArchiveTous($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=1 GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    /*menage*/
     public function obtenirListeSalarieMenage($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats join proposer as P on P.numSalarie_Intervenants=I.numSalarie_Intervenants where I.archive_Intervenants=0 and I.numSalarie_Intervenants in (SELECT numSalarie_Intervenants from proposer where idPresta_Prestations='MENA' and (dateFin_Proposer<date(now()) or dateFin_Proposer<>'0000-00-00')) and TravailVoulu_Candidats NOT LIKE 'ENFANT' GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    /*garde enfant*/
    public function obtenirListeSalarieGE($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats join proposer as P on I.numSalarie_Intervenants=P.numSalarie_Intervenants where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 and P.numSalarie_Intervenants in (SELECT numSalarie_Intervenants from proposer where idPresta_Prestations='ENFA' and (dateFin_Proposer<date(now()) or dateFin_Proposer<>'0000-00-00')) and TravailVoulu_Candidats NOT LIKE 'MENAGE' GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    /*ménage non placé*/
    public function obtenirListeSalarieMenageNP($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants<>1 and I.numSalarie_Intervenants not in (SELECT numSalarie_Intervenants from proposer where idPresta_Prestations='MENA' and (dateFin_Proposer<date(now()) or dateFin_Proposer<>'0000-00-00')) and TravailVoulu_Candidats NOT LIKE 'ENFANT' GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    /*garde enfant non placé*/
    public function obtenirListeSalarieGENP($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=0 AND I.numSalarie_Intervenants not in (SELECT numSalarie_Intervenants from proposer where idPresta_Prestations='ENFA' and (dateFin_Proposer<date(now()) or dateFin_Proposer<>'0000-00-00')) and TravailVoulu_Candidats NOT LIKE 'MENAGE' GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    /*archives non placé*/
     public function obtenirListeSalarieArchiveNonPlace($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=1 and I.numSalarie_Intervenants not in (SELECT numSalarie_Intervenants from proposer) GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    public function modePaiement($num){
        $req="SELECT modePaiement_Famille from famille where numero_Famille=:num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $res=$cmd->fetch();
        $cmd->closeCursor();
        $res=$res['modePaiement_Famille'];
        return $res;
    }
    public function updatemodePaiement($num, $modePaiement){
        $req="update famille set modePaiement_Famille=:modePaiement where numero_Famille=:num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->bindValue('modePaiement', $modePaiement);
        $cmd->execute();
        $cmd->closeCursor();
    }
    /*
    Retourne tous les détails concernant un salarié de chaudoudoux
    @return array tableau contenant les détails d'un salarié
    */
    public function obtenirDetailsSalarie($num){
        $req = "SELECT distinct C.*, I.*, Prop.*, P.* from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats left join proposer as Prop on Prop.numSalarie_Intervenants = I.numSalarie_Intervenants left join prestations as P on P.idPresta_Prestations = Prop.idPresta_Prestations where I.numSalarie_Intervenants = ?;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num);
        $cmd->execute();
        $ligne = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;
    }
	
    public function obtenirPrestaSalarie($num) {
		$req = "SELECT DISTINCT type_Prestations FROM prestations as P JOIN proposer as Prop ON P.idPresta_Prestations=Prop.idPresta_Prestations JOIN intervenants as I ON Prop.numSalarie_Intervenants=I.numSalarie_Intervenants WHERE I.numSalarie_Intervenants= ?;";
		$cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num);
        $cmd->execute();
        $ligne = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;
	}
	
    /*$num, $titre, $nom, $prenom, $idSalarie, $adresse, $cp, $ville, 
                            $quartier, $telPort, $telFixe, $telUrg, $email, $statutPro, $diplomes,
                            $qualifs, $expBBmoins1a, $enfantHand, $permis, $vehicule, $dispo, $observ, 
                            $dateEntree, $dateSortie, $certifs, $tauxH, $rechCompl, $nbHeureSem, $nbHeureMois,
                            $psc1, $justifs, $sitFam, $certif*/
    public function modifierDetailsSalarie($num, $archive, $titre, $nom, $prenom, $idSalarie, $adr, $cp, $ville, $quart, $telPort, $telFixe, $TelUrg, $email, $statutPro, $diplome, $qualifs, $expBB1a, $enfHand, $permis, $vehicule, $dispo, $observ, $dateEntree, $dateSortie, $certifs, $tauxH, $rechComplH, $nbhSem, $nbhMois, $psc1, $justifs, $sitFam, $certif,$suivi,$statutHandicap,$dateTS,$NSS,$LieuNaiss,$PaysNaiss,$Natio,$repassage, $secteurCandidat) {
        $datemodif = date('r'); 
        $req = "UPDATE candidats set titre_Candidats=:titre, nom_Candidats=:nom, prenom_Candidats=:prenom, adresse_Candidats = :adr,
         cp_Candidats = :cp, ville_Candidats = :ville, Quartier_Candidats = :quart, telPortable_Candidats= :telPort,
          telFixe_Candidats = :telFixe, TelUrg_Candidats = :TelUrg, email_Candidats = :email, statutPro_Candidats = :statutPro,
           statutHandicap_Candidats = :statutHandicap, dateTitreSejour = :dateTS, diplomes_Candidats = :diplome,
            qualifications_Candidats = :qualifs, expBBmoins1a_Candidats = :expBB1a, enfantHand_Candidats = :enfHand,
             disponibilites_Candidats = :dispo, observations_Candidats = :observ, permis_Candidats = :permis,
              vehicule_Candidats = :vehicule, situationFamiliale_Candidats=:sitFam, numSS_Candidats = :NSS,
               lieuNaiss_Candidats=:LieuNaiss, paysNaiss_Candidats=:PaysNaiss, nationalite_Candidats=:Natio,
               secteur_Candidats =:secteur
                where numCandidat_Candidats in (SELECT candidats_numcandidat_candidats from intervenants 
                where numSalarie_intervenants = :numSalarie1); ";
        /* 
        en laissant le code, le date('r') crée des espaces qui seront compris par mysql 
        comme faisant partie de la requête Sql alors que c'est une valeur,il manquait également une virgule.

        $req.= "UPDATE intervenants set idSalarie_Intervenants=:idSalarie, dateModif_Intervenants=".date('r').",
         archive_Intervenants=:archive, Certifications_Intervenants=:certif (ici) dateEntree_Intervenants = :dateEntree,
          dateSortie_Intervenants = :dateSortie,  Certification_Intervenants = :certifs, tauxH_Intervenants = :tauxH,
           rechCompl_Intervenants = :rechComplH, suivi_Intervenants=:suivi,nbHeureSem_Intervenants = :nbhSem,
            nbHeureMois_Intervenants = :nbhMois, ProposerPSC1_Intervenants = :psc1,
             justificatifs_Intervenants = :justifs where numSalarie_Intervenants = :numSalarie2; ";
        */
        $req.= "UPDATE intervenants set idSalarie_Intervenants=:idSalarie,
         dateModif_Intervenants=:datemodification, archive_Intervenants=:archive,
          Certification_Intervenants=:certif, dateEntree_Intervenants = :dateEntree,
           dateSortie_Intervenants = :dateSortie,  Certification_Intervenants = :certifs,
            tauxH_Intervenants = :tauxH, rechCompl_Intervenants = :rechComplH, suivi_Intervenants=:suivi,
            nbHeureSem_Intervenants = :nbhSem, nbHeureMois_Intervenants = :nbhMois, ProposerPSC1_Intervenants = :psc1,
             justificatifs_Intervenants = :justifs where numSalarie_Intervenants = :numSalarie2; ";

        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue("nom",$nom);
        $cmd->bindValue("suivi", $suivi);
        $cmd->bindValue("prenom",$prenom);
        $cmd->bindValue("certif", $certif);
        $cmd->bindValue("archive", $archive);
        $cmd->bindValue("adr", $adr);
        $cmd->bindValue("titre", $titre);
        $cmd->bindValue("cp", $cp);
        $cmd->bindValue("ville", $ville);
        $cmd->bindValue("quart", $quart);
        $cmd->bindValue("telPort", $telPort);
        $cmd->bindValue("telFixe", $telFixe);
        $cmd->bindValue("TelUrg", $TelUrg);
        $cmd->bindValue("email", $email);
        $cmd->bindValue("statutPro", $statutPro);
        $cmd->bindValue("statutHandicap", $statutHandicap);
        $cmd->bindValue("dateTS", $dateTS);
        $cmd->bindValue("diplome", $diplome);
        $cmd->bindValue("qualifs", $qualifs);
        $cmd->bindValue("expBB1a", $expBB1a);
        $cmd->bindValue("enfHand", $enfHand);
        $cmd->bindValue("dispo", $dispo);
        $cmd->bindValue("observ", $observ);
        $cmd->bindValue("permis", $permis);
        $cmd->bindValue("vehicule", $vehicule);
        $cmd->bindValue("numSalarie1", $num);
        $cmd->bindValue("idSalarie", $idSalarie);
        $cmd->bindValue("datemodification", $datemodif);
        $cmd->bindValue("dateEntree", $dateEntree);
        $cmd->bindValue("dateSortie", $dateSortie);
        $cmd->bindValue("certifs", $certifs);
        $cmd->bindValue("tauxH", $tauxH);
        $cmd->bindValue("rechComplH", $rechComplH);
        $cmd->bindValue("nbhSem", $nbhSem);
        $cmd->bindValue("nbhMois", $nbhMois);
        $cmd->bindValue("psc1", $psc1);
        $cmd->bindValue("justifs", $justifs);
        $cmd->bindValue("numSalarie2", $num);
	    $cmd->bindValue("sitFam", $sitFam);
        $cmd->bindValue("NSS", $NSS);
        $cmd->bindValue("LieuNaiss", $LieuNaiss); 
        $cmd->bindValue("PaysNaiss", $PaysNaiss); 
        $cmd->bindValue("Natio", $Natio);
        $cmd->bindValue("secteur", $secteurCandidat);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function candidatRefuse ($num, $raison)
    {
            $req = "UPDATE candidats set candidatureRetenue_Candidats=:raison where numCandidat_Candidats=:num;";
            $cmd = $this->monPdo->prepare($req);
            $cmd->bindValue('raison', $raison);
            $cmd->bindValue('num', $num);
            $cmd->execute();
            $cmd->closeCursor();
    }
    public function obtenirDetailFact($num)
    {
        $req="SELECT * from factures where idFact_Factures=:num";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $laFacture=$cmd->fetch(PDO::FETCH_ASSOC);
        
        $cmd->closeCursor();
        return $laFacture;
    }
    public function nouveauSalarie($num, $idSalarie, $dateEntree, $dateSortie, $archive, $rechCompl, $certif, $tauxH, $psc1, $justif,$repassage){
            $req = "UPDATE candidats set candidatureRetenue_Candidats='Accepté' where numCandidat_Candidats=:num;";
            $cmd = $this->monPdo->prepare($req);
            $cmd->bindValue('num', $num);
            $cmd->execute();
            $req= "INSERT into intervenants (dateEntree_Intervenants, candidats_numcandidat_candidats,idSalarie_Intervenants, dateSortie_Intervenants, archive_Intervenants, Certification_Intervenants, tauxH_Intervenants, rechCompl_Intervenants, proposerPSC1_Intervenants, justificatifs_Intervenants, dateModif_Intervenants,repassage_Intervenants)"
                    . " VALUES (:dateEntree, :num, 'XXX', :dateSortie, :archive, :certif, :tauxH, :rechCompl, :psc1, :justif,'".date('r')."',:repassage);";
            $cmd = $this->monPdo->prepare($req);
            if (is_null($archive))
            {
            $archive=0;
            }
            $cmd->bindValue('dateEntree', $dateEntree);
            $cmd->bindValue('dateSortie', $dateSortie);
            $cmd->bindValue('archive', $archive);
            $cmd->bindValue('certif', $certif);
            $cmd->bindValue('tauxH', $tauxH);
            $cmd->bindValue('rechCompl', $rechCompl);
            $cmd->bindValue('dateEntree', $dateEntree);
            $cmd->bindValue('justif', $justif);
            $cmd->bindValue('psc1', $psc1);
            $cmd->bindValue('num', $num);
            $cmd->bindValue('repassage', $repassage);
            $cmd->execute();
            $cmd->closeCursor();
        }
    
    public function UpdateDispoIntervenantCandidat($num){
        //Récupérarion du numéro d'intervenant du candidat qui viens d'être accépté
        $req="SELECT numSalarie_Intervenants FROM intervenants WHERE candidats_numcandidat_candidats=:num ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        //var_dump($res);
        //On ajout le numéro d'intervenant dans la table des disponibilités
        $req="UPDATE disponibilitesintervenants SET numero_Intervenant=:numInterv WHERE numero_Candidat=:num;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numInterv', $res[0]['numSalarie_Intervenants']);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $cmd->closeCursor();
    }




    public function recupererNumInterv($nom, $prenom) {
        $req = "SELECT numSalarie_Intervenants from intervenants join candidats on candidats_numcandidat_candidats=numCandidat_Candidats where upper(nom_Candidats) like %:nom% and upper(prenom_Candidats) like %:prenom%;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue("nom", $nom);
        $cmd->bindValue("prenom", $prenom);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    public function recupererNumFam($nom, $prenom) {
        $req = "SELECT famille.numero_Famille from famille join parents on parents.numero_Famille=famille.numero_Famille where upper(parents.nom_Parents) like '%:nom%' and upper(parents.prenom_Parents) like '%:prenom%' ";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue("nom", $nom);
        $cmd->bindValue("prenom", $prenom);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    public function trouverMailCandidat($num)
    {
        $req="SELECT email_Candidats from candidats where numCandidat_Candidats=:num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue("num", $num);
        $cmd->execute();
        $res=$cmd->fetchAll(PDO::FETCH_COLUMN);
        $cmd->closeCursor();
        $res=$res[0];
        return $res;
    }
    public function suppFact($num)
    {
        $req="DELETE FROM factures where idFact_Factures=:num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue("num",$num);
        $cmd->execute();
        $cmd->closeCursor();
               
    }
    public function modifFact($num,  $montant)
    {
        $req="update factures set montantFact_Factures=:montant where idFact_Factures=:num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->bindValue('montant', $montant);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function obtenirNbEntree(){
        $req = "SELECT count(*) from famille where month(dateEntree_Famille)=month(now()) AND year(dateSortie_Famille)=year(now())";
        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $nb=$cmd->fetch();
        $nb=$nb['count(*)'];
        $cmd ->closeCursor();
        return $nb;
    }
    public function obtenirNbSorties(){
        $req = "SELECT count(*) from famille where month(dateSortie_Famille)=month(now()) AND year(dateSortie_Famille)=year(now())";
        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $nb=$cmd->fetch();
        $nb=$nb['count(*)'];
        $cmd ->closeCursor();
        return $nb;
    }

    public function selectIntervenant($numFamille,$jour,$hDebut,$hFin){
        $req="select * from proposer where hDeb_Proposer=':hDebut' AND hFin_Proposer= ':hFin' AND jour_Proposer=':jour';";
        
    }
    
    public function attributionIntervFamille($numFam, $numInterv, $presta, $idADH, $options, $dateDeb,$dateFin, $modalites, $jour, $Hdeb, $Hfin, $validFam, $validInterv,$freq)
    {
        $req="Insert into proposer (Statut_Proposer, numSalarie_Intervenants, numero_Famille, idPresta_Prestations, idADH_TypeADH, options_Proposer, dateDeb_Proposer, dateFin_Proposer, modalites_Proposer, jour_Proposer, hDeb_Proposer, hFin_Proposer, dateModif_Proposer, validFamille_Proposer, validInterv_Proposer, frequence_Proposer)"
                . " Values ('Non effectué', :numInterv, :numFam, :presta, :idADH, :options, :dateDeb, :dateFin, :modalites, :jour, :Hdeb, :Hfin,now(), :validFam, :validInterv, :freq)";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue("numInterv", $numInterv);
        $cmd->bindValue('freq', $freq);
        $cmd->bindValue("validFam", $validFam);
        $cmd->bindValue("validInterv", $validInterv);
        $cmd->bindValue("modalites", $modalites);
        $cmd->bindValue("jour", $jour);
        $cmd->bindValue("Hdeb", $Hdeb);
        $cmd->bindValue("Hfin", $Hfin);
        $cmd->bindValue("numFam", $numFam);
        $cmd->bindValue("Hdeb", $Hdeb);
        $cmd->bindValue("Hfin", $Hfin);
        $cmd->bindValue("modalites", $modalites);
        $cmd->bindValue("presta", $presta);
        $cmd->bindValue("idADH", $idADH);
        $cmd->bindValue("options",$options);
        $cmd->bindValue("dateDeb",$dateDeb);
        $cmd->bindValue("dateFin",$dateFin);
        $cmd->execute();
        $cmd->closeCursor();
    }




    //ensemble des fonctions relatives aux familles



    /*
    Retourne l'ensemble des familles adhérentes à chaudoudoux
    @return array tableau listant 
    */
    public function attribuerForm($numSal, $numForm)
    {
        $req= "insert into suivre values (:numForm, :numSal) ";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numForm', $numForm);
        $cmd->bindValue('numSal', $numSal);
        $cmd->execute();
        $cmd->closeCursor();
    }
    
    public function obtenirListeForm(){
        $req="SELECT DISTINCT * from formations where type_Formations='PRESTATAIRE'";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function obtenirFormSuivi($numForm, $numSal){
        $req="SELECT DISTINCT * from suivre where idForm_Formations = :numForm AND numSalarie_Intervenants = :numSal";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numForm', $numForm);
        $cmd->bindValue('numSal', $numSal);
        $cmd->execute();
        $lignes = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    

    /*  
    Renvoie un tableau contenant les listes des candidats ayant réalisé une formation (passée en paramètre)
    */
    public function obtenirListeFormIndividu($num){
        $req="SELECT idForm_Formations, nom_Candidats, prenom_Candidats
        from suivre, candidats
        where idForm_Formations = :num 
        AND candidats.numCandidat_Candidats = suivre.numSalarie_Intervenants";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    /*
    SIMON
    */
    public function obtenirListeFormIndividuV2($num){ 
        $req="SELECT intervenants.numSalarie_Intervenants, intervenants.idSalarie_Intervenants, suivre.idForm_Formations, candidats.nom_Candidats, candidats.prenom_Candidats
        from intervenants
        join suivre on intervenants.numSalarie_Intervenants = suivre.numSalarie_Intervenants AND idForm_Formations = :num
        join candidats on intervenants.numSalarie_Intervenants = candidats.numCandidat_Candidats ;";

        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    //Théo
    public function obtenirListeFormIndividuV3($num){ 
        $req="SELECT intervenants.numSalarie_Intervenants, intervenants.idSalarie_Intervenants, suivre.idForm_Formations, candidats.nom_Candidats, candidats.prenom_Candidats
        FROM intervenants
        JOIN suivre ON intervenants.numSalarie_Intervenants = suivre.numSalarie_Intervenants AND idForm_Formations = :num
        JOIN candidats ON intervenants.candidats_numcandidat_candidats  = candidats.numCandidat_Candidats ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }




    /* 
    Renvoie le nom de la formation en fonction du numéro renseigné
    */
    public function obtenirNomFormation($num){
        $req="SELECT intitule_Formations
        from formations
        where idForm_Formations = :num";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function uneForm($num){
        $req="SELECT DISTINCT * from formations where idForm_Formations=:num";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
    public function modifForm($nom,$duree,$desc,$orga,$rem,$type,$num){
        $req="update formations set intitule_Formations=:nom, duree_Formations=:duree, description_Formations=:desc, organisme_Formations=:orga, remuneration_formation=:rem, type_Formations=:type where idForm_Formations=:num";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->bindValue('nom', $nom);
        $cmd->bindValue('duree', $duree);
        $cmd->bindValue('desc', $desc);
        $cmd->bindValue('orga', $orga);
        $cmd->bindValue('rem', $rem);
        $cmd->bindValue('type', $type);
        $cmd->execute();
        $cmd->closeCursor();
    }
        public function obtenirListeFormM(){
        $req="SELECT DISTINCT * from formations where type_Formations='MANDATAIRE'";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
    public function finArretAVenir(){
        $res=false;
        $req="SELECT count(*) from intervenants where ArretTravail_Intervenants=1 and month(dateFinArret_Intervenants)=month(now())";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetch();
        if ($lignes ['count(*)']>0){$res=true;}
        $cmd->closeCursor();
        return $res; 
    }
        public function obtenirListeFormSELECT($num){
        $req="SELECT DISTINCT * from formations where idForm_Formations not in (SELECT suivre.idForm_Formations from suivre where numSalarie_Intervenants=:num)";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    
    /* Permet d'obtenir la liste des entretiens personnels pour chaque intervenantes en fonction de $num
    */ 
    public function obtenirListeEntretiens($num){
        $req="SELECT *, DATE_FORMAT(`date`, '%d/%m/%Y') AS date_formater from entretiens WHERE numSalarie_Intervenants = :num ORDER BY date_formater DESC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    /* Permet d'obtenir la liste des entretiens en fonction de professionnel
    ou individuel en fonction de $num
    */ 
    public function listeEntretiensGlobal($num){
        $req="SELECT intervenants.idSalarie_Intervenants, entretiens.numSalarie_Intervenants, titre_Candidats, nom_Candidats, prenom_Candidats, pro, GROUP_CONCAT(DATE_FORMAT(`date`, '%d/%m/%Y') ORDER BY `date` DESC SEPARATOR ', ') AS dates, commentaire FROM candidats
        JOIN intervenants
        ON intervenants.candidats_numcandidat_candidats = candidats.numCandidat_Candidats
        JOIN entretiens
        ON intervenants.numSalarie_Intervenants = entretiens.numSalarie_Intervenants
        WHERE pro = :num GROUP BY prenom_Candidats
        ORDER BY dates DESC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function listeEntretiensTousFusion(){
        $req="SELECT intervenants.idSalarie_Intervenants, entretiens.numSalarie_Intervenants, titre_Candidats, nom_Candidats, prenom_Candidats,
        GROUP_CONCAT(DISTINCT IF(pro = 1, DATE_FORMAT(`date`, '%d/%m/%Y'), NULL) ORDER BY `date` DESC SEPARATOR ', ') AS dates_pro, 
        GROUP_CONCAT(DISTINCT IF(pro = 0, DATE_FORMAT(`date`, '%d/%m/%Y'), NULL) ORDER BY `date` DESC SEPARATOR ', ') AS dates_indiv
        FROM candidats JOIN intervenants
        ON intervenants.candidats_numcandidat_candidats = candidats.numCandidat_Candidats
        JOIN entretiens
        ON intervenants.numSalarie_Intervenants = entretiens.numSalarie_Intervenants
        GROUP BY prenom_Candidats
        ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function obtenirPresta($num){
        $req = "SELECT distinct type_Prestations, intitule_TypeADH from proposer join prestations on proposer.idPresta_Prestations=prestations.idPresta_Prestations join typeadh on proposer.idADH_TypeADH=typeadh.idADH_TypeADH where numero_Famille=:num and (dateFin_Proposer>now() or dateFin_Proposer='0000-00-00')"; 
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num',$num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
    public function obtenirADH($num){
        $req = 'SELECT distinct from proposer  where numero_Famille=:num'; 
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num',$num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
    public function obtenirCreneaux($num)/*travail*/
    {
        $req="SELECT distinct proposer.* from proposer 
        left join famille on famille.numero_Famille=proposer.numero_Famille 
        left join parents on parents.numero_Famille=famille.numero_Famille 
        where (dateFin_Proposer > now() or dateFin_Proposer='0000-00-00') and numSalarie_Intervenants=:numInterv";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numInterv', $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
    public function obtenirModalites($numFam, $numSal, $idADH,$idPresta, $hDeb,$dateDeb, $jour){
        $req="SELECT modalites_Proposer from proposer where numero_Famille=:numFam and numSalarie_Intervenants=:numSal and idADH_TypeADH=:idADH and idPresta_Prestations=:idPresta and hDeb_Proposer=:hDeb and dateDeb_Proposer=:dateDeb and jour_Proposer=:jour";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numSal', $numSal);
        $cmd->bindValue('numFam', $numFam);
        $cmd->bindValue('idADH', $idADH);
        $cmd->bindValue('idPresta', $idPresta);
        $cmd->bindValue('hDeb', $hDeb);
        $cmd->bindValue('dateDeb', $dateDeb);
        $cmd->bindValue('jour', $jour);
        $cmd->execute();
        $ligne=$cmd->fetch();
        $cmd->closeCursor();
        $ligne=$ligne['modalites_Proposer'];
        return $ligne;
    }
    /*idPresta/dateDeb/numFam*/
    public function ModifIntervention($idPresta,$dateDeb,$numSalAncien,$idADHAncien,$dateDebAncien,$jourAncien,$hDebAncien,$numSal,$numFam,$idADH,$hDeb,$hFin,$jour,$dateFin, $modalites,$freq) {
        $req="UPDATE proposer SET idPresta_Prestations=:idPresta_Prestations, DateDeb_Proposer=:dateDeb, modalites_Proposer=:modalites, dateModif_Proposer=now(), numSalarie_Intervenants=:numSal, numero_Famille=:numFam, idADH_TypeADH=:idADH, hDeb_Proposer=:hDeb, hFin_Proposer=:hFin, jour_Proposer=:jour, dateFin_Proposer=:dateFin ,frequence_Proposer=:freq where numSalarie_Intervenants=:numSalAncien and hDeb_Proposer=:hDebAncien and idADH_TypeADH=:idADHAncien and jour_Proposer=:jourAncien and dateDeb_Proposer=:dateDebAncien";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numSalAncien', $numSalAncien); /*OK*/
        $cmd->bindValue('hDebAncien',$hDebAncien); /*OK*/
        $cmd->bindValue('modalites', $modalites);
        $cmd->bindValue('idADHAncien', $idADHAncien);  /*OK*/
        /* $cmd->bindValue('idPrestaAncien', $idPrestaAncien); /* Pourquoi utiliser l'ancien id prestation? */
        $cmd->bindValue('dateDebAncien', $dateDebAncien); /*OK*/
        $cmd->bindValue('jourAncien', $jourAncien);  /*OK*/
        $cmd->bindValue('numSal', $numSal);
        $cmd->bindValue('numFam', $numFam);
        $cmd->bindValue('idADH', $idADH);
        $cmd->bindValue('hDeb', $hDeb);
        $cmd->bindValue('hFin', $hFin);
        $cmd->bindValue('jour', $jour);
        $cmd->bindValue('dateFin', $dateFin);
        $cmd->bindValue('dateDeb', $dateDeb);
        $cmd->bindValue('idPresta_Prestations', $idPresta); /* Modification du champ */
        $cmd->bindValue('freq', $freq); /* Modification impossible du champ freq car il faut revoir le calcul du nombre d'heures par semaine (voir v_annuInterv - ligne 128) */

        $cmd->execute();
        $cmd->closeCursor();
    }
    public function obtenirCreneauxFam($numFam)
    {
        $req="SELECT distinct proposer.* from proposer left join famille on famille.numero_Famille=proposer.numero_Famille 
        left join parents on parents.numero_Famille=famille.numero_Famille where (dateFin_Proposer >'".date('Y-m-d')."' 
        or dateFin_Proposer='0000-00-00') and numSalarie_Intervenants=99999 and proposer.numero_Famille=:numFam";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numFam', $numFam);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
    public function obtenirPM($numFam)
    {
        $req="SELECT PM_Famille from famille where numero_Famille=:numFam";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numFam', $numFam);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['PM_Famille'];
        return $lignes; 
    }
        public function obtenirPGE($numFam)
    {
        $req="SELECT PGE_Famille from famille where numero_Famille=:numFam";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numFam', $numFam);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['PGE_Famille'];
        return $lignes; 
    }
    public function obtenirMoisSuivant()
    {
        
        $req= "SELECT * from famille join proposer on proposer.numero_Famille=famille.numero_Famille 
        where idADH_TypeADH='MAND' and idPresta_Prestations='ENFA' ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        foreach ($lignes as $ligne)
        {
            $numFam=$ligne['numero_Famille'];
            $req="SELECT count(*) from factures where numero_Famille='".$numFam."'";
            $cmd = $this->monPdo->prepare($req);
            $cmd->execute();
            $res = $cmd->fetch(PDO::FETCH_ASSOC);
            if ($res['count(*)']==0){
            $req="insert into factures (idFact_Factures, montantFact_Factures, encaisse_Factures,
             montantEnc_Factures,dateFact_Factures, numero_Famille, modePaiement_Facture) values"
            . "(null, null, 0,0, now(), '".$numFam."', 'NC');";

            $cmd = $this->monPdo->prepare($req);
            $cmd->execute();
            }
        }
        $req="update factures set encaisse_Factures = 0;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function obtenirNomFamille($num)/*Vincent intérêt*/
    {
        $req="SELECT group_concat(nom_Parents separator ' ') as nomFam from parents 
        where numero_Famille=:num group by numero_Famille order by nom_Parents asc";

        $cmd=$this->monPdo->prepare($req);
        $cmd ->bindValue('num', $num);
        $cmd->execute();
        $fam=$cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        if( is_array($fam) ) {
            $fam=$fam['nomFam'];
        }
        if (substr($fam, 0, strrpos($fam, ' '))== substr($fam, strrpos($fam, ' ')+1)){
            $fam=substr($fam, 0, strrpos($fam, ' '));
        }
        if (substr($fam, 0, strrpos($fam, ' '))== substr($fam, strrpos($fam, ' ')+1)){
            $fam=substr($fam, 0, strrpos($fam, ' '));
        }
        for ($i=50; $i>1; $i--){
            if (substr($fam, 0, $i)== substr($fam, $i+1)){
            $fam=substr($fam, 0, $i);}
        }
        return $fam;
                
    }
    public function obtenirFamilleActuelle($num){
        $req= "SELECT distinct numero_Famille from proposer where numSalarie_Intervenants=:num 
        and numero_Famille != 9999 and (dateFin_Proposer='0000-00-00' or dateFin_Proposer>date(now()))";

        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $famille=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $famille;
    }
    public function obtenirFamilleActuelleMAND($num){
        $req= "SELECT distinct numero_Famille from proposer where numSalarie_Intervenants=:num 
        and idADH_TypeADH='MAND' and numero_Famille != 9999 and (dateFin_Proposer='0000-00-00' or dateFin_Proposer>date(now()))";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $famille=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $famille;
    }
    public function obtenirFamilleActuellePREST($num){
        $req= "SELECT distinct numero_Famille from proposer where numSalarie_Intervenants=:num 
        and idADH_TypeADH='PREST' and numero_Famille != 9999 and (dateFin_Proposer='0000-00-00' or dateFin_Proposer>date(now()))";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $famille=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $famille;
    }
    public function obtenirIntervFam($numI, $numF,$dateDeb,$dateFin)/*travail*/
    {
        $req="SELECT distinct * from proposer where numSalarie_Intervenants=:numI 
        and numero_Famille=:numF and (dateFin_Proposer>=date(now()) or dateFin_Proposer='0000-00-00') 
        and dateDeb_Proposer=:dateDeb and dateFin_Proposer=:dateFin";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numI', $numI);
        $cmd->bindValue('numF', $numF);
        $cmd->bindValue('dateDeb', $dateDeb);
        $cmd->bindValue('dateFin', $dateFin);
        $cmd->execute();
        $lignes=$cmd->fetchAll(pdo::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;

    }
        public function obtenirIntervFamPasse($numI, $numF, $dateDeb, $dateFin)
    {
        $req="SELECT distinct * from proposer where numSalarie_Intervenants=:numI and numero_Famille=:numF 
        and dateFin_Proposer<now() and dateDeb_Proposer=:dateDeb and dateFin_Proposer=:dateFin";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numI', $numI);
        $cmd->bindValue('numF', $numF);
        $cmd->bindValue('dateDeb', $dateDeb);
        $cmd->bindValue('dateFin', $dateFin);
        $cmd->execute();
        $lignes=$cmd->fetchAll(pdo::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;

    }
    public function obtenirListeInterv($an)
    {
        $req="SELECT distinct proposer.numSalarie_Intervenants, proposer.idPresta_Prestations, proposer.idADH_TypeADH, proposer.options_Proposer"
                . ", proposer.dateDeb_Proposer, proposer.dateFin_Proposer, proposer.Statut_Proposer, proposer.modalites_Proposer, proposer.validInterv_Proposer,"
                . "proposer.validFamille_Proposer, proposer.hDeb_Proposer, proposer.hFin_Proposer, proposer.jour_Proposer, proposer.dateModif_Proposer"
                . " ,nom_Candidats, intitule_TypeADH, proposer.numero_Famille, type_Prestations from proposer"
                . " join prestations on proposer.idPresta_Prestations=prestations.idPresta_Prestations"
                . " join typeadh on typeadh.idADH_TypeADH=proposer.idADH_TypeADH "
                . "join intervenants on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants "
                . "join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numcandidat_candidats"
                . " join famille on famille.numero_Famille=proposer.numero_Famille "
                . "join parents on parents.numero_Famille=famille.numero_Famille "
                . "where YEAR(DateFin_Proposer)=:an or DateFin_Proposer='0000-00-00' order by Statut_Proposer desc, nom_Parents asc;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('an', $an);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
        
    }
        public function validInterv( $validFam, $validInterv, $statut, $idPresta, $numSal, $numFam, $idADH, $jour, $hDeb)
    {
        $req="update proposer set validInterv_Proposer=:validInterv , validFamille_Proposer=:validFam, Statut_Proposer=:statut where idPresta_Prestations=:idPresta and numSalarie_Intervenants=:numSal and  numero_Famille=:numFam"
                . " and idADH_TypeADH=:idADH and jour_Proposer=:jour and hDeb_Proposer=:hDeb;";
        if ($statut=='Effectué'){ $req.="update proposer set dateFin_Proposer= now() where idPresta_Prestations=:idPresta and numSalarie_Intervenants=:numSal and  numero_Famille=:numFam"
        . " and idADH_TypeADH=:idADH and jour_Proposer=:jour and hDeb_Proposer=:hDeb; ";}
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('validInterv', $validInterv);
        $cmd->bindValue('validFam', $validFam);
        $cmd->bindValue('idPresta', $idPresta);
        $cmd->bindValue('jour', $jour);
        $cmd->bindValue('hDeb', $hDeb);
        $cmd->bindValue('numSal', $numSal);
        $cmd->bindValue('numFam', $numFam);
        $cmd->bindValue('idADH', $idADH);
        $cmd->bindValue('statut', $statut);
        $cmd->execute();
        $cmd->closeCursor();
        
    }
        public function obtenirListeIntervInvalid()
    {
$req="SELECT distinct proposer.numSalarie_Intervenants, proposer.idPresta_Prestations, proposer.idADH_TypeADH, proposer.options_Proposer"
                . ", proposer.dateDeb_Proposer, proposer.dateFin_Proposer, proposer.Statut_Proposer, proposer.modalites_Proposer, proposer.validInterv_Proposer,"
                . "proposer.validFamille_Proposer, proposer.hDeb_Proposer, proposer.hFin_Proposer, proposer.jour_Proposer, proposer.dateModif_Proposer"
                . " ,nom_Candidats, intitule_TypeADH, proposer.numero_Famille, type_Prestations from proposer"
                . " join prestations on proposer.idPresta_Prestations=prestations.idPresta_Prestations"
                . " join typeadh on typeadh.idADH_TypeADH=proposer.idADH_TypeADH "
                . "join intervenants on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants "
                . "join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numcandidat_candidats"
                . " join famille on famille.numero_Famille=proposer.numero_Famille "
                . "join parents on parents.numero_Famille=famille.numero_Famille "
                . " WHERE validInterv_Proposer not like 1 or validFamille_Proposer not like 1 or Statut_Proposer not like 'Effectué' order by nom_Parents asc"  ;
$cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
        
    }
    public function obtenirListeIntervSal($num)
    {
        $req="SELECT distinct type_Prestations, idSalarie_Intervenants, nomJF_Candidats, Statut_Proposer, prestations.idPresta_Prestations, " /*HERE*/
                . "intervenants.numSalarie_Intervenants, proposer.numero_Famille, typeadh.idADH_TypeADH, " /*HERE*/
                . "nom_Candidats, intitule_TypeADH, options_Proposer, dateDeb_Proposer, frequence_Proposer, dateFin_Proposer, "
                . "Statut_Proposer, hDeb_Proposer, hFin_Proposer, jour_Proposer, dateModif_Proposer, modalites_Proposer, "
                . "validInterv_Proposer, validFamille_Proposer from proposer "
                . "join famille on famille.numero_Famille=proposer.numero_Famille "
                . "join parents on parents.numero_Famille=famille.numero_Famille "
                . "join prestations on proposer.idPresta_Prestations=prestations.idPresta_Prestations "
                . "join typeadh on typeadh.idADH_TypeADH=proposer.idADH_TypeADH "
                . "join intervenants on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants "
                . "join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numcandidat_candidats "
                . "where intervenants.numSalarie_Intervenants=:num and (dateFin_Proposer>now() or dateFin_Proposer='0000-00-00') "
                . "order by dateDeb_Proposer desc;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
   
    public function obtenirNomdeFamille($numFamille){
        $req="select nom_Parents from parents where numero_Famille=:numFamille;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numFamille',$numFamille);
        $cmd->execute();
        $ligne=$cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;
    }
        public function obtenirListeIntervFam($num)
    {
        $req="SELECT distinct type_Prestations, Statut_Proposer, prestations.idPresta_Prestations, "
               ." intervenants.numSalarie_Intervenants, idSalarie_Intervenants, nomJF_Candidats,proposer.numero_Famille, typeadh.idADH_TypeADH, "
               ." nom_Candidats, intitule_TypeADH, options_Proposer, dateDeb_Proposer, frequence_Proposer, dateFin_Proposer, "
                ."Statut_Proposer, hDeb_Proposer, hFin_Proposer, jour_Proposer, dateModif_Proposer, modalites_Proposer,"
                ." validInterv_Proposer, validFamille_Proposer from proposer "
               ." join famille on famille.numero_Famille=proposer.numero_Famille "
               ." join prestations on proposer.idPresta_Prestations=prestations.idPresta_Prestations "
              ."  join typeadh on typeadh.idADH_TypeADH=proposer.idADH_TypeADH "
               ." join intervenants on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants "
               ." join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numcandidat_candidats"
              ."  where proposer.numero_Famille=:num and (proposer.dateFin_Proposer>NOW() or proposer.dateFin_Proposer='0000-00-00') order by dateDeb_Proposer desc;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
        public function obtenirPrestaFam($numI, $numF,$dateDeb,$dateFin){
            $req="SELECT distinct intitule_typeADH, frequence_Proposer, type_Prestations from proposer join typeADH on typeADH.idADH_typeADH=proposer.idADH_typeADH join prestations on prestations.idPresta_Prestations=proposer.idPresta_Prestations where numero_Famille=:numF and numSalarie_Intervenants=:numI and dateDeb_Proposer=:dateDeb and dateFin_Proposer=:dateFin";
            $cmd = $this->monPdo->prepare($req);
             $cmd->bindValue('numI', $numI);
             $cmd->bindValue('numF', $numF);
             $cmd->bindValue('dateDeb', $dateDeb);
             $cmd->bindValue('dateFin', $dateFin);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
        }
        public function obtenirPrestaFamPasse($numI, $numF,$dateDeb,$dateFin){
            $req="SELECT distinct intitule_typeADH, frequence_Proposer, type_Prestations from proposer join typeADH on typeADH.idADH_typeADH=proposer.idADH_typeADH join prestations on prestations.idPresta_Prestations=proposer.idPresta_Prestations where numero_Famille=:numF and numSalarie_Intervenants=:numI and dateFin_Proposer<=date(now()) and dateDeb_Proposer=:dateDeb and dateFin_Proposer=:dateFin";
            $cmd = $this->monPdo->prepare($req);
             $cmd->bindValue('numI', $numI);
             $cmd->bindValue('numF', $numF);
             $cmd->bindValue('dateDeb', $dateDeb);
             $cmd->bindValue('dateFin', $dateFin);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
        }
        public function obtenirListeIntervSalPasse($num)
    {
        $req="SELECT distinct type_Prestations, frequence_Proposer, nomJF_Candidats, idSalarie_Intervenants, Statut_Proposer, prestations.idPresta_Prestations, "
                . "intervenants.numSalarie_Intervenants, parents.numero_Famille, typeadh.idADH_TypeADH, nom_Candidats,"
                . " intitule_TypeADH, options_Proposer, dateDeb_Proposer, dateFin_Proposer, Statut_Proposer, hDeb_Proposer,"
                . " hFin_Proposer, jour_Proposer, dateModif_Proposer, modalites_Proposer, validInterv_Proposer,"
                . " validFamille_Proposer from proposer join famille on famille.numero_Famille=proposer.numero_Famille "
                . "join parents on parents.numero_Famille=famille.numero_Famille "
                . "join prestations on proposer.idPresta_Prestations=prestations.idPresta_Prestations "
                . "join typeadh on typeadh.idADH_TypeADH=proposer.idADH_TypeADH "
                . "join intervenants on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants"
                . " join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numcandidat_candidats"
                . " where intervenants.numSalarie_Intervenants=:num and dateFin_Proposer<= now() and dateFin_Proposer <> '0000-00-00'"
                . "order by dateDeb_Proposer desc;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

   
        public function obtenirListeIntervFamPasse($num)
    {
        $req="SELECT distinct type_Prestations, Statut_Proposer, frequence_Proposer, prestations.idPresta_Prestations, "
                . "intervenants.numSalarie_Intervenants,idSalarie_Intervenants,nomJF_Candidats, proposer.numero_Famille, typeadh.idADH_TypeADH, nom_Candidats,"
                . " intitule_TypeADH, options_Proposer, dateDeb_Proposer, dateFin_Proposer, Statut_Proposer, hDeb_Proposer,"
                . " hFin_Proposer, jour_Proposer, dateModif_Proposer, modalites_Proposer, validInterv_Proposer,"
                . " validFamille_Proposer from proposer join famille on famille.numero_Famille=proposer.numero_Famille "
                . "join prestations on proposer.idPresta_Prestations=prestations.idPresta_Prestations "
                . "join typeadh on typeadh.idADH_TypeADH=proposer.idADH_TypeADH "
                . "join intervenants on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants"
                . " join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numcandidat_candidats "
                . "where famille.numero_Famille=:num and dateFin_Proposer<= now() and dateFin_Proposer <> '0000-00-00' "
                . "order by dateDeb_Proposer desc;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
        public function ValidForm($numForm, $numSal, $familleForm){
        $req="Insert into suivre values (:numForm, :numSal, :numfamille)";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numForm', $numForm);
        $cmd->bindValue('numSal', $numSal);
        $cmd->bindValue('numfamille', $familleForm);
        $cmd->execute();
        $cmd->closeCursor();
 
    }
    public function EntretienNUM($numSal){
        $req="SELECT `num` FROM `entretiens` WHERE numSalarie_intervenants = :numSal ORDER BY `num` DESC LIMIT 1";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numSal', $numSal);
        $cmd->execute();
        $EntretienID = $cmd->fetchAll();
        $cmd->closeCursor();
        if( is_array($EntretienID)) {
            if(isset($EntretienID[0])){
                $id = $EntretienID[0]["num"]+1; 
            } else {
                $id = 1;
            }
        } else {
            $id = 1;
        }
        return $id;
    }
    public function ajoutEntretien($numEntretien, $numSal, $dateEntretien, $typeEntretien){ 
        $req="Insert into entretiens (`num`, `numSalarie_intervenants`, `date`, `commentaire`, `pro`) values (:num, :numSal, :date, '', :type)";
        $cmd = $this->monPdo->prepare($req);

        $cmd->bindValue('num', $numEntretien);
        $cmd->bindValue('numSal', $numSal);
        $cmd->bindValue('date', $dateEntretien);
        $cmd->bindValue('type', $typeEntretien);

        $cmd->execute();
        $cmd->closeCursor();
    }
    public function ajoutCommentaire($num, $com, $numSal){
        $req = "UPDATE `entretiens` SET `commentaire`=:com WHERE `num` = :num AND `numSalarie_Intervenants` = :numSal";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('com', $com);
        $cmd->bindValue('num', $num);
        $cmd->bindValue('numSal', $numSal);
        $cmd->execute();
        $cmd->closeCursor();
        }
        
    public function ValidEntretien($numSal, $datePremierEntretien){
        $req="Insert into entretien values (:numero_salarie, :date_entretien)";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numero_salarie', $numSal);
        $cmd->bindValue('date_entretien', $datePremierEntretien);
        $cmd->execute();
        $cmd->closeCursor();
 
    }
    public function ListeFormSal($num){
        $req="SELECT distinct * from formations join suivre on formations.idForm_Formations=suivre.idForm_Formations where numSalarie_Intervenants=:num";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function ajoutForm($nomForm, $dureeForm, $descForm, $orgaForm, $remForm, $typeForm){
        $req="insert into formations values (NULL,:nomForm,:dureeForm,:descForm,:orgaForm,:remForm,:typeForm)";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('nomForm', $nomForm);
        $cmd->bindValue('dureeForm', $dureeForm);
        $cmd->bindValue('descForm', $descForm);
        $cmd->bindValue('orgaForm',$orgaForm);
        $cmd->bindValue('remForm',$remForm);
        $cmd->bindValue('typeForm',$typeForm);
        $cmd->execute();
        $cmd->closeCursor();
    }
        public function SupForm($num){
        $req="delete from formations where idForm_Formations=:num";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function obtenirCoordonneesFam($num)
    {
        //$req="SELECT distinct numAlloc_Famille, aPourvoir_Famille, observations_Famille, modePaiement_Famille,option_Famille, adresse_Famille, cp_Famille, ville_Famille, quartier_Famille, group_concat(email_Parents separator ', ') as mail, telDom_Famille, GROUP_CONCAT(telPortable_Parents SEPARATOR ' / ') as port, dateEntree_Famille, dateSortie_Famille, vehicule_Famille from famille join parents on parents.numero_Famille=famille.numero_Famille where famille.numero_Famille=:num";
        $req="SELECT distinct numAlloc_Famille, aPourvoir_Famille, aPourvoir_PM, Date_aPourvoir_PM, aPourvoir_PGE, Date_aPourvoir_PGE, observations_Famille, modePaiement_Famille,option_Famille, adresse_Famille, cp_Famille, ville_Famille, quartier_Famille, numBus_Famille, arretBus_Famille, /*email_Parents as mail,*/ telDom_Famille, /*telPortable_Parents as port,*/ dateEntree_Famille, dateSortie_Famille, vehicule_Famille from famille join parents on parents.numero_Famille=famille.numero_Famille where famille.numero_Famille=:num";

        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        return $lignes;
    }
    public function trouverProchain($nom){
        $req="SELECT numSalarie_Intervenants from intervenants join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numCandidat_Candidats where nom_Candidats>:nom and archive_Intervenants<>1 order by nom_Candidats asc limit 0,1;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('nom', $nom);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['numSalarie_Intervenants'];
        return $lignes;
        
    }
    public function trouverProchainRechCompl($nom){
        $req="SELECT numSalarie_Intervenants from intervenants join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numCandidat_Candidats where nom_Candidats>:nom and archive_Intervenants<>1 and rechCompl_Intervenants=1 order by nom_Candidats asc limit 0,1;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('nom', $nom);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['numSalarie_Intervenants'];
        return $lignes;
        
    }
    /*lié au bouton planning*/
    public function premierRechCompl(){
        $req="SELECT numSalarie_Intervenants from intervenants join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numCandidat_Candidats where archive_Intervenants<>1 and rechCompl_Intervenants=1 order by nom_Candidats asc limit 0,1;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['numSalarie_Intervenants'];
        return $lignes;
        
    }
    /*lié au bouton planning AFFICHE LE PREMIER SALARIE DE LA BASE ET NON DE LA PAGE*/
    public function premierSal(){
        $req="SELECT numSalarie_Intervenants from intervenants join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numCandidat_Candidats where archive_Intervenants<>1 and numSalarie_Intervenants<>99999 order by nom_Candidats asc limit 0,1;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['numSalarie_Intervenants'];
        return $lignes;
        
    }
    public function trouverProchainFam($nom){
        $req="SELECT famille.numero_Famille from famille join parents on parents.numero_Famille=famille.numero_Famille where concat(nom_Parents)>:nom and archive_Famille<>1 order by group_concat(nom_Parents) asc limit 0,1;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('nom', $nom);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['numero_Famille'];
        return $lignes;
        
    }
    public function trouverPrecedent($nom){
        $req="SELECT numSalarie_Intervenants from intervenants join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numCandidat_Candidats where nom_Candidats<:nom and archive_Intervenants<>1 order by nom_Candidats desc limit 0,1;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('nom', $nom);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['numSalarie_Intervenants'];
        return $lignes;
        
    }
    public function trouverPrecedentRechCompl($nom){
        $req="SELECT numSalarie_Intervenants from intervenants join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numCandidat_Candidats where nom_Candidats<:nom and archive_Intervenants<>1 and RechCompl_Intervenants=1 order by nom_Candidats desc limit 0,1;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('nom', $nom);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['numSalarie_Intervenants'];
        return $lignes;
        
    }
    public function obtenirListeEntree(){
        $req="SELECT famille.numero_Famille, dateEntree_Famille, dateDeb_Proposer from famille "
                . " left join proposer on proposer.numero_Famille=famille.numero_Famille where"
                . " (mand_Famille=1 and aPourvoir_Famille=1) or "
                . "(((month(dateDeb_Proposer)=month(now())+1 or month(dateDeb_Proposer)=month(now()) or month(dateDeb_Proposer)=month(now())+2) and year(dateDeb_Proposer)=year(now()))"
                . " and idADH_TypeADH='MAND'and mand_Famille=1) or ((month(dateEntree_Famille)=month(now()) or month(dateEntree_Famille)=month(now())-1) and mand_Famille=1 and year(dateEntree_Famille)=year(now())) and famille.numero_Famille not in (SELECT numero_Famille from factures where dateFact_Factures!='0000-00-00' and dateFact_Factures<>'1970-01-01') "
                . " group by numero_Famille order by dateDeb_Proposer desc ";
        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    public function obtenirTotalListeEntrees(){/*nb entréess*/
        $req = "SELECT count(*) from famille "
        . " left join proposer on proposer.numero_Famille=famille.numero_Famille where"
        . " (mand_Famille=1 and aPourvoir_Famille=1) or"
        . " (((month(dateDeb_Proposer)=month(now())+1 or month(dateDeb_Proposer)=month(now()) or month(dateDeb_Proposer)=month(now())+2) and year(dateDeb_Proposer)=year(now()))"
        . " and idADH_TypeADH='MAND'and mand_Famille=1) or ((month(dateEntree_Famille)=month(now()) or month(dateEntree_Famille)=month(now())-1) and mand_Famille=1 and year(dateEntree_Famille)=year(now())) and famille.numero_Famille not in (SELECT numero_Famille from factures where dateFact_Factures!='0000-00-00' and dateFact_Factures<>'1970-01-01') "
        . " group by numero_Famille order by dateDeb_Proposer desc ";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['count(*)'];
        return $lignes; 
    }

    public function trouverPrecedentFam($nom){
        $req="SELECT famille.numero_Famille from famille join parents on parents.numero_Famille=famille.numero_Famille where concat(nom_Parents)<:nom and archive_Famille<>1 order by group_concat(nom_Parents) asc limit 0,1;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('nom', $nom);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['numero_Famille'];
        return $lignes;
        
    }
    public function obtenirEnfantsFamille($num){
        $req="SELECT distinct nom_Enfants, prenom_Enfants, datediff(now(),dateNaiss_Enfants) as age, dateNaiss_Enfants from enfants where numero_Famille=:num and concernGarde_Enfants=1 order by dateNaiss_Enfants DESC";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
        public function obtenirCoordonneesCandidat($num)
    {
        $req="SELECT adresse_Candidats, " ;  
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['adresse_Famille'].'/ '.$lignes['cp_Famille'].' '.$lignes['ville_Famille'].'/ '.$lignes['quartier_Famille'].'/ '.$lignes['telDom_Famille'].'/ '.$lignes['port'];
        return $lignes;
    }
    public function obtenirListeFamille(){
        $req = "SELECT distinct famille.numero_Famille,Pere.nom_Parents as nom1, Mere.nom_Parents as nom2 from famille join parents as Pere on famille.numero_Famille=Pere.numero_Famille join parents as Mere on famille.numero_Famille=Mere.numero_Famille left join proposer on famille.numero_Famille=proposer.numero_Famille where archive_Famille=0  group by famille.numero_Famille order by nom1 asc, nom2 asc ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
    /* function obsolète */
    public function obtenirTotalListeTousFamille(){/*nb toutes les familles*/
        $req = "SELECT distinct count(*)-1 from famille;";
        $cmd = $this->monPdo->prepare($req);
        
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['count(*)-1'];
        return $lignes; 
    }
    public function obtenirListeFamilleGardePart(){
        $req = "SELECT distinct famille.numero_Famille,Pere.nom_Parents as nom1, Mere.nom_Parents as nom2 from famille join parents as Pere on famille.numero_Famille=Pere.numero_Famille join parents as Mere on famille.numero_Famille=Mere.numero_Famille left join proposer on famille.numero_Famille=proposer.numero_Famille where archive_Famille=0 and gardePart_Famille=1  group by famille.numero_Famille order by nom1 asc, nom2 asc ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
    /* function obsolète */
    public function obtenirTotalListeGardePartage(){/*nb familles en garde partagée*/
        $req = "SELECT distinct count(*) from famille where archive_Famille=0 and gardePart_Famille=1;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['count(*)'];
        return $lignes; 
    }
    public function obtenirListeFamilleAPourvoir(){
         $req = "SELECT distinct famille.numero_Famille,Pere.nom_Parents 
        as nom1, Mere.nom_Parents as nom2 from famille join parents as Pere 
        on famille.numero_Famille=Pere.numero_Famille join parents as Mere 
        on famille.numero_Famille=Mere.numero_Famille left join proposer 
        on famille.numero_Famille=proposer.numero_Famille where archive_Famille=0 
        and aPourvoir_Famille=1 group by famille.numero_Famille order by nom1 asc, nom2 asc;  ";
		$cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
     }
     /* function obsolète */
     public function obtenirTotalListeAPourvoir(){/*nb famille à pourvoir*/
        $req = "SELECT distinct count(*) from famille where archive_Famille=0 and aPourvoir_Famille=1;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['count(*)'];
        return $lignes; 
    }
     public function obtenirListeFamilleAPourvoirM(){
         $req = "SELECT distinct famille.numero_Famille,Pere.nom_Parents as nom1, Mere.nom_Parents as nom2 from famille join parents as Pere on famille.numero_Famille=Pere.numero_Famille join parents as Mere on famille.numero_Famille=Mere.numero_Famille left join proposer on famille.numero_Famille=proposer.numero_Famille where archive_Famille=0 and famille.aPourvoir_PM = 1 group by famille.numero_Famille order by nom1 asc, nom2 asc ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
     }
      public function obtenirListeFamilleAPourvoirGE(){
         $req = "SELECT distinct famille.numero_Famille,Pere.nom_Parents as nom1, Mere.nom_Parents as nom2 from famille join parents as Pere on famille.numero_Famille=Pere.numero_Famille join parents as Mere on famille.numero_Famille=Mere.numero_Famille left join proposer on famille.numero_Famille=proposer.numero_Famille where archive_Famille=0 and famille.aPourvoir_PGE != 0 group by famille.numero_Famille order by nom1 asc, nom2 asc ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
     }
        public function obtenirListeFamillePrestaGE(){
        $req = "SELECT distinct famille.numero_Famille,Pere.nom_Parents as nom1, Mere.nom_Parents as nom2 from famille join parents as Pere on famille.numero_Famille=Pere.numero_Famille join parents as Mere on famille.numero_Famille=Mere.numero_Famille left join proposer on famille.numero_Famille=proposer.numero_Famille where archive_Famille=0 and prestGE_Famille=1 group by famille.numero_Famille order by nom1 asc, nom2 asc ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
        public function obtenirListeFamillePrestaM(){
        $req = "SELECT distinct famille.numero_Famille,Pere.nom_Parents as nom1, Mere.nom_Parents as nom2 from famille join parents as Pere on famille.numero_Famille=Pere.numero_Famille join parents as Mere on famille.numero_Famille=Mere.numero_Famille left join proposer on famille.numero_Famille=proposer.numero_Famille where archive_Famille=0 and prestM_Famille=1 group by famille.numero_Famille order by nom1 asc, nom2 asc ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
        /*WORK*/public function obtenirListeFamilleMand(){
        $req = "SELECT distinct famille.numero_Famille,Pere.nom_Parents as nom1, Mere.nom_Parents as nom2 from famille join parents as Pere on famille.numero_Famille=Pere.numero_Famille join parents as Mere on famille.numero_Famille=Mere.numero_Famille left join proposer on famille.numero_Famille=proposer.numero_Famille where archive_Famille=0 and mand_Famille=1 group by famille.numero_Famille order by nom1 asc, nom2 asc ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
    /* function obsolète */
        public function obtenirTotalListeFamilleMand(){
        $req = "SELECT distinct count(*) from famille where archive_Famille<>1 and mand_Famille=1 ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['count(*)'];
        return $lignes; 
    }
    /* function obsolète */
    public function obtenirTotalListeFamillePrestGE(){
        $req = "SELECT distinct count(*) from famille where archive_Famille<>1 and prestGE_Famille=1 ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['count(*)'];
        return $lignes; 
    }
    /* function obsolète */
    public function obtenirTotalListeFamillePrestM(){
        $req = "SELECT distinct count(*) from famille where archive_Famille<>1 and prestM_Famille=1 ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['count(*)'];
        return $lignes; 
    }
        public function obtenirListeFamilleArchive(){
        $req = "SELECT distinct famille.numero_Famille,Pere.nom_Parents as nom1, Mere.nom_Parents as nom2 from famille join parents as Pere on famille.numero_Famille=Pere.numero_Famille join parents as Mere on famille.numero_Famille=Mere.numero_Famille left join proposer on famille.numero_Famille=proposer.numero_Famille where archive_Famille=1  group by famille.numero_Famille order by nom1 asc, nom2 asc ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
    /* function obsolète */
    public function obtenirTotalListeArchive(){/*nb familles archivées*/
        $req = "SELECT distinct count(*) from famille where archive_Famille=1;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['count(*)'];
        return $lignes; 
    }
    public function obtenirListeFamilleAssembGen(){/*assemblée générale test*/
        $req = "SELECT distinct famille.numero_Famille,Pere.nom_Parents as nom1, Mere.nom_Parents as nom2 from famille join parents as Pere on famille.numero_Famille=Pere.numero_Famille join parents as Mere on famille.numero_Famille=Mere.numero_Famille left join proposer on famille.numero_Famille=proposer.numero_Famille where archive_Famille=0 AND AG_Famille=1 group by famille.numero_Famille order by nom1 asc, nom2 asc ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
    /* function obsolète */
    public function obtenirTotalListeFamilleAssembGen(){/*nb assemblée générale*/
        $req = "SELECT distinct count(*) from famille where AG_Famille=1 and archive_Famille=0;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['count(*)'];
        return $lignes; 
    }
    public function obtenirListeAssembGen(){/*liste de toutes assemblée générale*/
        $req = "SELECT annee from assemblee;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res; 
    }

    public function obtenirFamillesAArchiver(){
        $req = "SELECT numero_Famille, mand_Famille, sortieMand_Famille, sortiePGE_Famille, sortiePM_Famille, prestGE_Famille, prestM_Famille, dateSortie_Famille from famille"
                . " where ( "
                . "((month(dateSortie_Famille)=month(now()) and year(dateSortie_Famille)=year(now())) or (month(dateSortie_Famille)=month(now())+1 and year(dateSortie_Famille)=year(now())))"
                . " or ((month(sortieMand_Famille)=month(now()) and year(sortieMand_Famille)=year(now())) or (month(sortieMand_Famille)=month(now())+1 and year(sortieMand_Famille)=year(now())))"
                . " or ((month(sortiePGE_Famille)=month(now()) and year(sortiePGE_Famille)=year(now())) or (month(sortiePGE_Famille)=month(now())+1 and year(sortiePGE_Famille)=year(now())))"
                . " or ((month(sortiePM_Famille)=month(now()) and year(sortiePM_Famille)=year(now())) or (month(sortiePM_Famille)=month(now())+1 and year(sortiePM_Famille)=year(now())))) "
                . "and archive_Famille<>1 order by dateSortie_Famille asc;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
    }
        
        public function obtenirListeFactValid(){
        $req = "SELECT distinct * from factures join famille on factures.numero_Famille=famille.numero_Famille join parents on parents.numero_Famille=famille.numero_Famille where encaisse_Factures <>1 and dateFact_Factures='0000-00-00' group by factures.numero_Famille order by nom_Parents asc ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
        }
        public function FactEntree(){
        $req = "SELECT distinct * from factures join famille on factures.numero_Famille=famille.numero_Famille join parents on parents.numero_Famille=famille.numero_Famille where encaisse_Factures <>1 and dateFact_Factures='1970-01-01' group by factures.numero_Famille order by nom_Parents asc ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
        }
        public function ajoutEntree($num){
        $req = "insert into factures (dateFact_Factures, numero_Famille,encaisse_Factures) values ('1970-01-01', :num, 0);";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $cmd->closeCursor();
        }
        public function validMoisFact(){
        $req = "delete from factures where dateFact_Factures='0000-00-00'; ";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
                $req = "update factures set dateFact_Factures='0000-00-00'";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $req = "SELECT distinct * from factures join famille on factures.numero_Famille=famille.numero_Famille join parents on parents.numero_Famille=famille.numero_Famille where encaisse_Factures <>1 and dateFact_Factures='0000-00-00' group by factures.numero_Famille order by nom_Parents asc ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        foreach ($lignes as $ligne){
            $montant= $ligne['montantFact_Factures'];
            $num=$ligne['numero_Famille'];
            $req = "insert into factures (dateFact_Factures, numero_Famille,encaisse_Factures, montantFact_Factures) values (now(),'".$num."', 0,".$montant.");";
             $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        }
        $cmd->closeCursor();
        }
        public function obtenirSalariePresent($num){
        $req= "SELECT distinct nom_Candidats, prenom_Candidats, proposer.numSalarie_Intervenants from proposer join intervenants on intervenants.numSalarie_Intervenants=proposer.numSalarie_Intervenants join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numCandidat_Candidats where numero_Famille=:num and (dateFin_Proposer='0000-00-00' or dateFin_Proposer>date(now()))";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
        }

        public function suppSalarie($numAsupp)
        {
        $req="DELETE FROM proposer WHERE numSalarie_Intervenants =:numAsupp;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numAsupp', $numAsupp);
        $cmd->execute();
        $cmd->closeCursor();

        $req="DELETE FROM suivre WHERE numSalarie_Intervenants = :numAsupp;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numAsupp', $numAsupp);
        $cmd->execute();
        $cmd->closeCursor();

        $req="DELETE FROM bdchaudoudoux.intervenants WHERE numSalarie_Intervenants = :numAsupp;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numAsupp', $numAsupp);
        $cmd->execute();
        $cmd->closeCursor();
        }

        public function suppFormationSuivie($numForm, $numSal)
        {
        $req="DELETE FROM suivre WHERE idForm_Formations=:numForm AND numSalarie_Intervenants=:numSal;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numForm', $numForm);
        $cmd->bindValue('numSal', $numSal);
        $cmd->execute();
        $cmd->closeCursor();
        }
        

        public function suppFamille($numAsupp) {

            $req="DELETE FROM proposer WHERE numero_Famille =:numAsupp;";
            $cmd=$this->monPdo->prepare($req);
            $cmd->bindValue('numAsupp', $numAsupp);
            $cmd->execute();
            $cmd->closeCursor();

            $req="DELETE FROM partage WHERE famille1 =:numAsupp OR famille2 =:numAsupp";
            $cmd=$this->monPdo->prepare($req);
            $cmd->bindValue('numAsupp', $numAsupp);
            $cmd->execute();
            $cmd->closeCursor();

            $req="DELETE FROM factures WHERE numero_Famille =:numAsupp;";
            $cmd=$this->monPdo->prepare($req);
            $cmd->bindValue('numAsupp', $numAsupp);
            $cmd->execute();
            $cmd->closeCursor();

            $req="DELETE FROM parents WHERE numero_Famille =:numAsupp;";
            $cmd=$this->monPdo->prepare($req);
            $cmd->bindValue('numAsupp', $numAsupp);
            $cmd->execute();
            $cmd->closeCursor();

            $req="DELETE FROM enfants WHERE numero_Famille =:numAsupp;";
            $cmd=$this->monPdo->prepare($req);
            $cmd->bindValue('numAsupp', $numAsupp);
            $cmd->execute();
            $cmd->closeCursor();

            $req="DELETE FROM famille WHERE numero_Famille =:numAsupp;";
            $cmd=$this->monPdo->prepare($req);
            $cmd->bindValue('numAsupp', $numAsupp);
            $cmd->execute();
            $cmd->closeCursor();
        }

        /*Mand GE*/
        public function obtenirSalarieMandGEPresent($num){
        $req= "SELECT distinct nom_Candidats, prenom_Candidats from proposer as prop join intervenants on intervenants.numSalarie_Intervenants=prop.numSalarie_Intervenants join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numCandidat_Candidats join famille on famille.numero_Famille=prop.numero_Famille where prop.numero_Famille=:num and (dateFin_Proposer='0000-00-00' or prop.dateFin_Proposer>date(now())) and prop.idPresta_Prestations='ENFA' and idADH_TypeADH='MAND'";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
        }
        /*Prest Ménage*/
        public function obtenirSalariePrestMenagePresent($num){
        $req= "SELECT distinct nom_Candidats, prenom_Candidats from proposer as prop join intervenants on intervenants.numSalarie_Intervenants=prop.numSalarie_Intervenants join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numCandidat_Candidats join famille on famille.numero_Famille=prop.numero_Famille where prop.numero_Famille=:num and (dateFin_Proposer='0000-00-00'or prop.dateFin_Proposer>date(now())) and prop.idPresta_Prestations='MENA' and idADH_TypeADH='PREST'";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
        }
        /*Prest GE*/
        public function obtenirSalariePrestGEPresent($num){
        $req= "SELECT distinct nom_Candidats, prenom_Candidats from proposer as prop join intervenants on intervenants.numSalarie_Intervenants=prop.numSalarie_Intervenants join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numCandidat_Candidats join famille on famille.numero_Famille=prop.numero_Famille where prop.numero_Famille=:num and (dateFin_Proposer='0000-00-00'or prop.dateFin_Proposer>date(now())) and prop.idPresta_Prestations='ENFA' and idADH_TypeADH='PREST'";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes; 
        }



        /*FACTURATION*/
        public function obtenirListeNonEncaisse(){
            $req = "SELECT distinct * from factures join famille on factures.numero_Famille=famille.numero_Famille join parents on parents.numero_Famille=famille.numero_Famille where encaisse_Factures<>1 and modePaiement_Famille='PRELEVEMENT' group by factures.numero_Famille order by nom_Parents asc ;";
            $cmd = $this->monPdo->prepare($req);
            $cmd->execute();
            $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
            $cmd->closeCursor();
            return $lignes; 
            }
        public function obtenirTotalListeNonEncaisse(){/*nb non encaissés*/
            $req = "SELECT count(*) from factures join famille on factures.numero_Famille=famille.numero_Famille where encaisse_Factures<>1 and modePaiement_Famille='PRELEVEMENT' and dateFact_Factures!='0000-00-00';";
            $cmd = $this->monPdo->prepare($req);
            $cmd->execute();
            $lignes = $cmd->fetch();
            $cmd->closeCursor();
            $lignes=$lignes['count(*)'];
            return $lignes; 
        }

        public function obtenirListeNonEncaisse1(){
            $req = "SELECT distinct * from factures join famille on factures.numero_Famille=famille.numero_Famille join parents on parents.numero_Famille=famille.numero_Famille where encaisse_Factures<>1 and dateFact_Factures!='0000-00-00' and dateFact_Factures!='1970-01-01' group by factures.numero_Famille order by nom_Parents asc ;";
            $cmd = $this->monPdo->prepare($req);
            $cmd->execute();
            $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
            $cmd->closeCursor();
            return $lignes; 
        }
        public function obtenirTotalListeNonEncaisse1(){/*nb non encaissés 1*/
            $req = "SELECT distinct count(*) from factures join famille on factures.numero_Famille=famille.numero_Famille where encaisse_Factures<>1 and dateFact_Factures!='0000-00-00' and dateFact_Factures!='1970-01-01';";
            $cmd = $this->monPdo->prepare($req);
            $cmd->execute();
            $lignes = $cmd->fetch();
            $cmd->closeCursor();
            $lignes=$lignes['count(*)'];
            return $lignes; 
        }

        public function obtenirListeEncaisse($an){
            $req = "SELECT distinct * from factures join famille on factures.numero_Famille=famille.numero_Famille join parents on parents.numero_Famille=famille.numero_Famille where encaisse_Factures=1  order by modePaiement_Facture desc, nom_Parents asc ;";
            $cmd = $this->monPdo->prepare($req);
            $cmd->execute();
            $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
            $cmd->closeCursor();
            return $lignes; 
        }
        /* function obsolète 
           fonction non utilisé
            */
        public function obtenirTotalListeEncaisse(){/*nb encaissés*/
            $req = "SELECT distinct count(*) from factures join famille on factures.numero_Famille=famille.numero_Famille 
            where encaisse_Factures=1 ;";
            $cmd = $this->monPdo->prepare($req);
            $cmd->execute();
            $lignes = $cmd->fetch();
            $cmd->closeCursor();
            $lignes=$lignes['count(*)'];
            return $lignes; 
        }




        public function aPourvoir($num){
        $req = "update famille set aPourvoir_Famille=1 where numero_Famille=:num;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $cmd->closeCursor();
        }
        public function Pourvu($num){
        $req = "update famille set aPourvoir_Famille=0 where numero_Famille=:num;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $cmd->closeCursor();
        }
        public function trouverTarifs($montant){
            $req = "SELECT montant_Tarifs from tarifs where id_Tarifs=:montant";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('montant', $montant);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $lignes=$lignes['montant_Tarifs'];
        return $lignes;
        }
        
    public function verifM($num)
    {
        $req="SELECT count(*) from famille where numero_Famille=:num";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $lignes=$lignes['count(*)'];
        $cmd->closeCursor();
        if ($lignes==0){$res=true;} else {$res=false;}
        return $res;
    }

    public function obtenirNbEnfants($num){

        $req = "SELECT count(idEnfant_Enfants) as nbEnfants from enfants group by numero_Famille having numero_Famille=?;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }

    public function obtenirDetailFamille($num){
        $req = "SELECT * from famille where numero_Famille=:num ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirPrestaFamille($num){
        $req = "SELECT distinct type_Prestations, intitule_TypeADH from proposer join typeadh on typeadh.idADH_TypeADH=proposer.idADH_TypeADH join prestations on prestations.idPresta_Prestations=proposer.idPresta_Prestations where numero_Famille=? group by prestations.idPresta_Prestations";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirDemandesGE($num){

        $req = "SELECT DISTINCT besoinsfamille.numero_famille,famille.quartier_Famille, 
        famille.ville_Famille ,jour, activite, heureDebut, heureFin,frequence,
        PGE_Famille,besoinsfamille.id 
        from besoinsfamille 
        join famille on besoinsfamille.numero_famille=famille.numero_Famille 
        join parents on besoinsfamille.numero_famille=parents.numero_Famille 
        where besoinsfamille.numero_famille=? and activite='garde d\'enfants' ORDER BY jour ASC;";

        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }


    public function obtenirDemandesM($num){
        $req = "SELECT DISTINCT besoinsfamille.numero_famille,famille.quartier_Famille, 
        famille.ville_Famille ,jour, exception,
        heureSemaine, activite, heureDebut, heureFin,frequence,
        PM_Famille,besoinsfamille.id 
        from besoinsfamille 
        join famille on besoinsfamille.numero_famille=famille.numero_Famille 
        join parents on besoinsfamille.numero_famille=parents.numero_Famille 
        where besoinsfamille.numero_famille=? and activite='menage' ORDER BY jour ASC;";

        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirDetailParents($num){/*travail*/
        $req = "SELECT * from parents where numero_Famille=?;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirAgeEnfants ($num){
        $req="SELECT count(*) from enfants where datediff(now(), dateNaiss_Enfants) <1095 and numero_Famille=:num;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $lignes=$lignes['count(*)'];
        if ($lignes >0){
            $phrase = 'Enfants -3ans';
        }else {$phrase='';}
        return $phrase;
    }
    public function obtenirDetailEnfants($num){
        $req = "SELECT *, datediff(now(),dateNaiss_Enfants) as age from enfants where numero_Famille=?;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirFamilleGardePart($num){
        $req = "SELECT * from partage where famille1=? or famille2=?";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num);
        $cmd->bindValue(2, $num);
        $cmd->execute();
        $res = $cmd->fetch();
        $cmd->closeCursor();
        return $res;
    }
    public function majFamilleGardePart($num1, $num2){
        $req = "delete from partage where famille1=? or famille2=?";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num1);
        $cmd->bindValue(2, $num1);
        $cmd->execute();
        /*bug*/$req = "insert into partage values (?,?)";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num1);
        $cmd->bindValue(2, $num2);
        $cmd->execute();
        $req = "update famille set gardePart_Famille=1 where numero_Famille=?";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num2);
        $cmd->execute();
        $cmd->closeCursor();
    }
     public function obtenirFinMand($num){
        $req = "SELECT sortieMand_Famille from famille where numero_Famille=?;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num);
        $cmd->execute();
        $res = $cmd->fetch();
        $cmd->closeCursor();
        return $res['sortieMand_Famille'];
    }
        public function modifierDetailFamille($num, $pm, $pge, $archive, $remarque, $observ, $adresse, $cp, $ville, $quart, $tel, $numAlloc, $numURSSAF, $vehicule, $dateEntree, $dateSortie, $reg, $ag, $suivi, $option,$enfHand,$modePaiement, $mena, $ge,$mand, $aPourvoir, $MPourvoir, $dateMPourvoir, $GEPourvoir, $dateGEPourvoir, $ligneBus, $arretBus, $superficie, $repassage, $gardePart, $nbChambres, $nbEtages, $nbSDB, $nbSani,$typeLogement,$sortieMand, $sortiePM, $sortiePGE, $secteurFamille){
        
        $req = "UPDATE famille set sortiePM_Famille=:sortiePM, sortiePGE_Famille=:sortiePGE,sortieMand_Famille=:sortieMand,numBus_Famille=:ligneBus, arretBus_Famille=:arretBus, repassage_Famille=:repassage,"
                . " superficie_Famille=:superficie, typeLogement_Famille=:typeLogement, nbEtage_Famille=:nbEtages, "
                . "nbSanitaire_Famille=:nbSani, gardePart_Famille=:gardePart, nbSDB_Famille=:nbSDB, nbChambres_Famille=:nbChambres,"
                . "aPourvoir_Famille=:aPourvoir, aPourvoir_PM=:MPourvoir, Date_aPourvoir_PM=:dateMPourvoir, aPourvoir_PGE=:GEPourvoir, Date_aPourvoir_PGE=:dateGEPourvoir, option_Famille=:option, enfantHand_Famille=:enfHand, REG_Famille=:reg, modePaiement_Famille=:modePaiement, dateModif_Famille='".date('r')."' ,PM_Famille= :pm, PGE_Famille=:pge, archive_Famille=:archive, Remarques_Famille=:remarque, observations_Famille=:observ, adresse_Famille=:adresse, cp_Famille=:cp, suivi_Famille=:suivi,ville_Famille=:ville, quartier_Famille=:quart, telDom_Famille=:tel, numAlloc_Famille=:numAlloc, numURSSAF_Famille=:numURSSAF, vehicule_Famille=:vehicule, dateEntree_Famille=:dateEntree, dateSortie_Famille=:dateSortie, AG_Famille=:ag, prestM_Famille=:mena, prestGE_Famille=:ge, mand_Famille=:mand, secteur_Famille=:secteur 
                WHERE numero_Famille=:num; ";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue("num", $num);
        $cmd->bindValue("sortiePM", $sortiePM);
        $cmd->bindValue("sortiePGE", $sortiePGE);
        $cmd->bindValue("sortieMand", $sortieMand);
        $cmd->bindValue("ligneBus", $ligneBus);
        $cmd->bindValue("arretBus", $arretBus);
        $cmd->bindValue("repassage", $repassage);
        $cmd->bindValue("superficie", $superficie);
        $cmd->bindValue("typeLogement", $typeLogement);
        $cmd->bindValue("nbEtages", $nbEtages);
        $cmd->bindValue("nbSani", $nbSani);
        $cmd->bindValue("gardePart", $gardePart);
        $cmd->bindValue("nbSDB", $nbSDB);
        $cmd->bindValue("nbChambres", $nbChambres);
        $cmd->bindValue("aPourvoir", $aPourvoir);
        $cmd->bindValue("MPourvoir", $MPourvoir);
        $cmd->bindValue("dateMPourvoir", $dateMPourvoir);
        $cmd->bindValue("GEPourvoir", $GEPourvoir);
        $cmd->bindValue("dateGEPourvoir", $dateGEPourvoir);
        $cmd->bindValue("mand", $mand);
        $cmd->bindValue("ge", $ge);
        $cmd->bindValue ("suivi", $suivi);
        $cmd->bindValue("mena", $mena);
        $cmd->bindValue("modePaiement", $modePaiement);
        $cmd->bindValue("pm", $pm);
        $cmd->bindValue("option", $option);
        $cmd->bindValue("enfHand", $enfHand);
        $cmd->bindValue("pge", $pge);
        $cmd->bindValue("reg", $reg);
        $cmd->bindValue("archive", $archive);
        $cmd->bindValue("remarque", $remarque);
        $cmd->bindValue("observ", $observ);
        $cmd->bindValue("adresse", $adresse);
        $cmd->bindValue("cp", $cp);
        $cmd->bindValue("ville", $ville);
        $cmd->bindValue("quart", $quart);
        $cmd->bindValue("tel", $tel);
        $cmd->bindValue("numAlloc", $numAlloc);
        $cmd->bindValue("numURSSAF", $numURSSAF);
        $cmd->bindValue("vehicule", $vehicule);
        $cmd->bindValue("dateEntree", $dateEntree);
        $cmd->bindValue("dateSortie", $dateSortie);
        $cmd->bindValue("ag", $ag);
        $cmd->bindValue("secteur", $secteurFamille);

        $cmd->execute();
        $cmd->closeCursor();
    }
/*    public function modifierPrestaFamille($num, $prestMand, $idInterv, $presta, $codeCli, $codePresta, $regularite, $session, $compt) {
        if ($compt == 1) {
            $prereq = "DELETE FROM proposer where numero_Famille=:num;";
            $cmd = $this->monPdo->prepare($prereq);
            $cmd->bindValue("num", $num);
            $cmd->execute();        
        }
        if ($prestMand != 'NONE' && $presta != 'NONE') {
            $req = "INSERT INTO proposer VALUES (:presta, :interv, :num, :prestMand, :codePresta, :codeCli, :reg, NULL, :session, );";
            $cmd = $this->monPdo->prepare($req);
            $cmd->bindValue("presta", $presta);
            $cmd->bindValue("interv", $idInterv);
            $cmd->bindValue("prestMand", $prestMand);
            $cmd->bindValue("codeCli", $codeCli);
            $cmd->bindValue("codePresta", $codePresta);
            $cmd->bindValue("reg", $regularite);
            $cmd->bindValue("session", $session);
            $cmd->bindValue("num", $num);
            $cmd->execute();
            $cmd->closeCursor();
        }
    }*/
    
    
    public function obtenirDispo($num){
        $req ="SELECT disponibilites_Candidats from candidats join intervenants on numCandidat_Candidats=candidats_numCandidat_Candidats where numSalarie_Intervenants=:num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['disponibilites_Candidats'];
        return $lignes;
    }
    public function obtenirObserv($num){
        $req ="SELECT observations_Candidats from candidats join intervenants on numCandidat_Candidats=candidats_numCandidat_Candidats where numSalarie_Intervenants=:num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['observations_Candidats'];
        return $lignes;
    }
    public function obtenirRechCompl($num){
        $req ="SELECT rechCompl_Intervenants from intervenants where numSalarie_Intervenants=:num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['rechCompl_Intervenants'];
        return $lignes;
    }
    public function obtenirArchive($num){
        $req ="SELECT archive_Intervenants from intervenants where numSalarie_Intervenants=:num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
        $cmd->execute();
        $lignes=$cmd->fetch();
        $cmd->closeCursor();
        $lignes=$lignes['archive_Intervenants'];
        return $lignes;
    }
    public function trouverNomSal($num)
    {
        $req="SELECT nom_Candidats, prenom_Candidats, nomJF_Candidats, idSalarie_Intervenants from candidats join intervenants on intervenants.candidats_numcandidat_candidats=candidats.numCandidat_Candidats where numSalarie_Intervenants=:num";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue("num", $num);
        $cmd->execute();
        $res=$cmd->fetch();
        $cmd->closeCursor();
        $a=$res['nom_Candidats'].' '.strtolower($res['prenom_Candidats']).' ';
        if ($res['nomJF_Candidats']!=''){
            $a.='née '.$res['nomJF_Candidats'].' ';
        }
        $a.=$res['idSalarie_Intervenants'];
        return $a;
    }
    public function obtenirNbParents($num) {
 		$prereq = "SELECT idParent_Parents FROM parents WHERE numero_Famille=:num";
        $cmd = $this->monPdo->prepare($prereq);
        $cmd->bindValue("num", $num);
        $cmd->execute();
        $res = $cmd->rowCount();
        $cmd->closeCursor();
        return $res;
 	}
        public function ajoutParents($num, $titre, $nom, $prenom, $telPro, $telPort, $email, $prof)
        {
            if ($nom !=''){
            $req = "INSERT INTO parents (titre_Parents, nom_Parents, prenom_Parents, telTravail_Parents, telPortable_Parents, email_Parents, profession_Parents, numero_Famille) VALUES (:titre, upper(:nom), :prenom, :telPro, :telPort, :email, :prof, :num);";
           	$cmd = $this->monPdo->prepare($req);
           	$cmd->bindValue("titre", $titre);
           	$cmd->bindValue("nom", $nom);
           	$cmd->bindValue("prenom", $prenom);
           	$cmd->bindValue("telPro", $telPro);
           	$cmd->bindValue("telPort", $telPort);
           	$cmd->bindValue("email" ,$email);
           	$cmd->bindValue("prof", $prof);
           	$cmd->bindValue("num", $num);
           	$cmd->execute();
           	$cmd->closeCursor();
        }}
    public function modifierDetailParents($num, $titre, $nom, $prenom, $telPro, $telPort, $email, $prof,$compt) {
        $req="";    
        if($compt==1){
            $req = "DELETE FROM parents WHERE numero_Famille ='".$num."';";}
        if ($nom != ''){
        	$req .= "INSERT INTO parents (titre_Parents, nom_Parents, prenom_Parents, telTravail_Parents, telPortable_Parents, email_Parents, profession_Parents, numero_Famille) VALUES (:titre, upper(:nom), :prenom, :telPro, :telPort, :email, :prof, :num);";
           	$cmd = $this->monPdo->prepare($req);
           	$cmd->bindValue("titre", $titre);
           	$cmd->bindValue("nom", $nom);
           	$cmd->bindValue("prenom", $prenom);
           	$cmd->bindValue("telPro", $telPro);
           	$cmd->bindValue("telPort", $telPort);
           	$cmd->bindValue("email" ,$email);
           	$cmd->bindValue("prof", $prof);
           	$cmd->bindValue("num", $num);
           	$cmd->execute();
           	$cmd->closeCursor();
        }
    }
    public function obtenirNbIntervenants()
    {
        $req="SELECT count(*) as c from intervenants WHERE archive_Intervenants=0";
        $cmd = $this->monPdo->prepare($req);
	$cmd->execute();
        $res = $cmd->fetch();
        $cmd->closeCursor();
        $res=$res["c"];
        return $res;
        
    }
        public function obtenirNbFamilles()
    {
        $req="SELECT distinct count(*)-1 as c from famille WHERE archive_Famille=0";
        $cmd = $this->monPdo->prepare($req);
	$cmd->execute();
        $res = $cmd->fetch();
        $cmd->closeCursor();
        $res=$res["c"];
        return $res;
        
    }
    public function obtenirDateSortieFam($num)
    {
       $req="SELECT dateSortie_Famille from famille where numero_Famille=:num";
       $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
	$cmd->execute();
        $res = $cmd->fetch();
        $cmd->closeCursor();
        $res=$res['dateSortie_Famille'];
        return $res;
    }
   
    public function obtenirNbHeures($num)
    {
        $req="SELECT distinct PM_Famille, PGE_Famille, famille.numero_Famille, telDom_Famille, idPresta_Prestations, idADH_TypeADH, famille.adresse_Famille, cp_Famille, ville_Famille  from proposer left join famille on proposer.numero_Famille=famille.numero_Famille left join parents on parents.numero_Famille = proposer.numero_Famille where numSalarie_Intervenants=:num and (dateFin_Proposer>'".date('Y-m-d')."' or dateFin_Proposer='0000-00-00') and statut_Proposer<>'Effectué' group by proposer.numero_Famille, proposer.idPresta_Prestations, proposer.idADH_TypeADH order by group_concat(nom_Parents) asc";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
	$cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirMailMaman($num){/*Vincent*/
        $req="SELECT distinct email_Parents as mailMaman from parents where numero_Famille=:num limit 1";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
	$cmd->execute();
        $res = $cmd->fetch();
        $res=$res['mailMaman'];
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirMailPapa($num){/*Vincent*/
        $req="SELECT distinct email_Parents as mailPapa from parents where numero_Famille=:num limit 1,1";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
	$cmd->execute();
        $res = $cmd->fetch();
        if( is_array($res) ) {
            $res=$res['mailPapa'];
        }
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirTelMaman($num)
    {
        $req="SELECT distinct telPortable_Parents as telMaman from parents where numero_Famille=:num limit 1";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
	    $cmd->execute();
        $res = $cmd->fetch();
        $res=$res['telMaman'];
        $cmd->closeCursor();
        return $res;
    }

    public function obtenirTelPapa($num)/*Vincent*/
    {
        $req="SELECT distinct telPortable_Parents as telPapa from parents where numero_Famille=:num limit 1,1";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('num', $num);
	    $cmd->execute();
        $res = $cmd->fetch();
        if ($res === false) {
        // Si la requête n'a pas renvoyé de résultats (fetch() retourne false)
        $cmd->closeCursor();
        return null;  // Retourner null si aucun résultat
        }
        $res=$res['telPapa'];
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirMailParents($adresse){/*Vincent*/
        $req="SELECT DISTINCT nom_Parents, prenom_Parents, email_Parents FROM parents WHERE email_Parents=:adresse ORDER BY nom_parents ASC";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('adresse', $adresse);
        $cmd->execute();
        $res=$cmd->fetch();
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirMailIntervenants($adresse){/*Vincent*/
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats WHERE email_Candidats=:adresse ORDER BY nom_parents ASC";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('adresse', $adresse);
        $cmd->execute();
        $res=$cmd->fetch();
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirTimeDiffPrestM($numSal, $numFam)
    {
        $req="SELECT distinct jour_Proposer, frequence_Proposer, hDeb_Proposer, hFin_Proposer, timediff(hFin_Proposer, hDeb_Proposer) as nb_heures from proposer where numSalarie_Intervenants=:numSal and numero_Famille=:numFam and idADH_TypeADH='PREST' and idPresta_Prestations='MENA' and (dateFin_Proposer>'".date('Y-m-d')."' or dateFin_Proposer='0000-00-00')";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numSal', $numSal);
        $cmd->bindValue('numFam', $numFam);
	$cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirTimeDiffPrestGE($numSal, $numFam)
    {
        $req="SELECT distinct jour_Proposer, frequence_Proposer, hDeb_Proposer, hFin_Proposer, timediff(hFin_Proposer, hDeb_Proposer) as nb_heures from proposer where numSalarie_Intervenants=:numSal and numero_Famille=:numFam and idADH_TypeADH='PREST' and idPresta_Prestations='ENFA' and (dateFin_Proposer>'".date('Y-m-d')."' or dateFin_Proposer='0000-00-00 00:00:00')";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numSal', $numSal);
        $cmd->bindValue('numFam', $numFam);
	$cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    
     public function obtenirTimeDiffMand($numSal, $numFam)
    {
        $req="SELECT distinct jour_Proposer, frequence_Proposer, hDeb_Proposer, hFin_Proposer, timediff(hFin_Proposer, hDeb_Proposer) as nb_heures from proposer where numSalarie_Intervenants=:numSal and numero_Famille=:numFam and idADH_TypeADH='MAND' and (dateFin_Proposer>'".date('Y-m-d')."' or dateFin_Proposer='0000-00-00')";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numSal', $numSal);
        $cmd->bindValue('numFam', $numFam);
	$cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirNomsFamille()
    {
        $req = "SELECT numero_Famille from parents group by numero_Famille order by nom_Parents asc;";
        $cmd = $this->monPdo->prepare($req);
	    $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    public function obtenirNomsParents()
    {
        $req="SELECT parents.numero_Famille,group_concat(nom_Parents SEPARATOR ' ') as nomPar from parents group by numero_Famille";
        $cmd = $this->monPdo->prepare($req);
	$cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
    public function ajoutEnfant($num, $nom, $prenom, $dateNaiss,$concernGarde){
        if($nom!="" && $prenom!=""){
        $req = "INSERT INTO enfants (nom_Enfants, prenom_Enfants, dateNaiss_Enfants, numero_Famille,concernGarde_Enfants) VALUES (upper(:nom), :prenom, :dateNaiss,'".$num."',:concernGarde);";
           	$cmd = $this->monPdo->prepare($req);
           	$cmd->bindValue("nom", $nom);
           	$cmd->bindValue("prenom", $prenom);
           	$cmd->bindValue("dateNaiss", $dateNaiss);
                $cmd->bindValue("concernGarde", $concernGarde);
           	$cmd->execute();
           	$cmd->closeCursor();
    }}
    public function modifierDetailEnfant($num, $nom, $prenom, $dateNaiss, $compt, $concernGarde) {
        $req="";
        if ($compt==1){
        $req = "DELETE FROM enfants WHERE numero_Famille ='".$num."';";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $cmd->closeCursor();
    }
        if ($nom != '' && $prenom != ''){
        	$req = "INSERT INTO enfants (nom_Enfants, prenom_Enfants, dateNaiss_Enfants, numero_Famille, concernGarde_Enfants) VALUES (upper(:nom), :prenom, :dateNaiss,'".$num."',:concernGarde);";
           	$cmd = $this->monPdo->prepare($req);
           	$cmd->bindValue("nom", $nom);
           	$cmd->bindValue("prenom", $prenom);
           	$cmd->bindValue("dateNaiss", $dateNaiss);
                $cmd->bindValue("concernGarde", $concernGarde);
           	$cmd->execute();
           	$cmd->closeCursor();
        }
 	}//$num, $montant, $encFact,$montantEnc,$date,$numFam,$modePaiement
        public function ajoutFact ($num, $montant, $encFact,$montantEnc,$date,$numFam,$modePaiement)
        {
            $req="insert into factures (idFact_Factures, montantFact_Factures, encaisse_Factures, montantEnc_Factures, dateFact_Factures, factures.numero_Famille, modePaiement_Facture)values (:num, :montant, :encFact, :montantEnc, now(), :numFam, :modePaiement)";
            $cmd = $this->monPdo->prepare($req);
            $cmd->bindValue('num', $num);
            $cmd->bindValue('montant', $montant);
            $cmd->bindValue('encFact', $encFact);
            $cmd->bindValue('montantEnc', $montantEnc);
            $cmd->bindValue('numFam', $numFam);
            $cmd->bindValue('modePaiement', $modePaiement);
            $cmd->execute();
            $cmd->closeCursor();
        }
/*   public function VerifM($numFam)
    {
        $req="SELECT count(*) as c from famille where numero_Famille=:numFam";
        $cmd = $this->monPdo->prepare($req);   
        $cmd->bindValue('numFam', $numFam);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        $resu=$res["c"];
        return $res;*/
     public function trouverIncoherence() {
         $req="SELECT DISTINCT proposer.numero_Famille, proposer.numSalarie_Intervenants, nom_Candidats
         from proposer 
         join intervenants on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants 
         join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numcandidat_candidats 
         join famille on famille.numero_Famille=proposer.numero_Famille 
         where archive_Famille=1 /*and archive_Intervenants<>1*/ and (dateFin_Proposer='0000-00-00' or dateFin_Proposer>date(now()))";
         $cmd = $this->monPdo->prepare($req);
         $cmd->execute();
         $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
         $cmd->closeCursor();
         return $lignes;
     }
     public function trouverIncoherenceInt() {
        $req="SELECT DISTINCT proposer.numSalarie_Intervenants, proposer.numero_Famille, candidats.nom_Candidats 
            from proposer 
            join intervenants 
            on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants 
            join candidats on candidats.numCandidat_Candidats=intervenants.candidats_numcandidat_candidats 
            join famille on famille.numero_Famille=proposer.numero_Famille 
            where archive_Intervenants=1 /*and archive_Famille<>1*/ and (dateFin_Proposer='0000-00-00' or dateFin_Proposer>date(now()))";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
     /*mails des familles prestataires garde d'enfants*/
      public function mailPrestFamGE() {
         $req="SELECT nom_Parents, prenom_Parents, email_Parents from parents join famille on famille.numero_Famille=parents.numero_Famille where archive_Famille=0 and prestGE_Famille=1 group by famille.numero_Famille order by nom_Parents ASC";
         $cmd = $this->monPdo->prepare($req);
         $cmd->execute();
         $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
         $cmd->closeCursor();
         return $lignes;
     }
     /*mails des familles prestataires ménage*/
     public function mailPrestFamMen() {
        $req="SELECT nom_Parents, prenom_Parents, email_Parents from parents join famille on famille.numero_Famille=parents.numero_Famille where archive_Famille=0 and prestM_Famille=1 group by famille.numero_Famille order by nom_Parents ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    /*mails des familles mandataires*/
     public function mailMandFam() {
         $req="SELECT DISTINCT nom_Parents, prenom_Parents, email_Parents from parents join famille on famille.numero_Famille=parents.numero_Famille where archive_Famille=0 and mand_Famille=1 group by famille.numero_Famille order by nom_Parents ASC";
         $cmd = $this->monPdo->prepare($req);
         $cmd->execute();
         $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
         $cmd->closeCursor();
         return $lignes;
     }




     /*pas de mails des familles prestataires garde d'enfants*/
     public function mailVidePrestFamGE() {
        //Récupère tous les emails manquants
        $req1 = "SELECT DISTINCT nom_Parents, prenom_Parents, email_Parents FROM parents join famille on famille.numero_Famille=parents.numero_Famille WHERE (email_Parents is null or email_Parents = '') AND archive_Famille=0 AND prestGE_Famille=1 GROUP BY famille.numero_Famille ORDER BY nom_Parents ASC ;";
        $cmd1 = $this->monPdo->prepare($req1);
        $cmd1->execute();
        $lignes1=$cmd1->fetchAll(PDO::FETCH_ASSOC);
        $cmd1->closeCursor();

        return $lignes1;
    }

    /*pas de mails des familles prestataires ménage*/
     public function mailVidePrestFamMen() {
        $req="SELECT DISTINCT nom_Parents, prenom_Parents, email_Parents from parents join famille on famille.numero_Famille=parents.numero_Famille where (email_Parents is null or email_Parents = '') AND archive_Famille=0 AND prestM_Famille=1 group by famille.numero_Famille order by nom_Parents ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }



     /*pas de mails des familles mandataires*/
     public function mailVideMandFam() {
        $req="SELECT DISTINCT nom_Parents, prenom_Parents, email_Parents from parents join famille on famille.numero_Famille=parents.numero_Famille where (email_Parents is null or email_Parents = '') AND archive_Famille=0 AND mand_Famille=1 group by famille.numero_Famille order by nom_Parents ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

   
     /*obtenir adresses mail dans le carnet d'adresse mail pour les intervenants : prest / mand / disp / archi*/

    /*mails intervenants dans des familles prestataires*/
    public function mailPrestInterv() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='PREST' AND (travailVoulu_Candidats = 'ENFANT' OR travailVoulu_Candidats = 'TOUT' OR travailVoulu_Candidats = 'MENAGE') ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }


     /*mails intervenants dans des familles prestataires GE*/
     public function mailPrestIntervGE() {
         $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='PREST' AND (travailVoulu_Candidats = 'ENFANT' OR travailVoulu_Candidats = 'TOUT') ORDER BY nom_Candidats ASC";
         $cmd = $this->monPdo->prepare($req);
         $cmd->execute();
         $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
         $cmd->closeCursor();
         return $lignes;
     }
     /*mails intervenants dans des familles prestataires Men*/
     public function mailPrestIntervMen() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='PREST' AND (travailVoulu_Candidats = 'MENAGE' OR travailVoulu_Candidats = 'TOUT') ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
     /*mails intervenants dans des familles mandataires*/
     public function mailMandInterv() {
         $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats 
         FROM candidats 
         JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats 
         join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants 
         WHERE archive_Intervenants=0 AND idADH_TypeADH='MAND' 
         ORDER BY nom_Candidats ASC";
         $cmd = $this->monPdo->prepare($req);
         $cmd->execute();
         $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
         $cmd->closeCursor();
         return $lignes;
     } 
     public function mailIntervSansDispo() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats 
        FROM candidats 
        JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats
        JOIN disponibilitesintervenants AS D ON  D.numero_Intervenant = Intervenants.numSalarie_Intervenants
        WHERE archive_Intervenants=0 AND D.heureDebut = '01:01:00' AND D.heureFin = '01:01:00'
        ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    public function mailVideIntervSansDispo() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats 
        FROM candidats 
        JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats
        JOIN disponibilitesintervenants AS D ON  D.numero_Intervenant = Intervenants.numSalarie_Intervenants
        WHERE archive_Intervenants=0 AND D.heureDebut = '01:01:00' AND D.heureFin = '01:01:00' AND (email_Candidats is null or email_Candidats = '')
        ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    
    }










    public function mailPrestIntervAct() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='PREST' AND (travailVoulu_Candidats = 'ENFANT' OR travailVoulu_Candidats = 'TOUT' OR travailVoulu_Candidats = 'MENAGE') AND (dateFin_Proposer>now() or dateFin_Proposer='0000-00-00') ORDER BY nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function mailPrestIntervGEAct() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='PREST' AND (travailVoulu_Candidats = 'ENFANT' OR travailVoulu_Candidats = 'TOUT') AND (dateFin_Proposer>now() or dateFin_Proposer='0000-00-00') ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function mailPrestIntervMenAct() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='PREST' AND (travailVoulu_Candidats = 'MENAGE' OR travailVoulu_Candidats = 'TOUT') AND (dateFin_Proposer>now() or dateFin_Proposer='0000-00-00') ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function mailMandIntervAct() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='MAND' AND (dateFin_Proposer>now() or dateFin_Proposer='0000-00-00') ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

     /*mail intervenant disponibles*/
     public function mailDispInterv() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='DISP' ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
     }
     /*mail intervenants archivés*/
     public function mailArchiInterv() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats WHERE archive_Intervenants=1 ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
     }
     /*pas de mails intervenants dans des familles prestataires*/
     public function mailVidePrestInterv() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='PREST' AND (travailVoulu_Candidats = 'ENFANT' OR travailVoulu_Candidats = 'TOUT' OR travailVoulu_Candidats = 'MENAGE') AND (email_Candidats is null or email_candidats = '') ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    /*pas de mails intervenants dans des familles prestataires GE*/
    public function mailVidePrestIntervGE() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='PREST' AND (travailVoulu_Candidats = 'ENFANT' OR travailVoulu_Candidats = 'TOUT') AND (email_Candidats is null or email_Candidats = '') ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    /*pas de mails intervenants dans des familles prestataires Men*/
    public function mailVidePrestIntervMen() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='MAND' AND (email_Candidats is null or email_Candidats = '') ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    /*pas de mails intervenants dans des familles mandataires*/
    public function mailVideMandInterv() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats 
        FROM candidats 
        JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats 
        join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants 
        WHERE archive_Intervenants=0 AND idADH_TypeADH='MAND' AND (email_Candidats is null or email_Candidats = '') 
        ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }


    /*pas de mails intervenants dans des familles prestataires actuellement*/
    public function mailVidePrestIntervAct() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='PREST' AND (travailVoulu_Candidats = 'ENFANT' OR travailVoulu_Candidats = 'TOUT' OR travailVoulu_Candidats = 'MENAGE') AND (dateFin_Proposer>now() or dateFin_Proposer='0000-00-00') AND (email_Candidats is null or email_candidats = '') ORDER BY nom_Candidats ASC" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    /*pas de mails intervenants dans des familles prestataires GE actuellement*/
    public function mailVidePrestIntervGEAct() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='PREST' AND (travailVoulu_Candidats = 'ENFANT' OR travailVoulu_Candidats = 'TOUT') AND (dateFin_Proposer>now() or dateFin_Proposer='0000-00-00') AND (email_Candidats is null or email_Candidats = '') ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    /*pas de mails intervenants dans des familles prestataires Men actuellement*/
    public function mailVidePrestIntervMenAct() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='PREST' AND (travailVoulu_Candidats = 'MENAGE' OR travailVoulu_Candidats = 'TOUT') AND (email_Candidats is null or email_Candidats = '') ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    /*pas de mails intervenants dans des familles mandataires actuellement*/
    public function mailVideMandIntervAct() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='MAND' AND (dateFin_Proposer>now() or dateFin_Proposer='0000-00-00') AND (email_Candidats is null or email_Candidats = '') ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }


    /*pas de mails intervenant disponibles*/
    public function mailVideDispInterv() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats join proposer on proposer.numSalarie_Intervenants=intervenants.numSalarie_Intervenants WHERE archive_Intervenants=0 AND idADH_TypeADH='DISP' AND (email_Candidats is null or email_Candidats = '') ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    /*pas de mails intervenants archivés*/
    public function mailVideArchiInterv() {
        $req="SELECT DISTINCT nom_Candidats, prenom_Candidats, email_Candidats FROM candidats JOIN intervenants ON Intervenants.candidats_numCandidat_candidats=Candidats.numCandidat_Candidats WHERE (email_Candidats is null or email_Candidats = '') AND archive_Intervenants=1 ORDER BY nom_Candidats ASC";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }


    public function ajoutFamille($codeCli, $pm, $pge, $archive,$remarque, $observ,$adresse, $cp, $ville, $quart, $tel, $numAlloc, $numURSSAF, $vehicule, $dateEntree, $dateSortie, $reg, $ag, $option, $enfHand, $modePaiement, $mand, $mena, $ge, $aPourvoir, $MPourvoir, $dateMPourvoir, $GEPourvoir, $dateGEPourvoir, $ligneBus, $arretBus, $repassage, $superficie, $typeLogement, $nbEtages, $nbSani, $nbSDB, $nbChambres, $gardePart,$sortieMand, $sortiePM, $sortiePGE, $secteurFamille) {
        $req = "INSERT INTO famille (numero_Famille, PM_Famille, REG_Famille, PGE_Famille, archive_Famille, Remarques_Famille, observations_Famille,Famille_Famille, dateEntree_Famille, dateSortie_Famille,  adresse_Famille, cp_Famille, ville_Famille, quartier_Famille, telDom_Famille, numAlloc_Famille, numURSSAF_Famille, vehicule_Famille, AG_Famille, dateModif_Famille, option_Famille, enfantHand_Famille, modePaiement_Famille, mand_Famille, prestM_Famille, prestGE_Famille, aPourvoir_Famille, aPourvoir_PM, Date_aPourvoir_PM, aPourvoir_PGE, Date_aPourvoir_PGE, numBus_Famille, arretBus_Famille, repassage_Famille, superficie_Famille,typeLogement_Famille,nbEtage_Famille, nbSanitaire_Famille, nbSDB_Famille, nbChambres_Famille, gardePart_Famille, sortieMand_Famille, sortiePM_Famille, sortiePGE_Famille, secteur_Famille)"
                . " VALUES (:code, :pm, :reg, :pge, :archive,:remarque, :observ, 'Famille', :dateEntree, :dateSortie, :adresse, :cp, :ville, :quart, :tel, :numAlloc, :numURSSAF, :vehicule, :ag,'".date('r')."', :option, :enfHand, :modePaiement, :mand, :mena, :ge, :aPourvoir, :MPourvoir, :dateMPourvoir, :GEPourvoir, :dateGEPourvoir, :ligneBus, :arretBus, :repassage, :superficie, :typeLogement, :nbEtages, :nbSani, :nbSDB, :nbChambres, :gardePart,:sortieMand, :sortiePM, :sortiePGE, :secteur)";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue("code", $codeCli);
        $cmd->bindValue("sortiePM", $sortiePM);
        $cmd->bindValue("sortiePGE", $sortiePGE);
        $cmd->bindValue("ligneBus", $ligneBus);
        $cmd->bindValue("sortieMand", $sortieMand);
        $cmd->bindValue("arretBus", $arretBus);
        $cmd->bindValue("repassage", $repassage);
        $cmd->bindValue("superficie", $superficie);
        $cmd->bindValue("typeLogement", $typeLogement);
        $cmd->bindValue("nbEtages", $nbEtages);
        $cmd->bindValue("nbSani", $nbSani);
        $cmd->bindValue("gardePart", $gardePart);
        $cmd->bindValue("nbSDB", $nbSDB);
        $cmd->bindValue("nbChambres", $nbChambres);
        $cmd->bindValue("aPourvoir", $aPourvoir);
        $cmd->bindValue("MPourvoir", $MPourvoir);
        $cmd->bindValue("dateMPourvoir", $dateMPourvoir);
        $cmd->bindValue("GEPourvoir", $GEPourvoir);
        $cmd->bindValue("dateGEPourvoir", $dateGEPourvoir);
        $cmd->bindValue("mand", $mand);
        $cmd->bindValue("mena", $mena);
        $cmd->bindValue("ge", $ge);
        $cmd->bindValue("archive", $archive);
        $cmd->bindValue("modePaiement", $modePaiement);
        $cmd->bindValue("option", $option);
        $cmd->bindValue("pm", $pm);
        $cmd->bindValue("enfHand", $enfHand);
        $cmd->bindValue("pge", $pge);
        $cmd->bindValue("remarque", $remarque);
        $cmd->bindValue("observ", $observ);
        $cmd->bindValue("adresse", $adresse);
        $cmd->bindValue("cp", $cp);
        $cmd->bindValue("ville", $ville);
        $cmd->bindValue("quart", $quart);
        $cmd->bindValue("tel", $tel);
        $cmd->bindValue("numAlloc", $numAlloc);
        $cmd->bindValue("numURSSAF", $numURSSAF);
        $cmd->bindValue("vehicule", $vehicule);
        $cmd->bindValue("dateEntree", $dateEntree);
        $cmd->bindValue("dateSortie", $dateSortie);
        $cmd->bindValue("reg", $reg);
        $cmd->bindValue("ag", $ag);
        $cmd->bindValue("secteur", $secteurFamille);
        $cmd->execute();

        $cmd->closeCursor();

    }
   /* public function recupererNumFamille($codeCliFamille) {
        $req = "SELECT distinct famille.numero_Famille as numero from famille join proposer on proposer.numero_Famille=famille.numero_Famille where codeCli_Proposer like :code;";
        $codeCli = decouperCodes($codeCliFamille);
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue("code", $codeCli);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();

        return $res['numero'];
    }*/

    public function verifInterv($numFam, $idPresta, $numInterv) {
        $res = false;

        $req = "SELECT numSalarie_Intervenants from proposer where idPresta_Prestations = :idPresta and numero_Famille = :numFam having max(session_Proposer);";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue("numFam", $numFam);
        $cmd->bindValue("idPresta", $idPresta);
        $cmd->execute();
        $table = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();

        foreach ($table as $ligne) {
            if($numInterv == $ligne['numSalarie_Intervenants']) $res = true;
        }

        return $res;
    }







    //ensembles des fonctions relatives aux candidats
    public function updateNvSal($num, $nbH, $trav, $enfHand, $dispo,$BB){
        $req= "update candidats set travailVoulu_Candidats=:trav, enfantHand_Candidats=:enfHand, expBBmoins1a_Candidats=:BB, disponibilites_Candidats=:dispo where numCandidat_Candidats=:num;"
                . "update intervenants set nbHeureSem_Intervenants=:nbH where candidats_numCandidat_Candidats=:num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num',$num);
        $cmd->bindValue('trav',$trav);
        $cmd->bindValue('enfHand',$enfHand);
        $cmd->bindValue('dispo',$dispo);
        $cmd->bindValue('nbH',$nbH);
        $cmd->bindValue('BB',$BB);
        $cmd ->execute();
        $cmd->closeCursor();

    }

    public function obtenirListeCandidat(){
        $req = "SELECT * from candidats where candidatureRetenue_Candidats like 'En attente' order by dateEntretien_Candidats desc;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    public function obtenirListeCandidatRef(){
        $req = "SELECT * from candidats where candidatureRetenue_Candidats not in ('En attente' ,'Accepté') order by nom_Candidats asc;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    
    public function obtenirDetailCandidat($num){
        $req = "SELECT * from candidats where numCandidat_Candidats = ?;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue(1, $num);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }

    public function ajouterCandid($cmu, $mutuelle, $observ,$titre, $nom, $prenom, $dateNaiss, $lieuNaiss, $paysNaiss, $natio, $numTS,
            $adresse, $cp, $ville, $quartier, $telPort, $telFixe, $telUrg, $email, $numSS, $permis, $vehicule, $statutPro, $sitFam,
            $diplomes, $qualifs, $expBBmoins1a, $enfantHand, $dispo, $trav, $nomJF, $secteurCandidat){
        $req = "INSERT INTO Candidats( CMU_Candidats, Mutuelle_Candidats,  titre_Candidats, nom_Candidats, prenom_Candidats, dateNaiss_Candidats,"
                . " lieuNaiss_Candidats, paysNaiss_Candidats, nationalite_Candidats, numTitreSejour, numSS_Candidats,"
                . " adresse_Candidats, cp_Candidats, ville_Candidats, Quartier_Candidats, telPortable_Candidats, telFixe_Candidats,"
                . " TelUrg_Candidats, email_Candidats, permis_Candidats, vehicule_Candidats, statutPro_Candidats, situationFamiliale_Candidats,"
                . "diplomes_Candidats, qualifications_Candidats, expBBmoins1a_Candidats, enfantHand_Candidats, disponibilites_Candidats,"
                . " observations_Candidats, dateEntretien_Candidats, travailVoulu_Candidats, nomJF_Candidats, secteur_Candidats) 
                VALUES (:cmu, :mutuelle,:titre, upper(:nom), :prenom, :dateNaiss, :lieuNaiss, :paysNaiss, :natio,"
                . " :numTS, :numSS, :adresse, :cp, :ville, :quart, :telPort, :telFixe, :telUrg, :email, :permis, :vehicule, "
                . ":statutPro, :sitFam, :diplomes, :qualifs, :expBBmoins1a, :enfantHand, :dispo, :observ,now(),:trav,:nomJF, :secteur);";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('titre', $titre);
        $cmd->bindValue('nom', $nom);
        $cmd->bindValue('trav', $trav);
        $cmd->bindValue('nomJF', $nomJF);
        $cmd->bindValue('cmu', $cmu);
        $cmd->bindValue('sitFam', $sitFam);
        $cmd->bindValue('mutuelle', $mutuelle);
        $cmd->bindValue('observ', $observ);
        $cmd->bindValue('prenom', $prenom);
        $cmd->bindValue('dateNaiss', $dateNaiss);
        $cmd->bindValue('lieuNaiss', $lieuNaiss);
        $cmd->bindValue('paysNaiss', $paysNaiss);
        $cmd->bindValue('natio', $natio);
        $cmd->bindValue('numTS', $numTS);
        $cmd->bindValue('numSS', $numSS);
        $cmd->bindValue('adresse', $adresse);
        $cmd->bindValue('cp', $cp);
        $cmd->bindValue('ville', $ville);
        $cmd->bindValue('quart', $quartier);
        $cmd->bindValue('telPort', $telPort);
        $cmd->bindValue('telFixe', $telFixe);
        $cmd->bindValue('telUrg', $telUrg);
        $cmd->bindValue('email', $email);
        $cmd->bindValue('permis', $permis);
        $cmd->bindValue('vehicule', $vehicule);
        $cmd->bindValue('statutPro', $statutPro);
        $cmd->bindValue('sitFam', $sitFam);
        $cmd->bindValue('diplomes', $diplomes);
        $cmd->bindValue('qualifs', $qualifs);
        $cmd->bindValue('expBBmoins1a', $expBBmoins1a);
        $cmd->bindValue('enfantHand', $enfantHand);
        $cmd->bindValue('dispo', $dispo);
        $cmd->bindValue('secteur', $secteurCandidat);
        $cmd->execute();
        $cmd->closeCursor();
    }
public function updateEchecCandidat($num, $cmu, $mutuelle, $observ, $trav)
{
        $req = "update candidats set travailVoulu_Candidats=:trav , observations_Candidats=:observ,CMU_Candidats=:cmu, Mutuelle_Candidats=:mutuelle where numCandidat_Candidats = :num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num',$num);
        $cmd->bindValue('trav',$trav);
        $cmd->bindValue('cmu', $cmu);
        $cmd->bindValue('mutuelle',$mutuelle);
        $cmd->bindValue('observ', $observ);
        $cmd->execute();
        $cmd->closeCursor();
}
public function getNumCand($num)
{
    $req= "SELECT candidats_numcandidat_candidats from intervenants where numSalarie_Intervenants=:num";
    $cmd=$this->monPdo->prepare($req);
    $cmd->bindValue('num',$num);
    $cmd->execute();
    $ligne=$cmd->fetch();
    $ligne=$ligne['candidats_numcandidat_candidats'];
    $cmd->closeCursor();
    return $ligne;
}
public function updateEchecInterv($num, $numCand, $dateFinArret, $dateNaiss, $TS, $mutuelle, $cmu, $psc1, $hMois, $hSem, $compl, $tauxH, $certif, $archive, $dateSortie, $id, $suivi, $trav,$nomJF,$dateEntree, $arret, $archiveTemporaire, $dateFinArchiveTemporaire , $dateDebutArchiveTemporaire,$repassage)
{
    $req= "update candidats set nomJF_Candidats=:nomJF, dateNaiss_Candidats = :dateNaiss, numTitreSejour=:TS, travailVoulu_Candidats=:trav,Mutuelle_Candidats=:mutuelle, CMU_Candidats=:cmu where numCandidat_Candidats = :numCand;";
    $req.="update intervenants set dateFinArret_Intervenants=:finArret,arretTravail_Intervenants=:arret, idSalarie_Intervenants=:idSal, proposerPSC1_Intervenants=:psc1, "
            . "nbHeureSem_Intervenants=:hSem, nbHeureMois_Intervenants=:hMois, rechCompl_Intervenants=:compl, "
            . "tauxH_Intervenants=:tauxH, Certification_Intervenants=:certif, archive_Intervenants=:archive, "
            . "idSalarie_Intervenants=:idSal, dateSortie_Intervenants=:dateSortie, suivi_Intervenants=:suivi, dateEntree_Intervenants=:dateEntree, archiveTemporaire=:archiveTemporaire, dateFinArchiveTemporaire=:dateFinArchiveTemporaire , dateDebutArchiveTemporaire=:dateDebutArchiveTemporaire,repassage_Intervenants=:repassage where numSalarie_Intervenants=:num;";
    $cmd=$this->monPdo->prepare($req);
    $cmd->bindValue('num',$num);
     $cmd->bindValue('dateEntree',$dateEntree);
     $cmd->bindValue('finArret',$dateFinArret);
     $cmd->bindValue('arret',$arret);
    $cmd->bindValue('trav',$trav);
    $cmd->bindValue('nomJF',$nomJF);
    $cmd->bindValue('numCand',$numCand);
    $cmd->bindValue('dateNaiss',$dateNaiss);
    $cmd->bindValue('TS',$TS);
    $cmd->bindValue('dateSortie',$dateSortie);
    $cmd->bindValue('mutuelle',$mutuelle);
    $cmd->bindValue('cmu',$cmu);
    $cmd->bindValue('psc1',$psc1);
    $cmd->bindValue('hMois',$hMois);
    $cmd->bindValue('hSem',$hSem);
    $cmd->bindValue('compl',$compl);
    $cmd->bindValue('tauxH',$tauxH);
    $cmd->bindValue('certif',$certif);
    $cmd->bindValue('archive',$archive);
    $cmd->bindValue('idSal',$id);
    $cmd->bindValue('suivi',$suivi);
    $cmd->bindValue('archiveTemporaire',$archiveTemporaire);
    $cmd->bindValue('dateFinArchiveTemporaire',$dateFinArchiveTemporaire);
    $cmd->bindValue('dateDebutArchiveTemporaire',$dateDebutArchiveTemporaire);
    $cmd->bindValue('repassage',$repassage);

    $cmd->execute();
    $cmd->closeCursor();
    
}

    public function modifierCandid($num, $titre, $nom, $prenom, $dateNaiss, $lieuNaiss, $paysNaiss, $natio, $numTS, $adresse, $cp, $ville, $quartier, $telPort, $telFixe, $telUrg, $email, $numSS, $permis, $vehicule, $statutPro, $sitFam, $diplomes, $qualifs, $expBBmoins1a, $enfantHand, $dispo, $cmu, $observ, $mutuelle, $nomJF, $dateTS, $secteurCandidat){
        $req = "UPDATE candidats set observations_Candidats=:observ, CMU_Candidats=:cmu, Mutuelle_Candidats=:mutuelle, titre_Candidats=:titre, nom_Candidats=upper(:nom), prenom_Candidats=:prenom, dateNaiss_Candidats=:dateNaiss, lieuNaiss_Candidats=:lieuNaiss, paysNaiss_Candidats=:paysNaiss, nationalite_Candidats=:natio, numTitreSejour=:numTS, numSS_Candidats=:numSS, Mutuelle_Candidats=NULL, CMU_Candidats=NULL, adresse_Candidats=:adresse, cp_Candidats=:cp, ville_Candidats=:ville, Quartier_Candidats=:quart, telPortable_Candidats=:telPort, telFixe_Candidats=:telFixe, TelUrg_Candidats=:telUrg, email_Candidats=:email, permis_Candidats=:permis, vehicule_Candidats=:vehicule, statutPro_Candidats=:statutPro, situationFamiliale_Candidats=:sitFam, diplomes_Candidats=:diplomes, qualifications_Candidats=:qualifs, expBBmoins1a_Candidats=:expBBmoins1a, enfantHand_Candidats=:enfantHand, disponibilites_Candidats=:dispo, observations_Candidats=NULL, nomJF_Candidats=:nomJF, dateTitreSejour=:dateTS, secteur_Candidats=:secteur where numCandidat_Candidats=:num;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('titre', $titre);
        $cmd->bindValue('nom', $nom);
        $cmd->bindValue('nomJF', $nomJF);
        $cmd->bindValue('prenom', $prenom);
        $cmd->bindValue('dateNaiss', $dateNaiss);
        $cmd->bindValue('lieuNaiss', $lieuNaiss);
        $cmd->bindValue('paysNaiss', $paysNaiss);
        $cmd->bindValue('natio', $natio);
        $cmd->bindValue('numTS', $numTS);
        $cmd->bindValue('numSS', $numSS);
        $cmd->bindValue('cmu', $cmu);
        $cmd->bindValue('mutuelle',$mutuelle);
        $cmd->bindValue('observ', $observ);
        $cmd->bindValue('adresse', $adresse);
        $cmd->bindValue('cp', $cp);
        $cmd->bindValue('ville', $ville);
        $cmd->bindValue('quart', $quartier);
        $cmd->bindValue('telPort', $telPort);
        $cmd->bindValue('telFixe', $telFixe);
        $cmd->bindValue('telUrg', $telUrg);
        $cmd->bindValue('email', $email);
        $cmd->bindValue('permis', $permis);
        $cmd->bindValue('vehicule', $vehicule);
        $cmd->bindValue('statutPro', $statutPro);
        $cmd->bindValue('sitFam', $sitFam);
        $cmd->bindValue('diplomes', $diplomes);
        $cmd->bindValue('qualifs', $qualifs);
        $cmd->bindValue('expBBmoins1a', $expBBmoins1a);
        $cmd->bindValue('enfantHand', $enfantHand);
        $cmd->bindValue('dispo', $dispo);
        $cmd->bindValue('num', $num);
        $cmd->bindValue('dateTS', $dateTS);
        $cmd->bindValue('secteur', $secteurCandidat);

        $cmd->execute();
        $cmd->closeCursor();
    }

    public function obtenirNumLastCandid(){
        $req = "SELECT max(numCandidat_Candidats) as max from Candidats;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        $num = $res['max'];
        return $num;
    }
    public function obtenirRacineFichierEtFormat(){
        $req ="SELECT * from paramFact LIMIT 0,1";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }
/*        public function modifRacineFichierEtFormat($racine, $nvFormat){
        $req= "SELECT * from paramFact LIMIT 0,1";
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $format="";
        foreach ($res as $unres)
        {
            $format=$unres["format"];
        }
        $req ="UPDATE paramfact set racine = :racine, format = :nvformat where format= format";
        $cmd->bindValue('racine', $racine);
        $cmd->bindValue('nvformat', $nvFormat);
        $cmd->bindValue('format', $format);
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $cmd->closeCursor();
    }

*/






    function countEnfants(){
        $req="SELECT count(*) from enfants JOIN famille ON enfants.numero_Famille=famille.numero_Famille WHERE famille.archive_Famille=0";
        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $lignes=$lignes['count(*)'];
        $cmd->closeCursor();
        return $lignes;
    }
     function countEnfants3(){
        $req="SELECT count(*) from enfants JOIN famille ON enfants.numero_Famille=famille.numero_Famille where datediff(now(),dateNaiss_Enfants)<1095 AND famille.archive_Famille=0";
        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetch();
        $lignes=$lignes['count(*)'];
        $cmd->closeCursor();
        return $lignes;
    }
    PUBLIC FUNCTION obtenirDispoMenage($numeroInterv){
        $req="select * from disponibilitesintervenants where numero_intervenant=:numInterv and activite='menage' order by jour DESC;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numInterv',$numeroInterv);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();

        return $lignes;
    }
    
    public function ObtenirDispoCandidMenage($numeroCandidat){
        $req="select * from disponibilitesintervenants where numero_Candidat=:numeroCandidat and activite='menage' order by jour DESC;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numeroCandidat',$numeroCandidat);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();

        return $lignes;

    }






    public function nbFamille($activite){
        $req="Select distinct numero_famille from besoinsfamille where activite=:activite";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('activite',$activite);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();

        return $lignes;
    }

    public function nbInterv($activite){
        $req="Select distinct numero_Intervenant from disponibilitesintervenants join intervenants on disponibilitesintervenants.numero_Intervenant=intervenants.numSalarie_Intervenants where activite=:activite and archive_Intervenants=0;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('activite',$activite);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();

        return $lignes;
    }
    public function obtenirBesoinsGEFamille()
    {
        $req="SELECT distinct besoinsfamille.numero_famille ,jour,famille.quartier_Famille,REG_Famille, famille.ville_Famille,
         activite, heureDebut, heureFin,frequence, Date_aPourvoir_PGE, enfantHand_Famille, P.nom_Parents,PM_Famille,PGE_Famille 
         from besoinsfamille 
         join famille on besoinsfamille.numero_famille=famille.numero_Famille 
         join parents as P on besoinsfamille.numero_famille=P.numero_Famille
         where activite='garde d\'enfants' and famille.archive_Famille=0
         order by besoinsfamille.numero_famille ASC";
        //jointure avec la table parent pour récuperer le nom de la famille et distinct pour éviter les doublons de lignes (si pas de distinct les lignes doublent ou triplent à cause de la jointure)
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;

    }

    //Récupère toutes les familles à pourvoir en GE (besoin ou non)
    public function ObtenirFamilleApourvoirGE(){
        $req = "SELECT distinct famille.numero_Famille, quartier_Famille, REG_Famille, ville_Famille, Date_aPourvoir_PGE, Pa.nom_Parents, PM_Famille,
        PGE_Famille, besoinsfamille.jour, besoinsfamille.activite, besoinsfamille.heureDebut, besoinsfamille.heureFin, besoinsfamille.frequence
        FROM famille
        JOIN besoinsfamille ON famille.numero_Famille=besoinsfamille.numero_famille
        JOIN parents AS Pa ON famille.numero_Famille=Pa.numero_Famille
        LEFT JOIN proposer AS Pr ON Pr.numero_Famille=famille.numero_Famille
        WHERE activite='garde d\'enfants' AND famille.archive_Famille=0 AND NOT EXISTS(
            SELECT * FROM proposer WHERE (dateFin_Proposer>now() OR dateFin_Proposer='0000-00-00') AND numero_Famille=Pr.numero_Famille)
        ORDER BY besoinsfamille.numero_famille ASC";
        //jointure avec la table parent pour récuperer le nom de la famille et distinct pour éviter les doublons de lignes (si pas de distinct les lignes doublent ou triplent à cause de la jointure)
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function ObtenirFamilleApourvoirGEFutur(){
        $req = "SELECT DISTINCT famille.numero_Famille, quartier_Famille, REG_Famille, ville_Famille, Date_aPourvoir_PGE, Pa.nom_Parents, PM_Famille,
        PGE_Famille, besoinsfamille.jour, besoinsfamille.activite, besoinsfamille.heureDebut, besoinsfamille.heureFin, besoinsfamille.frequence, Pr.dateFin_Proposer, Can.nom_Candidats, Pr.numSalarie_Intervenants
        FROM famille
        JOIN proposer AS Pr ON Pr.numero_Famille=famille.numero_Famille
        JOIN parents AS Pa ON famille.numero_Famille=Pa.numero_Famille
        LEFT JOIN besoinsfamille ON famille.numero_Famille=besoinsfamille.numero_famille AND activite='garde d\'enfants'
        JOIN intervenants ON Pr.numSalarie_Intervenants=intervenants.numSalarie_Intervenants
        JOIN candidats AS Can ON Can.numCandidat_Candidats=intervenants.candidats_numcandidat_candidats
        WHERE archive_Famille=0 AND Can.nom_Candidats <> '' AND aPourvoir_PGE = 1 AND Pr.idPresta_Prestations ='ENFA' AND (Pr.dateFin_Proposer>now() OR Pr.dateFin_Proposer='0000-00-00')
        ORDER BY famille.numero_Famille ASC, Pr.dateFin_Proposer ASC";
       
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    } 

    //Récupère toutes les familles à pourvoir en Ménage (besoin ou non)
    public function ObtenirFamilleApourvoirM(){
        $req = "SELECT distinct famille.numero_Famille,quartier_Famille, REG_Famille, ville_Famille, Date_aPourvoir_PM, Pa.nom_Parents, PM_Famille,
        PGE_Famille
        from famille 
        LEFT JOIN besoinsfamille ON famille.numero_Famille=besoinsfamille.numero_famille 
        join parents AS Pa ON Pa.numero_Famille=famille.numero_Famille
        left join proposer ON famille.numero_Famille=proposer.numero_Famille 
        where archive_Famille=0 AND famille.aPourvoir_PM = 1 AND NOT EXISTS(
            SELECT * FROM proposer WHERE (dateFin_Proposer>now() OR dateFin_Proposer='0000-00-00') AND famille.numero_Famille = numero_Famille AND idPresta_Prestations ='MENA' )
        GROUP BY famille.numero_Famille 
        ORDER BY famille.numero_Famille";
       
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function ObtenirFamilleApourvoirMFutur(){ 
        $req = "SELECT DISTINCT famille.numero_Famille, quartier_Famille, REG_Famille, ville_Famille, Date_aPourvoir_PM, Pa.nom_Parents, PM_Famille,
        PGE_Famille, besoinsfamille.jour, besoinsfamille.activite, besoinsfamille.heureDebut, besoinsfamille.heureFin, besoinsfamille.frequence, Pr.dateFin_Proposer, Can.nom_Candidats, Pr.numSalarie_Intervenants
        FROM famille
        JOIN proposer AS Pr ON Pr.numero_Famille=famille.numero_Famille
        JOIN parents AS Pa ON famille.numero_Famille=Pa.numero_Famille
        LEFT JOIN besoinsfamille ON famille.numero_Famille=besoinsfamille.numero_famille AND activite='menage'
        JOIN intervenants ON Pr.numSalarie_Intervenants=intervenants.numSalarie_Intervenants
        JOIN candidats AS Can ON Can.numCandidat_Candidats=intervenants.candidats_numcandidat_candidats
        WHERE archive_Famille=0 AND Can.nom_Candidats <> '' AND aPourvoir_PM = 1 AND Pr.idPresta_Prestations ='MENA' AND (Pr.dateFin_Proposer>now() OR Pr.dateFin_Proposer='0000-00-00')
        ORDER BY famille.numero_Famille ASC, Pr.dateFin_Proposer ASC";
       
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }




    
    public function obtenirBesoinsMFamille()
    {
        $req="SELECT distinct besoinsfamille.numero_famille,famille.quartier_Famille,REG_Famille, famille.ville_Famille
         ,jour, activite, heureDebut, heureFin,frequence, Date_aPourvoir_PM,P.nom_Parents,PM_Famille,PGE_Famille from besoinsfamille 
         join famille on besoinsfamille.numero_famille=famille.numero_Famille 
         join parents as P on besoinsfamille.numero_famille=P.numero_Famille
          where activite='menage' and famille.archive_Famille=0 
          order by besoinsfamille.numero_famille ASC";/*, jour DESC;";*/
        // jointure avec la table parent pour récuperer le nom de la famille et distinct 
        // pour éviter les doublons de lignes (si pas de distinct les lignes doublent ou triplent à cause de la jointure)

        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;

    }
    /*
    public function suppBesoinsGEFamille($numFamille)
    {
        $req="delete from besoinsfamille where numero_famille=:numerofamille and activite='garde d'enfants'";

        //jointure avec la table parent pour récuperer le nom de la famille et distinct pour éviter les doublons de lignes (si pas de distinct les lignes doublent ou triplent à cause de la jointure)
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numerofamille',$numFamille)
        $cmd->execute();
        $cmd->closeCursor();

    }
    public function suppBesoinsMFamille()
    {
        $req="delete from besoinsfamille where numero_famille=:numerofamille and activite='menage'";
        //jointure avec la table parent pour récuperer le nom de la famille et distinct pour éviter les doublons de lignes (si pas de distinct les lignes doublent ou triplent à cause de la jointure)
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numerofamille',$numFamille);
        $cmd->execute();
        $cmd->closeCursor();

    }*/
    public function suppIntervDispo($numCandidat){
        $req="DELETE FROM disponibilitesintervenants where numero_intervenant=:numCandidat ;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numCandidat',$numCandidat);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function obtenirDispoGE($numeroInterv){
        $req='select * from disponibilitesintervenants where numero_intervenant=:numInterv and activite="garde d\'enfants" order by jour DESC;';
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numInterv',$numeroInterv);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();

        return $lignes;
    }

    public function ObtenirDispoCandidGE($numeroCandidat){
        $req='select * from disponibilitesintervenants where numero_Candidat=:numeroCandidat and activite="garde d\'enfants" order by jour DESC;';
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numeroCandidat',$numeroCandidat);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();

        return $lignes;

    }



    public function obtenirtousDispoIntervM(){
        $req='SELECT D.id,D.numero_Intervenant,intervenants.idSalarie_Intervenants,candidats.nom_Candidats,D.activite,D.jour,D.heureDebut,D.heureFin,D.frequence, candidats.ville_Candidats,
        candidats.Quartier_Candidats, repassage_Intervenants, candidats.vehicule_Candidats, dateModif_Intervenants
        from intervenants 
        join candidats on intervenants.candidats_numcandidat_candidats=candidats.numCandidat_Candidats 
        join disponibilitesintervenants as D on intervenants.numSalarie_Intervenants=D.numero_Intervenant
        where activite="menage"
        order by candidats.nom_Candidats ASC';

        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();

        return $lignes;
    }
    public function obtenirtousDispoIntervGE(){
        $req='SELECT D.id,D.numero_Intervenant,intervenants.idSalarie_Intervenants,candidats.nom_Candidats,D.activite,D.jour,D.heureDebut,D.heureFin,D.frequence, candidats.ville_Candidats,
        candidats.Quartier_Candidats, candidats.expBBmoins1a_Candidats, candidats.enfantHand_Candidats, candidats.vehicule_Candidats, dateModif_Intervenants
        from intervenants 
        join candidats on intervenants.candidats_numcandidat_candidats=candidats.numCandidat_Candidats 
        join disponibilitesintervenants as D on intervenants.numSalarie_Intervenants=D.numero_Intervenant
        where activite="garde d\'enfants"
        order by candidats.nom_Candidats ASC';

        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();

        return $lignes;
    }
    public function suppToutAPourvoir($num){
        $req="DELETE FROM besoinsfamille where numero_famille=:num ;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num',$num);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function suppToutMPourvoir($num){
        $req="DELETE FROM besoinsfamille where numero_famille=:num AND activite='menage';";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num',$num);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function suppToutGEPourvoir($num){
        $req="DELETE FROM besoinsfamille where numero_famille=:num AND activite='garde d\'enfants';";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('num',$num);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function obtenirTousBesoinsFamille(){
        $req='select * from besoinsfamille";';
        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $lignes=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();

        return $lignes;
    }
    public function suppDispoInterv($id){
        $req="Delete from disponibilitesintervenants where id=:id;";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('id',$id);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function suppAllDispoIntervGE($numero){
        $req="DELETE FROM disponibilitesintervenants WHERE numero_Intervenant=:id AND activite='garde d\'enfants'";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('id',$numero);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function suppAllDispoIntervMenage($numero){
        $req="DELETE FROM disponibilitesintervenants WHERE numero_Intervenant=:id AND activite='menage'";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('id',$numero);
        $cmd->execute();
        $cmd->closeCursor();
    }





    PUBLIC FUNCTION obtenirIndispoActuelle($num){
        $req="SELECT * from proposer where proposer.numSalarie_Intervenants=:num and (dateFin_Proposer>now() or dateFin_Proposer='0000-00-00')";
        $cmd=$this->monPdo->prepare($req);
         $cmd->bindValue(":num", $num);
         $cmd->execute();
         $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function obtenirListeChampI(){
        $req="SELECT COLUMN_NAME, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE (TABLE_NAME='candidats' OR TABLE_NAME='intervenants') GROUP BY COLUMN_NAME HAVING COLUMN_NAME != 'candidats_numcandidat_candidats' AND COLUMN_NAME != 'candidatureRetenue_Candidats' ORDER BY find_in_set(COLUMN_NAME,'numCandidat_Candidats') DESC ,find_in_set(COLUMN_NAME,'idSalarie_Intervenants') DESC , TABLE_NAME";
        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    public function obtenirListeChampF(){
        $req="SELECT COLUMN_NAME, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='famille' OR TABLE_NAME='parents' OR TABLE_NAME='enfants'";
        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    public function obtenirListeVilleF(){
        $req="SELECT DISTINCT `ville_Famille`,`cp_Famille` FROM `famille` WHERE `ville_Famille`!= '' AND `ville_Famille` IS NOT NULL ORDER BY `famille`.`ville_Famille` ASC";
        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    public function obtenirDateSortieInt($num,$presta){
        $req="SELECT dateSortie_intervenants FROM proposer LEFT JOIN intervenants ON intervenants.numSalarie_Intervenants=proposer.numSalarie_Intervenants "
        . "WHERE proposer.numero_Famille=:num AND proposer.idPresta_Prestations=:prestation AND dateSortie_intervenants>NOW() ORDER BY dateSortie_intervenants ASC";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue(":num", $num);
        $cmd->bindValue(":prestation", $presta);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    public function obtenirDateFinPlanning($num,$presta){
        $req="SELECT dateFin_Proposer FROM proposer WHERE numero_Famille=:num AND dateFin_Proposer>NOW() "
        . "AND idPresta_Prestations=:prestation ORDER BY dateFin_Proposer ASC";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue(":num", $num);
        $cmd->bindValue(":prestation", $presta);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function obtenirListeSalariePlaces($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 and I.numSalarie_Intervenants not in (SELECT numSalarie_Intervenants from proposer where dateFin_Proposer>date(now()) or dateFin_Proposer='0000-00-00' and numero_Famille<>'9999') and I.numSalarie_Intervenants in (SELECT numSalarie_Intervenants FROM proposer) GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC;" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }

    public function obtenirListeSalarieJamaisPlaces($quoi){
        $req = "SELECT ".$quoi." from candidats as C join intervenants as I on I.candidats_numcandidat_candidats=C.numCandidat_Candidats where I.archive_Intervenants=0 AND I.numSalarie_Intervenants != 99999 and I.numSalarie_Intervenants not in (SELECT numSalarie_Intervenants from proposer) GROUP BY C.numCandidat_Candidats ORDER BY C.nom_Candidats ASC;" ;
        $cmd = $this->monPdo->prepare($req);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_NUM);
        $cmd->closeCursor();
        return $lignes;        
    }
    /*public function separer*/

    //public function obtenirinformationcarte(){}

    
    public function VerifDubli($nom, $dateNaissance){
        $req="SELECT nom_Candidats, dateNaiss_Candidats FROM candidats WHERE nom_Candidats=:nom AND dateNaiss_Candidats=:dateNaissance";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue(":nom", $nom);
        $cmd->bindValue(":dateNaissance", $dateNaissance);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    public function existeCandidat($num){
        $req="SELECT numSalarie_Intervenants FROM intervenants WHERE candidats_numcandidat_candidats =:num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue(":num", $num);
        $cmd->execute();
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }

    
    public function supprimerToutDispoCandidat($num){
        $req="DELETE FROM disponibilitesintervenants WHERE numero_Candidat =:num";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue(":num", $num);
        $cmd->execute();
        $cmd->closeCursor();
    }

    public function obtenirNumCandidat($nom, $prenom){
        $req="SELECT numCandidat_Candidats FROM candidats WHERE nom_Candidats=:nom AND prenom_Candidats=:prenom";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue(":nom", $nom);
        $cmd->bindValue(":prenom", $prenom);
        $cmd->execute();
        $ligne=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $ligne=$ligne[0]['numCandidat_Candidats'];
        $cmd->closeCursor();
        return $ligne;
    }   

    public function ObtenirLigneDemande($id){
        $req="SELECT * FROM besoinsfamille WHERE id=:id ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('id', $id);
        $cmd->execute();
        $ligne=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;
       }


    public function modifierLigneDemande($id, $jour, $exceptionJour, $heureSem, $hDeb, $hFin, $freq){
        $req="UPDATE besoinsfamille
        SET jour=:jour, exception=:exceptionJour, heureSemaine=:heureSem, heureDebut=:heureDebut, heureFin=:heureFin, frequence=:frequence
        WHERE id=:id";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue("jour",$jour);
        $cmd->bindValue("exceptionJour",$exceptionJour);
        $cmd->bindValue("heureSem",$heureSem);
        $cmd->bindValue("heureDebut", $hDeb);
        $cmd->bindValue("heureFin", $hFin);
        $cmd->bindValue("frequence",$freq);
        $cmd->bindValue("id", $id);
        $cmd->execute();
        $cmd->closeCursor();
    }

    public function obtenirLigneDispo($id){
        $req="SELECT * FROM disponibilitesintervenants WHERE id=:id ;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('id', $id);
        $cmd->execute();
        $ligne=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;
    }

    public function modifierLigneDispo($id, $jour, $hDeb, $hFin, $freq){
        $req="UPDATE disponibilitesintervenants
        SET jour=:jour, heureDebut=:heureDebut, heureFin=:heureFin, frequence=:frequence
        WHERE id=:id";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue("jour",$jour);
        $cmd->bindValue("heureDebut", $hDeb);
        $cmd->bindValue("heureFin", $hFin);
        $cmd->bindValue("frequence",$freq);
        $cmd->bindValue("id", $id);
        $cmd->execute();
        $cmd->closeCursor();
    }


    public function obtenirBesoinsFamilleByNumGE($num){
        $req="SELECT * FROM besoinsfamille WHERE numero_famille =:num AND activite='garde d\'enfants'";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue("num",$num);
        $cmd->execute();
        $ligne=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;
    }

    public function obtenirBesoinsFamilleByNumMenage($num){
        $req="SELECT * FROM besoinsfamille WHERE numero_famille =:num AND activite='menage'";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue("num",$num);
        $cmd->execute();
        $ligne=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;
    }





    public function obtenirToutDisposByNumIntervGE($numInterv){
        $req="SELECT * FROM disponibilitesintervenants WHERE numero_Intervenant=:numInterv AND activite = 'garde d\'enfants'";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue("numInterv",$numInterv);
        $cmd->execute();
        $ligne=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;
    }
    public function obtenirToutDisposByNumIntervMenage($numInterv){
        $req="SELECT * FROM disponibilitesintervenants WHERE numero_Intervenant=:numInterv AND activite = 'menage'";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue("numInterv",$numInterv);
        $cmd->execute();
        $ligne=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;
    }

    public function obtenirNumCandidatByNumInterv($numInterv){
        $req = "SELECT 	candidats_numcandidat_candidats FROM intervenants WHERE  numSalarie_Intervenants=:numInterv";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numInterv', $numInterv);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }

    public function masquerIntervMatchingGE($numFamille, $numInterv){
        $req="INSERT INTO antimatching(numero_Famille, numero_Intervenant, GE) VALUES(:numFamille, :numInterv, 1)";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numFamille', $numFamille);
        $cmd->bindValue('numInterv', $numInterv);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function masquerIntervMatchingMenage($numFamille, $numInterv){
        $req="INSERT INTO antimatching(numero_Famille, numero_Intervenant, menage) VALUES(:numFamille, :numInterv, 1)";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numFamille', $numFamille);
        $cmd->bindValue('numInterv', $numInterv);
        $cmd->execute();
        $cmd->closeCursor();
    }


    public function verifIntervMasque($numFamille, $numInterv){
        $req = "SELECT * FROM antimatching WHERE numero_Famille=:numFamille AND numero_Intervenant=:numInterv";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numFamille', $numFamille);
        $cmd->bindValue('numInterv', $numInterv);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $res;
    }

    public function updateIntervMasqueGE($numFamille, $numInterv, $masqueGE){
        $req="UPDATE antimatching SET GE =:masqueGE WHERE numero_Famille=:numFamille AND numero_Intervenant=:numInterv";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('masqueGE', $masqueGE);
        $cmd->bindValue('numFamille', $numFamille);
        $cmd->bindValue('numInterv', $numInterv);
        $cmd->execute();
        $cmd->closeCursor();
    }
    public function updateIntervMasqueMenage($numFamille, $numInterv, $masqueMenage){
        $req="UPDATE antimatching SET menage =:masqueMenage WHERE numero_Famille=:numFamille AND numero_Intervenant=:numInterv";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('masqueMenage', $masqueMenage);
        $cmd->bindValue('numFamille', $numFamille);
        $cmd->bindValue('numInterv', $numInterv);
        $cmd->execute();
        $cmd->closeCursor();
    }
    
    public function obtenirTousIntervenant(){
        $req="SELECT intervenants.numSalarie_Intervenants, intervenants.idSalarie_Intervenants, C.titre_Candidats, C.nom_Candidats, C.prenom_Candidats FROM intervenants
        JOIN candidats as C ON intervenants.candidats_numcandidat_candidats = C.numCandidat_Candidats";
        $cmd=$this->monPdo->prepare($req);
        $cmd->execute();
        $ligne=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;
    }

    public function obtenirIntervByIdSalarie($idSalarie){
        $req="SELECT intervenants.idSalarie_Intervenants, C.titre_Candidats, C.nom_Candidats, C.prenom_Candidats, C.telPortable_Candidats FROM intervenants
        JOIN candidats as C ON intervenants.candidats_numcandidat_candidats = C.numCandidat_Candidats
        WHERE intervenants.idSalarie_Intervenants=:idSalarie";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('idSalarie', $idSalarie);
        $cmd->execute();
        $ligne=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;
    }

    public function obtenirIntervByNumInterv($numInterv){
        $req="SELECT * FROM intervenants
        JOIN candidats as C ON intervenants.candidats_numcandidat_candidats = C.numCandidat_Candidats
        WHERE intervenants.numSalarie_Intervenants=:numInterv";
        $cmd=$this->monPdo->prepare($req);
        $cmd->bindValue('numInterv', $numInterv);
        $cmd->execute();
        $ligne=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $ligne;

    }
	
}