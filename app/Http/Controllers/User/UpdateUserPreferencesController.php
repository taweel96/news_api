<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UpdateUserPreferencesRequest;
use App\Http\Resources\UserResource;
use App\Support\ApiResponse;

class UpdateUserPreferencesController
{
    public function __invoke(UpdateUserPreferencesRequest $request){
        $user = auth()->user();
        $data = $request->validated();

        $user->authors()->sync($data['preferred_authors'] ?? []);
        $user->categories()->sync($data['preferred_categories'] ?? []);

        $user->newsSourceRecords()->delete();
        foreach ($data['preferred_sources'] as $newsSource) {
            $user->attachNewsSource($newsSource);
        }
        return ApiResponse::success(UserResource::make($user));
    }

}