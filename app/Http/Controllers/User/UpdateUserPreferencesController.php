<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UpdateUserPreferencesRequest;
use App\Http\Resources\UserResource;

class UpdateUserPreferencesController
{
    public function __invoke(UpdateUserPreferencesRequest $request){
        $user = auth()->user();
        $data = $request->validated();
        $user->update([
            'preferred_categories' => $data['preferred_categories'] ?? null,
            'preferred_sources' => $data['preferred_sources'] ?? null,
            'preferred_authors' => $data['preferred_authors'] ?? null,
        ]);

        return response()->json(UserResource::make($user));
    }

}