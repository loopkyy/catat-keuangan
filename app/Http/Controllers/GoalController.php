<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    /**
     * Tampilkan semua tujuan tabungan
     */
public function index()
{
    $ongoingGoals = Goal::whereColumn('saved_amount', '<', 'target_amount')
        ->paginate(10, ['*'], 'ongoing_page');

    $completedGoals = Goal::whereColumn('saved_amount', '>=', 'target_amount')
        ->paginate(10, ['*'], 'completed_page');

    return view('goals.index', compact('ongoingGoals', 'completedGoals'));
}


    /**
     * Form tambah tujuan baru
     */
    public function create()
    {
        return view('goals.create');
    }

    /**
     * Simpan tujuan tabungan baru
     */
public function store(Request $request)
{

    $request->merge([
        'target_amount' => preg_replace('/[^\d]/', '', $request->target_amount)
    ]);

    $request->validate([
        'name'          => ['required','regex:/^[A-Za-z\s]+$/','max:255'],
        'target_amount' => 'required|numeric|min:1',
        'start_date'    => 'nullable|date'
    ]);

    $data = $request->only(['name','target_amount','start_date']);
    $data['name'] = ucwords(strtolower($data['name']));
    $data['saved_amount'] = 0;

    Goal::create($data);

    return redirect()->route('goals.index')->with('success','Tujuan tabungan berhasil ditambahkan');
}


    /**
     * Form edit tujuan
     */
    public function edit(Goal $goal)
    {
        return view('goals.edit', compact('goal'));
    }

    /**
     * Update tujuan tabungan
     */
    public function update(Request $request, Goal $goal)
    {
        $request->merge([
        'target_amount' => preg_replace('/[^\d]/', '', $request->target_amount),
        'saved_amount'  => preg_replace('/[^\d]/', '', $request->saved_amount)
    ]);
        $request->validate([
            'name'          => ['required','regex:/^[A-Za-z\s]+$/','max:255'],
            'target_amount' => 'required|numeric|min:1',
            'saved_amount'  => 'required|numeric|min:0',
            'start_date'    => 'nullable|date'
        ]);

        $data = $request->only(['name','target_amount','saved_amount','start_date']);
        $data['name'] = ucwords(strtolower($data['name']));
        $data['target_amount'] = (int) str_replace(['Rp','.',',',' '],'',$request->target_amount);
        $data['saved_amount']  = (int) str_replace(['Rp','.',',',' '],'',$request->saved_amount);

        $goal->update($data);

        return redirect()
            ->route('goals.index')
            ->with('success','Tujuan tabungan berhasil diupdate');
    }

    /**
     * Hapus tujuan tabungan
     */
    public function destroy(Goal $goal)
    {
        $goal->delete();

        return redirect()
            ->route('goals.index')
            ->with('success','Tujuan tabungan berhasil dihapus');
    }
}
