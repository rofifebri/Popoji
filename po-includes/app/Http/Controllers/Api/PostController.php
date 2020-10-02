<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;

class PostController extends Controller
{
    public function get(Request $request)
    {
        $per_page = $request->per_page ?: 20;
        $category = $request->category ?: null;
        $search =  $request->search ?: null;
        $headline = $request->headline == 'Y' ? 'Y' : null;
        $orderBy = $request->orderBy == 'ASC' ? 'ASC' : 'DESC';
        $query = Post::with(['category:id,parent,title,seotitle,picture', 'createdBy:id,name,username,bio,picture', 'updatedBy:id,name,username,bio,picture'])->withCount('comments')->where('active', 'Y');
        // Filter post by category
        if($category != null) {
            $query->where('category_id', $category);
        }
        // Search post
        if($search != null) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }
        // Headline post
        if($headline != null) {
            $query->where('headline', $headline);
        }
        // OrderBy post
        if($orderBy != null) {
            $query->orderBy('created_at', $orderBy);
        }
        $posts = $query->paginate($per_page);
        foreach($posts as $post){
            // Change picture to url for get image.
            if($post->picture != null) {
                $post->picture = url('/po-content/uploads/' . $post->picture);
            }
        }
        // Hidden key
        $posts->makeHidden(['created_by', 'updated_by', 'category_id', 'active']);
        return response()->json($posts);
    }
    public function show($id)
    {
        $post = Post::where('id',  $id)->with(['category:id,parent,title,seotitle,picture', 'createdBy:id,name,username,bio,picture', 'updatedBy:id,name,username,bio,picture'])->withCount('comments')->where('active', 'Y')->first();
        if(!$post){
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }
        if($post->picture != null) {
            $post->picture = url('/po-content/uploads/' . $post->picture);
        }
        // Update hits
        $post->increment('hits');
        // Hidden key
        $post->makeHidden(['created_by', 'updated_by', 'category_id', 'active']);
        return response()->json($post);
    }
}