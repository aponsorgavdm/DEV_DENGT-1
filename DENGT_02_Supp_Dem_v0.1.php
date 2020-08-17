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

require_once('Connections/PDO_Prod_Util_AO_BPU.php');
// connProd et conn=Pegase_Data_BO_Prod , connUtil=utilisateurdgabc, connAO=Analyse_AO, conBPU=BPU_Apel, conDENGT

#print_r($_GET);

//////////////////////////////////////////////////
//
//       Stokage des données
//
/////////////////////////////////////////////////

try {
	$conDENGT->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sth = $conDENGT->prepare("
		UPDATE DENGT.A0_DemandeEngt SET A0_080_Annulee_ON = 'O' WHERE A0_DemandeEngt.A0_000_idSql = ".$_GET['Val_A0_000_idSql'].";
	");
	$sth->execute();
	echo "La demande ".$_GET['Val_A0_000_idSql']." à été supprimée";
}
catch(PDOException $e){
	#echo "UPDATE DENGT.A0_DemandeEngt SET A0_080_Annulee_ON = 'O' WHERE A0_DemandeEngt.A0_000_idSql = ".$_POST['Val_A0_000_idSql'];
	echo "Erreur update A0_DemandeEngt : " . $e->getMessage();
}
?>