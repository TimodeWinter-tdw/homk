<?php

namespace App\Http\Controllers;

use App\Models\Shopping;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class ShoppingController extends Controller
{
    /**
     *  Returns a list of all the shopping list items
     */
    public function index()
    {
        return Inertia::render('Shopping/Index', [
            'items' => Shopping::all()
        ]);
    }

    /**
     * Create a new shopping list item
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request) : RedirectResponse
    {
        $request->validate([
            'product' => ['string', 'max:255', 'required'],
            'description' => ['string', 'required']
        ]);

        $item = Shopping::make($request->only(['product', 'description']));
        $item->user_id = Auth::id();
        $item->save();

        return Redirect::route('shopping');
    }

    /**
     * @param int $item
     * @return RedirectResponse
     */
    public function delete(int $item) : RedirectResponse
    {
        try {
            $item = Shopping::find($item);
            $item->delete();
        } catch (\Exception $e) {
            // Share a flash message
            Inertia::share('flash', function () use ($e) {
                return [
                    'message' => $e->getMessage()
                ];
            });
        }

        return Redirect::route('shopping');
    }
}
