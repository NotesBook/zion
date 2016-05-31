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
		private $surname;
		private $birthdate;
		private $country;
		private $region;
		private $email;

		private $entry_date;
		private $leaving_date;

		private $security_code;

		public function __construct($id, $name, $surname, $birthdate, $country, $region, $email) { 

			//Check if user is new
			if (is_null($id)) {

				//This code is used when validate user
				$this->security_code = md5(time());

			} else {

				$this->id = $id;

			}

			//Fields
			$this->name = trim($name);
			$this->surname = trim($surname);
			$this->birthdate = intval($birthdate);
			$this->country = trim($country);
			$this->region = trim($region);
			$this->email = trim($email);

		}

		/** Sets */
		public function set_name($name) {

			$this->name = $name;

		}

		/** Gets */
		public function get_name() {

			return $this->name;

		}

	    /** Validations */
	    public static function check_data($name, $category, $subcategory, $description) {

	    	//1. Read Json File
			$json_array = self::get_validationJson();
			$json_categories = self::get_categoriesJson();

	    	//2. Check data
			$check_name = preg_match($json_array["name"], $name);
			$check_category = self::check_category($json_categories, $category);
			$check_subcategory = self::check_subcategory($json_categories, $subcategory);
			$check_description = preg_match($json_array["description"], $description);

			//3. Parsing error menssages
			$msg = "";
			if (!$check_name)
				$msg .= ", El nombre está mal, muy mal";
			if (!$check_category)
				$msg .= ", La categoría está mal, muy mal";
			if (!$check_subcategory)
				$msg .= ", La subcategoría de nacimiento está mal, muy mal";
			if (!$check_description)
				$msg .= ", La descripción está mal, muy mal";

	    	//4. Check if any error exists.
	    	//throw custom exception if error
	    	if ($msg) { 
			    throw new Exception("Aula Data Error: $msg");
	    	}

	    	return true;
	    }

	    public static function check_category($json_categories, $category) {

	    	foreach ($json_categories["categories"] as $key => $value) {
	    		
	    		if($value["name"] == $category) {

	    			return true;

	    		}  
	    	} return false;
	    	
	    }

	    public static function check_subcategory($json_categories, $subcategory) {

	    	foreach ($json_categories["subcategories"] as $key => $value) {
	    		
	    		if($value["name"] == $subcategory) {

	    			return true;

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
	            'surname' =>  $this->surname,
	            'birthdate' => $this->birthdate,
	            'country' => $this->country,
	            'region' => $this->region,
	            'email' => $this->email
	        ];
	    }

	}


?>