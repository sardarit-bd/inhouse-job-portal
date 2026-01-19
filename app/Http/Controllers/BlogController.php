<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the blog posts.
     */
    public function index()
    {
        $blogs = Blog::published()
            ->orderBy('published_at', 'desc')
            ->paginate(12);
            
        $featuredBlogs = Blog::published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
            
        $categories = Blog::published()
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->pluck('category');
            
        return view('blogs.index', compact('blogs', 'featuredBlogs', 'categories'));
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        
        // Check if blog is published
        if (!$blog->is_published || ($blog->published_at && $blog->published_at->isFuture())) {
            abort(404);
        }
        
        // Increment view count
        $blog->incrementViews();
        
        // Get related posts - fixed query
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where(function ($query) use ($blog) {
                // Match by category
                if ($blog->category) {
                    $query->where('category', $blog->category);
                }
                
                // Match by tags
                if ($blog->tags && is_array($blog->tags) && count($blog->tags) > 0) {
                    $query->orWhere(function ($q) use ($blog) {
                        foreach ($blog->tags as $tag) {
                            $q->orWhereJsonContains('tags', $tag);
                        }
                    });
                }
            })
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
            
        // If no related posts found, get recent posts instead
        if ($relatedBlogs->count() === 0) {
            $relatedBlogs = Blog::published()
                ->where('id', '!=', $blog->id)
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get();
        }
            
        return view('blogs.show', compact('blog', 'relatedBlogs'));
    }
}