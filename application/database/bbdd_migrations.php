<?php 
/* 
 * Fichero que controla las migrations de bbdd
 *
 */

//1. Connectamos con el servidor. Las variables de configuración están en el fichero /config.php

$conn = new mysqli($bbdd_server, $bbdd_user, $bbdd_password);

/* set autocommit to off */
$conn->autocommit(FALSE);

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
$sql_creacion_bbdd = "CREATE DATABASE IF NOT EXISTS $bbdd_name";
//print $sql_creacion_bbdd."<br>";
$conn->query($sql_creacion_bbdd);

//2. Seleccionamos la BBDD
$conn->select_db($bbdd_name);

//3. Comprobamos si existe la tabla de versiones y la creamos
$sql_create_table_versions_if_not_exists = 
	"CREATE TABLE IF NOT EXISTS versions (
        version_number INT NOT NULL,
        PRIMARY KEY(version_number),
        DATE    date NOT NULL,
        description VARCHAR(500) NOT NULL
    )";
//print $sql_create_table_versions_if_not_exists."<br>";
$conn->query($sql_create_table_versions_if_not_exists);

//4. Comprobamos que la versión 0 (la inicial), no esté ya
$sql_check_actual_version = "SELECT MAX(version_number) version_actual FROM versions";
//print $sql_check_actual_version."<br>";
$result_check_actual_version = $conn->query($sql_check_actual_version);
$row_check_actual_version = $result_check_actual_version->fetch_array();

$version_actual = 0;

if(is_null($row_check_actual_version["version_actual"])) { //Si no existe ningún registro, insertamos la versión 0
	$sql_update_versions_0 = "INSERT INTO versions(version_number, date, description) VALUES(0, NOW(), 'versión incial de la bbdd')";
	//print $sql_update_versions_0."<br>";
	$conn->query($sql_update_versions_0);
} else {
	$version_actual = $row_check_actual_version["version_actual"];
}

//5. Hacemos el commit, porque lo tenemos desactivado
if (!$conn->commit()) {
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
	$sql_create_table_user_if_not_exists = 
		"CREATE TABLE IF NOT EXISTS users (
	        id INT NOT NULL AUTO_INCREMENT,
	        PRIMARY KEY(id),
	        name VARCHAR(50) NOT NULL
	    )";
	//print $sql_create_table_user_if_not_exists."<br>";
	$conn->query($sql_create_table_user_if_not_exists);

	//2. Insertamos, si no lo están ya los usuarios de prueba (Habrá que hacerlo para cada usuario que se quiera insertar)
	function insertar_usuario_si_no_existe($name) {
		global $conn;

		$sql_check_user1_exists = "SELECT * FROM users WHERE name = '$name'";
		//print $sql_check_user1_exists."<br>";
		$result_user1_exists = $conn->query($sql_check_user1_exists);
		$row_check_user1_exists = $result_user1_exists->fetch_array();

		if(is_null($row_check_user1_exists["name"])) { //Si no existe ningún registro, insertamos la versión 0
			$sql_insert_user = "INSERT INTO users(name) VALUES('$name')";
			//print $sql_insert_user."<br>";
			$conn->query($sql_insert_user);
		} 
	}

	insertar_usuario_si_no_existe("galo");
	insertar_usuario_si_no_existe("juan");

	//3. Actualizamos la versión de la bbdd
	$sql_update_versions_1 = "INSERT INTO versions(version_number, date, description) VALUES(1, NOW(), 'Creación de tabla usuarios, inserción de datos de prueba')";
	//print $sql_update_versions_0."<br>";
	$conn->query($sql_update_versions_1);
}


//4. Hacemos el commit, porque lo tenemos desactivado
if (!$conn->commit()) {
    print("Transaction commit failed\n");
    exit();
}


/* close connection */
$conn->close();

echo "versión actual de bbdd:".$version_actual."<br>";

 ?>