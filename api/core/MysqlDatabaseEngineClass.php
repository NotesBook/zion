<?php 
/**
 * NotesBook DatabaseEngine
 *
 * @author     Nombre <email@email.com>
 * @package    \api\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	class MysqlDatabaseEngine {

		public static $conn = null;

		public static function get_connection() {

			if (is_null(self::$conn))
				self::set_connection();

			return self::$conn;

		}

		private static function set_connection() {

			global $_NB_GLOBALS;

			if (is_null(self::$conn)) {

				$database_config = $_NB_GLOBALS["settings"]->database;
				self::$conn = new mysqli($database_config->server, $database_config->user, $database_config->pass, $database_config->scheme);

			}
		}

	}