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

$_SESSION['VG_Applicatif'] = "Travaux > Demande d'engagements";
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

	//$('select#FormX_N_01_019_Annule_O_N').selectmenu({style:'dropdown', width: 80, maxHeight: 200});
	$("select#FormX_N_01_019_Annule_O_N").jqxDropDownList({ width: 80, height: 20, autoDropDownHeight: true });
	if( $('#FormX_N_01_020_Type_BT').length ) { // pour tester si il existe
		$("select#FormX_N_01_020_Type_BT").jqxDropDownList({ width: 150, height: 20, autoDropDownHeight: true });
	}
	//$("select#FormX_N_06_002_Id_N_05Label1").jqxDropDownList({ width: 150, height: 20, autoDropDownHeight: true });
	$("#FormX_N_06_002_Id_N_05Label2").jqxDropDownList({ checkboxes: true, width: 600, height: 20, autoDropDownHeight: true, placeHolder: "Aucun"});
	$("#FormX_N_06_002_Id_N_05Label3").jqxDropDownList({ checkboxes: true, width: 600, height: 20, autoDropDownHeight: true, placeHolder: "Aucun"});
	//$("select#FormX_N_01_015_Diffusion_O_N").jqxDropDownList({ width: 80, height: 20, autoDropDownHeight: true });
	
	
	
	
	
	$("#FormX_N_06_002_Id_N_05Label2").jqxDropDownList('uncheckAll');
	var tot= t_pdo_05.length; // t_pdo_05 generer avec la requette pdo_05
	//console.log(tot);
	for (var i=0; i < tot; i++) {
		//console.log(t_pdo_05[i]);
		$("#FormX_N_06_002_Id_N_05Label2").jqxDropDownList('checkItem', t_pdo_05[i] );
	}
	//console.log(t_pdo_05);
	$("#N_06_002_Id_N_05Label2").val(t_pdo_05);
	$("#FormX_N_06_002_Id_N_05Label2").on('checkChange', function (event) {
		if (event.args) {
			//console.log(event.args);
			//console.log(event.args.value);
			if (event.args.value) {
				if (event.args.checked) {
					//console.log('coche '+event.args.value);
					t_pdo_05.push(event.args.value);
				} else {
					//console.log('decoche '+event.args.value);
					t_pdo_05.splice(t_pdo_05.indexOf(event.args.value),1) 
				}
				$("#N_06_002_Id_N_05Label2").val(t_pdo_05);
			}
		}
	});
	
	
	$("#FormX_N_06_002_Id_N_05Label3").jqxDropDownList('uncheckAll');
	var tot2= t_pdo_06.length; // t_pdo_05 generer avec la requette pdo_06
	//console.log(tot2);
	for (var i=0; i < tot2; i++) {
		//console.log(t_pdo_06[i]);
		$("#FormX_N_06_002_Id_N_05Label3").jqxDropDownList('checkItem', t_pdo_06[i] );
	}
	//console.log(t_pdo_05);
	$("#N_06_002_Id_N_05Label3").val(t_pdo_06);
	$("#FormX_N_06_002_Id_N_05Label3").on('checkChange', function (event) {
		if (event.args) {
			//console.log(event.args);
			//console.log(event.args.value);
			if (event.args.value) {
				if (event.args.checked) {
					//console.log('coche '+event.args.value);
					t_pdo_06.push(event.args.value);
				} else {
					//console.log('decoche '+event.args.value);
					t_pdo_06.splice(t_pdo_06.indexOf(event.args.value),1) 
				}
				$("#N_06_002_Id_N_05Label3").val(t_pdo_06);
			}
		}
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