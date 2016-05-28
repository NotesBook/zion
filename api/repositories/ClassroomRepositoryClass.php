<?php 
/**
 * NotesBook User Repository
 *
 * @author     Nombre <email@email.com>
 * @package    \application\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class ClassroomRepository extends BaseRepository implements IBaseRepository {

		/* 
		 * return: invitation_code 
		 */
		public static function register($name, $category, $subcategory, $description, $invitation_code) {

			//Generate random code
			$invitation_code = md5(uniqid(rand(), true));

			parent::insert("classrooms", 
				"name, category, subcategory, description, invitation_code",
				"'$name', '$category', '$subcategory', '$description', '$invitation_code'");

			return $invitation_code;

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

		public static function get_all() {

			//TODO:

		}

	}