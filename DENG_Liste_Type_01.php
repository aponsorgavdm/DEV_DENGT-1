<?php


?>

<!-- ######################################################################################## -->
<!-- ######################  JAVA SCRIPT  ################################################### -->
<!-- ######################################################################################## -->
<script type="text/javascript"><!--


var CheminToRacine = '<? echo $chemin_to_racine; ?>';


//--------------------------------------------------------------------
//--------------------- fonction create pour growl -------------------
function create( template, vars, opts ){
	return $container.notify("create", template, vars, opts);
}

var linkrenderer = function (row, column, value, columnfield) {
                if (value.indexOf('#') != -1) {
                    value = value.substring(0, value.indexOf('#'));
                }
				//console.log(row);
				//console.log(column);
				//console.log(value);
				//console.log(columnfield);
                //var format = { class : '"fancy_1050_550"' };
                //var html = $.jqx.dataFormat.formatlink(value, format);
				/*
				if (column == "BtAction") {
					//console.log(row);
					//console.log(column);
					//console.log(value);
					//console.log(columnfield);
					var html = '<a href="'+value+'" target="_top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="'+CheminToRacine+'DirCA/images/list_edit_32_32.png" width="16" height="16" align="middle" title="Action"/></a>';
					html = "";
					return html;
				}*/
				if (column == "BtPdf") {
					//console.log(row);
					//console.log(column);
					//console.log(value);
					//console.log(columnfield);
					var html = '<a href="'+value+'" target="_top">&nbsp;&nbsp;&nbsp;<img src="'+CheminToRacine+'DirCA/images/pdf_icon_29_30.png" width="16" height="16" align="middle" title="Pdf"/></a>';
					return html;
				}
				if (column == "BtVoir") {
					//console.log("row "+row);
					//console.log("column "+column);
					//console.log("value "+value);
					//console.log("columnfield "+columnfield);
					var html = '<a href="'+value+'" target="_top">&nbsp;&nbsp;&nbsp;<img src="'+CheminToRacine+'DirCA/images/zoom_32_30.png" width="16" height="15" align="middle" title="voir"/></a>';
					return html;
				}
            }




			function openTooltipStatut(row, value) {
				$('#line' + row).jqxTooltip({
					content: 'Depuis le : '+ value,
					position: 'right', 
					theme: 'darkblue',
					showDelay: 10
				});
				$('#line' + row).jqxTooltip('open');
			};

