<?php 
/**
 * NotesBook Article Repository
 *
 * @author     Nombre <email@email.com>
 * @package    \application\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class ArticleRepository extends BaseRepository implements IBaseRepository {

		public static function save($editor_id, $aula_id, $title, $description, $body, $tags, $category, $article_id) {

			parent::insert("article", 
				"editor_id, aula_id, title, tags, category, article_id",
				"editor_id, '$aula_id', '$title', '$description', '$body', '$tags', '$category', '$article_id'");

		}	

		public static function get_by_id($id) {

			//TODO:

		}

		/**
		 * return all dashboard user articles
		 */
		public static function get_all() {

			$database_result = parent::select("articles", array("*"));

			$array_obj_result = array();
			while($user_tupla = $database_result->fetch_array()) {

				$array_obj_result[] = new Article($user_tupla["editor_id"], $user_tupla["aula_id"], $user_tupla["title"], $user_tupla["category"], $user_tupla["tags"], $user_tupla["article_id"]);

			}

			return $array_obj_result;

		}

	}