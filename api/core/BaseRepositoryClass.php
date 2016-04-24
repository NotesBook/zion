<?php 
/**
 * NotesBook Base Repository
 *
 * @author     Nombre <email@email.com>
 * @package    \application\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	abstract class BaseRepository {

		protected static function select($table, $fields = array(), $where = "", $join = "") {

			global $_NB_GLOBALS; 

			$fields = empty($fields) ? "*" : implode(", ", $fields);
			$where = empty($where) ? "" : "WHERE $where";
			$join = empty($join) ? "" : "LEFT JOIN $join";

			//print_r("SELECT $fields FROM $table $where;");
			$result = MysqlDatabaseEngine::get_connection()->query("SELECT $fields FROM $table $where;");

			return $result;
		}

		protected static function insert($table, $fields, $values) {

			//echo "INSERT INTO $table($fields) VALUES($values)";
			$conn = MysqlDatabaseEngine::get_connection();
			$conn->query("INSERT INTO $table($fields) VALUES($values)");
			if (!$conn->commit()) {
			    throw new Exception('Base Repository: Error Insert $table');
			    exit();
			}
		}


	}

?>