<?php


//////////////////////////////////////////////////
//
//       connexion Mysql
//
/////////////////////////////////////////////////
#require_once('Connections/PDO_BPU_Apel1.php');
require_once('Connections/PDO_Prod_Util_AO_BPU.php');
// connProd et conn =Pegase_Data_BO_Prod , connUtil=utilisateurdgabc, connAO=Analyse_AO, conBPU=BPU_Apel, conDENGT
require_once('Connections/Con_PEG_DATA_BO_Prod.php');







		
/////////////////////////////////////////////////
//
//       Fonctions
//
/////////////////////////////////////////////////

require_once('../_Fonctions/_Dates/F_strtotime.php');
require_once('../_Fonctions/_Dates/F_Date_Mysql_Vers_FR.php');

//////////////////////////////////////////////////
//
//        Maj des Vg par rapport a la page
//
/////////////////////////////////////////////////


$fichierCourant = $_SERVER["PHP_SELF"];
$parties = explode('/', $fichierCourant );
$v_page = trim($parties[count($parties) - 1]);
// variables globales contenant les criteres de recherche/selection
// $_SESSION['VG_Page'] = "DENG_00.php" initialise dans DENG_00.php
// $_SESSION['VG_Page_Preced'] = "DENG_00.php" initialise dans Deng_00.php

$_SESSION['VG_Page'] = $v_page;
if ($_SESSION['VG_Page'] == $_SESSION['VG_Page_Preced']) {
	// on garde les valeurs des VG de critere
	if (isset($_GET['ReInit'])) { // passe en GEt sur l'appel de la page par le menu gauche
		$_SESSION['VG_Page_Preced'] = $_SESSION['VG_Page'];
		// on reinitialise les VG de critere
		$_SESSION['VG_Crit_01']="";
		$_SESSION['VG_Crit_02']="";
		$_SESSION['VG_Crit_03']=""; // contiend le numero service comptable
		$_SESSION['VG_Crit_04']="";
		$_SESSION['VG_Crit_05']="";
		$_SESSION['VG_Req_Sql']="";
		unset($_SESSION['VG_ResultSelect']);
		
		foreach($_SESSION as $key => $value){
			if(substr($key, 0,4) == "PNG_") {
				unset($_SESSION[$key]);
			}
		}
	}
} else {
	$_SESSION['VG_Page_Preced'] = $_SESSION['VG_Page'];
	// on reinitialise les VG de critere
	$_SESSION['VG_Crit_01']="";
	$_SESSION['VG_Crit_02']="";
	$_SESSION['VG_Crit_03']=""; // contiend le numero service comptable
	$_SESSION['VG_Crit_04']="";
	$_SESSION['VG_Crit_05']="";
	$_SESSION['VG_Req_Sql']="";
	unset($_SESSION['VG_ResultSelect']);
	
	foreach($_SESSION as $key => $value){
		if(substr($key, 0,4) == "PNG_") {
			unset($_SESSION[$key]);
		}
	}
}


//////////////////////////////////////////////////
//
//        gestion de la VG VG_ResultSelect
//
/////////////////////////////////////////////////
// $_SESSION['VG_ResultSelect'][$v_page] = nbr de lignes retournees. Avec $v_page = nom de la page en cours exemple Marches_01.php
$v_ResultSelect = 0;

if (isset($_SESSION['VG_ResultSelect'][$v_page])) {
	$v_ResultSelect = $_SESSION['VG_ResultSelect'][$v_page];
	#$v_ResultSelect = 126;
}

unset($_SESSION['VG_ResultSelect']);
$_SESSION['VG_ResultSelect'][$v_page] = $v_ResultSelect;
$v_ResultSelect = 0;

////////////////////////////////////
//
//		variable commune à toutes les pages
//
/////////////////////////////////////

$t_srv_dgave = array("50001"=>"DGAVE", "50102" => "DRP", "50402"=>"DEGPC", "50502"=>"Dtb Sud", "50602"=>"Dtb Nord", "50703"=>"Stb Est", "50803"=>"Stb NEst", "51102"=>"DEXT");
$v_srv_dgave_in = "'50001', '50102', '50402', '50502', '50602', '50703', '50803', '51102'";
$t_lib_budget = array("00"=>"Général", "01" => "Palais Pharo", "02"=>"Vélodrome", "03"=>"Opera/Odeon", "04"=>"Pompes Funebre", "05"=>"POMGE", "06"=>"Pole Media Belle de Mai");

