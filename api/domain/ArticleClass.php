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
		private $aula_id;
		private $title;
		private $description;
		private $category;
		private $tags;
		private $article_id;

		private $last_modified_date;
		private $creation_date;
		private $delete_date;

		public function __construct($author_id, $classroom_id, $title, $body, $tags, $topic, $article_id, $last_modified_date = null, $creation_date = null, $delete_date = null) { 

			//Fields
			$this->id = $article_id;
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

	    	//TODO:

	    	return true;
	    }

	    public static function check_category($json_categories, $category) {

	    	//TODO:
	    	
	    }

	    public static function get_validationJson() {

	    	//TODO:

	    }

	    public static function get_categoriesJson() {

	    	//TODO:

	    }

		/** JSON Serializer 
		 */

	    public function jsonSerialize() {
	        return [
	            'id' => $this->id,
	            'name' => $this->name,
	            'surname' =>  $this->surname,
	            'birthdate' => $this->birthdate,
	            'country' => $this->country,
	            'region' => $this->region,
	            'email' => $this->email
	        ];
	    }

	}


?>