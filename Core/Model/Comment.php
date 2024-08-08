<?php

namespace Wlog\Model;

require_once __DIR__ . '/../../init.php';

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
}