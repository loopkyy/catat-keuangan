<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::all();
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'start_date' => 'nullable|date'
        ]);

        Goal::create($request->all());

        return redirect()->route('goals.index')->with('success','Tujuan tabungan berhasil ditambahkan');
    }

    public function edit(Goal $goal)
    {
        return view('goals.edit', compact('goal'));
    }

    public function update(Request $request, Goal $goal)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'saved_amount' => 'required|numeric|min:0',
            'start_date' => 'nullable|date'
        ]);

        $goal->update($request->all());

        return redirect()->route('goals.index')->with('success','Tujuan tabungan berhasil diupdate');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();
        return redirect()->route('goals.index')->with('success','Tujuan tabungan berhasil dihapus');
    }
}
