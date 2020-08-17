<?php
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');
include('../_Fonctions/F_report_err_par_mail.php');
///////////////////////////  F_report_err_par_mail.php  ////////////////////////////////////////////
// contient la fonction qui retourne $chemin_to_racine
// contient la fonction qui envoi mail erreur PHP
// contient la fonction email_err_mysql qui envoi mail des erreurs mysql Exemple: mysql_query($query_2, $Con_PEG_DATA_BO_Prod) or die(email_err_mysql(__FILE__, __LINE__, $Con_PEG_DATA_BO_Prod));
///////////////////////////////////////////////////////////////////////


#require_once($chemin_to_racine.'_Sessions/Verif_Ses.php');
ini_set ('session_use_cookies', 0);
session_start();

//////////////////////////////////////////////////
//
//        Maj des Vg et variables par rapport a cette page
//
/////////////////////////////////////////////////

$_SESSION['VG_Applicatif'] = "Travaux > Demande d'engagements  v0.2";
$v_id_css_logo = "LogoTravaux";
$v_classe_du_Body = "BodyPetitHeader";
$v_id_div_header = "PetitHeaderDGAVE";
$t_menu_burger = array();
$t_menu_burger = array(
    "TRX_03_01_Visu.php?ReInit=0" => "Vérification Factures",
    "#" => "Dépense par Batiment",
    "PROG_05.php?ReInit=0" => "Analyse AO BPU",
    "Marches_01_Esti_00.php?ReInit=0" => "Estimatif",
    "PROG_00.php?ReInit=0" => "Suivi Programmation",
    "DENGT_00.php?ReInit=0" => "Demande Engagement",
);



include ('DENGT_Header.php');


//////////////////////////////////////////////////
//
//     chargement ds bibliotheque spécifiques à la page
//
/////////////////////////////////////////////////
?>
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
    
<div id="corp">
	<?
    //////////////////////////////////////////////////
    //
    //        include de la partie gauche commune a toutes les pages Marchés
    //
    /////////////////////////////////////////////////
    
    #require_once('Marches_Left.php');
    ?>
    <?
    //////////////////////////////////////////////////
    //
    //        Partie droite commune a toutes les pages
    //
    /////////////////////////////////////////////////
    ?>
    <div id="right"  class="NoShow">
		<? // class NoShow pour masquer pendant les traitements Jquery. Si utiliser ajouter en fin de javascript (voir ci dessous). necessaire pour reafficher quand jquery OK
                //$(window).load(function(){
                    //$('#right').removeClass('NoShow');
                //});
        ?>
        <div id="contenu-right">
            <div id="arbo_DENGT">
                <strong>&nbsp;&nbsp;Vous êtes ici :</strong> <i><? echo $_SESSION['VG_Applicatif'] ; ?></i>
            </div>
            <br />
<!--         //////////////////////////////////////////////////
            //
            //        Partie droite propre a cette page
            //
            /////////////////////////////////////////////////
-->            
            <? #if (($_SESSION['VG_Mdp_OK'] == "OUI" ) and ($_SESSION['VG_droits_CTR_visu'] == "OUI" )) { ?>
            <?
if ($_SESSION['VG_Pnom'] == 'apons') {
	$_SESSION['VG_Srv_Compta'] = '50602';
}
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

			#include 'DENGT_02_Enreg_post_data.inc';
			require_once('DENGT_02_Enreg_post_data.php');
			// en sortie de include $t_data_A0 contient toutes les data de AO
			// en sortie de include $t_data_A22 contient toutes les data de A22
			// en sortie de include $t_data_A31 contient toutes les data de A31

			/* echo "<pre>";
			echo " data de AO : ";
			print_r($t_data_A0);
			echo " data de A22 : ";
			print_r($t_data_A22);
			echo " data de A31 : ";
			print_r($t_data_A31);
			echo "</pre>"; */

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

