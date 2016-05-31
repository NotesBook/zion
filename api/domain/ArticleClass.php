<?php
/**
 * NotesBook Article
 *
 * @author     Nombre <email@email.com>
 * @package    \app\domain
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class Article extends BaseDomainClass implements JsonSerializable {

		private $editor_id;
		private $aula_id;
		private $title;
		private $description;
		private $category;
		private $tags;
		private $article_id;

		private $last_modified_date;
		private $creation_date;

		private $security_code;

		public function __construct($editor_id, $aula_id, $title, $description, $category, $tags, $article_id) { 

			//Fields
			$this->id = $article_id;
			$this->editor_id = intval($editor_id);
			$this->aula_id = intval($aula_id);
			$this->title = trim($title);
			$this->description = trim($description);
			$this->category = trim($category);
			$this->tags = trim($tags);

		}

		/** Sets */

	    /** Validations */
	    public static function check_data($editor_id, $aula_id, $title, $description, $category, $tags, $article_id) {

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