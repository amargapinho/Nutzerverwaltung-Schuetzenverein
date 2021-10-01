<?php
/**
 * @var User $user
 * @var array $config
 */
if(isset($_POST['addUser'])){
    $user->addUser();
}elseif (isset($_GET['removeUser'])){
    $user->removeUser($_GET['removeUser']);
}elseif (isset($_POST['update'])){
    $telefonnummer = $_POST['telefon'] ?? null;
    $email = $_POST['email'] ?? null;
    $user->updateUser($_POST['update'], $_POST['birthday'], $_POST['memberdate'], $_POST['street'], $_POST['number'], $_POST['zipcode'], $_POST['city'], $_POST['fname'], $_POST['lname'], $email, $telefonnummer);
}elseif (isset($_GET['updateNote'])){
    $user->updateNote($_GET['userId'], $_GET['note']);
}elseif (isset($_GET['addTrainingsnachweis'])){
    $user->addTrainingsnachweis($_GET['addTrainingsnachweis']);
}elseif(isset($_GET['removeTraining'])){
    $user->removeTrainingnachweis($_GET['removeTraining']);
}