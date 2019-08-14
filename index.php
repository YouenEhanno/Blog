<?php
// Dépendance : Connexion Bdd
require_once 'conf/Database.php';

// Création de l'instance à la bdd
// @TODO optimiser les appels, pour n'avoir qu'une seule instance 
$db = new Database();

// init session
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Récupération de tous les articles du blog classés par ordre antéchronologique.
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
    ORDER BY
        CreationTimestamp DESC
';

$posts = $db->findAll($query, []);

// Sélection et affichage du template PHTML.
$template = 'index';
include 'layout.phtml';