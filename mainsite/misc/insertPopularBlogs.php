<?php
ini_set("display_errors", true);

$conn = mysql_pconnect("localhost", "root", "pepitogrillo");
mysql_select_db("lynksee");
mysql_query("SET NAMES `utf8`");

$rs = mysql_query("DELETE FROM public_database.public_web", $conn);

$sql = "SELECT account.login, domain, count(*) as num FROM lastposts_blog LEFT JOIN account ON account.id_account = lastposts_blog.id_account GROUP BY lastposts_blog.id_account ORDER BY num DESC LIMIT 100;";
$rs = mysql_query($sql, $conn);
while ($data = mysql_fetch_assoc($rs))
{
	$sql = "INSERT INTO public_database.public_web
			(account, domain, num)
			VALUES
			('{$data['login']}', '{$data['domain']}', {$data['num']})
			";

	$rs2 = mysql_query($sql, $conn);

	echo "Insertado blog: {$data['login']}\n";
}

?>