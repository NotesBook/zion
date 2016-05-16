<?php 
/**
 * NotesBook FormattedRequestClass
 *
 * @author     Nombre <email@email.com>
 * @package    \api\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 * 
 */

	class FormattedRequest {

		public $valid;
		public $msg;
		public $data;

		public function __construct($valid, $data = "", $msg = "" ) { 

			$this->valid = $valid;
			$this->msg = $msg;
			$this->data = $data;

		}

		public static function format($ok, $data = "", $msg = "") {

			$object = new FormattedRequest($ok, $data, $msg);
			return json_encode($object);

		}

	}

 ?>