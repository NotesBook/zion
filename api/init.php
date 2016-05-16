<?php 
/**
 * NotesBook Bootstrap File
 *
 * @author     Nombre <email@email.com&lt;<br/>
 * @package    \application\config
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	/** Global Vars */
	$_NB_GLOBALS = array();
	$_NB_GLOBALS["settings"] = array();

	/** Load Settings from webconfig.xml file */
	function nb_loadSettings() {
		global $_NB_GLOBALS;

		$file_path = "./webconfig.xml";
		if(!file_exists($file_path)) {

			echo "El fichero de configuración debe ser un XML bien formado<br/>Path: base/api/webconfig.xml. Ejemplo Básico:<br/>";
			echo "&lt;?xml version=\"1.0\" encoding=\"iso-8859-1\" standalone=\"yes\"?&gt;<br/> 
					&lt;webconfig&gt;<br/>

						&lt;baseurl&gt;&lt;/baseurl&gt;<br/>

						&lt;database&gt;<br/>
							&lt;server&gt;&lt;/server&gt;<br/>
							&lt;user&gt;&lt;/user&gt;<br/>
							&lt;pass&gt;&lt;/pass&gt;<br/>
							&lt;schema&gt;&lt;/schema&gt;<br/>
						&lt;/database&gt;<br/>

						&lt;email&gt;<br/>
							&lt;user&gt;&lt;/user&gt;<br/>
							&lt;pass&gt;&lt;/pass&gt;<br/>
						&lt;/email&gt;<br/>

					&lt;/webconfig&gt;<br/>";
			throw new Exception("No Existe fichero de configuración del api");

		}

		$aux_xml = file_get_contents($file_path);
		$_NB_GLOBALS["settings"] = simplexml_load_string($aux_xml);
	}

	nb_loadSettings();

	/** Load Dependecies */
	/** Services */
	include("core/services/HttpEngineServiceClass.php");
	include("core/services/MailEngineServiceClass.php");
	include("core/services/RoutingEngineServiceClass.php");

	/** Application */
	include("core/ApplicationEngineClass.php");
	include("core/MysqlDatabaseEngineClass.php");
	include('core/BaseControllerClass.php');
	include('core/BaseDomainClass.php');
	include('core/BaseRepositoryClass.php');
	include('core/IBaseRepositoryClass.php');

	include('core/RequestErrorClass.php');

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