if ($_SESSION['VG_Id_Domaine'] == 'C') {
	$v_DirCompta = "%";
	if ($_SESSION['VG_ResultSelect'][$v_page] != 0) {
		$v_DirCompta = $_SESSION['VG_Crit_03'];
	}
} else {// if ($_SESSION['VG_Id_Domaine'] == 'C') { 
	$v_DirCompta = $_SESSION['VG_Dir']."02";
}// if ($_SESSION['VG_Id_Domaine'] == 'C') {
	
$v_title="Site intranet de la DGAAVE";
$v_title="DEV-----".$_SERVER['HTTP_HOST'];
if ($_SERVER['HTTP_HOST'] == '10.6.192.41') {
	$v_title="Site intranet de la DGAAVE";
}


//////////////////////////////////////////////////
//
//        recup compteur log
//
/////////////////////////////////////////////////
$nom_en_cours="Compteur_Log.txt";
$ouverture = @fopen($nom_en_cours, "r");
if (!$ouverture){
	$nombre_Log=0;
} else {
	while (!feof($ouverture)){
	$nombre_Log = fgets($ouverture, 1024);
	}
	if ($nombre_Log=="") $nombre_Log=0;
	fclose($ouverture);
}
//////////////////////////////////////////////////
//
//        recup compteur log
//
/////////////////////////////////////////////////
$nom_en_cours="Compteur_Log.txt";
$ouverture = @fopen($nom_en_cours, "r");
if (!$ouverture){
	$nombre_Log=0;
} else {
	while (!feof($ouverture)){
	$nombre_Log = fgets($ouverture, 1024);
	}
	if ($nombre_Log=="") $nombre_Log=0;
	fclose($ouverture);
}

/////////////////////////////////
//
//		gestion du file download
//
////////////////////////////////
setcookie ("fileDownload", "", time() - 3600);
// ci dessous à appeller dans le html du header
/*
<script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/js/jquery.fileDownload.js"></script>
*/
// ci dessous HTML du bt pour de telechargement pdf
/*
<div style="display:inline-block;float:left;margin-left: 50px;">
	<a href="Marches_01_imp_Pdf.php?v_Typ=A" id="bt_modal">
		<img src="images/Boutons/_Bouton_H32/fond_Gris/Telecharg_PDF_117_32.png" width="107" height="32" style="vertical-align : middle;">
	</a>
	&nbsp;La liste des Marchés
</div>
*/
// ci dessous a mettre en fin de page HTML avant javascript
/*
 <!-- container attente download -->
<div id="preparing-file-modal" title="Téléchargement en cours....." style="display: none;">
    <br />
	<br />
	<br />
	<div style="text-align:center"><img src="images/attente_37_39.gif" width="37" height="39" align="absmiddle" /></div>
</div>

<div id="error-modal" title="Error" style="display: none;">
    Téléchargement impossible
</div>
*/
// ci dessous partie jvavscript
/*
$(document).on("click", "#bt_modal", function () {
        var $preparingFileModal = $("#preparing-file-modal");

        $preparingFileModal.dialog({ modal: true });
		
		$( 'a.ui-dialog-titlebar-close' ).remove(); // supprime la crois de fermeture

        $.fileDownload($(this).attr('href'), {
            successCallback: function (url) {
                $preparingFileModal.dialog('close');
            },
            failCallback: function (responseHtml, url) {

                $preparingFileModal.dialog('close');
                $("#error-modal").dialog({ modal: true });
            }
        });
        return false; //this is critical to stop the click event which will trigger a normal file download!
    });
*/

