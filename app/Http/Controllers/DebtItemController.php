<?php

namespace App\Http\Controllers;

use App\Http\Requests\Debt\Create;
use App\Models\DebtItem;
use App\Models\User;
use Auth;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class DebtItemController extends Controller
{
    /**
     * @return Response
     */
    public function index() : Response
    {
        $user = Auth::user();
        $user->load('userDebt.creator');
        return Inertia::render('DebtManagement/Index', [
            'personal' => $user,
            'users' => User::where('id', '!=', Auth::id())->with('userDebt')->get(),
        ]);
    }

    /**
     * @param Create $request
     * @param int $id
     * @return RedirectResponse
     */
    public function create(Create $request, int $id) : RedirectResponse
    {
        $item = DebtItem::make($request->validated());
        $item->creator_id = Auth::id();
        $item->indebted_user = $id;
        $item->save();

        return Redirect::route('debt-management');
    }

    /**
     * @param int $id
     * @param string $deleteAll
     * @return RedirectResponse
     */
    public function delete(int $id, string $deleteAll) : RedirectResponse
    {
        $deleteAll = $deleteAll === 'false' ? false : true;

        $items = [];
        if ($deleteAll) {
            $items = DebtItem::whereCreatorId(Auth::id())
                ->where('indebted_user', $id)
                ->get();
        }else {
            $item = DebtItem::find($id);
            if ($item !== null && $item->creator_id === Auth::id()) {
                $items[] = $item;
            }
        }

        try {
            foreach ($items as $item) {
                $item->delete();
            }
        } catch (Exception $e) {
            return Redirect::route('debt-management')->with('error', $e->getMessage());
        }

        return Redirect::route('debt-management');
    }

}
