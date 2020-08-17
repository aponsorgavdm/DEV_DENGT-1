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

function F_DivComptaOpe($t1,$t2,$t3,$t4) { // t1 = t_detail_ib, t2 = t_ib , t3=t_detail_Resa, t4 = $t_resa 
	$v_retourHtml = "";
	$v_retourHtml =	'<div id="DivComptaOP" style="font-size: 14px;color: #666666;display:none;">';
            $v_retourHtml .='<table width="1000" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF" style="font-size: 14px;color: #666666;">';
                $v_retourHtml .='<tr height="0">';
                    $v_retourHtml .='<td bgcolor="#FFFFFF" align="center">';
                    	$v_retourHtml .='<fieldset style="border:0; font-size: 12px;">';
                          $v_retourHtml .='<select name="SelectIbOpi" id="SelectIbOpi">';
                              $v_retourHtml .='<option value="?">Choisir une Ib</option>';
                              foreach ($t1 as $key_t_detail_ib  => $lignes_t_detail_ib ) {
								   $v_retourHtml .='<option value"'.$t2[$key_t_detail_ib].'">'.utf8_encode($lignes_t_detail_ib).'</option>';
							  }
                          $v_retourHtml .='</select>';
                      $v_retourHtml .='</fieldset>';
                    $v_retourHtml .='</td>';
                $v_retourHtml .='</tr>';
            $v_retourHtml .='</table>';
            $v_retourHtml .='<table width="1000" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF" style="font-size: 14px;color: #666666;">';
                $v_retourHtml .='<tr height="0">';
                    $v_retourHtml .='<td bgcolor="#FFFFFF" align="center">';
                    	$v_retourHtml .='<fieldset style="border:0; font-size: 12px;">';
                          $v_retourHtml .='<select name="SelectResaOpi" id="SelectResaOpi">';
                              $v_retourHtml .='<option value="?">Choisir une reservation</option>';
                              foreach ($t3 as $key_t_detail_Resa  => $lignes_t_detail_Resa ) {
								   $v_retourHtml .='<option value"'.$t4[$key_t_detail_Resa].'">'.utf8_encode($lignes_t_detail_Resa).'</option>';
							  }
                          $v_retourHtml .='</select>';
                      $v_retourHtml .='</fieldset>';
                    $v_retourHtml .='</td>';
                $v_retourHtml .='</tr>';
            $v_retourHtml .='</table>';
            $v_retourHtml .='<table width="1000" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF" style="font-size: 14px;color: #666666;">';
                $v_retourHtml .='<tr height="0">';
                    $v_retourHtml .='<td style="width: 142px; background-color:#FFFFFF;">';
                    	$v_retourHtml .='&nbsp;<strong>CMP</strong>';
                    $v_retourHtml .='</td>';
                    $v_retourHtml .='<td style="width: 142px;height: 32px; background-color:#E7E7E7; text-align: left; vertical-align: middle; border-radius: 8px;-moz-border-radius: 8px;">';
                    	$v_retourHtml .='&nbsp;<input name="input_CMP_I" id="input_CMP_I" type="text" size="15" style="border: 0; font-size: 12px;color: #666666;background-color:transparent; text-align:right" value="" />';
                    $v_retourHtml .='</td>';
					$v_retourHtml .='<td>&nbsp;</td>';
                $v_retourHtml .='</tr>';
            $v_retourHtml .='</table>';
        $v_retourHtml .='</div>';
		return $v_retourHtml;
}

$t_srv_dgave = array("50001"=>"DGAVE", "50102" => "DRP", "50402"=>"DEGPC", "50502"=>"Dtb Sud", "50602"=>"Dtb Nord", "50703"=>"Stb Est", "50803"=>"Stb NEst", "51102"=>"DEXT");
$v_srv_dgave_in = "'50001', '50102', '50402', '50502', '50602', '50703', '50803', '51102'";
$t_lib_budget = array("00"=>"Général", "01" => "Palais Pharo", "02"=>"Vélodrome", "03"=>"Opera/Odeon", "04"=>"Pompes Funebre", "05"=>"POMGE", "06"=>"Pole Media Belle de Mai");

if ($_SESSION['VG_Id_Domaine'] == 'C') {
	$v_DirCompta = "%";
	if ($_SESSION['VG_Pnom'] == 'apons') { // ************************************************* A LEVER pour test ***********************************
		$v_DirCompta = "50602";
	}
	if ($_SESSION['VG_ResultSelect'][$v_page] != 0) {
		$v_DirCompta = $_SESSION['VG_Crit_03'];
	}
} else {// if ($_SESSION['VG_Id_Domaine'] == 'C') { 
	$v_DirCompta = $_SESSION['VG_Dir']."02";
}// if ($_SESSION['VG_Id_Domaine'] == 'C') {
	
	
	


/////////////////////////////////////////////////
//
//       apel ajax sur image ValidOPI pour mise à jour <div id="LibOpi">&nbsp;<i>lib opi<i></div>
//
/////////////////////////////////////////////////

