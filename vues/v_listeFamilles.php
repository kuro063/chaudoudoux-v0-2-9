<!--Vincent bouton vers le haut de page--> 
<button class="button" onclick="topFunction()" id="topBtn"><img src="images/toTop.png" width="60"></button>

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

<!--Scripts d'affichage des distances-->
<script src="./styles/geo-api.js"></script>
  <script defer type="module">
    import { getDistance } from "./styles/geo-api.js";
    (async () => {
  const tab = document.getElementById("listeFamilles");
  for (const line of tab.rows) {
    const firstTd = line.querySelector("td");
    if (!line.querySelector("th") && firstTd && firstTd.textContent.trim() !== "") {
      //const addr_can = line.querySelectorAll("td")[6].textContent.trim();
      const addr_fam = line.querySelectorAll("td")[5].textContent.trim() +" "+ line.querySelectorAll("td")[6].textContent.trim() +" "+ line.querySelectorAll("td")[7].textContent.trim();
      const addr_chau = "22 rue jean Guéhenno, 35700, Rennes";

      //const dist_can_fam = line.querySelectorAll("td")[7];
      const dist_chau_fam = line.querySelectorAll("td")[32];

      //if (addr_fam) {
        //dist_can_fam.textContent = await getDistance(addr_can, addr_fam) + "Km";
      //}

      dist_chau_fam.textContent = await getDistance(addr_chau, addr_fam) + " Km";


    }
  }
})();
  </script>
<html>
<head>
<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $lesFamilles array */
?>
<!-- Division pour le contenu principal -->


<script type="text/javascript">


/*function uncheckAll(divid) {
    $('#' + divid + ' :checkbox:disabled').prop('checked', false);
}*/



/*$("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});*/



/*function uncheckAll(divid) {
    var checks = document.querySelectorAll('#' + divid + ' input[type="checkbox"]');
    for(var i =0; i< checks.length;i++){
        var check = checks[i];
        if(!check.disabled){
            check.checked = false;
        }
    }
}*/

/*function hide_show_all(divid)
{
var checkbox_val=document.getElementById(col_name).value;
if(checkbox_val=="hide")
	{
		var all_col=
		document.getElementById(col_name).value="show";
	}
	else
	{
		document.getElementById(col_name).value="hide";
	}	
}*/

function check_uncheck_checkbox(isChecked) 
{
	var ToutLeTab = document.getElementById('listeFamilles');

		if(isChecked)
		{
			$('input[name="col"]').each(function() { 
				this.checked = true;
				this.onchange();//change l'etat de chaque élément
				//ToutLeTab.hidden=false; //cache tout le tableau, inutile
			});
		} 
		else 
		{
			$('input[name="col"]').each(function() {
				this.checked = false;
				this.onchange();
				//ToutLeTab.hidden=true;
			});
		}
}

// hide_show_table initial
function marche(col_name)
{
 	var checkbox_val=document.getElementById(col_name).value;

 	if(checkbox_val=="hide")
  	{
  		var all_col=document.getElementsByClassName(col_name);
  		for(var i=0;i<all_col.length;i++)
  		{
   			all_col[i].style.display="none";
  		}
  		document.getElementById(col_name+"_head").style.display="none";
  		document.getElementById(col_name).value="show";
  	}
  
 	else
  	{
  		var all_col=document.getElementsByClassName(col_name);

  		for(var i=0;i<all_col.length;i++)
  		{
   			all_col[i].style.display="table-cell";
  		}
  		document.getElementById(col_name+"_head").style.display="table-cell";
  		document.getElementById(col_name).value="hide";
  	}
}

// Simon hide_show_table

function hide_show_table(col_name)
{
	var checkbox = document.getElementById(col_name).checked;
	 
 	if(checkbox==false)
  	{
  		var all_col=document.getElementsByClassName(col_name);
  		for(var i=0;i<all_col.length;i++)
  		{
   			all_col[i].hidden = true;
  		}
  		document.getElementById(col_name+"_head").hidden = true;
  		document.getElementById(col_name).value="show";
  	}
 	else
  	{
  		var all_col=document.getElementsByClassName(col_name);
  		for(var i=0;i<all_col.length;i++)
  		{
   			all_col[i].hidden = false;
  		}
  		document.getElementById(col_name+"_head").hidden = false;
  		document.getElementById(col_name).value="hide";
  	}
}

 </script>

<!--/*var checkbox_check=document.getElementById('input[name="col"]').checked*/
/*document.getElementById(col_name+"_head").style.display="none";
document.getElementById(col_name).value="show";*/
/*document.getElementById(col_name+"_head").style.display="table-cell";
document.getElementById(col_name).value="hide";*/-->


<?php error_reporting ( 0 ); ?>

