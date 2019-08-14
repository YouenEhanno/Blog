<?php

class Database
{
	public static $_instance;

	public function __construct()
	{
		//	Connexion à la base de données
		try {

			if (self::$_instance === null) {
				self::$_instance = new PDO(
					'mysql:host=localhost;dbname=blog;charset=UTF8',
					'root',
					'troiswa',
					[
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
					]
				);
				self::$_instance->exec('SET NAMES utf8mb4 COLLATE utf8mb4_general_ci');
				// throw new PDOException("La connexion a échouée", 1);
			}
		} catch (PDOException $e) {
			echo "Message d'erreur : $e->getMessage() /n Code erreur : $e->getCode()";
		}
	}

	/**
	 * Description Requête Insert/Update/Delete
	 * @param string $sql
	 * @param array $values
	 *
	 * @return int Le dernier id inseré en bdd sur cette table
	 */
	public function executeSql($sql, array $values = array())
	{
		$query = self::$_instance->prepare($sql);
		$query->execute($values);

		return self::$_instance->lastInsertId();
	}

	/**
	 * Description Requête Select pour récupérer un ensemble de résultats
	 * @param string $sql
	 * @param array $criteria
	 *
	 * @return array Ensemble de résultats
	 */
	public function findAll($sql, array $criteria = array())
	{
		$query = self::$_instance->prepare($sql);
		$query->execute($criteria);

		return $query->fetchAll();
	}

	/**
	 * Descritption Requête Select pour récupérer un seul résultat
	 * @param string $sql
	 * @param array $criteria
	 *
	 * @return array Un élément
	 */
	public function findOne($sql, array $criteria = array())
	{
		$query = self::$_instance->prepare($sql);
		$query->execute($criteria);

		return $query->fetch();
	}
}