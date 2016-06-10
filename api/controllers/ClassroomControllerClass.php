<?php
/**
 * NotesBook ClassroomControllerClass
 *
 * @author     Nombre <email@email.com>
 * @package    \app\controllers
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class ClassroomController extends BaseController {

		public function __construct() {

			$domain_name = str_replace("Controller", "", static::class);

			parent::__construct($domain_name);

		}

		/* Method POST
		 * Save new classroom data
		 */
		public function register() {

			global $_NB_GLOBALS; 
			
			//1. Get fields from $request_body
			$request_body = HttpEngineService::get_array_from_json_body();

			$name = $request_body["name"]; 
			$category = $request_body["category"]; 
			$subcategory = $request_body["subcategory"]; 
			$description = $request_body["description"]; 

			//2. Check if data is correct
			Classroom::check_data($name, $category, $subcategory, $description);

			//3. Save
			//3.1. Generate Random Password
		    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		    $invitation_code = substr( str_shuffle( $chars ), 0, 8 );
		    $md5_password = md5($invitation_code);	

			//3.2. Save
			$classroom_id = ClassroomRepository::register($name, $category, $subcategory, $description, $invitation_code);

			//3.3 Enroll Session User to Classroom
			ClassroomRepository::enroll_user($_SESSION["user"]["id"], $classroom_id, $invitation_code);

			//4. Send Email
			//4.1 Compose Email
			$email_html = file_get_contents("mails/welcome_classroom_mail.html");
		    $email_html = str_replace("%%INVITATIONCODE%%", $invitation_code, $email_html);
		    $email_html = str_replace("%%NAME%%", $name, $email_html);
		    $email_html = str_replace("%%USERNAME%%", $_SESSION["user"]["name"], $email_html);

			MailEngineService::send("Aula Creada", $email_html, $_SESSION["user"]["email"]);

			//5. Return Ok
			return FormattedRequest::format(true);
		}

		/* Method POST
		 * Enroll classroom
		 */
		public function enroll($id_user, $classroom_id, $invitation_code) {

			//1 Enroll Session User to Classroom
			ClassroomRepository::enroll_user($id_user, $classroom_id, $invitation_code);

		}

		/* Method GET
		 * Last Articles Order by Activity
		 * param 0, classroom_id
		 */
		public function last_articles() {

			$classroom_id = RoutingEngineService::get_params()[0];
			//1. Get last articles by activity
			//TODO:
 			http_response_code(501);

			//5. Return Ok
			return FormattedRequest::format(false, "Not implemented");

		}

	}
