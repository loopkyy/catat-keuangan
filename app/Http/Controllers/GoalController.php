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
        'name' => ['required','regex:/^[A-Za-z\s]+$/','max:255'],
        'target_amount' => 'required',
        'start_date' => 'nullable|date'
    ]);

    $data = $request->all();
    $data['name'] = ucwords(strtolower($data['name']));
    $data['target_amount'] = (int) str_replace(['Rp','.',',',' '],'',$request->target_amount);

    Goal::create($data);

    return redirect()->route('goals.index')->with('success','Tujuan tabungan berhasil ditambahkan');
}
    public function edit(Goal $goal)
    {
        return view('goals.edit', compact('goal'));
    }

   public function update(Request $request, Goal $goal)
{
    $request->validate([
        'name' => ['required','regex:/^[A-Za-z\s]+$/','max:255'],
        'target_amount' => 'required',
        'saved_amount' => 'required',
        'start_date' => 'nullable|date'
    ]);

    $data = $request->all();
    $data['name'] = ucwords(strtolower($data['name']));
    $data['target_amount'] = (int) str_replace(['Rp','.',',',' '],'',$request->target_amount);
    $data['saved_amount'] = (int) str_replace(['Rp','.',',',' '],'',$request->saved_amount);

    $goal->update($data);

    return redirect()->route('goals.index')->with('success','Tujuan tabungan berhasil diupdate');
}

    public function destroy(Goal $goal)
    {
        $goal->delete();
        return redirect()->route('goals.index')->with('success','Tujuan tabungan berhasil dihapus');
    }
}
