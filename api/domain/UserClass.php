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
		public function check_name($name) {

			$start_with_letter = preg_match('/^[a-zA-Z]{1}/', $this->name);
			$length_greatter_than_4 = strlen($this->name) > 4;

			$name_is_valid = $start_with_letter 
				&& $length_greatter_than_4;

			return new FieldValidation("name", $name_is_valid, !$name_is_valid ? "El nombre está mal, muy mal" : null);

		}

		public function check_surname($surname) {

			$surname_is_valid = true;

			return new FieldValidation("surname", $surname_is_valid, !$surname_is_valid ? "El apellido está mal, muy mal" : null);

		}

		public function check_country($country) {

			$country_is_valid = true;

			return new FieldValidation("country", $country_is_valid, !$country_is_valid ? "El país está mal, muy mal" : null);

		}

		public function check_region($region) {

			$region_is_valid = true;

			return new FieldValidation("country", $region_is_valid, !$region_is_valid ? "La provincia está mal, muy mal" : null);

		}

		public function check_email($email) {

			$email_is_valid = true;

			return new FieldValidation("email", $email_is_valid, !$email_is_valid ? "El email está mal, muy mal" : null);

		}

		public function check_birthdate($birthdate) {

			$birthdate_is_valid = true;

			return new FieldValidation("birthdate", $birthdate_is_valid, !$birthdate_is_valid ? "La fecha de nacimimento está mal, muy mal" : null);

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