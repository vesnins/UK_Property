<?php

namespace App\Modules\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Files extends Eloquent
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files';

    protected $primaryKey = 'id';
}
