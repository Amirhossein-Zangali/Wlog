<?php

namespace Wlog\Model;

require_once __DIR__ . '/../../init.php';

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table = 'subscribers';
}