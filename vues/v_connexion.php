<?php 

    if (!estConnecte()){?>
    
    
    <div id="globale">
        
        <form id="frmConnexion" action="index.php?uc=connexion&amp;action=validerConnexion" method="post">


            <div id="connexion">

                <p>
                    <h3>Identification utilisateur</h3>
                </p>    

                <?php
                if (nbErreurs($tabErreurs) != 0 ) {
                    echo toHtmlErreurs($tabErreurs);
                }  
                ?>
                
                <p> 
                    <input type="text" id="txtNom" class="connexion" name="txtNom" placeholder="nom d'utilisateur" maxlength="30" size="30" value=""/>
                </p>
                <p>
                    <input type="password" id="txtMdp" class="connexion" name="txtMdp" placeholder="mot de passe" maxlength="15" size="30" value=""/>
                </p>
                <p>
                    <!--<input type="submit" id="ok" value="Se connecter"> <a href="index.php?uc=connexion&action=demanderConnexion" </a>> -->
                    <input type="submit" id="ok" value="Se connecter" href="index.php?uc=connexion&action=demanderConnexion">
                    <!--<input type="submit" id="ok" value="Se connecter" href="accueil.php">-->
                <p>
            </div>
        </form>
    </div>
    
<?php }  ?>