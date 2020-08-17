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


if ($_SESSION['VG_Pnom'] == 'apons') {
	$_SESSION['VG_Srv'] = '50602';
#echo "<pre>";
	#echo "Session : ";
	#print_r($_SESSION);
	#echo "server : ";
	#print_r($_SERVER);
#echo " donnees post : ";
#print_r($_POST);
	#echo "get : ";
	#print_r($_GET);
#echo "</pre>";

include 'DENGT_02_Enreg_post_data.inc';
// en sortie de include $t_data_A0 contient toutes les data de AO
// en sortie de include $t_data_A22 contient toutes les data de A22
// en sortie de include $t_data_A31 contient toutes les data de A31

echo "<pre>";
echo " data de AO : ";
print_r($t_data_A0);
echo " data de A22 : ";
print_r($t_data_A22);
echo " data de A31 : ";
print_r($t_data_A31);
echo "</pre>";

/* echo "----------------------<br>";
echo "<br>";
echo "v_A0_000_idSql : ".$v_A0_000_idSql."<br>";
echo "v_A0_001_Srv : ".$v_A0_001_Srv."<br>";
echo "v_A0_002_Pour_pnom : ".$v_A0_002_Pour_pnom."<br>";
echo "v_A0_003_Par_pnom : ".$v_A0_003_Par_pnom."<br>";
echo "v_A0_004_Ardt : ".$v_A0_004_Ardt."<br>";
echo "v_A0_005_Ex_Dem : ".$v_A0_005_Ex_Dem."<br>";
echo "v_A0_006_CTR : ".$v_A0_006_CTR."<br>";
echo "v_A0_007_Tiers : ".$v_A0_007_Tiers."<br>";

echo "v_A0_008_RefDevis : ".$v_A0_008_RefDevis."<br>";

echo "v_A0_009_DateDevis : ".$v_A0_009_DateDevis."<br>";
echo "v_A0_010_TVA : ".$v_A0_010_TVA."<br>";
echo "v_A0_011_Mt_HT : ".$v_A0_011_Mt_HT."<br>";
echo "v_A0_013_Taux_RVP : ".$v_A0_013_Taux_RVP."<br>";
echo "v_A0_012_Mt_RVP_HT : ".$v_A0_012_Mt_RVP_HT."<br>";
echo "v_A0_020_DatDeb : ".$v_A0_020_DatDeb."<br>";
echo "v_A0_021_DatFin : ".$v_A0_021_DatFin."<br>";

echo "v_A0_022_ObjEngt : ".$v_A0_022_ObjEngt."<br>";

echo "v_A0_023_TypEngt : ".$v_A0_023_TypEngt."<br>";
echo "v_A0_024_VdmProp_O_N : ".$v_A0_024_VdmProp_O_N."<br>";

echo "v_A0_025_Lieu : ".$v_A0_025_Lieu."<br>";

//$v_A0_030_TypBT = ""; // v0.1
//$v_A0_031_NomBT = ""; // v0.1
echo "v_A0_040_TypDep : ".$v_A0_040_TypDep."<br>";
echo "v_A0_041_Budget : ".$v_A0_041_Budget."<br>";
echo "v_A0_042_Ib_Chapitre : ".$v_A0_042_Ib_Chapitre."<br>";
echo "v_A0_043_Ib_Nature : ".$v_A0_043_Ib_Nature."<br>";
echo "v_A0_044_Ib_Fonction : ".$v_A0_044_Ib_Fonction."<br>";
echo "v_A0_044_B_Ib_Sdg : ".$v_A0_044_B_Ib_Sdg."<br>";
//$v_A0_045_CodeAction = ""; // v0.1
echo "v_A0_045_B_CMP : ".$v_A0_045_B_CMP."<br>";
echo "v_A0_046_idResa : ".$v_A0_046_idResa."<br>";
echo "v_A0_047_NumOPE : ".$v_A0_047_NumOPE."<br>";
echo "v_A0_048_idMip : ".$v_A0_048_idMip."<br>";
echo "v_A0_049_MtDepas : ".$v_A0_049_MtDepas."<br>";
echo "v_A0_050_ModeFinanc : ".$v_A0_050_ModeFinanc."<br>";
echo "v_A0_051_JustifDepas : ".$v_A0_051_JustifDepas."<br>";
echo "v_A0_060_Statut : ".$v_A0_060_Statut."<br>";
//$v_A0_061_Num_Engt_Peg = ""; // v0.1
//$v_A0_062_DatHeurEngt = ""; // v0.1
//$v_A0_063_DatAccRefu_PEG = ""; // v0.1
//$v_A0_064_Statut_PEG = ""; // v0.1
//$v_A0_070_PrevMail_ON = ""; // v0.1
echo "v_A0_080_Annulee_ON : ".$v_A0_080_Annulee_ON."<br>";
echo "v_A0_101_pnom_last_modif : ".$v_A0_101_pnom_last_modif."<br>";


echo "v_A22_002_TexteLong : ".$v_A22_002_TexteLong."<br>";
echo "v_A22_101_pnom_last_modif : ".$v_A22_101_pnom_last_modif."<br>";


echo "v_A31_002_TypRef : ".$v_A31_002_TypRef."<br>";
echo "v_A31_003_idRefPat : ".$v_A31_003_idRefPat."<br>";
echo "v_A31_101_pnom_last_modif : ".$v_A31_101_pnom_last_modif."<br>"; */


//////////////////////////////////////////////////
//
//       Stokage des données
//
/////////////////////////////////////////////////

try {
	$conDENGT->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sth = $conDENGT->prepare("
		INSERT INTO A0_DemandeEngt
		(
		A0_000_idSql , 
		A0_001_Srv , 
		A0_002_Pour_pnom , 
		A0_003_Par_pnom , 
		A0_004_Ardt , 
		A0_005_Ex_Dem , 
		A0_006_CTR , 
		A0_007_Tiers , 
		A0_008_RefDevis , 
		A0_009_DateDevis , 
		A0_010_TVA , 
		A0_011_Mt_HT , 
		A0_012_Mt_RVP_HT , 
		A0_013_Taux_RVP , 
		A0_020_DatDeb , 
		A0_021_DatFin , 
		A0_022_ObjEngt , 
		A0_023_TypEngt , 
		A0_024_VdmProp_O_N , 
		A0_025_Lieu , 
		A0_030_TypBT , 
		A0_031_NomBT , 
		A0_040_TypDep , 
		A0_041_Budget , 
		A0_042_Ib_Chapitre , 
		A0_043_Ib_Nature , 
		A0_044_Ib_Fonction , 
		A0_044_B_Ib_Sdg , 
		A0_045_CodeAction , 
		A0_045_B_CMP , 
		A0_046_idResa , 
		A0_047_NumOPE , 
		A0_048_idMip , 
		A0_049_MtDepas , 
		A0_050_ModeFinanc , 
		A0_051_JustifDepas , 
		A0_060_Statut , 
		A0_061_Num_Engt_Peg , 
		A0_062_DatHeurEngt , 
		A0_063_DatAccRefu_PEG , 
		A0_064_Statut_PEG , 
		A0_070_PrevMail_ON , 
		A0_080_Annulee_ON , 
		A0_101_pnom_last_modif
		) 
		VALUE  
		(
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		? , 
		?
		)
	");
	$sth->execute($t_data_A0);
	$v_id_Dem = $conDENGT->lastInsertId();
	
	//////////////////////////////////////////////////
	//
	//       Stokage A22_ObjetLong
	//
	/////////////////////////////////////////////////
	
	$t_data_A22[0] = "NULL"; // A22_000_idSql
	$t_data_A22[1] = $v_id_Dem; // A22_001_idSql_A0
	try {
		$conDENGT->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sth = $conDENGT->prepare("
			INSERT INTO A22_ObjetLong
			(
			A22_000_idSql, 
			A22_001_idSql_A0, 
			A22_002_TexteLong, 
			A22_101_pnom_last_modif
			) 
			VALUE  
			(
			? , 
			? , 
			? , 
			?
			)
		");
		$sth->execute($t_data_A22);
	}
	catch(PDOException $e){
		echo "Erreur INSERT INTO A22_ObjetLong : " . $e->getMessage();
	}
	
	//////////////////////////////////////////////////
	//
	//       Stokage A31_RefPatEngt
	//
	/////////////////////////////////////////////////
	
	$t_data_A31[0] = "NULL"; // A31_000_idSql
	$t_data_A31[1] = $v_id_Dem; // A31_001_idSql_A0
	try {
		$conDENGT->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sth = $conDENGT->prepare("
			INSERT INTO A31_RefPatEngt
			(
			A31_000_idSql, 
			A31_001_idSql_A0, 
			A31_002_TypRef, 
			A31_003_idRefPat, 
			A31_101_pnom_last_modif
			) 
			VALUE  
			(
			? , 
			? , 
			? , 
			? ,
			?
			)
		");
		$sth->execute($t_data_A31);
	}
	catch(PDOException $e){
		echo "Erreur INSERT INTO A31_RefPatEngt : " . $e->getMessage();
	}
	
	
}
catch(PDOException $e){
	echo "Erreur INSERT INTO A0_DemandeEngt : " . $e->getMessage();
}

echo "v_id_Dem : ".$v_id_Dem;



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