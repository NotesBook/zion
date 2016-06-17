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

 			$title = mysql_real_escape_string($title);
 			$body = mysql_real_escape_string($body);
 			$tags = mysql_real_escape_string($tags);
 			$topic = mysql_real_escape_string($topic);
			
			if (!isset($article_id)) {

				//New Article
				return parent::insert("articles", 
					"author_id, classroom_id, title, body, topic, tags, create_date, modify_date",
					"$author_id, '$classroom_id', '$title', '$body', '$topic', '$tags', '$date', '$date'");

			} else {

				//Update Article
				parent::update("articles", 
					"modify_date = '$date', title = '$title', body = '$body', topic = '$topic', tags = '$tags'",
					"id = '".$article_id."'");

				return $article_id;

			}

		}	

		public static function get_by_id($id) {

			$database_result = parent::select("articles", array("*"), "id = $id");

			$array_obj_result = array();
			$article_tupla = $database_result->fetch_array();

			//likes and unlikes count
			$likes_count_result = parent::select("articles_likes", array("*"), "article_id = ".$article_tupla["id"]." AND `like` = 1");
			$unlikes_count_result = parent::select("articles_likes", array("*"), "article_id = ".$article_tupla["id"]." AND `like` = 0");

			$likes_count = $likes_count_result->num_rows;
			$unlikes_count = $unlikes_count_result->num_rows;

			//author_name
			$author = UserRepository::get_by_id($article_tupla["author_id"]);

			$article = new Article($article_tupla["author_id"], $article_tupla["classroom_id"], $article_tupla["title"], $article_tupla["body"], $article_tupla["tags"], $article_tupla["topic"], $article_tupla["id"], $article_tupla["create_date"], $article_tupla["modify_date"], $article_tupla["delete_date"], $likes_count, $unlikes_count, $author);

			return $article;	
		}

		/**
		 * return all dashboard user articles
		 */
		public static function get_all_by_classroom($classroom_id) {

			$database_articles_result = parent::select("articles", array("*"), "classroom_id = $classroom_id", "modify_date DESC");

			$array_obj_result = array();
			while($article_tupla = $database_articles_result->fetch_array()) {

				//likes and unlikes count
				$likes_count_result = parent::select("articles_likes", array("*"), "article_id = ".$article_tupla["id"]." AND `like` = 1");
				$unlikes_count_result = parent::select("articles_likes", array("*"), "article_id = ".$article_tupla["id"]." AND `like` = 0");

				$likes_count = $likes_count_result->num_rows;
				$unlikes_count = $unlikes_count_result->num_rows;

				//author_name
				$author = UserRepository::get_by_id($article_tupla["author_id"]);

				$array_obj_result[] = new Article($article_tupla["author_id"], $article_tupla["classroom_id"], $article_tupla["title"], $article_tupla["body"], $article_tupla["tags"], $article_tupla["topic"], $article_tupla["id"], $article_tupla["create_date"], $article_tupla["modify_date"], $article_tupla["delete_date"], $likes_count, $unlikes_count, $author);

			}

			return $array_obj_result;

		}

		/** Like article
		 *
		 */
		public static function like($user_id, $article_id) {

			//1. Check Article exits
			$article = self::get_by_id($article_id);
			//UserRepository::modify_karma(User::KARMA_LIKE_ARTICLE, $user_id);

 			$date = date('Y/m/d H:i:s');

 			//2. Check if like or unlike exists
 			$article_like_result = parent::select("articles_likes", array("*"), "article_id = $article_id AND user_id = $user_id");

 			if ($article_like_result->num_rows > 0) {

				parent::update("articles_likes", 
					"`like` = 1, date = '$date'",
					"article_id = $article_id AND user_id = $user_id");

 			} else {

				//2. Insert articles_likes
				parent::insert("articles_likes", "`like`, article_id, user_id, date", "1, $article_id, $user_id, '$date'");

 			}

		}

		/** unlike article
		 *
		 */
		public static function unlike($user_id, $article_id) {

			//1. Check Article exits
			$article = self::get_by_id($article_id);
			//UserRepository::modify_karma(User::KARMA_UNLIKE_ARTICLE, $user_id);

 			//2. Check if like or unlike exists
 			$article_like_result = parent::select("articles_likes", array("*"), "article_id = $article_id AND user_id = $user_id");

 			$date = date('Y/m/d H:i:s');

 			if ($article_like_result->num_rows > 0) {

				parent::update("articles_likes", 
					"`like` = 0, date = '$date'",
					"article_id = $article_id AND user_id = $user_id");

 			} else {

				//2. Insert articles_likes
				parent::insert("articles_likes", "`like`, article_id, user_id, date", "0, $article_id, $user_id, '$date'");
 				
 			}

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