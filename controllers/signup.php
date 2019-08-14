<?php

if (empty($_POST)) {
    // Sélection et affichage du template PHTML.
    $template = 'signup';
    include '../layout.phtml';
} else {
    // Dépendance : Connexion Bdd
    require_once '../conf/Database.php';
    $db = new Database();
    // Vérifier si l'email exist déjà en bdd
    $query =
    'SELECT
            Id,
            Name,
            Email,
            Password
        FROM
            User
        WHERE
            Email = :email
    ';
    $user = $db->findOne($query, [
        ':email' => $_POST['email']
    ]);

    // Est-ce qu'on a bien trouvé un utilisateur ?
    if(!empty($user))
    {
        throw new DomainException
        (
            "Il y a déjà un compte associé à cette adresse email"
        );
        header('Location: ../index.php');
        exit();
    }

    // Hash du password
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query =
        'INSERT INTO
                User
                (Name, Email, Password, CreationTimestamp)
            VALUES
                (:name, :email, :password, NOW())
        ';
    $db->executeSql($query, [
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':password' => $passwordHash
    ]);

    // Retour à la page d'accueil une fois que le nouvel article du blog a été ajouté.
    header('Location: ../index.php');
    exit();
}