<a class="btn btn-secondary display-4 sideButton" style="float:right;position:absolute;right:10px" href="index.php?uc=search&amp;action=advSearchF">RECHERCHE AVANCÉE</a>
<!--Liste des cases à cocher pour afficher ou cacher les colonnes du tableau-->
<div class="deroule">
<span><h2 class="revert dropdown-toggle" style="cursor:pointer;padding:10px;border-style:solid;border-width:2px;text-align:center;border-color:#4d4d4d">AFFICHAGE COLONNES</h2></span>
<div class="deroule-content" style="column-count: 4">
<!--35 ligne pour un tableau de familles entier en regroupant tous ceux de l'application-->

	<label class="container"><b>Tout cocher / décocher</b>
	<input type="checkbox" onchange="check_uncheck_checkbox(this.checked);" checked>
	<span class="checkmark"></span>
	</label>

	<label class="container"><b>M</b>
	<input type="checkbox" name="col" value="hide" id="m_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<?php if (/*$action !='vueMand' && $action != 'vuePrestGE' &&*/ $action!='voirTousFact'){?>


	<label class="container"><b>PM</b>
	 <input type="checkbox" name="col" value="hide" id="pm_col" onchange="hide_show_table(this.id);" checked>
	 <span class="checkmark"></span>
	</label>

	<?php } if (/*$action != 'vuePrestM' && $action !='vueMand' && */$action !='voirTousFact'){?>


	<label class="container"><b>PGE</b>
 	<input type="checkbox" name="col" value="hide" id="pge_col" onchange="hide_show_table(this.id);" checked>
	 <span class="checkmark"></span>
	</label>
	<?php }/*if($action !='vuePrestM' && $action != 'vuePrestGE'){*/?>


	<label class="container"><b>REG</b>
	<input type="checkbox" name="col" value="hide" id="reg_col" onchange="hide_show_table(this.id);" checked><?php /*}*/?>
	<span class="checkmark"></span>
	</label>
	<label class="container"><b>NOM(S)</b>
 	<input type="checkbox" name="col" value="hide" id="nom_col" onchange="hide_show_table(this.id);" checked>
	 <span class="checkmark"></span>
	</label>
	<?php if ($action !='voirTousFact'){?>

	<!--Coordonnées de la famille et des parents-->
	<label class="container"><b>ADRESSE</b>
	<input type="checkbox" name="col" value="hide" id="adresse_col" onchange="hide_show_table(this.id);" checked>
  	<span class="checkmark"></span>
	</label>
	<label class="container"><b>CODE POSTAL</b>
	<input type="checkbox" name="col" value="hide" id="codepostal_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<label class="container"><b>VILLE</b>
	 <input type="checkbox" name="col" value="hide" id="ville_col" onchange="hide_show_table(this.id);" checked>
	 <span class="checkmark"></span>
	</label>

	<?php /*assemblée générale*/if ($action!='assembGen'){?>
	 <label class="container"><b>EMAIL MÈRE</b>
	 <input type="checkbox" name="col" value="hide" id="mailmere_col" onchange="hide_show_table(this.id);" checked>
	 <span class="checkmark"></span>
	</label>
	 <label class="container"><b>EMAIL PÈRE</b>
	 <input type="checkbox" name="col" value="hide" id="mailpere_col" onchange="hide_show_table(this.id);" checked>
	 <span class="checkmark"></span>
	</label>
	 <label class="container"><b>DOMICILE</b>
	 <input type="checkbox" name="col" value="hide" id="domicile_col" onchange="hide_show_table(this.id);" checked>
	 <span class="checkmark"></span>
	</label>
	 <label class="container"><b>PORTABLE MÈRE</b>
	 <input type="checkbox" name="col" value="hide" id="portmere_col" onchange="hide_show_table(this.id);" checked>
	 <span class="checkmark"></span>
	</label>
	 <!--<label class="container"><b>PROFESSION MÈRE</b>
	 <input type="checkbox" name="col" value="hide" id="profmere_col" onchange="hide_show_table(this.id);" checked>
	 <span class="checkmark"></span>
	</label>
	 <label class="container"><b>TEL PRO MÈRE</b>
	 <input type="checkbox" name="col" value="hide" id="telpromere_col" onchange="hide_show_table(this.id);" checked>
	 <span class="checkmark"></span>-->
	</label>
	 <label class="container"><b>PORTABLE PÈRE</b>
	<input type="checkbox" name="col" value="hide" id="portpere_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<!--<label class="container"><b>PROFESSION PÈRE</b>
	<input type="checkbox" name="col" value="hide" id="profpere_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<label class="container"><b>TEL PRO PÈRE</b>
	<input type="checkbox" name="col" value="hide" id="telpropere_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>-->

	<?php /*fin assemb gen*/ }} /*if($action !='vueMand' && $action !='vuePrestM' && $action!='vuePrestGE'){*/?><?php if($action !='voirTousFact' && $action!='assembGen'){?>
	<label class="container"><b>QUARTIER</b>
	<input type="checkbox" name="col" value="hide" id="quartier_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<label class="container"><b>N° BUS</b>
	<input type="checkbox" name="col" value="hide" id="lignebus_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<label class="container"><b>ARRÊT DE BUS</b>
	<input type="checkbox" name="col" value="hide" id="arretbus_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<?php }?>

	<?php if($action !='vueMand' && $action !='vuePrestM' && $action!='vuePrestGE' && $action!='assembGen'){?>
	<label class="container"><b>DATE ENTRÉE</b>
	<input type="checkbox" name="col" value="hide" id="dateentree_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<label class="container"><b>DATE SORTIE</b>
	<input type="checkbox" name="col" value="hide" id="datesortie_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>

	<?php } if($action !='vueMand' && $action !='vuePrestM' && $action!='vuePrestGE' && $action !='voirTousFact' && $action!='assembGen'){?>
	<label class="container"><b>ENFANTS</b>
	<input type="checkbox" name="col" value="hide" id="enfants_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>


	<!--Colonnes des différents enfants de la famille-->
	<?php } if($action=='vueMand'|| $action=='vuePrestGE' && $action!='assembGen') {?>
	<label class="container"><b>ENFANT 1</b>
	<input type="checkbox" name="col" value="hide" id="enfant1_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<label class="container"><b>ENFANT 2</b>
	<input type="checkbox" name="col" value="hide" id="enfant2_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<label class="container"><b>ENFANT 3</b>
	<input type="checkbox" name="col" value="hide" id="enfant3_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<label class="container"><b>ENFANT 4</b>
	<input type="checkbox" name="col" value="hide" id="enfant4_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<label class="container"><b>ENFANT 5</b>
	<input type="checkbox" name="col" value="hide" id="enfant5_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>


	<!--Cases à cocher des conditions ou observations pour les intervenants-->
	<?php } if ($action !='vueMand' && $action != 'vuePrestM' && $action !='vuePrestGE' && $action!='assembGen'){?>
	<label class="container"><b>A POURVOIR ?</b>
	<input type="checkbox" name="col" value="hide" id="pourvoir_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>

	<?php } if ($action != 'voirTousFamilleAPourvoirGE' && $action !='vueMand' && $action != 'vuePrestM' && $action !='vuePrestGE' && $action!='assembGen'){?>
	<label class="container"><b>A POURVOIR MENAGE</b>
	<input type="checkbox" name="col" value="hide" id="PM_prest_pourvoir_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>

	<?php } if ($action != 'voirTousFamilleAPourvoirGE' && $action !='vueMand' && $action != 'vuePrestM' && $action !='vuePrestGE' && $action!='assembGen'){?>
	<label class="container"><b>DATE POURVOIR MENAGE</b>
	<input type="checkbox" name="col" value="hide" id="date_PM_pourvoir_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>

	<?php } if ($action != 'voirTousFamilleAPourvoirM' && $action !='vueMand' && $action != 'vuePrestM' && $action !='vuePrestGE' && $action!='assembGen'){?>
	<label class="container"><b>A POURVOIR G. ENFANTS</b>
	<input type="checkbox" name="col" value="hide" id="PGE_prest_pourvoir_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>

	<?php } if ($action != 'voirTousFamilleAPourvoirM' && $action !='vueMand' && $action != 'vuePrestM' && $action !='vuePrestGE' && $action!='assembGen'){?>
	<label class="container"><b>DATE POURVOIR G. ENFANTS</b>
	<input type="checkbox" name="col" value="hide" id="date_PGE_pourvoir_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>

	<?php }if($action !='vueMand' && $action !='vuePrestM' && $action!='vuePrestGE' && $action !='voirTousFact' && $action!='assembGen'){?>
	<label class="container"><b>DEMANDES / OBSERVATIONS</b>
	<input type="checkbox" name="col" value="hide" id="observation_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>

	<?php }if($action !='vueMand' && $action !='vuePrestM' && $action!='vuePrestGE' && $action != 'voirTousFact' && $action!='assembGen'){?>
	<label class="container"><b>VÉHICULE DEMANDÉ</b>
	<input type="checkbox" name="col" value="hide" id="vehiculedemand_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>

	<?php }if ($action !='voirTousFamilleAPourvoir' && $action!='voirTousFamilleAPourvoirGE' && $action!='voirTousFamilleAPourvoirM' && $action!='assembGen'){?>
	<label class="container"><b>MODE DE PAIEMENT</b>
	<input type="checkbox" name="col" value="hide" id="paiement_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	
	<?php }if($action !='voirTousFact' && $action!='assembGen'){?>
	<label class="container"><b>PRESTATIONS</b>
	<input type="checkbox" name="col" value="hide" id="adhesion_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>

	 
	<!--Cases à cocher liées aux intervenants en poste-->

	<?php }/*if ($action != 'voirTousFamilleAPourvoirM' && $action !='voirTousFamilleAPourvoirGE' && $action !='vueMand' && $action != 'vuePrestM' && $action !='vuePrestGE'){*/?>
	<!--<label class="container"><b>INTERVENANT EN POSTE</b>
	<input type="checkbox" name="col" value="hide" id="intervposte_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>-->


	<?php /*}*/if ($action != 'voirTousFamilleAPourvoirM' && $action !='voirTousFamilleAPourvoirGE' && $action !='vuePrestM' && $action !='vuePrestGE' && $action!='assembGen'){?>
	<label class="container"><b>INTERV MAND GE</b>
	<input type="checkbox" name="col" value="hide" id="intervMandGE_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>

	<?php }if ($action != 'voirTousFamilleAPourvoirM' && $action !='voirTousFamilleAPourvoirGE' && $action !='vueMand' && $action !='vuePrestGE' && $action!='assembGen'){?>
	<label class="container"><b>INTERV PREST MÉNAGE</b>
	<input type="checkbox" name="col" value="hide" id="intervPrestMenage_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	
	<?php }if ($action != 'voirTousFamilleAPourvoirM' && $action !='voirTousFamilleAPourvoirGE' && $action !='vueMand' && $action !='vuePrestM' && $action!='assembGen'){?>
	<label class="container"><b>INTERV PREST GE</b>
	<input type="checkbox" name="col" value="hide" id="intervPrestGE_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<?php } ?>

	<!--Case à cocher du numéro de CAF-->
	<?php if($action!='assembGen'){?>
	<label class="container"><b>CAF</b>
	<input type="checkbox" name="col" value="hide" id="caf_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>

	<!--Case à cocher pour les Km-->
	<?php } if($action=='vuePrestGEKM'|| $action=='vuePrestMKM' && $action!='assembGen') {?>
	<label class="container"><b>DISTANCE CHAU-FAM</b>
	<input type="checkbox" name="col" value="hide" id="distanceChauFam_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>

	<label class="container"><b>DISTANCE INTERV-FAM</b>
	<input type="checkbox" name="col" value="hide" id="distanceIntervFam_col" onchange="hide_show_table(this.id);" checked>
	<span class="checkmark"></span>
	</label>
	<?php } ?>

</div>
</div>
<div class="divCenter">

	<?php if ($action=='resAdvSearchF'){?>   <!--- resAdvSearchF --->  

	<?php
	$stack = array();

	foreach ($lesFamilles as $uneFamille)
	{
		array_push($stack, $uneFamille["numFamille"]);
	}

	$_SESSION['stack'] = $stack;

    $_SESSION['numeroElementListeSearch'] = 1;

    $_SESSION['pointeur'] = current($stack);

	} 
	?>



<div id="contenu">
<!--Différents titres des pages/tableaux en fonctions de la page actuelle-->
<h1 style="text-align: center">familles <br>

<?php
if($archive==1) 												{echo 'archivées <br>';}
if($action=='voirTousFamille')								    {echo ' ';}
if($action=='voirTousFamilleAPourvoirM')						{echo 'à pourvoir ménage <br>';}
if($action=='voirTousFamilleAPourvoirGE')					    {echo 'à pourvoir garde d\'enfants <br>';}
if($action=='voirTousFamilleMand' || $action == 'voirTousFact') {echo 'mandataires <br>';}
if($action=='voirTousFamilleAPourvoir')							{echo 'à pourvoir <br>';}
if($action=='vueMand')											{echo 'MANDATAIRES <br>';}
if($action=='vuePrestGE' || $action=='voirTousFamillePrestaGE')	{echo 'PRESTATAIRES GE <br>';}
if($action=='vuePrestM' || $action=='voirTousFamillePrestaM')	{echo 'PRESTATAIRES MÉNAGE <br>';}
if($action=='voirTousFamilleGardePart') 						{echo 'en garde partagée <br>';}
if($action=='resAdvSearchF') 									{echo 'résultat de la recherche avancée <br>';}
if($action=='voirTousFamilleAssembGen') 						{echo 'participantes à l&#146assemblée générale <br>';}
/*test*/if($action=='assembGen')								{echo ' ';}

  echo count($lesFamilles);
  ?>
  RÉSULTATS
</h1>






<!--Liste des titres de colonnes de la liste des familles-->
<table class="sortable zebre" id="listeFamilles">
	<thead> 
	<tr class="btn-secondary">

		<th id="m_col_head">M</th><!-- -->

		<?php if (/*$action !='vueMand' && $action != 'vuePrestGE' && */$action!='voirTousFact'){?>

		<th id="pm_col_head">PM</th><!-- -->

		<?php } if (/*$action != 'vuePrestM' && $action !='vueMand' && */$action !='voirTousFact'){?>

		<th id="pge_col_head">PGE</th><?php }?><!-- -->

		<?php /*if($action !='vuePrestM' && $action != 'vuePrestGE'){*/?>

		<th id="reg_col_head">REG</th><?php /*}*/?>

		<th id="nom_col_head" class="selection">Nom(s)</th>

		<?php if ($action !='voirTousFact'){?><!-- -->

		<th id="adresse_col_head">Adresse</th><!-- -->
		<th id="codepostal_col_head">Code postal</th><!-- -->
		<th id="ville_col_head">Ville</th><!-- -->
		<?php if($action!='assembGen'){?>
		<th id="mailmere_col_head">Email mère</th><!-- -->
		<th id="mailpere_col_head">Email père</th><!-- -->
		<th id="domicile_col_head">Domicile</th><!-- -->
		<th id="portmere_col_head">Portable mère</th><!-- -->
		<!-- <th id="profmere_col_head">Profession mère</th>-->
		<!-- <th id="telpromere_col_head">Tel pro mère</th> -->
		<th id="portpere_col_head">Portable père</th><!-- -->
		<!-- <th id="profpere_col_head">Profession père</th> -->
		<!-- <th id="telpropere_col_head">Tel pro père</th> -->

		<?php }} /*if($action !='vueMand' && $action !='vuePrestM' && $action!='vuePrestGE'){*/?><?php if($action !='voirTousFact' && $action!='assembGen'){?>

		<th id="quartier_col_head">Quartier</th><!-- -->
		<th id="lignebus_col_head">N° bus</th>
		<th id="arretbus_col_head">Arrêt de bus</th><?php }?>
		<?php if($action !='vueMand' && $action !='vuePrestM' && $action!='vuePrestGE' && $action!='assembGen'){?>
		<th id="dateentree_col_head">Date entrée</th><!-- -->
		<th id="datesortie_col_head">Date sortie</th><!--22-->

		<?php } if($action !='vueMand' && $action !='vuePrestM' && $action!='vuePrestGE' && $action !='voirTousFact' && $action!='assembGen'){?>

		<th id="enfants_col_head">Enfants</th>

		<?php } if($action=='vueMand'||$action=='vuePrestGE' && $action!='assembGen') {?>

		<th id="enfant1_col_head">Enfant 1</th>
		<th id="enfant2_col_head">Enfant 2</th>
		<th id="enfant3_col_head">Enfant 3</th>
		<th id="enfant4_col_head">Enfant 4</th>
		<th id="enfant5_col_head">Enfant 5</th>

		<?php } if ($action !='vueMand' && $action!='vuePrestM' && $action!='vuePrestGE' && $action!='assembGen'){?>

		<th id="pourvoir_col_head">A Pourvoir?</th><!-- -->

		<?php } if ($action != 'voirTousFamilleAPourvoirGE' && $action !='vueMand' && $action!='vuePrestM' && $action!='vuePrestGE' && $action!='assembGen'){?>

		<th id="PM_prest_pourvoir_col_head">MENAGE à Pourvoir</th>

		<th id="date_PM_pourvoir_col_head">Date MENAGE à Pouvoir</th>

		<?php } if ($action != 'voirTousFamilleAPourvoirM' && $action !='vueMand' && $action!='vuePrestM' && $action!='vuePrestGE' && $action!='assembGen'){?>
		
		<th id="PGE_prest_pourvoir_col_head">GARDE D'ENFANTS à Pourvoir</th>

		<th id="date_PGE_pourvoir_col_head">Date GARDE D'ENFANTS à Pouvoir</th>

		<?php }if($action !='vueMand' && $action !='vuePrestM' && $action!='vuePrestGE' && $action !='voirTousFact' && $action!='assembGen'){?>

		<th id="observation_col_head">Demande / observations</th><!-- --><?php } 

		if($action !='vueMand' && $action !='vuePrestM' && $action!='vuePrestGE' && $action != 'voirTousFact' && $action!='assembGen'){?>

		<th id="vehiculedemand_col_head">Véhicule demandé</th><!-- --><?php }

		if ($action !='voirTousFamilleAPourvoir' && $action !='voirTousFamilleAPourvoirGE' && $action!='voirTousFamilleAPourvoirM' && $action!='assembGen'){?>

		<th id="paiement_col_head">Mode de paiement</th><!-- -->

		<?php }?>


		<?php if($action !='voirTousFact' && $action!='assembGen'){?>

		<th id="adhesion_col_head">Type d'adhésion / Prestations</th><?php } 



		/*if ($action != 'voirTousFamilleAPourvoirM' && $action != 'voirTousFamilleAPourvoirGE' && $action !='vueMand' && $action != 'vuePrestM' && $action !='vuePrestGE'){*/?>
		<!--<th id="intervposte_col_head">Intervenant en poste</th>-->
		
		<!--Titres des intervenants en poste-->
		<?php /*}*/if ($action !='voirTousFamilleAPourvoirM' && $action !='voirTousFamilleAPourvoirGE' && $action !='vuePrestM' && $action !='vuePrestGE' && $action!='assembGen'){?>
		<th id="intervMandGE_col_head">Interv mand GE</th>

		<?php }if ($action !='voirTousFamilleAPourvoirM' && $action !='voirTousFamilleAPourvoirGE' && $action !='vueMand' && $action !='vuePrestGE' && $action!='assembGen'){?>
		<th id="intervPrestMenage_col_head">Interv prest ménage</th>

		<?php }if ($action != 'voirTousFamilleAPourvoirM' && $action !='voirTousFamilleAPourvoirGE' && $action !='vueMand' && $action !='vuePrestM' && $action!='assembGen'){?>
		<th id="intervPrestGE_col_head">Interv prest GE</th>
		
		<?php } 

		
		
		if (/*$action == 'vuePrestGE'){ if ($action !='vueMand' && $action != 'vuePrestM' && $action !='vuePrestGE'*/$action!='assembGen'){?>
		<th id="caf_col_head">CAF</th>
		
		<!--Affiche le titre de la colonne-->
		<?php }if ($action != 'voirTousFamilleAPourvoirM' && $action !='voirTousFamilleAPourvoirGE' && $action !='vueMand' && $action !='vuePrestM' && $action!='assembGen' && $action=='vuePrestGEKM' || $action=='vuePrestMKM'){?>
			<th id="distanceChauFam_col_head">Distance chaudoudoux-famille</th>

			<th id="distanceIntervFam_col_head">Distance intervenant-famille</th>
		
		<?php } ?>

		<?php if (/*$action !='vueMand' && $action != 'vuePrestGE' && */$action=='assembGen'){?>

		<th id="AG_col_head">Participe</th><!-- -->

		<?php } ?>

    </tr>
	</thead>
	<tbody>

	<?php      
    foreach($lesFamilles as $uneFamille) {
        
        $num = $uneFamille["numero_Famille"];
        $noms=$pdoChaudoudoux->obtenirNomFamille($num);
        $tabNbEnfants = $pdoChaudoudoux->obtenirNbEnfants($num);
        $numeros=$pdoChaudoudoux->obtenirNumerosFamille($num);
        $coord=$pdoChaudoudoux->obtenirCoordonneesFam($num);
        $enf=$pdoChaudoudoux->obtenirEnfantsFamille($num);

        $telMaman=$pdoChaudoudoux->obtenirTelMaman($num);/*Vincent*/
        $telPapa=$pdoChaudoudoux->obtenirTelPapa($num);/*Vincent*/
        $mailMaman=$pdoChaudoudoux->obtenirMailMaman($num);/*Vincent*/
        $mailPapa=$pdoChaudoudoux->obtenirMailPapa($num);/*Vincent*/

        $nbEnfants = $tabNbEnfants['nbEnfants']; 
        $dateEntree=$coord['dateEntree_Famille'];
        $dateSortie=$coord['dateSortie_Famille'];
        
		//if((isset($dateSortieIntervenant[0]) && $dateSortieIntervenant[0]['dateSortie_Intervenants']!='0000-00-00') && $coord['aPourvoir_Famille']!=0){$NombreIntervenant=count($dateSortieIntervenant);}
		//else{$NombreIntervenant=1;}
		//A Voir
		//echo implode("|",$TypePrestIntervenant[0]);

        if (isset($dateEntree)){
            $ckentree= substr($dateEntree, 0,4).substr($dateEntree, 5,2).substr($dateEntree, 8,2).'000000';
        }
        if (isset($dateSortie)){
            $cksortie= substr($dateSortie, 0,4).substr($dateSortie, 5,2).substr($dateSortie, 8,2).'000000';
        }
 		if ($num != 9999){?>     


       	<tr>
       	   	<td class="m_col"><?php echo $numeros['numero_Famille'];?></td><?php  

		if (/*$action !='vueMand' && $action != 'vuePrestGE' && */$action!='voirTousFact'){?>

           	<td class="pm_col"><?php echo $numeros['PM_Famille'];?></td><?php } 

		if (/*$action != 'vuePrestM' && $action !='vueMand' && */$action!='voirTousFact'){?>

           	<td class="pge_col"><?php echo $numeros['PGE_Famille'];?></td><?php } 

		/*if ($action != 'vuePrestGE' && $action !='vuePrestM'){*/?>

           	<td class="reg_col"><?php echo $numeros['REG_Famille'];?></td><?php /*}*/?>
           	<td class="nom_col"><a href="index.php?uc=annuFamille&amp;action=voirDetailFamille&amp;num=<?php echo $num; ?>" ><?php echo $noms; ?></a></td><?php 

           	if ($action !='voirTousFact'){?><td class="adresse_col"><?php echo $coord['adresse_Famille'];?></td>

           	<td class="codepostal_col"><?php echo $coord['cp_Famille'];?></td>
            <td class="ville_col"><?php echo $coord['ville_Famille'];?></td>

			<?php if($action!='assembGen'){?>
           	<td class="mailmere_col"><?php echo $mailMaman;?></td><!--Vincent-->
           	<td class="mailpere_col"><?php echo $mailPapa;?></td><!--Vincent-->
           	<td class="domicile_col"><?php echo $coord['telDom_Famille'];?></td>
           	<td class="portmere_col"><?php echo $telMaman;?></td><!--Vincent-->
			<td class="portpere_col"><?php echo $telPapa;?></td><!--Vincent--> <?php }}
           
           	/*if($action !='vueMand' && $action !='vuePrestM' && $action!='vuePrestGE'){*/?>
           	<?php if ($action!='voirTousFact' && $action!='assembGen') {?>

		    <td class="quartier_col"><?php echo $coord['quartier_Famille'];?></td>
           	<td class="lignebus_col"><?php echo $coord['numBus_Famille'];?></td>
           	<td class="arretbus_col"><?php echo $coord['arretBus_Famille'];?></td><?php }?>

			<?php if($action!='vueMand' && $action!='vuePrestM' && $action!='vuePrestGE' && $action!='assembGen'){?>
           	<td class="dateentree_col"<?php if (isset($ckentree)){echo 'sorttable_customkey='.$ckentree;}?>><?php if(isset($dateEntree)&&$dateEntree!='0000-00-00'){if(dateToString($dateEntree)!='00/00/0000'){echo dateToString($dateEntree);}}?></td>
           	<td class="datesortie_col"<?php if (isset($cksortie)){echo 'sorttable_customkey='.$cksortie;}?>><?php if(isset($dateSortie)&&$dateSortie!='0000-00-00'){if(dateToString($dateSortie)!='00/00/0000'){echo dateToString($dateSortie);}}?></td>
			<?php }?>

           	<?php if($action!='vueMand' && $action!='vuePrestM' && $action!='vuePrestGE' && $action!='voirTousFact' && $action!='assembGen' && $action!='assembGen'){ ?>
		    <td class="enfants_col"><?php foreach($enf as $unEnf){echo $unEnf['nom_Enfants'].' '.$unEnf['prenom_Enfants'].' '.(int)($unEnf['age']/365).'ans ';}?></td><?php }
           	
            if($action =='vueMand' || $action=='vuePrestGE' && $action!='assembGen'){?>
           	<td class="enfant1_col"><?php if(isset($enf[0])) echo $enf[0]['nom_Enfants'].' '.$enf[0]['prenom_Enfants'].' '.dateToString ($enf[0]['dateNaiss_Enfants'])?></td>
           	<td class="enfant2_col"><?php if(isset($enf[1])) echo $enf[1]['nom_Enfants'].' '.$enf[1]['prenom_Enfants'].' '.dateToString ($enf[1]['dateNaiss_Enfants'])?></td>
           	<td class="enfant3_col"><?php if(isset($enf[2])) echo $enf[2]['nom_Enfants'].' '.$enf[2]['prenom_Enfants'].' '.dateToString ($enf[2]['dateNaiss_Enfants'])?></td>
           	<td class="enfant4_col"><?php if(isset($enf[3])) echo $enf[3]['nom_Enfants'].' '.$enf[3]['prenom_Enfants'].' '.dateToString ($enf[3]['dateNaiss_Enfants'])?></td>
            <td class="enfant5_col"><?php if(isset($enf[4])) echo $enf[4]['nom_Enfants'].' '.$enf[4]['prenom_Enfants'].' '.dateToString ($enf[4]['dateNaiss_Enfants']) ;}?></td>
 
           	<?php if ($action!='vueMand' && $action!='vuePrestM' && $action!='vuePrestGE' && $action!='assembGen'){ 

			echo '<td class="pourvoir_col">'; if ($coord['aPourvoir_Famille']==0){echo 'NON';} else {echo 'OUI';} echo '</td>';
			
			} if ($action!='voirTousFamilleAPourvoirGE' && $action!='vueMand' && $action!='vuePrestM' && $action!='vuePrestGE' && $action!='assembGen'){ 

			echo '<td class="PM_prest_pourvoir_col">'; if ($coord['aPourvoir_Famille']==0){echo 'NON';}else {if(isset($coord['aPourvoir_PM'])&& ($coord['aPourvoir_PM']!=0)){echo "MENAGE à Pourvoir";}else{echo "";}} echo '</td>';

			echo '<td class="date_PM_pourvoir_col">'; if ($coord['aPourvoir_Famille']==0){echo 'NON';}else {if(isset($coord['Date_aPourvoir_PM'])&& $coord['Date_aPourvoir_PM']!='0000-00-00'){echo dateToString($coord['Date_aPourvoir_PM']);}else{echo "";}}echo '</td>';
			
			} if ($action!='voirTousFamilleAPourvoirM' && $action!='vueMand' && $action!='vuePrestM' && $action!='vuePrestGE' && $action!='assembGen'){ 

			echo '<td class="PGE_prest_pourvoir_col">'; if ($coord['aPourvoir_Famille']==0){echo 'NON';}else {if(isset($coord['aPourvoir_PGE']) && ($coord['aPourvoir_PGE']==1)){echo "GARDE ENFANTS PRESTATAIRE à Pourvoir";}else{if($coord['aPourvoir_PGE']==2){echo "GARDE ENFANTS MANDATAIRE à Pourvoir";} else{echo "";}}} echo '</td>';

			echo '<td class="date_PGE_pourvoir_col">'; if ($coord['aPourvoir_Famille']==0){echo 'NON';}else {if(isset($coord['Date_aPourvoir_PGE']) && $coord['Date_aPourvoir_PGE']!='0000-00-00'){echo dateToString($coord['Date_aPourvoir_PGE']);}else{echo "";}}echo '</td>';}

           	if ($action !='vueMand' && $action !='vuePrestM' && $action!='vuePrestGE' && $action !='voirTousFact' && $action!='assembGen'){ 
			echo '<td class="observation_col">'.$coord['observations_Famille'].'</td>'.
			'<td class="vehiculedemand_col">'; if($coord['vehicule_Famille']==1) {echo 'OUI';} else {echo 'NON';}?></td><?php } 

           	if ($action !='voirTousFamilleAPourvoir' && $action !='voirTousFamilleAPourvoirGE'&& $action !='voirTousFamilleAPourvoirM' && $action!='assembGen'){ echo '<td class="paiement_col">'.$coord['modePaiement_Famille'].'</td>';}?>
           
           


       
<?php
	$prestations=$pdoChaudoudoux->obtenirPrestaFamille($num);
	$nomPresta = "";
	$prestMand = "";

	foreach ($prestations as $presta) {
		$nomPresta .= $presta['type_Prestations']."/";
		$prestMand .= $presta['intitule_TypeADH']."/";
                        
	}
?>
<?php
	if ($action!='voirTousFact' && $action!='assembGen'){?>
		<td class="adhesion_col"> <?php $prestas=$pdoChaudoudoux->obtenirPresta($num);

        foreach ($prestas as $presta){ 
            echo $presta['type_Prestations'].' '.$presta['intitule_TypeADH'].' ';
        }
        echo ' '.$coord['option_Famille'];?></td>
	<?php }
		
	/*if ($action != 'voirTousFamilleAPourvoirM' && $action != 'voirTousFamilleAPourvoirGE' && $action !='vueMand' &&  $action !='vuePrestM' && $action!='vuePrestGE'){?>
		<td class="intervposte_col"><?php $enPoste = $pdoChaudoudoux->obtenirSalariePresent($num);

		foreach ($enPoste as $unInterv){
			echo $unInterv['nom_Candidats'].' '.$unInterv['prenom_Candidats'].' ';
		}?>
		</td>

	<?php }*/

	if ($action!='voirTousFamilleAPourvoirM' && $action!='voirTousFamilleAPourvoirGE' && $action!='vuePrestM' && $action!='vuePrestGE' && $action!='assembGen'){?>
		<td class="intervMandGE_col"><?php $enPosteMandGE = $pdoChaudoudoux->obtenirSalarieMandGEPresent($num);
		foreach ($enPosteMandGE as $unIntervMandGE){
			echo $unIntervMandGE['nom_Candidats'].' '.$unIntervMandGE['prenom_Candidats'].' ';
		}?>
		</td>

	<?php }

	if ($action!='voirTousFamilleAPourvoirM' && $action!='voirTousFamilleAPourvoirGE' && $action!='vueMand' && $action!='vuePrestGE' && $action!='assembGen'){?>
		<td class="intervPrestMenage_col"><?php $enPostePrestMenage = $pdoChaudoudoux->obtenirSalariePrestMenagePresent($num);
		foreach ($enPostePrestMenage as $unIntervPrestMenage){
			echo $unIntervPrestMenage['nom_Candidats'].' '.$unIntervPrestMenage['prenom_Candidats'].' ';
		}?>
		</td>

	<?php }

	if ($action!='voirTousFamilleAPourvoirM' && $action!='voirTousFamilleAPourvoirGE' && $action!='vueMand' && $action!='vuePrestM' && $action!='assembGen'){?>
		<td class="intervPrestGE_col"><?php $enPostePrestGE = $pdoChaudoudoux->obtenirSalariePrestGEPresent($num);
		foreach ($enPostePrestGE as $unIntervPrestGE){
			echo $unIntervPrestGE['nom_Candidats'].' '.$unIntervPrestGE['prenom_Candidats'].' ';
		}?>
		</td>

	<?php }

	if ($action=='voirTousFamilleAPourvoirM' && $action=='voirTousFamilleAPourvoirGE' && $action!='assembGen') {?>
	<td class=""><a href="planning.php?num=99999&amp;numFam=<?php echo $numeros['numero_Famille']?>" target="_blank">Planning</a></td><?php } ?>  
   		<!--?php if ($action=='vuePrestGE'){echo '<td class="">'.$coord['numAlloc_Famille'].'</td>';}?>-->
		<?php if($action!='assembGen'){?>
    	<td class="caf_col"><?php echo $coord['numAlloc_Famille'];}?></td>
		<?php } 
		
		if ($action!='voirTousFamilleAPourvoirM' && $action!='voirTousFamilleAPourvoirGE' && $action!='vueMand' && $action!='vuePrestM' && $action!='assembGen' && $action=='vuePrestGEKM'|| $action=='vuePrestMKM'){
			?>
			<td class="distanceChauFam_col"><img style="max-width:30px;" src="./styles/img/loading.gif"></img></td>
			
			<td class="distanceIntervFam_col"><img style="max-width:30px;" src="./styles/img/loading.gif"></img></td>
	
		<?php } 

		?>
        </tr>
<?php 
 }/*}*/
?>
</div>
</tbody>
</table>
</body>
</html>




      <!--Vincent--> 
 <button class="button" onclick="topFunction()" id="topBtn"><img src="images/toTop.png" width="60"></button>

<script>/*
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
 }*/
</script>


<!--Vincent bouton vers le haut de page
<button class="button" onclick="topFunction()" id="topBtn"><img src="../images/toTop.png" width="60"></button>
--> 

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
