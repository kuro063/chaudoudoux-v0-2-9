<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>mysql.general_log</title>
        <meta charset="UTF-8">
        <style>th,td,tr,table{border: solid 1px black; 
            border-collapse: collapse;}</style>
    </head>
    <body><?php
                   $chaineConnexion = 'mysql:host=localhost;dbname=mysql';
                    // demande que le dialogue se fasee en utilisant l'encodage utf-8
                      // et le mode de gestion des erreurs soit les exceptions
        $params = array (   PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", 
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        // crée une instance de PDO (connexion avec le serveur MySql) 
        $monPdo = new PDO($chaineConnexion, 'root', '', $params); 
        $req= " select * from general_log"
                . " where user_host<> 'root[root] @ localhost [127.0.0.1]' "
                . "and user_host <> 'root[root] @ localhost [::1]' "
                . "and user_host <> 'pma[pma] @ localhost [127.0.0.1]'"
                . "and user_host <> '[root] @ localhost [::1]'"
                . "and user_host <> '[root] @ localhost [127.0.0.1]'"
                . "and user_host <> '[root] @ localhost [::1]'"
                . "and user_host <> '[pma] @ localhost [127.0.0.1]' "
                . "and event_time <> DATE_SUB(NOW(), INTERVAL 3 DAY) "
                . "and argument <> 'SET NAMES utf8' "
                . "and command_type <>'Connect' "
                . "and command_type <>'Quit'"
                . "order by event_time desc";
                
        $cmd=$monPdo->prepare($req);
        $cmd->execute();
        $lesReq=$cmd->fetchAll(PDO::FETCH_ASSOC);
        $cmd->closeCursor();
        ?>
        <h2>Historique des requêtes SQL des 3 derniers jours</h2>
        <table>
            <tr><th>Date/Heure</th><th>Utilisateur</th><th>thread_id</th><th>server_id</th><th>Type de commande</th><th>Commande</th>
                <?php foreach($lesReq as $uneReq)
                {
                    $datetime=$uneReq['event_time'];
                    $user=$uneReq['user_host'];
                    $thread=$uneReq['thread_id'];
                    $server=$uneReq['server_id'];
                    $type=$uneReq['command_type'];
                    $commande=$uneReq['argument'];
                    echo '<tr><td>'.$datetime.'</td><td>'.$user.'</td><td>'.$thread.'</td><td>'.$server.'</td><td>'.$type.'</td><td>'.$commande.'</td></tr>';
                }?>
        </table>
                <?php $monPdo=null;?>
    </body>
</html>