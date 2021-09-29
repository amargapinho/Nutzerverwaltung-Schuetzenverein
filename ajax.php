<?php
include_once __DIR__ . '/src/classes/User.php';
$user = new User();


if(isset($_GET['loadInfo'])){
    $message = array();
    $message['abteilungen'] = $user->getMitgliedAbteilungen($_GET['loadInfo']);
    $message['price'] = $user->getMitgliedCost($_GET['loadInfo']);
    $message['M_ID'] = $_GET['loadInfo'];
    $message['note'] = $user->getNote($_GET['loadInfo']);
    $message['trainingsnachweise'] = $user->getTrainingsnachweise($_GET['loadInfo']);
    $message['pistole'] = $user->userCanBuyGun($_GET['loadInfo']);
    $user->sendAjax($message);
}elseif (isset($_GET['loadUser'])){
    $message = $user->getUserById($_GET['loadUser'])[0];
    $message['abteilungen'] = $user->getMitgliedAbteilungen($_GET['loadUser']);
    $user->sendAjax($message);
}elseif (isset($_GET['updateNote'])){
    $user->updateNote($_GET['userId'], $_GET['note']);
}