if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "ValidOPI") and ($_POST['v_F_000_Id_Ope'] != "")) {
	$sql = "
		SELECT 
		*
		FROM 
		F_OPE 
		WHERE 
		F_000_Id_Ope = '".$_POST['v_F_000_Id_Ope']."' 
		and 
		F_012_Statut = 'AFF' 
		";
	$sql = "
		SELECT 
		*
		FROM 
		F_OPE 
		WHERE 
		F_000_Id_Ope = '".$_POST['v_F_000_Id_Ope']."'
		";
		#echo $sql."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour']=$sql;
	$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	$pdo_total_sql = count($pdo_sql);
		//////////////////////////////////////
		//
		//		le resultat de la recherche de l'OPI donne 1 seul resultat 
		//
		/////////////////////////////////////
	if ($pdo_total_sql == 1) { // le resultat de la recherche de l'OPI donne 1 seul resultat 
		foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
		}
		if($pdo_lignes_sql['F_012_Statut'] == "AFF") {
			$sqlOPI_ib = "
				select 
				FH_026_Ib_Chapitre, FH_027_Ib_Nature, FH_028_Ib_Fonction, FH_029_Ib_Srv 
				from FH_Ope_IB 
				where FH_000_Id_Ope = '".$_POST['v_F_000_Id_Ope']."'" ;
				
			#echo $sql."<br>";
			$_SESSION['VG_ResultSelect']['code_html_retour']="111 ".$sqlOPI_ib;
			$pdo_sqlOPI_ib = $conn->query($sqlOPI_ib)->fetchAll(PDO::FETCH_ASSOC);
			$pdo_total_sqlOPI_ib = count($pdo_sqlOPI_ib);
			$t_detail_ib=array();
			$t_ib=array();
			foreach ($pdo_sqlOPI_ib  as $key_sqlOPI_ib  => $pdo_lignes_sqlOPI_ib ) {
				$v_ib = $pdo_lignes_sqlOPI_ib['FH_026_Ib_Chapitre']."_".$pdo_lignes_sqlOPI_ib['FH_027_Ib_Nature']."_".$pdo_lignes_sqlOPI_ib['FH_028_Ib_Fonction']."_".$pdo_lignes_sqlOPI_ib['FH_029_Ib_Srv'];
				$t_ib[]=$v_ib;
				$v_lib_ib=$v_ib." - ";
				$sqlOPI_libib = "
					SELECT 
					H_027_Ib_Nature,H2_104_Libelle  
					FROM 
					H_IB, H2_IB_Libelle 
					WHERE 
					H_000_Id_Ib LIKE '".$v_ib."%' 
					and 
					H2_000_Id_Ib_Lib = concat('N_','".$pdo_lignes_sql['F_006_Budget']."','_', H_IB.H_027_Ib_Nature) 
					group by H_027_Ib_Nature;";
				#echo "sqlOPI_libib :".$sqlOPI_libib."<br>";
				$_SESSION['VG_ResultSelect']['code_html_retour']=$sqlOPI_libib;
				$pdo_sqlOPI_libib = $conn->query($sqlOPI_libib)->fetchAll(PDO::FETCH_ASSOC);
				$pdo_total_sqlOPI_libib = count($sqlOPI_libib);
				if($pdo_total_sqlOPI_libib ==1) {
					foreach ($pdo_sqlOPI_libib  as $key_sqlOPI_libib  => $pdo_lignes_sqlOPI_libib) {
					}
					$v_lib_ib .= $pdo_lignes_sqlOPI_libib['H2_104_Libelle'];
					$sqlOPI_libib2 = "
						SELECT 
						H_028_Ib_Fonction,H2_104_Libelle  
						FROM 
						H_IB, H2_IB_Libelle 
						WHERE 
						H_000_Id_Ib LIKE '".$v_ib."%' 
						and 
						H2_000_Id_Ib_Lib = concat('F_','".$pdo_lignes_sql['F_006_Budget']."','_',H_028_Ib_Fonction) 
						AND
						H_027_Ib_Nature LIKE '".$pdo_lignes_sqlOPI_libib['H_027_Ib_Nature']."' 
						order by H_028_Ib_Fonction;";
					$_SESSION['VG_ResultSelect']['code_html_retour']=$sqlOPI_libib2;
					$pdo_sqlOPI_libib2 = $conn->query($sqlOPI_libib2)->fetchAll(PDO::FETCH_ASSOC);
					$pdo_total_sqlOPI_libib2 = count($sqlOPI_libib2);
					if($pdo_total_sqlOPI_libib2 ==1) {
						foreach ($pdo_sqlOPI_libib2  as $key_sqlOPI_libib2  => $pdo_lignes_sqlOPI_libib2) {
						}
						$v_lib_ib .= " / ".$pdo_lignes_sqlOPI_libib2['H2_104_Libelle'];
					} // if($pdo_total_sqlOPI_libib ==1) {
				} // if($pdo_total_sqlOPI_libib ==1) {
				$t_detail_ib[]=$v_lib_ib;
			} //foreach ($pdo_sqlOPI_ib  as $key_sqlOPI_ib  => $pdo_lignes_sqlOPI_ib ) {
			$t_F_000_Id_Ope = explode(" - ", $_POST['v_F_000_Id_Ope']);
			$sqlOPI_resa = "
				select 
				A_000_id_Resa, A_010_Libelle 
				from A_Resa 
				where 
				A_013_Ex_Ope = '".$t_F_000_Id_Ope[0]."'
				and 
				A_014_Code_Ope = '".$t_F_000_Id_Ope[1]."' 
				and 
				A_015_Num_Ope = '".$t_F_000_Id_Ope[2]."' 
				and
				A_012_Statut = 'N' 
				" ;
				
			#echo $sql."<br>";
			$_SESSION['VG_ResultSelect']['code_html_retour']="111 ".$sqlOPI_resa;
			$pdo_sqlOPI_resa = $conn->query($sqlOPI_resa)->fetchAll(PDO::FETCH_ASSOC);
			$pdo_total_sqlOPI_resa = count($pdo_sqlOPI_resa);
			$t_detail_Resa=array();
			$t_resa=array();
			foreach ($pdo_sqlOPI_resa  as $key_sqlOPI_resa  => $pdo_lignes_sqlOPI_resa ) {	
				$t_detail_Resa[]= $pdo_lignes_sqlOPI_resa['A_000_id_Resa']." - ".$pdo_lignes_sqlOPI_resa['A_010_Libelle'];
				$t_resa[]=$pdo_lignes_sqlOPI_resa['A_000_id_Resa'];
			}
			?>
			<div id="LibOpi">&nbsp;<? echo utf8_encode($pdo_lignes_sql['F_010_Libelle']); ?></div>
			$$_$$_$$OpiTrouv$$_$$_$$
			<div id="DivConsoOPI" style="font-size: 14px;color: #666666;display:none;"> 
				<table width="1000" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC" style="font-size: 14px;color: #666666;">
					<tr height="0">
						<th width="250" bgcolor="#FFFFFF" align="center">Mt BP <? echo date('Y'); ?></th>
						<th width="250" bgcolor="#FFFFFF" align="center">Mt CP <? echo date('Y'); ?></th>
						<th width="250" bgcolor="#FFFFFF" align="center">Mt Engagé <? echo date('Y'); ?></th>
						<th width="250" bgcolor="#FFFFFF" align="center">Mt Mandaté <? echo date('Y'); ?></th>
					</tr>
					<tr> 
						<td width="250" bgcolor="#FFFFFF" align="right"><? echo number_format($pdo_lignes_sql['F_089_Mt_BP_Annee'], 2, ',', ' '); ?>&nbsp;</td>
						<td width="250" bgcolor="#FFFFFF" align="right"><? echo number_format($pdo_lignes_sql['F_090_Mt_CP_Annee'], 2, ',', ' '); ?>&nbsp;</td>
						<td width="250" bgcolor="#FFFFFF" align="right"><? echo number_format($pdo_lignes_sql['F_084_Mt_Engt_Acce'], 2, ',', ' '); ?>&nbsp;</td>
						<td width="250" bgcolor="#FFFFFF" align="right"><? echo number_format($pdo_lignes_sql['F_087_Mt_Mand_Acce'], 2, ',', ' '); ?>&nbsp;</td>
					</tr>
				</table>    
			</div>
			$$_$$_$$
			<? echo F_DivComptaOpe($t_detail_ib,$t_ib,$t_detail_Resa,$t_resa ) ; ?>
			<!--<div id="DivComptaOP" style="font-size: 14px;color: #666666;display:none;">
				<table width="1000" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF" style="font-size: 14px;color: #666666;">
					<tr height="0">
						<td bgcolor="#FFFFFF" align="center">
							<fieldset style="border:0; font-size: 12px;">
							  <select name="SelectIbOpi" id="SelectIbOpi">
								  <option value="?">Choisir une Ib</option>
								  <?
								  #foreach ($t_detail_ib  as $key_t_detail_ib  => $lignes_t_detail_ib ) {
									  #echo '<option value"'.$t_ib[$key_t_detail_ib].'">'.utf8_encode($lignes_t_detail_ib).'</option>';
								  #}
								  ?>
							  </select>
						  </fieldset>
						</td>
					</tr>
				</table>
				 <table width="1000" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF" style="font-size: 14px;color: #666666;">
					<tr height="0">
						<td bgcolor="#FFFFFF" align="center">
							<fieldset style="border:0; font-size: 12px;">
							  <select name="SelectResaOpi" id="SelectResaOpi">
								  <option value="?">Choisir une reservation</option>
								  <?
								  #foreach ($t_detail_Resa  as $key_t_detail_Resa  => $lignes_t_detail_Resa ) {
									  #echo '<option value"'.$t_resa[$key_t_detail_Resa].'">'.utf8_encode($lignes_t_detail_Resa).'</option>';
								  #}
								  ?>
							  </select>
						  </fieldset>
						</td>
					</tr>
				</table>
			</div>-->
        <?
		} else {  // if($pdo_lignes_sql['F_012_Statut'] == "AFF") {
		?>
			<div id="LibOpi">&nbsp;<strong><span style=";color: #CC0000;">OPI en statut '<? echo $pdo_lignes_sql['F_012_Statut']; ?>'</span></strong></div>
            $$_$$_$$
            Erreur
			<?
		} // // if($pdo_lignes_sql['F_012_Statut'] == "AFF") {
	} else { //if ($pdo_total_sql2 == 1) { // le resultat de la recherche de l'OPI donne 1 seul resultat
		if ($pdo_total_sql == 0) {
			?>
			<div id="LibOpi">&nbsp;<strong><span style=";color: #CC0000;">Aucune OPI avec ce N°</span></strong></div>
            $$_$$_$$
            Erreur
			<?
		} else { //if ($pdo_total_sql == 0) {
			?>
			<div id="LibOpi">&nbsp;<strong><span style=";color: #CC0000;">plusieurs OPI avec ce N°</span></strong></div>
            $$_$$_$$
            Erreur
			<?
			
		} // if ($pdo_total_sql == 0) {
	} //if ($pdo_total_sql2 == 1) { // le resultat de la recherche de l'OPI donne 1 seul resultat
} //if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "ValidOPI") and ($_POST['v_F_000_Id_Ope'] != "")) {

/////////////////////////////////////////////////
//
//       apel ajax sur image ValidMarche pour mise à jour <td> AfficheLibCTR et input_IdCtr, <td> AfficheLibCTR et/ou SelectNumTiers, <td> AfficheConso, <tr> AfficheDateCtr
//
/////////////////////////////////////////////////

