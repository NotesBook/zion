<?php 
/**
 * NotesBook Base Repository
 *
 * @author     Nombre <email@email.com>
 * @package    \application\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	abstract class BaseRepository {

		static protected $domain_name;
		static protected $instance;
		static protected $database_conn;

		protected static function select($table, $campos = array(), $where = "", $join = "") {

			$fields = empty($fields) ? "*" : implode(", ", $fields);
			$where = empty($where) ? "" : "WHERE $where";
			$join = empty($join) ? "" : "LEFT JOIN $join";

			return MysqlDatabaseEngine::get_connection()->query("SELECT $fields FROM $table $where;");

		}


	}

?>