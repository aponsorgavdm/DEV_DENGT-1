<script>

//////////////////////////////////////////////////////////
//--------------- Fonctions javascript traitement -------------------
/////////////////////////////////////////////////////////
	 
	function check_input_MtDem() {
		var Mt_dem = document.getElementById("input_MtDem").value;
		Mt_dem = Mt_dem.replace(',', '.');
		if ($.isNumeric(Mt_dem)) {
			if (Mt_dem > 0 ) {
				document.getElementById("input_MtDem").value=Mt_dem;
				$("#expandCompta").jqxExpander({ disabled: false });
				var Rvp_selected = document.getElementById("val_SelectRevisable").value;
				if (Rvp_selected == 'Oui') {
					console.log('input_TauxRvp :'+document.getElementById("input_TauxRvp").value);
					var v_tauxRvp =document.getElementById("input_TauxRvp").value;
					v_tauxRvp = v_tauxRvp.replace(',', '.');
					if (v_tauxRvp > 0) {
						var MtCalcRvp = Math.abs((v_tauxRvp-1) * Mt_dem);
						MtCalcRvp = MtCalcRvp.toFixed(2);
						//console.log('MtCalcRvp :'+MtCalcRvp);
						var code_html_retour_manuel = '<td width="142" bgcolor="#FFFFFF" align="left" height="32" style="font-size: 12px;color: #CC6633;visibility: visible;" id="tdAlertRvp">&nbsp;:&nbsp;'+MtCalcRvp+'</td>';
						$('#tdAlertRvp').replaceWith(code_html_retour_manuel);
					} // if (v_tauxRvp > 0) {
				} else {
					//alert('pas de calcul Mt RVP');
				}
				
				if( document.getElementById("input_IdCtr").value != '?') {
					var mtdispo_ctr = document.getElementById("MtDispoCtr").value;
					mtdispo_ctr = mtdispo_ctr.replace(',', '.');
					mtdispo_ctr = mtdispo_ctr.replace(' ', '');
					mtdispo_ctr = mtdispo_ctr*1;
					//alert('verif '+Mt_dem+' inf a dispo' + mtdispo_ctr) ;
					//alert($("#SelectType_TVA").val());
					if ($("#SelectHtTTC").val() == "TTC") {
						var coefTVA = 1+(($("#SelectType_TVA").val())/100);
					} else {
						var coefTVA = 1;
					}
					if ((Mt_dem / coefTVA) > mtdispo_ctr) {
						$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Le Montant de la demande est supérieur<br>au montant disponible.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
						document.getElementById("input_MtDem").value = "0,00";
					}
				} else {
					//alert('pas de ctr selectionné');
				}
			} else { // if (Mt_dem > 0 )) {
				$("#expandCompta").jqxExpander({ disabled: true });
				$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Le Montant de la demande est à 0,00.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
			} // if (Mt_dem > 0 )) {
		} else { // if ($.isNumeric(Mt_dem)) 
			$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Le Montant de la demande "'+Mt_dem+'" est incorrect.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
			document.getElementById("input_MtDem").value='0,00';
		} // if ($.isNumeric(Mt_dem)) 
		//////////////
		//
		//		test pour mise à jour avancement
		//
		///////////// 
		if ((document.getElementById("input_MtDem").value > 0) && (document.getElementById("input_DateDebTRX").value != '00/00/0000') && (document.getElementById("val_dateFinCtr").value != '00/00/0000')) {
			$('#DENGT_Avanc_2').attr('src','images/Etapes/Etape_DENGT_2_Vert.png') ;
			VerifFinEtape();
		} else {
			$('#DENGT_Avanc_2').attr('src','images/Etapes/Etape_DENGT_2_gris.png') ;
			$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
			$("#show_Bt_enreg").hide();
		}
	};
	
	function check_input_TauxRvp() {
		var Taux_Rvp = document.getElementById("input_TauxRvp").value;
		Taux_Rvp = Taux_Rvp.replace(',', '.');
		if ($.isNumeric(Taux_Rvp)) {
			if (Taux_Rvp > 0 ) {
				document.getElementById("input_TauxRvp").value=Taux_Rvp;
				var Mt_dem_val = document.getElementById("input_MtDem").value;
				Mt_dem_val = Mt_dem_val.replace(',', '.');
				if (Mt_dem_val > 0) {
					var Rvp_selected = document.getElementById("val_SelectRevisable").value;
					if (Rvp_selected == 'Oui') {
						//console.log('input_TauxRvp :'+document.getElementById("input_TauxRvp").value);
						if (Taux_Rvp > 0) {
							var MtCalcRvp = Math.abs((Taux_Rvp-1) * Mt_dem_val);
							MtCalcRvp = MtCalcRvp.toFixed(2);
							//console.log('MtCalcRvp :'+MtCalcRvp);
							var code_html_retour_manuel = '<td width="142" bgcolor="#FFFFFF" align="left" height="32" style="font-size: 12px;color: #CC6633;visibility: visible;" id="tdAlertRvp">&nbsp;:&nbsp;'+MtCalcRvp+'</td>';
							$('#tdAlertRvp').replaceWith(code_html_retour_manuel);
						} // if (v_tauxRvp > 0) {
					} else {
						//alert('pas de calcul Mt RVP');
					}
				} else {
					//alert('pas de calcul Mt RVP');
					$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Le Montant de la demande est à 0,00. le calcul ne la RVP ne peut etre effectué.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
				}
			} else { // if (Mt_dem > 0 )) {
				$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Le Taux de la Rvp est à 0,00.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
			} // if (Mt_dem > 0 )) {
		} else { // if ($.isNumeric(Mt_dem)) 
			$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Le Taux Rvp "'+Taux_Rvp+'" est incorrect.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
			document.getElementById("input_TauxRvp").value='0,00';
		} // if ($.isNumeric(Mt_dem)) 
	};
	
	function check_input_LibTrx() {
		//////////////
		//
		//		test pour mise à jour avancement
		//
		///////////// 
		if ((document.getElementById("input_LibTrx").value != '') && (document.getElementById("input_LieuTrx").value != '')) {
			$('#DENGT_Avanc_3').attr('src','images/Etapes/Etape_DENGT_3_Vert.png') ;
			VerifFinEtape();
		} else {
			$('#DENGT_Avanc_3').attr('src','images/Etapes/Etape_DENGT_3_gris.png') ;
			$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
			$("#show_Bt_enreg").hide();
		}
	};
	
	function check_input_LieuTrx() {
		//////////////
		//
		//		test pour mise à jour avancement
		//
		///////////// 
		if ((document.getElementById("input_LibTrx").value != '') && (document.getElementById("input_LieuTrx").value != '')) {
			$('#DENGT_Avanc_3').attr('src','images/Etapes/Etape_DENGT_3_Vert.png') ;
			VerifFinEtape();
		} else {
			$('#DENGT_Avanc_3').attr('src','images/Etapes/Etape_DENGT_3_gris.png') ;
			$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
			$("#show_Bt_enreg").hide();
		}
	};
	
	
	
	//---------------- tester input_LibTrx
	//
	// test 1 input_LibTrx dif de ""
	// tester si input_LibTrx <> "" et input_LieuTrx <> ""  si oui passer #DENGT_Avanc_3 en images/Etapes/Etape_DENGT_3_Vert.png" et tester si tout est vert
	//
	//---------------- tester input_LieuTrx
	//
	// test 1 input_LieuTrx dif de ""
	// tester si input_LibTrx <> "" et input_LieuTrx <> ""  si oui passer #DENGT_Avanc_3 en images/Etapes/Etape_DENGT_3_Vert.png" et tester si tout est vert
	
	
	
	
	
//////////////////////////////////////////////////////////
//--------------- Fonctions javascript interface -------------------
/////////////////////////////////////////////////////////



//--------------------------------------------------------------------
//--------------------- fonction create pour growl -------------------
function create( template, vars, opts ){
	return $container.notify("create", template, vars, opts);
}
//--------------------------------------------------------------------
//--------------------- FIN fonction create pour growl ---------------

function roue(){
	$('#right').addClass('NoShow');
	$('#RoueAttente').replaceWith('<div id="RoueAttente"  class="Attent"><br><img src="images/attente_37_39.gif" width="37" height="39" align="absmiddle" /></div>');
}

function VerifFinEtape() {
	if ($('#DENGT_Avanc_1').attr('src') == "images/Etapes/Etape_DENGT_1_Vert.png") {
		if ($('#DENGT_Avanc_2').attr('src') == "images/Etapes/Etape_DENGT_2_Vert.png") {
			if ($('#DENGT_Avanc_3').attr('src') == "images/Etapes/Etape_DENGT_3_Vert.png") {
				if ($('#DENGT_Avanc_4').attr('src') == "images/Etapes/Etape_DENGT_4_Vert.png") {
					$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_Vert.png') ;
					$("#show_Bt_enreg").show();
				} else {
					$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
					$("#show_Bt_enreg").hide();
				}
			} else {
				$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
				$("#show_Bt_enreg").hide();
			}
		} else {
			$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
			$("#show_Bt_enreg").hide();
		}
	} else {
		$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
		$("#show_Bt_enreg").hide();
	}
}

Date.prototype.addDays = function(days) { 
	// On récupère le jour du mois auquel on ajoute le nombre de jour passé en paramètre
	var day = this.getDate()+days;
	// On définit le jour du mois (This représente la date sur laquelle on effectue l'opération)
	this.setDate(day);
}
Date.prototype.addMonth = function(mois) { 
	// On récupère le jour du mois auquel on ajoute le nombre de jour passé en paramètre
	var mois = this.getMonth()+mois;
	// On définit le jour du mois (This représente la date sur laquelle on effectue l'opération)
	this.setMonth(mois);
}
// utilisation
// var Mydate = new date("2019-01-01");
// Mydate.addDays(2);

function datUTCtoMysql(myDate){
	var TempMois = myDate.getUTCMonth()+1;
	TempMois = TempMois.toString().padStart(2, '0');
	var tempjour = myDate.getUTCDate();
	tempjour = tempjour.toString().padStart(2, '0');
	mydatSql = myDate.getFullYear()+"-"+TempMois+"-"+tempjour;
	return mydatSql;
}

function datMysqltoUTC(myDate){
	var t_datJava = myDate.split('-');
	var datJava = t_datJava[0]+","+(t_datJava[1]-1)+","+t_datJava[2];
	//console.log('datJava : '+datJava);
	//var myDate = new Date(Date.UTC(2019,1,27)); // fevrier
	//var myDate = new Date(Date.UTC(2019,11,30)); // decembre
	//var myDate = new Date(Date.UTC(2020,1,27)); // bissextile
	var mydatUTC = new Date(Date.UTC(t_datJava[0],(t_datJava[1]-1),t_datJava[2])); // -1 car les mois de javascript commencent à 0 (fevrier = 1,....)
	return mydatUTC;
}

function diffdate(d1,d2){
	var WNbJours = d2.getTime() - d1.getTime();
	return Math.ceil(WNbJours/(1000*60*60*24));
}


//////////////////////////////////////////////////
//--------------------- jquery -------------------
//////////////////////////////////////////////////

