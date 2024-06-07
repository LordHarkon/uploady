<?php

$users = $user->getAll();

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}

$role = new Uploady\Role($db, $user);