if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "ValidMarche") and ($_POST['v_D_000'] != "")) {
	$sql = "
		SELECT 
		D_000_Id_Ctr, D_002_Srv, D_010_Libelle, D_069_Date_Deb, D_065_Duree_Mois, D_062_Mt_Dispo, D_083_Mt_Engt_Prop, D_084_Mt_Engt_Acce 
		FROM 
		D_CTR 
		WHERE 
		D_000_Id_Ctr LIKE '".$_POST['v_D_000']."%' 
		AND 
		D_012_Statut LIKE 'N'
		";
		#echo $sql."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour']=$sql;
	$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	$pdo_total_sql = count($pdo_sql);
		//////////////////////////////////////
		//
		//		le resultat de la recherche du marche donne 1 seul resultat 
		//
		/////////////////////////////////////
	if ($pdo_total_sql == 1) { // le resultat de la recherche du marche donne 1 seul resultat 
		foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
		}
		?>
		<? ////////////// code_html_retour_part_0 : 1ctr ?>
            <? ////////////// affichage AfficheLibCTR /////////// ?>
        <td colspan="7" align="left" bgcolor="#FFFFFF" height="22" style="font-size: 12px;color: #CC6633;" id="AfficheLibCTR">
        	&nbsp;<i><? echo $pdo_lignes_sql['D_000_Id_Ctr'].'-"'.utf8_encode($pdo_lignes_sql['D_010_Libelle']).'"'; ?></i>
        	<input name="input_IdCtr" id="input_IdCtr" type="hidden" value="<? echo $pdo_lignes_sql['D_000_Id_Ctr']; ?>" />
        </td>
            <? ////////////// affichage AfficheLibTiers /////////// ?>
    	<?
		$sql2 = "
			SELECT 
			DE_016_Tiers, DE_074_Typ_Tiers, DE_062_Mt_Dispo, DE_083_Mt_Engt_Prop, DE_084_Mt_Engt_Acce, E_010_Libelle 
			FROM 
			DE_Ctr_Tiers, E_Tiers 
			WHERE 
			DE_000_id_Ctr_Tiers Like '".$pdo_lignes_sql['D_000_Id_Ctr']."%' 
			and 
			E_000_Id_Tiers = DE_016_Tiers
			";
			#echo $sql."<br>";
			$_SESSION['VG_ResultSelect']['code_html_retour_part_0 : 1ctr']=$sql2;
		$pdo_sql2 = $conn->query($sql2)->fetchAll(PDO::FETCH_ASSOC);
		$pdo_total_sql2 = count($pdo_sql2);
		//////////////////////////////////////
		//
		//		le resultat de la recherche du marche donne 1 seul resultat et le resultat de la recherche du tiers donne 1 seul resultat 
		//
		/////////////////////////////////////
		if ($pdo_total_sql2 == 1) { // le resultat de la recherche du tiers donne 1 seul resultat ?>
            <? ////////////// affichage AfficheLibTiers /////////// ?>
<? ////////////// code_html_retour_part_1 : 1ctr1tier ?>
        	$$_$$_$$
            v_input
<? ////////////// code_html_retour_part_2 : 1ctr1tier ?>
        	$$_$$_$$
            <?
			foreach ($pdo_sql2  as $key_sql2  => $pdo_lignes_sql2 ) {
			}
			?>
			<td colspan="7" align="left" bgcolor="#FFFFFF" height="22" style="font-size: 12px;color: #CC6633;" id="AfficheLibTiers">
				&nbsp;Tiers :&nbsp;<i><? echo $pdo_lignes_sql2['DE_016_Tiers'].'_'.$pdo_lignes_sql2['DE_074_Typ_Tiers'].'-"'.utf8_encode($pdo_lignes_sql2['E_010_Libelle']).'"'; ?></i>
				<input name="SelectNumTiers" id="SelectNumTiers" type="hidden" value="<? echo $pdo_lignes_sql2['DE_016_Tiers']; ?>" />
			</td>
            <? ////////////// affichage AfficheConso /////////// ?>
<? ////////////// code_html_retour_part_3 : 1ctr1tier ?>
        $$_$$_$$
        	<td height="32" bgcolor="#FFFFFF" align="right" style="font-size: 10px;color: #CC6633;" id="AfficheConso">&nbsp;<i>
            Engagé:<br />Proposé:<br />Disponible:
            <i>
            </td>
            <? ////////////// affichage AfficheConso2 /////////// ?>
<? ////////////// code_html_retour_part_4 : 1ctr1tier ?>
        $$_$$_$$
        	<td height="32" bgcolor="#FFFFFF" align="right" style="font-size: 10px;color: #CC6633;" id="AfficheConso2">&nbsp;<i>
            <!--<? #echo number_format($pdo_lignes_sql['D_084_Mt_Engt_Acce'], 2, ',', ' ') ;?>&nbsp;<br />
			<? #echo number_format($pdo_lignes_sql['D_083_Mt_Engt_Prop'], 2, ',', ' ') ;?>&nbsp;<br />
			<? #echo number_format($pdo_lignes_sql['D_062_Mt_Dispo'], 2, ',', ' ') ;?>&nbsp;-->
            
            <? echo number_format($pdo_lignes_sql2['DE_084_Mt_Engt_Acce'], 2, ',', ' ') ;?>&nbsp;<br />
			<? echo number_format($pdo_lignes_sql2['DE_083_Mt_Engt_Prop'], 2, ',', ' ') ;?>&nbsp;<br />
			<? echo number_format($pdo_lignes_sql2['DE_062_Mt_Dispo'], 2, ',', ' ') ;?>&nbsp;
            <input name="MtDispoCtr" id="MtDispoCtr" type="hidden" value="<? echo $pdo_lignes_sql2['DE_062_Mt_Dispo']; ?>" />
            <i>
            </td>
            <? ////////////// affichage AfficheDateCtr /////////// ?>
<? ////////////// code_html_retour_part_5 : 1ctr1tier ?>
        $$_$$_$$
            <tr id="AfficheDateCtr">
                <td colspan="2" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #CC6633;">&nbsp;<i>Date debut du Marché : <? echo F_Date_Mysql_Vers_FR($pdo_lignes_sql['D_069_Date_Deb']);?><i><input name="val_dateDebCtr" id="val_dateDebCtr" type="hidden" size="10" style="border: 1; font-size: 14px;color: #666666;background-color:transparent;" value="<? echo $pdo_lignes_sql['D_069_Date_Deb'];?>" /></td>
                <?
				if ($pdo_lignes_sql['D_065_Duree_Mois'] > 0) {
					$v_dateFinCalcule = DateAddJMA($pdo_lignes_sql['D_065_Duree_Mois'],"M",$pdo_lignes_sql['D_069_Date_Deb']);
					$v_dateFinCalcule = DateAddJMA("-1","J",$v_dateFinCalcule);
				?>
                	<td colspan="4" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #CC6633;">&nbsp;<i>Date Fin du Marché : <? echo F_Date_Mysql_Vers_FR($v_dateFinCalcule);?><i><input name="val_dateFinCtr" id="val_dateFinCtr" type="hidden" size="10" style="border: 1; font-size: 14px;color: #666666;background-color:transparent;" value="<? echo $v_dateFinCalcule ;?>" /></td>
                    <td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;">&nbsp;</td>
				<?
				} else { // if ($pdo_lignes_sql['D_065_Duree_Mois'] > 0) {
				?>
                	<td colspan="4" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #CC6633;">&nbsp;<i>Date Fin du Marché : ...... <i><input name="val_dateFinCtr" id="val_dateFinCtr" type="hidden" size="10" style="border: 1; font-size: 14px;color: #666666;background-color:transparent;" value="" /></td>
                	<td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;">&nbsp;<strong><i>alerte calcul dates Impossible<i></strong></td>
				<?
				} // if ($pdo_lignes_sql['D_065_Duree_Mois'] > 0) {
				?>
            </tr>
            <? ////////////// affichage avancement DENGT_Avanc_1/////////// ?>
<? ////////////// code_html_retour_part_6 : 1ctr1tier ?>
        $$_$$_$$
        	<img id="DENGT_Avanc_1" src="images/Etapes/Etape_DENGT_1_Vert.png" width="74" height="117" />
			<?
		} else { //if ($pdo_total_sql2 == 1) { // le resultat de la recherche du tiers donne 1 seul resultat
		//////////////////////////////////////
		//
		//		le resultat de la recherche du marche donne 1 seul resultat et le resultat de la recherche du tiers donne aucun resultat ************* en principe impossible
		//
		///////////////////////////////////// ?>
            <?
			if ($pdo_total_sql2 == 0) {
			?>
<? ////////////// code_html_retour_part_0 : 1ctr0tier ?>
<? ////////////// code_html_retour_part_1 : 1ctr0tier ?>
        	$$_$$_$$
            v_input
<? ////////////// code_html_retour_part_2 : 1ctr0tier ?>
        	$$_$$_$$
			<td colspan="7" align="left" bgcolor="#FFFFFF" height="22" style="font-size: 12px;color: #CC0000;" id="AfficheLibTiers">
				&nbsp;<i>Aucun Tiers trouvé sur ce Marché. Veuillez contacter votre responsable comptable</i>
				<input name="SelectNumTiers" id="SelectNumTiers" type="hidden" value="?" />
			</td>
            <? ////////////// affichage AfficheConso /////////// ?>
<? ////////////// code_html_retour_part_3 : 1ctr0tier ?>
        $$_$$_$$
        	<td height="32" bgcolor="#FFFFFF" align="right" style="font-size: 10px;color: #CC6633;" id="AfficheConso">&nbsp;<i>
            <br /><br />
            <i>
            </td>
            <? ////////////// affichage AfficheConso2 /////////// ?>
<? ////////////// code_html_retour_part_4 : 1ctr0tier ?>
        $$_$$_$$
        	<td height="32" bgcolor="#FFFFFF" align="right" style="font-size: 10px;color: #CC6633;" id="AfficheConso2">&nbsp;<i>
            &nbsp;<br />
			&nbsp;<br />
			&nbsp;
            <input name="MtDispoCtr" id="MtDispoCtr" type="hidden" value="0" />
            <i>
            </td>
            <? ////////////// affichage AfficheDateCtr /////////// ?>
<? ////////////// code_html_retour_part_5 : 1ctr0tier ?>
        $$_$$_$$
            <tr id="AfficheDateCtr">
                <td colspan="2" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #CC6633;">&nbsp;<i>Date debut du Marché :<i><input name="val_dateDebCtr" id="val_dateDebCtr" type="hidden" size="10" style="border: 1; font-size: 14px;color: #666666;background-color:transparent;" value="" /></td>
                <td colspan="4" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #CC6633;">&nbsp;<i>Date Fin du Marché :<i><input name="val_dateFinCtr" id="val_dateFinCtr" type="hidden" size="10" style="border: 1; font-size: 14px;color: #666666;background-color:transparent;" value="" /></td>
                <td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;">&nbsp;</td>
            </tr>
            <? ////////////// affichage avancement DENGT_Avanc_1/////////// ?>
<? ////////////// code_html_retour_part_6 : 1ctr0tier ?>
        $$_$$_$$
        	<img id="DENGT_Avanc_1" src="images/Etapes/Etape_DENGT_1_gris.png" width="74" height="117" />
			<?	
			} else { // if ($pdo_total_2 == 0) {
		//////////////////////////////////////
		//
		//		le resultat de la recherche du marche donne 1 seul resultat et le resultat de la recherche du tiers donne plusieur resultat 
		//
		/////////////////////////////////////
			?>
<? ////////////// code_html_retour_part_0 : 1ctrXtier ?>
<? ////////////// code_html_retour_part_1 : 1ctrXtier ?>
        	$$_$$_$$
            v_select
<? ////////////// code_html_retour_part_2 : 1ctrXtier ?>
        	$$_$$_$$
            <td colspan="7" align="left" bgcolor="#FFFFFF" height="22" style="font-size: 12px;color: #666666;" id="AfficheLibTiers">
            	<fieldset style="border:0; font-size: 12px;">
                	<select name="SelectNumTiers" id="SelectNumTiers">
                    	<!--<option value="?">Choisir le Tiers</option>-->
					<?
					$v_compteur = 0;
                    foreach ($pdo_sql2  as $key_sql2  => $pdo_lignes_sql2 ) {
						if ($v_compteur == 0) {
							$v_DE_084_Mt_Engt_Acce = $pdo_lignes_sql2['DE_084_Mt_Engt_Acce'];
							$v_DE_083_Mt_Engt_Prop = $pdo_lignes_sql2['DE_083_Mt_Engt_Prop'];
							$v_DE_062_Mt_Dispo = $pdo_lignes_sql2['DE_062_Mt_Dispo'];
							#$v_DE_084_Mt_Engt_Acce = $pdo_lignes_sql['D_084_Mt_Engt_Acce'];
							#$v_DE_083_Mt_Engt_Prop = $pdo_lignes_sql['D_083_Mt_Engt_Prop'];
							#$v_DE_062_Mt_Dispo = $pdo_lignes_sql['D_062_Mt_Dispo'];
							$v_compteur = 1;
						}
                        echo '<option value="'.$pdo_lignes_sql2['DE_016_Tiers'].'">'.$pdo_lignes_sql2['DE_016_Tiers'].'_'.$pdo_lignes_sql2['DE_074_Typ_Tiers'].'-"'.utf8_encode($pdo_lignes_sql2['E_010_Libelle']).'"</option>';
					}
                    ?>
                    </select>
                </fieldset>
			</td>
            <? ////////////// affichage AfficheConso /////////// ?>
<? ////////////// code_html_retour_part_3 : 1ctrXtier ?>
        $$_$$_$$
        	<td height="32" bgcolor="#FFFFFF" align="right" style="font-size: 10px;color: #CC6633;" id="AfficheConso">&nbsp;<i>
            Engagé:<br />Proposé:<br />Disponible:
            <i>
            </td>
            <? ////////////// affichage AfficheConso2 /////////// ?>
<? ////////////// code_html_retour_part_4 : 1ctrXtier ?>
        $$_$$_$$
        	<td height="32" bgcolor="#FFFFFF" align="right" style="font-size: 10px;color: #CC6633;" id="AfficheConso2">&nbsp;<i>
            <? echo number_format($v_DE_084_Mt_Engt_Acce, 2, ',', ' ') ;?>&nbsp;<br />
			<? echo number_format($v_DE_083_Mt_Engt_Prop, 2, ',', ' ') ;?>&nbsp;<br />
			<? echo number_format($v_DE_062_Mt_Dispo, 2, ',', ' ') ;?>&nbsp;
            <input name="MtDispoCtr" id="MtDispoCtr" type="hidden" value="<? echo $v_DE_062_Mt_Dispo; ?>" />
            <i>
            </td>
            <? ////////////// affichage AfficheDateCtr /////////// ?>
<? ////////////// code_html_retour_part_5 : 1ctrXtier ?>
        $$_$$_$$
            <tr id="AfficheDateCtr">
                <td colspan="2" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #CC6633;">&nbsp;<i>Date debut du Marché : <? echo F_Date_Mysql_Vers_FR($pdo_lignes_sql['D_069_Date_Deb']);?><i><input name="val_dateDebCtr" id="val_dateDebCtr" type="hidden" size="10" style="border: 1; font-size: 14px;color: #666666;background-color:transparent;" value="<? echo $pdo_lignes_sql['D_069_Date_Deb'];?>" /></td>
                <?
				if ($pdo_lignes_sql['D_065_Duree_Mois'] > 0) {
					$v_dateFinCalcule = DateAddJMA($pdo_lignes_sql['D_065_Duree_Mois'],"M",$pdo_lignes_sql['D_069_Date_Deb']);
					$v_dateFinCalcule = DateAddJMA("-1","J",$v_dateFinCalcule);
				?>
                	<td colspan="4" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #CC6633;">&nbsp;<i>Date Fin du Marché : <? echo F_Date_Mysql_Vers_FR($v_dateFinCalcule);?><i><input name="val_dateFinCtr" id="val_dateFinCtr" type="hidden" size="10" style="border: 1; font-size: 14px;color: #666666;background-color:transparent;" value="<? echo $v_dateFinCalcule; ?>" /></td>
                    <td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;">&nbsp;</td>
				<?
				} else { // if ($pdo_lignes_sql['D_065_Duree_Mois'] > 0) {
				?>
                	<td colspan="4" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #CC6633;">&nbsp;<i>Date Fin du Marché : ...... <i><input name="val_dateFinCtr" id="val_dateFinCtr" type="hidden" size="10" style="border: 1; font-size: 14px;color: #666666;background-color:transparent;" value="" /></td>
                	<td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;">&nbsp;<strong><i>alerte calcul dates Impossible<i></strong></td>
				<?
				} // if ($pdo_lignes_sql['D_065_Duree_Mois'] > 0) {
				?>
            </tr>
            <? ////////////// affichage avancement DENGT_Avanc_1/////////// ?>
<? ////////////// code_html_retour_part_6 : 1ctrXtier ?>
        $$_$$_$$
        	<img id="DENGT_Avanc_1" src="images/Etapes/Etape_DENGT_1_Vert.png" width="74" height="117" />
			<?
			} // if ($pdo_total_sql2 == 0) {
		} //if ($pdo_total_sql2 == 1) { // le resultat de la recherche du tiers donne 1 seul resultat
	} else { // if ($pdo_total_sql == 1) { // le resultat de la recherche du marche donne 1 seul resultat
		//////////////////////////////////////
		//
		//		il n'y a aucun resultat pour la recherche du marche
		//
		/////////////////////////////////////
		if ($pdo_total_sql == 0) { // il n'y a aucun resultat pour la recherche du marche
			?>
            <? ////////////// affichage AfficheLibCTR /////////// ?>
            <td colspan="7" align="left" bgcolor="#FFFFFF" height="22" style="font-size: 18px;color: #CC0000;" id="AfficheLibCTR">
            	&nbsp;<strong><i>Aucun marché avec ce N°</i></strong>
                <input name="SelectNumTiers" id="SelectNumTiers" type="hidden" value="?" />
            </td>
<? ////////////// code_html_retour_part_0 : 0ctr ?>
            <? ////////////// affichage AfficheLibTiers /////////// ?>
<? ////////////// code_html_retour_part_1 : 0ctr ?>
        	$$_$$_$$
            v_input
<? ////////////// code_html_retour_part_2 : 0ctr ?>
        	$$_$$_$$
			<td colspan="7" align="left" bgcolor="#FFFFFF" height="22" style="font-size: 12px;color: #CC6633;" id="AfficheLibTiers">
				&nbsp;
				<input name="SelectNumTiers" id="SelectNumTiers" type="hidden" value="?" />
			</td>
            <? ////////////// affichage AfficheConso /////////// ?>
<? ////////////// code_html_retour_part_3 : 0ctr ?>
        $$_$$_$$
        	<td height="32" bgcolor="#FFFFFF" align="right" style="font-size: 10px;color: #CC6633;" id="AfficheConso">&nbsp;<i>
            Engagé:<br />Proposé:<br />Disponible:
            <i>
            </td>
            <? ////////////// affichage AfficheConso2 /////////// ?>
<? ////////////// code_html_retour_part_4 : 0ctr ?>
        $$_$$_$$
        	<td height="32" bgcolor="#FFFFFF" align="right" style="font-size: 10px;color: #CC6633;" id="AfficheConso2">&nbsp;<i>
            &nbsp;<br />
			&nbsp;<br />
			&nbsp;
            <input name="MtDispoCtr" id="MtDispoCtr" type="hidden" value="0" />
            <i>
            </td>
            <? ////////////// affichage AfficheDateCtr /////////// ?>
<? ////////////// code_html_retour_part_5 : 0ctr ?>
        $$_$$_$$
            <tr id="AfficheDateCtr">
                <td colspan="2" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #CC6633;">&nbsp;<i>Date debut du Marché :<i><input name="val_dateDebCtr" id="val_dateDebCtr" type="hidden" size="10" style="border: 1; font-size: 14px;color: #666666;background-color:transparent;" value="" /></td>
                <td colspan="4" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #CC6633;">&nbsp;<i>Date Fin du Marché :<i><input name="val_dateFinCtr" id="val_dateFinCtr" type="hidden" size="10" style="border: 1; font-size: 14px;color: #666666;background-color:transparent;" value="" /></td>
                <td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;">&nbsp;</td>
            </tr>
            <? ////////////// affichage avancement DENGT_Avanc_1/////////// ?>
<? ////////////// code_html_retour_part_6 : 0ctr ?>
        $$_$$_$$
        	<img id="DENGT_Avanc_1" src="images/Etapes/Etape_DENGT_1_gris.png" width="74" height="117" />
            <?
		} else { // if ($pdo_total_sql == 0) { // il n'y a aucun resultat pour la recherche du marche
		//////////////////////////////////////
		//
		//		il n'y a plusieurs resultat pour la recherche du marche
		//
		/////////////////////////////////////
			?>
            <? ////////////// affichage AfficheLibCTR /////////// ?>
<? ////////////// code_html_retour_part_0 : Xctr ?>
            <td colspan="7" align="left" bgcolor="#FFFFFF" height="22" style="font-size: 12px;color: #CC0000;" id="AfficheLibCTR">
            	&nbsp;<strong><i>Il y a plusieur marchés avec les informations que vous avez renseigné.<br />Renseignez plus précisément le N° ou utilisez la loupe</i></strong>
                <input name="SelectNumTiers" id="SelectNumTiers" type="hidden" value="?" />
            </td>
            <? ////////////// affichage AfficheLibTiers /////////// ?>
<? ////////////// code_html_retour_part_1 : Xctr ?>
       		$$_$$_$$
            v_input
<? ////////////// code_html_retour_part_2 : Xctr ?>
        	$$_$$_$$
			<td colspan="7" align="left" bgcolor="#FFFFFF" height="22" style="font-size: 12px;color: #CC6633;" id="AfficheLibTiers">
				&nbsp;
				<input name="SelectNumTiers" id="SelectNumTiers" type="hidden" value="?" />
			</td>
            <? ////////////// affichage AfficheConso /////////// ?>
<? ////////////// code_html_retour_part_3 : Xctr ?>
        $$_$$_$$
        	<td height="32" bgcolor="#FFFFFF" align="right" style="font-size: 10px;color: #CC6633;" id="AfficheConso">&nbsp;<i>
            Engagé:<br />Proposé:<br />Disponible:
            <i>
            </td>
            <? ////////////// affichage AfficheConso2 /////////// ?>
<? ////////////// code_html_retour_part_4 : Xctr ?>
        $$_$$_$$
        	<td height="32" bgcolor="#FFFFFF" align="right" style="font-size: 10px;color: #CC6633;" id="AfficheConso2">&nbsp;<i>
            &nbsp;<br />
			&nbsp;<br />
			&nbsp;
            <input name="MtDispoCtr" id="MtDispoCtr" type="hidden" value="0" />
            <i>
            </td>
            <? ////////////// affichage AfficheDateCtr /////////// ?>
<? ////////////// code_html_retour_part_5 : Xctr ?>
        $$_$$_$$
            <tr id="AfficheDateCtr">
                <td colspan="2" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #CC6633;">&nbsp;<i>Date debut du Marché :<i><input name="val_dateDebCtr" id="val_dateDebCtr" type="hidden" size="10" style="border: 1; font-size: 14px;color: #666666;background-color:transparent;" value="" /></td>
                <td colspan="4" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #CC6633;">&nbsp;<i>Date Fin du Marché :<i><input name="val_dateFinCtr" id="val_dateFinCtr" type="hidden" size="10" style="border: 1; font-size: 14px;color: #666666;background-color:transparent;" value="" /></td>
                <td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;">&nbsp;</td>
            </tr>
            <? ////////////// affichage avancement DENGT_Avanc_1/////////// ?>
<? ////////////// code_html_retour_part_6 : Xctr ?>
        $$_$$_$$
        	<img id="DENGT_Avanc_1" src="images/Etapes/Etape_DENGT_1_gris.png" width="74" height="117" />
            <?
		} // if ($pdo_total_sql == 0) { // il n'y a aucun resultat pour la recherche du marche
	} // if ($pdo_total_sql == 1) { // le resultat de la recherche du marche donne 1 seul resultat
} // if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "ValidMarche") and ($_POST['v_D_000'] != "")) {

	
/////////////////////////////////////////////////
//
//       apel ajax sur SelectRevisable pour mise à jour tdTextRvp, tdMtRvp, tdAlertRvp et tdTauxRvp
//
/////////////////////////////////////////////////

