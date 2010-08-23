<?php
ini_set("display_errors", true);
Header("Content-Type: text/plain;");

$conn = mysql_pconnect("localhost", "root", "pepitogrillo");
mysql_select_db("lynksee");
mysql_query("SET NAMES `utf8`");

$rs = mysql_query("SELECT * FROM account ORDER BY id_account ASC", $conn);
while ($data = mysql_fetch_assoc($rs))
{
	$soft = array();

	# Obtenemos los softwares instalados
	$rs2 = mysql_query("SELECT * FROM account_software WHERE id_account = {$data['id_account']}", $conn);
	while ($data2 = mysql_fetch_assoc($rs2)) {
		$soft[$data2['id_software']] = true;
	}

	$data['soft'] = $soft;
	$users[] = $data;
}


# Init
$params['numFile']  = 0;
$params['file']     = null;
$params['linea']    = 50000;
$params['numLines'] = 50000;


foreach ($users as $user) {
	$params = generarSitemap($params, $user, $conn);
}

fileClose($params);

# Funcion generarSitemap
function generarSitemap($params, $user, $conn)
{
	# Miramos si tiene dominio
	$domain = $user['domain'] ? $user['domain'] : "{$user['login']}.lynksee.com";

	# Obtenemos la DB
	mysql_select_db($user['login']);

	$params = fileWrite($params, "http://www.lynksee.com/ruser/{$user['login']}/{$domain}", "0.9");


	# Miramos si tiene JOOMLA! instalado
	if ($user['soft'][6]) {
		$params = fileWrite($params, "http://www.lynksee.com/ruser/{$user['login']}/{$domain}[2F]web[2F]", "0.8");
	}
	# Miramos si tiene PHPBB instalado
	if ($user['soft'][4]) {
		$params = fileWrite($params, "http://www.lynksee.com/ruser/{$user['login']}/{$domain}[2F]forum[2F]", "0.8");
	}
	# Miramos si tiene GALLERY instalado
	if ($user['soft'][2]) {
		$params = fileWrite($params, "http://www.lynksee.com/ruser/{$user['login']}/{$domain}[2F]album[2F]", "0.8");
	}

	# Miramos si tiene WORDPRESS instalado
	if ($user['soft'][1])
	{
		# Generamos el sitemap con las rutas del blog
		$params = fileWrite($params, "http://www.lynksee.com/ruser/{$user['login']}/{$domain}[2F]blog[2F]", "0.8");
		$rs = mysql_query("SELECT * FROM wp_posts ORDER BY post_date ASC", $conn);
		while ($data = mysql_fetch_assoc($rs))
		{
			if ($data['guid'])
			{
				$params = fileWrite($params, "http://www.lynksee.com/ruser/{$user['login']}/" . replaceChars(str_replace("http://", "", $data['guid'])), "0.5");
			}
		}
	}

	# Miramos si tiene MEDIAWIKI instalado
	if ($user['soft'][3])
	{
		# Generamos el sitemap con las rutas del wiki
		$params = fileWrite($params, "http://www.lynksee.com/ruser/{$user['login']}/{$domain}[2F]wiki[2F]", "0.8");
		$rs = mysql_query("SELECT * FROM wiki_page ORDER BY page_touched ASC", $conn);
		while ($data = mysql_fetch_assoc($rs))
		{
			if ($data['page_title'])
			{
				if (ereg("^(.*)\.(jpg|jpeg|gif|png)$", $data['page_title']))
				{
					$params = fileWrite($params, "http://www.lynksee.com/ruser/{$user['login']}/{$domain}[2F]wiki[2F]Image:" . urlencode($data['page_title']), "0.5");
				}
				else if (ereg("^(.*)\.(ogg|mp3|wav)$", $data['page_title']))
				{
					$params = fileWrite($params, "http://www.lynksee.com/ruser/{$user['login']}/{$domain}[2F]wiki[2F]Media:" . urlencode($data['page_title']), "0.5");
				}
				else if ($data['page_title'] != "Main_Page")
				{
					$params = fileWrite($params, "http://www.lynksee.com/ruser/{$user['login']}/{$domain}[2F]wiki[2F]" . urlencode($data['page_title']), "0.5");
				}
			}
		}
	}

	# Miramos si tiene SABROSUS instalado
	if ($user['soft'][5])
	{
		# Generamos el sitemap con las rutas del SABROSUS
		$params = fileWrite($params, "http://www.lynksee.com/ruser/{$user['login']}/{$domain}[2F]links[2F]", "0.8");
		$rs   = mysql_query("SELECT COUNT(*) as num FROM sab_sabrosus WHERE tags NOT LIKE '%:sab:privado%'", $conn);
		$data = mysql_fetch_assoc($rs);
		$num  = $data['num'];
		if ($num > 20)
		{
			$pages = ceil($num / 10);

			for ($page = 2; $page <= $pages; $page++) {
				$params = fileWrite($params, "http://www.lynksee.com/ruser/{$user['login']}/{$domain}[2F]links[2F]pag[2F]{$page}", "0.5");
			}
		}
	}

	return $params;
}

function fileClose($params)
{
	if ($params['file'])
	{
		fwrite($params['file'], "</urlset>");
		fclose($params['file']);

		/* [STEP 1] */
		$fp   = fopen("../sitemap/sitemap_{$params['numFile']}.xml", "rb");
		$data = fread($fp, filesize("../sitemap/sitemap_{$params['numFile']}.xml"));
		fclose($fp);
		/* [/STEP 1] */

		/* [STEP 2] */
		$fd     = fopen("../sitemap/sitemap_{$params['numFile']}.xml.gz", "wb");
		$gzdata = gzencode($data, 9);
		fwrite($fd, $gzdata);
		fclose($fd);
		/* [/STEP 2] */
	}

	$params['file'] = null;
	return $params;
}

function fileStart($params)
{
	$file = fopen("../sitemap/sitemap_{$params['numFile']}.xml", "w");
	fwrite($file, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
	fwrite($file, "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n");

	return $file;
}

function fileWrite($params, $str, $priority = "0.8")
{
	# Creamos el fichero
	if ($params['linea'] == $params['numLines'])
	{
		$params = fileClose($params);
		$params['numFile']++;
		$params['linea'] = 1;
		$params['file']  = fileStart($params);
	}

	fwrite($params['file'], "<url><loc>{$str}</loc><changefreq>monthly</changefreq><priority>{$priority}</priority></url>\n");
	$params['linea']++;

	return $params;
}

function replaceChars($url)
{
	$url = str_replace("?", "[3F]", $url);
	$url = str_replace("/", "[2F]", $url);
	$url = str_replace("&", "[26]", $url);

	return $url;
}
?>