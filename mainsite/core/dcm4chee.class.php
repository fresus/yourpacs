<?php
/**
Connect
@file connect.class.php
@class Connect
@version 1.0
@date 17 de marzo del 2007
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

class Dcm4chee
{
	static public $command;
	static public $result;
    static public $TWIDDLE  = "sudo -u pacs /opt/dcm4chee/bin/twiddle.sh -uadmin -padmin ";
	/** ************************************************************************
	* Constructor:
	***************************************************************************/
	function __construct() {}

	/** ************************************************************************
	* command:
	*   - Envia un comando al servidor
	*   - @param command string
	*   - @return bool
	***************************************************************************/
	static public function command($command)
	{
		# Init
		$return        = null;
		$socket        = fsockopen("localhost", 8900, $errno, $errstr, 2);
		self::$command = trim($command) . chr(0);

		if (!$socket) {
			return false;
		}
		else
		{
			fwrite($socket, self::$command);

			while (!feof($socket)) {
				$return .= fgets($socket);
			}
			fclose($socket);

			self::$result = $return;
		}

		return true;
	}

    // Delete a study
    static public function deleteWholeStudy($studyIUID) {
        //TODO: filtrar studyUID per les comandes bash
        $command = self::$TWIDDLE . "invoke dcm4chee.archive:service=FileSystemMgt,group=ONLINE_STORAGE scheduleStudyForDeletion ". $studyIUID;        
        self::$result = exec($command);        
        Db::query("DELETE FROM dcm4chee.study_permission WHERE study_iuid = %s", array(addslashes($studyIUID)));
        return true;
    }

    // Check that the user has permissions to delete the study
    static public function canDelete($studyIUID) {
        $user = User::getCurrentUser();
        Db::query("SELECT count(*) as sum FROM dcm4chee.study_permission WHERE roles = %s", array($user->getProperty("login")));
        $data = Db::resultOne();
        if ($data['sum'] == 0) return false;
        else return true;
    }

    static public function addUser($login, $host) {
        // Afegir aet
        $sql = "INSERT INTO dcm4chee.ae 
                (aet, hostname, port, pat_id_issuer, user_id, passwd)
                VALUES (%s, %s, 1234, %s, %s, %s), (%s, 'localhost', 11112, %s, %s, %s)";
        Db::query($sql, array($login, $host, $login, $login, $login, strtoupper($login), $login, $login, $login));

        // Afegir aet com a storescp i queryretrive
        $command = self::$TWIDDLE . "get dcm4chee.archive:service=StoreScp CalledAETitles | cut -d '=' -f 2";
        $currAET = exec($command);
        $command = self::$TWIDDLE . "set dcm4chee.archive:service=StoreScp CalledAETitles '$currAET\\".strtoupper($login)."'";
        exec($command);
        $command = self::$TWIDDLE . "set dcm4chee.archive:service=QueryRetrieveScp CalledAETitles '$currAET\\".strtoupper($login)."'";
        exec($command);


        // Afegir usuari
        $command = "sudo -u pacs java -jar /opt/dcm4chee/bin/pwd2hash.jar ". $login ." | cut -d ':' -f 2";
        $pass_hash = exec($command);
        $sql = "INSERT INTO dcm4chee.users
                (user_id, passwd)
                VALUES (%s, %s)";
        Db::query($sql, array($login, $pass_hash));

        // Assignar-li només el seu rol
        $sql = "INSERT INTO dcm4chee.roles
                (user_id, roles)
                VALUES (%s, %s)";
        Db::query($sql, array($login, $login));

        // Netejar AET cache
        $command = self::$TWIDDLE . "invoke dcm4chee.archive:service=AE clearCache";
        exec($command);

        return true;
    }

    // Assign 4 new ips for user $id and return the one assigned to the host
    static public function createIps($id, $login) {

        # Afegim les ips assignades a l'usuari
        $sql = "SELECT ip FROM ips ORDER BY pk DESC LIMIT 1";
        Db::query($sql);
        $data = Db::resultOne();
        $ip = preg_split('/\./', $data['ip']);
        if ($ip[3] < 252) {
            $base = $ip[0].".".$ip[1].".".$ip[2].".";
            $sql = "INSERT INTO ips (account_fk, ip) 
                    VALUES (%i, %s), (%i, %s), (%i, %s), (%i, %s)";
            Db::query($sql, array($id, $base.($ip[3]+1), $id, $base.($ip[3]+2), $id, $base.($ip[3]+3), $id, $base.($ip[3]+4)));
            $data = "ifconfig-push ".$base.($ip[3]+2)." ".$base.($ip[3]+3)."\n";
            self::$result = $base.($ip[3]+2);
        } 
        else {
            $ip[2]++;
            $base = $ip[0].".".$ip[1].".".$ip[2].".";
            $sql = "INSERT INTO ips (account_fk, ip) 
                    VALUES (%i, %s), (%i, %s), (%i, %s), (%i, %s)";
            Db::query($sql, array($id, $base."0", $id, $base."1", $id, $base."2", $id, $base."3"));
            $data = "ifconfig-push ".$base."1 ".$base."2\n";
            self::$result = $base."1";
        }

        // Create openvpn file
        $fd = fopen("/etc/openvpn/ccd/".$login, 'w');
        fwrite($fd, $data);
        fclose($fd);

        return True;
    }
    
}