/*
$.ajax({
	url : 'DENG_02_01_crea_dem_ajax.php',
	type : 'POST',
	data : 'v_ajax=SelectRevisable' + '&v_E1_001_id_Ctr=' + val_id_Ctr,
	dataType : 'html',
	*/
if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectRevisable") and ($_POST['v_E1_001_id_Ctr'] != "")) {
	$sql = "
		SELECT 
		E1_002_Taux
		FROM 
		E1_Taux_RVP 
		WHERE 
		E1_001_id_Ctr = '".$_POST['v_E1_001_id_Ctr']."' 
		";
		#echo $sql."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour']=$sql;
	$pdo_sql = $conDENGT->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	$pdo_total_sql = count($pdo_sql);
	if ($pdo_total_sql == 1) {
		foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
		}
		?>
		OUI
		$$_$$_$$
        <?
		echo $pdo_lignes_sql['E1_002_Taux'];
	} else { // if ($pdo_total_sql == 1) {
		echo "NON";
	} // if ($pdo_total_sql == 1) {
	
} // if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "ValidMarche") and ($_POST['v_D_000'] != "")) {
		
/////////////////////////////////////////////////
//
//       apel ajax sur SelectNumTiers pour mise à jour AfficheConso2
//
/////////////////////////////////////////////////

