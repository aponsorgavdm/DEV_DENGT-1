<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');
include('../_Fonctions/F_report_err_par_mail.php');

require_once('../_Sessions/Verif_Ses.php');


//////////////////////////////////////////////////
//
//       connexion Mysql
//
/////////////////////////////////////////////////
require_once('Connections/PDO_Prod_Util_AO_BPU.php');
// connProd=Pegase_Data_BO_Prod , connUtil=utilisateurdgabc, connAO=Analyse_AO, conBPU=BPU_Apel

$t_srv_dgave = array("50001"=>"DGAVE", "50201" => "DRP", "50402"=>"DEGPC", "50502"=>"Dtb Sud", "50602"=>"Dtb Nord", "50703"=>"Stb Est", "50803"=>"Stb NEst", "51102"=>"DEXT");
$t_lib_budget = array("00"=>"Général", "01" => "Palais Pharo", "02"=>"Vélodrome", "03"=>"--", "04"=>"Pompes Funebre", "05"=>"POMGE", "06"=>"Pole Media Belle de Mai");

$v_title="Site intranet de la DGAAVE";
if ($_SERVER['HTTP_HOST'] == 'dgave-lamp.dev.mars') {
	$v_title=$_SERVER['HTTP_HOST'];
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title><? echo $v_title; ?></title>	
<meta http-equiv="Content-Language" content="fr" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link type="text/css" rel="stylesheet" media="screen" href="style.css" />


<script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/js/jquery-3.3.1.min.js"></script>

<link href="<? echo $chemin_to_racine ?>_Jquery/css/smoothness/jquery-ui.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/js/jquery-ui.min.js"></script>

<script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/js/jquery.fancybox.min.js"></script>
<link rel="stylesheet" type="text/css" href="<? echo $chemin_to_racine ?>_Jquery/css/jquery.fancybox.min.css" media="screen" />


</head>
<body>
<?
if((isset($_GET["v_Ex_Ctr"])) and ($_GET["v_Ex_Ctr"] != '') and (isset($_GET["v_Num_Ctr"])) and ($_GET["v_Num_Ctr"] != '')) { // 
	$sql = "
		SELECT D_000_Id_Ctr, D_010_Libelle 
		FROM 
		D_CTR 
		WHERE 
		D_000_Id_Ctr like '".$_GET['v_Ex_Ctr']."_".$_GET['v_Num_Ctr']."%' 
		order by D_000_Id_Ctr DESC
		";
	$pdo_result = $connProd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	$pdo_total_result = count($pdo_result);
	if ($pdo_total_result == 0) {
		?>
<div style="text-align:center">
			<br><br>Aucune Marché ne contiend ces N° : "<? echo $_GET["v_Ex_Ctr"]."_".$_GET["v_Num_Ctr"]; ?>"<br><br>
			<img src="images/Annul_128_128.png" width="128" height="128" /></div>
		<?
	} else { ?>
			<table width="550" border="0" align="center" cellpadding="0" cellspacing="2" style="font-size: 12px;color: #666666;">
			<tr>
				<th colspan="4" style="text-align: center">Cliquez sur le N° de marché désiré</th>
			</tr>
			<tr>
				<th colspan="4" style="text-align: center">&nbsp;</th>
			</tr>
			<tr>
				<td colspan="3" style="text-align: center">N° Marché</td>
				<td>&nbsp;Libellé Marché</td>
			</tr>
			<tr>
				<td height="1mm" colspan="4" bgcolor="#999999"></td>
			</tr>
			<?
		foreach ($pdo_result as $key => $pdo_lignes) { 
		?>
				<tr>
					<th colspan="2" style="text-align: center">
                    	<span style="display: inline-block; overflow: hidden;">
                    		<a class="link_up" href="#" onclick="OpeSelect(this)" value="<? echo $pdo_lignes['D_000_Id_Ctr']; ?>">
                    			<span style="font-size: 12px;display: inline-block; overflow: hidden;"><? echo $pdo_lignes['D_000_Id_Ctr']; ?></span>
                            </a>
                        </span>
                    </th>
					<td width="20" valign="middle">
                    <div id="<? echo $pdo_lignes['D_000_Id_Ctr']; ?>" style="display:none;"><span class="ui-icon ui-icon-check" style="display:inline-block;opacity:0.5;vertical-align:top;">&nbsp;</span></div>
                    </td>
					<td width="360" style="text-align: left"><? echo $pdo_lignes['D_010_Libelle']; ?></td>
				</tr>
				<tr>
					<td height="1mm" colspan="4" bgcolor="#999999"></td>
				</tr>	
		<?
		} // foreach ($pdo_result as $key => $pdo_lignes) {
		?>
			</table>
		<?
	}
	
}
?>
</body>
</html>


<!-- ######################################################################################## -->
<!-- ######################  JAVA SCRIPT  ################################################### -->
<!-- ######################################################################################## -->
<script type="text/javascript"><!--

function getParamValue(param,url){
		var u = url == undefined ? document.location.href : url;
		var reg = new RegExp('(\\?|&|^)'+param+'=(.*?)(&|$)');
		matches = u.match(reg);
		if (matches != null) {
			return matches[2] != undefined ? decodeURIComponent(matches[2]).replace(/\+/g,' ') : '';
		} else {
			return "noparam";
		}
	}




function OpeSelect(a){
	var avalue = a.getAttribute('value');
	alert(avalue);
	//var tabvalue = avalue.split("@"); 
	//var myLink = tabvalue[0];
	//alert(getParamValue('v_crea'));
	//if (getParamValue('v_crea') == 'oui') {
		//window.parent.document.getElementById('FormCritRechRCMOPELib').value =tabvalue[1];
	//}
	window.parent.document.getElementById('input_IdCtr').value = avalue;
	parent.$.fancybox.close();
}

//////////////////////////////////////////////////
//--------------------- jquery -------------------
//////////////////////////////////////////////////


$(document).ready(function(){
	$('.link_up').hover(
		function() {
			var txt = $(this).text();
			txt = txt.trim();
			console.log('*'+txt+'*');
			document.getElementById(txt).style.display = "inline";
		}, 
		function() {
			console.log('out');
			var txt = $(this).text();
			txt = txt.trim();
			document.getElementById(txt).style.display = "none";
		}
	);
	
}
);
//--></script>

<!-- ######################################################################################## -->
<!-- ######################  FIN JAVA SCRIPT  ############################################### -->
<!-- ######################################################################################## -->