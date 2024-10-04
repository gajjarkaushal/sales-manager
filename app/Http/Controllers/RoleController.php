<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    // Display all roles
    public function index()
    {
        return Inertia::render('Role/Index', [
            'roles' => Role::all(),
        ]);        
    }

    // Store a new role
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles',
        ]);

        return Role::create($request->all());
    }

    // Show a single role
    public function show($id)
    {
        return Role::findOrFail($id);
    }

    // Update a role
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());

        return $role;
    }

    // Delete a role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }
}
