<?php
require_once "../init.php";
if (isset($_SESSION['user_id']))
    $user = \Wlog\Model\User::find($_SESSION['user_id']);
else
    header("location: ./../index.php");

if ($user->role == 'admin')
    header("location: ./admin.php");
else if ($user->role == 'writer')
    header("location: ./writer.php");
else if ($user->role == 'user')
    header("location: ./user.php");
