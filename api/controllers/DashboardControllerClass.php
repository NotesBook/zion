<?php
/**
 * NotesBook DashboardControllerClass
 *
 * @author     Nombre <email@email.com>
 * @package    \app\controllers
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class DashboardController extends BaseController {

		public function __construct() {

			$domain_name = str_replace("Controller", "", static::class);
			
			SessionManager::verify_session_or_redirect();

			parent::__construct($domain_name);

		}

		/* Method GET
		 * Last Articles Order by Activity
		 */
		public function last_articles() {

			//1. Get my classrooms
			$user_id = $_SESSION["user"]["id"];
			$classrooms = ClassroomRepository::get_all_by_user($user_id);

			//2. Get last_articles by my classrooms
			$articles = array();
			foreach ($classrooms as $key => $classroom) {
				
				$articles[] = ArticleRepository::get_all_by_classroom($classroom->get_id());

			}

			//5. Return Ok
			return FormattedRequest::format(true, $articles);

		}

		/* Method GET
		 * My enrolled classrooms
		 */
		public function my_classrooms() {

			//1. Get my classrooms
			$user_id = $_SESSION["user"]["id"];
			$classrooms = ClassroomRepository::get_all_by_user($user_id);

			//5. Return Ok
			return FormattedRequest::format(true, $classrooms);

		}

	}
