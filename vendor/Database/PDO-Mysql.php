<?php

$App = require '../../config/app.php';
$DB_CONNECTION = require '../../config/database.php';

class DB {
	public static $Pdo;

	public function construct() {
		global $DB_CONNECTION;
		try {
			self::$Pdo = new PDO('mysql:host=' . DB_HOST . ';' .
				'dbname=' . DB_DATABASE . ';' .
				'port=' . DB_PORT . ';',
				DB_USERNAME, DB_PASSWORD,
				array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES ' .
				$DB_CONNECTION['connections'][DB_CONNECTION]['charset']));
		} catch (PDOException $e) {
			die('Error: ' . $e->getMessage() . '<br>');
		}
	}

	public function select($sql) {
		$statement = self::$Pdo->query($sql);
		if ($statement === false)
			return null;
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$result = array();
		foreach ($statement as $row)
			$result[] = $row;
		return $result;
	}

	public function insert($sql) {
		$affected_rows = self::$Pdo->exec($sql);
		return $affected_rows;
	}

	public function update($sql) {
		$affected_rows = self::$Pdo->exec($sql);
		return $affected_rows;
	}

	public function delete($sql) {
		$affected_rows = self::$Pdo->exec($sql);
		return $affected_rows;
	}

	public function statement($sql) {
		$affected_rows = self::$Pdo->exec($sql);
		return $affected_rows;
	}

	public function unprepared($sql) {
		$affected_rows = self::$Pdo->exec($sql);
		return $affected_rows;
	}
}

DB::construct();
