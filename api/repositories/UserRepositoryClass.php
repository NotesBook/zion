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

			global $_NB_GLOBALS;

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
		public static function register($name, $surname, $birthdate, $country, $region, $email) {

			global $_NB_GLOBALS;

			//Generate random code
			$security_code = md5(uniqid(rand(), true));

			parent::insert("users", 
				"name, surname, birthdate, country, region, email, security_code",
				"'$name', '$surname', STR_TO_DATE('$birthdate','%d/%m/%Y'), '$country', '$region', '$email', '$security_code'");

			return $security_code;

		}

		public static function get_by_id($id) {

			global $_NB_GLOBALS;

			$database_result = parent::select("users", array("id", "name"), "id = $id");

			$array_obj_result = array();
			while($user_tupla = $database_result->fetch_array()) {

				$array_obj_result[] = new User($user_tupla["id"], $user_tupla["name"]);
			}

			return $array_obj_result;

		}

	}