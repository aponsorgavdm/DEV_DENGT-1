<?php

require_once('../_Sessions/Verif_Ses.php');

//////////////////////////////////////////////////
//
//       connexion Mysql
//
/////////////////////////////////////////////////
require_once('Connections/PDO_Prod_Util_AO_BPU.php');
// connProd et conn =Pegase_Data_BO_Prod , connUtil=utilisateurdgabc, connAO=Analyse_AO, conBPU=BPU_Apel, conDENGT

require_once('../_Fonctions/_Dates/F_Date_Mysql_Vers_FR.php');

function array_msort($array, $cols)
{
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;

}

function bidon() {
	$Home1 = substr($_SERVER['SCRIPT_FILENAME'],19,strlen($_SERVER['SCRIPT_FILENAME'])); // $_SERVER['SCRIPT_FILENAME']=> /Users/apons/Sites/................
	#echo $_SERVER['SCRIPT_FILENAME']."<br>";
	#echo $Home1."<br>";

	$tab_Home1= explode("/",$Home1);
	$V_Nbr_lign_Home1=count($tab_Home1);
	if (($V_Nbr_lign_Home1 == 1) and ($tab_Home1[0] != "")) {
		#echo "./"."<br>"; // la page est à la racine du site
		$chemin_to_racine= "./";
	} else {
		switch ($V_Nbr_lign_Home1)  {
			case 2 :
				$chemin_to_racine="../";
				break;
			case 3 :
				$chemin_to_racine="../../";
				break;
			case 4 :
				$chemin_to_racine="../../../";
				break;
			case 5 :
				$chemin_to_racine= "../../../../";
				break;
			case 6 :
				$chemin_to_racine= "../../../../../";
				break;
			case 7 :
				$chemin_to_racine= "../../../../../../";
				break;
		}
	}
	return $chemin_to_racine ;
}
$chemin_to_racine = bidon();

/////////////////////
//
//
//
////////////////////