//////////////////////////////////////////////////
//--------------------- jquery -------------------
//////////////////////////////////////////////////
$(document).ready(function(){
	
//////////////////////////////////////////////////////////
//--------------- localisation texte jqxgrid
/////////////////////////////////////////////////////////	
			var localizationobj = {
				groupsheaderstring: "Deposer des titres de colonnes ici pour regrouper",
				groupbystring: "Regrouper sur cette colonne",
				groupremovestring: "Supprimer du regroupement",
				
				percentsymbol: " %",
				currencysymbol: " &#128;",
				currencysymbolposition: "after",
				decimalseparator: '.',
				thousandsseparator: ' ',
				
				pagergotopagestring: "Aller &#224; la page:",
				pagershowrowsstring: "Nbr de lignes:",
				pagerrangestring: " de ",
				pagerpreviousbuttonstring: "precedent",
				pagernextbuttonstring: "suivant",
				emptydatastring: "Pas de donnees à afficher",
				sortascendingstring: "Tri Ascendant",
				sortdescendingstring: "Tri Descendant",
				sortremovestring: "Supprimer le Tri",
				
				loadtext: "En Cours",
				};
			/////////////////
			//
			//	pour fenetre edit
			//
			////////////////	
			var theme = 'darkblue';
			var theme = 'highcontrast';
			var theme = 'fresh';
            // initialize the input fields.
            $("#IdDem").jqxInput({ disabled: true, theme: theme});
        
            $("#IdDem").width(150);
            $("#IdDem").height(23);
			
			$("#Motif").jqxTextArea({ placeHolder: 'Saisir le motif', height: 150, width: 150, minLength: 1, theme: theme});
			
			
			var profilDengt = '<? echo $_SESSION['VG_droits_DENGT_profil'];?>';
	//console.log(profilDengt);
			var QuoiVoir = "<? echo $v_voir; ?>";
	//console.log("QuoiVoir : "+QuoiVoir);
			switch (profilDengt) {
				case 'DEM':
					var listItemAction = ['01_Soumettre', '02_Modifier', '03_Supprimer', '11_Repondre_ATTCOMPTA'];
					var valtitre = "Mes demandes en attente interne DGAAVE (PROJ, SOUM, VISEE, ATTCOMPTA, ATTSAI)";
					break;
				case 'VALID':
					var listItemAction = ['04_Viser', '05_Refuser Visa','__________','01_Soumettre', '02_Modifier', '03_Supprimer', '11_Repondre_ATTCOMPTA'];
					var valtitre = "Mes demandes à Viser (SOUM)";
					break;
				case 'COMPTA':
					var listItemAction = ['06_En Saisie','07_NON Accorder','08_Attente Info. Comp.','09_Refuser Engt','10_Saisie N° Engagement','__________','01_Soumettre', '02_Modifier', '03_Supprimer', '11_Repondre_ATTCOMPTA','___________','04_Viser', '05_Refuser Visa'];
					var valtitre = "Mes demandes à Traiter (VISEE, ATTSAI, ATTCOMPTA, ATTPEG)";
					break;
				case 'ADMIN':
					var listItemAction = ['01_Soumettre', '02_Modifier', '03_Supprimer', '11_Repondre_ATTCOMPTA','__________','04_Viser', '05_Refuser Visa','__________','06_En Saisie','07_NON Accorder','08_Attente Info. Comp.','09_Refuser Engt','10_Saisie N° Engagement'];
					var valtitre = "Mes demandes à Accorder";
					break;
				default:
					var listItemAction = ['Aucune'];
			}
			if (QuoiVoir == 'tout') {
				valtitre = 'TOUTES mes Demandes';
			}
			
			
            var editrow = -1;
			
			var cellsrendererStatut = function (row, column, value) {
				//console.log("***"+value);
				var recudata2 = value.split('="');
				//console.log(recudata2[7]);
				//recudata2 = recudata2[7];
				recudata2 = recudata2[7].split('"');
				 	//console.log(recupurl[0]);
				var valuefortooltip = recudata2[0];
				var returnFinal = '<div id="line' + row + '" style="text-align: center; margin-top: 5px;" onmouseover="openTooltipStatut(';
				returnFinal = returnFinal + "'" + row + "','" + valuefortooltip + "')"
				returnFinal = returnFinal + '">' + value + '</div>';
				//console.log(returnFinal);
				//return '<div id="line' + row + '" style="text-align: center; margin-top: 5px;" onmouseover="openTooltipStatut(\'' + row +'\')">' + value + '</div>';
				return returnFinal;
			}
	
	$("#jqxgrid1").jqxGrid({
				//source : data,
				sortable: true, 
				//showsortmenuitems: false,
				filterable: true,
				showfilterrow: false,
				filterrowheight: 28,
				width: 1200,
				pageable: true,
				pagermode: 'simple',
				pagesize: 20,
				pagesizeoptions: ['10', '20', '30', '50', '100'],
				//height: 378,
				autoheight: true,
				rowsheight: 24,
				showaggregates: true,
				showstatusbar: true,
				statusbarheight: 20,
				columns: [
					{text: 'N° Dem', datafield: 'A0_000_idSql', 				columngroup: 'TitreTableau', width: 55, align: 'center', cellsalign: 'center', columntype: 'textbox', filterable:true,    
						aggregates: [ {
						  'Nb': function (aggregatedValue, currentValue) {
							  return aggregatedValue + 1;
						  }
						}], 
						aggregatesrenderer: function (aggregates) {
							var renderstring = "";
							$.each(aggregates, function (key, value) {
								renderstring += '<div style="position: relative; margin: 4px; overflow: hidden; font-size : 10px;">Nbr : ' + value + '</div>';
							});
							return renderstring;
						}
					},
					{text: 'Du', datafield: 'A60B_100_Dat_last_modif', 			columngroup: 'TitreTableau', width: 75, align: 'center', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', columntype: 'textbox', filterable:true},
					{text: 'Pour', datafield: 'A0_002_Pour_pnom', 				columngroup: 'TitreTableau', width: 100, align: 'center', cellsalign: 'center', columntype: 'textbox', filterable:true},
					{text: 'Typ', datafield: 'A0_040_TypDep', 					columngroup: 'TitreTableau', width: 30, align: 'center', cellsalign: 'center', columntype: 'textbox', filterable:true},
					{text: 'Ardt', datafield: 'A0_004_Ardt', 					columngroup: 'TitreTableau', width: 35, columntype: 'textbox', align: 'center', cellsalign: 'center', filterable:true},
					{text: 'Lieu', datafield: 'A0_025_Lieu', 					columngroup: 'TitreTableau', width: 205, columntype: 'textbox', align: 'center', cellsalign: 'left', filterable:true},
					{text: 'libellé', datafield: 'A0_022_ObjEngt', 				columngroup: 'TitreTableau', width: 300, columntype: 'textbox', align: 'center', cellsalign: 'left', filterable:true},
					{text: 'Mt TTC', datafield: 'A0_011_Mt_HT', 				columngroup: 'TitreTableau', width: 90, columntype: 'numberinput', align: 'center', cellsalign: 'right',cellsformat: 'd2', filterable:false,  
						aggregates: [ {
							  'Mt': function (aggregatedValue, currentValue) {
								  return aggregatedValue + currentValue;
							  }
						}], 
						aggregatesrenderer: function (aggregates) {
							var renderstring = "";
							$.each(aggregates, function (key, value) {
								renderstring += '<div style="position: relative; margin: 4px; overflow: hidden; font-size : 10px;">' + value.replace(/,/gi, " ") + '</div>';
							});
							return renderstring;
						}
					},
					{text: 'Statut', datafield: 'A0_060_Statut', 				columngroup: 'TitreTableau', width: 100, align: 'center', cellsalign: 'center', columntype: 'textbox', filterable:true, cellsrenderer: cellsrendererStatut,},
					{text: 'Compta', datafield: 'iconCompta', 					columngroup: 'TitreTableau', width: 50, align: 'center', cellsalign: 'center', columntype: 'textbox', filterable:false, sortable: false, menu: false},
					{text: 'Délais', datafield: 'DifDatJourmoinsDatStatut', 	columngroup: 'TitreTableau', width: 50, align: 'center', cellsalign: 'center', columntype: 'textbox', filterable:true},
					//{text: 'Action', datafield: 'BtAction', 					width: 50, align: 'center', cellsalign: 'center', columntype: 'textbox', filterable:false, sortable: false, menu: false, cellsrenderer: linkrenderer},
					{text: 'Action', datafield: 'BtAction', 					columngroup: 'TitreTableau', width: 50, align: 'center', cellsalign: 'center', filterable:false, sortable: false, menu: false, columntype: 'button', 
					cellsrenderer: function () {
											 return 'Action';
										  }, 
										  buttonclick: function (row) {
											 // open the popup window when the user clicks a button.
											 editrow = row;
											 var offset = $("#jqxgrid1").offset();
											 $("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 1000, y: parseInt(offset.top) - 10 } });
											 // get the clicked row's data and initialize the input fields.
											 var dataRecord = $("#jqxgrid1").jqxGrid('getrowdata', editrow);
											 $("#IdDem").val(dataRecord.A0_000_idSql);
											 // show the popup window.
											 $("#popupWindow").jqxWindow('open');
										 }
                 },
					{text: 'PDF', datafield: 'BtPdf', 							columngroup: 'TitreTableau', width: 30, align: 'center', cellsalign: 'center', columntype: 'textbox', filterable:false, sortable: false, menu: false, cellsrenderer: linkrenderer},
					{text: 'Voir', datafield: 'BtVoir', 						columngroup: 'TitreTableau', width: 30, align: 'right', cellsalign: 'right', columntype: 'textbox', filterable:false, sortable: false, menu: false, cellsrenderer: linkrenderer}
				],
				columngroups: [
					{ text: valtitre, align: 'center', name: 'TitreTableau' }
				]
	});
	
			/////////////////
			//
			//	pour fenetre edit
			//
			////////////////
	
            // initialize the popup window and buttons.
            $("#popupWindow").jqxWindow({
                width: 300, height: 300, resizable: false,  isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.5, title: 'Action', theme : theme        
            });
            $("#popupWindow").on('open', function () {
				//$("#SelectAction").jqxDropDownList('enableItem','01_Choisir');
           		$("#SelectAction").jqxDropDownList('selectIndex',-1);
				//$("#SelectAction").jqxDropDownList('disableItem','01_Choisir');
				$("#TrMotif").hide();
            });
         
            $("#Cancel").jqxButton({ theme: theme });
            $("#Save").jqxButton({ theme: theme });
            // update the edited row when the user clicks the 'Save' button.
            $("#Save").click(function () {
                if (editrow >= 0) {
                    //console.log($("#IdDem").val());
					//console.log($('#SelectAction').jqxDropDownList('selectedIndex'));
					if ($('#SelectAction').jqxDropDownList('selectedIndex') > 0) {
						var args = event.args;
						var item = args.item;
						var value = item.value;
						var idAction = value.substring(0,2);
						$.ajax({
							url : 'DENGT_02_Supp_Dem_v0.1.php',
							type : 'GET',
							async : false,
							data : 'Val_A0_000_idSql=' + $("#IdDem").val() + '&v_idAction=' + idAction ,
							dataType : 'html',
							success : function(code_html_retour, statut){
								alert(code_html_retour);
							},
						});
						$('#jqxgrid1').jqxGrid('updatebounddata');
					}
                    $("#popupWindow").jqxWindow('hide');
                }
            });
			
			$("#SelectAction").jqxDropDownList({
				source: listItemAction,
				placeHolder: 'Choisir',
				width: '200px',
				autoDropDownHeight: true,
				theme: theme,
				selectedIndex: 0
			});
			
			$('#SelectAction').on('change', function (event)
				{
					var args = event.args;
					if (args) {
						$("#TrMotif").hide();
					  // index represents the item's index.                
					  var index = args.index;
		//console.log(index);
					  if (index >=0) { // 
					  	var item = args.item;
						// get item's label and value.
						//var label = item.label;
						var value = item.value;
						var idAction = value.substring(0,2);
		//console.log(idAction);
						//var type = args.type; // keyboard, mouse or null depending on how the item was selected.
						//listItemAction = ['01_Soumettre', '02_Modifier', '03_Supprimer','__________','04_Viser', '05_Refuser Visa','___________','06_En Saisie','07_NON Accorder','08_Attente Info. Comp.','09_Refuser Engt','10_Saisie N° Engagement'];
						if (idAction == '05') { // 05_Refuser Visa
						  $("#TrMotif").show();
						}
						if (idAction == '07') { // 07_NON Accorder
						  $("#TrMotif").show();
						}
						if (idAction == '08') { // 08_Attente Info. Comp
						  $("#TrMotif").show();
						}
						if (idAction == '09') { // 09_Refuser Engt
						  $("#TrMotif").show();
						}
					  } // if (index >=0) { 
					}                        
			});
			
			if (profilDengt == 'VALID') {
				$("#SelectAction").jqxDropDownList('disableItem','__________');
			}
			if (profilDengt == 'COMPTA') {
				$("#SelectAction").jqxDropDownList('disableItem','__________');
				$("#SelectAction").jqxDropDownList('disableItem','___________');
			}
			if (profilDengt == 'ADMIN') {
				$("#SelectAction").jqxDropDownList('disableItem','__________');
				$("#SelectAction").jqxDropDownList('disableItem','___________');
			}
			
																											//--------------- ********************* A FAIRE *****************
			// test sur 01 SOUM enable si statut = PROJ et minimum saisie OK
			// test sur 02 Modifier enable si statut = PROJ et profil = DEM
			// test sur 03 Supprimer enable si N° engagement non renseigné
			// test sur 04 VISE enable si statut = SOUM et profil # DEM
			// test sur 05 NVISE enable si statut = SOUM et profil # DEM
			// test sur 06 ATTSAI si statut = VISE et profil = compta
			// test sur 07 NACCORD si statut = VISE et profil = compta
			// test sur 08 ATTCOMPTA si statut = ATTSAI et profil = compta
			// test sur 09 NCOMPTA si statut = ATTCOMPTA et profil = compta
			// test sur 10 ATTPEG si statut = ATTSAI et profil = compta
			// test sur 11 reponse ATTCOMPTA si statut = ATTCOMPTA et profil = DEM
			
			
			
			//listItemAction = ['01_Soumettre', '02_Modifier', '03_Supprimer','__________','04_Viser', '05_Refuser Visa','___________','06_En Saisie','07_NON Accorder','08_Attente Info. Comp.','09_Refuser Engt','10_Saisie N° Engagement'];
			switch (profilDengt) {
				case 'DEM':
					$("#SelectAction").jqxDropDownList('disableItem','01_Soumettre');
					$("#SelectAction").jqxDropDownList('disableItem','02_Modifier');
					$("#SelectAction").jqxDropDownList('disableItem','11_Repondre_ATTCOMPTA');
					break;
				case 'VALID':
					$("#SelectAction").jqxDropDownList('disableItem','01_Soumettre');
					$("#SelectAction").jqxDropDownList('disableItem','02_Modifier');
					$("#SelectAction").jqxDropDownList('disableItem','04_Viser');
					$("#SelectAction").jqxDropDownList('disableItem','05_Refuser Visa');
					$("#SelectAction").jqxDropDownList('disableItem','11_Repondre_ATTCOMPTA');
					break;
					//listItemAction = ['06_En Saisie','07_NON Accorder','08_Attente Info. Comp.','09_Refuser Engt','10_Saisie N° Engagement','__________','01_Soumettre', '02_Modifier', '03_Supprimer','___________','04_Viser', '05_Refuser Visa'];
				case 'COMPTA':
					$("#SelectAction").jqxDropDownList('disableItem','01_Soumettre');
					$("#SelectAction").jqxDropDownList('disableItem','02_Modifier');
					$("#SelectAction").jqxDropDownList('disableItem','04_Viser');
					$("#SelectAction").jqxDropDownList('disableItem','05_Refuser Visa');
					$("#SelectAction").jqxDropDownList('disableItem','06_En Saisie');
					//$("#SelectAction").jqxDropDownList('disableItem','07_NON Accorder');
					//$("#SelectAction").jqxDropDownList('disableItem','08_Attente Info. Comp.');
					//$("#SelectAction").jqxDropDownList('disableItem','09_Refuser Engt');
					$("#SelectAction").jqxDropDownList('disableItem','10_Saisie N° Engagement');
					$("#SelectAction").jqxDropDownList('disableItem','11_Repondre_ATTCOMPTA');
					break;
			}
			
			
																											//--------------- ********************* FIN A FAIRE *****************
			
			
	var data ={
			datatype: "json",
			datafields: [
				{ name: 'A0_000_idSql', type: 'string' },
				{ name: 'A60B_100_Dat_last_modif', type: 'string' },
				{ name: 'A0_040_TypDep', type: 'string' },
				{ name: 'A0_002_Pour_pnom', type: 'string' },
				{ name: 'A0_004_Ardt', type: 'string' },
				{ name: 'A0_025_Lieu', type: 'string' },
				{ name: 'A0_022_ObjEngt', type: 'string'},
				{ name: 'A0_011_Mt_HT', type: 'number'},
				{ name: 'A0_060_Statut', type: 'string'},
				{ name: 'iconCompta', type: 'string'},
				{ name: 'DifDatJourmoinsDatStatut', type: 'number'},
				{ name: 'BtAction', type: 'string'},
				{ name: 'BtPdf', type: 'string'},
				{ name: 'BtVoir', type: 'string'}],
			url: 'DENG_Liste_Type_01_ajax.php?tab=1&v_profilDengt='+profilDengt+"&v_QuoiVoir="+QuoiVoir
		};
	var dataAdapter = new $.jqx.dataAdapter(data);
	dataAdapter.dataBind();
	$("#jqxgrid1").jqxGrid('localizestrings', localizationobj);
	$("#jqxgrid1").jqxGrid({ source: dataAdapter});
	$("#jqxgrid1").jqxGrid({ showfilterrow: true});
	
	
	
	
	
			
			$('#jqxgrid1').on('cellclick', function (event) {
				 //$("#log").html("A cell has been clicked:" + event.args.rowindex + ":" + event.args.value);
				 	//console.log(event.args.columnindex);
				 	//alert(event.args.columnindex);
				 if (event.args.columnindex == 13) { // colonne voir
					 var vurl = event.args.value;
				 	//console.log(event.args.value);
					$.fancybox({
						'showCloseButton' : true,
						'titlePosition' : 'inside',
						'width' : 770,
						'height' : 600,
						'autoScale'         : false,
						'transitionIn'      : 'fade',
						'speedIn'			: 900,
						'transitionOut'     : 'fade',
						'speedOut'			: 600,
						'type'              : 'iframe',
						'href'				: vurl

					});
				 }
				 if (event.args.columnindex == 8) { // colonne statut
					 var vurl = event.args.value;
				 	console.log(event.args.value);
					var recupurl = vurl.split('="');
				 	//console.log(recupurl);
				 	console.log(recupurl[6]);
					recupurl = recupurl[6].split(' ');
				 	//console.log(recupurl[0]);
					var vurl2 = recupurl[0];
				 	//console.log(vurl2);
					$.fancybox({
						'showCloseButton' : true,
						'titlePosition' : 'inside',
						'width' : 550,
						'height' : 800,
						'autoScale'         : false,
						'transitionIn'      : 'fade',
						'speedIn'			: 900,
						'transitionOut'     : 'fade',
						'speedOut'			: 600,
						'type'              : 'iframe',
						'href'				: vurl2

					});
				 }
				 /*if (event.args.columnindex == 11) { // colonne action
					 var vurl = event.args.value;
				 	console.log(event.args.value);
					$.fancybox({
						'showCloseButton' : true,
						'titlePosition' : 'inside',
						'width' : 770,
						'height' : 600,
						'autoScale'         : false,
						'transitionIn'      : 'fade',
						'speedIn'			: 900,
						'transitionOut'     : 'fade',
						'speedOut'			: 600,
						'type'              : 'iframe',
						'href'				: vurl,
						'onClosed': function() { $('#jqxgrid1').jqxGrid('updatebounddata');}

					});
				 }*/
			 });
			 
			 
});

//--></script>


<style type="text/css">
	.jqx-grid-content {font-size : 10px;}
	.jqx-grid {font-size : 10px;}
	.jqx-grid-column-header
	{
		font-weight: bold;
		font-size : 10px;
	}
</style>

<div id="jqxgrid1" style="z-index: 0; margin: 0px 0px 0px 0px">
    <img src='images/attente_37_39.gif' />
</div>
<div style="margin-top: 30px;">
            <div id="cellbegineditevent"></div>
            <div style="margin-top: 10px;" id="cellendeditevent"></div>
       </div>
       <div id="popupWindow">
            <div>Edit</div>
            <div style="overflow: hidden;">
                <table>
                    <tr>
                        <td align="right">N° Dem:</td>
                        <td align="left"><input id="IdDem" /></td>
                    </tr>
                    <tr>
                        <td align="right">Action:</td>
                        <td align="left"><div id="SelectAction"></div></td>
                    </tr>
                    <tr id="TrMotif" style="display:none;">
                        <td align="right">Motif:</td>
                        <td align="left"><textarea id="Motif"></textarea></td>
                    </tr>
                    <tr>
                        <td align="right"></td>
                        <td style="padding-top: 10px;" align="right"><input style="margin-right: 5px;" type="button" id="Save" value="Enregistrer" /><input id="Cancel" type="button" value="Annuler" /></td>
                    </tr>
                </table>
            </div>
       </div>