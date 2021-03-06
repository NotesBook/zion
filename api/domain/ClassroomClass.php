<?php
/**
 * NotesBook Classroom
 *
 * @author     Nombre <email@email.com>
 * @package    \app\domain
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class Classroom extends BaseDomainClass implements JsonSerializable {

		private $name;
		private $category;
		private $subcategory;
		private $description;
		private $image_path;

		private $entry_date;
		private $leaving_date;

		private $invitation_code;

		public function __construct($id, $name, $category, $subcategory, $description, $image_path, $invitation_code, $entry_date = null, $leaving_date = null) { 

			$this->id = $id;

			//Fields
			$this->name = trim($name);
			$this->category = trim($category);
			$this->subcategory = trim($subcategory);
			$this->description = trim($description);
			$this->image_path = trim($image_path);
			$this->invitation_code = trim($invitation_code);

			$this->entry_date = trim($entry_date);
			$this->leaving_date = trim($leaving_date);

		}

		/** Sets */
		public function set_name($name) {

			$this->name = $name;

		}

		/** Gets */
		public function get_name() {

			return $this->name;

		}

		public function get_invitation_code() {

			return $this->invitation_code;

		}

	    /** Validations */
	    public static function check_data($name, $category, $subcategory, $description) {

	    	//1. Read Json File
			$json_array = self::get_validationJson();
			$json_categories = self::get_categoriesJson();

	    	//2. Check data
			$check_name = preg_match($json_array["name"], $name);
			$check_category_subcategory = self::check_category_subcategory($json_categories, $category, $subcategory);
			$check_description = preg_match($json_array["description"], $description);

			//3. Parsing error menssages
			$msg = "";
			if (!$check_name)
				$msg .= ", El nombre está mal, muy mal";
			if (!$check_category_subcategory)
				$msg .= ", La categoría o subcategoría está mal, muy mal";
			if (!$check_description)
				$msg .= ", La descripción está mal, muy mal";

	    	//4. Check if any error exists.
	    	//throw custom exception if error
	    	if ($msg) { 
			    throw new Exception("Aula Data Error: $msg");
	    	}

	    	return true;
	    }

	    public static function check_category_subcategory($json_categories, $category, $subcategory) {

	    	foreach ($json_categories as $keyC => $json_category) {

	    		if ($json_category["category"] == $category) {

	    			foreach ($json_category["subcategories"] as $keyS => $json_subcategory) {
	    				
	    				if ($json_subcategory["name"] == $subcategory)
	    					return true;

	    			}

	    		}  
	    	} return false;
	    	
	    }

	    public static function get_validationJson() {

			$json_content_txt = file_get_contents("config/validations.json");
			return json_decode($json_content_txt, TRUE);

	    }

	    public static function get_categoriesJson() {

			$json_content_txt = file_get_contents("config/categories.json");
			return json_decode($json_content_txt, TRUE);

	    }

		/** JSON Serializer 
		 */

	    public function jsonSerialize() {
	        return [
	            'id' => $this->id,
	            'name' => $this->name,
	            'category' =>  $this->category,
	            'subcategory' => $this->subcategory,
	            'description' => $this->description,
	            'image_path' => $this->image_path,
	            'invitation_code' => $this->invitation_code
	        ];
	    }

	}


?>