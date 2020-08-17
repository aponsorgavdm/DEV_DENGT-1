<?php

require_once('../_Sessions/Verif_Ses.php');

//////////////////////////////////////////////////
//
//       connexion Mysql
//
/////////////////////////////////////////////////
require_once('Connections/PDO_Prod_Util_AO_BPU.php');
// connProd et conn =Pegase_Data_BO_Prod , connUtil=utilisateurdgabc, connAO=Analyse_AO, conBPU=BPU_Apel, conDENGT

date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');
 

ini_set('max_execution_time', 0); // 600 secondes = 10 minutes

$v_title="DEV-----".$_SERVER['HTTP_HOST'];
if ($_SERVER['HTTP_HOST'] == '10.6.192.41') {
	$v_title="Site intranet de la DGAAVE";
}

		
/////////////////////////////////////////////////
//
//       Fonctions
//
/////////////////////////////////////////////////
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
function count_days($start, $end) {
	#if( $start != '0000-00-00' and $end != '0000-00-00' ) {
		$date1 = strtotime($start);
		$date2 = strtotime($end);
		$diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
		$retour = array();
	 
		$tmp = $diff;
		$retour['second'] = $tmp % 60;
	 
		$tmp = floor( ($tmp - $retour['second']) /60 );
		$retour['minute'] = $tmp % 60;
	 
		$tmp = floor( ($tmp - $retour['minute'])/60 );
		$retour['hour'] = $tmp % 24;
	 
		$tmp = floor( ($tmp - $retour['hour'])  /24 );
		$retour['day'] = $tmp;
	 	if ($retour['day'] == 0) {
			$retour['day'] = 1;
		}
		return $retour['day'];
	#} else {
		#return 0;
	#}
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



	
$v_A0_000_idSql = $_GET['v_A0_000_idSql'];
$sql01 = "
	SELECT * 
	FROM 
	A0_DemandeEngt  LEFT JOIN A22_ObjetLong ON A22_ObjetLong.A22_001_idSql_A0 = A0_DemandeEngt.A0_000_idSql 
	LEFT JOIN A31_RefPatEngt ON A31_RefPatEngt.A31_001_idSql_A0 = A0_DemandeEngt.A0_000_idSql 
	WHERE 
	A0_000_idSql = '".$v_A0_000_idSql."'";
#echo $sql01."<br>";	
	$pdo_01 = $conDENGT->query($sql01)->fetchAll(PDO::FETCH_ASSOC);
if(count($pdo_01) == 1) {
	ob_start();
	foreach ($pdo_01 as $key_pdo_01  => $pdo_lignes_pdo_01 ) {
	}
	
	switch($pdo_lignes_pdo_01['A0_040_TypDep']) {
		case "F" :
			$v1_A0_040_TypDep = "FONC";
			break;
		case "I" :
			$v1_A0_040_TypDep = "OPI";
			break;
		case "A" :
			$v1_A0_040_TypDep = "OPA";
			break;
	}
?>

  <?
  if ($_GET['Sortie'] == 'pdf') {
	  $v_margin_table = '-50px';
	  $v_epar_table = '45px';
  ?>
  <page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
      <page_header>
          <table style="border: solid 0px #666666; width: 700px;background-color: #666666; margin-left: -12px;" cellspacing="1" cellpadding="0">
              <tr style="height: 0px">
                  <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
              </tr>
              <tr style="height: 65px">
                  <td colspan="6" style="background-color:#FFFFFF;color: #666666;">&nbsp;Demande d'engagement imprimée le : <? echo date("d/m/Y");?> à <? echo date("H:i:s");?> par <? echo $_SESSION['VG_Pnom'];?></td>
                  <td style="background-color:#FFFFFF; text-align:center; font-size:24px"><? echo $v1_A0_040_TypDep; ?></td>
                  <td style="background-color:#FFFFFF;text-align: right; font-size:10px; vertical-align:baseline ;" align="center" valign="middle"><strong>DGAAVE</strong>&nbsp;&nbsp;<img src="images/SPI_64_64.png" width="32" height="32" align="absmiddle" />&nbsp;&nbsp;</td>
              </tr>
          </table>
      <br />
      </page_header>
      <page_footer>
          <div style="text-align: right;">page [[page_cu]]/[[page_nb]]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
      </page_footer>
  <?
  } else { //if ($_GET['Sortie'] == 'pdf') {
	  $v_margin_table = '0px';
	  $v_epar_table = '5px';
  ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
    <title><? echo $v_title; ?></title>	
    <meta http-equiv="Content-Language" content="fr" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
    
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/js/jquery.fileDownload.js"></script>

	<link rel="stylesheet" href="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxcore.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxdata.js"></script> 
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxbuttons.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxmenu.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxgrid.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxgrid.edit.js"></script>  
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxgrid.selection.js"></script> 
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxlistbox.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxcalendar.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxnumberinput.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/globalization/globalize.js"></script>
    
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxgrid.grouping.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxgrid.export.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxgrid.columnsresize.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxdata.export.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxgrid.aggregates.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxtooltip.js"></script>
    <body>
  <?
  } //if ($_GET['Sortie'] == 'pdf') {
  ?>
	<table style=" font-family:Arial, Helvetica, sans-serif; border: solid 0px #666666; width: 750px;background-color: #666666; margin-left: <? echo $v_margin_table; ?>" cellspacing="1" cellpadding="0">
		<tr style="height: 0px">
            <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
            <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
            <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
            <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
            <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
            <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
            <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
            <td style="width: 93px; background-color:rgba(0, 0, 0, 0);"></td>
        </tr>
		<tr>
        	<td colspan="8" style="border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">
                <table style="border: solid 0px #666666; width: 726px;background-color: #666666;" cellspacing="0" cellpadding="0">
                	<tr>
                        <td style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Demande N° :</td>
                        <td style="width: 90px;text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;font-weight:bold;" cellspacing="0" cellpadding="0">&nbsp;<? echo sprintf("%06d",$pdo_lignes_pdo_01['A0_000_idSql']); ?></td>
                        <td style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Soumise par :</td>
                        <td style="width: 90px;text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo $pdo_lignes_pdo_01['A0_003_Par_pnom'];?></td>
                        <td style="width: 90px;text-align: right;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">Le : &nbsp;</td>
                        <td style="width: 90px;text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo date("d/m/Y");?></td>
                        <td style="width: 90px;text-align: right;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">Ardt : &nbsp;</td>
                        <td style="width: 90px;text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;font-weight:bold;" cellspacing="0" cellpadding="0">&nbsp;<? echo sprintf("%02d",$pdo_lignes_pdo_01['A0_004_Ardt']); ?></td>
                    </tr>
                </table>
        	</td>
		</tr>
        <tr style="height: <? echo $v_epar_table; ?>">
        	<td colspan="8" style="border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;</td>
        </tr>
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;Demandeur :</td>
			<td colspan="7" style="width: 651px;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;font-weight:bold;" cellspacing="1" cellpadding="1">&nbsp;<? echo $pdo_lignes_pdo_01['A0_002_Pour_pnom']; ?></td>
        </tr>
        <tr style="height: <? echo $v_epar_table; ?>">
        	<td colspan="8" style="border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;</td>
        </tr>
		<tr>
			<td style="width: 93px;text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;Marché N° :</td>
			<td colspan="3" style="text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;<i><? echo $pdo_lignes_pdo_01['A0_006_CTR'];?></i></td>
			<td colspan="2" style="text-align: right;vertical-align: middle;border: solid 0px #666666;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;Adresse Mail : &nbsp;</td>
			<td colspan="2" style="text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;<? echo "xxxx@gmail.com";?></td>
		</tr>
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;Lib. Marché :</td>
            <?
			$sql = "SELECT D_010_Libelle FROM D_CTR WHERE D_000_Id_Ctr = '".$pdo_lignes_pdo_01['A0_006_CTR']."'";
				#echo $sql."<br>";
				#$_SESSION['VG_ResultSelect']['code_html_retour']=$sql;
			$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
			}
			?>
			<td colspan="7" style="width: 651px;border: solid 0px #666666;background-color: #FFFFFF;font-size: 12px;" cellspacing="1" cellpadding="1">&nbsp;<i><? echo utf8_encode($pdo_lignes_sql['D_010_Libelle']); ?></i></td>
        </tr>
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Tiers :</td>
            <td style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo $pdo_lignes_pdo_01['A0_007_Tiers'];?></td>
            <?
			$t_temp=explode("_", $pdo_lignes_pdo_01['A0_007_Tiers']);
			$sql = "SELECT E_010_Libelle FROM E_Tiers WHERE E_000_Id_Tiers = '".$t_temp[0]."'";
				#echo $sql."<br>";
				#$_SESSION['VG_ResultSelect']['code_html_retour']=$sql;
			$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
			}
			?>
			<td colspan="6" style="width: 558px;border: solid 0px #666666;background-color: #FFFFFF;font-size: 12px;" cellspacing="1" cellpadding="1">&nbsp;<i><? echo utf8_encode($pdo_lignes_sql['E_010_Libelle']); ?></i></td>
        </tr>
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Ref. Estimatif</td>
        	<td colspan="2" style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo $pdo_lignes_pdo_01['A0_008_RefDevis'];?></td>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Daté Du :</td>
            <td style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo F_Date_Mysql_Vers_FR($pdo_lignes_pdo_01['A0_009_DateDevis']);?></td>
            <td colspan="3" style="text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;">&nbsp;</td>
       	</tr>
        <tr style="height: <? echo $v_epar_table; ?>">
        	<td colspan="8" style="border: solid 0px #666666;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;</td>
        </tr>
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Date Début :</td>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo F_Date_Mysql_Vers_FR($pdo_lignes_pdo_01['A0_020_DatDeb']);?></td>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Date Fin :</td>
            <td style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo F_Date_Mysql_Vers_FR($pdo_lignes_pdo_01['A0_021_DatFin']);?></td>
        	<td style="width: 93px;text-align: right;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Durée : &nbsp;</td>
            <td colspan="3" style="text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;">&nbsp;<? echo count_days($pdo_lignes_pdo_01['A0_020_DatDeb'], $pdo_lignes_pdo_01['A0_021_DatFin']);?>&nbsp;J</td>
       	</tr>
        <!--<tr>
			<td style="width: 93px;text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;Type Bt :</td>
			<td colspan="2" style="text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;<? #echo "Elementaire";?></td>
			<td style="width: 93px;text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;Nom :</td>
			<td colspan="4" style="text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;<? #echo "Flotte";?></td>
		</tr>-->
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;Lieu :</td>
			<td colspan="7" style="border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;<? echo utf8_encode($pdo_lignes_pdo_01['A0_025_Lieu']); ?></td>
        </tr>
        <tr>
			<td style="width: 93px;text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;N° UPEP :</td>
            <?
			$sql = "
				SELECT * 
				FROM 
				A31_RefPatEngt 
				WHERE 
				A31_001_idSql_A0 = '".$v_A0_000_idSql."'";
			#echo $sql01."<br>";	
			$pdo_sql = $conDENGT->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			?>
			<td style="width: 93px;text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;
				<? 
				foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql) {
					switch($pdo_lignes_pdo_01['A31_002_TypRef']) {
						case "UPEP_B" :
							$v1_A31_002_TypRef = "Bâtiment";
							break;
						case "UPEP_T" :
							$v1_A31_002_TypRef = "Terrain";
							break;
						case "EQ" :
							$v1_A31_002_TypRef = "Equipement";
							break;
						case "RM" :
							$v1_A31_002_TypRef = "Rgt Metier";
							break;
					}
					echo $v1_A31_002_TypRef."<br>";
				}
				
				?>
            </td>
            <td style="width: 93px;text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;
				<? 
				foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql) {
					echo $pdo_lignes_pdo_01['A31_003_idRefPat']."<br>";
				}
				
				?>
            </td>
            <?
			switch($pdo_lignes_pdo_01['A0_023_TypEngt']) {
				case "Etud" :
					$v1_A0_023_TypEngt = "Etude NON suivie de travaux";
					break;
				case "EetT" :
					$v1_A0_023_TypEngt = "Etude suivis de travaux";
					break;
				case "Trav" :
					$v1_A0_023_TypEngt = "Travaux";
					break;
				case "Maint" :
					$v1_A0_023_TypEngt = "Maintenance";
					break;
				case "Inv" :
					$v1_A0_023_TypEngt = "Inventaire";
					break;
			}
			?>
			<td colspan="2" style="text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;<? echo $v1_A0_023_TypEngt;?></td>
            <?
			switch($pdo_lignes_pdo_01['A0_024_VdmProp_O_N']) {
				case "O" :
					$v1_A0_024_VdmProp_O_N = "VdM propriétaire";
					break;
				case "N" :
					$v1_A0_024_VdmProp_O_N = "VdM NON propriétaire";
					break;
			}
			?>
			<td colspan="3" style="text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;<? echo $v1_A0_024_VdmProp_O_N;?></td>
		</tr>
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;Lib. Engt :</td>
			<td colspan="7" style="width: 651px;border: solid 0px #666666;background-color: #FFFFFF;font-size: 12px;" cellspacing="1" cellpadding="1">&nbsp;<? echo utf8_encode($pdo_lignes_pdo_01['A0_022_ObjEngt']); ?></td>
        </tr>
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 12px;" cellspacing="1" cellpadding="1">&nbsp;Libellé<br>&nbsp;Complémentaire</td>
            <?
			$sql = "
				SELECT A22_002_TexteLong 
				FROM 
				A22_ObjetLong 
				WHERE 
				A22_001_idSql_A0 = '".$v_A0_000_idSql."'";
			#echo $sql01."<br>";	
			$pdo_sql = $conDENGT->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			if (count($pdo_sql) == 1) {
				foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql) {
				}
				$v1_A22_002_TexteLong = utf8_encode(nl2br($pdo_lignes_sql['A22_002_TexteLong']));
			} else {
				$v1_A22_002_TexteLong = "......<br>.....";
			}
			?>
			<td colspan="7" style="width: 651px;border: solid 0px #666666;background-color: #FFFFFF;font-size: 12px;" cellspacing="1" cellpadding="1"><i><? echo $v1_A22_002_TexteLong; ?></i></td>
        </tr>
        <tr style="height: <? echo $v_epar_table; ?>">
        	<td colspan="8" style="border: solid 0px #666666;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;</td>
        </tr>
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;IB Budget :</td>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo $pdo_lignes_pdo_01['A0_041_Budget'];?></td>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;IB Chapitre :</td>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo $pdo_lignes_pdo_01['A0_042_Ib_Chapitre'];?></td>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;IB Nature :</td>
            <td style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo $pdo_lignes_pdo_01['A0_043_Ib_Nature'];?></td>
            <td style="width: 93px;text-align: right;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;IB Fonction : &nbsp;</td>
            <td style="width: 93px;text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;">&nbsp;<? echo $pdo_lignes_pdo_01['A0_044_Ib_Fonction']." - ".$pdo_lignes_pdo_01['A0_044_B_Ib_Sdg'];?></td>
       	</tr>
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;Opération :</td>
			<td colspan="2" style="text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;<? echo $pdo_lignes_pdo_01['A0_047_NumOPE'];?></td>
            <?
			if ($pdo_lignes_pdo_01['A0_047_NumOPE'] == '0000 - 00 - 0000') {
				$v1_A0_047_NumOPE = "";
			} else {
				$sql = "SELECT F_010_Libelle FROM f_ope WHERE F_000_Id_Ope = '".$pdo_lignes_pdo_01['A0_047_NumOPE']."'";
					#echo $sql."<br>";
					#$_SESSION['VG_ResultSelect']['code_html_retour']=$sql;
				$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
				}
				$v1_A0_047_NumOPE = utf8_encode($pdo_lignes_sql['F_010_Libelle']);
			}
			?>
			<td colspan="5" style="width: 465px;border: solid 0px #666666;background-color: #FFFFFF;font-size: 12px;" cellspacing="1" cellpadding="1">&nbsp;<i><? echo $v1_A0_047_NumOPE; ?></i></td>
        </tr>
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;MIP :</td>
			<td colspan="2" style="text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;<? echo $pdo_lignes_pdo_01['A0_048_idMip'];?></td>
			<?
			if ($pdo_lignes_pdo_01['A0_048_idMip'] == '0000-00-00000') {
				$v1_A0_048_idMip = "";
			} else {
				$t1_v1_A0_048_idMip = explode("_", $pdo_lignes_pdo_01['A0_048_idMip']);
				$sql = "SELECT F5_136_Lib_Niv_3, F5_139_lib_trx FROM f5_ope_mip WHERE F5_000_id_Ope = '".$pdo_lignes_pdo_01['A0_047_NumOPE']."' AND F5_135_Id_Niv_3 LIKE '%-".$t1_v1_A0_048_idMip[2]."';";
					#echo $sql."<br>";
					#$_SESSION['VG_ResultSelect']['code_html_retour']=$sql;
				$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
				}
				$v1_A0_048_idMip = $pdo_lignes_sql['F5_136_Lib_Niv_3']." - ".$pdo_lignes_sql['F5_139_lib_trx'];
			}
			?>
			<td colspan="5" style="width: 465px;border: solid 0px #666666;background-color: #FFFFFF;font-size: 10px;" cellspacing="1" cellpadding="1">&nbsp;<i><? echo utf8_encode($v1_A0_048_idMip); ?></i></td>
        </tr>
        <?
		if ($pdo_lignes_pdo_01['A0_050_ModeFinanc'] == 'AUTO') {
		?>
        <tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 12px;" cellspacing="1" cellpadding="1">&nbsp;Justif. Depas. :</td>
        	<td colspan="7" style="width: 465px;border: solid 0px #666666;background-color: #FFFFFF;font-size: 12px;" cellspacing="1" cellpadding="1">&nbsp;<? echo utf8_encode($pdo_lignes_pdo_01['A0_051_JustifDepas']); ?></td>
        </tr>
        <?
		} //if ($pdo_lignes_pdo_01['A0_050_ModeFinanc'] == 'AUTO') {
		?>
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Reservation :</td>
			<?
			if ($pdo_lignes_pdo_01['A0_046_idResa'] == '0000_000000_000_00') {
				$v1_A0_046_idResa = "";
			} else {
				$v1_A0_046_idResa = $pdo_lignes_pdo_01['A0_046_idResa'];
			}
			?>
        	<td colspan="2" style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo ($pdo_lignes_pdo_01['A0_046_idResa']=='0000_000000_000_00') ? '':$pdo_lignes_pdo_01['A0_046_idResa'];?></td>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;CMP :</td>
        	<td colspan="2" style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo $pdo_lignes_pdo_01['A0_045_B_CMP'];?></td>
        	<td colspan="2" style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;font-size: 14px;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;</td>
       	</tr>
        <tr style="height: <? echo $v_epar_table; ?>">
        	<td colspan="8" style="border: solid 0px #666666;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;</td>
        </tr>
		<tr>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Révisable :</td>
            <?
			if ($pdo_lignes_pdo_01['A0_013_Taux_RVP'] > 0) {
				$v1_A0_013_Taux_RVP = "Oui";
			} else {
				$v1_A0_013_Taux_RVP = "Non";
			}
			?>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo $v1_A0_013_Taux_RVP;?></td>
        	<td style="width: 93px;text-align: left;vertical-align: middle;background-color: #CCCCCC;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Taux :</td>
            <?
			if ($v1_A0_013_Taux_RVP == "Oui") {
				$v2_A0_013_Taux_RVP = $pdo_lignes_pdo_01['A0_013_Taux_RVP'];
			} else {
				$v2_A0_013_Taux_RVP = "";
			}
			?>
            <td style="width: 93px;text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;<? echo $v2_A0_013_Taux_RVP;?></td>
            <td style="width: 93px;text-align: right;vertical-align: middle;background-color: #CCCCCC;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;TVA : &nbsp;</td>
            <?
			$sql = "
				SELECT E0_001_Taux_TVA 
				FROM 
				E0_Taux_TVA 
				WHERE 
				E0_000_idSql = '".$pdo_lignes_pdo_01['A0_010_TVA']."'";
			#echo $sql01."<br>";	
			$pdo_sql = $conDENGT->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql) {
			}
			?>
            <td colspan="3" style="text-align: left;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;">&nbsp;<? echo $pdo_lignes_sql['E0_001_Taux_TVA'];?>%</td>
       	</tr>
		<tr>
        	<td colspan="4" style="text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;</td>
        	<td colspan="2" style="text-align: left;vertical-align: middle;background-color: #CCCCCC;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Montant HT :</td>
            <td colspan="2" style="text-align: right;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;">&nbsp;<? echo number_format($pdo_lignes_pdo_01['A0_011_Mt_HT'],2,',',' ');?>&nbsp;</td>
       	</tr>
		<tr>
        	<td colspan="4" style="text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;</td>
        	<td colspan="2" style="text-align: left;vertical-align: middle;background-color: #CCCCCC;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Montant RVP HT :</td>
            <td colspan="2" style="text-align: right;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;">&nbsp;<? echo number_format($pdo_lignes_pdo_01['A0_012_Mt_RVP_HT'],2,',',' ');?>&nbsp;</td>
       	</tr>
		<tr>
        	<td colspan="4" style="text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;</td>
        	<td colspan="2" style="text-align: left;vertical-align: middle;background-color: #CCCCCC;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Total HT Révisé :</td>
            <td colspan="2" style="text-align: right;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;">&nbsp;<? echo number_format(($pdo_lignes_pdo_01['A0_011_Mt_HT']+$pdo_lignes_pdo_01['A0_012_Mt_RVP_HT']),2,',',' ');?>&nbsp;</td>
       	</tr>
		<tr>
        	<td colspan="4" style="text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;</td>
        	<td colspan="2" style="text-align: left;vertical-align: middle;background-color: #CCCCCC;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;TVA :</td>
            <td colspan="2" style="text-align: right;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;">&nbsp;
			<? echo number_format((($pdo_lignes_pdo_01['A0_011_Mt_HT']+$pdo_lignes_pdo_01['A0_012_Mt_RVP_HT'])*($pdo_lignes_sql['E0_001_Taux_TVA']/100)),2,',',' ');?>&nbsp;</td>
       	</tr>
		<tr>
        	<td colspan="4" style="text-align: left;vertical-align: middle;background-color: #FFFFFF;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;</td>
        	<td colspan="2" style="text-align: left;vertical-align: middle;background-color: #CCCCCC;height: 0px;" cellspacing="0" cellpadding="0">&nbsp;Total TTC Révisé :</td>
            <td colspan="2" style="text-align: right;vertical-align: middle;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;">&nbsp;
			<? echo number_format((($pdo_lignes_pdo_01['A0_011_Mt_HT']+$pdo_lignes_pdo_01['A0_012_Mt_RVP_HT'])*(($pdo_lignes_sql['E0_001_Taux_TVA']/100)+1)),2,',',' ');?>&nbsp;</td>
       	</tr>
        <?
  		if ($_GET['Sortie'] == 'pdf') {
		?>
        <tr style="height: 45px">
        	<td colspan="8" style="border: solid 0px #666666;background-color: #CCCCCC;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;</td>
        </tr>
		<tr style="height: 250px">
        	<td colspan="8" style="border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px; padding-left: 15px" cellspacing="1" cellpadding="1">
                <table style="border: solid 0px #666666; width: 726px;background-color: #FFFFFF;" cellspacing="0" cellpadding="0">
                	<tr style="height: 250px">
                        <td style="width: 240px;height: 200px;vertical-align: top;border: solid 1px #666666;font-size: 14px;text-align: center;" cellspacing="1" cellpadding="1">&nbsp;Le Demandeur</td>
                        <td style="width: 242px;height: 150px;vertical-align: top;border: solid 1px #666666;font-size: 14px;text-align: center;" cellspacing="1" cellpadding="1">&nbsp;Le Reponsable de Service</td>
                        <td style="width: 242px;height: 150px;vertical-align: top;border: solid 1px #666666;font-size: 14px;text-align: center;" cellspacing="1" cellpadding="1">&nbsp;Le Responsable Comptable</td>
                    </tr>
                </table>
        	</td>
		</tr>
        <tr style="height: 45px">
        	<td colspan="8" style="border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px;" cellspacing="1" cellpadding="1">&nbsp;</td>
        </tr>
        <tr style="height: 45px">
        	<td colspan="8" style="height: 45px;border: solid 0px #666666;background-color: #FFFFFF;font-size: 14px; vertical-align:middle;" cellspacing="1" cellpadding="1">&nbsp;N° engagement PEGASE : </td>
        </tr>
        <?
		} //if ($_GET['Sortie'] == 'pdf') {
		?>
	</table>
    
        <?
  		if ($_GET['Sortie'] != 'pdf') {
			if ($_GET['Supp'] == 'O') {
		?>
        	<br />
        	<form action="DENGT_02_Supp_Dem_v0.1.php" method="post" name="Supp_DENGT" id="Supp_DENGT"  enctype="application/x-www-form-urlencoded">
				<input name="Val_A0_000_idSql" id="Val_A0_000_idSql" type="hidden" value="<? echo $pdo_lignes_pdo_01['A0_000_idSql'];?>" />
        		<table style=" font-family:Arial, Helvetica, sans-serif; border: solid 0px #666666; width: 750px;background-color: #FFFFFF; margin-left: <? echo $v_margin_table; ?>" cellspacing="1" cellpadding="0">
    				<td>
                    	<tr>
                        	<div id="click_Bt_Supp">
                                <img src="images/Boutons/BT_DENG_Supp_dem_160_32.png" width="160" height="32" alt="Supprimer" style="border:0px; outline: none;vertical-align:middle;" class="rollove" />&nbsp;&nbsp;
                            </div>
                        </tr>
                    </td>
    			</table>
            </form>
            <!-- container pour growl sans case fermeture-->
				<div id="containerGrowlErr0_Auto" style="display:none; z-index:1000; margin-left: 50px; margin-top: 160px;">
					<div id="withIcon">
						<div style="float:left;margin:0 10px 0 0"><img src="#{icon}" alt="warning" /></div>
						<h1>#{title}</h1>
						<p>#{text}</p>
					</div>
				</div>
				<!-- fin container pour growl sans case fermeture -->
        <?
			} //if ($_GET['Supp'] == 'O') {
		} //if ($_GET['Sortie'] != 'pdf') {
		?>
    
        <?
  		if ($_GET['Sortie'] == 'pdf') {
		?>
</page>
        <?
		} //if ($_GET['Sortie'] == 'pdf') {
		?>

	