//////////////////////////////////////////////////
	//
	//        Maj des Vg et variables par rapport a cette page
	//
	/////////////////////////////////////////////////
	
	$_SESSION['VG_Applicatif'] = "Travaux > Demande d'engagements v0.3";
	$v_id_css_logo = "LogoTravaux";
	$v_classe_du_Body = "BodyPetitHeader";
	$v_id_div_header = "PetitHeaderDGAVE";
	$t_menu_burger = array();
	$t_menu_burger = array(
    "TRX_03_01_Visu.php?ReInit=0" => "Vérification Factures",
    "PROG_05.php?ReInit=0" => "Analyse AO BPU",
    "Marches_01_Esti_00.php?ReInit=0" => "Estimatif",
    "PROG_00.php?ReInit=0" => "Suivi Programmation",
    "DENG_00.php?ReInit=0" => "Demande Engagement",
	);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title><? echo $v_title; ?></title>	
<meta http-equiv="Content-Language" content="fr" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!--<link href="<? #echo $chemin_to_racine ?>DGAVE/_Fontes/Verdanax/Verdanax.css" type="text/css" rel="stylesheet"/>
<link href="<? #echo $chemin_to_racine ?>DGAVE/_Fontes/Tahomax/Tahomax.css" type="text/css" rel="stylesheet"/>-->

<link type="text/css" rel="stylesheet" media="screen" href="style.css" />


<script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/js/jquery-3.3.1.min.js"></script>

<link href="<? echo $chemin_to_racine ?>_Jquery/css/smoothness/jquery-ui.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/js/jquery-ui.min.js"></script>

<script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/fancybox_1_3_4/jquery.fancybox-1.3.4.js"></script>
<link rel="stylesheet" type="text/css" href="<? echo $chemin_to_racine ?>_Jquery/fancybox_1_3_4/jquery.fancybox-1.3.4.css" media="screen" />
<!--<script type="text/javascript" src="<? #echo $chemin_to_racine ?>_Jquery/js/jquery.fancybox.min.js"></script>
<link rel="stylesheet" type="text/css" href="<? #echo $chemin_to_racine ?>_Jquery/css/jquery.fancybox.min.css" media="screen" />-->

<link href="<? echo $chemin_to_racine ?>_Jquery/Growl/ui.notify.css" media="all" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/Growl/jquery.notify.js"></script>