/*$.ajax({
	url : 'DENG_02_01_crea_dem_ajax.php',
	type : 'POST',
	data : 'v_ajax=SelectNumTiers' + '&v_DE_016=' + val_DE_016[0] + '&v_DE_017=' + val_DE_0xx[0] + '&v_DE_018=' + val_DE_0xx[1],
	dataType : 'html',
	success : function(code_html_retour, statut){
		$('#AfficheConso2').replaceWith(code_html_retour);
	},
});*/
if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectNumTiers") and ($_POST['v_DE_016'] != "") and ($_POST['v_DE_017'] != "") and ($_POST['v_DE_018'] != "")) {
	$sql2 = "
		SELECT 
			DE_062_Mt_Dispo, DE_083_Mt_Engt_Prop, DE_084_Mt_Engt_Acce 
			FROM 
			DE_Ctr_Tiers 
			WHERE 
			DE_016_Tiers = '".$_POST['v_DE_016']."' 
			and
			DE_017_Ex_Ctr = '".$_POST['v_DE_017']."' 
			and 
			DE_018_Num_Ctr = '".$_POST['v_DE_018']."'
			";
	//$sql2 = "
//		SELECT 
//			D_062_Mt_Dispo, D_083_Mt_Engt_Prop, D_084_Mt_Engt_Acce  
//			FROM 
//			D_CTR 
//			WHERE 
//			D_000_Id_Ctr LIKE '".$_POST['v_DE_017']."_".$_POST['v_DE_018']."%' 
//			AND 
//			D_012_Statut LIKE 'N'
//			";
		#echo $sql."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour : SelectNumTiers']=$sql2;
	$pdo_sql2 = $conn->query($sql2)->fetchAll(PDO::FETCH_ASSOC);
	$pdo_total_sql2 = count($pdo_sql2);
	if ($pdo_total_sql2 == 1) { 
		foreach ($pdo_sql2  as $key_sql2  => $pdo_lignes_sql2 ) {
		}
	?>
    <td height="32" bgcolor="#FFFFFF" align="right" style="font-size: 10px;color: #CC6633;" id="AfficheConso2">&nbsp;<i>
		<!--<? #echo number_format($pdo_lignes_sql2['D_084_Mt_Engt_Acce'], 2, ',', ' ') ;?>&nbsp;<br />
    	<? #echo number_format($pdo_lignes_sql2['D_083_Mt_Engt_Prop'], 2, ',', ' ') ;?>&nbsp;<br />
    	<? #echo number_format($pdo_lignes_sql2['D_062_Mt_Dispo'], 2, ',', ' ') ;?>&nbsp;-->
        
		<? echo number_format($pdo_lignes_sql2['DE_084_Mt_Engt_Acce'], 2, ',', ' ') ;?>&nbsp;<br />
    	<? echo number_format($pdo_lignes_sql2['DE_083_Mt_Engt_Prop'], 2, ',', ' ') ;?>&nbsp;<br />
    	<? echo number_format($pdo_lignes_sql2['DE_062_Mt_Dispo'], 2, ',', ' ') ;?>&nbsp;
        <input name="MtDispoCtr" id="MtDispoCtr" type="hidden" value="<? echo $pdo_lignes_sql2['DE_062_Mt_Dispo']; ?>" />
    	<i>
    </td>
    <?
	}
}

/////////////////////////////////////////////////
//
//       apel ajax sur SelectTypeBud pour mise à jour SelectIbNat
//
/////////////////////////////////////////////////

if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectTypeBud") and ($_POST['v_H_006'] != "")) {
	$sql = "
		SELECT H_027_Ib_Nature,H2_104_Libelle  
		FROM 
		H_IB, H2_IB_Libelle 
		WHERE 
		H_002_Srv LIKE '".$_SESSION['VG_Srv_Compta']."' 
		AND 
		H_006_Budget LIKE '".$_POST['v_H_006']."' 
		AND 
		H_007_Fonc_Invst LIKE 'F' 
		and 
		H2_000_Id_Ib_Lib = concat('N_','00','_',H_027_Ib_Nature) 
		group by H_027_Ib_Nature;
		";
		#echo $sql."<br>";
	$_SESSION['VG_ResultSelect']['code_html_retour : SelectTypeBud']=$sql;
	$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	$pdo_total_sql = count($pdo_sql);
	?>
    <select name="SelectIbNat" id="SelectIbNat">
        <option value="?">Choisir</option>
        <?
        if ($pdo_total_sql > 0) {
            foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
                echo '<option value="'.$pdo_lignes_sql['H_027_Ib_Nature'].'">'.$pdo_lignes_sql['H_027_Ib_Nature'].'-'.$pdo_lignes_sql['H2_104_Libelle'].'</option>';
            }
        }
        ?>
    </select>
	<?

} // if ((isset($_POST['ajax'])) and ($_POST['ajax'] == "SelectTypeBud")) {

/////////////////////////////////////////////////
//
//       apel ajax sur SelectIbNat pour mise à jour SelectIbFonc
//
/////////////////////////////////////////////////

if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectIbNat") and ($_POST['v_H_027'] != "") and ($_POST['v_H_006'] != "")) {
	$sql = "
		SELECT H_028_Ib_Fonction,H2_104_Libelle  
		FROM 
		H_IB, H2_IB_Libelle 
		WHERE 
		H_002_Srv LIKE '".$_SESSION['VG_Srv_Compta']."' 
		AND 
		H_006_Budget LIKE '".$_POST['v_H_006']."' 
		AND 
		H_007_Fonc_Invst LIKE 'F' 
		and 
		H2_000_Id_Ib_Lib = concat('F_','00','_',H_028_Ib_Fonction) 
		AND
		H_027_Ib_Nature LIKE '".$_POST['v_H_027']."' 
		order by H_028_Ib_Fonction
		";
		#echo $sql."<br>";
	$_SESSION['VG_ResultSelect']['code_html_retour : SelectIbNat']=$sql;
	$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	$pdo_total_sql = count($pdo_sql);
	?>
    <select name="SelectIbFonc" id="SelectIbFonc">
        <option value="?">Choisir</option>
        <?
        if ($pdo_total_sql > 0) {
            foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
                echo '<option value="'.$pdo_lignes_sql['H_028_Ib_Fonction'].'">'.$pdo_lignes_sql['H_028_Ib_Fonction'].'-'.$pdo_lignes_sql['H2_104_Libelle'].'</option>';
            }
        }
        ?>
    </select>
	<?

} // if ((isset($_POST['ajax'])) and ($_POST['ajax'] == "SelectIbNat")) {


/////////////////////////////////////////////////
//
//       apel ajax sur SelectEx_OPA pour mise à jour SelectNum_OPA
//
/////////////////////////////////////////////////

if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectExOPA") and ($_POST['v_F_013'] != "")) {
	$sql = "
		SELECT F_000_Id_Ope,F_010_Libelle,F_015_Num_Ope  
		FROM 
		F_OPE 
		WHERE 
		F_002_Srv LIKE '".$_SESSION['VG_Srv_Compta']."' 
		AND 
		F_013_Ex_Ope LIKE '".$_POST['v_F_013']."' 
		AND 
		F_020_OPI_OPA_FONC LIKE 'OPA'  
		order by F_015_Num_Ope
		";
	$sql = "
		SELECT F_000_Id_Ope,F_010_Libelle,F_015_Num_Ope  
		FROM 
		F_OPE 
		WHERE 
		F_002_Srv LIKE '".$_SESSION['VG_Srv_Compta']."' 
		AND 
		F_013_Ex_Ope LIKE '".$_POST['v_F_013']."' 
		AND 
		F_014_Code_Ope LIKE 'M%'  
		order by F_015_Num_Ope
		";
		#echo $sql."<br>";
	$_SESSION['VG_ResultSelect']['code_html_retour : SelectIbNat']=$sql;
	$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	$pdo_total_sql = count($pdo_sql);
	?>
    <select name="SelectNum_OPA" id="SelectNum_OPA">
        <option value="?">Choisir N° OPA</option>
        <?
        if ($pdo_total_sql > 0) {
            foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
                echo '<option value="'.$pdo_lignes_sql['F_000_Id_Ope'].'">'.$pdo_lignes_sql['F_015_Num_Ope'].'-'.utf8_encode($pdo_lignes_sql['F_010_Libelle']).'</option>';
            }
        }
        ?>
    </select>
	<?

} // if ((isset($_POST['ajax'])) and ($_POST['ajax'] == "SelectIbNat")) {


/////////////////////////////////////////////////
//
//       apel ajax sur SelectEx_OPA_IMP pour mise à jour SelectNum_OPA_IMP
//
/////////////////////////////////////////////////

