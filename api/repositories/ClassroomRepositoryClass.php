<?php 
/**
 * NotesBook Classroom Repository
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

			//TODO:

		}

		public static function get_all() {

			//TODO:

		}

		public static function get_all_by_user() {

			//TODO:

		}

	}