
<body>

<div class="center-screen">

    <div class="mb-3"> 
        <h1 style="text-align:center">Carnet d'adresses mail</h1> 
    </div>
    <div class="lescol" style="clear:both;display:table">
       
        <div style="float:left; width:30%">
        <h5>En ce moment</h5>
        <a class="btn btn-lg btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=mailIntervPrestAct" style="background-color:blue;">Tous les Intervenants Prestataires</a><br>
        <a class="btn btn-lg btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=mailIntervPrestGEAct">Intervenants Prestataires<br>Garde Enfant </a><br> <!-- style="font-size: 2em; width: 20%;"  -->
        <a class="btn btn-lg btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=mailIntervPrestMenAct">Intervenants Prestataires<br>Ménage</a><br>
        <a class="btn btn-lg btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=mailIntervMandAct">Intervenants Mandataires</a><br>
        <a class="btn btn-lg btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=mailIntervDisp">Intervenants Disponibles</a><br>
        <a class="btn btn-lg btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=mailIntervArchiv">Intervenants Archivés</a>
        </div>
        <div style="float:left; width:30%">        
        <h5>Au moins une fois</h5>
        <a class="btn btn-lg btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=mailIntervPrest"> Tous les Intervenants Prestataires</a><br>
        <a class="btn btn-lg btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=mailIntervPrestGE">Intervenants Prestataires<br>Garde Enfant </a><br> <!-- style="font-size: 2em; width: 20%;" -->
        <a class="btn btn-lg btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=mailIntervPrestMen">Intervenants Prestataires<br>Ménage</a><br>
        <a class="btn btn-lg btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=mailIntervMand">Intervenants Mandataires</a><br>
        <a class="btn btn-lg btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=mailIntervSansDispo">Adresse mail des intervenants en attente de disponibilités</a><br>
        </div>
        <div style="float:left; width:30%">
        <h5>Famille</h5>
        <a class="btn btn-lg btn-primary display-4" href="index.php?uc=annuFamille&amp;action=mailFamPrestGE">Familles Prestataires <br> Garde Enfant </a><br>
        <a class="btn btn-lg btn-primary display-4" href="index.php?uc=annuFamille&amp;action=mailFamPrestMen">Familles Prestataires <br> Ménage</a><br>
        <a class="btn btn-lg btn-primary display-4" href="index.php?uc=annuFamille&amp;action=mailFamMand">Familles Mandataires</a>
        </div>

    </div>

</div>

<script>
var map = L.map('map').setView([51.505, -0.09], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

L.marker([51.5, -0.09]).addTo(map)
    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
    .openPopup();
</script>

<button style="position:fixed;bottom:0px;left:0px" class="retour btn " onclick="history.go(-1);">RETOUR</button>
