<?php 
/**
 * NotesBook Session Manager
 *
 * @author     Nombre <email@email.com>
 * @package    \api\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	session_start($_COOKIE['PHPSESSID']);

	class SessionManager {

		public static function start($user) {

		  	self::set_session_user($user);

		}

		public static function logout() {

			$_SESSION['user'] = null;
			session_destroy();

		}

		public static function get_session_user() {

			return $_SESSION['user'];

		}

		public static function set_session_user($user) {

			$_SESSION['user'] = $user->jsonSerialize($user);

		}

		public static function get_session_id() {

			return session_id();

		}


		public static function check_session_token() {

			if(!isset($_SESSION['user'])) {
				return false;
			} else {
				return true;
			}

		}

		public static function verify_session_or_redirect() {

			if (!self::check_session_token()) {
				http_response_code(405);
				exit();
			}

		}
		
	}

?>