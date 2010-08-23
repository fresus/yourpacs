<?php
/**
Section: Control Panel
@file controlpanel.class.php
@class Controlpanel
@version 1.0
@date 12 de marzo del 2007
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

class Controlpanel extends Section
{
	/** ************************************************************************
	* Constructor
	*    - @param section string (Nombre de la seccion)
	***************************************************************************/
	function __construct($section = null)
	{
		parent::__construct($section);

		if (!User::getCurrentUser()) {
			header("Location: /" . Lang::$acronym . "/newaccount");
			exit();
		}
	}

	/** ************************************************************************
	* perform:
	*   - Metodo por defecto que devuelve la clase si no se especifica nada
	*   - @return DOM object
	***************************************************************************/
	public function perform()
	{
		# Init
		Config::set("page", "title", Lang::get("controlpanel", "pagetitle"));
		$user = User::getCurrentUser();
		$key  = strtolower(trim($_GET['key'])) ? strtolower(trim($_GET['key'])) : "home";
		#$this->defaultpass = $user->getProperty("defaultpass");

        $this->doc->appendNode("accounttype", $user->getProperty("type"));
        $regdate = strtotime($user->getProperty("date"));
        $demodate = strtotime("-1 month");
        if ($regdate < $demodate) $this->doc->appendNode("demo", 0);
        else $this->doc->appendNode("demo", 1);
        $this->doc->appendNode("regdate", date('d/m/Y', $regdate));

		# Ejecutamos comando
		#Connect::command("quota {$user->getProperty('login')}");
		#$quotaused = Connect::getQuota();

		#$total = time() - strtotime(date("Y-m-d", strtotime($user->getProperty("date"))));
		#$quota = 400 + ($total * 0.000011574);

		# Asignamos la quota para el contador
		#$this->doc->appendNode("quotaused", $quotaused);
		#$this->doc->appendNode("quotafree", substr($quota, 0, 10));

		# Asignamos el porcentaje para llenar la barra
		#$percent = $quotaused / $quota * 100;
		#$this->doc->appendNode("quotapercent", ceil($percent));

		# Datos de la cuenta
		#$this->doc->appendNode("email", $user->getProperty("email"), null, "user");
		#$this->doc->appendNode("date", date("d-m-Y H:i", strtotime($user->getProperty("date"))), null, "user");

		# Factoria de opciones
		switch ($key)
		{
			case "pacs":
				$this->pacs();
				$this->doc->appendNode("keycp", $key);
				break;

			case "logaccess":
				$this->logAccess();
				$this->doc->appendNode("keycp", $key);
				break;

			case "searchuser":
				$this->searchUser();
				$this->doc->appendNode("keycp", $key);
				break;
			
            case "configaccount":
				$this->configAccount();
				$this->doc->appendNode("keycp", $key);
				break;

			case "invitation":
				$this->invitation();
				$this->doc->appendNode("keycp", $key);
				break;

			case "upgrade":
				$this->doc->appendNode("keycp", $key);
				break;

			default:
				$this->home();
				$this->doc->appendNode("keycp", $key);
		}

		# Obtenemos si hay que mostrar el aviso y la contraseña por defecto del admin
		#if ($this->defaultpass) {
		#	$this->doc->appendNode("adminpassword", $user->getProperty("defaultpass"));
		#}

		return $this->show();
	}

	private function home()
	{
		# Init
		$user   = User::getCurrentUser();
		$domain = $user->getProperty("domain");

		# Recorremos los softwares del usuario
		#$sql = "SELECT software.*, software_category.name AS categoryname
		#		FROM account_software
		#			LEFT JOIN software ON software.id = account_software.id_software
		#			LEFT JOIN software_category ON software_category.id = software.id_category
		#		WHERE id_account = %i
		#		ORDER BY software.order ASC
		#		";
		#Db::query($sql, array($user->getProperty("id_account")));
		#while ($data = Db::resultOne())
		#{
		#	$this->doc->appendNode("item", null, $data, "homecp");
		#}

	}

	private function pacs()
	{
		# Init
		$user   = User::getCurrentUser();

        if (isset($_GET['del']) && Dcm4chee::canDelete($_GET['del'])) {
            Dcm4chee::deleteWholeStudy($_GET['del']);
        }

        $page = intval($_GET['page']);
        $this->doc->appendNode("aet", strtolower($user->getProperty("login")), null, "client");
        $this->doc->appendNode("port", "12345", null, "client");
        $this->doc->appendNode("aet", strtoupper($user->getProperty("login")), null, "server");
        $this->doc->appendNode("ip", "192.168.69.1", null, "server");
        $this->doc->appendNode("port", "12345", null, "server");
        $this->doc->appendNode("next", $page+1);
        $this->doc->appendNode("curr", $page);
        $this->doc->appendNode("prev", $page-1 < 0 ? 0 : $page-1);
        $this->doc->appendNode("fname", $_REQUEST['name']);
        $this->doc->appendNode("fdesc", $_REQUEST['desc']);

        $sql = "
            SELECT DISTINCT study.pk, study.study_iuid, patient.pat_name, study.study_desc, study.mods_in_study, study.study_datetime
            FROM dcm4chee.study, dcm4chee.patient, dcm4chee.study_permission
            WHERE study.study_iuid = study_permission.study_iuid
            AND patient.pk = study.patient_fk
            AND study_permission.roles = %s
            AND patient.pat_name LIKE %s
            AND study.study_desc LIKE %s
            ORDER BY pk DESC
            LIMIT %i , 35;";
            
        Db::query($sql, array($user->getProperty("login"), 
                                "%".addslashes(trim($_REQUEST['name']))."%", 
                                "%".addslashes(trim($_REQUEST['desc']))."%", 
                                $page*35));
        while ($data = Db::resultOne())
        {
        $this->doc->appendNode("item", $data['study_iuid'], 
            array("pat_name" => htmlspecialchars(str_replace("^", " ", $data['pat_name'])), 
                "study_desc" => htmlspecialchars($data['study_desc']), 
                "study_type" => htmlspecialchars($data['mods_in_study']), 
                "date" => htmlspecialchars($data['study_datetime'])), "studies");
}


	}

	private function configAccount()
	{
		# Init
		$user = User::getCurrentUser();

		# Obtenemos la tematica del usuario
		#Db::query("SELECT * FROM thematic WHERE id_thematic = %i", array($user->getProperty("id_thematic")));
		#$tuser = Db::resultOne();

		#$idcat  = $_POST['thematic'] ? $_POST['thematic'] : $tuser['id_category'];
		#$idthe  = $_POST['thematicvalue'] ? $_POST['thematicvalue'] : $tuser['id_thematic'];
		$email  = $_POST['email'] ? $_POST['email'] : $user->getProperty("email");
		$cemail = $_POST['cemail'] ? $_POST['cemail'] : $user->getProperty("email");

		$passwd  = $_POST['passwd'] ? $_POST['passwd'] : null;
		$cpasswd = $_POST['cpasswd'] ? $_POST['cpasswd'] : null;

		# Comprobamos el email
		Db::query("SELECT * FROM account WHERE email = %s AND id_account <> %i", array(strtolower(trim($email)), $user->getProperty("id_account")));
		$existsemail = Db::resultOne();

		if ($email != $cemail)
		{
			$error = true;
			$this->doc->appendNode("error", "El e-Mail no coincide");
			$this->doc->appendNode("email", $email, array("class" => "error"));
			$this->doc->appendNode("cemail", $cemail, array("class" => "error"));
		}
		else if (!ereg("[a-zA-Z0-9\.\-_]*@[a-zA-Z0-9\.\-_]*\.[a-zA-Z]{2,4}", $email))
		{
			$error = true;
			$this->doc->appendNode("error", "El e-Mail es incorrecto");
			$this->doc->appendNode("email", $email, array("class" => "error"));
			$this->doc->appendNode("cemail", $cemail, array("class" => "error"));
		}
		else if ($existsemail)
		{
			$error = true;
			$this->doc->appendNode("error", "El e-Mail ya está asociado a Yourpacs");
			$this->doc->appendNode("email", $email, array("class" => "error"));
			$this->doc->appendNode("cemail", $cemail, array("class" => "error"));
		}
		else
		{
			$this->doc->appendNode("email", $email, array("class" => "text"));
			$this->doc->appendNode("cemail", $cemail, array("class" => "text"));
		}

		# Comprobamos las contraseñas
		if (empty($passwd) && empty($cpasswd))
		{
			$this->doc->appendNode("passwd", null, array("class" => "text"));
			$this->doc->appendNode("cpasswd", null, array("class" => "text"));
		}
		else if ($passwd != $cpasswd)
		{
			if (!$error) {
				$this->doc->appendNode("error", "Las contraseñas no coinciden");
			}
			$error = true;

			$this->doc->appendNode("passwd", $passwd, array("class" => "error"));
			$this->doc->appendNode("cpasswd", $cpasswd, array("class" => "error"));
		}
		else if (strlen($passwd) < 6)
		{
			if (!$error) {
				$this->doc->appendNode("error", "La contraseña es muy corta");
			}
			$error = true;

			$this->doc->appendNode("passwd", $passwd, array("class" => "error"));
			$this->doc->appendNode("cpasswd", $cpasswd, array("class" => "error"));
		}
		else
		{
			$passChanged = true;
			$this->doc->appendNode("passwd", null, array("class" => "text"));
			$this->doc->appendNode("cpasswd", null, array("class" => "text"));
		}

		# Cambiamos los datos
		if (isset($_POST['email']) && !$error)
		{
			if ($passChanged) {
				Db::query("UPDATE account SET email = %s, pass = %s, newsmail = %i WHERE id_account = %i", array(strtolower(trim($email)), $passwd, ($_POST['newsmail'] ? 1 : 0), $user->getProperty("id_account")));
			}
			else {
				Db::query("UPDATE account SET email = %s, newsmail = %i WHERE id_account = %i", array(strtolower(trim($email)), ($_POST['newsmail'] ? 1 : 0), $user->getProperty("id_account")));
			}
			$this->doc->appendNode("success", "Cambios guardados correctamente");

			# Guardamos registro de cambios
			$this->addLog($idaction = 4);
		}

		# Añadimos los nodos de las categorias
		#$sql = "SELECT *
		#		FROM category
		#			LEFT JOIN category_lang ON category_lang.id_category = category.id_category
		#		WHERE id_lang = %i
		#		ORDER BY 'order' ASC";
		#Db::query($sql, array(Lang::$id));
		#foreach (Db::result() as $data)
		#{
		#	# Creamos el nodo de la categoria
		#	$node  = $this->doc->appendNode("item", null, array("checked" => ($idcat == $data['id_category'] ? 1 : 0), "disabled" => ($idcat == $data['id_category'] ? 0 : 1), "name" => $data['name'], "id" => $data['id_category']), "category");
		#	$node2 = $this->doc->appendNode("thematic", null, null, $node);

		#	# Obtenemos las tematicas
		#	$sql = "SELECT *
		#			FROM thematic
		#				LEFT JOIN thematic_lang ON thematic_lang.id_thematic = thematic.id_thematic
		#			WHERE
		#				id_lang = %i AND
		#				id_category = %i
		#			ORDER BY name ASC";
		#	Db::query($sql, array(Lang::$id, $data['id_category']));
		#	foreach (Db::result() as $data2) {
		#		$this->doc->appendNode("item", $data2['name'], array("id" => $data2['id_thematic'], "selected" => ($idthe == $data2['id_thematic'] ? 1 : 0)), $node2);
		#	}
		#}

		if ($_POST['email']) {
			$this->doc->appendNode("checknewsmail", ($_POST['newsmail'] ? 1 : 0));
		}
		else {
			$this->doc->appendNode("checknewsmail", $user->getProperty("newsmail"));
		}

	}

