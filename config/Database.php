<?php

namespace Inspirational\config;

use PDO;
use PDOException;

class Database
{
	private $hostName = 'localhost';
	private $dbName = 'inspirational';
	private $username = 'root';
	private $password;
	private $pdo;

	public function __construct()
	{
		/** @noinspection UnusedConstructorDependenciesInspection */
		$this->password = ini_get('mysqli.default_pw');

		try {
			/** @noinspection UnusedConstructorDependenciesInspection */
			$this->pdo = new PDO("mysql:host=$this->hostName;dbname=$this->dbName;", $this->username, $this->password);
			$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $err) {
			echo 'Error connecting to the database: ' . $err->getMessage();
		}
	}

	public function fetchAll($query): ?array
	{
		$stmt = $this->pdo->query($query);
		$rowCount = $stmt->rowCount();

		if ($rowCount <= 0) {
			return null;
		}

		return $stmt->fetchAll();
	}

	public function fetchOne($query, $parameter): ?array
	{
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([$parameter]);
		$rowCount = $stmt->rowCount();

		if ($rowCount <= 0) {
			return null;
		}

		return $stmt->fetch();
	}
}
