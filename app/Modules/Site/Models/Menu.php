<?php

namespace App\Modules\Site\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $name
 * @property string $sys_cat
 * @property string $text
 * @property int $active
 * @property int $cat
 * @property string $title
 * @property string $author
 * @property string $keywords
 * @property string $description
 * @property int $order
 * @property string $class
 * @property string $translation
 * @property string $controller
 * @property string $sort
 */
class Menu extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'menu';

    /**
     * @var array
     */
    protected $fillable = ['created_at', 'updated_at', 'name', 'sys_cat', 'text', 'active', 'cat', 'title', 'author', 'keywords', 'description', 'order', 'class', 'translation', 'controller', 'sort'];

}
