<?php
// include('views/dashboard.php');
include_once('functions.php');

if(IsSet($_POST['action']) && ($_POST['action'] == 'login')) 
{
    $user = false;
    $error = "";
    if(IsSet($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $error .= "<li>Veuillez entrer une adresse e-mail</li>";
    }

    if(IsSet($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $error .= "<li>Veuillez entrer un mot de passe</li>";
    }

    if(IsSet($email) && IsSet($password)) {
        $stmt = $db->prepare("SELECT * FROM clients WHERE email=:email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() == 1) {
            $client = $stmt->fetch(PDO::FETCH_ASSOC);
            if($client['password'] == $password) {
                setcookie('client_id', $client['id']);
                setcookie('password_hash', sha1($client['password']));
                header('Location: /');
                die();
            } else {
                $error = "<li>Mot de passe incorrect</li>";
            }
        } else {
            $error = "<li>Indentifiant inconnu</li>";
        }
    }

    include('views/login.php');

} 
else if(!$user) 
{
    include('views/login.php');
} 
else 
{
    if(IsSet($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = false;
    }

    if($page == "room") {
        include('views/room.php');
    } else {
        include('views/dashboard.php');
    }
}
?>