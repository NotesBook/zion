<?php 
/**
 * NotesBook Base Controller
 *
 * @author     Nombre <email@email.com>
 * @package    \application\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class BaseController {

		private $domain_name;

		public function __construct($domain_name) {

			$this->domain_name = $domain_name;

		}

		protected function get_domain_name() {

			return $this->domain_name;

		}

		public function get_all() {

			$repository_name_class = $this->domain_name."Repository";

			echo json_encode($repository_name_class::get_all());

		}

	}



?>