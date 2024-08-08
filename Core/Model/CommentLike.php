<?php

namespace Wlog\Model;

require_once __DIR__ . '/../../init.php';

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    protected $table = 'comment_likes';
}