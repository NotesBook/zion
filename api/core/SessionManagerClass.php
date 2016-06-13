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

			if (!isset($_SESSION['user'])) {
				/*start session*/
			  	$_SESSION['user'] = $user->jsonSerialize();
			}

		}

		public static function logout() {

			$_SESSION['user'] = null;
			session_destroy();

		}

		public static function get_session_user() {

			return $_SESSION['user'];

		}

		public static function get_session_id() {

			return session_id();

		}


		public static function check_session_token() {

			if(!isset($_SESSION['user'])) {
				http_response_code(405);
				return false;
			} else {
				return true;
			}

		}
		
	}

?>