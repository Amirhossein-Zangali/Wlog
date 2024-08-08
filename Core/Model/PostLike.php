<?php

namespace Wlog\Model;

require_once __DIR__ . '/../../init.php';

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    protected $table = 'post_likes';
}