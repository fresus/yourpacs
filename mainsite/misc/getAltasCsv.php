<?php
header("Content-Type: text/plain");

$conn = mysql_pconnect("localhost", "root", "pepitogrillo");
mysql_select_db("lynksee");
mysql_query("SET NAMES `utf8`");

$sql = "SELECT count(*) AS value, DATE(date) AS date FROM account GROUP BY DATE(date) ORDER BY DATE(date) ASC;";

$cursor = mysql_query($sql, $conn);
$num = mysql_num_rows($cursor);

while ($data = mysql_fetch_assoc($cursor))
{
	echo "{$data['date']}, {$data['value']}\n";
}

?>