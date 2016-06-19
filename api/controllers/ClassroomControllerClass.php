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
			
			SessionManager::verify_session_or_redirect();

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

			//3.2. Save
			$classroom_id = ClassroomRepository::register($name, $category, $subcategory, $description, $invitation_code, $_SESSION["user"]["id"]);

			//3.3 Enroll Session User to Classroom
			ClassroomRepository::enroll_user($_SESSION["user"]["id"], $invitation_code);

			//4. Send Email
			//4.1 Compose Email
			$email_html = file_get_contents("mails/welcome_classroom_mail.html");
		    $email_html = str_replace("%%INVITATIONCODE%%", $invitation_code, $email_html);
		    $email_html = str_replace("%%NAME%%", $name, $email_html);
		    $email_html = str_replace("%%USERNAME%%", $_SESSION["user"]["name"], $email_html);

			MailEngineService::send("Aula Creada", $email_html, $_SESSION["user"]["email"]);

			self::refresh_session();

			//5. Return Ok
			return FormattedRequest::format(true, $classroom_id);
		}

		/* Method GET
		 * Get article data
		 */
		public function get_by_id() {

			$classroom_id = RoutingEngineService::get_params()[0];

			//1. GET
			$classroom = ClassroomRepository::get_by_id($classroom_id);

			return FormattedRequest::format(true, $classroom);

		}

		/* Method POST
		 * Enroll classroom
		 */
		public function enroll() {

			$invitation_code = RoutingEngineService::get_params()[0];

			//TODO: get id user from session
			$id_user = $_SESSION["user"]["id"];

			//1 Enroll Session User to Classroom
			$classroom_id = ClassroomRepository::enroll_user($id_user, $invitation_code);

			self::refresh_session();

			return FormattedRequest::format(true, $classroom_id);

		}

		/* Method POST
		 * Unenroll classroom
		 */
		public function unenroll($id_user, $classroom_id) {

			//1 Unenroll Session User to Classroom
			ClassroomRepository::unenroll_user($id_user, $classroom_id);
			return FormattedRequest::format(true);

		}

		/* Method GET
		 * Last Articles Order by Activity
		 * param 0, classroom_id
		 */
		public function last_articles() {
			
			$classroom_id = RoutingEngineService::get_params()[0];
			//1. Get last articles by activity
			$articles = ArticleRepository::get_all_by_classroom($classroom_id);
			//5. Return Ok
			return FormattedRequest::format(true, $articles);
		}

		public function refresh_session() {

			$user_obj = UserRepository::get_by_id($_SESSION['user']['id']);

			SessionManager::set_session_user($user_obj);

		}

		/* Method GET
		 * Articles most popular
		 * param 0, classroom_id
		 */
		public function get_most_popular_articles() {
			
			$classroom_id = RoutingEngineService::get_params()[0];
			
			//1. Get last articles by activity
			$articles = ArticleRepository::get_most_popular_by_classroom($classroom_id);

			//5. Return Ok
			return FormattedRequest::format(true, $articles);
		}
	}
