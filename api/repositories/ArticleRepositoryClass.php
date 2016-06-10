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

			$database_result = parent::select("articles", array("*"),
			 						"id = $id");

			$array_obj_result = array();
			$article_tupla = $database_result->fetch_array();

			$article = new Article($article_tupla["author_id"], $article_tupla["classroom_id"], $article_tupla["title"], $article_tupla["body"], $article_tupla["tags"], $article_tupla["topic"], $article_tupla["id"], $article_tupla["create_date"], $article_tupla["modify_date"], $article_tupla["delete_date"]);

			return $article;	
		}

		/**
		 * return all dashboard user articles
		 */
		public static function get_all_by_classroom($classroom_id) {

			$database_articles_result = parent::select("articles", array("*"), "classroom_id = $classroom_id", "modify_date DESC");

			$array_obj_result = array();
			while($article_tupla = $database_articles_result->fetch_array()) {

				$array_obj_result[] = new Article($article_tupla["author_id"], $article_tupla["classroom_id"], $article_tupla["title"], $article_tupla["body"], $article_tupla["tags"], $article_tupla["topic"], $article_tupla["id"], $article_tupla["create_date"], $article_tupla["modify_date"], $article_tupla["delete_date"]);

			}

			return $array_obj_result;

		}

		/** Like article
		 *
		 */
		public static function like($user_id, $article_id) {

			//1. Get Article
			$article = self::get_by_id($article_id);
			UserRepository::modify_karma(1, $user_id);

 			$date = date('Y/m/d H:i:s');

			//2. Insert articles_likes
			parent::insert("articles_likes", "article_id, user_id, date", "$article_id, $user_id, '$date'");

		}

		/** Get Likes Counter of Article
		 *
		 */
		public static function likes_count($article_id) {

			//1. Get Article to check if exists
			$article = self::get_by_id($article_id);

 			$date = date('Y/m/d H:i:s');

			//2. Get count
			$database_article_likes_result = parent::select("articles_likes", array("COUNT(*) likes_count"), "article_id = $article_id");

			$array_obj_result = array();
			$article_tupla = $database_article_likes_result->fetch_array();

			return $article_tupla["likes_count"];

		}

	}