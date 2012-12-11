<?php

namespace framework;

include('../../../../config.php');
include("../../../../framework/autoload.class.php");
include("../../../../framework/user.class.php");

session_start(); autoload::init();

$_SESSION['CAPSULE_REGISTER'] = $_POST;

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>