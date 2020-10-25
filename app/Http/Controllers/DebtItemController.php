<?php

namespace App\Http\Controllers;

use App\Models\DebtItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class DebtItemController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('DebtManagement/Index', [
            'items' => DebtItem::all()
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request) : RedirectResponse
    {

        return Redirect::route('debt-management');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id) : RedirectResponse
    {
        //todo: make sure you can only delete an item that is yours
        return Redirect::route('debt-management');
    }

}
