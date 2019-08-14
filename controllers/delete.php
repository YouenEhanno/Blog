<?php

// Validation de la query string dans l'URL.
if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id'])
	AND !array_key_exists('table', $_GET) OR !ctype_alpha($_GET['table']))
{
    header('Location: admin.php');
    exit();
}

// Dépendance : Connexion Bdd
require_once '../conf/Database.php';
$db = new Database();

$table = ucfirst($_GET['table']);
// Suppression d'un article du blog.
$query =
"DELETE FROM
        $table
    WHERE
        Id = :id
";
$db->executeSql($query, [
    ':id' => $_GET['id']
]);

// Redirection vers le panneau d'administration.
header('Location: admin.php');
exit();