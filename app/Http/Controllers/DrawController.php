<?php

namespace App\Http\Controllers;

use App\Models\Practise;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DrawController extends Controller
{
    public function show(Practise $practise): View|RedirectResponse
    {
        $draw = $practise->draw()->with('drawer')->first();

        if (! $draw) {
            return redirect()->route('home')->with('error-message', 'Für dieses Training gibt es noch keine Auslosung.');
        }

        return view('draw.show', [
            'practise' => $practise,
            'draw' => $draw,
            'teams' => $draw->teams(),
        ]);
    }
}