<?
/*
<link rel="Stylesheet" href="<? echo $chemin_to_racine ?>_Jquery/css/ui.selectmenu.css" type="text/css" />
<script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/js/ui.selectmenu.js"></script>

<link rel="stylesheet" type="text/css" href="<? echo $chemin_to_racine ?>_Jquery/css/jquery.multiselect.css" />
<script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/js/jquery.multiselect.js"></script>

<link href="<? echo $chemin_to_racine ?>_Jquery/Growl/ui.notify.css" media="all" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/Growl/jquery.notify.js"></script>

<script src="<? echo $chemin_to_racine ?>_Highcharts/js/highcharts.js"></script>
<script src="<? echo $chemin_to_racine ?>_Highcharts/js/highcharts-more.js"></script>
*/
?>
</head>
<body>
<? if ($_SESSION['VG_Pnom'] == "apons") {
	include ('DENGT_Header_Include_Dump.php');	
} ?>
	<div class="<? echo $v_classe_du_Body; ?>">
    	<div id="<? echo $v_id_css_logo; ?>">
			<? if ($_SESSION['VG_Mdp_OK'] == "OUI" ) { ?>
                <a href="<? echo $chemin_to_racine ?>_Sessions/Sortie.php"><img src="images/LogOut.png" width="8" height="422" border="0" style="width: 20px; height: 20px; vertical-align:middle;"><span class="textBlanc" style="font-family: Tahomax, Tahoma, Geneva, sans-serif;">&nbsp;Déconnexions</span></a>
                <? 
                $sql01 = "SELECT * FROM Z0_Droits WHERE Z0_002_PnomUtil = '".$_SESSION['VG_Pnom']."'";
    #echo $sql01."<br>";
                $pdo_01 = $conDENGT->query($sql01)->fetchAll(PDO::FETCH_ASSOC);
                if (count($pdo_01) == 1) {
                    foreach ($pdo_01 as $key_pdo_01  => $pdo_lignes_pdo_01 ) {
                    }
					$_SESSION['VG_droits_DENGT_profil'] = $pdo_lignes_pdo_01['Z0_004_Profil'];
					$_SESSION['VG_droits_DENGT_Ardt'] = $pdo_lignes_pdo_01['Z0_003_Ardt'];
				} // if (count($pdo_01) == 1) {
			} // if ($_SESSION['VG_Mdp_OK'] == "OUI" ) { ?>
        </div> <!--<div id="<? #echo $v_id_css_logo; ?>">-->
        <div id="datheur">
            <div class="date">
                <p class="jour"><? echo date("d"); ?></p>
                <p class="mois"><? echo date("m"); ?></p>
                <p class="annee"><? echo date("Y"); ?></p>
                <p class="heure"><? echo date("H:i:s"); ?></p>
            </div> <!--<div class="date">-->
        </div> <!--<div id="datheur">-->
        <div id="page_DENGT">
            <div id="<? echo $v_id_div_header; ?>"></div>
            <div id="sous-header">
                  <div id="mh">
						<?
                        if (count($t_menu_burger)> 0) {
                        ?>
                            <nav data-action="expand" style="z-index: 999999;">
                                <span><img border="0" src="images/Burger_32_32_N.png"></span>
                                <br />
                                <?
                                foreach ($t_menu_burger as $key => $value) {
                                    echo '<a href="'.$key.'">'.$value.'</a>';
                                }
                                ?>
                            </nav>
						<?
						} //if (count($t_menu_burger)> 0) {
                        ?>
                      <a title="" href="index.php">Accueil</a>
                      <a title="" href="Marches_00.php">Marchés</a>
                      <a title="" href="Budget_00.php">Finances</a>
                      <a title="" href="Compta_00.php">Comptabilité</a>
                      <a title="" href="Ope_00.php">Opérations</a>
                      <a title="" href="Trx_00.php?ReInit=0">Travaux</a>
                      <? if ($_SESSION['VG_Pnom'] == "apons") { ?>
                      <a title="" href="#" onclick="document.getElementById('Dump').style.display = (document.getElementById('Dump').style.display == 'none') ? 'inline' : 'none';">Dump</a>
                      <? } ?>
                  </div> <!--<div id="mh">-->
            </div> <!--<div id="sous-header">-->
          
        <!--</div id="page"> dans le footer-->
	<!-- <div class="<? #echo $v_classe_du_Body; ?>"> dans le footer -->


<script type="text/javascript"><!--  

//////////////////////////////////////////////////////////
//--------------- Fonctions javascript interface -------------------
/////////////////////////////////////////////////////////

    window.addEventListener("load", function(){
		// menu Burger
        var nodes = document.querySelectorAll('nav[data-action="expand"] *:first-child');
        for(var i=0; i<nodes.length; i++) {
            nodes[i].addEventListener("click", function(){
                if(this.parentNode.className == "open") {
                    this.parentNode.className = "";
					//document.getElementById('divPourJqxgrid').style.margin = "0px 0px 0px 0px"; 
					document.getElementById('divPourJqxgrid').animate([
								{transform: 'translateX(15vw)'}, 
								{transform: 'translateX(0px)'}
								], {duration: 1000, fill: 'forwards'}); 
					//document.getElementById('divPourJqxgrid').style.margin = "0px 0px 0px 0px";
				} else {
                    this.parentNode.className = "open";
					//document.getElementById('divPourJqxgrid').style.margin = "0px 0px 0px 15vw";
					document.getElementById('divPourJqxgrid').animate([{transform: 'translateX(0px)'}, {transform: 'translateX(15vw)'}], {duration: 1000, fill: 'forwards'}); 
					//document.getElementById('divPourJqxgrid').style.margin = "0px 0px 0px 15vw";
				}
            });
			
        }
		// gestion affichage avec roue d'attente
		//alert('load fini');
		$('#right').removeClass('NoShow');
		$('#RoueAttente').replaceWith('<div id="RoueAttente"  class="Attent">&nbsp;</div>');
    });
	
	//--------------------------------------------------------------------
	//--------------------- fonction create pour growl -------------------
	function create( template, vars, opts ){
		return $container.notify("create", template, vars, opts);
	}
	//--------------------------------------------------------------------
	//--------------------- FIN fonction create pour growl ---------------
//--></script>