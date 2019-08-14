<?php
// Dépendance : Connexion Bdd
require_once '../conf/Database.php';
$db = new Database();

if(empty($_POST))
{
    // Validation de la query string dans l'URL.
    if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
    {
        header('Location: admin.php');
        exit();
    }

    // Récupération d'un article du blog.
    $query =
    'SELECT
            Id,
            Title,
            Contents
        FROM
            Post
        WHERE
            Id = :id
    ';
    $post = $db->findOne($query, [
        ':id' => $_GET['id']
    ]);

    // Sélection et affichage du template PHTML.
    $template = 'edit_post';
    include '../layout.phtml';
}
else
{
    // die('Edit');
    // Edition d'un article du blog.
    $query =
    'UPDATE
            Post
        SET
            Title = :title,
            Contents = :contents
        WHERE
            Id = :postId
    ';
    $db->executeSql($query, [
        ':title' => $_POST['title'],
        ':contents' => $_POST['contents'],
        ':postId' => $_POST['postId']
    ]);

    // Retour au panneau d'administration.
    header('Location: admin.php');
    exit();
}