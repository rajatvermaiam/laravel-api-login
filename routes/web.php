<?php

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

use App\Events\SendMessage;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/chat/{id}', function ($id) {
    $messages = Message::where(function ($q) use ($id) {
        $q->where('to', Auth::id())->Where('from', $id);
    })->orWhere(function ($q) use ($id) {
        $q->where('to', $id)->Where('from', Auth::id());
    })->with('user')->get();
    return view('chat', compact('messages'));
})->middleware('auth');

Route::post('/send', function (Request $request) {
    $request['from'] = Auth::id();
    $message = Message::create($request->all());
    $message = $message->load('user');
    event(new SendMessage($message));
    return $message;
});

Route::get('/', function () {
    if (request()->ajax()) {
        return datatables()->of(Message::with('user')->select([
            'message', 'created_at', 'id', 'from'
        ]))->addColumn('action', function ($data) {
            $btn = '<a href="google.com" class="btn btn-primary btn-sm">Edit</a>';
            $btn = $btn . ' <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick=deleteItem(' . $data->id . ')>Delete</a>';
            return $btn;
        })
            ->addIndexColumn()
            ->make(true);
    }
    return view('welcome');
});

Route::delete('/delete-todo/{id}', function ($id) {
    return Response::json($id);
});

Auth::routes(['verify' => true]);
Route::get('login/{provider}', 'Auth\SocialiteController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialiteController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');
