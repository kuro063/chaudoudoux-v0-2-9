<div class="center-screen">

    <div class="mb-3"> 
        <h1 style="margin-bottom:10px;text-align:center"> Confirmez la suppression de : </h1> <h1 style="margin-top:20px;border:1px dotted black; padding:2%;"> <span style="font-weight:bold;"> <?php echo $nomForm['intitule_Formations']?> </span> <br> pour l'intervenant : <span style="font-weight:bold;"> <?php echo $nom ?> </span> </h1> 
    </div>
    
    <div style="clear:both;display:table">
        
        <div style="float:left; width:50%">
            <button class="btn btn-lg btn-secondary btn-block display-4" onclick="history.go(-1);"> NON </button>  
        </div>

        <div style="float:left; width:50%">
            <a class="btn btn-lg btn-primary display-4" href="index.php?uc=annuSalarie&amp;action=suppressionConfirmeeFormation&amp;num=<?php echo $num ?>&amp;numForm=<?php echo $numForm ?>"> OUI </a>
        </div>

    </div>
    
</div>