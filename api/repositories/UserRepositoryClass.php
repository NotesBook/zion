<?php 
/**
 * NotesBook User Repository
 *
 * @author     Nombre <email@email.com>
 * @package    \application\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class UserRepository extends BaseRepository {

		public static function get_all() {

			$database_result = parent::select("notesbook.users", array("id", "name"));

			$array_obj_result = array();
			while($user_tupla = $database_result->fetch_array()) {

				$array_obj_result[] = new User($user_tupla["id"], $user_tupla["name"]);
			}

			return $array_obj_result;

		}

	}