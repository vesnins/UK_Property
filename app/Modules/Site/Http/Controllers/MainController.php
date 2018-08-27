<?php

namespace App\Modules\Site\Http\Controllers;

use App\Modules\Site\Models\Blog;
use App\Modules\Site\Models\Blog2;
use App\Modules\Site\Models\File;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function index()
    {  var_dump('');
        $blog = new Blog();
        $files = new File();
        //$files = $blog::all();

//        dd($blog->files());
//      $d =   $blog->blog()->paginate(20);
//      $d2 =   $files->files()->paginate(20);


//        print_r($d[0]['files']);
//        ($blog->blog()->get());
        dd($files->files()->first());
//        php artisan models:generate --path="app/Modules/Site/Models" --namespace="App\Modules\Site\Models"

//    php artisan krlove:generate:model Blog --table-name="blog" --output-path="app/Modules/Site/Models" --namespace="App\Modules\Site\Models"
//        dd($files) ;
    }
}
