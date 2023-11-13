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
     *
     * @OA\Get(
     *     path="/api/users-notes/",
     *     description="Paginatable list of user notes",
     *     @OA\Response(response="200", description="Display a listing of the notes"),
     *     @OA\Response(response="204", description="No content"),
     *     @OA\Response(response="403", description="Not authorized."),
     *  )
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
     *
     * @OA\Post(
     *     path="/api/users-notes/{id}",
     *     description="Store a newly created resource in storage.",
     *     @OA\Response(response="201", description="New note was created."),
     *     @OA\Response(response="403", description="Not authorized."),
     * )
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
     *
     * @OA\Get(
     *     path="/api/users-notes/{id}",
     *     description="Display the specified note.",
     *     @OA\Response(response="200", description="Display the specified note."),
     *     @OA\Response(response="403", description="Not authorized."),
     *     @OA\Response(response="404", description="Not found."),
     *  )
     */
    public function show(UserNote $userNote)
    {
        return \response()->json($userNote);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/users-notes/",
     *     description="Update the specified resource in storage.",
     *     @OA\Response(response="200", description="Note was updated."),
     *     @OA\Response(response="403", description="Not authorized."),
     *     @OA\Response(response="404", description="Not found."),
     *     )
     *
     * @OA\Patch(
     *     path="/api/users-notes/{id}",
     *     description="Update the specified resource in storage.",
     *     @OA\Response(response="200", description="Note was updated."),
     *     @OA\Response(response="403", description="Not authorized."),
     *     @OA\Response(response="404", description="Not found."),
     *     )
     */
    public function update(UpdateUserNoteRequest $request, UserNote $userNote)
    {
        return \response()->json(
            $userNote->update($request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *      path="/api/users-notes/{id}",
     *      description="Remove the specified note from storage.",
     *      @OA\Response(response="200", description="Note was deleted."),
     *      @OA\Response(response="403", description="Not authorized."),
     *      @OA\Response(response="404", description="Not found."),
     *  )
     */
    public function destroy(UserNote $userNote)
    {
        $userNote->delete();

        return \response(null);
    }
}
