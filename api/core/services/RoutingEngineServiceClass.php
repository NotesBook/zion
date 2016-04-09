<?php
/**
 * NotesBook Bootstrap File
 *
 * @author     Nombre <email@email.com>
 * @package    \application\config
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 * 
 * Routing Service
 * ###############
 * 
 * Content
 * #######
 * RoutingService Class - 
 * 
 * 
 * 
 * 
 * Set up apache mod_rewrite in /.htaccess
 * 
 */

/** Load Dependecies
*/

/** Class Definition
*/

class RoutingEngineService {

	private static $controller_name;
	private static $action_name = "";
	private static $params = array();

	public static function init() {

		self::setParams();

		self::set_controller_name();
		self::set_action_name();
	}
	
	private static function setParams() {

		$base_url = self::getCurrentUri();

		//echo $base_url."<br>"; //TODO: Log

		$param_aux = array();

		$param_aux = explode('/', $base_url);

		$param_aux_count = 0;

		foreach($param_aux as $param)
		{
			if(trim($param)) {
				self::$params[$param_aux_count] = $param;
				$param_aux_count++;
			}
		}
	}

	private static function getCurrentUri()	{
		/**
		 * INFO ABOUT $_SERVER['SCRIPT_NAME']
		 * http://stackoverflow.com/questions/279966/php-self-vs-path-info-vs-script-name-vs-request-uri
		 */
		$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';

		$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));

		if (strstr($uri, '?')) 
			$uri = substr($uri, 0, strpos($uri, '?'));

		$uri = '/' . trim($uri, '/');

		return $uri;
	}

	public static function get_params() {

		return self::$params;

	}

	private static function set_controller_name() {

		self::$controller_name = ucfirst(array_shift(self::$params))."Controller";

	}

	private static function set_action_name() {

		if(!empty(self::$params))
			self::$action_name = array_shift(self::$params);

	}

	public static function get_controller_name() {

		return self::$controller_name;

	}

	public static function get_action_name() {

		return self::$action_name;

	}
}
 ?>