if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectEx_OPA_IMP") and ($_POST['v_F_013'] != "")) {
	$sql = "
		SELECT F_000_Id_Ope,F_010_Libelle,F_015_Num_Ope  
		FROM 
		F_OPE 
		WHERE 
		F_002_Srv LIKE '".$_SESSION['VG_Srv_Compta']."' 
		AND 
		F_013_Ex_Ope LIKE '".$_POST['v_F_013']."' 
		AND 
		F_020_OPI_OPA_FONC LIKE 'OPA'  
		order by F_015_Num_Ope
		";
	$sql = "
		SELECT F_000_Id_Ope,F_010_Libelle,F_015_Num_Ope  
		FROM 
		F_OPE 
		WHERE 
		F_002_Srv LIKE '".$_SESSION['VG_Srv_Compta']."' 
		AND 
		F_013_Ex_Ope LIKE '".$_POST['v_F_013']."' 
		AND 
		F_014_Code_Ope LIKE 'M%'   
		order by F_015_Num_Ope
		";
		#echo $sql."<br>";
	$_SESSION['VG_ResultSelect']['code_html_retour : SelectIbNat']=$sql;
	$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	$pdo_total_sql = count($pdo_sql);
	?>
    <select name="SelectNum_OPA_IMP" id="SelectNum_OPA_IMP">
        <option value="?">Choisir N° OPA</option>
        <?
        if ($pdo_total_sql > 0) {
            foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
                echo '<option value="'.$pdo_lignes_sql['F_000_Id_Ope'].'">'.$pdo_lignes_sql['F_015_Num_Ope'].'-'.utf8_encode($pdo_lignes_sql['F_010_Libelle']).'</option>';
            }
        }
        ?>
    </select>
	<?

} // if ((isset($_POST['ajax'])) and ($_POST['ajax'] == "SelectIbNat")) {
	
/////////////////////////////////////////////////
//
//       apel ajax sur SelectNumMip dans liste des mip
//
/////////////////////////////////////////////////
if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectNum_OPA_IMP") and ($_POST['v_NumOpe_F5'] != "")) {
	$sqlOPI_ib = "
			select 
			FH_026_Ib_Chapitre, FH_027_Ib_Nature, FH_028_Ib_Fonction, FH_029_Ib_Srv, FH_006_Budget 
			from FH_Ope_IB 
			where FH_000_Id_Ope = '".$_POST['v_NumOpe_F5']."'" ;
			
		#echo "**".$sqlOPI_ib."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour']="111 ".$sqlOPI_ib;
		$pdo_sqlOPI_ib = $conn->query($sqlOPI_ib)->fetchAll(PDO::FETCH_ASSOC);
		$pdo_total_sqlOPI_ib = count($pdo_sqlOPI_ib);
		$t_detail_ib=array();
		$t_ib=array();
		foreach ($pdo_sqlOPI_ib  as $key_sqlOPI_ib  => $pdo_lignes_sqlOPI_ib ) {
			$v_ib = $pdo_lignes_sqlOPI_ib['FH_026_Ib_Chapitre']."_".$pdo_lignes_sqlOPI_ib['FH_027_Ib_Nature']."_".$pdo_lignes_sqlOPI_ib['FH_028_Ib_Fonction']."_".$pdo_lignes_sqlOPI_ib['FH_029_Ib_Srv'];
			$t_ib[]=$v_ib;
			$v_lib_ib=$v_ib." - ";
			$sqlOPI_libib = "
				SELECT 
				H_027_Ib_Nature,H2_104_Libelle  
				FROM 
				H_IB, H2_IB_Libelle 
				WHERE 
				H_000_Id_Ib LIKE '".$v_ib."%' 
				and 
				H2_000_Id_Ib_Lib = concat('N_','".$pdo_lignes_sqlOPI_ib['FH_006_Budget']."','_', H_IB.H_027_Ib_Nature) 
				group by H_027_Ib_Nature;";
			#echo "sqlOPI_libib :".$sqlOPI_libib."<br>";
			$_SESSION['VG_ResultSelect']['code_html_retour']=$sqlOPI_libib;
			$pdo_sqlOPI_libib = $conn->query($sqlOPI_libib)->fetchAll(PDO::FETCH_ASSOC);
			$pdo_total_sqlOPI_libib = count($sqlOPI_libib);
			if($pdo_total_sqlOPI_libib ==1) {
				foreach ($pdo_sqlOPI_libib  as $key_sqlOPI_libib  => $pdo_lignes_sqlOPI_libib) {
				}
				$v_lib_ib .= $pdo_lignes_sqlOPI_libib['H2_104_Libelle'];
				$sqlOPI_libib2 = "
					SELECT 
					H_028_Ib_Fonction,H2_104_Libelle  
					FROM 
					H_IB, H2_IB_Libelle 
					WHERE 
					H_000_Id_Ib LIKE '".$v_ib."%' 
					and 
					H2_000_Id_Ib_Lib = concat('F_','".$pdo_lignes_sqlOPI_ib['FH_006_Budget']."','_',H_028_Ib_Fonction) 
					AND
					H_027_Ib_Nature LIKE '".$pdo_lignes_sqlOPI_libib['H_027_Ib_Nature']."' 
					order by H_028_Ib_Fonction;";
				$_SESSION['VG_ResultSelect']['code_html_retour']=$sqlOPI_libib2;
				$pdo_sqlOPI_libib2 = $conn->query($sqlOPI_libib2)->fetchAll(PDO::FETCH_ASSOC);
				$pdo_total_sqlOPI_libib2 = count($sqlOPI_libib2);
				if($pdo_total_sqlOPI_libib2 ==1) {
					foreach ($pdo_sqlOPI_libib2  as $key_sqlOPI_libib2  => $pdo_lignes_sqlOPI_libib2) {
					}
					$v_lib_ib .= " / ".$pdo_lignes_sqlOPI_libib2['H2_104_Libelle'];
				} // if($pdo_total_sqlOPI_libib ==1) {
			} // if($pdo_total_sqlOPI_libib ==1) {
			$t_detail_ib[]=$v_lib_ib;
		} //foreach ($pdo_sqlOPI_ib  as $key_sqlOPI_ib  => $pdo_lignes_sqlOPI_ib ) {
		$t_F_000_Id_Ope = explode(" - ", $_POST['v_NumOpe_F5']);
		$sqlOPI_resa = "
			select 
			A_000_id_Resa, A_010_Libelle 
			from A_Resa 
			where 
			A_013_Ex_Ope = '".$t_F_000_Id_Ope[0]."'
			and 
			A_014_Code_Ope = '".$t_F_000_Id_Ope[1]."' 
			and 
			A_015_Num_Ope = '".$t_F_000_Id_Ope[2]."' 
			and
			A_012_Statut = 'N' 
			" ;
			
		#echo "sqlOPI_resa : ".$sqlOPI_resa."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour']="111 ".$sqlOPI_resa;
		$pdo_sqlOPI_resa = $conn->query($sqlOPI_resa)->fetchAll(PDO::FETCH_ASSOC);
		$pdo_total_sqlOPI_resa = count($pdo_sqlOPI_resa);
		$t_detail_Resa=array();
		$t_resa=array();
		foreach ($pdo_sqlOPI_resa  as $key_sqlOPI_resa  => $pdo_lignes_sqlOPI_resa ) {	
			$t_detail_Resa[]= $pdo_lignes_sqlOPI_resa['A_000_id_Resa']." - ".$pdo_lignes_sqlOPI_resa['A_010_Libelle'];
			$t_resa[]=$pdo_lignes_sqlOPI_resa['A_000_id_Resa'];
		}
		echo F_DivComptaOpe($t_detail_ib,$t_ib,$t_detail_Resa,$t_resa ) ; 
	
} //if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectNum_OPA_IMP") and ($_POST['v_NumOpe_F5'] != "")) {

/////////////////////////////////////////////////
//
//       apel ajax sur SelectNum_OPA ou input_NumMip pour mise à jour DivMip
//
/////////////////////////////////////////////////
if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectNumOPA") and ($_POST['v_F5_000'] != "")) {
	///////
// pour developpement hors ligne
//

$v_DatDuJourSQL = date('Y-m-d');
#$v_DatDuJourSQL = '2020-06-17';

