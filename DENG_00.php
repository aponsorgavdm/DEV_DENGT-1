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
	<link rel="stylesheet" href="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/styles/jqx.highcontrast.css" type="text/css" />
	<link rel="stylesheet" href="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/styles/jqx.darkblue.css" type="text/css" />
	<link rel="stylesheet" href="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/styles/jqx.fresh.css" type="text/css" />

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
    
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxwindow.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxinput.js"></script>
    <script type="text/javascript" src="<? echo $chemin_to_racine ?>_Jquery/jqwidgets_v4_5_4/jqxtextarea.js"></script>
    

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
				
				
		if (isset($_GET['v_voir'])) {
			$v_voir=$_GET['v_voir'];
		} else {
			$v_voir = 'profil';
		}
		if($v_voir == 'profil') {
			$v_titreBtVoir = 'Tout Voir';
			$v_image_voir = 'folder_search_tout_32_32';
		} else {
			$v_titreBtVoir = 'Voir selon mon profil';
			$v_image_voir = 'folder_search_32_32';
		}
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
            
			<table style="border: 0px solid; background-color:rgba(0, 0, 0, 0); padding: 0px; width:1200px; margin-left:auto; margin-right:auto; font-size: 12px;color: #666666;">
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
              	<td style="height: 32px; vertical-align: middle; background-color:rgba(0, 0, 0, 0);">&nbsp;<strong>Faire une Demande : </strong></td>
              <?
				$t_list_ardt_autorise = explode("_",$_SESSION['VG_droits_DENGT_Ardt']);
				$v_showhide_LancerDem = "none";
				if (count($t_list_ardt_autorise) == 1) { ?>
					<td style="height: 64px; background-color:rgba(0, 0, 0, 0);">
                        <fieldset style="border:0; font-size: 12px;">&nbsp;<strong>Ardt :</strong>
                              <select name="val_Ardt_choisi" id="val_Ardt_choisi">
                                  <option value="?">Choisir</option>
                                  <option value="<? echo $_SESSION['VG_droits_DENGT_Ardt'];?>" selected="selected" ><? echo $_SESSION['VG_droits_DENGT_Ardt'];?></option>
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
                    <fieldset style="border:0; font-size: 12px;">
                      &nbsp;<strong>Bénéficiare :</strong>
                      <select name="val_pnom_choisi" id="val_pnom_choisi">
                          <option value="?">Choisir</option>
                          <option value="<? echo $_SESSION['VG_Pnom'];?>" selected="selected" ><? echo $_SESSION['VG_Pnom'];?></option>
                      </select>
                  </fieldset>
                </td>
                <? } else { //if ($_SESSION['VG_droits_DENGT_profil'] == "DEM") { ?>
                    <? if (count($t_list_ardt_autorise) == 1) { 
                        $sql = "Select Id_Agent from agent_dgabc_2 where Id_Service Like '".$_SESSION['VG_Srv']."' and Valide_O_N = 'O'";
                        $pdo_result = $connUtil->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                    
                    ?>
                        <td colspan="2" style="background-color:rgba(0, 0, 0, 0);">
                            <fieldset style="border:0; font-size: 12px;">&nbsp;<strong>Bénéficiare :</strong>
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
                                  <option value="?" selected="selected" >Choisir</option>
                              </select>
                          </fieldset>
                        </td>
                    <? } //if (count($t_list_ardt_autorise) == 1) { ?>
                
                <? } //if ($_SESSION['VG_droits_DENGT_profil'] == "DEM") { ?>
                <td colspan="2" style="background-color:rgba(0, 0, 0, 0); text-align: left;height: 32px; vertical-align: middle;"  valign="middle" >
                    <div id="LancerDem" style="font-size: 12px;color: #666666;display:<? echo $v_showhide_LancerDem; ?>;">
                    <img src="images/list_add2_32_32.png" width="32" height="32" class="rollove" title="Etablir Nvlle Demande" id="Bt_lanc_dem" />
                    </div>
                </td>
                <td style="background-color:rgba(0, 0, 0, 0); text-align: left;height: 32px; vertical-align: middle;"  valign="middle" >
                 <img src="images/<? echo $v_image_voir; ?>.png" width="32" height="32" class="rollove" title="<? echo $v_titreBtVoir; ?>" id="Bt_Voir" />
                 </td>
              </tr>
            </table>
            </form>
            <br />
            <div id="divPourJqxgrid">
			<?			
            require_once('DENG_Liste_Type_01.php');
            ?>
            </div> <!--<div id="divPourJqxgrid">-->   
                
                
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
//--------------------------------------------------------------------
//--------------------- fonction create pour growl -------------------
function create( template, vars, opts ){
	return $container.notify("create", template, vars, opts);
}

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
	
	var QuoiVoir = "<? echo $v_voir; ?>";
	$( "#Bt_Voir" ).click(function() {
		if (QuoiVoir == 'profil') {
			QuoiVoir = 'tout';
		} else {
			QuoiVoir = 'profil';
		}
		console.log(QuoiVoir);
		window.location.href = 'DENG_00.php?v_voir='+QuoiVoir;
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