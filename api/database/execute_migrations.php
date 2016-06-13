<?php
/**
 * NotesBook Database Migrations File
 *
 * @author     Nombre <email@email.com>
 * @package    \application\database
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

$database_config = $_NB_GLOBALS["settings"]->database;

//1. Connectamos con el servidor. Las variables de configuración están en el fichero /config.php
MysqlDatabaseEngine::get_connection();

/* set autocommit to off */
MysqlDatabaseEngine::get_connection()->autocommit(FALSE);

if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

/* 
 * 	Migración 0, 
 *	1. Creación de la bbbd, y la tabla de versiones
 *  2. Comprueba la última versión
 */
//1. Después de conectarnos, comprobamos si existe la bbdd
$sql_creacion_bbdd = "CREATE DATABASE IF NOT EXISTS ".$_NB_GLOBALS["settings"]->database->schema;
//print $sql_creacion_bbdd."<br>";
MysqlDatabaseEngine::get_connection()->query($sql_creacion_bbdd);

//2. Seleccionamos la BBDD
MysqlDatabaseEngine::get_connection()->select_db($database_config->schema);

//3. Comprobamos si existe la tabla de versiones y la creamos
$sql_create_table_versions_if_not_exists = 
	"CREATE TABLE IF NOT EXISTS versions (
        version_number INT NOT NULL,
        PRIMARY KEY(version_number),
        date    date NOT NULL,
        description VARCHAR(500) NOT NULL
    )";
//print $sql_create_table_versions_if_not_exists."<br>";
MysqlDatabaseEngine::get_connection()->query($sql_create_table_versions_if_not_exists);

//4. Comprobamos que la versión 0 (la inicial), no esté ya
$sql_check_actual_version = "SELECT MAX(version_number) version_actual FROM versions";
//print $sql_check_actual_version."<br>";
$result_check_actual_version = MysqlDatabaseEngine::get_connection()->query($sql_check_actual_version);
$row_check_actual_version = $result_check_actual_version->fetch_array();

$version_actual = 0;

if(is_null($row_check_actual_version["version_actual"])) { //Si no existe ningún registro, insertamos la versión 0
	$sql_update_versions_0 = "INSERT INTO versions(version_number, date, description) VALUES(0, NOW(), 'versión incial de la bbdd')";
	//print $sql_update_versions_0."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_update_versions_0);
} else {
	$version_actual = $row_check_actual_version["version_actual"];
}

//5. Hacemos el commit, porque lo tenemos desactivado
if (!MysqlDatabaseEngine::get_connection()->commit()) {
    print("Transaction commit failed\n");
    exit();
}

/* 
 * 	Migración 1, 
 *	1. Añade tabla usuarios
 *	2. Inserta usuarios base y de prueba
 */


//1. Comprobamos si existe la tabla de versiones y la creamos, sólo si nuestra versión actual es la anterior a esta Migración (la versión 0)
if($version_actual == "0") {
	$sql_create_table_users_if_not_exists = 
		"CREATE TABLE IF NOT EXISTS users (
	        id 				INT NOT NULL AUTO_INCREMENT,
	        				PRIMARY KEY(id),
	        name 			VARCHAR(50) NOT NULL,
	        surname 		VARCHAR(100),
	        birthdate 		DATETIME DEFAULT NULL,
	        country 		VARCHAR(50),
	        region      	VARCHAR(50),
	        email 			VARCHAR(150) NOT NULL,	        
	        entry_date 		DATETIME DEFAULT NULL,
	        leaving_date 	DATETIME DEFAULT NULL,
	        password      	VARCHAR(50),
	        security_code	VARCHAR(50),
	        session_code	VARCHAR(50),        
	        last_session_date	DATETIME DEFAULT NULL
	    )";
	//print $sql_create_table_users_if_not_exists."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_create_table_users_if_not_exists);

	//3. Actualizamos la versión de la bbdd
	$sql_update_versions_1 = "INSERT INTO versions(version_number, date, description) VALUES(1, '2016/04/09', 'Creación de tabla usuarios, inserción de datos de prueba')";
	//print $sql_update_versions_0."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_update_versions_1);

	if (!MysqlDatabaseEngine::get_connection()->commit()) {
	    print("Transaction 1 commit failed\n");
	    exit();
	} else {
		$version_actual = 1;
	}
}

//1. Comprobamos si existe la tabla de versiones y la creamos, sólo si nuestra versión actual es la anterior a esta Migración (la versión 0)
if ($version_actual == "1") {
	$sql_create_table_classrooms_if_not_exists = 
		"CREATE TABLE IF NOT EXISTS classrooms (
	        id 				INT NOT NULL AUTO_INCREMENT,
	        				PRIMARY KEY(id),
	        name 			VARCHAR(50) NOT NULL,
	        category 		VARCHAR(100),
	        subcategory		VARCHAR(100),
	        description		VARCHAR(1000),
	        image_path		VARCHAR(50),        
	        entry_date 		DATETIME DEFAULT NULL,
	        leaving_date 	DATETIME DEFAULT NULL,
	        invitation_code	VARCHAR(50)
	    )";
	//print $sql_create_table_user_if_not_exists."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_create_table_classrooms_if_not_exists);

	//3. Actualizamos la versión de la bbdd
	$sql_update_versions_2 = "INSERT INTO versions(version_number, date, description) VALUES(2, '2016/05/26', 'Creación de tabla de aulas')";
	//print $sql_update_versions_0."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_update_versions_2);

	//4. Hacemos el commit, porque lo tenemos desactivado
	if (!MysqlDatabaseEngine::get_connection()->commit()) {
	    print("Transaction 2 commit failed\n");
	    exit();
	} else {
		$version_actual = 2;
	}
}

