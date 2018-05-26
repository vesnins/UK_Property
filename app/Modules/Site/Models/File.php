<?php

namespace App\Modules\Site\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_album
 * @property string $name
 * @property string $text
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property int $size
 * @property int $main
 * @property string $orig_name
 * @property string $created_at
 * @property string $updated_at
 * @property string $type
 * @property string $file
 * @property string $name_table
 * @property string $crop
 * @property int $active
 * @property Blog $blog
 */
class File extends Model
{
    protected $table = 'files';

    /**
     * @var array
     */
    protected $fillable = ['id_album', 'name', 'text', 'title', 'description', 'keywords', 'size', 'main', 'orig_name', 'created_at', 'updated_at', 'type', 'file', 'name_table', 'crop', 'active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blog()
    {
        return $this->belongsToMany('App\Modules\Site\Models\Files', 'blog', 'blog_id', 'blog_id', 'id_album', 'id_album', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function files()
    {
        return $this->with('blog');
    }
}
