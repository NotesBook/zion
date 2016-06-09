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

		private $last_modified_date;
		private $creation_date;
		private $delete_date;

		public function __construct($author_id, $classroom_id, $title, $body, $tags, $topic, $article_id, $last_modified_date = null, $creation_date = null, $delete_date = null) { 

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

		}

		/** Sets */

	    /** Validations */
	    public static function check_data($author_id, $classroom_id, $title, $body, $tags, $topic) {

	    	//1. Read Json File
			$json_array = self::get_validationJson();

	    	//2. Check data
	    	$check_author_id = isset($author_id);
			$check_title = preg_match($json_array["article_title"], trim($title));
			$check_topic = preg_match($json_array["article_title"], trim($topic));
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

		/** JSON Serializer 
		 */

	    public function jsonSerialize() {
	        return [
	            'id' => $this->id,
	            'author_id' => $this->author_id,
	            'classroom_id' => $this->classroom_id,
	            'title' => $this->title,
	            'topic' => $this->topic,
	            'tags' => $this->tags,
	            'last_modified_date' => $this->last_modified_date,
	            'creation_date' => $this->creation_date,
	            'delete_date' => $this->delete_date
	        ];
	    }

	}


?>