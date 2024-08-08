<?php

namespace Wlog\Model;

require_once __DIR__ . '/../../init.php';

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
}