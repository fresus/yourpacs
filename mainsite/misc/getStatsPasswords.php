<?php
$conn = mysql_pconnect("localhost", "root", "pepitogrillo");
mysql_select_db("lynksee");
mysql_query("SET NAMES `utf8`");


# Recorremos las cuentas de los usuarios
$rs = mysql_query("SELECT id_account, login FROM account ORDER BY id_account ASC", $conn);
while ($data = mysql_fetch_assoc($rs))
{
	include("/var/www/lynksee.com/{$data['login']}/config/configstats.php");

	if (!trim($passwd)) {
		$passwd = md5(microtime() . rand(0,999));
	}
	else {
		$passwd = md5($passwd);
	}

	mysql_query("INSERT INTO account_stats (id_account, passwd) VALUES ({$data['id_account']}, '{$passwd}')", $conn);
	unset($passwd);

	mysql_query("INSERT INTO account_software (id_account, id_software, date) VALUES ({$data['id_account']}, 1, '{$data['date']}')", $conn);
	mysql_query("INSERT INTO account_software (id_account, id_software, date) VALUES ({$data['id_account']}, 2, '{$data['date']}')", $conn);
	mysql_query("INSERT INTO account_software (id_account, id_software, date) VALUES ({$data['id_account']}, 3, '{$data['date']}')", $conn);
	mysql_query("INSERT INTO account_software (id_account, id_software, date) VALUES ({$data['id_account']}, 4, '{$data['date']}')", $conn);
	mysql_query("INSERT INTO account_software (id_account, id_software, date) VALUES ({$data['id_account']}, 5, '{$data['date']}')", $conn);
}

?>