<?php
namespace app\models;

use PDO;

class Database {
	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $dbname = DB_NAME;
	
	private $conn;
	private $error;
	
	public function __construct() {
		
		// Set DSN
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
		$options = array (
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
		);


		// Create a new PDO instanace
		try {
			$this->conn = new PDO ($dsn, $this->user, $this->pass, $options);
		}		
		
		// Catch any errors
		catch ( PDOException $e ) {
			$this->error = $e->getMessage();
		}
	}

	public function getConnection(){

		return $this->conn;
	}
}