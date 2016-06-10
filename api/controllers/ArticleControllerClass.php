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
			ArticleRepository::save($author_id, $classroom_id, $title, $body, $tags, $topic, $article_id);

			//5. Return Ok
			return FormattedRequest::format(true);
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
			$article = ArticleRepository::like($_SESSION["user"]["id"], $article_id);

			return FormattedRequest::format(true);

		}

		/* Method GET
		 * Get article data
		 */
		public function likes_count() {
			
			$article_id = RoutingEngineService::get_params()[0];

			//1. GET
			$likes_count = ArticleRepository::likes_count($article_id);

			return FormattedRequest::format(true, $likes_count);

		}

	}
