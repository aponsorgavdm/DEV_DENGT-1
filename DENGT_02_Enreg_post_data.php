<?php
		
/////////////////////////////////////////////////
//
//       Fonctions
//
/////////////////////////////////////////////////
require_once('../_Fonctions/_Dates/F_Date_Mysql_Vers_FR.php');
// retourne un date donnĂ©e au format Mysql (2013-12-31) en format Fr (31/12/2013)
// si date ($date) non renseignee prend la date du jour
require_once('../_Fonctions/_Dates/F_Date_FR_Vers_Mysql.php');
// retourne un date donnĂ©e au format Fr (31/12/2013) en format  Mysql (2013-12-31)
// si date ($date) non renseignee prend la date du jour
// F_Date_FR_Vers_Mysql("31/03/2013") ->>>  2013-03-31
	
function valid_donnees_mysql($donnees){
        $donnees = trim($donnees); // supprime blanc debut et fin
        $donnees = stripslashes($donnees); // supprime les antislash
        $donnees = str_replace("'"," ",$donnees); // remplace ' par blanc
        $donnees = str_replace('"',' ',$donnees); // remplace " par blanc
        $donnees = str_replace('<script>','',$donnees); // supprime  script> 
        $donnees = str_replace('</script>','',$donnees); // supprime  script> 
        return $donnees;
}	
	

$t_data_A0 = array();
$t_data_A22 = array();
$t_data_A31 = array();

/////////////////////
//
//		variables pour determiner type de demande
//
/////////////////////
$v_TypDep = ""; // OPA,OPI,IMP,FONC
$v_A0_040_TypDep = ""; // I,F,A recalcule via $v_TypDep
$v_A0_050_ModeFinanc = ""; // IMP,N,AJUST,AUTO

$v_TypDep = $_POST['input_FoncInvest'];


/////////////////////
//
//		Mise en variable des données communes v0.1
//
////////////////////
$v_A0_000_idSql = $_POST['val_A0_000_idSql'];
$v_A0_001_Srv = $_SESSION['VG_Srv_Compta'];
$v_A0_002_Pour_pnom = $_POST['val_pnom_choisi'];
$v_A0_003_Par_pnom = $_SESSION['VG_Pnom'];
$v_A0_004_Ardt = $_POST['val_Ardt_choisi'];
$v_A0_005_Ex_Dem = date('Y');
$v_A0_006_CTR = $_POST['input_IdCtr'];
$v_A0_007_Tiers = $_POST['SelectNumTiers'];

$v_A0_008_RefDevis = utf8_decode(valid_donnees_mysql($_POST['input_RefDevis']));
#$v_A0_008_RefDevis = utf8_decode($_POST['input_RefDevis']); // la prepa de la req en PDO echape a priori les ' à vérifier

$v_A0_009_DateDevis = F_Date_FR_Vers_Mysql($_POST['input_DateDevis']);

$sqltva = "
	SELECT E0_001_Taux_TVA 
	FROM 
	E0_Taux_TVA 
	WHERE 
	E0_000_idSql = '".$_POST['SelectType_TVA']."'";
#echo $sql01."<br>";	
$pdo_sqltva = $conDENGT->query($sqltva)->fetchAll(PDO::FETCH_ASSOC);
foreach ($pdo_sqltva  as $key_sqltva  => $pdo_lignes_sqltva) {
}
$v_A0_010_TVA = 1+($pdo_lignes_sqltva['E0_001_Taux_TVA']/100);
if ($_POST['SelectHtTTC'] == "TTC") {
	$v_A0_011_Mt_HT = $_POST['input_MtDem'] / $v_A0_010_TVA;
} else {
	$v_A0_011_Mt_HT = $_POST['input_MtDem'];
}
$v_A0_010_TVA = $_POST['SelectType_TVA'];


if ($_POST['val_SelectRevisable'] == "Non") {
	$v_A0_012_Mt_RVP_HT = 0;
} else {
	$v_A0_012_Mt_RVP_HT = ($v_A0_011_Mt_HT*$_POST['input_TauxRvp'])-$v_A0_011_Mt_HT;
};
$v_A0_013_Taux_RVP = $_POST['input_TauxRvp'];
$v_A0_020_DatDeb = F_Date_FR_Vers_Mysql($_POST['input_DateDebTRX']);
$v_A0_021_DatFin = F_Date_FR_Vers_Mysql($_POST['input_DateFinTRX']);

