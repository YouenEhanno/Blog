<?php
// Dépendance : Connexion Bdd
require_once '../conf/Database.php';
$db = new Database();

if (empty($_POST)) {
    // Récupération de tous les auteurs du blog.
    $query =
        'SELECT
                Id,
                FirstName,
                LastName
            FROM
                Author
        ';
    $authors = $db->findAll($query, []);

    // Récupération de toutes les catégories du blog.
    $query =
        'SELECT
                Id,
                Name
            FROM
                Category
        ';
    $categories = $db->findAll($query, []);

    // Sélection et affichage du template PHTML.
    $template = 'add_post';
    include '../layout.phtml';
} else {

    // Ajout d'un article du blog.
    $query =
        'INSERT INTO
                Post
                (Title, Contents, Author_Id, Category_Id, CreationTimestamp)
            VALUES
                (:title, :contents, :author, :category, NOW())
        ';
        $db->executeSql($query, [
            ':title' => $_POST['title'],
            ':contents' => $_POST['contents'],
            ':author' => $_POST['authors'],
            ':category' => $_POST['category']
        ]);

    // Retour à la page d'accueil une fois que le nouvel article du blog a été ajouté.
    header('Location: admin.php');
    exit();
}