<?
  if ($_GET['Sortie'] == 'pdf') {
	  
	  $content = ob_get_clean();
  
	  // convert in PDF
	  require_once('../_html2pdf/html2pdf.class.php');
	  try
	  {
		  $v_nom_fichier_pdf = "DemEngt_".sprintf("%06d",$pdo_lignes_pdo_01['A0_000_idSql'])."_Ardt_".sprintf("%02d",$pdo_lignes_pdo_01['A0_004_Ardt'])."_".$v1_A0_040_TypDep.".pdf";
		  header('Set-Cookie: fileDownload=true; path=/');
		  header('Cache-Control: max-age=60, must-revalidate');
		  $html2pdf = new HTML2PDF('p', 'A4', 'fr');
		  $html2pdf->setDefaultFont('Arial');
		  $html2pdf->writeHTML($content);
		  $html2pdf->Output($v_nom_fichier_pdf, 'D');
	  }
	  catch(HTML2PDF_exception $e) {
		  echo $e;
		  exit;
	  }
  } else { //if ($_GET['Sortie'] == 'pdf') {
?>
	</body>
<?
  } //  //if ($_GET['Sortie'] == 'pdf') {
	  
	  
	  
	  
	  
} else {// if(count($pdo_01) == 1) {
	echo "PB ";
} // if(count($pdo_01) == 1) {
?>