#echo "<pre>";
#print_r($t_data_A0);
#echo "</pre>";
			try { //try1
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
#echo "sth1 : <br>";
				$sth->execute($t_data_A0);
				$v_id_Dem = $conDENGT->lastInsertId();
			
				//////////////////////////////////////////////////
				//
				//       Stokage A22_ObjetLong
				//
				/////////////////////////////////////////////////
				if ($t_data_A22[2] != '') {
					$t_data_A22[0] = "NULL"; // A22_000_idSql
					$t_data_A22[1] = $v_id_Dem; // A22_001_idSql_A0
#echo "<pre>";
#print_r($t_data_A22);
#echo "</pre>";
					try { //try2
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
#echo "sth2 : <br>";
						$sth->execute($t_data_A22);
					} //try2
					catch(PDOException $e){ //try2
						echo "Erreur INSERT INTO A22_ObjetLong : " . $e->getMessage();
					} //try2
				} //if ($t_data_A22[2] != '') {
			
				//////////////////////////////////////////////////
				//
				//       Stokage A31_RefPatEngt
				//
				/////////////////////////////////////////////////
				
				if ($t_data_A31[2] != 'AUCUN') {
					$t_data_A31[0] = "NULL"; // A31_000_idSql
					$t_data_A31[1] = $v_id_Dem; // A31_001_idSql_A0
#echo "<pre>";
#print_r($t_data_A31);
#echo "</pre>";
					try { //try3
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
#echo "sth3 : <br>";
						$sth->execute($t_data_A31);
					} //try3
					catch(PDOException $e){ //try3
						echo "Erreur INSERT INTO A31_RefPatEngt : " . $e->getMessage();
					} //try3
				} // f ($t_data_A31[2] != 'AUCUN') {
			
				//////////////////////////////////////////////////
				//
				//       Stokage A60B_Histo_statut
				//
				/////////////////////////////////////////////////
				
				$t_data_A60B[0] = "NULL"; // A60B_000_idSql
				$t_data_A60B[1] = $v_id_Dem; // A60B_001_idSql_A0
#echo "<pre>";
#print_r($t_data_A60B);
#echo "</pre>";
				try { //try4
					$conDENGT->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sth = $conDENGT->prepare("
						INSERT INTO A60B_Histo_statut
						(
						A60B_000_idSql, 
						A60B_001_idSql_A0, 
						A60B_002_Statut, 
						A60B_003_EmailEnvoye, 
						A60B_004_DatEnvoiMail, 
						A60B_100_Dat_last_modif, 
						A60B_101_pnom_last_modif
						) 
						VALUE  
						(
						? , 
						? , 
						? , 
						? , 
						? , 
						? ,
						?
						)
					");
#echo "sth5 : <br>";
					$sth->execute($t_data_A60B);
				} //try4
				catch(PDOException $e){ //try4
					echo "Erreur INSERT INTO A60B_Histo_statut : " . $e->getMessage();
				} //try4
				?>
                <br />
                <strong>Version v0.3 </strong>sans aucun circuit de validation informatisé<br />
      <strong>&nbsp;&nbsp;Sur cette version l'enregistrement de la demande est effectué&nbsp;&nbsp;****&nbsp;&nbsp;Le circuit de validation reste manuel</strong>&nbsp;&nbsp;<img src="images/Alert_35_38.png" width="35" height="38" /><br /><br /><br />
				<table style="border: 0px solid; background-color:#666666; padding: 0px; width:1000px; margin-left:auto; margin-right:auto; font-size: 12px;color: #666666;">
					<tr>
						<td style="width: 55px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;"><? echo sprintf("%06d", $v_id_Dem);?></td>
						<td style="width: 80px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;"><? echo date('d/m/Y');?></td>
						<td style="width: 100px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;"><? echo $t_data_A0[2];?></td>
						<td style="width: 30px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;"><? echo sprintf("%02d", $t_data_A0[4]);?></td>
						<td style="width: 510px; height: 32px; vertical-align: middle; text-align:left; background-color:#FFFFFF;">&nbsp;<? echo utf8_encode($t_data_A0[16]);?></td>
						<td style="width: 100px; height: 32px; vertical-align: middle; text-align:right; background-color:#FFFFFF;"><? echo number_format(($t_data_A0[11]+ $t_data_A0[12]), 2, ',', ' ');?>&nbsp;</td>
						<td style="width: 120px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;"><a href="DENG_02_Crea_PDF_Dem.php?v_A0_000_idSql=<? echo $v_id_Dem;?>&Sortie=pdf" target="_blank"><img src="images/Boutons/_Bouton_H32/fond_Gris/Telecharg_PDF_117_32.png" width="117" height="32" alt="Telecharger PDF" /></a></td>
					</tr>
				</table>
				<br />
				<table style="border: 0px solid; background-color:#FFFFFF; padding: 0px; width:1020px; margin-left:auto; margin-right:auto; font-size: 12px;color: #666666;">
					<tr style="height: 5px">
						<td style="width: 400px"></td>
						<td style="width: 400px"></td>
						<td style="width: 400px"></td>
					</tr>
					<tr style="text-align: center; height: 32px">
						<td style="width: 400px; text-align: left; vertical-align: middle;">
							<div id="click_Bt_annu">
							&nbsp;&nbsp;<img src="images/Boutons/BT_DENG_Retour_160_32.png" width="160" height="32" alt="Retour" style="border:0px; outline: none;vertical-align:middle;" class="rollove" /><br />&nbsp;&nbsp;
							</div>
						</td>
						<td style="width: 400px; text-align: right; vertical-align: middle;">
							<!--<img src="images/Boutons/BT_DENG_Projet_160_32.png" width="160" height="32" alt="Enreg Projet" style="border:0px; outline: none;vertical-align:middle;" class="rollove" /><br />-->&nbsp;&nbsp;
						</td>
						<td style="width: 400px; text-align: right; vertical-align: middle;">
							<!--<img src="images/Boutons/BT_DENG_Projet_160_32.png" width="160" height="32" alt="Enreg Projet" style="border:0px; outline: none;vertical-align:middle;" class="rollove" /><br />-->&nbsp;&nbsp;
						</td>
					</tr>
					<tr style="height: 5px">
						<td style="width: 400px"></td>
						<td style="width: 400px"></td>
						<td style="width: 400px"></td>
					</tr>
				</table>
						
						
						
				<?
			} //try1
			catch(PDOException $e){ //try1
				echo "Erreur INSERT INTO A0_DemandeEngt : " . $e->getMessage();
			} //try1
?>
            
            <? #} if (($_SESSION['VG_Mdp_OK'] == "OUI" ) and ($_SESSION['VG_droits_CTR_visu'] == "OUI" )) { ?>
<!--         //////////////////////////////////////////////////
            //
            //        FIN Partie droite propre a cette page
            //
            /////////////////////////////////////////////////
-->            
    	</div><!-- <div id="contenu-right">-->
	</div> <!--<div id="right"  class="NoShow">-->
<?
//////////////////////////////////////////////////
//
//        include du footer commun a toutes les pages
//
/////////////////////////////////////////////////

require_once('Footer.php');

?>

<!-- container pour growl sans case fermeture-->
<div id="containerGrowlErr0_Auto" style="display:none; z-index:1000; margin-left: 310px;; margin-top: 165px;">
		<div id="withIcon">
			<div style="float:left;margin:0 10px 0 0"><img src="#{icon}" alt="warning" /></div>
			<h1>#{title}</h1>
			<p>#{text}</p>
		</div>
</div>
<!-- fin container pour growl sans case fermeture -->


<!-- container attente download -->
<div id="preparing-file-modal" title="Téléchargement en cours..." style="display: none;">
    <br />
	<br />
	<br />
	<div style="text-align:center"><img src="images/attente_37_39.gif" width="37" height="39" align="absmiddle" /></div>
</div>

<div id="error-modal" title="Error" style="display: none;">
    Téléchargement impossible
</div>

<!-- ######################################################################################## -->
<!-- ######################  JAVA SCRIPT  ################################################### -->
<!-- ######################################################################################## -->
<script type="text/javascript"><!--


$(document).ready(function(){

	//////////////////////////////////////////////////
	//--------------------- BT image annul -------------------
	//////////////////////////////////////////////////
	$("#click_Bt_annu").on('click', function() {
		window.location.href = 'DENG_00.php';
		
	});
	
	
	//------------------------------------------------------------------------------------------
	//------------------------- Gestion roolover------------------------------------------------
	//			l'objet doit avoir la classe : rollove --- l'image(en png) down doit avoir le meme nom avec _down à la fin (ex image_30_30.png et image_30_30_down.png)
	
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
	//-----------------------------------------------------------------------------------------------
	//------------------------- FIN Gestion roolover-------------------------------------------------
	
});


//////////////////////////////////////////////////////////
//--------------- Fonctions javascript interface -------------------
/////////////////////////////////////////////////////////

//--></script>

<!-- ######################################################################################## -->
<!-- ######################  FIN JAVA SCRIPT  ############################################### -->
<!-- ######################################################################################## -->