<?php 
/**
 * NotesBook start_application
 *
 * @author     Nombre <email@email.com>
 * @package    \api\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class ApplicationEngine {

		public static function start() {
			try {

				/** Routing - Load Controller and execute Action with the parameters from URI */
				RoutingEngineService::init();

				/** Create Controller */
				$controller_name = RoutingEngineService::get_controller_name();
				$controller_obj = new $controller_name;

				/** Set action */
				$action_name = empty(RoutingEngineService::get_action_name()) 
								? "get_all" //Default when empty action
								: RoutingEngineService::get_action_name();

				/** Execute action */
				header('Content-Type: application/json');
				$response = $controller_obj->$action_name();

			} catch (Exception $err) {

				print_r("APPLICATION ERROR: ".$err->getMessage());
				
				throw $err;

			}
		}
	}

?>