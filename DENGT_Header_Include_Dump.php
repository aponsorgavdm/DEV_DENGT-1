<div id="Dump" style="display:none;">
<?
echo "<br>";
echo '<a href="Dump_session.php" target="_blank">dump</a>';
echo "<br><pre>";
echo "Session : <br>";
#print_r($_SESSION); // ci dessous pour ne pas afficher les variable de session ne commencant pas par VG_. exemple les graph de chartdirector creer avec le nom  PNG_xxxx
foreach($_SESSION as $key => $value){
	if(substr($key, 0,3) == "VG_") {
		echo "&nbsp;&nbsp;&nbsp;[".$key."] = ".$value."<br>";
		if (is_array($_SESSION[$key])) {
			foreach($_SESSION[$key] as $key2 => $value2){
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[".$key2."] = ".$value2."<br>";
			}
		}
	}
}
echo "<br>";
echo "server : ";
print_r($_SERVER);
echo "post : ";
print_r($_POST);
echo "get : ";
print_r($_GET);
echo "</pre>";
?>
</div>