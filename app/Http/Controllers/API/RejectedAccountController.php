<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RejectedAccount;

class RejectedAccountController extends Controller
{
    // List rejected accounts with pagination and search by name
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');

        $query = RejectedAccount::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('middle_name', 'like', "%$search%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%$search%"]);
            });
        }
        $accounts = $query->paginate($perPage);
        return response()->json($accounts);
    }

    // Create a rejected account with validation and try-catch
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
                'status' => 'required|string',
                'type' => 'required|string',
                'first_name' => 'required|string',
                'middle_name' => 'nullable|string',
                'last_name' => 'required|string',
                'suffix' => 'nullable|string',
                'sex' => 'required|string',
                'nationality' => 'required|string',
                'birthday' => 'required|date',
                'contact_no' => 'required|string',
                'birth_place' => 'required|string',
                'municipality' => 'required|string',
                'barangay' => 'required|string',
                'house_no' => 'required|string',
                'zip_code' => 'required|string',
                'street' => 'required|string',
                'pwd_number' => 'nullable|string',
                'single_parent_number' => 'nullable|string',
                'profile_picture_path' => 'nullable|string',
                'reason' => 'nullable|string',
            ]);
            $rejected = RejectedAccount::create($validated);
            return response()->json(['message' => 'Rejected account created successfully', 'rejected_account' => $rejected], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
