<?php

Header("Content-Type: text/plain;");

# Incluimos magpierss
require_once("../lib/magpierss-0.72/rss_fetch.inc");

$conn = mysql_pconnect("localhost", "root", "pepitogrillo");
mysql_select_db("lynksee");
mysql_query("SET NAMES `utf8`");


# Recorremos las cuentas de los usuarios
$rs = mysql_query("SELECT id_account, login FROM account ORDER BY id_account ASC", $conn);
while ($data = mysql_fetch_assoc($rs))
{
	$rss = @fetch_rss("http://{$data['login']}.lynksee.com/blog/?feed=rss2");

	if ($rss)
	{
		foreach ($rss->items as $item)
		{
			if (strlen($item['title']) >= 6 && strpos($item['title'], "Hola, mundo") === FALSE && $item['title'] != "Yourpacs!")
			{
				# Miramos si existe el post en la DB
				$rs2    = mysql_query("SELECT * FROM lastposts_blog WHERE link = '{$item['link']}'", $conn);
				$exists = mysql_num_rows($rs2);
				if (!$exists)
				{
					$sql = "INSERT INTO lastposts_blog
							(id_account, login, link, title, date)
							VALUES
							({$data['id_account']}, '{$data['login']}', '" . addslashes($item['link']) . "', '" . addslashes(htmlentities($item['title'])) . "', '{$item['date_timestamp']}')
							";
					mysql_query($sql, $conn);
					echo "Añadido post a {$data['login']}: {$item['title']}\n";
				}
				else
				{
					break;
				}
			}
		}
	}

// 	sleep(1);
//	if ($c++ >= 30) break;
}