/*	private function upgrade()
	{
		# Init
		$user = User::getCurrentUser();

        $sql = "SELECT type
                FROM account
                WHERE id_account = %i
                LIMIT 1";
        Db::query($sql, array($user->getProperty("id_account")));
        if ($data = Db::resultOne()) {
            $this->doc->appendNode("item", $data['type'], null, "accounttype");
        }
	}
	private function payments()
	{
		# Init
		$user = User::getCurrentUser();

		$sql = "SELECT *
				FROM account_payment
				WHERE id_account = %i
				ORDER BY date DESC";
		Db::query($sql, array($user->getProperty("id_account")));
		while ($data = Db::resultOne())
		{
			$this->doc->appendNode("item", null, array("date" => date("d-m-Y H:i", strtotime($data['date'])), "concept" => $data['concept'], "ammount" => $data['ammount'], "currency" => $data['currency']), "payments");
		}

        $sql = "SELECT type
                FROM account
                WHERE id_account = %i
                LIMIT 1";
        Db::query($sql, array($user->getProperty("id_account")));
        if ($data = Db::resultOne()) {
            $this->doc->appendNode("item", $data['type'], null, "accounttype");
        }
	}

*/
	private function searchUser()
	{
		# Init
		$user = User::getCurrentUser();
        $error = true;
        $filter = $_POST['filter'];

        if (isset($filter)) {
		    Db::query("SELECT login FROM account WHERE ((email LIKE %s) OR (login LIKE %s))", 
                array("%".strtolower(trim($filter))."%", "%".strtolower(trim($filter))."%"));

            while ($data = Db::resultOne()) {
                $this->doc->appendNode("item", null, array("user" => $data['login'], "aet" => strtoupper($data['login']), "ip" => "192.168.69.1", "port" => "12345"), "users");
            }
             $this->doc->appendNode("filter", $filter);
        } 
    }

	private function logAccess()
	{
		# Init
		$user = User::getCurrentUser();

		$sql = "SELECT *
			    FROM account_action
			    LEFT JOIN action ON action.id_action = account_action.id_action
			    WHERE
			    	id_account = %i AND
			    	id_lang = %i
			    ORDER BY date DESC";
		Db::query($sql, array($user->getProperty("id_account"), Lang::$id));
		while ($data = Db::resultOne())
		{
			$this->doc->appendNode("item", $data['content'], array("date" => date("d-m-Y H:i", strtotime($data['date']))), "logaccess");
		}
	}

	private function invitation()
	{
		# Init
		$user = User::getCurrentUser();
        $name = $_POST['name'];
        $email = $_POST['email'];        
        $error = false;
		# Comprobamos el email
		Db::query("SELECT * FROM account WHERE email = %s", array(strtolower(trim($email))));
		$existsemail = Db::resultOne();

        if (isset($email)) {
            if (!ereg("[a-zA-Z0-9\.\-_]*@[a-zA-Z0-9\.\-_]*\.[a-zA-Z]{2,4}", $email))
		    {
		    	$error = true;
		    	$this->doc->appendNode("error", "El e-Mail es incorrecto");
		    	$this->doc->appendNode("email", $email, array("class" => "error"));
			    $this->doc->appendNode("success", 0);
		    }
		    else if ($existsemail)
		    {
		    	$error = true;
		    	$this->doc->appendNode("error", "El e-Mail ya está registrado a Yourpacs");
		    	$this->doc->appendNode("email", $email, array("class" => "error"));
			    $this->doc->appendNode("success", 0);
		    }
		    else
		    {
		    	$this->doc->appendNode("email", $email, array("class" => "text"));

		        # Enviamos el mail con los datos
		        $headers  = "From: Yourpacs <support@yourpacs.com>\n";
		        $headers .= "Reply-To: Yourpacs <support@yourpacs.com>\n";
		        $headers .= "Return-Path: Yourpacs <support@yourpacs.com>\n";    // these two to set reply address
		        $headers .= "X-Mailer: PHP v".phpversion()."\n";          // These two to help avoid spam-filters
		        $headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
		        $headers .= "MIME-Version: 1.0\n\n";

		        $body = Lang::get("email", "invbody");
                $body = str_replace("[%USER%]", $user->getProperty("login"), $body);
                $body = str_replace("[%EMAIL%]", $user->getProperty("email"), $body);

		        mail($email, Lang::get("email", "invsubject"), $body, $headers);
			    $this->doc->appendNode("success", 1);
		    }
        } else {
		    $this->doc->appendNode("email", $email, array("class" => "text"));
        }
	}

	function addLog($idaction)
	{
		$user = User::getCurrentUser();
		Db::query("SELECT * FROM account_action ORDER BY date DESC");
		if (Db::num() > 50)
		{
			$data = Db::resultOne();
			Db::query("DELETE FROM account_action WHERE id = %i", array($data['id']));
		}

		Db::query("INSERT INTO account_action (id_account, id_action, date) VALUES (%i, %i, NOW())", array($user->getProperty("id_account"), $idaction));
	}


}
