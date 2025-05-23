<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller; // Tambahkan baris ini

class MemberController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $members = User::where('role', 'member')->withTrashed()->get();
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'member_id' => 'required|string|unique:users,member_id',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'member_id' => $request->member_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'role' => 'member',
        ]);

        return redirect()->route('admin.members.index')->with('success', 'Member created successfully.');
    }

    public function edit(User $member)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        if ($member->role !== 'member') {
            abort(403, 'Cannot edit non-member user.');
        }
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, User $member)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        if ($member->role !== 'member') {
            abort(403, 'Cannot edit non-member user.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'member_id' => 'required|string|unique:users,member_id,' . $member->id,
            'email' => 'required|email|unique:users,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name' => $request->name,
            'member_id' => $request->member_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $member->update($data);
        return redirect()->route('admin.members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy(User $member)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        if ($member->role !== 'member') {
            abort(403, 'Cannot delete non-member user.');
        }
        $member->delete();
        return redirect()->route('admin.members.index')->with('success', 'Member soft deleted successfully.');
    }

    public function restore($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $member = User::withTrashed()->findOrFail($id);
        if ($member->role !== 'member') {
            abort(403, 'Cannot restore non-member user.');
        }
        $member->restore();
        return redirect()->route('admin.members.index')->with('success', 'Member restored successfully.');
    }

    public function forceDelete($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $member = User::withTrashed()->findOrFail($id);
        if ($member->role !== 'member') {
            abort(403, 'Cannot permanently delete non-member user.');
        }
        $member->forceDelete();
        return redirect()->route('admin.members.index')->with('success', 'Member permanently deleted successfully.');
    }
}