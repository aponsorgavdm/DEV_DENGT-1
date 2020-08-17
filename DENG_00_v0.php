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


require_once('../_Fonctions/_Dates/F_Date_Mysql_Vers_FR.php');


//////////////////////////////////////////////////
//
//        Maj des Vg et variables par rapport a cette page
//
/////////////////////////////////////////////////

$_SESSION['VG_Applicatif'] = "Travaux > Demande d'engagements v0.2";
$v_id_css_logo = "LogoTravaux";
$v_classe_du_Body = "BodyPetitHeader";
$v_id_div_header = "PetitHeaderDGAVE";
$t_menu_burger = array();
$t_menu_burger = array(
    "TRX_03_01_Visu.php?ReInit=0" => "Vérification Factures",
    "PROG_05.php?ReInit=0" => "Analyse AO BPU",
    "Marches_01_Esti_00.php?ReInit=0" => "Estimatif",
    "PROG_00.php?ReInit=0" => "Suivi Programmation",
    "DENG_00.php?ReInit=0" => "Demande Engagement",
);



include ('DENGT_Header.php');
// dans DENGT_Header : connProd=Pegase_Data_BO_Prod , connUtil=utilisateurdgabc, connAO=Analyse_AO, conBPU=BPU_Apel, conDENGT


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
	//     faire la gestion des doits
	//
	/////////////////////////////////////////////////
	
	
	
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
            <? if (($_SESSION['VG_Mdp_OK'] == "OUI") and ($_SESSION['VG_droits_DENGT'] =="Oui")){ ?>
            <form action="DENG_02_01_crea_dem.php" method="post" name="Dem_DENGT" id="Dem_DENGT"  enctype="application/x-www-form-urlencoded">  
            
            <strong>Version de test v0.2<br />
            &nbsp;&nbsp;Sur cette version AUCUN enregistrement de demande ne sera effectué</strong>&nbsp;&nbsp;<img src="images/Alert_35_38.png" width="35" height="38" /><br />
			<table style="border: 0px solid; background-color:rgba(0, 0, 0, 0); padding: 0px; width:1000px; margin-left:auto; margin-right:auto; font-size: 12px;color: #666666;">
              <tr style="height: 0px">
                  <td style="width: 142px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 142px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 142px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 142px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 142px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 142px; background-color:rgba(0, 0, 0, 0);"></td>
                  <td style="width: 142px; background-color:rgba(0, 0, 0, 0);"></td>
              </tr>
              <tr>
              	<td style="height: 32px; vertical-align: middle; background-color:rgba(0, 0, 0, 0);">&nbsp;<strong>faire une demande : </strong></td>
              <?
				$t_list_ardt_autorise = explode("_",$_SESSION['VG_droits_DENGT_Ardt']);
				$v_showhide_LancerDem = "none";
				if (count($t_list_ardt_autorise) == 1) { ?>
					<td style="height: 64px; background-color:rgba(0, 0, 0, 0);">
                        <fieldset style="border:0; font-size: 12px;">&nbsp;<strong>Ardt :</strong>
                              <select name="val_Ardt_choisi" id="val_Ardt_choisi">
                                  <option value="<? echo $_SESSION['VG_droits_DENGT_Ardt'];?>"><? echo $_SESSION['VG_droits_DENGT_Ardt'];?></option>
                              </select>
                          </fieldset>
                   	</td>
				<?  } else { // if (count($t_list_ardt_autorise) == 1) { ?>
					<td  style="height: 64px; background-color:rgba(0, 0, 0, 0);">
						<fieldset style="border:0; font-size: 12px;">&nbsp;<strong>Ardt :</strong>
						  <select name="val_Ardt_choisi" id="val_Ardt_choisi">
							  <option value="?">Choisir</option>
							  <?
							  foreach ($t_list_ardt_autorise as $key => $value) {
								echo '<option value="'.$value.'">'.$value.'</option>';
							  }
							  ?>
                              <option value="NL">Multi Ardt</option>
						  </select>
					  </fieldset>
					</td>
				<?  } // if (count($t_list_ardt_autorise) == 1) { ?>
                
				<? if ($_SESSION['VG_droits_DENGT_profil'] == "DEM") { ?>
                <? $v_showhide_LancerDem = "inline"; ?>
                <td colspan="2" style="background-color:rgba(0, 0, 0, 0);">
                    <fieldset style="border:0; font-size: 12px;">&nbsp;<strong>Pour :</strong>
                      <select name="val_pnom_choisi" id="val_pnom_choisi">
                          <option value="<? echo $_SESSION['VG_Pnom'];?>"><? echo $_SESSION['VG_Pnom'];?></option>
                      </select>
                  </fieldset>
                </td>
                <? } else { //if ($_SESSION['VG_droits_DENGT_profil'] == "DEM") { ?>
                    <? if (count($t_list_ardt_autorise) == 1) { 
                        $sql = "Select Id_Agent from agent_dgabc_2 where Id_Service Like '".$_SESSION['VG_Srv']."' and Valide_O_N = 'O'";
                        $pdo_result = $connUtil->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                    
                    ?>
                        <td colspan="2" style="background-color:rgba(0, 0, 0, 0);">
                            <fieldset style="border:0; font-size: 12px;">&nbsp;<strong>Pour :</strong>
                              <select name="val_pnom_choisi" id="val_pnom_choisi">
                                  <option value="?">Choisir</option>
                                  <? foreach($pdo_result as $key => $pdo_lignes) { ?>	  
                                  <option value="<? echo $pdo_lignes['Id_Agent'];?>"><? echo $pdo_lignes['Id_Agent'];?></option>
                                  <? } ?>	
                              </select>
                          </fieldset>
                        </td>
                    <? } else { //if (count($t_list_ardt_autorise) == 1) { ?>
                        <td colspan="2" style="background-color:rgba(0, 0, 0, 0);">
                            <fieldset style="border:0; font-size: 12px;">&nbsp;<strong>Pour :</strong>
                              <select name="val_pnom_choisi" id="val_pnom_choisi">
                                  <option value="?">Choisir</option>
                              </select>
                          </fieldset>
                        </td>
                    <? } //if (count($t_list_ardt_autorise) == 1) { ?>
                
                <? } //if ($_SESSION['VG_droits_DENGT_profil'] == "DEM") { ?>
                <td colspan="3" style="background-color:rgba(0, 0, 0, 0); text-align: left;height: 32px; vertical-align: middle;"  valign="middle" >
                    <div id="LancerDem" style="font-size: 12px;color: #666666;display:<? echo $v_showhide_LancerDem; ?>;">
                    <img src="images/maj_64_64.png" width="64" height="64" class="rollove" title="etablir demande" id="Bt_lanc_dem" />
                    </div>
                </td>
              </tr>
            </table>
            </form>
            <br />
            
            <? #if ($_SESSION['VG_Pnom'] == 'schabotx') { ?>
            <?
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
				if ($_SESSION['VG_droits_DENGT_profil'] == "DEM") {
					$sql01 = "SELECT * FROM A0_DemandeEngt WHERE A0_002_Pour_pnom = '".$_SESSION['VG_Pnom']."' order by A0_004_Ardt,A0_000_idSql";
				} else {
					$sql01 = "SELECT * FROM A0_DemandeEngt WHERE A0_004_Ardt in (".$v_sql_in_ardt.") order by A0_004_Ardt,A0_000_idSql";
				}
#echo $sql01."<br>";	
			$pdo_sql01 = $conDENGT->query($sql01)->fetchAll(PDO::FETCH_ASSOC);
			?>
				<table style="border: 0px solid; background-color:#666666; padding: 0px; width:1000px; margin-left:auto; margin-right:auto; font-size: 12px;color: #666666;">
					<tr>
						<th style="width: 55px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;">N° Dem</th>
						<th style="width: 80px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;">du</th>
						<th style="width: 100px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;">pour</th>
						<th style="width: 30px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;">Ardt</th>
						<th style="width: 510px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;">Libellé demande</th>
						<th style="width: 100px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;">Montant HT</th>
						<th style="width: 120px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;">Action</th>
					</tr>
                    <?
					if (count($pdo_sql01) > 0) {
						foreach ($pdo_sql01  as $key_sql01  => $pdo_lignes_sql01) {
					?>
					<tr>
						<td style="width: 55px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;"><? echo sprintf("%06d", $pdo_lignes_sql01['A0_000_idSql']);?></td>
                        <?
						$sql02 = "SELECT Z1_007_DatEvent FROM Z1_SuiviMaj WHERE Z1_002_idSqlDansTable = '".$pdo_lignes_sql01['A0_000_idSql']."' and Z1_003_TypEvent = 'Creation' and Z1_001_NomTable = 'A0_DemandeEngt'";
						$pdo_sql02 = $conDENGT->query($sql02)->fetchAll(PDO::FETCH_ASSOC);
						if (count($pdo_sql02) > 0) {
							foreach ($pdo_sql02  as $key_sql02  => $pdo_lignes_sql02) {
							}
							$v_dat_Maj = F_Date_Mysql_Vers_FR(substr($pdo_lignes_sql02['Z1_007_DatEvent'],0,10));
						} else {
							$v_dat_Maj = date('d/m/Y');
						}
						?>
						<td style="width: 80px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;"><? echo $v_dat_Maj ;?></td>
						<td style="width: 100px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;"><? echo $pdo_lignes_sql01['A0_002_Pour_pnom'];?></td>
						<td style="width: 30px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;"><? echo sprintf("%02d", $pdo_lignes_sql01['A0_004_Ardt']);?></td>
						<td style="width: 510px; height: 32px; vertical-align: middle; text-align:left; background-color:#FFFFFF;">&nbsp;<? echo utf8_encode($pdo_lignes_sql01['A0_022_ObjEngt']);?></td>
						<td style="width: 100px; height: 32px; vertical-align: middle; text-align:right; background-color:#FFFFFF;"><? echo number_format(($pdo_lignes_sql01['A0_011_Mt_HT']+ $pdo_lignes_sql01['A0_012_Mt_RVP_HT']), 2, ',', ' ');?>&nbsp;</td>
						<td style="width: 120px; height: 32px; vertical-align: middle; text-align:center; background-color:#FFFFFF;"><a href="DENG_02_Crea_PDF_Dem.php?v_A0_000_idSql=<? echo $pdo_lignes_sql01['A0_000_idSql'];?>" target="_blank"><img src="images/pdf_icon_29_30.png" width="29" height="30" alt="Telecharger PDF" /></a></td>
					</tr>
                    <?
						} // foreach ($pdo_sql01  as $key_sql01  => $pdo_lignes_sql01) {
					} // if (count($pdo_sql01) > 0) {
						
					require_once('DENG_Liste_Type_01.php');
					?>
				</table>
            <? #} //if ($_SESSION['VG_Pnom'] == 'apons') { ?>
                
                
                
            <? } else { //if (($_SESSION['VG_Mdp_OK'] == "OUI") and ($_SESSION['VG_droits_DENGT'] =="Oui")){ 
            		require_once('VerifLdapForm.php');
             } //if (($_SESSION['VG_Mdp_OK'] == "OUI") and ($_SESSION['VG_droits_DENGT'] =="Oui")){ ?>
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
				
	$("#val_Ardt_choisi").change(function(){

        var selectedArdt = $(this).children("option:selected").val();
//alert("You have selected the country - " + selectedArdt);
		$.ajax({
			url : 'DENG_00_ajax.php',
			type : 'POST',
			data : 'v_ajax=PnomArdt' + '&v_ardt_dem=' + selectedArdt,
			dataType : 'html',
			success : function(code_html_retour, statut){
				$('#val_pnom_choisi').replaceWith(code_html_retour);
				  $("#val_pnom_choisi").change(function(){
					  var selectedPnom = $(this).children("option:selected").val();
					  if (selectedPnom != '?') {
					  	$("#LancerDem").show();
					  } else {
						 $("#LancerDem").hide(); 
					  }
				  });
			},
		});
    });
	
				  $("#val_pnom_choisi").change(function(){
					  var selectedPnom = $(this).children("option:selected").val();
					  if (selectedPnom != '?') {
					  	$("#LancerDem").show();
					  } else {
						 $("#LancerDem").hide(); 
					  }
				  });
	
	$( "#Bt_lanc_dem" ).click(function() {
 		$( "#Dem_DENGT" ).submit();
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
	$("a.fancy_no_reload").fancybox({
				'width' : 600,
				'height' : 600,
				'autoScale'         : false,
				'transitionIn'      : 'fade',
				'speedIn'			: 900,
				'transitionOut'     : 'fade',
				'speedOut'			: 600,
				'type'              : 'iframe' 
	});
});


//////////////////////////////////////////////////////////
//--------------- Fonctions javascript interface -------------------
/////////////////////////////////////////////////////////

//--></script>

<!-- ######################################################################################## -->
<!-- ######################  FIN JAVA SCRIPT  ############################################### -->
<!-- ######################################################################################## -->