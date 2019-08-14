<?php

// Validation de la query string dans l'URL.
if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
{
    header('Location: index.php');
    exit();
}

// Dépendance : Connexion Bdd
require_once '../conf/Database.php';
$db = new Database();

// Récupération d'un article du blog.
$query =
'SELECT
        Post.Id,
        Title,
        Contents,
        CreationTimestamp,
        FirstName,
        LastName
    FROM
        Post
    INNER JOIN
        Author
    ON
        Post.Author_Id = Author.Id
    WHERE
        Post.Id = :id
';
$post = $db->findOne($query, [
    ':id' => $_GET['id']
]);

// Récupération de tous les commentaires de l'article du blog.
$query =
'SELECT
        NickName,
        Contents,
        CreationTimestamp
    FROM
        Comment
    WHERE
        Post_Id = :id
';
$comments = $db->findAll($query, [
    ':id' => $_GET['id']
]);

// Sélection et affichage du template PHTML.
$template = 'show_post';
include '../layout.phtml';