$v_jour_date=date("w",strtotime($v_DatDuJourSQL));	
if ($v_jour_date == "1") { // c'est un lundi
	$v_DatDuJourSQLPreced = DateAddJMA(-3, "J", $v_DatDuJourSQL);
} else {
	$v_DatDuJourSQLPreced = DateAddJMA(-1, "J", $v_DatDuJourSQL);
}

	if ((isset($_POST['v_input_NumMip'])) and ($_POST['v_input_NumMip'] != "")) { // on arrive via n° mip direct $_POST['v_F5_000'] = exercice du MIP
		$sql = "select * from F5_OPE_MIP where F5_131_Id_Niv_1 = '".$_POST['v_F5_000']."' and F5_135_Id_Niv_3 like '%".$_POST['v_input_NumMip']."' and F5_001_Date_Maj = '".$v_DatDuJourSQL."' order by F5_000_id_Ope, F5_131_Id_Niv_1, F5_133_Id_Niv_2, F5_135_Id_Niv_3";
			#echo $sql."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour : input_NumMip']=$sql;
		$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		$pdo_total_sql = count($pdo_sql);
	} else { // if ((isset($_POST['v_input_NumMip'])) and ($_POST['v_input_NumMip'] != "")) { // on arrive via n° mip direct $_POST['v_F5_000'] = exercice du MIP
		$sql = "select * 
			from F5_OPE_MIP 
			where 
			F5_000_id_Ope = '".$_POST['v_F5_000']."' 
			and 
			(F5_001_Date_Maj = '".$v_DatDuJourSQL."'  or F5_001_Date_Maj = '".$v_DatDuJourSQLPreced."') 
			and 
			(F5_133_Id_Niv_2 = '".($_SESSION['VG_Ardt_choisi']*1)."' OR F5_133_Id_Niv_2 = 'NL') 
			order by F5_000_id_Ope, F5_131_Id_Niv_1, F5_133_Id_Niv_2, F5_135_Id_Niv_3";
			#echo $sql."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour : SelectNum_OPA']=$sql;
		$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		$pdo_total_sql = count($pdo_sql);
	} // if ((isset($_POST['v_input_NumMip'])) and ($_POST['v_input_NumMip'] != "")) { // on arrive via n° mip direct $_POST['v_F5_000'] = exercice du MIP
	if ($pdo_total_sql > 0) {
		  ?>
		  <div id="DivMip" style="font-size: 14px;color: #666666;display:none;">  
			  <!--construi via ajax Liste des mip-->
			  <table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" style="font-size: 8px;color: #333333;">
                <tr>
                    <th colspan="12" bgcolor="#CCCCCC" style="text-align: center;font-size: 10px"">&nbsp;<span style="color:#000">OPERATION&nbsp;:&nbsp;<? echo $pdo_sql[0]['F5_000_id_Ope']; ?>&nbsp;</span></th>
                </tr>
                <tr>
                    <th width="40" scope="row" style="text-align: center">Selectionner</th>
                    <th width="70" scope="row" style="text-align: center">N° MIP</th>
                    <th width="210" scope="row" style="text-align: center">Lieu</th>
                    <th width="330" scope="row" style="text-align: center">Libellé MIP</th>
                    <th width="70" scope="row" style="text-align: center">Mt Prév.</th>
                    <th width="70" scope="row" style="text-align: center">Mt Reval.</th>
                    <th width="70" scope="row" style="text-align: center">Mt Engt.</th>
                    <th width="70" scope="row" style="text-align: center">Mt Circuit</th>
                    <th width="70" scope="row" style="text-align: center">Mt Dispo</th>
                </tr>
                <?
				$pdo_lignes_MIP = array();
                foreach ($pdo_sql as $key_MIP => $pdo_lignes_MIP) {
					$pdo_lignes_Engt = array();
					$t_num_mip = explode("-", $pdo_lignes_MIP['F5_135_Id_Niv_3']);
					$sqlEngt = "select SUM(B_011_Mt) as ENGT
							from B_Engt 
							where 
							B_012_Statut != 'Z' 
							and 
							B_025_Axe_MIP = '".$pdo_lignes_MIP['F5_131_Id_Niv_1']."_".$pdo_lignes_MIP['F5_133_Id_Niv_2']."_".$pdo_lignes_MIP['F5_135_Id_Niv_3']."' 
							group by B_025_Axe_MIP";
					$_SESSION['VG_ResultSelect']['code_html_retour : sqlEngt']=$sqlEngt;
					$pdo_Engt = $conn->query($sqlEngt)->fetchAll(PDO::FETCH_ASSOC);
					$pdo_total_Engt = count($pdo_Engt);
					$pdo_lignes_Engt['ENGT'] = 0; // pour les cas ou il n'y a pas d'engt
					foreach ($pdo_Engt as $key_Engt => $pdo_lignes_Engt) {
					}
					///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////   ************************************************************************ A FAIRE **************************************
					////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					$sqlCircuit = "recherche des mt dans le circuit soit les status SOUM,VISE,ATTCOMPTA";
					#$pdo_Circ = $conn->query($sqlCircuit)->fetchAll(PDO::FETCH_ASSOC);
					#$pdo_total_Circ = count($pdo_Circ);
					$pdo_Circ = array();
					$pdo_Circ[0]=0;
					
					$v_mt_dispo = $pdo_lignes_MIP['F5_138_Mt_Reval']-$pdo_lignes_Engt['ENGT']-$pdo_Circ[0];
                ?>
                <tr class="TrSelectMip">
                    <td scope="row" style="text-align: center"><div id="<? echo $pdo_lignes_MIP['F5_131_Id_Niv_1']."$".$pdo_lignes_MIP['F5_133_Id_Niv_2']."$".$pdo_lignes_MIP['F5_135_Id_Niv_3']."$".$t_num_mip[1]."$".$pdo_Circ[0]."$".$pdo_lignes_Engt['ENGT']."$".$v_mt_dispo."$".$pdo_lignes_MIP['F5_000_id_Ope']; ?>" class="SelectMip">Choisir</div></td>
                    <td scope="row" style="text-align: center"><? echo $pdo_lignes_MIP['F5_131_Id_Niv_1']."-".$pdo_lignes_MIP['F5_133_Id_Niv_2']."-".$t_num_mip[1]; ?></td>
                    <td scope="row" style="text-align: left">&nbsp;<? echo utf8_encode($pdo_lignes_MIP['F5_136_Lib_Niv_3']); ?></td>
                    <td scope="row" style="text-align: left">&nbsp;<? echo utf8_encode($pdo_lignes_MIP['F5_139_lib_trx']); ?></td>
                    <td scope="row" style="text-align: right"><? echo number_format($pdo_lignes_MIP['F5_137_Mt_Prev'], 2, ',', ' '); ?>&nbsp;</td>
                    <td scope="row" style="text-align: right"><? echo number_format($pdo_lignes_MIP['F5_138_Mt_Reval'], 2, ',', ' '); ?>&nbsp;</td>
                    <td scope="row" style="text-align: right"><? echo number_format($pdo_lignes_Engt['ENGT'], 2, ',', ' '); ?>&nbsp;</td>
                    <td scope="row" style="text-align: right"><? echo number_format($pdo_Circ[0], 2, ',', ' '); ?>&nbsp;</td>
                    <td scope="row" style="text-align: right"><? echo number_format(($v_mt_dispo), 2, ',', ' '); ?>&nbsp;</td>
                </tr>
                <?
				} // foreach ($pdo_sql as $key_MIP => $pdo_lignes_MIP) {
                ?>
			  </table>
              <br />
		  </div><!--<div id="DivMip" style="font-size: 14px;color: #666666;display:none;">-->
		  <?
	} else { // if ($pdo_total_sql > 0) {
		?>
        <div id="DivMip" style="font-size: 14px;color: #666666;display:none; text-align:center">
        	Aucun MIP pour votre sélection
        </div>
        <?
	} // if ($pdo_total_sql > 0) {
} // if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectNumOPA") and ($_POST['v_F5_000'] != "")) {
	

/////////////////////////////////////////////////
//
//       apel ajax sur SelectNumMip dans liste des mip
//
/////////////////////////////////////////////////
if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectNumMip") and ($_POST['v_ExMip'] != "")) {
	// tableau detail MIP
	#echo "<br>v_ajax'] == SelectNumMip<pre>";
	#print_r($_POST);
	#echo "</pre>";
	$sql = "select * 
			from F5_OPE_MIP 
			where 
			F5_135_Id_Niv_3 = '".$_POST['v_NumMipF5_135']."'";
	#echo $sql."<br>";
	$_SESSION['VG_ResultSelect']['code_html_retour : SelectNumMip']=$sql;
	$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	$pdo_total_sql = count($pdo_sql);
	#echo "pdo_total_sql : ".$pdo_total_sql."<br>";
	foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
		}
	?>
			<table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" style="font-size: 8px;color: #333333;">
                <tr>
                    <th colspan="11" bgcolor="#CCCCCC" style="text-align: center;font-size: 10px"">&nbsp;<span style="color:#000">Detail MIP Selectionné&nbsp;:&nbsp;<? echo $_POST['v_NumMipF5_135']; ?>&nbsp;</span></th>
                </tr>
                <tr>
                    <th width="250" scope="row" style="text-align: center">Lieu</th>
                    <th width="400" scope="row" style="text-align: center">Libellé MIP</th>
                    <th width="70" scope="row" style="text-align: center">Mt Prév.</th>
                    <th width="70" scope="row" style="text-align: center">Mt Reval.</th>
                    <th width="70" scope="row" style="text-align: center">Mt Engt.</th>
                    <th width="70" scope="row" style="text-align: center">Mt Circuit</th>
                    <th width="70" scope="row" style="text-align: center">Mt Dispo</th>
                </tr>
				<tr class="TrSelectMip">
                    <td scope="row" style="text-align: left">&nbsp;<? echo utf8_encode($pdo_lignes_sql['F5_136_Lib_Niv_3']); ?></td>
                    <td scope="row" style="text-align: left">&nbsp;<? echo utf8_encode($pdo_lignes_sql['F5_139_lib_trx']); ?></td>
                    <td scope="row" style="text-align: right"><? echo number_format($pdo_lignes_sql['F5_137_Mt_Prev'], 2, ',', ' '); ?>&nbsp;</td>
                    <td scope="row" style="text-align: right"><? echo number_format($pdo_lignes_sql['F5_138_Mt_Reval'], 2, ',', ' '); ?>&nbsp;</td>
                    <td scope="row" style="text-align: right"><? echo number_format($_POST['v_Mt_Engage'], 2, ',', ' '); ?>&nbsp;</td>
                    <td scope="row" style="text-align: right"><? echo number_format($_POST['v_Mt_dans_circuit'], 2, ',', ' '); ?>&nbsp;</td>
                    <td scope="row" style="text-align: right"><? echo number_format(($_POST['v_mt_dispo']), 2, ',', ' '); ?>&nbsp;</td>
                </tr>
			</table>
	<?
	$sqlOPI_ib = "
			select 
			FH_026_Ib_Chapitre, FH_027_Ib_Nature, FH_028_Ib_Fonction, FH_029_Ib_Srv, FH_006_Budget 
			from FH_Ope_IB 
			where FH_000_Id_Ope = '".$_POST['NumOpe_F5']."'" ;
			
		#echo "**".$sqlOPI_ib."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour']="111 ".$sqlOPI_ib;
		$pdo_sqlOPI_ib = $conn->query($sqlOPI_ib)->fetchAll(PDO::FETCH_ASSOC);
		$pdo_total_sqlOPI_ib = count($pdo_sqlOPI_ib);
		$t_detail_ib=array();
		$t_ib=array();
		foreach ($pdo_sqlOPI_ib  as $key_sqlOPI_ib  => $pdo_lignes_sqlOPI_ib ) {
			$v_ib = $pdo_lignes_sqlOPI_ib['FH_026_Ib_Chapitre']."_".$pdo_lignes_sqlOPI_ib['FH_027_Ib_Nature']."_".$pdo_lignes_sqlOPI_ib['FH_028_Ib_Fonction']."_".$pdo_lignes_sqlOPI_ib['FH_029_Ib_Srv'];
			$t_ib[]=$v_ib;
			$v_lib_ib=$v_ib." - ";
			$sqlOPI_libib = "
				SELECT 
				H_027_Ib_Nature,H2_104_Libelle  
				FROM 
				H_IB, H2_IB_Libelle 
				WHERE 
				H_000_Id_Ib LIKE '".$v_ib."%' 
				and 
				H2_000_Id_Ib_Lib = concat('N_','".$pdo_lignes_sqlOPI_ib['FH_006_Budget']."','_', H_IB.H_027_Ib_Nature) 
				group by H_027_Ib_Nature;";
			#echo "sqlOPI_libib :".$sqlOPI_libib."<br>";
			$_SESSION['VG_ResultSelect']['code_html_retour']=$sqlOPI_libib;
			$pdo_sqlOPI_libib = $conn->query($sqlOPI_libib)->fetchAll(PDO::FETCH_ASSOC);
			$pdo_total_sqlOPI_libib = count($sqlOPI_libib);
			if($pdo_total_sqlOPI_libib ==1) {
				foreach ($pdo_sqlOPI_libib  as $key_sqlOPI_libib  => $pdo_lignes_sqlOPI_libib) {
				}
				$v_lib_ib .= $pdo_lignes_sqlOPI_libib['H2_104_Libelle'];
				$sqlOPI_libib2 = "
					SELECT 
					H_028_Ib_Fonction,H2_104_Libelle  
					FROM 
					H_IB, H2_IB_Libelle 
					WHERE 
					H_000_Id_Ib LIKE '".$v_ib."%' 
					and 
					H2_000_Id_Ib_Lib = concat('F_','".$pdo_lignes_sqlOPI_ib['FH_006_Budget']."','_',H_028_Ib_Fonction) 
					AND
					H_027_Ib_Nature LIKE '".$pdo_lignes_sqlOPI_libib['H_027_Ib_Nature']."' 
					order by H_028_Ib_Fonction;";
				$_SESSION['VG_ResultSelect']['code_html_retour']=$sqlOPI_libib2;
				$pdo_sqlOPI_libib2 = $conn->query($sqlOPI_libib2)->fetchAll(PDO::FETCH_ASSOC);
				$pdo_total_sqlOPI_libib2 = count($sqlOPI_libib2);
				if($pdo_total_sqlOPI_libib2 ==1) {
					foreach ($pdo_sqlOPI_libib2  as $key_sqlOPI_libib2  => $pdo_lignes_sqlOPI_libib2) {
					}
					$v_lib_ib .= " / ".$pdo_lignes_sqlOPI_libib2['H2_104_Libelle'];
				} // if($pdo_total_sqlOPI_libib ==1) {
			} // if($pdo_total_sqlOPI_libib ==1) {
			$t_detail_ib[]=$v_lib_ib;
		} //foreach ($pdo_sqlOPI_ib  as $key_sqlOPI_ib  => $pdo_lignes_sqlOPI_ib ) {
		$t_F_000_Id_Ope = explode(" - ", $_POST['NumOpe_F5']);
		$sqlOPI_resa = "
			select 
			A_000_id_Resa, A_010_Libelle 
			from A_Resa 
			where 
			A_013_Ex_Ope = '".$t_F_000_Id_Ope[0]."'
			and 
			A_014_Code_Ope = '".$t_F_000_Id_Ope[1]."' 
			and 
			A_015_Num_Ope = '".$t_F_000_Id_Ope[2]."' 
			and
			A_012_Statut = 'N' 
			" ;
			
		#echo "sqlOPI_resa : ".$sqlOPI_resa."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour']="111 ".$sqlOPI_resa;
		$pdo_sqlOPI_resa = $conn->query($sqlOPI_resa)->fetchAll(PDO::FETCH_ASSOC);
		$pdo_total_sqlOPI_resa = count($pdo_sqlOPI_resa);
		$t_detail_Resa=array();
		$t_resa=array();
		foreach ($pdo_sqlOPI_resa  as $key_sqlOPI_resa  => $pdo_lignes_sqlOPI_resa ) {	
			$t_detail_Resa[]= $pdo_lignes_sqlOPI_resa['A_000_id_Resa']." - ".$pdo_lignes_sqlOPI_resa['A_010_Libelle'];
			$t_resa[]=$pdo_lignes_sqlOPI_resa['A_000_id_Resa'];
		}
		?>
        $$_$$_$$
        <? echo F_DivComptaOpe($t_detail_ib,$t_ib,$t_detail_Resa,$t_resa ) ;
		?>
        $$_$$_$$
        <? // recherche % depasement autorisé
		
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////   ************************************************************************ A FAIRE **************************************
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$v_Pourcentage_depas = 0.05;
			echo $v_Pourcentage_depas;
		?>
        $$_$$_$$
		<? // rMt revalo du MIP dans input
			echo $pdo_lignes_sql['F5_138_Mt_Reval'];
} // if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectNumMip") and ($_POST['v_ExMip'] != "")) {
	