$v_A0_022_ObjEngt = utf8_decode(valid_donnees_mysql($_POST['input_LibTrx']));

$v_A0_023_TypEngt = $_POST['input_EtudTrx'];
$v_A0_024_VdmProp_O_N = $_POST['SelectVilleProp'];

$v_A0_025_Lieu = utf8_decode(valid_donnees_mysql($_POST['input_LieuTrx']));

//$v_A0_030_TypBT = ""; // v0.1
//$v_A0_031_NomBT = ""; // v0.1
switch($v_TypDep) {
	case 'OPA' :
		$v_A0_040_TypDep = "A";
		break;
	case 'IMP' :
		$v_A0_040_TypDep = "A";
		break;
	case 'OPI' :
		$v_A0_040_TypDep = "I";
		break;
	case 'FONC' :
		$v_A0_040_TypDep = "F";
		break;
	default :
		$v_A0_040_TypDep = "?";
}
$v_A0_041_Budget = $_POST['SelectTypeBud'];
//$v_A0_042_Ib_Chapitre = ""; // gere dans module demande en Equipement I et A ou demande en fonctionnement
//$v_A0_043_Ib_Nature = ""; // gere dans module demande en Equipement I et A ou demande en fonctionnement
//$v_A0_044_Ib_Fonction= ""; // gere dans module demande en Equipement I et A ou demande en fonctionnement
//$v_A0_044_B_Ib_Sdg = ""; // gere dans module demande en fonctionnement
//$v_A0_045_CodeAction = ""; // v0.1
//$v_A0_045_B_CMP = ""; // gere dans module demande en Equipement I et A ou demande en fonctionnement
//$v_A0_046_idResa = "0000_000000_000_00"; // gere dans module demande en Equipement I et A
//$v_A0_047_NumOPE = "0000 - 00 - 0000";  // gere dans module demande en Equipement I et A
//$v_A0_048_idMip = ""; // gere dans module demande en Equipement I et A
$v_A0_049_MtDepas = $_POST['input_Mt_Depas'];
$v_A0_050_ModeFinanc = $_POST['input_DepasMip'];
//$v_A0_051_JustifDepas = ""; // gere dans module demande en Equipement I et A
$v_A0_060_Statut = $_POST['Val_Statut'];
//$v_A0_061_Num_Engt_Peg = ""; // v0.1
//$v_A0_062_DatHeurEngt = ""; // v0.1
//$v_A0_063_DatAccRefu_PEG = ""; // v0.1
//$v_A0_064_Statut_PEG = ""; // v0.1
$v_A0_070_PrevMail_ON = $_POST['SuiviMail'];
$v_A0_080_Annulee_ON ="N"; ///////////////////////////////////////// attention si cet include utilisé en modif *****************************
$v_A0_101_pnom_last_modif = $_SESSION['VG_Pnom'];




$v_A22_002_TexteLong = utf8_decode(valid_donnees_mysql($_POST['inpute_TexteLong']));
$v_A22_101_pnom_last_modif = $v_A0_101_pnom_last_modif;




$v_A31_002_TypRef = $_POST['SelectTypUPEP'];
$v_A31_003_idRefPat = $_POST['input_UPEP'];
$v_A31_101_pnom_last_modif = $v_A0_101_pnom_last_modif;




$v_A60B_002_Statut = $v_A0_060_Statut;
if ($v_A0_070_PrevMail_ON == 'N') {
	$v_A60B_003_EmailEnvoye = '0';
} else {
	$v_A60B_003_EmailEnvoye = 'N'; ///////////////////////////////////////// attention si cet include utilisé en modif *****************************
}
$v_A60B_004_DatEnvoiMail = '0000-00-00';  ///////////////////////////////////////// attention si cet include utilisé en modif *****************************
$v_A60B_100_Dat_last_modif = date('Y-m-d H:i:s');
$v_A60B_101_pnom_last_modif = $v_A0_101_pnom_last_modif;


/////////////////////
//
//		colonnes non gérées dans la version v0.1
//
////////////////////
$v_A0_030_TypBT = "";
$v_A0_031_NomBT = "";
$v_A0_045_CodeAction = "";
$v_A0_061_Num_Engt_Peg = "";
$v_A0_062_DatHeurEngt = "0000-00-00 00:00:00";
$v_A0_063_DatAccRefu_PEG = "0000-00-00";
$v_A0_064_Statut_PEG = "";



