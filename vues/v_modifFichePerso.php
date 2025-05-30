
<!-- Division pour le contenu principal -->
    <div id="contenu">
      <h2>Modifier le mot de passe</h2>
      <form id="frmPerso" action="index.php?uc=fichePerso&amp;action=validerModif" method="post">
<?php
        if ( nbErreurs($tabErreurs) != 0 ) {
          echo toHtmlErreurs($tabErreurs);
        } 
 ?>
<?php
        if ( !empty($messageInfo) ) {?>
            <p class="info"><?php echo $messageInfo; ?></p>
<?php   } 
 ?>
  <div id="corpsForm">
  <fieldset>
  <p>
    <label for="txtMdp">Mot de passe actuel : </label>
    <input type="password" id="txtMdp" name="txtMdp" maxlength="16" size="16" value="" />
  </p>

  <p>
    <label for="txtNMdp">Nouveau mot de passe : </label>
    <input type="password" id="txtNMdp" name="txtNMdp" maxlength="16" size="16" value="" />
  </p>
  <p>
    <label for="confNMdp">Confirmer le nouveau mot de passe : </label>
    <input type="password" id="confNMdp" name="confNMdp" maxlength="16" size="16" value="" />
  </p>

  
  </fieldset>
  </div>
  <div id="piedForm">
  <p>
      <input id="cmdOk" type="submit" value="OK" />
      <input id="cmdAnnuler" type="reset" value="Annuler" />
  </p> 
  </div>
  </form>
</div>      
