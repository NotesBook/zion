<?php 
/**
 * NotesBook FieldValidationClass
 *
 * @author     Nombre <email@email.com>
 * @package    \api\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class FieldValidation {

		public $field;
		public $valid;
		public $msg;

		public function __construct($field, $valid, $msg = "") { 

			$this->field = $field;
			$this->valid = $valid;
			$this->msg = $msg;

		}

	}

 ?>