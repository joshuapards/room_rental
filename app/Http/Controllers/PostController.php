<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

use DB;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function searchResult(Request $request)
    {
        $type = $request['type'];
        $max_price = $request['max_price'];
        $location = $request['location'];

        $results = DB::table('posts')->where('type', $type)
                                    ->where('price', '<=',  $max_price)
                                    ->where('location', 'like', "%$location%")
                                    ->orderby('updated_at','desc')
                                    ->paginate(4);

        return view('pages.client.result', ['posts' => $results]);

    }

    /*
    |--------------------------------------------------------------------------
    | This method is use to delete multiple selected posts ids
    |--------------------------------------------------------------------------
    */
    public function postDeleteMultiplePost(Request $request)
    {
        $ids = $request->input('postid');

        if(DB::table('posts')->whereIn('id',$ids)->delete()) {
            return redirect()->route('showposttodelete')->with('message', 'Posts Successfully Delete!');
        }

        return redirect()->route('showposttodelete')->with('error_msg', 'Error Occured. Please Try again later.');
    }

    /*
    |--------------------------------------------------------------------------
    | This method is use to show multiple post to delete
    |--------------------------------------------------------------------------
    */
    public function showPostToDelete()
    {
        $posts = DB::table('posts')->select()->get();

        return view('pages.client.showdelete',['posts' => $posts]);
    }

    /*
    |--------------------------------------------------------------------------
    | This method is use to update the editted content of a post
    |--------------------------------------------------------------------------
    */
    public function postUpdatePost(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:6|max:150',
            'price' => 'required',
            'description' => 'required|min:25',
            'location' => 'required'
            // upload multiple images for the room/appartment
            ]); 
            
        $id = $request['post_id'];
        $title = $request['title'];
        $price = $request['price'];
        $description = $request['description'];
        $location = $request['location'];

        $post = \App\Post::find($id);

        $post->title = $title;
        $post->price = $price;
        $post->description = $description;
        $post->location = $location;

        if($post->save()) {
            return redirect()->route('myposts')->with('message', 'Successfully Updated!');
        }

        return redirect()->route('myposts')->with('error_msg', 'Error Occured. Please try again later.');
    }


    /*
    |--------------------------------------------------------------------------
    | This method is use to edit post of the client/user
    |--------------------------------------------------------------------------
    */
    public function editPost($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();

        if(!empty($post)) {
            $post_data['id'] = $post->id;
            $post_data['title'] = $post->title;
            $post_data['price'] = $post->price;
            $post_data['description'] = $post->description;
            $post_data['location'] = $post->location;

            return view('pages.client.postformedit', $post_data);
        }
        return redirect()->route('mypost')->with('error_msg', 'Error Occured. Please Try again later.');
    }

    /*
    |--------------------------------------------------------------------------------
    | This method is used by the user to delete single post
    | This is on the route('myposts') by the client
    |--------------------------------------------------------------------------------
    */
    public function deletePost($id)
    {
        $delete = DB::table('posts')->delete($id);

        if($delete) {
            return redirect()->route('myposts')->with('message', 'Post Successfully Deleted!');
        }

        return redirect()->route('myposts')->with('error_msg', 'Can\'t Delete Post!');
    }


    /*
    |--------------------------------------------------------------------------------
    | This is index method used by client to view their posts and the status of their post
    |--------------------------------------------------------------------------------
    */
	public function index()
    {
    	$id = Auth::user()->id;
        $posts = DB::table('posts')->where('user_id', '=', $id)->orderby('updated_at','desc')->paginate(4);
        return view('pages.client.posts', ['posts' => $posts]);
    }


    /*
    |--------------------------------------------------------------------------------
    | This methods is use to view the specific post
    |--------------------------------------------------------------------------------
    */
    public function postView($id)
    {
    	$post = DB::table('posts')->where('id', $id)->first();

    	$data['title'] = $post->title;
    	$data['price'] = $post->price;
    	$data['description'] = $post->description;
    	$data['location'] = $post->location;
    	$data['user_id'] = $post->user_id;
        $data['type'] = $post->type;

    	$user = DB::table('users')->where('id', $post->user_id)->first();

    	$data['user_fname'] = $user->firstname;
    	$data['user_lname'] = $user->lastname;
    	$data['user_mobile'] = $user->mobile;
    	$data['user_email'] = $user->email;

        return view('pages.client.post', $data);
    }


    /*
    |--------------------------------------------------------------------------------
    | This methods is use to browse all the posts in the database to view by the client
    |--------------------------------------------------------------------------------
    */
	public function browsePosts()
    {
        $posts = DB::table('posts')->orderby('updated_at','desc')->paginate(4);
        return view('pages.client.browse', ['posts' => $posts]);
    }


    /*
    |--------------------------------------------------------------------------------
    | This methods is use to add post by authenticated client/user
    |--------------------------------------------------------------------------------
    */
    public function postAddPost(Request $request)
    {
    	$this->validate($request, [
            'type' => 'required',
    		'title' => 'required|min:6|max:150',
    		'price' => 'required',
    		'description' => 'required|min:25',
    		'location' => 'required'
    		// upload multiple images for the room/appartment
    		]);

        $type = $request['type'];
    	$title = $request['title'];
    	$price = $request['price'];
    	$description = $request['description'];
    	$location = $request['location'];
    	$user_id = $request['user_id'];

    	$post = new Post();

    	$post->title = $title;
    	$post->price = $price;
    	$post->description = $description;
    	$post->location = $location;
    	$post->user_id = $user_id;
        $post->type = $type;

    	$post->save();

    	return redirect()->route('addpost')->with('message', 'Post Successfully Saved!');
    }
}
