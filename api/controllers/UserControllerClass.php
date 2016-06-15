<?php
/**
 * NotesBook UserControllerClass
 *
 * @author     Nombre <email@email.com>
 * @package    \app\controllers
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class UserController extends BaseController {

		public function __construct() {

			$domain_name = str_replace("Controller", "", static::class);

			parent::__construct($domain_name);

		}

		/* Method GET
		 * Check email exists
		 */
		public function check_email_exists() {

			$params = RoutingEngineService::get_params();
			$email = $params[0];

			$email_is_free = UserRepository::check_email_exists($email);

			return FormattedRequest::format($email_is_free);

		}

		/* Method POST
		 * Save new user data from register
		 */
		public function register() {

			global $_NB_GLOBALS; 
			
			//1. Get User's fields from $request_body
			$request_body = HttpEngineService::get_array_from_json_body();

			$name = $request_body["name"]; 
			$surname = $request_body["surname"]; 
			$birthdate = $request_body["birthdate"]; 
			$country = $request_body["country"]; 
			$region = $request_body["region"]; 
			$email = $request_body["email"]; 

			//2. Check if data is correct
			User::check_data($name, $surname, $birthdate, $country, $region, $email);

			//3. Save User
			//3.1. Generate Random Password
		    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		    $password = substr( str_shuffle( $chars ), 0, 8 );
		    $md5_password = md5($password);	

			//3.2. Save User
			$security_code = UserRepository::register($name, $surname, $birthdate, $country, $region, $email, $md5_password);

			//4. Send Email
			//4.1 Compose Email
			$email_html = file_get_contents("mails/validate_user_mail.html");
		    $email_html = str_replace("%%PASSWORD%%", $password, $email_html);
		    $email_html = str_replace("%%URL_VALIDATE_USER%%", $_NB_GLOBALS["settings"]->baseurl."#/user/validation/$email/".$security_code, $email_html);

			MailEngineService::send("Usuario registrado. ConfirmarCuenta", $email_html, $email);

			//5. Return Ok
			return FormattedRequest::format(true);
		}


		/* Method POST
		 * Save new user data
		 */
		public function save() {
			
			//1. Get User's fields from $request_body
			$request_body = HttpEngineService::get_array_from_json_body();

			$name = $request_body["name"]; 
			$surname = $request_body["surname"]; 
			$birthdate = $request_body["birthdate"]; 
			$country = $request_body["country"]; 
			$region = $request_body["region"]; 
			$email = $request_body["email"]; 

			//2. Check if data is correct
			User::check_data($name, $surname, $birthdate, $country, $region);

			//3.2. Save User
			UserRepository::save($_SESSION['user']['id'], $name, $surname, $birthdate, $country, $region);

			self::refresh_session();

			//5. Return Ok
			return FormattedRequest::format(true);

		}

		/* Method POST
		 * Login and return TOKEN
		 */
		public function login() {
			//1. Get User's fields from $request_body
			$request_body = HttpEngineService::get_array_from_json_body();

			$email = $request_body["email"]; 
			$password = $request_body["password"]; 

			$user_result = UserRepository::login($email, md5($password));
			$user_tupla = $user_result->fetch_array();
			$login_valid = $user_tupla["user_count"]; //Valid if exits

			if ($login_valid) {

				$token = bin2hex(openssl_random_pseudo_bytes(16));
				UserRepository::start_session($user_tupla["id"], $token);

				$user_obj = UserRepository::get_by_id($user_tupla["id"]);

				SessionManager::start($user_obj);

				return FormattedRequest::format(true, $token);

			} else {

				http_response_code(405);
				return FormattedRequest::format(false, "", "Invalid Login");

			}

		}

		public function refresh_session() {

			$user_obj = UserRepository::get_by_id($_SESSION['user']['id']);

			SessionManager::set_session_user($user_obj);

		}

		/* Method POST
		 * Upload avatar
		 */
		public function upload_avatar() {

			$identifier = md5(uniqid(rand(), true));
			$image_name = $identifier.".".substr(strrchr($_FILES['avatar']['name'],'.'),1);

			move_uploaded_file($_FILES['avatar']['tmp_name'], '../avatars/'.$image_name);

			UserRepository::upload_avatar($_SESSION['user']['id'], $image_name);

			self::refresh_session();

			return FormattedRequest::format(true, "avatars/".$image_name);

		}

		/* Method GET
		 * Get session user
		 */
		public function get_logged_user_data() {

			SessionManager::verify_session_or_redirect();
			return FormattedRequest::format(true, $_SESSION['user'],"");

		}

		/* Method GET
		 * Get session user
		 */
		public function get_by_id() {

			$params = RoutingEngineService::get_params();
			$user_id = $params[0];

			$user_obj = UserRepository::get_by_id($user_id);
			return FormattedRequest::format(true, $user_obj);

		}



		/* Method GET
		 * Logout delete TOKEN
		 */
		public function logout() {

			SessionManager::logout();
			return FormattedRequest::format(true);

		}

		/* Method GET
		 * Activate User After Validation
		 */
		public function active() {

			$params = RoutingEngineService::get_params();
			$email = $params[0];
			$security_code = $params[1];

			$activation_ok = UserRepository::active($email, $security_code);
			return FormattedRequest::format($activation_ok, "", $activation_ok ? "" : "Código o usuario incorrectos para la activación");

		}

		/* Method GET
		 * Get Validation Json
		 */
		public function validationJson() {

			return FormattedRequest::format(true,User::get_validationJson(),"");

		}

		/* Method GET
		 * Check Session
		 */
		public function check_session() {

			//CheckSession
			$valid_session = SessionManager::check_session_token();
			
			return FormattedRequest::format(true, array("active_session" => $valid_session));

		}

		public function send_classroom_invitation() {

			$params = RoutingEngineService::get_params();
			$email = $params[0];
			$classroom_id = $params[1];

			$classroom = ClassroomRepository::get_by_id($classroom_id);

			//4. Send Email
			//4.1 Compose Email
			$email_html = file_get_contents("mails/invite_user_mail.html");
			
		    $email_html = str_replace("%%CLASSROOM_NAME%%", $classroom->get_name(), $email_html);
		    $email_html = str_replace("%%INVITATION_CODE%%", $classroom->get_invitation_code(), $email_html);

			MailEngineService::send("Has sido invitado al aula: ".$classroom->get_name(), $email_html, $email);

			//5. Return Ok
			return FormattedRequest::format(true);

		}

	}
