<?php
/**
 * NotesBook Http Engine Service
 *
 * @author     Nombre <email@email.com>
 * @package    \application\config
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 * 
 * Http Engine Service
 * ###############
 * Get Data from http request, or set http response
 * 
 * Content
 * #######
 * 
 * 
 * 
 * 
 * 
 */

/** Load Dependecies
*/

/** Class Definition
*/

class HttpEngineService {

	public static function get_array_from_json_body() {

		$request_body_json = file_get_contents('php://input');
		$request_body = json_decode( $request_body_json, TRUE );
		
		return $request_body;

	}

	public static function set_response_json_headers() {

		header('Content-Type: application/json');

	}
}
 ?>

