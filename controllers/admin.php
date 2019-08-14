<?php
// Dépendance : Connexion Bdd
require_once '../conf/Database.php';
$db = new Database();

// die('admin');
// Récupération de tous les articles du blog classés par ordre antéchronologique.
$query =
'SELECT
        Post.Id,
        Title,
        Contents,
        CreationTimestamp,
        FirstName,
        LastName,
        Category.Name AS Category_Name
    FROM
        Post
    INNER JOIN
        Author
    ON
        Post.Author_Id = Author.Id
    INNER JOIN
        Category
    ON
        Post.Category_Id = Category.Id
    ORDER BY
        CreationTimestamp DESC
';
$posts = $db->findAll($query, []);

// Sélection et affichage du template PHTML.
$template = 'admin';
include '../layout.phtml';