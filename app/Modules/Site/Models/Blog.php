<?php

namespace App\Modules\Site\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $blog_id
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $url
 * @property string $author
 * @property string $text
 * @property string $name
 * @property string $cat
 * @property string $date
 * @property int    $active
 * @property int    $translation_id
 * @property string $desc_little
 * @property string $created_at
 * @property string $updated_at
 * @property int    $files_id
 * @property File[] $files
 */
class Blog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog';

    /**
     * @var array
     */
    protected $fillable = ['title', 'keywords', 'description', 'url', 'author', 'text', 'name', 'cat', 'date', 'active', 'translation_id', 'desc_little', 'created_at', 'updated_at', 'files_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files()
    {
        return $this->belongsToMany('App\Modules\Site\Models\Files', 'blog', 'blog_id', 'blog_id', 'id_album', 'id_album');
       // return $this->belongsToMany('App\Modules\Site\Models\Files', 'blog', 'blog_id', 'id_album', 'blog_id', 'blog_id', 'id');
    }

    public function blogFiles()
    {
        return $this->hasOne('App\Modules\Site\Models\Blog');
//        return $this->belongsToMany('App\Modules\Site\Models\Blog', 'files',  'id_album', 'id_album', 'blog_id', 'blog_id');
        // return $this->belongsToMany('App\Modules\Site\Models\Files', 'blog', 'blog_id', 'id_album', 'blog_id', 'blog_id', 'id');
    }

    public function blog()
    {
        return $this->with('files');
    }
}