/////////////////////
//
//		mise a valeur par defaut des colonnes non communes
//
////////////////////
$v_A0_042_Ib_Chapitre = "0";
$v_A0_043_Ib_Nature = "0";
$v_A0_044_Ib_Fonction= "0";
$v_A0_044_B_Ib_Sdg = "";
$v_A0_045_B_CMP = "";
$v_A0_046_idResa = "0000_000000_000_00";
$v_A0_047_NumOPE = "0000 - 00 - 0000";  
$v_A0_048_idMip = "0000-00-00000";
$v_A0_051_JustifDepas = "";


/////////////////////
//
//		demande en fonctionnement
//
////////////////////
if ($v_A0_040_TypDep == 'F') {
	$v_A0_043_Ib_Nature = $_POST['SelectIbNat'];
	$v_A0_044_Ib_Fonction= $_POST['SelectIbFonc'];
	$sql01 = "SELECT H_026_Ib_Chapitre FROM h_ib WHERE H_000_Id_Ib LIKE '%_".$v_A0_043_Ib_Nature."_".$v_A0_044_Ib_Fonction."_".$v_A0_001_Srv."_".$v_A0_041_Budget."'";
#echo $sql01."<br>";	
	$pdo_01 = $conn->query($sql01)->fetchAll(PDO::FETCH_ASSOC);
	if(count($pdo_01) == 1) {
		foreach ($pdo_01 as $key_pdo_01  => $pdo_lignes_pdo_01 ) {
		}
		$v_A0_042_Ib_Chapitre = $pdo_lignes_pdo_01['H_026_Ib_Chapitre'];
		$v_A0_044_B_Ib_Sdg = valid_donnees_mysql($_POST['input_SDG']);
		$v_A0_045_B_CMP = valid_donnees_mysql($_POST['input_CMP_F']);
	}
} // if ($v_A0_040_TypDep == 'F') {
	
	
	
/////////////////////
//
//		demande en Equipement I et A
//
////////////////////
if (($v_A0_040_TypDep == 'I') or ($v_A0_040_TypDep == 'A')) {
#echo "I ou A<br>";
	if ($_POST['SelectIbOpi'] != '?') {
        $t_SelectIbOpi = explode(" - ", $_POST['SelectIbOpi']); // 21_2128_211_50502 - Autres agencements.......
        $t_DecoupIb = explode("_",$t_SelectIbOpi[0]); // 21_2128_211_50502
        $v_A0_042_Ib_Chapitre = $t_DecoupIb[0];
        $v_A0_043_Ib_Nature = $t_DecoupIb[1];
        $v_A0_044_Ib_Fonction= $t_DecoupIb[2];
    }
	$v_A0_045_B_CMP = valid_donnees_mysql($_POST['input_CMP_I']);
    if ($_POST['SelectResaOpi'] != '?') {
		$v_A0_046_idResa = $_POST['SelectResaOpi'];
    }
	switch($v_A0_040_TypDep) {
		case 'A':
#echo "case A<br>";
			switch($_POST['input_FoncInvest']) {
				case 'OPA':
#echo "case OPA<br>";
					$v_A0_047_NumOPE = $_POST['SelectNum_OPA'];
					$t_A0_047_NumOPE = explode(" - ", $v_A0_047_NumOPE); // 2020 - MA - 5548
					$sql01 = "SELECT F5_131_Id_Niv_1, F5_133_Id_Niv_2  FROM f5_ope_mip WHERE F5_000_id_Ope = '".$v_A0_047_NumOPE."' AND F5_135_Id_Niv_3 LIKE '%-".$_POST['input_NumMip']."'";
#echo $sql01."<br>";
					$pdo_01 = $conn->query($sql01)->fetchAll(PDO::FETCH_ASSOC);
					foreach ($pdo_01 as $key_pdo_01  => $pdo_lignes_pdo_01 ) {
					}
					$v_A0_048_idMip = $pdo_lignes_pdo_01['F5_131_Id_Niv_1']."_".$pdo_lignes_pdo_01['F5_133_Id_Niv_2']."_".$_POST['input_NumMip'];
					break;
				case 'IMP':
#echo "case IMP<br>";
					$v_A0_047_NumOPE = $_POST['SelectNum_OPA_IMP'];
					break;
			}
			
			if ($_POST['input_DepasMip'] == "AUTO") {
				$v_A0_051_JustifDepas = valid_donnees_mysql($_POST['DetailTextejustifdepas']);
			}
			break;
		case 'I':
#echo "case I<br>";
			$v_A0_047_NumOPE = $_POST['input_ExOPI']." - ".$_POST['input_TypOPI']." - ".$_POST['input_NumOPI'];
			break;
	}
} // if (($v_A0_040_TypDep == 'I') or ($v_A0_040_TypDep == 'A')) {
	

