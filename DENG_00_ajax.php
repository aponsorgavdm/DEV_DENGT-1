<?php
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');

require_once('../_Sessions/Verif_Ses.php');

include('../_Fonctions/F_report_err_par_mail.php');
///////////////////////////  F_report_err_par_mail.php  ////////////////////////////////////////////
// contient la fonction qui retourne $chemin_to_racine
// contient la fonction qui envoi mail erreur PHP
// contient la fonction email_err_mysql qui envoi mail des erreurs mysql Exemple: mysql_query($query_2, $Con_PEG_DATA_BO_Prod) or die(email_err_mysql(__FILE__, __LINE__, $Con_PEG_DATA_BO_Prod));
///////////////////////////////////////////////////////////////////////

require_once('Connections/Con_PEG_DATA_BO_Prod.php');
require_once('Connections/PDO_Prod_Util_AO_BPU.php');
// connProd=Pegase_Data_BO_Prod , connUtil=utilisateurdgabc, connAO=Analyse_AO, conBPU=BPU_Apel, conDENGT


///////
// pour developpement hors ligne
//

$v_DatDuJourSQL = date('Y-m-d');
#$v_DatDuJourSQL = '2020-03-13';


		
/////////////////////////////////////////////////
//
//       Fonctions
//
/////////////////////////////////////////////////

require_once('../_Fonctions/_Dates/F_strtotime.php');
require_once('../_Fonctions/_Dates/F_Date_Mysql_Vers_FR.php');

function DateAddJMA($v,$a,$d=null , $f="Y-m-d"){
/*
ajoute des jours, mois , an selon la val de $a :"J" days,"M" months, "A" years
l'ajout se fait par rapport à la date du jour si $d non renseigné dans le format $f si renseigné
$v obligatoire au format Y-m-d : 2006-05-15
$a obligatoire
*/
 	$d=($d?$d:date("Y-m-d")); 
  	switch ($a) {
  		case "J" :
			return date($f,strtotime($v." days",strtotime($d)));
  		case "M" :
  			return date($f,strtotime($v." months",strtotime($d)));
		case "A" :
			return date($f,strtotime($v." years",strtotime($d)));
		default :
			return "Erreur d'argument";
	}

# date du jour  2006-05-15
#echo DateAddJMA(2,"J");  // 2 jours apres date du jour : 2006-05-17
#echo DateAddJMA(2,"M");  // 2 mois apres date du jour : 2006-07-15
#echo DateAddJMA(2,"A");  // 2 ans apres date du jour : 2008-05-15
#echo DateAddJMA(-2,"J",0,"d/m/Y");  // 2 jours avant la date du jour dans le format donné : 13/05/2006
#echo DateAddJMA(-2,"M","2006-05-01","d/m/Y");  // 2 avant la date donée dans le format donné: 01/03/2006
#echo DateAddJMA(2,"J","2004-02-27");  // 2 jours apres date donnée (2004 année bixetile) : 2004-02-29
}
	
/////////////////////////////////////////////////
//
//       apel ajax sur val_Ardt_choisi pour mise à jour select des pnom de l'ardt
//
/////////////////////////////////////////////////

if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "PnomArdt") and ($_POST['v_ardt_dem'] != "")) {
	$sql1 = "Select Id_Srv FROM srv_dgabc WHERE Niv != 'R' AND List_Ardt LIKE '".$_POST['v_ardt_dem'] ."';";
	$pdo_result1 = $connUtil->query($sql1)->fetchAll(PDO::FETCH_ASSOC);
	foreach($pdo_result1 as $key1 => $pdo_lignes1) {
	}
	if (count($pdo_result1) == 1) {
		$sql = "Select Id_Agent from agent_dgabc_2 where Id_Service Like '".$pdo_lignes1['Id_Srv']."' and Valide_O_N = 'O'";
	} else {
		$sql = "Select Id_Agent from agent_dgabc_2 where Id_Service Like '".$_SESSION['VG_Dir']."%' and Valide_O_N = 'O'";
	}
	#echo $sql;
	if ($_SESSION['VG_droits_DENGT_profil'] == "DEM") {
		echo '<select name="val_pnom_choisi" id="val_pnom_choisi">';
			echo '<option value="'.$_SESSION['VG_Pnom'].'">'.$_SESSION['VG_Pnom'].'</option>';
		echo '</select>';
	} else {
		$pdo_result = $connUtil->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		echo '<select name="val_pnom_choisi" id="val_pnom_choisi">';
			echo '<option value="?">Choisir</option>';
			if (($_SESSION['VG_droits_DENGT_profil'] == "VALID") or ($_SESSION['VG_droits_DENGT_profil'] == "COMPTA")){
				echo '<option value="'.$_SESSION['VG_Pnom'].'">'.$_SESSION['VG_Pnom'].'</option>';
			}
			foreach($pdo_result as $key => $pdo_lignes) {
				if ($_SESSION['VG_Pnom'] != $pdo_lignes['Id_Agent']) {
					echo '<option value="'.$pdo_lignes['Id_Agent'].'">'.$pdo_lignes['Id_Agent'].'</option>';
				}
			}
		echo '</select>';
	}
}