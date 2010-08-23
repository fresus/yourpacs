<?php
ini_set("display_errors", true);

$conn = mysql_pconnect("localhost", "root", "pepitogrillo");
mysql_select_db("lynksee");
mysql_query("SET NAMES `utf8`");


# Recorremos las cuentas de los usuarios
$rs = mysql_query("SELECT id_account, login FROM account ORDER BY id_account ASC", $conn);
while ($data = mysql_fetch_assoc($rs)) {
	$accounts[] = $data;
}

foreach ($accounts as $account)
{
	if (mysql_select_db($account['login']))
	{
//		mysql_query("UPDATE phpbb_config SET config_value = '/forum/' WHERE config_name = 'script_path'", $conn);
 		mysql_query("UPDATE wp_options SET option_value = '0' WHERE option_name = 'gzipcompression'", $conn);

// 		$rs = mysql_query("SELECT * FROM phpbb_config WHERE config_name = 'sitename'", $conn);
// 		if (!$data = mysql_fetch_assoc($rs))
// 		{
// 			mysql_query("INSERT INTO phpbb_config VALUES ('sitename', '{$account['login']}')", $conn);
// 		}
	}
}

?>
