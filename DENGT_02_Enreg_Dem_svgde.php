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
		
/////////////////////////////////////////////////
//
//       Fonctions
//
/////////////////////////////////////////////////

require_once('../_Fonctions/_Dates/F_strtotime.php');
require_once('../_Fonctions/_Dates/F_Date_Mysql_Vers_FR.php');

if ($_SESSION['VG_Pnom'] == 'apons') {

echo "<pre>";
	#echo "Session : ";
	#print_r($_SESSION);
	#echo "server : ";
	#print_r($_SERVER);
echo "post : ";
print_r($_POST);
	#echo "get : ";
	#print_r($_GET);
echo "</pre>";



/*
post : Array

*/


//////////////////////////////////////////////////
//
//       Stokage des données
//
/////////////////////////////////////////////////

echo "id_dem";




#header ( "location: ./DENG_00.php");
#exit();

} else {
	?>
    
    VERSION DE TEST
    <br />
    <br />
    <a href="./Deng_00.php">Cliquez pour tester une nouvelle fois</a><br />
    <br />
    <br />
    <a href="./index.php">Cliquez pour retourner à l'acceuil du site</a>
    <?
}
?>