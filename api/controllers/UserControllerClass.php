<?php
/**
 * NotesBook UserControllerClass
 *
 * @author     Nombre <email@email.com>
 * @package    \app\controllers
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class UserController extends BaseController {

		public function __construct() {

			$domain_name = str_replace("Controller", "", static::class);

			parent::__construct($domain_name);

		}

		/* Method POST
		 * Save new user data
		 */
		public function register() {
			//1. Get User's fields from $_POST
			$name = $_POST["name"]; 
			$surname = $_POST["surname"]; 
			$birthdate = $_POST["birthdate"];  
			$country = $_POST["country"]; 
			$region = $_POST["region"]; 
			$email = $_POST["email"]; 

			echo $name;

			//2. Check if data is correct
			//TODO: Check again if necessary

			//3. Save User
			$security_code = UserRepository::register($name, $surname, $birthdate, $country, $region, $email);

			echo $security_code;

			//4. Send Email


			//5. Return Ok
			return true;
		}


		/* Validations */

		/*  
		 * return FieldValidation
		 */
		public function check_name($name) {

			return User::check_name($name); 

		}

		/*  
		 * return FieldValidation
		 */
		public function check_surname($surname) {

			return User::check_surname($surname); 

		}

		/*  
		 * return FieldValidation
		 */
		public function check_country($country) {

			return User::check_country($country); 

		}

		/*  
		 * return FieldValidation
		 */
		public function check_region($region) {

			return User::check_region($region); 

		}

		/*  
		 * return FieldValidation
		 */
		public function check_email($email) {

			return User::check_email($email); 

		}

		/*  
		 * return FieldValidation
		 */
		public function check_birthdate($birthdate) {

			return User::check_birthdate($birthdate); 

		}

	}
