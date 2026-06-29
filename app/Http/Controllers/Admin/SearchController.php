<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));

        $users = collect();
        $roles = collect();

        if ($q !== '') {
            $users = User::with('roles')
                ->where('name', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
                ->orWhereHas('roles', function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%");
                })
                ->latest()
                ->get();

            $roles = Role::query()
                ->where('name', 'like', "%{$q}%")
                ->latest()
                ->get();
        }

        return view('admin.search.index', compact('q', 'users', 'roles'));
    }
}