$(document).ready(function(){
	
	//$.jqx.theme = 'black';

	//---------------------------------------------------------------------------------------
	//---------------------  container growl ------------------------------------------------
	
		//-------------------- containerGrowlErr0 --------------------
		$containerGrowlErr0_Auto = $("#containerGrowlErr0_Auto").notify();
		$containerGrowlErr0_Manu = $("#containerGrowlErr0_Manu").notify();
	
	//--------------------- FIN container growl ---------------------------------------------
	//--------------------------------------------------------------------------------------- ValidLoup
	
	$("#input_MtDem").focus(function() { 
		//alert("change");
		$("#DivMipDetail").hide();
		$("#Textejustifdepas").hide();
		$("#DivDepasMip").hide();
		$("#DivComptaOP").hide();
		document.getElementById("input_DepasMip").value='N';
		document.getElementById("input_Mt_Depas").value='0';
		
					$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_Gris.png') ;
					$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
					VerifFinEtape();
		
	});
	
	//////////////////////////////////////////////////
	//--------------------- test click sur $("#expandCompta").jqxExpander -------------------
	//////////////////////////////////////////////////
	$("#expandCompta").click(function(){
		disabled = $('#expandCompta').jqxExpander('disabled');
		if (disabled) {
			//alert("out");
			$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Saisir au minimum le Montant de votre demande pour pouvoir renseigner la partie comptable'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
		}
	});
	
	
	//////////////////////////////////////////////////
	//--------------------- input_DateDuree -------------------
	//////////////////////////////////////////////////
	
	$("#input_DateDuree").on('change', function() {
	//---------------- tester input_DateDuree
	//
	// test 1 input_DateDuree > 0
	// test 2 input_DateDebTRX different de 00/00/0000
	// calcul input_DateFinTRX
	// test 3 input_DateFinTRX < date fin ctr + x mois si non input_DateFinTRX == 00/00/0000 et input_DateDuree == 0
	// tester si input_MtDem > 0 et input_DateDebTRX dif de 00/00/000 et  input_DateFinTRX dif de 00/00/000 si oui passer #DENGT_Avanc_2 en images/Etapes/Etape_DENGT_2_Vert.png" et tester si tout est vert
	//
	
		var code_html_retour_manuel = '<td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;" id="tdAlertDate">&nbsp;</td>';
		$('#tdAlertDate').replaceWith(code_html_retour_manuel);
		
		var DatDebTrx = document.getElementById("input_DateDebTRX").value;
		DatDebTrx = DatDebTrx.split('/');
		DatDebTrx = DatDebTrx.reverse().join('-');
		var DatFinTrx = document.getElementById("input_DateFinTRX").value;
		DatFinTrx = DatFinTrx.split('/');
		DatFinTrx = DatFinTrx.reverse().join('-');
		var DureeTrx = document.getElementById("input_DateDuree").value;
		DureeTrx = Math.round(DureeTrx);
		var DebutCtr = document.getElementById("val_dateDebCtr").value;
		var FinCtr = document.getElementById("val_dateFinCtr").value;
		
		var FinCtrProlongJava = datMysqltoUTC(FinCtr);
		FinCtrProlongJava.addMonth(3);
		var FinCtrProlongMysql = datUTCtoMysql(FinCtrProlongJava);
		
		/*
		console.log('DatDebTrx : '+DatDebTrx);
		console.log('DatFinTrx : '+DatFinTrx);
		console.log('DureeTrx : '+DureeTrx);
		console.log('DebutCtr : '+DebutCtr);
		console.log('FinCtr : '+FinCtr);
		console.log('FinCtrProlongMysql : '+FinCtrProlongMysql);
		*/
	
		if (DureeTrx > 0) {
			if (DatDebTrx != '0000-00-00') {
				var temp1 = datMysqltoUTC(DatDebTrx);
				//console.log('datMysqltoUTC : '+temp1);
				temp1.addDays(DureeTrx);
				var DatFinTrx = datUTCtoMysql(temp1);
				//console.log('datUTCtoMysql : '+temp2);
				DatFinTrx = DatFinTrx.split('-');
				DatFinTrx = DatFinTrx.reverse().join('/');
				//console.log('DatFinTrx : '+DatFinTrx);
				document.getElementById("input_DateFinTRX").value=DatFinTrx;
				DatFinTrx = DatFinTrx.split('/');
				DatFinTrx = DatFinTrx.reverse().join('-');
				//console.log('DatFinTrx : '+DatFinTrx);
				if (DatFinTrx <= FinCtrProlongMysql) {
					// tout est OK 
				} else { // if (DatFinTrx > FinCtrProlongMysql) {
					$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('La date de Fin des Trx est supérieure à la date de FIN PROLONGEE du marché.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
					var code_html_retour_manuel = '<td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 10px;color: #FF0000;" id="tdAlertDate">&nbsp;<strong><i>Fin Trx Suppérieure à<br> Fin Marché + 3 mois<i></strong></td>';
					$('#tdAlertDate').replaceWith(code_html_retour_manuel);
				} // if (DatFinTrx > FinCtrProlongMysql) {
			} // if (DatDebTrx != '0000-00-00') {
		} // if (DureeTrx > 0) {
		
		//////////////
		//
		//		test pour mise à jour avancement
		//
		///////////// 
		if ((document.getElementById("input_MtDem").value > 0) && (document.getElementById("input_DateDebTRX").value != '00/00/0000') && (document.getElementById("input_DateFinTRX").value != '00/00/0000')) {
			$('#DENGT_Avanc_2').attr('src','images/Etapes/Etape_DENGT_2_Vert.png') ;
			VerifFinEtape();
		} else {
			$('#DENGT_Avanc_2').attr('src','images/Etapes/Etape_DENGT_2_gris.png') ;
			$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
			$("#show_Bt_enreg").hide();
		}
	});
	//////////////////////////////////////////////////
	//--------------------- FIN input_DateDuree -------------------
	//////////////////////////////////////////////////
	
	
	
	//////////////////////////////////////////////////
	//--------------------- input_DateFinTRX -------------------
	//////////////////////////////////////////////////
	
	$("#input_DateFinTRX").on('change', function() {
	//--------------- tester input_DateFinTRX
	//
	// test 1 input_DateFinTRX < date fin ctr + x mois
	// test 2 si input_DateDebTRX diff de 00/00/0000 tester input_DateFinTRX >= input_DateDebTRX
	// calculer input_DateDuree
	//
	// tester si input_MtDem > 0 et input_DateDebTRX dif de 00/00/000 et  input_DateFinTRX dif de 00/00/000 si oui passer #DENGT_Avanc_2 en images/Etapes/Etape_DENGT_2_Vert.png" et tester si tout est vert
	
		var code_html_retour_manuel = '<td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;" id="tdAlertDate">&nbsp;</td>';
		$('#tdAlertDate').replaceWith(code_html_retour_manuel);
		
		var DatDebTrx = document.getElementById("input_DateDebTRX").value;
		DatDebTrx = DatDebTrx.split('/');
		DatDebTrx = DatDebTrx.reverse().join('-');
		var DatFinTrx = document.getElementById("input_DateFinTRX").value;
		DatFinTrx = DatFinTrx.split('/');
		DatFinTrx = DatFinTrx.reverse().join('-');
		var DureeTrx = document.getElementById("input_DateDuree").value;
		DureeTrx = Math.round(DureeTrx);
		var DebutCtr = document.getElementById("val_dateDebCtr").value;
		var FinCtr = document.getElementById("val_dateFinCtr").value;
		
		var FinCtrProlongJava = datMysqltoUTC(FinCtr);
		FinCtrProlongJava.addMonth(3);
		var FinCtrProlongMysql = datUTCtoMysql(FinCtrProlongJava);
		
		/*
		console.log('DatDebTrx : '+DatDebTrx);
		console.log('DatFinTrx : '+DatFinTrx);
		console.log('DureeTrx : '+DureeTrx);
		console.log('DebutCtr : '+DebutCtr);
		console.log('FinCtr : '+FinCtr);
		console.log('FinCtrProlongMysql : '+FinCtrProlongMysql);
		*/
		
		//var temp1 = datMysqltoUTC(DebutCtr);
		//console.log('datMysqltoUTC : '+temp1);
		//temp1.addMonth(3);
		//var temp2 = datUTCtoMysql(temp1);
		//console.log('datUTCtoMysql : '+temp2);

		if (DatFinTrx >= DebutCtr) {
			if (DatDebTrx != '0000-00-00') {
				if ( DatFinTrx >= DatDebTrx) {
					var DatDebTrxJava = datMysqltoUTC(DatDebTrx);
					var DatFinTrxJava = datMysqltoUTC(DatFinTrx);
					DureeTrx = diffdate(DatDebTrxJava,DatFinTrxJava);
					if (DureeTrx == 0) {
						DureeTrx = 1;
					}
					//console.log(DureeTrx);
					document.getElementById("input_DateDuree").value=DureeTrx;
					if (DatFinTrx <= FinCtrProlongMysql) {
						// tout est OK 
					} else { // if (DatFinTrx > FinCtrProlongMysql) {
						$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('La date de Fin des Trx est supérieure à la date de FIN PROLONGEE du marché.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
						var code_html_retour_manuel = '<td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 10px;color: #FF0000;" id="tdAlertDate">&nbsp;<strong><i>Fin Trx Suppérieure à<br> Fin Marché + 3 mois<i></strong></td>';
						$('#tdAlertDate').replaceWith(code_html_retour_manuel);
					} // if (DatFinTrx > FinCtrProlongMysql) {
				} else { // if (DatDebTrx <= DatFinTrx) {
					$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('La date de Fin des trx ne peut etre inférieure à la date de Début des Trx.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
					document.getElementById("input_DateFinTRX").value='00/00/0000';
					document.getElementById("input_DateDuree").value='0';
				} // if (DatDebTrx <= DatFinTrx) {
			} else { // if (DatFinTrx != '0000-00-00') {
				$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Veuillez saisir la date de début des TRX.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
				document.getElementById("input_DateFinTRX").value='00/00/0000';
				document.getElementById("input_DateDuree").value='0';
			} // if (DatFinTrx != '0000-00-00') {
		} else { // f (DatDebTrx >= DebutCtr) {
			$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('La date de Fin des Trx ne peut etre inférieure à la date de Debut du marché.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
			document.getElementById("input_DateFinTRX").value='00/00/0000';
			document.getElementById("input_DateDuree").value='0';
		} // f (DatDebTrx >= DebutCtr) {
			
		//////////////
		//
		//		test pour mise à jour avancement
		//
		///////////// 
		if ((document.getElementById("input_MtDem").value > 0) && (document.getElementById("input_DateDebTRX").value != '00/00/0000') && (document.getElementById("input_DateFinTRX").value != '00/00/0000')) {
			$('#DENGT_Avanc_2').attr('src','images/Etapes/Etape_DENGT_2_Vert.png') ;
			VerifFinEtape();
		} else {
			$('#DENGT_Avanc_2').attr('src','images/Etapes/Etape_DENGT_2_gris.png') ;
			$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
			$("#show_Bt_enreg").hide();
		}
	});
	//////////////////////////////////////////////////
	//--------------------- FIN input_DateFinTRX -------------------
	//////////////////////////////////////////////////
	
	//////////////////////////////////////////////////
	//--------------------- input_DateDebTRX -------------------
	//////////////////////////////////////////////////
	
	$("#input_DateDebTRX").on('change', function() {
	//--------------- tester input_DateDebTRX
	// 
	// test 1 input_DateDebTRX >= date debut ctr
	// test 2 input_DateDebTRX <= date fin ctr
	// test 3 si input_DateFinTRX diff de 00/00/0000 tester si input_DateDebTRX <= input_DateFinTRX
	// tester si input_MtDem > 0 et input_DateDebTRX dif de 00/00/000 et  input_DateFinTRX dif de 00/00/000 si oui passer #DENGT_Avanc_2 en images/Etapes/Etape_DENGT_2_Vert.png" et tester si tout est vert
	//
	
		var code_html_retour_manuel = '<td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;" id="tdAlertDate">&nbsp;</td>';
		$('#tdAlertDate').replaceWith(code_html_retour_manuel);
		
		var DatDebTrx = document.getElementById("input_DateDebTRX").value;
		DatDebTrx = DatDebTrx.split('/');
		DatDebTrx = DatDebTrx.reverse().join('-');
		var DatFinTrx = document.getElementById("input_DateFinTRX").value;
		DatFinTrx = DatFinTrx.split('/');
		DatFinTrx = DatFinTrx.reverse().join('-');
		var DureeTrx = document.getElementById("input_DateDuree").value;
		DureeTrx = Math.round(DureeTrx);
		var DebutCtr = document.getElementById("val_dateDebCtr").value;
		var FinCtr = document.getElementById("val_dateFinCtr").value;
		
		var FinCtrProlongJava = datMysqltoUTC(FinCtr);
		FinCtrProlongJava.addMonth(3);
		var FinCtrProlongMysql = datUTCtoMysql(FinCtrProlongJava);
		
		/*
		console.log('DatDebTrx : '+DatDebTrx);
		console.log('DatFinTrx : '+DatFinTrx);
		console.log('DureeTrx : '+DureeTrx);
		console.log('DebutCtr : '+DebutCtr);
		console.log('FinCtr : '+FinCtr);
		console.log('FinCtrProlongMysql : '+FinCtrProlongMysql);
		*/
		
		//var temp1 = datMysqltoUTC(DebutCtr);
		//console.log('datMysqltoUTC : '+temp1);
		//temp1.addMonth(3);
		//var temp2 = datUTCtoMysql(temp1);
		//console.log('datUTCtoMysql : '+temp2);

		if (DatDebTrx >= DebutCtr) {
			if (DatDebTrx <= FinCtr) {
				if (DatFinTrx != '0000-00-00') {
					if (DatDebTrx <= DatFinTrx) { 
						var DatDebTrxJava = datMysqltoUTC(DatDebTrx);
						var DatFinTrxJava = datMysqltoUTC(DatFinTrx);
						DureeTrx = diffdate(DatDebTrxJava,DatFinTrxJava);
						//console.log(DureeTrx);
						document.getElementById("input_DateDuree").value=DureeTrx;
						if (DatFinTrx <= FinCtrProlongMysql) {
							// tout est OK
						} else { // if (DatFinTrx > FinCtrProlongMysql) {
							$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('La date de Fin des Trx est supérieure à la date de FIN PROLONGEE du marché.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
							var code_html_retour_manuel = '<td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 10px;color: #FF0000;" id="tdAlertDate">&nbsp;<strong><i>Fin Trx Suppérieure à<br> Fin Marché + 3 mois<i></strong></td>';
							$('#tdAlertDate').replaceWith(code_html_retour_manuel);
						} // if (DatFinTrx > FinCtrProlongMysql) {
					} else { // if (DatDebTrx <= DatFinTrx) {
						$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('La date de début des trx ne peut etre supérieure à la date de fin des Trx.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
						document.getElementById("input_DateDebTRX").value='00/00/0000';
						document.getElementById("input_DateDuree").value='0';
					} // if (DatDebTrx <= DatFinTrx) {
				} else { // if (DatFinTrx != '0000-00-00') {
					if (DureeTrx > 0) {
						var temp1 = datMysqltoUTC(DatDebTrx);
						//console.log('datMysqltoUTC : '+temp1);
						temp1.addDays(DureeTrx);
						var DatFinTrx = datUTCtoMysql(temp1);
						//console.log('datUTCtoMysql : '+temp2);
						DatFinTrx = DatFinTrx.split('-');
						DatFinTrx = DatFinTrx.reverse().join('/');
						//console.log('DatFinTrx : '+DatFinTrx);
						document.getElementById("input_DateFinTRX").value=DatFinTrx;
						if (DatFinTrx <= FinCtrProlongMysql) {
							// tout est OK 
						} else { // if (DatFinTrx > FinCtrProlongMysql) {
							$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('La date de Fin des Trx est supérieure à la date de FIN PROLONGEE du marché.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
							var code_html_retour_manuel = '<td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 10px;color: #FF0000;" id="tdAlertDate">&nbsp;<strong><i>Fin Trx Suppérieure à<br> Fin Marché + 3 mois<i></strong></td>';
							$('#tdAlertDate').replaceWith(code_html_retour_manuel);
						} // if (DatFinTrx > FinCtrProlongMysql) {
					} else { // if (DureeTrx > 0) {
						// rien à faire pour le moment pas de date de fin ni de duree
					} // if (DureeTrx > 0) {
				} // if (DatFinTrx != '0000-00-00') {
			} else { // if (DatDebTrx <= DebutCtr) {
				$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('La date de début des Trx ne peut etre supérieure à la date de Fin du marché.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
				document.getElementById("input_DateDebTRX").value='00/00/0000';
				document.getElementById("input_DateDuree").value='0';
			} // if (DatDebTrx <= DebutCtr) {
		} else { // f (DatDebTrx >= DebutCtr) {
			$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('La date de début des Trx ne peut etre inférieure à la date de début du marché.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
			document.getElementById("input_DateDebTRX").value='00/00/0000';
			document.getElementById("input_DateDuree").value='0';
		} // f (DatDebTrx >= DebutCtr) {
			
		//////////////
		//
		//		test pour mise à jour avancement
		//
		///////////// 
		if ((document.getElementById("input_MtDem").value > 0) && (document.getElementById("input_DateDebTRX").value != '00/00/0000') && (document.getElementById("input_DateFinTRX").value != '00/00/0000')) {
			$('#DENGT_Avanc_2').attr('src','images/Etapes/Etape_DENGT_2_Vert.png') ;
			VerifFinEtape();
		} else {
			$('#DENGT_Avanc_2').attr('src','images/Etapes/Etape_DENGT_2_gris.png') ;
			$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
			$("#show_Bt_enreg").hide();
		}
	});
	//////////////////////////////////////////////////
	//--------------------- FIN input_DateDebTRX -------------------
	//////////////////////////////////////////////////
	
	
	//////////////////////////////////////////////////
	//--------------------- BT image valid Form -------------------
	//////////////////////////////////////////////////
	$("#click_Bt_enreg").on('click', function() {
		////////////////////
		//
		//		a mettre quand enreg mysql de la dem et liste des dem effectuée , mettre la redirection en fin de 
		//
		///////////////////
		
		$("#Enreg_DENGT").submit();
		/*
		////////////////////
		//
		//		a lever quand enreg mysql de la dem et liste des dem effectuée
		//
		///////////////////
		var copi_data = $('#Enreg_DENGT').serialize();
		//console.log(copi_data);
		var id_dem_retour = "vide";
		$.ajax({
		   url: 'DENGT_02_Enreg_Dem.php',                           // Any URL
		   data: copi_data,                 // Serialize the form data
		   success: function (data) {                        // If 200 OK
			  //alert('Success response: ' + data);
			  id_dem_retour = data;
			  //alert(id_dem_retour);
				var tempwin = window.open('http://10.6.192.41/dirca/DENG_02_Crea_PDF_Dem.php?'+copi_data, '_blank');
				setTimeout(function(){ tempwin.close();window.location.href = 'DENG_00.php';}, 5000);
				//window.location.href = 'DENG_00.php';
				
		   }
		});
		*/		
	});
	
	//////////////////////////////////////////////////
	//--------------------- BT image annul -------------------
	//////////////////////////////////////////////////
	$("#click_Bt_annu").on('click', function() {
		window.location.href = 'DENG_00.php';
		
	});
	
	//////////////////////////////////////////////////
	//--------------------- BT switch email -------------------
	//////////////////////////////////////////////////
	//$("#SwitchMail").jqxSwitchButton({ width: 70, height: 25, checked: false, onLabel: 'Oui', offLabel: 'Non'});
	//$('#SwitchMail').on('checked', function (event) {
		//document.getElementById("SuiviMail").value = 'N';
	//});
	//$('#SwitchMail').on('unchecked', function (event) {
		//document.getElementById("SuiviMail").value = 'O';
	//});
			
	//////////////////////////////////////////////////
	//--------------------- BT image ValidMarche -------------------
	//////////////////////////////////////////////////
	$("#ValidMarche").on('click', function() {
		// remise à zero des zones
		$("#SelectType_CTR").jqxDropDownList('selectIndex', 0);
		var code_html_retour_manuel = '<td colspan="2" bgcolor="#FFFFFF" id="AfficheCEMbc">&nbsp;</td>';
		$('#AfficheCEMbc').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;" id="AfficheConso">&nbsp;<i>info conso marche<i></td>';
		$('#AfficheConso').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;" id="AfficheConso2">&nbsp;</td>';
		$('#AfficheConso2').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<tr id="AfficheDateCtr"><td colspan="2" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;">&nbsp;<i>date debut marche<i></td><td colspan="4" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;">&nbsp;<i>date fin marche<i></td><td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;">&nbsp;</td></tr>';
		$('#AfficheDateCtr').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td colspan="7" align="left" bgcolor="#FFFFFF" height="22" style="font-size: 12px;color: #FF9933;" id="AfficheLibCTR">&nbsp;<input name="input_IdCtr" id="input_IdCtr" type="hidden" value="?" /></td>';
		$('#AfficheLibCTR').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td colspan="7" align="left" bgcolor="#FFFFFF" height="32" id="AfficheLibTiers">&nbsp;<input name="SelectNumTiers" id="SelectNumTiers" type="hidden" value="?" /></td>';
		$('#AfficheLibTiers').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;" id="tdAlertDate">&nbsp;</td>';
		$('#tdAlertDate').replaceWith(code_html_retour_manuel);
		
		$('#DENGT_Avanc_1').attr('src','images/Etapes/Etape_DENGT_1_gris.png') ;
		$('#DENGT_Avanc_2').attr('src','images/Etapes/Etape_DENGT_2_gris.png') ;
		$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
		$("#show_Bt_enreg").hide();
		
		$("#tdDateDebTrx").css("visibility", "hidden");
		$("#input_DateDebTRX").val('00/00/0000');
		$("#tdDateFinTrx").css("visibility", "hidden");
		$("#input_DateFinTRX").val('00/00/0000');
		$("#tdDateDurTrx").css("visibility", "hidden");
		$("#input_DateDuree").val('0');
		
		$("#SelectRevisable").jqxDropDownList('selectIndex', 0);
		$("#val_SelectRevisable").val('Non');
		$("#input_TauxRvp").val('0,00');
		$("#tdTextRvp").css("visibility", "hidden");
		$("#tdTauxRvp").css("visibility", "hidden");
		$("#tdMtRvp").css("visibility", "hidden");
		$("#tdAlertRvp").css("visibility", "hidden");
		$("#tdSelectRevisable").css("visibility", "hidden");
			//console.log('ann ' + document.getElementById("input_ExCtr").value);
			//console.log('num ' + document.getElementById("input_NumCtr").value);
			//console.log('long ' + document.getElementById("input_NumCtr").value.length);
		if ((document.getElementById("input_ExCtr").value != '') && (document.getElementById("input_NumCtr").value != '99999') && (document.getElementById("input_NumCtr").value.length != 0)) {
			if ((document.getElementById("input_ExCtr").value.length == 4) && (document.getElementById("input_NumCtr").value.length < 6)) {
				var Ex_ctr = document.getElementById("input_ExCtr").value;
				var Num_Ctr = document.getElementById("input_NumCtr").value;
				//console.log('Ex_ctr _' + Ex_ctr+'_');
				//console.log('Num_Ctr ' + Num_Ctr);
				if ($.isNumeric(Ex_ctr)) {
					if ($.isNumeric(Num_Ctr)) {
						var val_D_000 = Ex_ctr+"_"+Num_Ctr;
						//console.log('val_D_000 ' + val_D_000);
						$.ajax({
							url : 'DENG_02_01_crea_dem_ajax.php',
							type : 'POST',
							data : 'v_ajax=ValidMarche' + '&v_D_000=' + val_D_000,
							dataType : 'html',
							success : function(code_html_retour, statut){
								var code_html_retour_part = code_html_retour.split('$$_$$_$$');
								//console.log('part 0 '+code_html_retour_part[0]);
								//console.log('part 1 '+code_html_retour_part[1]);
								//console.log('part 2 '+code_html_retour_part[2]);
								//console.log('part 3 '+code_html_retour_part[3]);
								//console.log('part 4 '+code_html_retour_part[4]);
								//console.log('part 5 '+code_html_retour_part[5]);
								//console.log('part 6 '+code_html_retour_part[6]);
								$('#AfficheLibCTR').replaceWith(code_html_retour_part[0]);
								$('#AfficheLibTiers').replaceWith(code_html_retour_part[2]);
								if ($.trim(code_html_retour_part[1]) == 'v_select') {
									$("select#SelectNumTiers").jqxDropDownList({ width: 800, height: 22, dropDownWidth: 800, dropDownHorizontalAlignment: 'left', autoDropDownHeight: true });
									$("#SelectNumTiers").on('select', function (event) {
										var args = event.args;
										var lign = $('#SelectNumTiers').jqxDropDownList('getItem', args.index);
										var val_DE_016 = lign.label.split('_');
										//console.log('val_DE_016 '+val_DE_016[0]);
										var val_DE_000 = document.getElementById("input_IdCtr").value;
										var val_DE_001 = val_DE_000.split('_');
										//console.log('val_DE_000 '+$('#input_IdCtr').val());
										//console.log('val_DE_000 '+val_DE_000);
										//console.log('val_DE_017 '+val_DE_001[0]);
										//console.log('val_DE_018 '+val_DE_001[1]);
										$.ajax({
											url : 'DENG_02_01_crea_dem_ajax.php',
											type : 'POST',
											data : 'v_ajax=SelectNumTiers' + '&v_DE_016=' + val_DE_016[0] + '&v_DE_017=' + val_DE_001[0] + '&v_DE_018=' + val_DE_001[1],
											dataType : 'html',
											success : function(code_html_retour, statut){
												$('#AfficheConso2').replaceWith(code_html_retour);
												document.getElementById("input_MtDem").value = "0,00";
											},
										});
									});
								};
								$('#AfficheConso').replaceWith(code_html_retour_part[3]);
								$('#AfficheConso2').replaceWith(code_html_retour_part[4]);
								document.getElementById("input_MtDem").value = "0,00";
								$('#AfficheDateCtr').replaceWith(code_html_retour_part[5]);
								$('#DENGT_Avanc_1').replaceWith(code_html_retour_part[6]);
								$("#input_DateDebTRX").val('00/00/0000');
								$("#input_DateFinTRX").val('00/00/0000');
								$("#input_DateDuree").val('0');		
								
								
								
								// teste les valeurs des etapes pour afficher le valid en vert
								var v_src_1 = $('#DENGT_Avanc_1').attr('src');
								//console.log('v_src_1 '+v_src_1);
								if ($('#DENGT_Avanc_1').attr('src') == "images/Etapes/Etape_DENGT_1_Vert.png") {
									$("#tdDateDebTrx").css("visibility", "visible");
									$("#tdDateFinTrx").css("visibility", "visible");
									$("#tdDateDurTrx").css("visibility", "visible");
									$("#tdSelectRevisable").css("visibility", "visible");
									VerifFinEtape();
								} else {
		
									$("#tdDateDebTrx").css("visibility", "hidden");
									$("#input_DateDebTRX").val('00/00/0000');
									$("#tdDateFinTrx").css("visibility", "hidden");
									$("#input_DateFinTRX").val('00/00/0000');
									$("#tdDateDurTrx").css("visibility", "hidden");
									$("#input_DateDuree").val('0');
									
									$("#SelectRevisable").jqxDropDownList('selectIndex', 0);
									$("#val_SelectRevisable").val('Non');
									$("#input_TauxRvp").val('0,00');
									$("#tdTextRvp").css("visibility", "hidden");
									$("#tdTauxRvp").css("visibility", "hidden");
									$("#tdMtRvp").css("visibility", "hidden");
									$("#tdAlertRvp").css("visibility", "hidden");
									$("#tdSelectRevisable").css("visibility", "hidden");
									$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
									$("#show_Bt_enreg").hide();
								}
							},
						});
					} else { // if Number.isInteger(Num_Ctr) {
						$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('N° Marché : erroné.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
					} // if Number.isInteger(Num_Ctr) {
				} else { // if Number.isInteger(Ex_ctr) {
					$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Année Marché : erroné.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
				} // if Number.isInteger(Ex_ctr) {
			} else { // if ((document.getElementById("input_ExCtr").value.length == 4) && (document.getElementById("input_NumCtr").value.length < 6)) {
				$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Marché : Année ou N° erroné.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
			} // if ((document.getElementById("input_ExCtr").value.length == 4) && (document.getElementById("input_NumCtr").value.length < 6)) {
		} else { // if ((document.getElementById("input_ExCtr").value != '') && (document.getElementById("input_NumCtr").value != '99999') && (document.getElementById("input_NumCtr").value.length != 0)) {
			$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Marché : Année ou N° non renseigné.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
		} // if ((document.getElementById("input_ExCtr").value != '') && (document.getElementById("input_NumCtr").value != '99999') && (document.getElementById("input_NumCtr").value.length != 0)) {
	});
	//////////////////////////////////////////////////
	//--------------------- FIN BT image valid ctr -------------------
	//////////////////////////////////////////////////
	
	//////////////////////////////////////////////////
	//--------------------- BT image valid OPI -------------------
	//////////////////////////////////////////////////
	$("#ValidOPI").on('click', function() {
		// remise à zero des zones
		var code_html_retour_manuel = '<div id="LibOpi">&nbsp;<i>lib opx<i></div>';
		$('#LibOpi').replaceWith(code_html_retour_manuel);
		
		if ((document.getElementById("input_ExOPI").value != '') && (document.getElementById("input_TypOPI").value != '') && (document.getElementById("input_NumOPI").value != '')) {
			if ((document.getElementById("input_ExOPI").value.length == 4) && (document.getElementById("input_NumOPI").value.length == 4)) {
				var Ex_OPI = document.getElementById("input_ExOPI").value;
				var Num_OPI = document.getElementById("input_NumOPI").value*1;
				var Typ_OPI = document.getElementById("input_TypOPI").value;
				//console.log('Ex_ctr _' + Ex_ctr+'_');
				//console.log('Num_Ctr ' + Num_Ctr);
				if ($.isNumeric(Ex_OPI)) {
					if ($.isNumeric(Num_OPI)) {
						var val_F_000_Id_Ope = Ex_OPI+" - "+Typ_OPI+" - "+Num_OPI;
						//console.log('val_D_000 ' + val_D_000);
						$.ajax({
							url : 'DENG_02_01_crea_dem_ajax.php',
							type : 'POST',
							data : 'v_ajax=ValidOPI' + '&v_F_000_Id_Ope=' + val_F_000_Id_Ope,
							dataType : 'html',
							success : function(code_html_retour, statut){
								var code_html_retour_part = code_html_retour.split('$$_$$_$$');
								$('#LibOpi').replaceWith(code_html_retour_part[0]);
								if (code_html_retour_part[1] == 'OpiTrouv') {
									$('#DivConsoOPI').replaceWith(code_html_retour_part[2]);
									$("#DivConsoOPI").show();
									$("#DivComptaOP").show();
									$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_Vert.png') ;
									VerifFinEtape();
									$('#DivComptaOP').replaceWith(code_html_retour_part[3]);
									$("select#SelectIbOpi").jqxDropDownList({ width: 900, height: 22, autoDropDownHeight: true });
									$("select#SelectResaOpi").jqxDropDownList({ width: 900, height: 22, autoDropDownHeight: true });
									$("#DivComptaOP").show();
								} else {
									$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('N° OPI Non Trouvée.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
									$("#DivConsoOPI").hide();
									$("#DivComptaOP").hide();
									$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_gris.png') ;
									VerifFinEtape();
								}
							},
						});
					} else { // if Number.isInteger(Num_OPI) {
						$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('N° OPI : erroné.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
						$("#DivConsoOPI").hide();
						$("#DivComptaOP").hide();
						$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_gris.png') ;
						VerifFinEtape();
					} // if Number.isInteger(Num_OPI) {
				} else { // if Number.isInteger(Ex_OPI) {
					$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Année OPI : erroné.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
					$("#DivConsoOPI").hide();
					$("#DivComptaOP").hide();
					$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_gris.png') ;
					VerifFinEtape();
				} // if Number.isInteger(Ex_OPI) {
			} else { // if ((document.getElementById("input_ExOPI").value.length == 4) && (document.getElementById("input_NumOPI").value.length == 4)) {
				$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('OPI : Année ou N° erroné.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
				$("#DivConsoOPI").hide();
				$("#DivComptaOP").hide();
				$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_gris.png') ;
				VerifFinEtape();
			} // if ((document.getElementById("input_ExOPI").value.length == 4) && (document.getElementById("input_NumOPI").value.length == 4)) {
		} else { // if ((document.getElementById("input_ExOPI").value != '') && (document.getElementById("input_TypOPI").value != '') && (document.getElementById("input_NumOPI").value != '')) {
			$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('OPI : mal renseignée.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
			$("#DivConsoOPI").hide();
			$("#DivComptaOP").hide();
			$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_gris.png') ;
			VerifFinEtape();
		} // if ((document.getElementById("input_ExOPI").value != '') && (document.getElementById("input_TypOPI").value != '') && (document.getElementById("input_NumOPI").value != '')) {
	});
	//////////////////////////////////////////////////
	//--------------------- FIN BT image valid OPI -------------------
	//////////////////////////////////////////////////
	
	//////////////////////////////////////////////////
	//--------------------- BT image Loupe Ctr -------------------
	//////////////////////////////////////////////////
	$("#ValidLoup").on('click', function() {
		// remise à zero des zones
		$("#SelectType_CTR").jqxDropDownList('selectIndex', 0);
		var code_html_retour_manuel = '<td colspan="2" bgcolor="#FFFFFF" id="AfficheCEMbc">&nbsp;</td>';
		$('#AfficheCEMbc').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;" id="AfficheConso">&nbsp;<i>info conso marche<i></td>';
		$('#AfficheConso').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;" id="AfficheConso2">&nbsp;</td>';
		$('#AfficheConso2').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<tr id="AfficheDateCtr"><td colspan="2" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;">&nbsp;<i>date debut marche<i></td><td colspan="4" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;">&nbsp;<i>date fin marche<i></td><td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;">&nbsp;</td></tr>';
		$('#AfficheDateCtr').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td colspan="7" align="left" bgcolor="#FFFFFF" height="22" style="font-size: 12px;color: #FF9933;" id="AfficheLibCTR">&nbsp;<input name="input_IdCtr" id="input_IdCtr" type="hidden" value="?" /></td>';
		$('#AfficheLibCTR').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td colspan="7" align="left" bgcolor="#FFFFFF" height="32" id="AfficheLibTiers">&nbsp;<input name="SelectNumTiers" id="SelectNumTiers" type="hidden" value="?" /></td>';
		$('#AfficheLibTiers').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;" id="tdAlertDate">&nbsp;</td>';
		$('#tdAlertDate').replaceWith(code_html_retour_manuel);
		
		$('#DENGT_Avanc_1').attr('src','images/Etapes/Etape_DENGT_1_gris.png') ;
		$('#DENGT_Avanc_2').attr('src','images/Etapes/Etape_DENGT_2_gris.png') ;
		$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
		$("#show_Bt_enreg").hide();
		
		$("#tdDateDebTrx").css("visibility", "hidden");
		$("#input_DateDebTRX").val('00/00/0000');
		$("#tdDateFinTrx").css("visibility", "hidden");
		$("#input_DateFinTRX").val('00/00/0000');
		$("#tdDateDurTrx").css("visibility", "hidden");
		$("#input_DateDuree").val('0');
		
		$("#SelectRevisable").jqxDropDownList('selectIndex', 0);
		$("#val_SelectRevisable").val('Non');
		$("#input_TauxRvp").val('0,00');
		$("#tdTextRvp").css("visibility", "hidden");
		$("#tdTauxRvp").css("visibility", "hidden");
		$("#tdMtRvp").css("visibility", "hidden");
		$("#tdAlertRvp").css("visibility", "hidden");
		$("#tdSelectRevisable").css("visibility", "hidden");
		
		if ((document.getElementById("input_ExCtr").value != '') && (document.getElementById("input_NumCtr").value != '99999') && (document.getElementById("input_NumCtr").value.length != 0)) {
			if ((document.getElementById("input_ExCtr").value.length == 4) && (document.getElementById("input_NumCtr").value.length < 6)) {
				var Ex_ctr = document.getElementById("input_ExCtr").value;
				var Num_Ctr = document.getElementById("input_NumCtr").value;
				//console.log('Ex_ctr _' + Ex_ctr+'_');
				//console.log('Num_Ctr ' + Num_Ctr);
				if ($.isNumeric(Ex_ctr)) {
					if ($.isNumeric(Num_Ctr)) {
						Num_Ctr = Num_Ctr*1;
						var val_D_000 = Ex_ctr+"_"+Num_Ctr;
						//console.log('val_D_000 ' + val_D_000);
						$.ajax({
							url : 'DENG_02_01_crea_dem_ajax.php',
							type : 'POST',
							data : 'v_ajax=ValidLoup' + '&v_D_000=' + val_D_000,
							dataType : 'html',
							success : function(code_html_retour, statut){
								//console.log(code_html_retour);
								if (code_html_retour != 'Erreur') {
								  $('#AfficheCEMbc').replaceWith(code_html_retour);
								  $("select#SelectList_CTR").jqxDropDownList({ width: 250, height: 22, autoDropDownHeight: true, dropDownWidth: 400, dropDownHorizontalAlignment: 'left' });
								  $("#SelectList_CTR").on('select', function (event) {
									  var args3 = event.args;
									  var lign3 = $("#SelectList_CTR").jqxDropDownList('getItem', args3.index);
									  var val_D_000 = lign3.value
									  $.ajax({
										  url : 'DENG_02_01_crea_dem_ajax.php',
										  type : 'POST',
										  data : 'v_ajax=ValidMarche' + '&v_D_000=' + val_D_000,
										  dataType : 'html',
										  success : function(code_html_retour, statut){
											  var code_html_retour_part = code_html_retour.split('$$_$$_$$');
											  //console.log('part 0 '+code_html_retour_part[0]);
											  //console.log('part 1 '+code_html_retour_part[1]);
											  //console.log('part 2 '+code_html_retour_part[2]);
											  //console.log('part 3 '+code_html_retour_part[3]);
											  //console.log('part 4 '+code_html_retour_part[4]);
											  //console.log('part 5 '+code_html_retour_part[5]);
											  //console.log('part 6 '+code_html_retour_part[6]);
											  $('#AfficheLibCTR').replaceWith(code_html_retour_part[0]);
											  $('#AfficheLibTiers').replaceWith(code_html_retour_part[2]);
											  if ($.trim(code_html_retour_part[1]) == 'v_select') {
												  $("select#SelectNumTiers").jqxDropDownList({ width: 800, height: 22, dropDownWidth: 800, dropDownHorizontalAlignment: 'left', autoDropDownHeight: true });
												  $("#SelectNumTiers").on('select', function (event) {
													  var args = event.args;
													  var lign = $('#SelectNumTiers').jqxDropDownList('getItem', args.index);
													  var val_DE_016 = lign.label.split('_');
													  console.log('val_DE_016 '+val_DE_016[0]);
													  var val_DE_000 = document.getElementById("input_IdCtr").value;
													  var val_DE_001 = val_DE_000.split('_');
													  //console.log('val_DE_000 '+$('#input_IdCtr').val());
													  //console.log('val_DE_000 '+val_DE_000);
													  //console.log('val_DE_017 '+val_DE_001[0]);
													  //console.log('val_DE_018 '+val_DE_001[1]);
													  $.ajax({
														  url : 'DENG_02_01_crea_dem_ajax.php',
														  type : 'POST',
														  data : 'v_ajax=SelectNumTiers' + '&v_DE_016=' + val_DE_016[0] + '&v_DE_017=' + val_DE_001[0] + '&v_DE_018=' + val_DE_001[1],
														  dataType : 'html',
														  success : function(code_html_retour, statut){
															  $('#AfficheConso2').replaceWith(code_html_retour);
															  document.getElementById("input_MtDem").value = "0,00";
														  },
													  });
												  });
											  };
											  $('#AfficheConso').replaceWith(code_html_retour_part[3]);
											  $('#AfficheConso2').replaceWith(code_html_retour_part[4]);
											  document.getElementById("input_MtDem").value = "0,00";
											  $('#AfficheDateCtr').replaceWith(code_html_retour_part[5]);
											  $('#DENGT_Avanc_1').replaceWith(code_html_retour_part[6]);
		  $("#input_DateDebTRX").val('00/00/0000');
		  $("#input_DateFinTRX").val('00/00/0000');
		  $("#input_DateDuree").val('0');
											  
											  
											  
											  // teste les valeurs des etapes pour afficher le valid en vert
											  var v_src_1 = $('#DENGT_Avanc_1').attr('src');
											  //console.log('v_src_1 '+v_src_1);
											  if ($('#DENGT_Avanc_1').attr('src') == "images/Etapes/Etape_DENGT_1_Vert.png") {
												  $("#tdDateDebTrx").css("visibility", "visible");
												  $("#tdDateFinTrx").css("visibility", "visible");
												  $("#tdDateDurTrx").css("visibility", "visible");
		  $("#tdSelectRevisable").css("visibility", "visible");
												  VerifFinEtape();
											  } else {
		  
												  $("#tdDateDebTrx").css("visibility", "hidden");
												  $("#input_DateDebTRX").val('00/00/0000');
												  $("#tdDateFinTrx").css("visibility", "hidden");
												  $("#input_DateFinTRX").val('00/00/0000');
												  $("#tdDateDurTrx").css("visibility", "hidden");
												  $("#input_DateDuree").val('0');
												  
												  $("#SelectRevisable").jqxDropDownList('selectIndex', 0);
												  $("#val_SelectRevisable").val('Non');
												  $("#input_TauxRvp").val('0,00');
												  $("#tdTextRvp").css("visibility", "hidden");
												  $("#tdTauxRvp").css("visibility", "hidden");
												  $("#tdMtRvp").css("visibility", "hidden");
												  $("#tdAlertRvp").css("visibility", "hidden");
												  $("#tdSelectRevisable").css("visibility", "hidden");
												  $('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
												  $("#show_Bt_enreg").hide();
											  }
										  },
									  });
									  
								  });
								} else { //if (code_html_retour != 'Erreur') {
									$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('N° Marché : non trouvé.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
								}//if (code_html_retour != 'Erreur') {
							},
						});	
					} else { // if Number.isInteger(Num_Ctr) {
						$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('N° Marché : erroné.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
					} // if Number.isInteger(Num_Ctr) {
				} else { // if Number.isInteger(Ex_ctr) {
					$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Année Marché : erroné.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
				} // if Number.isInteger(Ex_ctr) {
			} else { // if ((document.getElementById("input_ExCtr").value.length == 4) && (document.getElementById("input_NumCtr").value.length < 6)) {
				$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Marché : Année ou N° erroné.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
			} // if ((document.getElementById("input_ExCtr").value.length == 4) && (document.getElementById("input_NumCtr").value.length < 6)) {
		} else { // if ((document.getElementById("input_ExCtr").value != '') && (document.getElementById("input_NumCtr").value != '99999') && (document.getElementById("input_NumCtr").value.length != 0)) {
			$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Marché : Année ou N° non renseigné.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
		} // if ((document.getElementById("input_ExCtr").value != '') && (document.getElementById("input_NumCtr").value != '99999') && (document.getElementById("input_NumCtr").value.length != 0)) {
	});
	//////////////////////////////////////////////////
	//--------------------- FIN BT image Loupe Ctr -------------------
	//////////////////////////////////////////////////
	
	//////////////////////////////////////////////////
	//--------------------- SelectType_CTR -------------------
	//////////////////////////////////////////////////
	$("select#SelectType_CTR").jqxDropDownList({ width: 120, height: 22, autoDropDownHeight: true });
	$("#SelectType_CTR").on('select', function (event) {
		// remise à zero des zones
		var code_html_retour_manuel = '<td colspan="2" bgcolor="#FFFFFF" id="AfficheCEMbc">&nbsp;</td>';
		$('#AfficheCEMbc').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;" id="AfficheConso">&nbsp;<i>info conso marche<i></td>';
		$('#AfficheConso').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;" id="AfficheConso2">&nbsp;</td>';
		$('#AfficheConso2').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<tr id="AfficheDateCtr"><td colspan="2" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;">&nbsp;<i>date debut marche<i></td><td colspan="4" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;">&nbsp;<i>date fin marche<i></td><td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;">&nbsp;</td></tr>';
		$('#AfficheDateCtr').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td colspan="7" align="left" bgcolor="#FFFFFF" height="22" style="font-size: 12px;color: #FF9933;" id="AfficheLibCTR">&nbsp;<input name="input_IdCtr" id="input_IdCtr" type="hidden" value="?" /></td>';
		$('#AfficheLibCTR').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td colspan="7" align="left" bgcolor="#FFFFFF" height="32" id="AfficheLibTiers">&nbsp;<input name="SelectNumTiers" id="SelectNumTiers" type="hidden" value="?" /></td>';
		$('#AfficheLibTiers').replaceWith(code_html_retour_manuel);
		var code_html_retour_manuel = '<td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;" id="tdAlertDate">&nbsp;</td>';
		$('#tdAlertDate').replaceWith(code_html_retour_manuel);
		
		$('#DENGT_Avanc_1').attr('src','images/Etapes/Etape_DENGT_1_gris.png') ;
		$('#DENGT_Avanc_2').attr('src','images/Etapes/Etape_DENGT_2_gris.png') ;
		$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
		$("#show_Bt_enreg").hide();
		
		$("#tdDateDebTrx").css("visibility", "hidden");
		$("#input_DateDebTRX").val('00/00/0000');
		$("#tdDateFinTrx").css("visibility", "hidden");
		$("#input_DateFinTRX").val('00/00/0000');
		$("#tdDateDurTrx").css("visibility", "hidden");
		$("#input_DateDuree").val('0');
		
		$("#SelectRevisable").jqxDropDownList('selectIndex', 0);
		$("#val_SelectRevisable").val('Non');
		$("#input_TauxRvp").val('0,00');
		$("#tdTextRvp").css("visibility", "hidden");
		$("#tdTauxRvp").css("visibility", "hidden");
		$("#tdMtRvp").css("visibility", "hidden");
		$("#tdAlertRvp").css("visibility", "hidden");
		$("#tdSelectRevisable").css("visibility", "hidden");
		
		var args = event.args;
		var lign = $("#SelectType_CTR").jqxDropDownList('getItem', args.index);
		//console.log(lign.value);
		if (lign != null) {
			if ((lign.label == 'MBC Trx') || (lign.label == 'MBC Presta') || (lign.label == 'MBC Period')) {
				$.ajax({
					url : 'DENG_02_01_crea_dem_ajax.php',
					type : 'POST',
					data : 'v_ajax=SelectType_CTR' + '&v_item=' + lign.label,
					dataType : 'html',
					success : function(code_html_retour, statut){
						$('#AfficheCEMbc').replaceWith(code_html_retour);
						$("select#SelectCE_CTR").jqxDropDownList({ width: 250, height: 22, dropDownHeight: 350, dropDownWidth: 400, dropDownHorizontalAlignment: 'left' });
						$("#SelectCE_CTR").on('select', function (event) {
							// remise à zero des zones
							var code_html_retour_manuel = '<td height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;" id="AfficheConso">&nbsp;<i>info conso marche<i></td>';
							$('#AfficheConso').replaceWith(code_html_retour_manuel);
							var code_html_retour_manuel = '<td height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;" id="AfficheConso2">&nbsp;</td>';
							$('#AfficheConso2').replaceWith(code_html_retour_manuel);
							var code_html_retour_manuel = '<tr id="AfficheDateCtr"><td colspan="2" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;">&nbsp;<i>date debut marche<i></td><td colspan="4" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF9933;">&nbsp;<i>date fin marche<i></td><td width="142" height="32" bgcolor="#FFFFFF" align="center" style="font-size: 12px;color: #FF0000;">&nbsp;</td></tr>';
							$('#AfficheDateCtr').replaceWith(code_html_retour_manuel);
							var code_html_retour_manuel = '<td colspan="7" align="left" bgcolor="#FFFFFF" height="22" style="font-size: 12px;color: #FF9933;" id="AfficheLibCTR">&nbsp;<input name="input_IdCtr" id="input_IdCtr" type="hidden" value="?" /></td>';
							$('#AfficheLibCTR').replaceWith(code_html_retour_manuel);
							var code_html_retour_manuel = '<td colspan="7" align="left" bgcolor="#FFFFFF" height="32" id="AfficheLibTiers">&nbsp;<input name="SelectNumTiers" id="SelectNumTiers" type="hidden" value="?" /></td>';
							$('#AfficheLibTiers').replaceWith(code_html_retour_manuel);
							var code_html_retour_manuel = '<img id="DENGT_Avanc_1" src="images/Etapes/Etape_DENGT_1_gris.png" width="74" height="117" />';
							$('#DENGT_Avanc_1').replaceWith(code_html_retour_manuel);
							var code_html_retour_manuel = '<img id="DENGT_Avanc_2" src="images/Etapes/Etape_DENGT_2_gris.png" width="74" height="117" />';
							$('#DENGT_Avanc_2').replaceWith(code_html_retour_manuel);
							var code_html_retour_manuel = '<img id="DENGT_Avanc_5" src="images/Etapes/Etape_FIN_gris.png" width="74" height="117" />';
							$('#DENGT_Avanc_5').replaceWith(code_html_retour_manuel);
							$("#show_Bt_enreg").hide();

		
							$("#tdDateDebTrx").css("visibility", "hidden");
							$("#input_DateDebTRX").val('00/00/0000');
							$("#tdDateFinTrx").css("visibility", "hidden");
							$("#input_DateFinTRX").val('00/00/0000');
							$("#tdDateDurTrx").css("visibility", "hidden");
							$("#input_DateDuree").val('0');
							
							$("#SelectRevisable").jqxDropDownList('selectIndex', 0);
							$("#val_SelectRevisable").val('Non');
							$("#input_TauxRvp").val('0,00');
							$("#tdTextRvp").css("visibility", "hidden");
							$("#tdTauxRvp").css("visibility", "hidden");
							$("#tdMtRvp").css("visibility", "hidden");
							$("#tdAlertRvp").css("visibility", "hidden");
							$("#tdSelectRevisable").css("visibility", "hidden");
												
							var args2 = event.args;
							var lign2 = $("#SelectCE_CTR").jqxDropDownList('getItem', args2.index);
							$("#input_IdCtr").val('?');
							//console.log(lign2.value);
							if (lign2 != null) {
								$.ajax({
									url : 'DENG_02_01_crea_dem_ajax.php',
									type : 'POST',
									data : 'v_ajax=SelectCE_CTR' + '&v_item=' + lign2.value,
									dataType : 'html',
									success : function(code_html_retour, statut){
										$('#SelectList_CTR').replaceWith(code_html_retour);
										$("select#SelectList_CTR").jqxDropDownList({ width: 250, height: 22, dropDownHeight: 350, dropDownWidth: 400, dropDownHorizontalAlignment: 'left' });
										$("#SelectList_CTR").on('select', function (event) {
											var args3 = event.args;
											var lign3 = $("#SelectList_CTR").jqxDropDownList('getItem', args3.index);
											var val_D_000 = lign3.value
											$.ajax({
												url : 'DENG_02_01_crea_dem_ajax.php',
												type : 'POST',
												data : 'v_ajax=ValidMarche' + '&v_D_000=' + val_D_000,
												dataType : 'html',
												success : function(code_html_retour, statut){
													var code_html_retour_part = code_html_retour.split('$$_$$_$$');
													//console.log('part 0 '+code_html_retour_part[0]);
													//console.log('part 1 '+code_html_retour_part[1]);
													//console.log('part 2 '+code_html_retour_part[2]);
													//console.log('part 3 '+code_html_retour_part[3]);
													//console.log('part 4 '+code_html_retour_part[4]);
													//console.log('part 5 '+code_html_retour_part[5]);
													//console.log('part 6 '+code_html_retour_part[6]);
													$('#AfficheLibCTR').replaceWith(code_html_retour_part[0]);
													$('#AfficheLibTiers').replaceWith(code_html_retour_part[2]);
													if ($.trim(code_html_retour_part[1]) == 'v_select') {
														$("select#SelectNumTiers").jqxDropDownList({ width: 800, height: 22, dropDownWidth: 800, dropDownHorizontalAlignment: 'left', autoDropDownHeight: true });
														$("#SelectNumTiers").on('select', function (event) {
															var args = event.args;
															var lign = $('#SelectNumTiers').jqxDropDownList('getItem', args.index);
															var val_DE_016 = lign.label.split('_');
															console.log('val_DE_016 '+val_DE_016[0]);
															var val_DE_000 = document.getElementById("input_IdCtr").value;
															var val_DE_001 = val_DE_000.split('_');
															//console.log('val_DE_000 '+$('#input_IdCtr').val());
															//console.log('val_DE_000 '+val_DE_000);
															//console.log('val_DE_017 '+val_DE_001[0]);
															//console.log('val_DE_018 '+val_DE_001[1]);
															$.ajax({
																url : 'DENG_02_01_crea_dem_ajax.php',
																type : 'POST',
																data : 'v_ajax=SelectNumTiers' + '&v_DE_016=' + val_DE_016[0] + '&v_DE_017=' + val_DE_001[0] + '&v_DE_018=' + val_DE_001[1],
																dataType : 'html',
																success : function(code_html_retour, statut){
																	$('#AfficheConso2').replaceWith(code_html_retour);
																	document.getElementById("input_MtDem").value = "0,00";
																},
															});
														});
													};
													$('#AfficheConso').replaceWith(code_html_retour_part[3]);
													$('#AfficheConso2').replaceWith(code_html_retour_part[4]);
													document.getElementById("input_MtDem").value = "0,00";
													$('#AfficheDateCtr').replaceWith(code_html_retour_part[5]);
													$('#DENGT_Avanc_1').replaceWith(code_html_retour_part[6]);
													$("#input_DateDebTRX").val('00/00/0000');
													$("#input_DateFinTRX").val('00/00/0000');
													$("#input_DateDuree").val('0');
													var code_html_retour_manuel = '<img id="DENGT_Avanc_2" src="images/Etapes/Etape_DENGT_2_gris.png" width="74" height="117" />';
													$('#DENGT_Avanc_2').replaceWith(code_html_retour_manuel);
													var code_html_retour_manuel = '<img id="DENGT_Avanc_5" src="images/Etapes/Etape_FIN_gris.png" width="74" height="117" />';
													$('#DENGT_Avanc_5').replaceWith(code_html_retour_manuel);
													$("#show_Bt_enreg").hide();
													
													
													
													// teste les valeurs des etapes pour afficher le valid en vert
													var v_src_1 = $('#DENGT_Avanc_1').attr('src');
													//console.log('v_src_1 '+v_src_1);
													if ($('#DENGT_Avanc_1').attr('src') == "images/Etapes/Etape_DENGT_1_Vert.png") {
														$("#tdDateDebTrx").css("visibility", "visible");
														$("#tdDateFinTrx").css("visibility", "visible");
														$("#tdDateDurTrx").css("visibility", "visible");
		$("#tdSelectRevisable").css("visibility", "visible");
														VerifFinEtape();
													} else {
		
														$("#tdDateDebTrx").css("visibility", "hidden");
														$("#input_DateDebTRX").val('00/00/0000');
														$("#tdDateFinTrx").css("visibility", "hidden");
														$("#input_DateFinTRX").val('00/00/0000');
														$("#tdDateDurTrx").css("visibility", "hidden");
														$("#input_DateDuree").val('0');
														
														$("#SelectRevisable").jqxDropDownList('selectIndex', 0);
														$("#val_SelectRevisable").val('Non');
														$("#input_TauxRvp").val('0,00');
														$("#tdTextRvp").css("visibility", "hidden");
														$("#tdTauxRvp").css("visibility", "hidden");
														$("#tdMtRvp").css("visibility", "hidden");
														$("#tdAlertRvp").css("visibility", "hidden");
														$("#tdSelectRevisable").css("visibility", "hidden");
														$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
														$("#show_Bt_enreg").hide();
													}
												},
											});
											
										});
									},
								});	
							}
						});
					},
				});	
			} else { // if ((lign.label == 'MBC Trx') || (lign.label == 'MBC Presta') || (lign.label == 'MBC Period')) {
				var code_html_retour_manuel = '<td colspan="2" bgcolor="#FFFFFF" id="AfficheCEMbc">&nbsp;</td>';
				$('#AfficheCEMbc').replaceWith(code_html_retour_manuel);
			} // if ((lign.label == 'MBC Trx') || (lign.label == 'MBC Presta') || (lign.label == 'MBC Period')) {
		}
	});
	//////////////////////////////////////////////////
	//--------------------- FIN SelectType_CTR -------------------
	//////////////////////////////////////////////////
	
	//////////////////////////////////////////////////
	//--------------------- SelectTypeDep -------------------
	//////////////////////////////////////////////////
	$("select#SelectTypeDep").jqxDropDownList({ width: 130, height: 22, autoDropDownHeight: true });
	$("#SelectTypeDep").on('select', function (event) {
		var args = event.args;
		var lign = $("#SelectTypeDep").jqxDropDownList('getItem', args.index);
		if (lign != null) {
			if (lign.label == "Investissement") {
				$("#DivFonct").hide();
				$("#DivOPE").show();
				$("#showInvest").show();
				$("#radioInvest1").jqxRadioButton({ checked: true });
				$("#input_FoncInvest").val('OPA');
				$("#DivOPI").hide();
				$("#DivOPA").show();
				$("#DivMip").hide();
				$("#DivMipDetail").hide();
				$("#expandListMip").hide();
				$("#DivConsoOPI").hide();
				$("#DivDepasMip").hide();
				$("#DivComptaOP").hide();
				$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_gris.png') ;
				$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
				$("#show_Bt_enreg").hide();
					// -------------------------------------------------------------------------------------------------- gerer la partie OPE *********************
			} else {
				if (lign.label == "Fonctionnement") {
					$("#DivFonct").show();
					$("#showInvest").hide();
					$("#DivOPE").hide();
					//////////////
					//
					//		test pour mise à jour avancement
					//
					///////////// 
					$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_Vert.png') ;
					VerifFinEtape();
				} else {
					$("#showInvest").hide();
					$("#DivFonct").hide();
					$("#DivOPE").hide();
					$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_gris.png') ;
					$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
					$("#show_Bt_enreg").hide();
				}
			}
		}
	});
	//////////////////////////////////////////////////
	//--------------------- FIN SelectTypeDep -------------------
	//////////////////////////////////////////////////
	
	//////////////////////////////////////////////////
	//--------------------- SelectTypeBud -------------------
	//////////////////////////////////////////////////
	$("select#SelectTypeBud").jqxDropDownList({ width: 140, height: 22, autoDropDownHeight: true });
	$("#SelectTypeBud").on('select', function (event) {
		var args = event.args;
		var lign = $("#SelectTypeBud").jqxDropDownList('getItem', args.index);
		if (lign != null) {
			//console.log(args);
			var val_H_006=lign.value;
			//alert(lign.value);
			//alert('val_H_027_0_'+val_H_027[0]);
			//alert('val_H_027_1_'+val_H_027[1]);
			$.ajax({
				url : 'DENG_02_01_crea_dem_ajax.php',
				type : 'POST',
				data : 'v_ajax=SelectTypeBud' + '&v_H_006=' + val_H_006,
				dataType : 'html',
				success : function(code_html_retour, statut){
					$('#SelectIbNat').replaceWith(code_html_retour);
					$("select#SelectIbNat").jqxDropDownList({ width: 140, height: 22, dropDownHeight: 150, dropDownWidth: 500, dropDownHorizontalAlignment: 'left' });
					// ci dessous re generer le on select
						$("#SelectIbNat").on('select', function (event) {
							var args = event.args;
							var lign = $("#SelectIbNat").jqxDropDownList('getItem', args.index);
							if (lign != null) {
								var val_H_027=lign.label.split('-');
								//alert(lign.label);
								//alert('val_H_027_0_'+val_H_027[0]);
								//alert('val_H_027_1_'+val_H_027[1]);
								//console.log(lign);
								$.ajax({
									url : 'DENG_02_01_crea_dem_ajax.php',
									type : 'POST',
									data : 'v_ajax=SelectIbNat' + '&v_H_027=' + val_H_027[0] + '&v_H_006=' + val_H_006,
									dataType : 'html',
									success : function(code_html_retour, statut){
										$('#SelectIbFonc').replaceWith(code_html_retour);
										$("select#SelectIbFonc").jqxDropDownList({ width: 140, height: 22, dropDownHeight: 150, dropDownWidth: 500, dropDownHorizontalAlignment: 'left' });
									},
								});
								
							}
						});
				},
			});
			
		}
	});
	//////////////////////////////////////////////////
	//--------------------- FIN SelectTypeBud -------------------
	//////////////////////////////////////////////////
	
	//////////////////////////////////////////////////
	//--------------------- SelectIbNat -------------------
	//////////////////////////////////////////////////
	$("select#SelectIbNat").jqxDropDownList({ width: 140, height: 22, dropDownHeight: 150, dropDownWidth: 500, dropDownHorizontalAlignment: 'left' });
	$("#SelectIbNat").on('select', function (event) { // ne sert que pour le premier affichage sur budget 00, apres repris dans SelectTypeBud 
		var args = event.args;
		var lign = $("#SelectIbNat").jqxDropDownList('getItem', args.index);
		if (lign != null) {
			var val_H_027=lign.label.split('-');
			//alert(lign.label);
			//alert('val_H_027_0_'+val_H_027[0]);
			//alert('val_H_027_1_'+val_H_027[1]);
			$.ajax({
				url : 'DENG_02_01_crea_dem_ajax.php',
				type : 'POST',
				data : 'v_ajax=SelectIbNat' + '&v_H_027=' + val_H_027[0] + '&v_H_006=00',
				dataType : 'html',
				success : function(code_html_retour, statut){
					$('#SelectIbFonc').replaceWith(code_html_retour);
					$("select#SelectIbFonc").jqxDropDownList({ width: 140, height: 22, dropDownHeight: 150, dropDownWidth: 500, dropDownHorizontalAlignment: 'left' });
					//$("#SelectIbFonc").on('select', function (event) {
//						var args = event.args;
//						var lign = $("#SelectIbFonc").jqxDropDownList('getItem', args.index);
//						//alert("_"+lign+"_");
//						console.log(lign);
//					});
				},
			});
			
		}
	});
	//////////////////////////////////////////////////
	//--------------------- FIN SelectIbNat -------------------
	//////////////////////////////////////////////////
	
	//////////////////////////////////////////////////
	//--------------------- SelectRevisable -------------------
	//////////////////////////////////////////////////
	$("select#SelectRevisable").jqxDropDownList({ width: 80, height: 22, autoDropDownHeight: true });
	$("#SelectRevisable").on('select', function (event) {
		// remise à zero des zones
		$("#tdTextRvp").css("visibility", "hidden");
		$("#tdTauxRvp").css("visibility", "hidden");
		$("#tdMtRvp").css("visibility", "hidden");
		$("#tdAlertRvp").css("visibility", "hidden");
		$("#input_TauxRvp").val('0,00');
		
		var args = event.args;
		var lign = $("#SelectRevisable").jqxDropDownList('getItem', args.index);
		//console.log(lign.value);
		var val_id_Ctr = document.getElementById("input_IdCtr").value;
		//console.log(val_id_Ctr);
		if (val_id_Ctr != '?') {
			if (lign != null) {
				if (lign.value == 'Oui') {
					//----------------------------------------------------------------------------> ajax pour recherhce taux
					$("#tdTextRvp").css("visibility", "visible");
					$("#tdMtRvp").css("visibility", "visible");
					$("#tdAlertRvp").css("visibility", "visible");
					$.ajax({
						url : 'DENG_02_01_crea_dem_ajax.php',
						type : 'POST',
						data : 'v_ajax=SelectRevisable' + '&v_E1_001_id_Ctr=' + val_id_Ctr,
						dataType : 'html',
						success : function(code_html_retour, statut){
							var code_html_retour_part = code_html_retour.split('$$_$$_$$');
							//console.log(code_html_retour_part);
							if ($.trim(code_html_retour_part[0]) == 'NON') {
								$("#tdTauxRvp").css("visibility", "visible");
								var code_html_retour_manuel ='<td width="142" align="right" bgcolor="#E7E7E7" height="32" valign="middle" style="border-radius: 8px;-moz-border-radius: 8px;visibility: visible;" id="tdTauxRvp">&nbsp;<input name="input_TauxRvp" id="input_TauxRvp" type="text" size="10" style="border: 0; font-size: 14px;color: #666666;background-color:transparent; text-align:right" value="0,00" onclick="';
                        		code_html_retour_manuel = code_html_retour_manuel  + "javascript:if(document.getElementById('input_TauxRvp').value == '0,00') {document.getElementById('input_TauxRvp').value ='';};";
								code_html_retour_manuel = code_html_retour_manuel  + '" onfocus="';
								code_html_retour_manuel = code_html_retour_manuel  + "javascript:if(document.getElementById('input_TauxRvp').value == '0,00') {document.getElementById('input_TauxRvp').value ='';};";
								code_html_retour_manuel = code_html_retour_manuel  + '" onblur="check_input_TauxRvp();"/>&nbsp;</td>';
								$('#tdTauxRvp').replaceWith(code_html_retour_manuel);
								var code_html_retour_manuel = '<td width="142" bgcolor="#FFFFFF" align="left" height="32" style="font-size: 12px;color: #CC6633;visibility: visible;" id="tdAlertRvp">&nbsp;</td>';
								$('#tdAlertRvp').replaceWith(code_html_retour_manuel);
							} else { // if ($.trim(code_html_retour_part[0]) == 'NON') {
								var TauxRecup=$.trim(code_html_retour_part[1]);
								$("#tdTauxRvp").css("visibility", "visible");
								var code_html_retour_manuel = '<td colspan="2" height="32" bgcolor="#FFFFFF" align="left" style="font-size: 12px;color: #CC6633;visibility: visible;" id="tdTauxRvp">&nbsp;';
								code_html_retour_manuel = code_html_retour_manuel + '<input name="input_TauxRvp" id="input_TauxRvp" type="text" size="10" style="border: 0; font-size: 14px;color: #666666;background-color:transparent; text-align:right" value="'+TauxRecup+'"  readonly="readonly"></td>';
								$('#tdTauxRvp').replaceWith(code_html_retour_manuel);
								// calcul du Mt de RVP
								
								//console.log('TauxRecup :'+TauxRecup);
								var Mt_dem_val = document.getElementById("input_MtDem").value;
								Mt_dem_val = Mt_dem_val.replace(',', '.');
								Mt_dem_val = Mt_dem_val*1;
								//console.log('Mt_dem_val :'+Mt_dem_val);
								if (Mt_dem_val > 0) {
									var MtCalcRvp = Math.abs((TauxRecup-1) * Mt_dem_val);
									MtCalcRvp = MtCalcRvp.toFixed(2);
									//console.log('MtCalcRvp :'+MtCalcRvp);
									var code_html_retour_manuel = '<td width="142" bgcolor="#FFFFFF" align="left" height="32" style="font-size: 12px;color: #CC6633;visibility: visible;" id="tdAlertRvp">&nbsp;:&nbsp;'+MtCalcRvp+'</td>';
									$('#tdAlertRvp').replaceWith(code_html_retour_manuel);
								} else { // if (Mt_dem_val > 0) {
									var code_html_retour_manuel = '<td width="142" bgcolor="#FFFFFF" align="left" height="32" style="font-size: 12px;color: #CC6633;visibility: visible;" id="tdAlertRvp">&nbsp;NON calculé, Mt à 0.00</td>';
									$('#tdAlertRvp').replaceWith(code_html_retour_manuel);
								} // if (Mt_dem_val > 0) {
							} // if ($.trim(code_html_retour_part[0]) == 'NON') {
						},
					});
				} else { // if (lign.value == 'Oui') {
					//alert('non');
				} // if (lign.value == 'Oui') {
			} // if (lign != null) {
			$("#val_SelectRevisable").val(lign.value);	
		} else { // if (val_id_Ctr != '?') {
			$("#SelectRevisable").jqxDropDownList('selectIndex', 0);
			$("#val_SelectRevisable").val('?');
			//$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Il n\'y a pas de N° de Marché.'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
		} // if (val_id_Ctr != '?') {
		
	});
	//////////////////////////////////////////////////
	//--------------------- FIN SelectRevisable -------------------
	//////////////////////////////////////////////////
	
	//////////////////////////////////////////////////
	//--------------------- SelectExOPA -------------------
	//////////////////////////////////////////////////
	
	$("select#SelectEx_OPA").jqxDropDownList({ width: 140, height: 22, autoDropDownHeight: true });
	$("#SelectEx_OPA").on('select', function (event) {
		var args = event.args;
		var lign = $("#SelectEx_OPA").jqxDropDownList('getItem', args.index);
		if (lign != null) {
			//console.log(args);
			var val_F_013=lign.value;//ex OPE
			//alert(lign.value);
			//alert('val_H_027_0_'+val_H_027[0]);
			//alert('val_H_027_1_'+val_H_027[1]);
			$.ajax({
				url : 'DENG_02_01_crea_dem_ajax.php',
				type : 'POST',
				data : 'v_ajax=SelectExOPA' + '&v_F_013=' + val_F_013,
				dataType : 'html',
				success : function(code_html_retour, statut){
					$('#SelectNum_OPA').replaceWith(code_html_retour);
					$("select#SelectNum_OPA").jqxDropDownList({ width: 140, height: 22, dropDownHeight: 250, dropDownWidth: 500, dropDownHorizontalAlignment: 'left' });
					// ci dessous re generer le on select
						$("#SelectNum_OPA").on('select', function (event) {
							var args = event.args;
							var lign = $("#SelectNum_OPA").jqxDropDownList('getItem', args.index);
							if (lign != null) {
								$("#expandListMip").jqxExpander({ expanded: true });
								$('#Textejustifdepas').hide();
								$('#DivMipDetail').replaceWith('<div id="DivMipDetail" style="font-size: 14px;color: #666666;display:none;">DivMipDetail</div>');
								$("#DivMipDetail").hide();
								$("#DivDepasMip").hide();
								var val_F5_000=lign.value;// num OPE
								//alert(lign.value);
								//alert('val_H_027_0_'+val_H_027[0]);
								//alert('val_H_027_1_'+val_H_027[1]);
								//console.log(lign);
								$.ajax({
									url : 'DENG_02_01_crea_dem_ajax.php',
									type : 'POST',
									data : 'v_ajax=SelectNumOPA' + '&v_F5_000=' + val_F5_000,
									dataType : 'html',
									success : function(code_html_retour, statut){
										$('#DivMip').replaceWith(code_html_retour);
										$("#DivMip").show();
										$("#expandListMip").show();
										$(".SelectMip").mouseover(function(){
											$(this).closest('tr').css("background", "#CCCCCC");
											$(this).css("background", "#00CC00");
											//console.log(this);
										});
										$(".SelectMip").mouseout(function(){
											$(this).css("background", "#FFFFFF");
											$(".TrSelectMip").css("background", "#FFFFFF");
											$(this).closest('tr').css("background", "#FFFFFF");
										})
										$(".SelectMip"	).click(function(){
											var recupMip = $(this).attr('id');
											$("#expandListMip").jqxExpander({ expanded: false });
											var code_MIP_retour = recupMip.split('$'); 
											// $pdo_lignes_MIP['F5_131_Id_Niv_1']
											//."$".$pdo_lignes_MIP['F5_133_Id_Niv_2']
											//."$".$pdo_lignes_MIP['F5_135_Id_Niv_3']
											//."$".$t_num_mip[1]
											//."$".$pdo_Circ[0]
											//."$".$pdo_lignes_Engt['ENGT']
											//."$".$v_mt_dispo
											//."$".$pdo_lignes_MIP['F5_000_id_Ope
											console.log("*** "+code_MIP_retour);
											var v_ExMip = code_MIP_retour[0];
											var v_ArdtMip = code_MIP_retour[1];
											var v_NumMipF5_135 = code_MIP_retour[2]; // F5_131 = v_ExMip et F5_135 = NumMipF5_135
											var v_NumMipSeul = code_MIP_retour[3];
											var NumMipPourN_01 = v_ExMip+"_"+v_ArdtMip+"_"+v_NumMipSeul;
											var v_Mt_dans_circuit = code_MIP_retour[4];
											var v_Mt_Engage =  code_MIP_retour[5];
											var v_mt_dispo = code_MIP_retour[6];
											var v_F5_000 = code_MIP_retour[7];
											///////////////////////
											// recup info MIP
											///////////////////////
											$.ajax({
												url : 'DENG_02_01_crea_dem_ajax.php',
												type : 'POST',
												async : false,
												data : 'v_ajax=SelectNumMip' + '&v_ExMip=' + v_ExMip 
														+ '&v_NumMipF5_135=' + v_NumMipF5_135 + '&NumMipPourN_01=' + NumMipPourN_01 
														+ '&NumOpe_F5=' + v_F5_000 + '&v_Mt_dans_circuit=' + v_Mt_dans_circuit 
														+ '&v_Mt_Engage=' + v_Mt_Engage + '&v_mt_dispo=' + v_mt_dispo ,
												dataType : 'html',
												success : function(code_html_retour, statut){
													var code_html_retour_part = code_html_retour.split('$$_$$_$$');
													$('#DivMipDetail').replaceWith('<div id="DivMipDetail" style="font-size: 14px;color: #666666;display:none;">'+code_html_retour_part[0]+'</div>');
													$("#DivMipDetail").show();
													$('#DivComptaOP').replaceWith(code_html_retour_part[1]);
													$("select#SelectIbOpi").jqxDropDownList({ width: 900, height: 22, autoDropDownHeight: true });
													$("select#SelectResaOpi").jqxDropDownList({ width: 900, height: 22, autoDropDownHeight: true });
													$("#DivComptaOP").show();
													var ValPourcDepas = code_html_retour_part[2];
													var ValMtRevaloMip = code_html_retour_part[3];
													document.getElementById("input_ValPourcDepas").value = ValPourcDepas;
													document.getElementById("input_ValMtRevaloMip").value = ValMtRevaloMip;
													document.getElementById("input_NumMip").value = v_NumMipSeul;
												},
											});
											
											//alert("mt demande "+document.getElementById("input_MtDem").value);
											var MtDem_pour_Calcul = parseFloat(document.getElementById("input_MtDem").value);
											var ValPourcDepas = parseFloat(document.getElementById("input_ValPourcDepas").value); // exemple = 0.05 pour 5%
											var ValMtRevaloMip = parseFloat(document.getElementById("input_ValMtRevaloMip").value);
											v_mt_dispo = parseFloat(v_mt_dispo); 
											// // $v_mt_dispo = $pdo_lignes_MIP['F5_138_Mt_Reval']-$pdo_lignes_Engt['ENGT']-$pdo_Circ[0]; dans SelectNumMip de crea_dem_ajax
											// test sur Mt pour calcul depassement
											// si Mt dispo - Mt dem > 0 ok sinon 
											// si (Mt dispo + x% du Mt revalo) - Mt dem > 0 ok avec alerte % depas autorisé sinon Textejustifdepas
											if (v_mt_dispo - MtDem_pour_Calcul >= 0) {
												$("#DivDepasMip").hide();
												$("#Textejustifdepas").hide();
												document.getElementById("input_DepasMip").value='N';
												document.getElementById("input_Mt_Depas").value='0';	
					$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_Vert.png') ;
					VerifFinEtape();
											} else {
												//console.log("input_ValMtRevaloMip"+ValMtRevaloMip);
												//console.log("input_ValPourcDepas"+ValPourcDepas);
												//console.log("v_mt_dispo"+v_mt_dispo);
												//console.log("MtDem_pour_Calcul"+MtDem_pour_Calcul);
												//console.log(ValMtRevaloMip * ValPourcDepas );
												//console.log(((ValMtRevaloMip * ValPourcDepas )+ v_mt_dispo));
												//console.log(((ValMtRevaloMip * ValPourcDepas )+ v_mt_dispo) - MtDem_pour_Calcul);
												
												if (((ValMtRevaloMip * ValPourcDepas )+ v_mt_dispo) - MtDem_pour_Calcul >= 0) { // sup a dispo mais rentre dans % autorisé
													$('#DivDepasMip').replaceWith('<div id="DivDepasMip"><br>***** Le Montant demandé est supérieur au montant prévu mais entre dans le % de depassement autorisé<br></div>');
													$("#DivDepasMip").show();
													$("#Textejustifdepas").hide();
													document.getElementById("input_DepasMip").value='AJUST';
													if (v_mt_dispo < 0) {
														document.getElementById("input_Mt_Depas").value=MtDem_pour_Calcul;
													} else {
														document.getElementById("input_Mt_Depas").value=((ValMtRevaloMip * ValPourcDepas )+ v_mt_dispo) - MtDem_pour_Calcul;
													}
					$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_Vert.png') ;
					VerifFinEtape();
												} else {
													document.getElementById("input_DepasMip").value='IMP'; // par defaut le depassement est financé par imprevu
													if (v_mt_dispo < 0) {
														document.getElementById("input_Mt_Depas").value=MtDem_pour_Calcul;
													} else {
														document.getElementById("input_Mt_Depas").value=((ValMtRevaloMip * ValPourcDepas )+ v_mt_dispo) - MtDem_pour_Calcul;
													}
													$('#DivDepasMip').replaceWith('<div id="DivDepasMip"><br>***** Le Montant demandé est supérieur au montant prévu et n\'entre pas dans le % de depassement autorisé<br>***** Veuillez renseigner un mode de financement</div>');
													$("#DivDepasMip").show();
													//$('#Textejustifdepas').replaceWith('<div id="Textejustifdepas">Textejustifdepas '+recupMip+'</div>');
													$("#Textejustifdepas").show();
					$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_Vert.png') ;
					VerifFinEtape();
												}
											}
											
										}).css({'cursor':'pointer'});
									},
								});
//								
							}
						});
				},
			});
			
		}
	});
	
	//////////////////////////////////////////////////
	//--------------------- FIN SelectExOPA -------------------
	//////////////////////////////////////////////////
	
	
	//////////////////////////////////////////////////
	//--------------------- SelectEx_OPA_IMP -------------------
	//////////////////////////////////////////////////
	
	$("select#SelectEx_OPA_IMP").jqxDropDownList({ width: 140, height: 22, autoDropDownHeight: true });
	$("#SelectEx_OPA_IMP").on('select', function (event) {
		var args = event.args;
		var lign = $("#SelectEx_OPA_IMP").jqxDropDownList('getItem', args.index);
		if (lign != null) {
			//console.log(args);
			var val_F_013=lign.value;//ex OPE
			//alert(lign.value);
			//alert('val_H_027_0_'+val_H_027[0]);
			//alert('val_H_027_1_'+val_H_027[1]);
			$.ajax({
				url : 'DENG_02_01_crea_dem_ajax.php',
				type : 'POST',
				data : 'v_ajax=SelectEx_OPA_IMP' + '&v_F_013=' + val_F_013,
				dataType : 'html',
				success : function(code_html_retour, statut){
					$('#SelectNum_OPA_IMP').replaceWith(code_html_retour);
					$("select#SelectNum_OPA_IMP").jqxDropDownList({ width: 500, height: 22, dropDownHeight: 250, dropDownWidth: 500, dropDownHorizontalAlignment: 'left' });
					$("#SelectNum_OPA_IMP").on('select', function (event) {
						document.getElementById("input_DepasMip").value='IMP';
						document.getElementById("input_Mt_Depas").value='0';
						var v_Num_OPA_Imp = $("#SelectNum_OPA_IMP").val();
						$('#DivDepasMip').replaceWith('<div id="DivDepasMip"><br>***** Travaux Imprevus sur l\'OPA : '+v_Num_OPA_Imp+'</div>');
						$("#DivDepasMip").show();
						
						
						$.ajax({
							url : 'DENG_02_01_crea_dem_ajax.php',
							type : 'POST',
							data : 'v_ajax=SelectNum_OPA_IMP' + '&v_NumOpe_F5=' + v_Num_OPA_Imp,
							dataType : 'html',
							success : function(code_html_retour, statut){
								$('#DivComptaOP').replaceWith(code_html_retour);
								$("select#SelectIbOpi").jqxDropDownList({ width: 900, height: 22, autoDropDownHeight: true });
								$("select#SelectResaOpi").jqxDropDownList({ width: 900, height: 22, autoDropDownHeight: true });
								$("#Textejustifdepas").show();
								$("#DivComptaOP").show();
					$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_Vert.png') ;
					VerifFinEtape();
							},
						});
						
						
					});
				},
			});
			
		}
	});
	
	//////////////////////////////////////////////////
	//--------------------- BT image ValidMip Direct -------------------
	//////////////////////////////////////////////////
	$("#ValidMip").on('click', function() {
		// remise à zero des zones
		if (document.getElementById("input_NumMip").value != '')  {
			if (document.getElementById("input_NumMip").value.length == 5) {
				var Num_Mip = document.getElementById("input_NumMip").value;
				if ($.isNumeric(Num_Mip)) {
					var v_ex_OPA = $("#SelectEx_OPA").val();
					if (v_ex_OPA != '?') {
						$.ajax({
						url : 'DENG_02_01_crea_dem_ajax.php',
						type : 'POST',
						data : 'v_ajax=SelectNumOPA' + '&v_F5_000=' + v_ex_OPA + '&v_input_NumMip=' + Num_Mip,
						dataType : 'html',
						success : function(code_html_retour, statut){
							$('#DivMip').replaceWith(code_html_retour);
							$("#DivMip").show();
							$("#expandListMip").show();
							$(".SelectMip").mouseover(function(){
								$(this).css("background", "#00CC00");
							});
							$(".SelectMip").mouseout(function(){
								$(this).css("background", "#FFFFFF");
							})
							$(".SelectMip"	).click(function(){
								var recupMip = $(this).attr('id');
								$("#expandListMip").jqxExpander({ expanded: false });
								var code_MIP_retour = recupMip.split('$'); 
								// $pdo_lignes_MIP['F5_131_Id_Niv_1']
								//."$".$pdo_lignes_MIP['F5_133_Id_Niv_2']
								//."$".$pdo_lignes_MIP['F5_135_Id_Niv_3']
								//."$".$t_num_mip[1]
								//."$".$pdo_Circ[0]
								//."$".$pdo_lignes_Engt['ENGT']
								//."$".$v_mt_dispo
								//."$".$pdo_lignes_MIP['F5_000_id_Ope
								console.log("*** "+code_MIP_retour);
								var v_ExMip = code_MIP_retour[0];
								var v_ArdtMip = code_MIP_retour[1];
								var v_NumMipF5_135 = code_MIP_retour[2]; // F5_131 = v_ExMip et F5_135 = NumMipF5_135
								var v_NumMipSeul = code_MIP_retour[3];
								var NumMipPourN_01 = v_ExMip+"_"+v_ArdtMip+"_"+v_NumMipSeul;
								var v_Mt_dans_circuit = code_MIP_retour[4];
								var v_Mt_Engage =  code_MIP_retour[5];
								var v_mt_dispo = code_MIP_retour[6];
								var v_F5_000 = code_MIP_retour[7];
								///////////////////////
								// recup info MIP
								///////////////////////
								$.ajax({
									url : 'DENG_02_01_crea_dem_ajax.php',
									type : 'POST',
									async : false,
									data : 'v_ajax=SelectNumMip' + '&v_ExMip=' + v_ExMip 
											+ '&v_NumMipF5_135=' + v_NumMipF5_135 + '&NumMipPourN_01=' + NumMipPourN_01 
											+ '&NumOpe_F5=' + v_F5_000 + '&v_Mt_dans_circuit=' + v_Mt_dans_circuit 
											+ '&v_Mt_Engage=' + v_Mt_Engage + '&v_mt_dispo=' + v_mt_dispo ,
									dataType : 'html',
									success : function(code_html_retour, statut){
										var code_html_retour_part = code_html_retour.split('$$_$$_$$');
										$('#DivMipDetail').replaceWith('<div id="DivMipDetail" style="font-size: 14px;color: #666666;display:none;">'+code_html_retour_part[0]+'</div>');
										$("#DivMipDetail").show();
										$('#DivComptaOP').replaceWith(code_html_retour_part[1]);
										$("select#SelectIbOpi").jqxDropDownList({ width: 900, height: 22, autoDropDownHeight: true });
										$("select#SelectResaOpi").jqxDropDownList({ width: 900, height: 22, autoDropDownHeight: true });
										$("#DivComptaOP").show();
										var ValPourcDepas = code_html_retour_part[2];
										var ValMtRevaloMip = code_html_retour_part[3];
										document.getElementById("input_ValPourcDepas").value = ValPourcDepas;
										document.getElementById("input_ValMtRevaloMip").value = ValMtRevaloMip;
										document.getElementById("input_NumMip").value = v_NumMipSeul;
									},
								});
								
								//alert("mt demande "+document.getElementById("input_MtDem").value);
								var MtDem_pour_Calcul = parseFloat(document.getElementById("input_MtDem").value);
								var ValPourcDepas = parseFloat(document.getElementById("input_ValPourcDepas").value); // exemple = 0.05 pour 5%
								var ValMtRevaloMip = parseFloat(document.getElementById("input_ValMtRevaloMip").value);
								v_mt_dispo = parseFloat(v_mt_dispo); 
								// // $v_mt_dispo = $pdo_lignes_MIP['F5_138_Mt_Reval']-$pdo_lignes_Engt['ENGT']-$pdo_Circ[0]; dans SelectNumMip de crea_dem_ajax
								// test sur Mt pour calcul depassement
								// si Mt dispo - Mt dem > 0 ok sinon 
								// si (Mt dispo + x% du Mt revalo) - Mt dem > 0 ok avec alerte % depas autorisé sinon Textejustifdepas
								if (v_mt_dispo - MtDem_pour_Calcul >= 0) {
									$("#DivDepasMip").hide();
									$("#Textejustifdepas").hide();
									document.getElementById("input_DepasMip").value='N';
									document.getElementById("input_Mt_Depas").value='0';	
		$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_Vert.png') ;
		VerifFinEtape();
								} else {
									//console.log("input_ValMtRevaloMip"+ValMtRevaloMip);
									//console.log("input_ValPourcDepas"+ValPourcDepas);
									//console.log("v_mt_dispo"+v_mt_dispo);
									//console.log("MtDem_pour_Calcul"+MtDem_pour_Calcul);
									//console.log(ValMtRevaloMip * ValPourcDepas );
									//console.log(((ValMtRevaloMip * ValPourcDepas )+ v_mt_dispo));
									//console.log(((ValMtRevaloMip * ValPourcDepas )+ v_mt_dispo) - MtDem_pour_Calcul);
									
									if (((ValMtRevaloMip * ValPourcDepas )+ v_mt_dispo) - MtDem_pour_Calcul >= 0) { // sup a dispo mais rentre dans % autorisé
										$('#DivDepasMip').replaceWith('<div id="DivDepasMip"><br>***** Le Montant demandé est supérieur au montant prévu mais entre dans le % de depassement autorisé<br></div>');
										$("#DivDepasMip").show();
										$("#Textejustifdepas").hide();
										document.getElementById("input_DepasMip").value='AJUST';
										if (v_mt_dispo < 0) {
											document.getElementById("input_Mt_Depas").value=MtDem_pour_Calcul;
										} else {
											document.getElementById("input_Mt_Depas").value=((ValMtRevaloMip * ValPourcDepas )+ v_mt_dispo) - MtDem_pour_Calcul;
										}
		$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_Vert.png') ;
		VerifFinEtape();
									} else {
										document.getElementById("input_DepasMip").value='IMP'; // par defaut le depassement est financé par imprevu
										if (v_mt_dispo < 0) {
											document.getElementById("input_Mt_Depas").value=MtDem_pour_Calcul;
										} else {
											document.getElementById("input_Mt_Depas").value=((ValMtRevaloMip * ValPourcDepas )+ v_mt_dispo) - MtDem_pour_Calcul;
										}
										$('#DivDepasMip').replaceWith('<div id="DivDepasMip"><br>***** Le Montant demandé est supérieur au montant prévu et n\'entre pas dans le % de depassement autorisé<br>***** Veuillez renseigner un mode de financement</div>');
										$("#DivDepasMip").show();
										//$('#Textejustifdepas').replaceWith('<div id="Textejustifdepas">Textejustifdepas '+recupMip+'</div>');
										$("#Textejustifdepas").show();
		$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_Vert.png') ;
		VerifFinEtape();
									}
								}
							}).css({'cursor':'pointer'});
						},
					});
					} else { // if (v_ex_OPA != '?') {
						$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Selectionnez l\'exercice du MIP'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
					} // if (v_ex_OPA != '?') {
				} else { // if ($.isNumeric(Num_Mip)) {
					$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Renseignez le N° MIP sur 5 chiffres <br>"ex : 00001"'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
				} // if ($.isNumeric(Num_Mip)) {
		  	} else { // if (document.getElementById("input_NumMip").value.length == 5) {
				$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Renseignez le N° MIP sur 5 chiffres <br>"exemple : 00001"'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
			} // if (document.getElementById("input_NumMip").value.length == 5) {
		} else { // if (document.getElementById("input_NumMip").value != '')  {
			$("#containerGrowlErr0_Auto").notify("create", "withIcon", { title:'', text:('Renseignez un N° MIP'), icon:'../_Jquery/Growl/alerte-48-48.png' }, { expires: 10000 });
		} // if (document.getElementById("input_NumMip").value != '')  {
	});
						
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$("select#SelectType_TVA").jqxDropDownList({ width: 80, height: 22, autoDropDownHeight: true });
	$("select#SelectHtTTC").jqxDropDownList({ width: 80, height: 22, autoDropDownHeight: true });
	$("#SelectHtTTC").on('select', function (event) {
		var args = event.args;
		var lign = $("#SelectHtTTC").jqxDropDownList('getItem', args.index);
		//console.log(lign);
		if (lign != null) {
			document.getElementById("input_MtDem").value = "0,00";
		}
	});

		
	//$("select#SelectType_BT").jqxDropDownList({ width: 160, height: 22, autoDropDownHeight: true });
	$("select#SelectVilleProp").jqxDropDownList({ width: 80, height: 22, autoDropDownHeight: true });
	$("select#SelectTypUPEP").jqxDropDownList({ width: 80, height: 22, autoDropDownHeight: true });
	$("select#SelectIbFonc").jqxDropDownList({ width: 140, height: 22, dropDownHeight: 150, dropDownWidth: 500, dropDownHorizontalAlignment: 'left' });
	$("select#SelectNum_OPA").jqxDropDownList({ width: 140, height: 22, dropDownHeight: 250, dropDownWidth: 500, dropDownHorizontalAlignment: 'left' });
	$("select#SelectNum_OPA_IMP").jqxDropDownList({ width: 140, height: 22, dropDownHeight: 250, dropDownWidth: 500, dropDownHorizontalAlignment: 'left' });
		
	$("#expandMarEtTiers").jqxExpander({ width: '1020px'});
	//$("#expandMarEtTiers").on('expanding', function () {
//		$("#expandMtEtDatess").jqxExpander({ expanded: false});
//		$("#expandObjEtLieu").jqxExpander({ expanded: false});
//		$("#expandCompta").jqxExpander({ expanded: false});
//	});
	$("#expandMtEtDatess").jqxExpander({ width: '1020px', expanded: false });
	//$("#expandMtEtDatess").on('expanding', function () {
//		$("#expandMarEtTiers").jqxExpander({ expanded: false});
//		$("#expandObjEtLieu").jqxExpander({ expanded: false});
//		$("#expandCompta").jqxExpander({ expanded: false});
//	});
	$("#expandObjEtLieu").jqxExpander({ width: '1020px', expanded: false });
	//$("#expandObjEtLieu").on('expanding', function () {
//		$("#expandMarEtTiers").jqxExpander({ expanded: false});
//		$("#expandMtEtDatess").jqxExpander({ expanded: false});
//		$("#expandCompta").jqxExpander({ expanded: false});
//	});
	$("#expandTextLibelle").jqxExpander({ width: '1000px', expanded: false });
	$("#expandCompta").jqxExpander({ width: '1020px', expanded: false, disabled: true });
	//$("#expandCompta").on('expanding', function () {
//		$("#expandMarEtTiers").jqxExpander({ expanded: false});
//		$("#expandMtEtDatess").jqxExpander({ expanded: false});
//		$("#expandObjEtLieu").jqxExpander({ expanded: false});
//	});
	$("#expandListMip").jqxExpander({ width: '1018px', expanded: true });
	
	
	
	
	//$(".SelectMip").click(function(){
		//var recupMip = $(this).attr('id');
	//});
	$(".SelectMip").mouseover(function(){
		$(this).css("background", "#00CC00");
    });
    $(".SelectMip").mouseout(function(){
		$(this).css("background", "#FFFFFF");
    });
	
	//////////////////////////////////////////////////
	//--------------------- radioTrx -------------------
	//////////////////////////////////////////////////
	
	$("#radioTrx1").jqxRadioButton({ theme: 'highcontrast',groupName: '1', width: '100px', height: 25, checked: true });
	$("#radioTrx1").on('change', function (event) {
		var checked = event.args.checked;
		if (checked) {
			$("#input_EtudTrx").val('Trav');
		}
	});
	$("#radioTrx2").jqxRadioButton({ theme: 'highcontrast',groupName: '1', width: '200px', height: 25 });
	$("#radioTrx2").on('change', function (event) {
		var checked = event.args.checked;
		if (checked) {
			$("#input_EtudTrx").val('EetT');
		}
	});
	$("#radioTrx3").jqxRadioButton({ theme: 'highcontrast',groupName: '1', width: '300px', height: 25 });
	$("#radioTrx3").on('change', function (event) {
		var checked = event.args.checked;
		if (checked) {
			$("#input_EtudTrx").val('Etud');
		}
	});
	$("#radioTrx4").jqxRadioButton({ theme: 'highcontrast',groupName: '1', width: '200px', height: 25 });
	$("#radioTrx4").on('change', function (event) {
		var checked = event.args.checked;
		if (checked) {
			$("#input_EtudTrx").val('Maint');
		}
	});
	$("#radioTrx5").jqxRadioButton({ theme: 'highcontrast',groupName: '1', width: '100px', height: 25 });
	$("#radioTrx5").on('change', function (event) {
		var checked = event.args.checked;
		if (checked) {
			$("#input_EtudTrx").val('Inv');
		}
	});
	//////////////////////////////////////////////////
	//--------------------- FIN radioTrx -------------------
	//////////////////////////////////////////////////
	
	//////////////////////////////////////////////////
	//--------------------- radioInvest -------------------
	//////////////////////////////////////////////////
	$("#radioInvest1").jqxRadioButton({ theme: 'highcontrast',groupName: '2', width: '100px', height: 25, checked: true });
	$("#radioInvest1").on('change', function (event) {
		var checked = event.args.checked;
		if (checked) {
			$("#input_FoncInvest").val('OPA');
			$("#DivOPI").hide();
			$("#DivConsoOPI").hide();
			$("#DivOPA").show();
			$("#SelectEx_OPA").val('?');
			$("#DivMip").hide();
			$("#DivOPA_IMP").hide();
			$("#expandListMip").hide();
			$("#DivDepasMip").hide();
			$("#DivComptaOP").hide();
			$('#DivMipDetail').replaceWith('<div id="DivMipDetail" style="font-size: 14px;color: #666666;display:none;"></div>');
			$("#DivMipDetail").hide();
			//$('#Textejustifdepas').replaceWith('<div id="Textejustifdepas">Textejustifdepas</div>');
			$("#Textejustifdepas").hide();
			$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_gris.png') ;
			$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
		}
	});
	$("#radioInvest2").jqxRadioButton({ theme: 'highcontrast',groupName: '2', width: '200px', height: 25 });
	$("#radioInvest2").on('change', function (event) {
		var checked = event.args.checked;
		if (checked) {
			$("#input_FoncInvest").val('IMP');
			$("#DivOPI").hide();
			$("#DivConsoOPI").hide();
			$("#DivOPA").hide();
			$("#DivMip").hide();
			$("#expandListMip").hide();
			$("#DivOPA_IMP").show();
			$("#SelectEx_OPA_IMP").val('?');
			$("#DivDepasMip").hide();
			$("#DivComptaOP").hide();
			$('#DivMipDetail').replaceWith('<div id="DivMipDetail" style="font-size: 14px;color: #666666;display:none;"></div>');
			$("#DivMipDetail").hide();
			//$('#Textejustifdepas').replaceWith('<div id="Textejustifdepas">Textejustifdepas</div>');
			$("#Textejustifdepas").hide();
			$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_gris.png') ;
			$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
		}
	});
	$("#radioInvest3").jqxRadioButton({ theme: 'highcontrast',groupName: '2', width: '100px', height: 25 });
	$("#radioInvest3").on('change', function (event) {
		var checked = event.args.checked;
		if (checked) {
			$("#input_FoncInvest").val('OPI');
			$("#DivOPI").show();
			$("#DivOPA").hide();
			$("#DivOPA_IMP").hide();
			$("#DivMip").hide();
			$("#expandListMip").hide();
			$("#DivDepasMip").hide();
			$("#DivComptaOP").hide();
			$('#DivMipDetail').replaceWith('<div id="DivMipDetail" style="font-size: 14px;color: #666666;display:none;"></div>');
			$("#DivMipDetail").hide();
			//$('#Textejustifdepas').replaceWith('<div id="Textejustifdepas">Textejustifdepas</div>');
			$("#Textejustifdepas").hide();
			$('#LibOpi').replaceWith('<div id="LibOpi">&nbsp;<i>libellé opi<i></div>');
			$('#DENGT_Avanc_4').attr('src','images/Etapes/Etape_DENGT_4_gris.png') ;
			$('#DENGT_Avanc_5').attr('src','images/Etapes/Etape_FIN_gris.png') ;
		}
	});
	//////////////////////////////////////////////////
	//--------------------- FIN radioInvest -------------------
	//////////////////////////////////////////////////
	
	//////////////////////////////////////////////////
	//--------------------- radioDepas -------------------
	//////////////////////////////////////////////////
	$("#radioDepas1").jqxRadioButton({ theme: 'highcontrast',groupName: '3', width: '300px', height: 25, checked: true });
	$("#radioDepas1").on('change', function (event) {
		var checked = event.args.checked;
		if (checked) {
			$("#input_DepasMip").val('IMP');
			$("#input_Mt_Depas").val('0');
			$("#DetailTextejustifdepas").hide();
		}
	});
	$("#radioDepas2").jqxRadioButton({ theme: 'highcontrast',groupName: '3', width: '300px', height: 25 });
	$("#radioDepas2").on('change', function (event) {
		var checked = event.args.checked;
		if (checked) {
			$("#input_DepasMip").val('AUTO');
			$("#input_Mt_Depas").val('0');
			$("#DetailTextejustifdepas").show();
		}
	});
	//////////////////////////////////////////////////
	//--------------------- radioDepas -------------------
	//////////////////////////////////////////////////
	
	
	//////////////////////////////////////////////////
	//--------------------- datepicker -------------------
	//////////////////////////////////////////////////
	
	$( "#input_DateDevis" ).datepicker({ 
			'monthNames'	: ['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
			'dayNamesShort'	: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'] ,
			'dayNamesMin'	: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'], 
			'showAnim'		: 'clip',
			'dateFormat'	: 'dd/mm/yy', 
			'showOn'		: 'button',
			'buttonImage'	: "images/Calendar_30_30.png",
			'buttonImageOnly': true 
	});
	$( "#input_DateDebTRX" ).datepicker({ 
			'monthNames'	: ['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
			'dayNamesShort'	: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'] ,
			'dayNamesMin'	: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'], 
			'showAnim'		: 'clip',
			'dateFormat'	: 'dd/mm/yy', 
			'showOn'		: 'button',
			'buttonImage'	: "images/Calendar_30_30.png",
			'buttonImageOnly': true 
	});
	$( "#input_DateFinTRX" ).datepicker({ 
			'monthNames'	: ['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
			'dayNamesShort'	: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'] ,
			'dayNamesMin'	: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'], 
			'showAnim'		: 'clip',
			'dateFormat'	: 'dd/mm/yy', 
			'showOn'		: 'button',
			'buttonImage'	: "images/Calendar_30_30.png",
			'buttonImageOnly': true 
	});
	//////////////////////////////////////////////////
	//--------------------- FIN datepicker -------------------
	//////////////////////////////////////////////////
	
	
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





</script>