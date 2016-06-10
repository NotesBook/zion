<?php 
/**
 * NotesBook User Repository
 *
 * @author     Nombre <email@email.com>
 * @package    \application\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class UserRepository extends BaseRepository implements IBaseRepository {

		public static function get_all() {

			$database_result = parent::select("users", array("id", "name", "surname", "birthdate", "country", "region", "email"));

			$array_obj_result = array();
			while($user_tupla = $database_result->fetch_array()) {

				$array_obj_result[] = new User($user_tupla["id"], $user_tupla["name"], $user_tupla["surname"], $user_tupla["birthdate"], $user_tupla["country"], $user_tupla["region"], $user_tupla["email"]);

			}

			return $array_obj_result;

		}

		/* 
		 * return: security_code 
		 */
		public static function register($name, $surname, $birthdate, $country, $region, $email, $password) {

			//Generate random code
			$security_code = md5(uniqid(rand(), true));

			parent::insert("users", 
				"name, surname, birthdate, country, region, email, security_code, password",
				"'$name', '$surname', STR_TO_DATE('$birthdate','%d/%m/%Y'), '$country', '$region', '$email', '$security_code', '$password'");

			return $security_code;

		}


		public static function check_email_exists($email) {

			$email_field = array("email");
			$email_exists = parent::select("users",$email_field,"email = '$email'","");

			if($email_exists->num_rows == 0) {
				return true;
		    } else return false;
		    
		}		

		public static function get_by_id($id) {

			$database_result = parent::select("users", array("id", "name", "surname", "birthdate", "country", "region", "email", "session_code"), "id = $id");

			$array_obj_result = array();
			while($user_tupla = $database_result->fetch_array()) {
				//$id, $name, $surname, $birthdate, $country, $region, $email
				$array_obj_result[] = new User($user_tupla["id"], $user_tupla["name"], $user_tupla["surname"], $user_tupla["birthdate"], $user_tupla["country"], $user_tupla["region"], $user_tupla["email"]);

			}

			return $array_obj_result;

		}


		public static function login($email, $password) {

			$result = parent::select("users", array("COUNT(*) as user_count", "id"), "email = '$email' AND password = '$password'");

			return $result;

		}


		public static function start_session($id, $session_code) {

			parent::update("users", 
				"last_session_date = STR_TO_DATE('".date('d/m/Y h:m:s', time())."','%d/%m/%Y'), session_code = '$session_code'",
				"id = '".$id."'");

		}

		/* 
		 * 
		 */
		public static function active($email, $token) {

			$result = parent::select("users", array("id"), "email = '$email' AND security_code = '$token'");
	        if($result->num_rows > 0) {
				$user_tupla = $result->fetch_array();
				parent::update("users", 
					"entry_date = STR_TO_DATE('".date('d/m/Y', time())."','%d/%m/%Y'), security_code = ''",
					"id = '".$user_tupla['id']."'");

				return true;
	        }

			return false;

		}

	}