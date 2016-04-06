<?php
/**
 * NotesBook Bootstrap File
 *
 * @author     Nombre <email@email.com>
 * @package    \application\config
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */


	/** dependencies */
	include('config/global.php');
	include('routes/default.php');


	/** migrations - Uncomment to execute file */
	/** include('database/')


	/** route - Load Controller and execute Action from URI */
	/*
	 * Set up apache mod_rewrite in /api/init.php
	*/
	function getCurrentUri()
	{
		$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
		/* echo "$uri <br><br>"; */
		if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
		$uri = '/' . trim($uri, '/');
		return $uri;
	}
 
	$base_url = getCurrentUri();
	echo $base_url."<br>";
	$routes_aux = array();
	$routes_aux = explode('/', $base_url);
	$routes = array();
	$route_names = array("controller", "action", "param1", "param2", "param3");
	$route_aux_count = 0;
	foreach($routes_aux as $route)
	{
		if(trim($route)) {
			$routes[$route_names[$route_aux_count]] = $route;
			$route_aux_count++;
		}
	}

	echo "--------------------------- array route: ---------------------------<br>";
	print_r($routes);
	echo "<br>--------------------------- array route --------------------------- <br>";
 ?>

