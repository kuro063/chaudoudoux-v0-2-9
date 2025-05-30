<?php 
class Matching{   		
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
public function obtenirBesoinsFamillesI($numeroInterv){
        $req="SELECT distinct B.id,B.numero_famille,P.nom_Parents,B.activite,B.jour as jourF, F.PM_Famille, F.PGE_Famille, B.heureDebut, B.heureFin,B.frequence, D.jour as jourI
        From besoinsfamille as B
        join disponibilitesintervenants as D ON B.heureDebut >= D.heureDebut AND B.heureFin<=D.heureFin AND (B.jour = D.jour OR B.jour = 'sans importance')
        join parents as P on B.numero_famille=P.numero_Famille 
        JOIN famille AS F on B.numero_famille=F.numero_Famille
        where numero_Intervenant=:numeroInterv and B.activite=D.activite and F.archive_Famille=0;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numeroInterv',$numeroInterv);
        $cmd->execute(); 
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
    }
    /**
    * variable a selectionner : $jour,$heureDeb,$heureFin
    */




public function obtenirIntervenantsRechCompl($numeroFamille){
    $req ="SELECT DISTINCT D.id,D.numero_Intervenant,candidats.nom_Candidats,D.activite,D.jour,D.heureDebut,D.heureFin,D.frequence,
    idSalarie_Intervenants 
    from intervenants 
    join candidats on intervenants.candidats_numcandidat_candidats=candidats.numCandidat_Candidats
    join disponibilitesintervenants as D on intervenants.numSalarie_Intervenants=D.numero_Intervenant 
    join besoinsfamille as B ON D.heureDebut <= B.heureDebut AND D.heureFin>=B.heureFin AND (B.jour = D.jour OR B.jour = 'sans importance')
    where intervenants.rechCompl_Intervenants = 1 and B.numero_famille =:numero_famille and D.frequence=B.frequence and B.activite=D.activite 
    ORDER BY D.numero_Intervenant ASC; ";

    $cmd = $this->monPdo->prepare($req);
    $cmd->bindValue('numero_famille',$numeroFamille);
    $cmd->execute(); 
    $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
    $cmd->closeCursor();
    return $lignes;
}


public function obtenirIntervenantsRechComplGE($numeroFamille){
    $req ="SELECT DISTINCT D.id,D.numero_Intervenant,candidats.nom_Candidats,D.activite,D.jour,D.heureDebut,D.heureFin,D.frequence,
    idSalarie_Intervenants 
    from intervenants 
    join candidats on intervenants.candidats_numcandidat_candidats=candidats.numCandidat_Candidats
    join disponibilitesintervenants as D on intervenants.numSalarie_Intervenants=D.numero_Intervenant 
    join besoinsfamille as B ON D.heureDebut <= B.heureDebut AND D.heureFin>=B.heureFin AND (B.jour = D.jour OR B.jour = 'sans importance')
    where intervenants.rechCompl_Intervenants = 1 and B.numero_famille =:numero_famille and D.frequence=B.frequence AND D.activite = 'garde d\'enfants' and B.activite=D.activite
    ORDER BY D.numero_Intervenant ASC; ";
    $cmd = $this->monPdo->prepare($req);
    $cmd->bindValue('numero_famille',$numeroFamille);
    $cmd->execute(); 
    $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
    $cmd->closeCursor();
    return $lignes;
}
public function obtenirIntervenantsRechComplMenage($numeroFamille){
    $req ="SELECT DISTINCT D.id,D.numero_Intervenant,candidats.nom_Candidats,D.activite,D.jour,D.heureDebut,D.heureFin,D.frequence,
    idSalarie_Intervenants 
    from intervenants 
    join candidats on intervenants.candidats_numcandidat_candidats=candidats.numCandidat_Candidats
    join disponibilitesintervenants as D on intervenants.numSalarie_Intervenants=D.numero_Intervenant 
    join besoinsfamille as B ON D.heureDebut <= B.heureDebut AND D.heureFin>=B.heureFin AND (B.jour = D.jour OR B.jour = 'sans importance')
    where intervenants.rechCompl_Intervenants = 1 and B.numero_famille =:numero_famille and D.frequence=B.frequence AND D.activite = 'menage' and B.activite=D.activite
    ORDER BY D.numero_Intervenant ASC; ";
    $cmd = $this->monPdo->prepare($req);
    $cmd->bindValue('numero_famille',$numeroFamille);
    $cmd->execute(); 
    $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
    $cmd->closeCursor();
    return $lignes;
}









public function obtenirAllnumFamilleBesoinsGE(){
    $req ="SELECT DISTINCT numero_famille FROM besoinsfamille WHERE activite = 'garde d\'enfants'";
    $cmd = $this->monPdo->prepare($req);
    $cmd->execute(); 
    $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
    $cmd->closeCursor();
    return $lignes;
}

public function obtenirAllnumFamilleBesoinsMenage(){
    $req ="SELECT DISTINCT numero_famille FROM besoinsfamille WHERE activite = 'menage'";
    $cmd = $this->monPdo->prepare($req);
    $cmd->execute(); 
    $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
    $cmd->closeCursor();
    return $lignes;
}

public function obtenirIntervenantsDispo($numeroFamille){
    $req ="SELECT DISTINCT D.id,D.numero_Intervenant,candidats.nom_Candidats,D.activite,D.jour,D.heureDebut,D.heureFin,D.frequence,idSalarie_Intervenants
    from intervenants 
    join candidats on intervenants.candidats_numcandidat_candidats=candidats.numCandidat_Candidats 
    join disponibilitesintervenants as D on intervenants.numSalarie_Intervenants=D.numero_Intervenant 
    join besoinsfamille as B ON D.heureDebut <= B.heureDebut AND D.heureFin>=B.heureFin AND (B.jour = D.jour OR B.jour = 'sans importance')
    where intervenants.rechCompl_Intervenants = 0 and B.numero_famille =:numero_famille AND D.frequence=B.frequence and B.activite=D.activite 
    ORDER BY D.numero_Intervenant ASC;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numero_famille',$numeroFamille);
        $cmd->execute(); 
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
}

public function obtenirIntervenantsDispoGE($numeroFamille){
    $req ="SELECT DISTINCT D.id,D.numero_Intervenant,candidats.nom_Candidats,D.activite,D.jour,D.heureDebut,D.heureFin,D.frequence,idSalarie_Intervenants
    from intervenants 
    join candidats on intervenants.candidats_numcandidat_candidats=candidats.numCandidat_Candidats 
    join disponibilitesintervenants as D on intervenants.numSalarie_Intervenants=D.numero_Intervenant 
    join besoinsfamille as B ON D.heureDebut <= B.heureDebut AND D.heureFin>=B.heureFin AND (B.jour = D.jour OR B.jour = 'sans importance')
    where intervenants.rechCompl_Intervenants = 0 and B.numero_famille =:numero_famille AND D.frequence=B.frequence AND D.activite = 'garde d\'enfants' and B.activite=D.activite
    ORDER BY D.numero_Intervenant ASC;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numero_famille',$numeroFamille);
        $cmd->execute(); 
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
}

public function obtenirIntervenantsDispoMenage($numeroFamille){
    $req ="SELECT DISTINCT D.id,D.numero_Intervenant,candidats.nom_Candidats,D.activite,D.jour,D.heureDebut,D.heureFin,D.frequence,idSalarie_Intervenants
    from intervenants 
    join candidats on intervenants.candidats_numcandidat_candidats=candidats.numCandidat_Candidats 
    join disponibilitesintervenants as D on intervenants.numSalarie_Intervenants=D.numero_Intervenant 
    join besoinsfamille as B ON D.heureDebut <= B.heureDebut AND D.heureFin>=B.heureFin AND (B.jour = D.jour OR B.jour = 'sans importance') 
    where intervenants.rechCompl_Intervenants = 0 and B.numero_famille =:numero_famille AND D.frequence=B.frequence and D.activite = 'menage'  AND B.activite=D.activite 
    ORDER BY D.numero_Intervenant ASC;";
        $cmd = $this->monPdo->prepare($req);
        $cmd->bindValue('numero_famille',$numeroFamille);
        $cmd->execute(); 
        $lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        return $lignes;
}








public function obtenirBesoinFamilleByIDintervenantDispo($numeroInterv, $numeroFamille, $id){
    $req="SELECT distinct B.id,B.numero_famille,P.nom_Parents,B.activite,B.jour as jourF, F.PM_Famille, F.PGE_Famille, B.heureDebut as heureDebutFamille, B.heureFin as heureFinFamille,B.frequence, D.jour as jourI
    From besoinsfamille as B
    join disponibilitesintervenants as D ON B.heureDebut >= D.heureDebut AND B.heureFin<=D.heureFin AND (B.jour = D.jour OR B.jour = 'sans importance')
    join parents as P on B.numero_famille=P.numero_Famille 
    JOIN famille AS F on B.numero_famille=F.numero_Famille
    where numero_Intervenant=:numeroInterv and B.activite=D.activite and F.archive_Famille=0 and B.numero_famille=:numeroFamille and D.id =:id;";
    $cmd = $this->monPdo->prepare($req);
    $cmd->bindValue('numeroInterv',$numeroInterv);
    $cmd->bindValue('numeroFamille', $numeroFamille);
    $cmd->bindValue('id', $id);
    $cmd->execute(); 
    //$lignes = $cmd->fetchAll(PDO::FETCH_ASSOC);
    $res = $cmd->fetch();
    $cmd->closeCursor();
    return $res;
}


}
?>