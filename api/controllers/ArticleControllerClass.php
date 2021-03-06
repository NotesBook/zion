<?php
/**
 * NotesBook ArticleControllerClass
 *
 * @author     Nombre <email@email.com>
 * @package    \app\controllers
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class ArticleController extends BaseController {

		public function __construct() {

			$domain_name = str_replace("Controller", "", static::class);

			parent::__construct($domain_name);

		}

		/* Method POST
		 * Save artile data
		 */
		public function save() {

			global $_NB_GLOBALS; 
			
			//1. Get fields from $request_body
			$request_body = HttpEngineService::get_array_from_json_body();

			$article_id = isset($request_body["article_id"]) ? $request_body["article_id"] : null; 
			$classroom_id = $request_body["classroom_id"]; 
			$author_id = isset($request_body["user_id"]) ? $request_body["user_id"] : SessionManager::get_session_user()["id"]; 
			$title = $request_body["title"]; 
			$body = $request_body["body"];  
			$tags = $request_body["tags"]; 
			$topic = $request_body["topic"]; 

			//2. Check if data is correct
			Article::check_data($author_id, $classroom_id, $title, $body, $tags, $topic);

			//3. Save
			$article_id = ArticleRepository::save($author_id, $classroom_id, $title, $body, $tags, $topic, $article_id);

			self::refresh_session();

			//5. Return Ok
			return FormattedRequest::format(true, $article_id);
		}

		/* Method GET
		 * Get article data
		 */
		public function get_by_id() {

			$article_id = RoutingEngineService::get_params()[0];

			//1. GET
			$article = ArticleRepository::get_by_id($article_id);

			return FormattedRequest::format(true, $article);

		}

		/* Method GET
		 * Get article data
		 */
		public function like() {

			$article_id = RoutingEngineService::get_params()[0];

			//1. GET
			ArticleRepository::like($_SESSION["user"]["id"], $article_id);

			self::refresh_session();

			return FormattedRequest::format(true);

		}

		/* Method GET
		 * Get article data
		 */
		public function unlike() {

			$article_id = RoutingEngineService::get_params()[0];

			//1. GET
			$article = ArticleRepository::unlike($_SESSION["user"]["id"], $article_id);

			self::refresh_session();

			return FormattedRequest::format(true);

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

			//1. Get my classrooms
			$user_id = $_SESSION["user"]["id"];
			$classrooms = ClassroomRepository::get_all_by_user($user_id);

			//2. Get last_articles by my classrooms
			$articles = array();
			foreach ($classrooms as $key => $classroom) {
				
				$articles = array_merge($articles, ArticleRepository::get_all_by_classroom($classroom->get_id()));

			}

			//2. Order by votations desc
			function votation_articles_order_compare($a, $b) {

				return ($a->get_likes_count() > $b->get_likes_count()) ? -1 : 1;

			}

			usort($articles, "votation_articles_order_compare");

			$articles = array_slice($articles, 0, 3);

			//5. Return Ok
			return FormattedRequest::format(true, $articles);
		}

	}