if ($version_actual == "2") {
	$sql_create_table_articles_if_not_exists = 
		"CREATE TABLE IF NOT EXISTS articles (
	        id 				INT NOT NULL AUTO_INCREMENT,
	        				PRIMARY KEY(id),
	        author_id 		INT NOT NULL,
	        classroom_id 	INT,
	        title 			VARCHAR(100),
	        topic 			VARCHAR(100),
	        body 			VARCHAR(5000),
	        tags 			VARCHAR(1000),  
	        create_date 	DATETIME DEFAULT NULL,
	        modify_date 	DATETIME DEFAULT NULL,
	        delete_date 	DATETIME DEFAULT NULL
	    )";
	//print $sql_create_table_user_if_not_exists."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_create_table_articles_if_not_exists);

	//3. Actualizamos la versión de la bbdd
	$sql_update_versions_3 = "INSERT INTO versions(version_number, date, description) VALUES(3, '2016/06/09', 'Creación de tabla de de artículo')";
	//print $sql_update_versions_0."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_update_versions_3);

	//4. Hacemos el commit, porque lo tenemos desactivado
	if (!MysqlDatabaseEngine::get_connection()->commit()) {
	    print("Transaction 3 commit failed\n");
	    exit();
	} else {
		$version_actual = 3;
	}
}

if ($version_actual == "3") {
	$sql_create_table_articles_likes_if_not_exists = 
		"CREATE TABLE IF NOT EXISTS articles_likes (
	        article_id		INT NOT NULL,
	        user_id 		INT NOT NULL,
			`like`			tinyint(1) DEFAULT NULL,
	        date 		 	DATETIME DEFAULT NULL,
	        PRIMARY KEY (article_id, user_id)
	    )";
	print $sql_create_table_articles_likes_if_not_exists."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_create_table_articles_likes_if_not_exists);

	//3. Actualizamos la versión de la bbdd
	$sql_update_versions_4 = "INSERT INTO versions(version_number, date, description) VALUES(4, '2016/06/09', 'Creación de tabla de likes de artículo')";
	//print $sql_update_versions_0."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_update_versions_4);

	//4. Hacemos el commit, porque lo tenemos desactivado
	if (!MysqlDatabaseEngine::get_connection()->commit()) {
	    print("Transaction 4 commit failed\n");
	    exit();
	} else {
		$version_actual = 4;
	}
}

if ($version_actual ==  "4") {
	$sql_create_table_comments_if_not_exists = 
		"CREATE TABLE IF NOT EXISTS comments (
	        id				INT NOT NULL,
	        				PRIMARY KEY(id),
	        article_id		INT DEFAULT NULL,
	        classroom_id	INT DEFAULT NULL,
	        user_id 		INT NOT NULL,
	        body 			VARCHAR(1000),
	        date 		 	DATETIME DEFAULT NULL
	    )";

	//print $sql_create_table_user_if_not_exists."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_create_table_comments_if_not_exists);

	//3. Actualizamos la versión de la bbdd
	$sql_update_versions_5 = "INSERT INTO versions(version_number, date, description) VALUES(5, '2016/06/09', 'Creación de tabla de comentarios')";
	//print $sql_update_versions_0."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_update_versions_5);

	//4. Hacemos el commit, porque lo tenemos desactivado
	if (!MysqlDatabaseEngine::get_connection()->commit()) {
	    print("Transaction 5 commit failed\n");
	    exit();
	} else {
		$version_actual = 5;
	}
}


if ($version_actual ==  "5") {
	$sql_create_table_classrooms_users_if_not_exists = 
		"CREATE TABLE IF NOT EXISTS classrooms_users (
	        classroom_id	INT NOT NULL,
	        user_id 		INT NOT NULL,
	        date 		 	DATETIME DEFAULT NULL,
	        PRIMARY KEY (classroom_id, user_id)
	    )";

	//print $sql_create_table_user_if_not_exists."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_create_table_classrooms_users_if_not_exists);

	//3. Actualizamos la versión de la bbdd
	$sql_update_versions_6 = "INSERT INTO versions(version_number, date, description) VALUES(6, '2016/06/10', 'Creación de tabla de comentarios')";
	//print $sql_update_versions_0."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_update_versions_6);

	//4. Hacemos el commit, porque lo tenemos desactivado
	if (!MysqlDatabaseEngine::get_connection()->commit()) {
	    print("Transaction 6 commit failed\n");
	    exit();
	} else {
		$version_actual = 6;
	}
}


if ($version_actual ==  "6") {
	$sql_alter_table_users_if_not_exists = 
		"ALTER TABLE users ADD karma INT DEFAULT 0";

	//print $sql_create_table_user_if_not_exists."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_alter_table_users_if_not_exists);

	//3. Actualizamos la versión de la bbdd
	$sql_update_versions_7 = "INSERT INTO versions(version_number, date, description) VALUES(7, '2016/06/10', 'Creación de columna de karma')";
	//print $sql_update_versions_0."<br>";
	MysqlDatabaseEngine::get_connection()->query($sql_update_versions_7);

	//4. Hacemos el commit, porque lo tenemos desactivado
	if (!MysqlDatabaseEngine::get_connection()->commit()) {
	    print("Transaction 7 commit failed\n");
	    exit();
	} else {
		$version_actual = 7;
	}
}



/* close connection */
//MysqlDatabaseEngine::get_connection()->close();

//echo "versión actual de bbdd:".$version_actual."<br>";

 ?>