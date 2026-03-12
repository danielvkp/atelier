<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class SitemapController extends Controller
{
  public function generateSitemap(){
    $posts = Blog::all();

    return response()->view('helpers.sitemap', [
      'items' => $posts
      ])->header('Content-Type', 'text/xml');
  }
}
