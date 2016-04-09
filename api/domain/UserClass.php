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
		/* private $surname;
		private $age;
		private $location;
		private $mail; */

		public function __construct($id, $name) { //, $surname, $age, $location, $mail) {

			$this->id = $id;
			$this->name = $name;

		}

		/** Sets */
		public function set_name($name) {

			$this->name = $name;

		}

		/** Gets */
		public function get_name() {

			return $this->name;

		}


		/** Auxiliar Functions */
	    public function jsonSerialize() {

	        return get_object_vars($this);

	    }
	}


?>