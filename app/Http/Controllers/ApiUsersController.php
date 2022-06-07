<?php

namespace App\Http\Controllers;

use App\Models\ApiUser;
use Illuminate\Http\Request;

class ApiUsersController extends Controller
{
    public function search(Request $request)
    {
        $searchParam = $request->searchInput;


        $results = ApiUser::where(strtolower('givenName'), 'like', $searchParam . '%')
            ->orWhere(strtolower('familyName'), 'like', $searchParam . '%')
            ->orderBy('id')
            ->get();

        return response()->json($results);
    }
}
