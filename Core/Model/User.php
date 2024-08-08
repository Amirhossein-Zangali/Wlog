<?php

namespace Wlog\Model;

require_once __DIR__ . '/../../init.php';

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
}
//$username = 'amir';
//$user = User::where('username', $username)->first();
//if (empty($user)) {
//    $newUser = new User;
//    $newUser->name = $username;
//    $newUser->username = $username;
//    $newUser->password = password_hash('123', PASSWORD_DEFAULT);
//    $newUser->email = "$username@gmail.com";
//    $newUser->save();
//    echo 'save';
//} else
//    echo 'exist';