<!-- ######################################################################################## -->
<!-- ######################  JAVA SCRIPT  ################################################### -->
<!-- ######################################################################################## -->
<script type="text/javascript"><!--

//--------------------------------------------------------------------
//--------------------- fonction create pour growl -------------------
function create( template, vars, opts ){
	return $container.notify("create", template, vars, opts);
}

//////////////////////////////////////////////////
//--------------------- jquery -------------------
//////////////////////////////////////////////////
$(document).ready(function(){
	
	//-------------------- containerGrowlErr0 --------------------
		$containerGrowlErr0_Auto = $("#containerGrowlErr0_Auto").notify();
		$containerGrowlErr0_Manu = $("#containerGrowlErr0_Manu").notify();
		
	$("#click_Bt_Supp").on('click', function() {
		
		//$("#Supp_DENGT").submit();
		
		////////////////////
		//
		//		a lever quand enreg mysql de la dem et liste des dem effectuée
		//
		///////////////////
		var copi_data = $('#Supp_DENGT').serialize();
		//console.log(copi_data);
		var id_dem_retour = "vide";
		$.ajax({
		   url: 'DENGT_02_Supp_Dem_v0.1.php',                           // Any URL
		   data: copi_data,                 // Serialize the form data
		   success: function (data) {                        // If 200 OK
			  //alert('Success response: ' + data);
			  $("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:(data), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
		   }
		});	
	});
	
	$('.rollove').hover(function () 
		{
		  $(this).css("cursor", "pointer");
		  var vdown = this.src.indexOf("_down.png");
		  if (vdown == -1) {
			  this.src = this.src.replace(".png","_down.png");
		  }
		}, 
		function () {
					var vdown = this.src.indexOf("_down.png");
		  			if (vdown > 0) {
						this.src = this.src = this.src.replace("_down.png",".png");
					}
					}
		);
	
	
			 
});

//--></script>
