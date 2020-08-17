<?php

$_POST = $_GET; // pendant les test les parama sont passé en post à enreg et en get pour le pdf
/*
post : Fonc
(
	[val_Ardt_choisi] => 02
    [val_pnom_choisi] => gindaburu
    [SelectType_CTR] => A
    [input_ExCtr] => 2018
    [input_NumCtr] => 99999
    [SelectCE_CTR] => MAC
    [SelectList_CTR] => 2019_4471_1
    [input_IdCtr] => 2019_4471_1
    [SelectNumTiers] => 122682
    [input_RefDevis] => xxxx
    [input_DateDevis] => 00/00/0000
    [SelectType_TVA] => 20
    [input_MtDem] => 10000
    [SelectHtTTC] => TTC
    [MtDispoCtr] => 2480035.21
    [SelectRevisable] => Non
    [val_SelectRevisable] => Non
    [input_TauxRvp] => 0,00
    [val_dateDebCtr] => 2019-06-26
    [val_dateFinCtr] => 2020-06-25
    [input_DateDebTRX] => 02/06/2020
    [input_DateFinTRX] => 02/06/2020
    [input_DateDuree] => 0
    [input_LibTrx] => hhhhh
    [inpute_TexteLong] => 
    [input_EtudTrx] => Trx
    [SelectType_BT] => ?
    [SelectVilleProp] => O
    [input_LieuTrx] => hjklm
    [SelectTypeDep] => F
    [input_FoncInvest] => IMP
    [SelectTypeBud] => 00
    [SelectIbNat] => 615221
    [SelectIbFonc] => 211
    [input_ExOPI] => 2018
    [input_TypOPI] => .
    [input_NumOPI] => 9999
    [SelectEx_OPA] => 2020
    [SelectNum_OPA] => 2020 - MA - 5229
    [input_NumMip] => 18346
    [SelectEx_OPA_IMP] => 2020
    [SelectNum_OPA_IMP] => 2020 - MA - 1001
    [input_ValPourcDepas] => 0.05        
    [input_ValMtRevaloMip] => 1
    [input_DepasMip] => IMP
    [DetailTextejustifdepas] => Renseignez ici les MIP Ã  utiliser pour l'auto financement
    [SelectIbOpi] => ?
    [SelectResaOpi] => ?
    [SuiviMail] => Non
    [v_page_php] => DENG_02_01_crea_dem.php
    [V_PHP_SELF] => /DirCA/DENG_02_01_crea_dem.php
)
*/

/////////////////////
//
//		variables utilisée pour pdf et enreg
//
/////////////////////
$v_Typ_dep = ""; // I,F,A
$v_sous_typ_dep = ""; // OPA,OPI,IMP
$v_DepasMip = ""; // IMP,N,AJUST,AUTO
/////////////////////
//
//		demande en fonctionnement
//
////////////////////
if ($_POST['SelectTypeDep'] == 'F') {
	
} // if ($_POST['SelectTypeDep'] == 'F') {
?>