<?php

if (empty($_POST)) {
    // Sélection et affichage du template PHTML.
    $template = 'login';
    include '../layout.phtml';
} else {
    // Dépendance : Connexion Bdd
    require_once '../conf/Database.php';
    $db = new Database();

    $query =
    'SELECT
            Id,
            Name,
            Email,
            Password,
			IsAdmin
        FROM
            User
        WHERE
            Email = :email
    ';
    $user = $db->findOne($query, [
        ':email' => $_POST['email']
    ]);
    // Est-ce qu'on a bien trouvé un utilisateur ?
    if(empty($user))
    {
        throw new DomainException
        (
            "Il n'y a pas de compte associé à cette adresse email"
        );
    }

    // Est-ce que le mot de passe spécifié est correct par rapport à celui stocké ?
    if(!password_verify($_POST['password'], $user['Password']))
    {
        throw new DomainException
        (
            'Le mot de passe spécifié est incorrect'
        );
    }

    // Création de la session
    // Init session
    if(session_status() == PHP_SESSION_NONE)
    {
        // Démarrage du module PHP de gestion des sessions.
        // Ce qui donne accès à $_SESSION
        session_start();
    }

    $_SESSION['user'] = [];

    $_SESSION['user']['id'] = $user['Id'];
    $_SESSION['user']['name'] = $user['Name'];
    $_SESSION['user']['admin'] = $user['IsAdmin'];

    // Retour à la page d'accueil une fois que le nouvel article du blog a été ajouté.
    header('Location: ../index.php');
    exit();
}
