<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['category','source'])
            ->orderBy('date', 'desc')
            ->get();

        $totalIncome = Transaction::where('type','income')->sum('amount');
        $totalExpense = Transaction::where('type','expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('transactions.index', compact('transactions','totalIncome','totalExpense','balance'));
    }

    public function create()
    {
        $categories = Category::all();
        $sources = Source::all();
        return view('transactions.create', compact('categories','sources'));
    }

public function store(Request $request)
{
    $request->validate([
        'title' => [
            'required',
            'string',
            'max:255',
            'regex:/^[A-Za-z\s]+$/'
        ],
        'type' => 'required|in:income,expense',
        'amount' => 'required|numeric|min:1',
        'date' => 'required|date',
    ], [
        'title.regex' => 'Judul hanya boleh berisi huruf.',
    ]);

    Transaction::create($request->all());

    return redirect()->route('transactions.index')
        ->with('success','Transaksi berhasil dicatat');
}


    public function edit(Transaction $transaction)
    {
        $categories = Category::all();
        $sources = Source::all();
        return view('transactions.edit', compact('transaction','categories','sources'));
    }

   public function update(Request $request, Transaction $transaction)
{
    $request->validate([
        'title' => [
            'required',
            'string',
            'max:255',
            'regex:/^[A-Za-z\s]+$/'
        ],
        'type' => 'required|in:income,expense',
        'amount' => 'required|numeric|min:1',
        'date' => 'required|date',
    ], [
        'title.regex' => 'Judul hanya boleh berisi huruf.',
    ]);

    $transaction->update($request->all());

    return redirect()->route('transactions.index')
        ->with('success','Transaksi berhasil diupdate');
}
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')
            ->with('success','Transaksi berhasil dihapus');
    }
}
