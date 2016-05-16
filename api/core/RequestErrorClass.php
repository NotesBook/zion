<?php 
/**
 * NotesBook FieldValidationClass
 *
 * @author     Nombre <email@email.com>
 * @package    \api\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class RequestError {

		public $valid;
		public $identifiers;
		public $msg;

		public function __construct($valid, $msg, $identifiers = "") { 

			$this->valid = $valid;
			$this->msg = $msg;
			$this->identifiers = $identifiers;

		}

	}

 ?>