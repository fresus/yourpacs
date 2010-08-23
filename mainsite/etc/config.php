<?php
/**
Config
@file config.php
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

# Configuracion del sistema
# ------------------------------------------------------------------------------
$CONFIG['system']['forbiddenclass'] = array("User", "Lang", "Debug",
											"Db", "Page", "Section",
											"Config", "buildHTML",
											"buildXML", "Connect");
$CONFIG['system']['utf8encode']     = false;

# Debug
# ------------------------------------------------------------------------------
$CONFIG['debug']['code']       = true;
$CONFIG['debug']['db']         = true;
$CONFIG['debug']['xmlallowed'] = true;

# DataBase
# ------------------------------------------------------------------------------
$CONFIG['db']['host']   = "localhost";
$CONFIG['db']['login']  = "website";
$CONFIG['db']['passwd'] = "EeJaesie4pie";
$CONFIG['db']['dbname'] = "website";

# Variables globales
# ------------------------------------------------------------------------------

# Site
$CONFIG['site']['protocol']   = "http://";
$CONFIG['site']['domain']     = "188.165.192.112";
$CONFIG['site']['ajaxdomain'] = "188.165.192.112";
$CONFIG['site']['nosection']  = "sectionerror";
$CONFIG['site']['versioncss'] = "9";
$CONFIG['site']['versionjs']  = "9";
$CONFIG['site']['home']       = "home";
$CONFIG['site']['lang']       = "es";

# Cookies
$CONFIG['cookie']['lang']    = "lelang";

# Paths
$CONFIG['path']['base']      = "/var/www/mainsite/";
$CONFIG['path']['core']      = "{$CONFIG['path']['base']}core/";
$CONFIG['path']['lib']       = "{$CONFIG['path']['base']}lib/";
$CONFIG['path']['xsl']       = "{$CONFIG['path']['base']}xsl/";
$CONFIG['path']['sections']  = "{$CONFIG['path']['base']}class/";
$CONFIG['path']['web']       = "{$CONFIG['path']['base']}www/";
$CONFIG['path']['lang']      = "{$CONFIG['path']['base']}lang/";
$CONFIG['path']['css']       = "css/";
$CONFIG['path']['images']    = "img/";
$CONFIG['path']['js']        = "js/";

# Paginación
$CONFIG['pages']['regxpage']    = 10;
$CONFIG['pages']['pagesxpager'] = 2;

# e-Mail
$CONFIG['email']['from'] = "Yourpacs <suport@lynksee.com>, ";

# Page
$CONFIG['page']['title'] = "Yourpacs";

?>