/////////////////////
//
//		mise en tableau des data
//
////////////////////	
$t_data_A0[] = $v_A0_000_idSql;	
$t_data_A0[] = $v_A0_001_Srv;
$t_data_A0[] = $v_A0_002_Pour_pnom;
$t_data_A0[] = $v_A0_003_Par_pnom;
$t_data_A0[] = $v_A0_004_Ardt;
$t_data_A0[] = $v_A0_005_Ex_Dem; // key N°5
$t_data_A0[] = $v_A0_006_CTR;
$t_data_A0[] = $v_A0_007_Tiers;
$t_data_A0[] = $v_A0_008_RefDevis;
$t_data_A0[] = $v_A0_009_DateDevis;
$t_data_A0[] = $v_A0_010_TVA; // key N°10
$t_data_A0[] = $v_A0_011_Mt_HT;
$t_data_A0[] = $v_A0_012_Mt_RVP_HT;
$t_data_A0[] = $v_A0_013_Taux_RVP;
$t_data_A0[] = $v_A0_020_DatDeb;
$t_data_A0[] = $v_A0_021_DatFin; // key N°15
$t_data_A0[] = $v_A0_022_ObjEngt;
$t_data_A0[] = $v_A0_023_TypEngt;
$t_data_A0[] = $v_A0_024_VdmProp_O_N;
$t_data_A0[] = $v_A0_025_Lieu;
$t_data_A0[] = $v_A0_030_TypBT; // v0.1 // key N°20
$t_data_A0[] = $v_A0_031_NomBT; // v0.1
$t_data_A0[] = $v_A0_040_TypDep;
$t_data_A0[] = $v_A0_041_Budget;
$t_data_A0[] = $v_A0_042_Ib_Chapitre;
$t_data_A0[] = $v_A0_043_Ib_Nature; //key  N°25
$t_data_A0[] = $v_A0_044_Ib_Fonction;
$t_data_A0[] = $v_A0_044_B_Ib_Sdg;
$t_data_A0[] = $v_A0_045_CodeAction; // v0.1
$t_data_A0[] = $v_A0_045_B_CMP;
$t_data_A0[] = $v_A0_046_idResa; // key N°30
$t_data_A0[] = $v_A0_047_NumOPE; 
$t_data_A0[] = $v_A0_048_idMip;
$t_data_A0[] = $v_A0_049_MtDepas;
$t_data_A0[] = $v_A0_050_ModeFinanc;
$t_data_A0[] = $v_A0_051_JustifDepas; // key N°35
$t_data_A0[] = $v_A0_060_Statut;
$t_data_A0[] = $v_A0_061_Num_Engt_Peg; // v0.1
$t_data_A0[] = $v_A0_062_DatHeurEngt; // v0.1
$t_data_A0[] = $v_A0_063_DatAccRefu_PEG; // v0.1
$t_data_A0[] = $v_A0_064_Statut_PEG; // v0.1 // key N°40
$t_data_A0[] = $v_A0_070_PrevMail_ON; // v0.1
$t_data_A0[] = $v_A0_080_Annulee_ON;
$t_data_A0[] = $v_A0_101_pnom_last_modif;

$t_data_A22[] = "" ; //A22_000_idSql
$t_data_A22[] = "" ; //A22_001_idSql_A0
$t_data_A22[] = $v_A22_002_TexteLong;
$t_data_A22[] = $v_A22_101_pnom_last_modif;

$t_data_A31[] = "" ; //A31_000_idSql
$t_data_A31[] = "" ; //A31_001_idSql_A0
$t_data_A31[] = $v_A31_002_TypRef;
$t_data_A31[] = $v_A31_003_idRefPat;
$t_data_A31[] = $v_A31_101_pnom_last_modif;

$t_data_A60B[] = "" ; //A60B_000_idSql
$t_data_A60B[] = "" ; //A60B_001_idSql_A0
$t_data_A60B[] = $v_A60B_002_Statut;
$t_data_A60B[] = $v_A60B_003_EmailEnvoye;
$t_data_A60B[] = $v_A60B_004_DatEnvoiMail;
$t_data_A60B[] = $v_A60B_100_Dat_last_modif;
$t_data_A60B[] = $v_A60B_101_pnom_last_modif;
?>