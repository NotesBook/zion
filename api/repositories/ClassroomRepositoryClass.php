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
		public static function register($name, $category, $subcategory, $description, $invitation_code, $user_id) {

			//Generate random code

			$classroom_id = parent::insert("classrooms", 
				"name, category, subcategory, description, invitation_code",
				"'$name', '$category', '$subcategory', '$description', '$invitation_code'");

			UserRepository::modify_karma(User::KARMA_CREATE_CLASSROOM, $user_id);

			return $classroom_id;

		}	

		/*
		 * Enroll user in database
		 */
		public static function enroll_user($user_id, $invitation_code) {


			//1. Check if classroom_id has this invitation_code
			$database_classroom_result = parent::select("classrooms", array("*"), "invitation_code = '$invitation_code'");
			$classroom_tupla = $database_classroom_result->fetch_array();
			$classroom_id = $classroom_tupla["id"];

			if ($database_classroom_result->num_rows) {

				$database_user_classroom_result = parent::select("classrooms_users", array("*"), "classroom_id = $classroom_id AND user_id = $user_id");

				if ($database_user_classroom_result->num_rows == 0) {

		 				$date = date('Y/m/d H:i:s');

						UserRepository::modify_karma(User::KARMA_ENROLL_CLASSROOM, $user_id);

						//2. Insert into classrooms_users new field, with actual date
						parent::insert("classrooms_users", 
							"user_id, classroom_id, date",
							"$user_id, $classroom_id, '$date'");

				}

			} else {

				throw new Exception('Code is incorrect');

			}

			return $classroom_id;

		}	

		/*
		 * Unenroll user in database
		 */
		public static function unenroll_user($user_id, $classroom_id) {

			//1. Delete classrooms_users field with $user_id and $classroom_id 
			$database_user_classroom_result = parent::select("classrooms_users", array("*"), "id = $classroom_id AND user_id = $user_id");

			if ($database_user_classroom_result) {

				//2. Delete classroom_user
				$classroom_user_tupla = $database_user_classroom_result->fetch_array();
				parent::delete("classrooms_users", "user_id = ".$classroom_user_tupla["user_id"]." AND classroom_id = ".$classroom_user_tupla["classroom_id"]);

			}

		}

		public static function get_by_id($id) {

			$database_result = parent::select("classrooms", array("*"),
			 						"id = $id");

			$array_obj_result = array();
			$classroom_tupla = $database_result->fetch_array();

			$classroom = new Classroom($classroom_tupla["id"], $classroom_tupla["name"], $classroom_tupla["category"], $classroom_tupla["subcategory"], $classroom_tupla["description"], $classroom_tupla["image_path"], $classroom_tupla["invitation_code"], $classroom_tupla["entry_date"]);

			return $classroom;	

		}

		public static function get_all() {

			//TODO:

		}

		public static function get_all_by_user($user_id) {

			$database_result = parent::select("classrooms_users", array("classroom_id"), "user_id = $user_id");

			$array_obj_result = array();
			while($classroom_user_tupla = $database_result->fetch_array()) {

				$database_classrooms_result = parent::select("classrooms", array("*"), "id = ".$classroom_user_tupla["classroom_id"]);
				$classroom_tupla = $database_classrooms_result->fetch_array();

				$array_obj_result[] = new Classroom($classroom_tupla["id"], $classroom_tupla["name"], $classroom_tupla["category"], $classroom_tupla["subcategory"], $classroom_tupla["description"], $classroom_tupla["image_path"], $classroom_tupla["invitation_code"]);

			}

			return $array_obj_result;

		}

	}