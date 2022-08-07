<?php

use App\Http\Controllers\PostController;
use App\Models\County;
use App\Models\Post;
use App\Models\User;
use App\Models\Role;
use App\Models\Photo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Prophecy\Call\Call;
use App\Models\Tag;
use App\Models\Video;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/post/{id}', \App\Http\Controllers\PostController::class . '@index', function () {
});

Route::resource('posts', \App\Http\Controllers\PostController::class);
Route::get('/contact', [PostController::class, "contact"]);
Route::get('post/{id}/{name}/{pass}', [PostController::class, "showPost"]);

// CRUD OPERATIONS !!!!
Route::get('/insert', function () {
    DB::insert('insert into posts(title,content) values(?,?)', ['PhP with React', 'React is the best']);
});

Route::get('/read', function () {
    $result = DB::select('select * from posts where id = ?', [1]);
    foreach ($result as $post) {
        return $post->title;
    }
});
Route::get('/update', function () {
    $updated = DB::update('update posts set title = "updated title" where id =?', [1]);
    return $updated;
});
Route::get('/delete', function () {
    $deleted = DB::delete('delete from posts where i d =?', [1]);
    return $deleted;
});
/*  

Eloquent

*/
Route::get('/find', function () {
    $posts = Post::all();

    foreach ($posts as $post) {
        return $post->title;
    }
});
// finding with constraints
Route::get('/findwhere', function () {
    $posts = Post::where('id', 3)->orderBy('id', 'desc')->take(1)->get();
    return $posts;
    foreach ($posts as $post) {
        return $post->title;
    }
});
Route::get('/findmore', function () {
    $posts = Post::findOrFail(2);
    //return $posts;
    $posts2 = Post::where('users_count', '<', 50)->firstOrFail();
});
// Insert record
Route::get('/basicInsert', function () {
    $post = new Post;
    $post->title = "New Eloquent title";
    $post->content = "Wow Eloquent is really cool.";
    $post->save();
});
Route::get('/basicInsertUser', function () {
    $post = new User;
    $post->name = "Chris";
    $post->email = "chris@email.com";
    $post->password = "Peter123";
    $post->save();
});
Route::get('/basicInsertRole', function () {
    $post = new Role;
    $post->name = "Admin";
    $post->save();
});
Route::get('/insertUserRole', function () {
    $post = new Role;
    $post->role_id = 1;
    $post->user_id = 2;
    $post->save();
});
// Update record
Route::get('/basicUpdate/{id}', function ($id) {
    $post = Post::find($id);
    $post->title = "New Eloquent title insert number " . $id;
    $post->content = "Wow Eloquent is really cool " . $id;
    $post->save();
});
// Create Data
Route::get('/createData', function () {
    Post::create(["title" => "PHP create method", "content" => "Wow i'm learning alot with PHP!"]);
});
// Update method
Route::get('/updateData', function () {
    Post::where('id', 2)->where('its_admin', 0)->update(['title' => "new php title", "content" => "new php content"]);
});
// Delete Data
Route::get('/deleteData', function () {
    $post = Post::find(1);
    $post->delete();
});
// Delete another way
Route::get('/delete2', function () {
    // if key is known can use destroy
    Post::destroy(3);
});
// Delete multiple data
Route::get('/deleteMultiple', function () {
    Post::destroy([4, 2]);
});
// Delete temporarily (put into trash)
Route::get('/softDelete', function () {
    Post::find(5)->delete();
});
// Read soft deleted item
// "onlyTrashed" only select trashed item whereas "withTrashed" select all item including trashed trashed trashed
Route::get('/readDelete', function () {
    $post = Post::withTrashed()->where('id', 1)->get();
    return $post;
});
// Read all soft deleted items
Route::get('/readDeleted', function () {
    $post = Post::onlyTrashed()->get();
    return $post;
});
// Restore soft deleted items
Route::get('/restore', function () {
    Post::withTrashed()->restore();
});
// Permanent delete
Route::get('/permanentDelete', function () {
    Post::onlyTrashed()->where('id', 5)->forceDelete();
});
/*  
[-----------------------------------------------------------------------
ELOQUENT RELATIONSHIP
[-----------------------------------------------------------------------
*/
// One to One (Has one) relationship
Route::get('/user/post/{id}', function ($id) {
    return User::find($id)->post;
});
// inverse of one to one
Route::get('/post/{id}/user', function ($id) {
    return Post::find($id)->user->name;
});
// One to many relationship
Route::get('/user/{id}/posts', function ($id) {
    $user = User::find($id);
    foreach ($user->posts as $post) {
        echo $post->title . "<br>";
    }
});
// Many to Many relationship
Route::get('/user/{id}/role', function ($id) {
    $user = User::find($id);
    foreach ($user->roles as $role) {
        return $role->name;
    }
});
// Intermediate table (pivid table)
Route::get('user/pivid', function () {
    $user = User::find(2);
    foreach ($user->roles as $role) {
        echo $role->pivot->user_id;
    }
});
// Has many through
Route::get('/user/country', function () {
    $county = County::find(1);
    foreach ($county->posts as $post) {
        echo $post->title . "<br></br>";
    }
});
/*  
[-----------------------------------------------------------------------
POLYMORPHIC RELATIONSHIP (Relation between Models (One model related to one or more models))
[-----------------------------------------------------------------------
*/
Route::get('user/{id}/photo', function ($id) {
    $user = User::find($id);
    foreach ($user->photos as $photo) {
        echo $photo->path;
    }
});
Route::get('post/{id}/photo', function ($id) {
    $user = Post::find($id);
    foreach ($user->photos as $photo) {
        return $photo;
    }
});
// Inverse
Route::get('photo/{id}/post', function ($id) {
    $photo = Photo::findOrFail($id);
    return $photo->imageable;
});
// Many to Many
Route::get('/post/{id}/tag', function ($id) {
    $post =  Post::findOrFail($id);
    foreach ($post->tags as $tag) {
        echo $tag->pivot->taggable_type;
    }
});
// Inverse
Route::get('/tag/{id}/post', function ($id) {
    $tag =  Tag::findOrFail($id);
    foreach ($tag->posts as $post) {
        echo $post->title;
    }
});
Route::get('/tag/{id}/video', function ($id) {
    $tag =  Video::findOrFail($id);
    foreach ($tag->videos as $video) {
        echo $video;
    }
});
/*  
[-----------------------------------------------------------------------
TINKER
[-----------------------------------------------------------------------
// php artisan tinker
*/



// Route::get('/about', function () {
//     return "Hi about page";
// });

// Route::get('/contact', function () {
//     return "Hi contact page";
// });

// Route::get('/post/example', array('as' => 'admin.home', function () {
//     $url = route('admin.home');
//     return "this url is " . $url;
//     //return ("THis is post number " . $id . " " . $name);
// }));




/*  
[-----------------------------------------------------------------------
FORM VALIDATION CRUD APPLICATION
[-----------------------------------------------------------------------
*/

Route::resource('/post', PostController::class);
