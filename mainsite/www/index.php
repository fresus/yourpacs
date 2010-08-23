<?php
/**
Factory
@file index.php
@version 1.0
@date 3 de marzo del 2007
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

# Parametros de inicializacion
ob_start();
session_start();

# Cabeceras
header("Expires: Mon 1 Jan 2001 01:00:00 GMT" );
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
header("Cache-control: no-store, no-cache, must-revalidate");
header("Cache-control: post-check=0, pre-check=0", false );
header("Pragma: no-cache" );
header('Content-Type: text/html; charset=UTF-8');

ini_set("error_reporting", E_ALL ^ E_NOTICE);

# Configuracion
require_once("../etc/config.php");
require_once("../core/config.class.php");

# Instancia el objeto de configuracion y vacia el array $CONFIG
$static['config'] = new Config($CONFIG);

# Niveles de error
ini_set("display_errors", Config::get("debug", "code"));

# Core
require_once(Config::get("path", "core") . "debug.class.php");
require_once(Config::get("path", "core") . "db.class.php");
require_once(Config::get("path", "core") . "page.class.php");
require_once(Config::get("path", "core") . "section.class.php");
require_once(Config::get("path", "core") . "buildXML.class.php");
require_once(Config::get("path", "core") . "buildHTML.class.php");
require_once(Config::get("path", "core") . "user.class.php");
require_once(Config::get("path", "core") . "lang.class.php");
require_once(Config::get("path", "core") . "dcm4chee.class.php");

# Instancia el debug
$static['debug'] = new Debug();

# Instancia la base de datos
$static['db'] = new Db(Config::get("db", "host"),
			  		   Config::get("db", "login"),
					   Config::get("db", "passwd"),
					   Config::get("db", "dbname"));

# Instancia el user
$static['user'] = new User();
$static['user']->setCurrentUserBySession();

# Instancia la clase de idioma
$static['lang'] = new Lang($_GET['lang']);

# Instancia la conexion de sockets
//$static['connect'] = new Connect();

# Instanciamos la página
$section = trim($_GET['section']) ? trim($_GET['section']) : Config::get("site", "home");
$page    = new Page($section);
$content = $page->show();

# ALEHOPPPPP!!!!!!!!!!!!!!!
if (Config::get("system", "utf8encode")) {
	echo utf8_encode($content);
}
else {
	echo $content;
}


# Debug
if (Config::get("debug", "code"))
{
	echo Debug::getHTML();
}

?>
