<?php
/**
 * NotesBook Article
 *
 * @author     Nombre <email@email.com>
 * @package    \app\domain
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class Article extends BaseDomainClass implements JsonSerializable {

		private $author_id;
		private $classroom_id;
		private $title;
		private $topic;
		private $tags;
		private $body;
		private $last_modified_date;
		private $creation_date;
		private $delete_date;

		//Non database likes
		private $likes_count = 0;
		private $unlikes_count = 0;
		private $author_name;

		public function __construct($author_id, $classroom_id, $title, $body, $tags, $topic, $article_id, $last_modified_date, $creation_date, $delete_date, $likes_count = 0, $unlikes_count = 0, $author = null) { 

			//Fields
			$this->id = isset($article_id) ? intval($article_id) : null;
			$this->author_id = intval($author_id);
			$this->classroom_id = intval($classroom_id);
			$this->title = trim($title);
			$this->body = trim($body);
			$this->topic = trim($topic);
			$this->tags = trim($tags);
			$this->last_modified_date = $last_modified_date;
			$this->creation_date = $creation_date;
			$this->delete_date = $delete_date;

			//Non Database
			$this->likes_count = $likes_count;
			$this->unlikes_count = $unlikes_count;
			$this->author = $author;

		}

		/** Gets */
		function get_last_modified_date() {

			return $this->last_modified_date;

		}

	    /** Validations */
	    public static function check_data($author_id, $classroom_id, $title, $body, $tags, $topic) {

	    	//1. Read Json File
			$json_array = self::get_validationJson();

	    	//2. Check data
	    	$check_author_id = isset($author_id);
			$check_title = preg_match($json_array["article_title"], trim($title));
			$check_topic = preg_match($json_array["article_tags"], trim($topic));
			$check_body = preg_match($json_array["article_body"], trim($body));
			$check_tags = preg_match($json_array["article_tags"], $tags);

			//3. Parsing error menssages
			$msg = "";
			if (!$check_author_id)
				$msg .= ", El artículo no tiene autor";
			if (!$check_title)
				$msg .= ", El artículo no tiene título";
			if (!$check_topic)
				$msg .= ", El artículo no tiene topic";
			if (!$check_body)
				$msg .= ", El artículo no tiene body";
			if (!$check_tags)
				$msg .= ", Las tags están muy mal";

	    	//4. Check if any error exists.
	    	//throw custom exception if error
	    	if ($msg) { 
			    throw new Exception("Article Data Error: $msg");
	    	}

	    	return true;
	    }

	    public static function get_validationJson() {

			$json_content_txt = file_get_contents("config/validations.json");
			return json_decode($json_content_txt, TRUE);

	    }


		/** JSON Serializer 
		 */

	    public function jsonSerialize() {
	        return [
	            'id' => $this->id,
	            'author_id' => $this->author_id,
	            'classroom_id' => $this->classroom_id,
	            'title' => $this->title,
	            'topic' => $this->topic,
	            'body' => $this->body,
	            'tags' => $this->tags,
	            'last_modified_date' => $this->last_modified_date,
	            'creation_date' => $this->creation_date,
	            'delete_date' => $this->delete_date,
	            'likes_count' => $this->likes_count,
	            'unlikes_count' => $this->unlikes_count,
	            'author_name' => isset($this->author) ? $this->author->get_complete_name() : "",
	            'author_id' => isset($this->author) ? $this->author->get_id() : 0
	        ];
	    }

	}


?>