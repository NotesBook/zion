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

			$aula_id = $request_body["aula_id"]; 
			$title = $request_body["title"]; 
			$tags = $request_body["tags"]; 
			$category = $request_body["category"]; 
			$body = $request_body["body"]; 
			$description = $request_body["description"]; 
			$article_id = $request_body["article_id"]; 
			$editor_id = SessionManager::get_session_user()->get_id(); 

			//2. Check if data is correct
			Article::check_data($editor_id, $aula_id, $title, $description, $body, $tags, $category, $article_id);

			//3. Save
			ArticleRepository::save($editor_id, $aula_id, $title, $body, $tags, $category, $article_id);

			//5. Return Ok
			return FormattedRequest::format(true);
		}

	}