if (($_GET['tab'] == "1")) { 
		$t_01_retour = array();
		
		$t_ardt = explode("_", $_SESSION['VG_droits_DENGT_Ardt']);
		$v_sql_in_ardt = "";
		if (count($t_ardt) == 1) {
			$v_sql_in_ardt = "'".$_SESSION['VG_droits_DENGT_Ardt']."'";
		} else { // if (count($t_ardt) == 1) {
			foreach ($t_ardt as $key => $value) {
				$v_sql_in_ardt .= "'".$value."',";
			}
#echo $v_sql_in_ardt."<br>";
			$v_sql_in_ardt = substr($v_sql_in_ardt,0,-1);
#echo $v_sql_in_ardt."<br>";
		} // if (count($t_ardt) == 1) {
		
		if($_GET['v_QuoiVoir'] == 'profil') {
			switch ($_GET['v_profilDengt']) {
				case 'DEM':
					$v_sql_in_statut = "and A0_060_Statut IN ('PROJ', 'SOUM','VISEE','ATTCOMPTA') ";
					break;
				case 'VALID':
					$v_sql_in_statut = "and A0_060_Statut IN ('SOUM') ";
					break;
				case 'COMPTA':
					$v_sql_in_statut = "and A0_060_Statut IN ('VISEE','ATTSAI','ATTCOMPTA','ATTPEG') ";
					break;
				default:
					$v_sql_in_statut = "and A0_060_Statut IN ('SOUM','VISEE','ATTCOMPTA') ";
			}
		} else {
			$v_sql_in_statut = "";
		}
	#echo "v_sql_in_statut : ".$v_sql_in_statut;
		
		/*		
		$sql01 = "
			select 
			A0_000_idSql, A0_002_Pour_pnom, A0_004_Ardt, A0_025_Lieu, A0_022_ObjEngt, A0_060_Statut, A0_011_Mt_HT, A0_012_Mt_RVP_HT, A0_043_Ib_Nature, A0_046_idResa, A0_040_TypDep, 
			DATEDIFF(now(), A60B_100_Dat_last_modif) as diferenceDat, 
			date(Z1_007_DatEvent) as DatCrea
			from 
			A0_DemandeEngt, A60B_Histo_statut, Z1_SuiviMaj
			where 
			A60B_001_idSql_A0 = A0_000_idSql and A60B_002_Statut = A0_060_Statut 
			and 
			Z1_002_idSqlDansTable = A0_000_idSql and Z1_003_TypEvent = 'Creation' and Z1_001_NomTable = 'A0_DemandeEngt'  
			and 
			A0_080_Annulee_ON = 'N' 
			and 
			A0_060_Statut IN (".$v_sql_in_statut.") 
			and ";
		switch ($_SESSION['VG_droits_DENGT_profil']) {
			case 'DEM':	
				$sql01 .= "A0_002_Pour_pnom = '".$_SESSION['VG_Pnom']."'";
				break;
			case 'VALID':	
				$sql01 .= "(A0_002_Pour_pnom = '".$_SESSION['VG_Pnom']."' OR A0_004_Ardt IN (".$v_sql_in_ardt."))";
				break;
			case 'COMPTA':	
				$sql01 .= "(A0_002_Pour_pnom = '".$_SESSION['VG_Pnom']."' OR A0_004_Ardt IN (".$v_sql_in_ardt."))";
				break;
			case 'ADMIN':	
				$sql01 .= "(A0_002_Pour_pnom = '".$_SESSION['VG_Pnom']."' OR A0_004_Ardt IN (".$v_sql_in_ardt."))";
				break;
			default:	
				$sql01 .= "A0_002_Pour_pnom = '".$_SESSION['VG_Pnom']."'";
		}
			
			$sql01 .= "order by A0_000_idSql;";
		*/
			
		$sql01 = "
			select 
			A0_000_idSql, A0_002_Pour_pnom, A0_004_Ardt, A0_025_Lieu, A0_022_ObjEngt, A0_060_Statut, A0_011_Mt_HT, A0_012_Mt_RVP_HT, A0_043_Ib_Nature, A0_046_idResa, A0_040_TypDep, 
			DATEDIFF(now(), A60B_100_Dat_last_modif) as diferenceDat, A60B_100_Dat_last_modif, 
			date(Z1_007_DatEvent) as DatCrea
			from 
			A0_DemandeEngt, A60B_Histo_statut, Z1_SuiviMaj
			where 
			A60B_001_idSql_A0 = A0_000_idSql and A60B_002_Statut = A0_060_Statut 
			and 
			Z1_002_idSqlDansTable = A0_000_idSql and Z1_003_TypEvent = 'Creation' and Z1_001_NomTable = 'A0_DemandeEngt'  
			and 
			A0_080_Annulee_ON = 'N' 
			and ";
		switch ($_SESSION['VG_droits_DENGT_profil']) {
			case 'DEM':	
				$sql01 .= "A0_002_Pour_pnom = '".$_SESSION['VG_Pnom']."'";
				break;
			case 'VALID':	
				$sql01 .= "(A0_002_Pour_pnom = '".$_SESSION['VG_Pnom']."' OR A0_004_Ardt IN (".$v_sql_in_ardt."))";
				break;
			case 'COMPTA':	
				$sql01 .= "(A0_002_Pour_pnom = '".$_SESSION['VG_Pnom']."' OR A0_004_Ardt IN (".$v_sql_in_ardt."))";
				break;
			case 'ADMIN':	
				$sql01 .= "(A0_002_Pour_pnom = '".$_SESSION['VG_Pnom']."' OR A0_004_Ardt IN (".$v_sql_in_ardt."))";
				break;
			default:	
				$sql01 .= "A0_002_Pour_pnom = '".$_SESSION['VG_Pnom']."'";
		}
			
			$sql01 .= "order by A0_000_idSql;";
//echo $sql01."<br>";			
		$pdo_01 = $conDENGT->query($sql01)->fetchAll(PDO::FETCH_ASSOC);
		foreach ($pdo_01 as $key_pdo_01 => $pdo_lignes_pdo_01) {
			$v_Mt_TTC = 0;
			$v_Mt_TTC = ($pdo_lignes_pdo_01['A0_011_Mt_HT'] + $pdo_lignes_pdo_01['A0_012_Mt_RVP_HT'])*(($pdo_lignes_pdo_01['E0_001_Taux_TVA']/100)+1);
			
			$v_A0_040_TypDep = "";
			switch ($pdo_lignes_pdo_01['A0_040_TypDep']) {
				case 'F':
					$v_A0_040_TypDep = "Fonc";
					break;
				case 'I':
					$v_A0_040_TypDep = "OPI";
					break;
				case 'A':
					$v_A0_040_TypDep = "OPA";
					break;
			}
			
			$v_iconComptaIB = '<img src="'.$chemin_to_racine.'DirCA/images/ib_out_32_32.png" width="16" height="16" align="middle" title="ib non renseignée"/>';
			$v_iconComptaResa = "";
			if ($pdo_lignes_pdo_01['A0_043_Ib_Nature'] != '?') {
				$v_iconComptaIB = '<img src="'.$chemin_to_racine.'DirCA/images/ib_ok_32_32.png" width="16" height="16" align="middle" title="ib renseignée"/>';
			}
			if (($pdo_lignes_pdo_01['A0_040_TypDep'] != 'F') and ($pdo_lignes_pdo_01['A0_040_TypDep'] != 'A')) {
				if ($pdo_lignes_pdo_01['A0_046_idResa'] != '0000_000000_000_00') {
					$v_iconComptaResa = '&nbsp;&nbsp;<img src="'.$chemin_to_racine.'DirCA/images/Resa_ok_32_32.png" width="16" height="16" align="middle" title="Resa renseignée"/>';
				} else {
					$v_iconComptaResa = '&nbsp;&nbsp;<img src="'.$chemin_to_racine.'DirCA/images/Resa_out_32_32.png" width="16" height="16" align="middle" title="Resa non renseignée"/>';
				}
			}
			
			$v_iconCompta = $v_iconComptaIB.$v_iconComptaResa;
#echo $v_iconCompta;
			$v_BtAction = "DENG_02_Crea_PDF_Dem.php?v_A0_000_idSql=".$pdo_lignes_pdo_01['A0_000_idSql']."&Sortie=pdf&Supp=O";
			
			$v_BtPdf = "DENG_02_Crea_PDF_Dem.php?v_A0_000_idSql=".$pdo_lignes_pdo_01['A0_000_idSql']."&Sortie=pdf";
			
			$v_BtVoir = "http://".$_SERVER['HTTP_HOST']."/Dirca/DENG_02_Crea_PDF_Dem.php?v_A0_000_idSql=".$pdo_lignes_pdo_01['A0_000_idSql']."&Sortie=ecran";
			
			$v_statut = $pdo_lignes_pdo_01['A0_060_Statut'].'&nbsp;&nbsp;<span style="vertical-align:middle;"><img src="'.$chemin_to_racine.'DirCA/images/help_16_16.png" width="12" height="12" title="Info Statut" data="'.$chemin_to_racine.'DirCA/images/DENGT_Enchainement_Statuts_'.$pdo_lignes_pdo_01['A0_060_Statut'].'.png data2="'.F_Date_Mysql_Vers_FR(substr($pdo_lignes_pdo_01['A60B_100_Dat_last_modif'],0,10)).'"/></span>';
			
			$t_01_retour[] = array(
							'A0_000_idSql' => mb_convert_encoding($pdo_lignes_pdo_01['A0_000_idSql'],'UTF-8','UTF-8'),
							'A60B_100_Dat_last_modif' => mb_convert_encoding(F_Date_Mysql_Vers_FR($pdo_lignes_pdo_01['DatCrea']),'UTF-8','UTF-8'),
							'A0_040_TypDep' => mb_convert_encoding($v_A0_040_TypDep,'UTF-8','UTF-8'),
							'A0_002_Pour_pnom' => mb_convert_encoding($pdo_lignes_pdo_01['A0_002_Pour_pnom'],'UTF-8','UTF-8'),
							'A0_004_Ardt' => mb_convert_encoding($pdo_lignes_pdo_01['A0_004_Ardt'],'UTF-8','UTF-8'),
							'A0_025_Lieu' => mb_convert_encoding($pdo_lignes_pdo_01['A0_025_Lieu'],'UTF-8','UTF-8'),
							'A0_022_ObjEngt' => mb_convert_encoding($pdo_lignes_pdo_01['A0_022_ObjEngt'],'UTF-8','UTF-8'),
							'A0_011_Mt_HT' => mb_convert_encoding($v_Mt_TTC,'UTF-8','UTF-8'),
							'A0_060_Statut' => mb_convert_encoding($v_statut,'UTF-8','UTF-8'),
							'iconCompta' => mb_convert_encoding($v_iconCompta,'UTF-8','UTF-8'),
							'DifDatJourmoinsDatStatut' => mb_convert_encoding($pdo_lignes_pdo_01['diferenceDat'],'UTF-8','UTF-8'),
							'BtAction' => mb_convert_encoding($v_BtAction,'UTF-8','UTF-8'),
							'BtPdf' => mb_convert_encoding($v_BtPdf,'UTF-8','UTF-8'),
							'BtVoir' => mb_convert_encoding($v_BtVoir,'UTF-8','UTF-8'),
							);
		}
		#echo "<pre>";
		$t_01_retour = array_msort($t_01_retour, array('A0_000_idSql'=>SORT_DESC, 'A0_011_Mt_HT'=>SORT_DESC));
		#print_r($t_01_retour);
		$t_01_retour = array_values($t_01_retour);
		echo json_encode($t_01_retour);
}
?>
				