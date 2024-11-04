<?php

namespace App\Http\Controllers;

use App\DTO\NewsDTO;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{

    public function index(Request $request)
    {
        $query = News::query();
        if ($request->has('name')) {
            $name = $request->input('name');
            $query->where('title', 'like', '%' . $name . '%');
        }

        $newsItems = $query->get();

        return response()->json($newsItems);
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $news = News::create($request->all());

        // Create a DTO and return it
        $newsDTO = new NewsDTO($news->title, $news->content);
        return response()->json($newsDTO, 201);
    }

    public function show($id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json(['message' => 'News not found'], 404);
        }

        $newsDTO = new NewsDTO($news->title, $news->content);
        return response()->json($newsDTO);
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $news = News::find($id);
        if (!$news) {
            return response()->json(['message' => 'News not found'], 404);
        }

        $news->update($request->only(['title', 'content']));

        $newsDTO = new NewsDTO($news->title, $news->content);
        return response()->json($newsDTO);
    }

    public function destroy($id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json(['message' => 'News not found'], 404);
        }

        $news->delete();

        return response()->json(['message' => 'News deleted successfully'], 200);
    }

}
