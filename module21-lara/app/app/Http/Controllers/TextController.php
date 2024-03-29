<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TelegraphText;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class TextController extends Controller
{
    public function listText(): Response
    {
        $texts = TelegraphText::all();
        $view = view('show-text')->with(['texts' => $texts]);
        return new Response($view);
    }

    public function addText(Request $request): RedirectResponse
    {
        $text = $request->get('text');
        $title = $request->get('title');
        $author = $request->get('author');

        $telegraphText = new TelegraphText();
        $telegraphText->text = $text;
        $telegraphText->title = $title;
        $telegraphText->author = $author;

        $telegraphText->save();
        return redirect()->route('texts-show');
    }

    public function updateText(Request $request): RedirectResponse
    {

        $id = $request->get('id');
        $title = $request->get('title');
        $text = $request->get('text');
        $author = $request->get('author');

        $telegraphText = TelegraphText::find($id);
        $telegraphText->title = $title;
        $telegraphText->author = $author;
        $telegraphText->text = $text;

        $telegraphText->save();
        return redirect()->route('texts-show');
    }

    public function showAddTable(): Response
    {
        $view = view('create-text');
        return new Response($view);
    }

    public function showUpdateTable($id): Response
    {
        $telegraphText = TelegraphText::find($id);
        $view = view('create-text')->with(['telegraphText' => $telegraphText]);;
        return new Response($view);
    }

    public function deleteText($id): Response
    {
        TelegraphText::where('id', '=', $id)->delete();
        $view = view('delete-text')->with(['id' => $id]);
        return new Response($view);
    }
}
