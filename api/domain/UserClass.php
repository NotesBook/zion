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
		private $karma;

		private $entry_date;
		private $leaving_date;

		private $security_code;

		//Karma Values
		const KARMA_CREATE_ARTICLE = 1;
		const KARMA_POSITIVE_VOTE = 1;
		const KARMA_NEGATIVE_VOTE = -1;

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
			$this->birthdate = $birthdate;
			$this->country = trim($country);
			$this->region = trim($region);
			$this->email = trim($email);

		}

		/** Sets */
		public function set_name($name) {

			$this->name = $name;

		}

		public function set_email($email) {

			$this->email = $email;

		}

		/** Gets */
		public function get_id() {

			return $this->id;

		}

		public function get_name() {

			return $this->name;

		}

		public function get_email() {

			return $this->email;

		}

	    /** Validations */
	    public static function check_data($name, $surname, $birthdate, $country, $region, $email) {

	    	//1. Read Json File
			$json_array = self::get_validationJson();
			$json_countries = self::get_countriesJson();

	    	//2. Check data
			$check_name = preg_match($json_array["name"], $name);
			$check_surname = preg_match($json_array["surname"], $surname);
			$check_birthdate = preg_match($json_array["birthdate"], $birthdate);
			$check_country = self::check_country($json_countries,$country);
			$check_region = preg_match($json_array["region"], $region);
			$check_email_exist = userRepository::check_email_exists($email);
			$check_email = preg_match($json_array["email"], $email);

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
				$msg .= ", <".$check_email.">,El email está mal, muy mal";
			if (!$check_email_exist)
				$msg .= ", Email ya registrado en la BBDD";

	    	//4. Check if any error exists.
	    	//throw custom exception if error
	    	if ($msg) { 
			    throw new Exception("User Data Error: $msg");
	    	}

	    	return true;
	    }

	    public static function check_country($json_countries,$country) {

	    	foreach ($json_countries as $key => $value) {
	    		
	    		if($value == $country) {

	    			return true;

	    		}  
	    	} return false;
	    	
	    }

	    public static function get_validationJson() {

			$json_content_txt = file_get_contents("config/validations.json");
			return json_decode($json_content_txt, TRUE);

	    }

	    public static function get_countriesJson() {

			$json_content_txt = file_get_contents("config/countries.json");
			return json_decode($json_content_txt, TRUE);

	    }

		/** JSON Serializer 
		 */

	    public function jsonSerialize() {
	        return [
	            'id' => $this->id,
	            'name' => $this->name,
	            'surname' =>  $this->surname,
	            'birthdate' => date('Y/m/d', strtotime($this->birthdate)),
	            'country' => $this->country,
	            'region' => $this->region,
	            'email' => $this->email,	            
	            'karma' => $this->karma
	        ];
	    }

	}


?>