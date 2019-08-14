<?php
// Dépendance : Connexion Bdd
require_once '../conf/Database.php';

$db = new Database();

// Ajout d'un commentaire à un article du blog.
$query =
'INSERT INTO
        Comment
        (NickName, Contents, Post_Id, CreationTimestamp)
    VALUES
        (:nickname, :contents, :postId, NOW())
';
$db->executeSql($query, [
    ':nickname' => $_POST['nickName'],
    ':contents' => $_POST['contents'],
    ':postId'   => $_POST['postId']
]);

// Retour à l'article détaillé une fois que le nouveau commentaire a été ajouté.
header('Location: show_post.php?id='.$_POST['postId']);
exit();