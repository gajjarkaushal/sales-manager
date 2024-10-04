<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleApiController extends Controller
{
    // Display a listing of the resource, with search functionality
    public function index(Request $request)
    {
        $query = Role::query();

        // If the request contains a search parameter, filter by role name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Get all roles or filtered roles
        $roles = $query->get();

        return response()->json($roles, 200);
    }

    // Store a newly created role in storage (Create Role)
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'slug' => 'required|string|max:255|unique:roles,slug',
        ]);

        // Create a new role
        $role = Role::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
        ]);

        return response()->json($role, 201);  // 201 for resource created
    }

    // Display the specified role (Read)
    public function show($id)
    {
        // Find role by ID
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        return response()->json($role, 200);
    }

    // Update the specified role in storage (Edit Role)
    public function update(Request $request, $id)
    {
        // Find role by ID
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'slug' => 'required|string|max:255|unique:roles,slug,' . $id,
        ]);

        // Update the role
        $role->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
        ]);

        return response()->json($role, 200);
    }

    // Remove the specified role from storage (Delete Role)
    public function destroy($id)
    {
        // Find role by ID
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        // Delete the role
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully'], 200);
    }
}
