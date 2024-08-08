<?php

namespace Wlog\Model;

require_once __DIR__ . '/../../init.php';

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
}
//$newCategory = new Category();
//$newCategory->name = 'والیبال';
//$newCategory->subcat_id = 3;
//$newCategory->save();