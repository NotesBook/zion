<?php
/**
 * NotesBook UserClass
 *
 * @author     Nombre <email@email.com>
 * @package    \app\domain
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class User extends BaseDomainClass implements JsonSerializable {

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
	    public static function check_data($name, $surname, $birthdate, $country, $region, $email) {

	    	//1. Read Json File
			$json_array = self::get_validationJson();

	    	//2. Check data
			$check_name = preg_match($json_array["name"], $name);
			$check_surname = preg_match($json_array["name"], $surname);
			$check_birthdate = preg_match($json_array["date"], $birthdate);
			$check_country = preg_match($json_array["name"], $country);
			$check_region = preg_match($json_array["name"], $region);
			$check_email = preg_match($json_array["mail"], $email);

			//3. Parsing error menssages
			$msg = "";
			if (!$check_name)
				$msg .= ", El nombre está mal, muy mal";
			if (!$check_surname)
				$msg .= ", El apellido está mal, muy mal";
			if (!$check_birthdate)
				$msg .= ", La fecha de nacimiento está mal, muy mal";
			if (!$check_country)
				$msg .= ", El país está mal, muy mal";
			if (!$check_region)
				$msg .= ", La región está mal, muy mal";
			if (!$check_email)
				$msg .= ", El email está mal, muy mal";

	    	//4. Check if any error exists.
	    	//throw custom exception if error
	    	if ($msg) { 
			    throw new Exception("User Data Error: $msg");
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