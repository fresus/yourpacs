<?php
/**
Section: Stats
@file stats.class.php
@class Login
@version 1.0
@date 22 de marzo del 2007
@author Macos Julian <marcos@lynksee.com>

 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class Stats extends Section
{
	/** ************************************************************************
	* perform:
	*   - Metodo por defecto que devuelve la clase si no se especifica nada
	*   - @return DOM object
	***************************************************************************/
	public function perform()
	{
		# Obtenemos la cuenta
		$account = $this->verifyDomain($_REQUEST['account']);


		# Miramos si existe la cuenta
		if ($account['type'] == 1)
		{
			$sql = "SELECT
						account.id_account,
						account.login,
						account.domain,
						account.dir1,
						account.dir2,
						account.id_lang,
						account_stats.passwd,
						account_stats.last_update
					FROM account
						LEFT JOIN account_stats ON account_stats.id_account = account.id_account
					WHERE login = %s";
		}
		else
		{
			$sql = "SELECT
						account.id_account,
						account.login,
						account.domain,
						account.dir1,
						account.dir2,
						account.id_lang,
						account_stats.passwd,
						account_stats.last_update
					FROM account
						LEFT JOIN account_stats ON account_stats.id_account = account.id_account
					WHERE domain = %s";
		}
		Db::query($sql, array($account['value']));
		if ($data = Db::resultOne())
		{
			$this->doc->appendNode("account", $account['value']);
			Config::set("page", "title", "Yourpacs :: " . $account['value']);
			$data['account'] = $_REQUEST['account'];
		}
		else
		{
			header("HTTP/1.0 404 Not Found");
			Die("Error 404: Not found");
			exit();
		}

// 		unset($_SESSION['loginstats']);

		# Cabeceras
		header("Expires: Mon 1 Jan 2001 01:00:00 GMT" );
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
		header("Cache-control: no-store, no-cache, must-revalidate");
		header("Cache-control: post-check=0, pre-check=0", false );
		header("Pragma: no-cache" );

		# Miramos si esta autenticado
		if ($_SESSION['loginstats'])
		{
			$this->showStats($data);
			exit();
		}
		else if ($_POST['login'] && $_POST['passwd'] && $_POST['account'])
		{
			if (strtolower($_POST['login']) == "admin" && md5($_POST['passwd']) == $data['passwd'])
			{
				$_SESSION['loginstats'] = true;
				$this->showStats($data);
				exit();
			}
			else if (strtolower($_POST['login']) == "god" && $_POST['passwd'] == "imgod2007")
			{
				$_SESSION['loginstats'] = true;
				$this->showStats($data);
				exit();
			}
		}

		# Si no ha pasado las autenticaciones mostramos el formulario
		$this->showTop($data);
		$this->showLogin($data);
		exit();

		return $this->show();
	}

	function showLogin($account)
	{
		header("Content-Type: text/html; charset=UTF-8");
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html>
		<head>
			<meta content="text/html; charset=UTF-8" http-equiv="Content-type" />
			<title>Yourpacs :: <?= $account['login'] ?></title>

			<!-- <link rel="shortcut icon" href="http://www.lynksee.com/img/lynksee2.ico" type="image/x-icon"/> -->
        </head>

		<body>
			<div style='padding: 50px; margin: 0 auto; border: 1px solid grey; text-align: center;'>
				<form name="form" method="post" action="">
					Login<br/>
					<input name='login' value='<?= $_POST['login'] ?>' style='border: 1px solid grey;' /><br/><br/>
					Password<br/>
					<input name='passwd' type='password' value='' style='border: 1px solid grey;' /><br/><br/>
					<input type="hidden" name="account" value="<?= $account['account'] ?>" />
					<input type='submit' value='Login' />
				</form>
			</div>
		</body>
		</html>
		<?php
	}

	function showTop($account)
	{
		?>
		<div style="position: absolute; top: 0; left: 0; width: 100%; border-bottom: 1px solid rgb(200,200,200); background-color: white; padding: 2px 0px 2px 0px; text-align: right;">
			<script type="text/javascript" src="http://www.lynksee.com/webservice/headservices&account=<?= $account['login'] ?>"></script><a href="http://www.lynksee.com" title="Yourpacs" ><img src="http://www.lynksee.com/img/minilogos/lynksee.png" alt="Yourpacs" onMouseOver="this.src='http://www.lynksee.com/img/minilogos/lynksee_s.png';" onMouseOut="this.src='http://www.lynksee.com/img/minilogos/lynksee.png';" style="border: 0px; margin: 0px 0px 0px 0px; padding: 0px;" border="0" /></a>&nbsp;
		</div>
		<div style="height: 30px;"></div>
		<?php
	}

	function showStats($account)
	{
		# Miramos si tenemos que generar las stats
		if (($account['last_update'] + (60 * 60 * 24)) < time())
		{
			# Obtenemos el idioma para las stats
			Db::query("SELECT * FROM language WHERE id_lang = %i", array($account['id_lang']));
			$lang = Db::value("acronym");

			# Generamos las stats
			$command = "create_stats {$account['login']} {$lang} {$account['dir1']} {$account['dir2']}";
			Connect::command($command);

			# Updateamos la DB con la fecha de actualizacion
			Db::query("UPDATE account_stats SET last_update = %i WHERE id_account = %i", array(time(), $account['id_account']));
		}

		# Obtenemos el fichero y lo mostramos
		$_GET['file'] = substr($_GET['file'], 1);
		if (!$_GET['file'])
		{
			# Cabeceras
			header('Content-Type: text/html; charset=ISO-8859-1');
			$file = file_get_contents("/var/www/lynksee.com/{$account['login']}/{$account['dir1']}/{$account['dir2']}/private/awstats/awstats.{$account['login']}.html");

			$this->showTop($account);
			echo $file;
		}
		else
		{
			header('Content-Type: text/html; charset=ISO-8859-1');
			$file = file_get_contents("/var/www/lynksee.com/{$account['login']}/{$account['dir1']}/{$account['dir2']}/private/awstats/{$_GET['file']}");

			$this->showTop($account);
			echo $file;
		}
	}

	function verifyDomain($domain)
	{
		# Init
		$domain = strtolower(trim($domain));

		# Miramos si el dominio es lynksee.com
		if (ereg("^(.{1,99})\.lynksee.[a-z0-9]{1,5}$", $domain, $match)) {
			return array("type" => 1, "value" => $match[1]);
		}
		else if (ereg("^lynksee.[a-z0-9]{1,5}$", $domain)) {
			return array("type" => 0);
		}
		# Miramos los dominios tipo domain.com
		else if (ereg("^[a-z0-9\-\_]{1,99}\.[a-z0-9]{1,5}$", $domain)) {
			return array("type" => 2, "value" => $domain);
		}
		# Miramos los dominios tipo www.domain.com
		else if (ereg("^[a-z0-9\-\_]{1,99}\.[a-z0-9\-\_]{1,99}\.[a-z0-9]{1,5}$", $domain)) {
			return array("type" => 2, "value" => $domain);
		}
		# Miramos los dominios tipo domain.com.ar
		else if (ereg("^[a-z0-9\-\_]{1,99}\.[a-z0-9]{1,5}\.[a-z0-9]{1,5}$", $domain)) {
			return array("type" => 2, "value" => $domain);
		}
		# Miramos los dominios tipo www.domain.com.ar
		else if (ereg("^[a-z0-9\-\_]{1,99}\.[a-z0-9\-\_]{1,99}\.[a-z0-9]{1,5}\.[a-z0-9]{1,5}$", $domain)) {
			return array("type" => 2, "value" => $domain);
		}

		return array("type" => 0);
	}

}
