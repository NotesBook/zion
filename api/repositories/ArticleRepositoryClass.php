<?php 
/**
 * NotesBook Article Repository
 *
 * @author     Nombre <email@email.com>
 * @package    \application\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class ArticleRepository extends BaseRepository implements IBaseRepository {

		public static function save($author_id, $classroom_id, $title, $body, $tags, $topic, $article_id = null) {
 
 			$date = date('Y/m/d H:i:s');
			
			if (!isset($article_id)) {

				//New Article
				parent::insert("articles", 
					"author_id, classroom_id, title, body, topic, tags, create_date, modify_date",
					"$author_id, '$classroom_id', '$title', '$body', '$topic', '$tags', '$date', '$date'");

			} else {

				//Update Article
				parent::update("articles", 
					"modify_date = '$date', title = '$title', body = '$body', topic = '$topic', tags = '$tags'",
					"id = '".$article_id."'");

			}

		}	

		public static function get_by_id($id) {

			$database_result = parent::select("articles", array("author_id", "classroom_id", "title", "body", "topic", "tags", "create_date", "modify_date"),
			 						"id = $id");

			$array_obj_result = array();
			$user_tupla = $database_result->fetch_array();

			$user = new User($user_tupla["id"], $user_tupla["author_id"], $user_tupla["classroom_id"], $user_tupla["title"], $user_tupla["body"], $user_tupla["topic"], $user_tupla["tags"], $user_tupla["create_date"], $user_tupla["modify_date"]);

			return $user;	
		}

		/**
		 * return all dashboard user articles
		 */
		public static function get_all() {

			$database_result = parent::select("articles", array("*"));

			$array_obj_result = array();
			while($user_tupla = $database_result->fetch_array()) {

				$array_obj_result[] = new Article($user_tupla["author_id"], $user_tupla["classroom_id"], $user_tupla["title"], $user_tupla["body"], $user_tupla["tags"], $user_tupla["topic"], $user_tupla["article_id"], $user_tupla["create_date"], $user_tupla["modify_date"], $user_tupla["delete_date"]);

			}

			return $array_obj_result;

		}

	}