/////////////////////////////////////////////////
//
//       apel ajax sur SelectType_CTR pour mise à jour AfficheCEMbc
//
/////////////////////////////////////////////////
/*
$.ajax({
				url : 'DENG_02_01_crea_dem_ajax.php',
				type : 'POST',
				data : 'v_ajax=SelectType_CTR' + '&v_item=' + lign.label,
				dataType : 'html',
				success : function(code_html_retour, statut){
					$('#AfficheCEMbc').replaceWith(code_html_retour);
					$("select#SelectCE_CTR").jqxDropDownList({ width: 260, height: 22, autoDropDownHeight: true });
				},
			});	
			*/
if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectType_CTR") and ($_POST['v_item'] != "")) {
	?>
    <td colspan="2" bgcolor="#FFFFFF" id="AfficheCEMbc">
	<?
	$v_AffSelect = "Non";
	switch ($_POST['v_item']) {
		case "MBC Trx":
		$v_AffSelect = "A";
		break;
		case "MBC Presta":
		$v_AffSelect = "C";
		break;
		case "MBC Period":
		$v_AffSelect = "D";
		break;
	}
	if ($v_AffSelect != "Non") {
		$sql = "
			SELECT D112_112_CE, D112_140_Lib_CE 
			FROM 
			D112_Ctr_CE, D3_Ctr_Info_Compl 
			WHERE 
			D112_13_Type2_CTR = '".$v_AffSelect."' 
			and 
			D112_112_CE = D3_112_CE 
			and 
			D3_017_Ex_Ctr > '".(date('Y')-5)."' 
			group by D112_140_Lib_CE
			";
			#echo $sql."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour : SelectType_CTR']=$sql;
		$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		$pdo_total_sql = count($pdo_sql);
		if ($pdo_total_sql > 0) {
			?>
			<select name="SelectCE_CTR" id="SelectCE_CTR">
				<option value="?">Choisir</option>
				<?
				foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
					echo '<option value="'.$pdo_lignes_sql['D112_112_CE'].'">'.utf8_encode($pdo_lignes_sql['D112_140_Lib_CE']).'</option>';
				}
				?>
			</select>
            <select name="SelectList_CTR" id="SelectList_CTR" style="visibility: hidden;">
				<option value="?">Choisir</option>
			</select>
			<?
		} else { // if ($pdo_total_sql > 0) {
			echo "&nbsp;";
		} // if ($pdo_total_sql > 0) {
	} else { // if ($v_AffSelect != "Non") {
		echo "&nbsp;";
	} // if ($v_AffSelect != "Non") {
	?>
    </td>
    <?
}


/////////////////////////////////////////////////
//
//       apel ajax sur SelectCE_CTR pour mise à jour SelectList_CTR
//
/////////////////////////////////////////////////
/*
$.ajax({
	url : 'DENG_02_01_crea_dem_ajax.php',
	type : 'POST',
	data : 'v_ajax=SelectCE_CTR' + '&v_item=' + lign2.value,
	dataType : 'html',
	success : function(code_html_retour, statut){
		$('#SelectList_CTR').replaceWith(code_html_retour);
		$("select#SelectList_CTR").jqxDropDownList({ width: 250, height: 22, dropDownHeight: 350, dropDownWidth: 400, dropDownHorizontalAlignment: 'left' });
	},
});
*/
if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "SelectCE_CTR") and ($_POST['v_item'] != "")) {
	if ($_SESSION['VG_Ardt_choisi'] == 'NL') {
		$v1_Ardt_choisi = $_SESSION['VG_Ardt_choisi'];// recup VG_Ardt_Dir le couper en paquet de 2 ardt et remplacer les _ par - (ardt separé par - dans D3_Ctr_Info_Compl) + faire des OR pour le where de D3_117
	} else {
		$v1_Ardt_choisi = $_SESSION['VG_Ardt_choisi'];
	}
	$sql = "
			SELECT D3_000_Id_Ctr, D_010_Libelle 
			FROM 
			D_CTR, D3_Ctr_Info_Compl 
			WHERE 
			D3_112_CE = '".$_POST['v_item']."' 
			and 
			D3_117_Ardt like'%".$_SESSION['VG_Ardt_choisi']."%' 
			and 
			D_000_Id_Ctr = D3_000_Id_Ctr  
			order by D_000_Id_Ctr DESC
			";
			#echo $sql."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour : SelectType_CTR']=$sql;
		$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		$pdo_total_sql = count($pdo_sql);
		if ($pdo_total_sql > 0) {
			?>
			<select name="SelectList_CTR" id="SelectList_CTR">
				<option value="?">Choisir</option>
				<?
				foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
					echo '<option value="'.$pdo_lignes_sql['D3_000_Id_Ctr'].'">'.$pdo_lignes_sql['D3_000_Id_Ctr'].'-'.utf8_encode($pdo_lignes_sql['D_010_Libelle']).'</option>';
				}
				?>
			</select>
			<?
		}
	
}


/////////////////////////////////////////////////
//
//       apel ajax sur bt image ValidLoup pour mise à jour SelectList_CTR
//
/////////////////////////////////////////////////
/*
$.ajax({
							url : 'DENG_02_01_crea_dem_ajax.php',
							type : 'POST',
							data : 'v_ajax=ValidLoup' + '&v_D_000=' + val_D_000,
							dataType : 'html',
*/
if ((isset($_POST['v_ajax'])) and ($_POST['v_ajax'] == "ValidLoup") and ($_POST['v_D_000'] != "")) {
	$sql = "
			SELECT D_000_Id_Ctr, D_010_Libelle
			FROM 
			D_CTR 
			WHERE 
			D_000_Id_Ctr like '".$_POST['v_D_000']."%'  
		and 
		D_002_Srv in (".$v_srv_dgave_in.")
			order by D_000_Id_Ctr DESC
			";
			#echo $sql."<br>";
		$_SESSION['VG_ResultSelect']['code_html_retour : SelectType_CTR']=$sql;
		$pdo_sql = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		$pdo_total_sql = count($pdo_sql);
		if ($pdo_total_sql > 0) {
			?>
            <td colspan="2" bgcolor="#FFFFFF" id="AfficheCEMbc">
                <select name="SelectList_CTR" id="SelectList_CTR">
                    <option value="?">Choisir</option>
                    <?
                    foreach ($pdo_sql  as $key_sql  => $pdo_lignes_sql ) {
                        echo '<option value="'.$pdo_lignes_sql['D_000_Id_Ctr'].'">'.$pdo_lignes_sql['D_000_Id_Ctr'].'-'.utf8_encode($pdo_lignes_sql['D_010_Libelle']).'</option>';
                    }
                    ?>
                </select>
            </td>
			<?
		} else {
			echo "Erreur";
		}
	
}
?>