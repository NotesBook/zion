<?php 
/**
 * NotesBook Base Repository
 *
 * @author     Nombre <email@email.com>
 * @package    \application\core
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

	abstract class BaseRepository {

		protected static function select($table, $fields = array(), $where = "", $orderby = "") {

			$fields = empty($fields) ? "*" : implode(", ", $fields);
			$where = empty($where) ? "" : "WHERE $where";
			$orderby = empty($orderby) ? "" : "ORDER BY $orderby";

			//echo ("SELECT $fields FROM $table $where $orderby;");
			//exit();
			$result = MysqlDatabaseEngine::get_connection()->query("SELECT $fields FROM $table $where $orderby;");

			return $result;
		}

		protected static function insert($table, $fields, $values) {

			//echo "INSERT INTO $table($fields) VALUES($values)";
			//exit();

			$conn = MysqlDatabaseEngine::get_connection();
			$conn->query("INSERT INTO $table($fields) VALUES($values)");
			$insert_id = $conn->insert_id;


			if (!$conn->commit()) {
			    throw new Exception('Base Repository: Error Insert $table');
			    exit();
			}


			return $insert_id;

		}

		protected static function update($table, $updates, $where) {

			$conn = MysqlDatabaseEngine::get_connection();

			//print_r("UPDATE $table SET $updates WHERE $where");
			//exit();

			$conn->query("UPDATE $table SET $updates WHERE $where");
			if (!$conn->commit()) {
			    throw new Exception('Base Repository: Error Insert $table');
			    exit();
			}
		}

		protected static function delete($table, $where) {
			
			$conn = MysqlDatabaseEngine::get_connection();
			$conn->query("DELETE $table WHERE $where");
			if (!$conn->commit()) {
			    throw new Exception('Base Repository: Error Delete $table');
			    exit();
			}

		}


	}

?>