<?php

use Wlog\Model\Comment;
use Wlog\Model\Subscribe;

require_once __DIR__ . '/init.php';

if (isset($_POST['subscribe'])){
    $email = checkInput($_POST['email']);
    if (empty($email))
        header('Location: index.php');
    else {
        $isSubscribe = Subscribe::where('email', $email)->count();
        if ($isSubscribe)
            header('Location: index.php?subscribe=exist');
        else {
            $subscribe = new Subscribe();
            $subscribe->email = $email;
            $subscribe->save();
            if ($subscribe)
                header('Location: index.php?subscribe=true');
        }
    }
}

if (isset($_POST['comment'])){
    $comment_text = checkInput($_POST['text']);
    if (!isset($_SESSION['user_id']))
        header("Location: single.php?id={$_POST['post_id']}&user=empty");
    if (empty($comment_text))
        header("Location: single.php?id={$_POST['post_id']}");
    else {
        $comment = new Comment();
        $comment->post_id = $_POST['post_id'];
        $comment->user_id = $_SESSION['user_id'];
        $comment->content = $comment_text;
        $comment->reply = $_POST['reply'];
        $comment->save();
        if ($comment)
            header('Location: single.php?id=' . $comment->post_id . '&comment=true');

    }
}
if (isset($_POST['signup'])) {
    $name = checkInput($_POST['name']);
    $username = checkInput($_POST['username']);
    $password = checkInput($_POST['password']);
    $email = checkInput($_POST['email']);

    if (empty($name) || empty($username) || empty($password) || empty($email)) {
        header('location: register.php?err=empty');
    }else{
        $findUser = \Wlog\Model\User::where('username', $username)->orWhere('email', $email)->count();
        if ($findUser){
            header('location: register.php?err=exist');
        } else {
            $user = new \Wlog\Model\User();
            $user->name = $name;
            $user->username = $username;
            $user->email = $email;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->save();
        }

        if ($user){
            $_SESSION['user_id'] = $user->id;
            header('location: index.php');
        }else {
            $_SESSION['err'] = $user;
            header('location: register.php?err=' . $user);
        }
    }
}
if (isset($_POST['signin'])) {
    $username = checkInput($_POST['username']);
    $password = checkInput($_POST['password']);
    if (empty($username) || empty($password)) {
        header('location: login.php?err=empty');
    } else {
        $user = \Wlog\Model\User::where('username' , $username)->first();
        $findUser = false;
        if ($user->id)
            $findUser = password_verify($password, $user->password);
        if ($findUser){
            $_SESSION['user_id'] = $user->id;
            header('location: index.php');
        } else {
            $_SESSION['err'] = $user->id;
            header('location: login.php?err=notFindUser');
        }
    }
}


function checkInput($value)
{
    return htmlspecialchars(trim($value));
}