<?php 
/**
 * NotesBook Bootstrap File
 *
 * @author     Nombre <email@email.com>
 * @package    \application\config
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	/** Global Vars */
	$_NB_GLOBALS = array();
	$_NB_GLOBALS["base_path"] = "C:\\xampp\\htdocs\\www\\gimp_workspace\\zion\\";
	$_NB_GLOBALS["api_path"] = $_NB_GLOBALS["base_path"]."api\\";
	$_NB_GLOBALS["settings"] = array();

	/** Load Settings from webconfig.xml file */
	function nb_loadSettings() {
		global $_NB_GLOBALS;

		$aux_xml = file_get_contents($_NB_GLOBALS["api_path"]."webconfig.xml");
		$_NB_GLOBALS["settings"] = simplexml_load_string($aux_xml);
	}

	nb_loadSettings();

	/** Load Dependecies */
	/** Services */
	include("core/services/RoutingEngineServiceClass.php");

	/** Application */
	include("core/ApplicationEngineClass.php");
	include("core/MysqlDatabaseEngineClass.php");
	include('core/BaseControllerClass.php');
	include('core/BaseDomainClass.php');
	include('core/BaseRepositoryClass.php');
	include('core/IBaseRepositoryClass.php');

	/** Controllers */	
	include('controllers/UserControllerClass.php');

	/** Domain */
	include('domain/UserClass.php');
	
	/** Repositories */	
	include('repositories/UserRepositoryClass.php');

	/** migrations - comment to avoid executing file */
	//include('database/execute_migrations.php');

	/** Init Application
	 *
	 * Execute the Specifics Action and Controller 
	*/
	ApplicationEngine::start();
	
 ?>

