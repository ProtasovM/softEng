<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\IndexUserNoteRequest;
use App\Http\Requests\StoreUserNoteRequest;
use App\Http\Requests\UpdateUserNoteRequest;
use App\Models\User;
use App\Models\UserNote;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserNoteController extends Controller
{
    /**
     * Создать экземпляр контроллера.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(UserNote::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexUserNoteRequest $request)
    {
        $builder = UserNote::query();

        if (
            Auth::user()->hasRole(Roles::Administrator->value) === false
        ) {
            $builder->where(
                'user_id',
                '=',
                Auth::user()->id
            );
        }

        $paginator = $builder->paginate(
            $request->per_page ?? 100,
            page: $request->page ?? 1
        );

        if ($paginator->total() === 0) {
            return \response(null, status: Response::HTTP_NO_CONTENT);
        }

        return \response()->json(
            [
                'items' => $paginator->items(),
                'page' => $paginator->currentPage(),
                'total' => $paginator->total(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserNoteRequest $request)
    {
        return \response()->json(
            Auth::user()->notes()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(UserNote $userNote)
    {
        return \response()->json($userNote);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserNoteRequest $request, UserNote $userNote)
    {
        return \response()->json(
            $userNote->update($request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserNote $userNote)
    {
        $userNote->delete();

        return \response(null);
    }
}
