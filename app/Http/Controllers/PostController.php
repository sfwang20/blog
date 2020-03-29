<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBlogPost;
use App\Post;
use App\Category;
use App\Tag;


class PostController extends Controller
{
    public function admin()
    {
      $posts = Post::all();
      return view('posts.admin', ['posts'=>$posts]);
    }

    public function index()
    {
      $posts = Post::paginate(5);
      return view('posts.index', ['posts' => $posts]);
    }

    public function indexWithCategory (Category $category)
    {
      $posts = Post::where('category_id', $category->id)->get();
      return view('posts.index', ['posts' => $posts]);
    }

    public function indexWithTag(Tag $tag)
    {
      $posts = $tag->posts;
      return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
      $post = new Post;
      $categories = Category::all();
      return view('posts.create', ['post' => $post, 'categories' => $categories]);
    }

    public function store(StoreBlogPost $request)
    {
      $path = $request->file('thumbnail')->store('public');
      $path = str_replace('public/','/storage/', $path);
      //validation
      // $request->validate([
      //     'title' => 'required|max:255',
      //     'content' => 'required',
      // ]);
      $post = new Post;
      $post->fill($request->all());
      $post->user_id = Auth::id();
      $post->thumbnail = $path;
      $post->save();

      $tags = $this->stringToTags($request->tags);
      $this->addTagsToPost($tags, $post);

      return redirect('/posts/admin');
    }

    private function stringToTags($string)
    {
      $tags = explode(', ', $string);
      $tags = array_filter($tags);

      foreach ($tags as $key => $tag){
        $tags[$key] = trim($tag);
      }
      return $tags;
    }

    private function addTagsToPost($tags, $post)
    {
      foreach ($tags as $key => $tag) {
        //create & load tags
        $model = Tag::firstOrCreate(['name' => $tag]);
        // connect post & tag
        $post->tags()->attach($model->id);
      }
    }

    public function show(Post $post)
    {
      // $categories = Category::all();
      $prevPostId = Post::where('id', '<', $post->id)->max('id');
      $nextPostId = Post::where('id', '>', $post->id)->min('id');
      return view('posts.show', ['post' => $post, 'prevPostId' => $prevPostId, 'nextPostId' => $nextPostId]);
    }

    public function showByAdmin(Post $post) {
      return view('posts.showByAdmin', ['post' => $post]);
    }
    public function edit(Post $post)
    {
      $categories = Category::all();
      return view('posts.edit', ['post' => $post, 'categories' => $categories]);
    }

    public function update(StoreBlogPost $request, Post $post)
    {
      $post->fill($request->all());
      if (!is_null($request->file('thumbnail'))) {
        $path = $request->file('thumbnail')->store('public');
        $path = str_replace('public/','/storage/', $path);

        $post->thumbnail = $path;
      }


      $post->save();

      $post->tags()->detach();

      $tags = $this->stringToTags($request->tags);
      $this->addTagsToPost($tags, $post);

      return redirect('/posts/admin');
    }

    public function destroy(Post $post)
    {
      $post->delete();
      return redirect('/posts/admin');
    }
}
