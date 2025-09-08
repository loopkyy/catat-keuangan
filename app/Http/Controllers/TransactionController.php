<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Source;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi dengan paginate
        $transactions = Transaction::with(['category','source'])
            ->orderBy('date', 'desc')
            ->paginate(10);

        // Pemasukan saja
        $transactionsIncome = Transaction::with(['category','source'])
            ->where('type', 'income')
            ->orderBy('date', 'desc')
            ->paginate(10, ['*'], 'income_page');

        // Pengeluaran saja
        $transactionsExpense = Transaction::with(['category','source'])
            ->where('type', 'expense')
            ->orderBy('date', 'desc')
            ->paginate(10, ['*'], 'expense_page');

        // Hitung total
        $totalIncome = Transaction::where('type','income')->sum('amount');
        $totalExpense = Transaction::where('type','expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('transactions.index', compact(
            'transactions',
            'transactionsIncome',
            'transactionsExpense',
            'totalIncome',
            'totalExpense',
            'balance'
        ));
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
            'amount' => 'required',
            'date' => 'required|date',
        ], [
            'title.regex' => 'Judul hanya boleh berisi huruf.',
        ]);

        // Pastikan amount angka (hilangkan titik pemisah ribuan)
        $request['amount'] = str_replace('.', '', $request->amount);

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
            'amount' => 'required',
            'date' => 'required|date',
        ], [
            'title.regex' => 'Judul hanya boleh berisi huruf.',
        ]);

        // Pastikan amount angka (hilangkan titik pemisah ribuan)
        $request['amount'] = str_replace('.', '', $request->amount);

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
public function exportPdf(Request $request)
{
    $type = $request->query('type');   // contoh: ?type=income
    $range = $request->query('range'); // contoh: ?range=monthly

    $today = Carbon::today();
    if ($range === 'today') {
        $start = $today;
        $end = $today->copy()->endOfDay();
    } elseif ($range === 'weekly') {
        $start = $today->copy()->startOfWeek();
        $end = $today->copy()->endOfWeek();
    } elseif ($range === 'monthly') {
        $start = $today->copy()->startOfMonth();
        $end = $today->copy()->endOfMonth();
    } else {
        $start = null;
        $end = null;
    }

    $query = Transaction::query();

    if ($start && $end) {
        $query->whereBetween('date', [$start, $end]);
    }

    if ($type === 'income') {
        $query->where('type', 'income');
    } elseif ($type === 'expense') {
        $query->where('type', 'expense');
    }

    $transactions = $query->orderBy('date', 'desc')->get();
    $total = $transactions->sum('amount');

    $pdf = Pdf::loadView('transactions.export', [
        'transactions' => $transactions,
        'type' => $type,
        'range' => $range,
        'total' => $total,
        'start' => $start,
        'end' => $end,
    ]);

    $filename = "laporan-{$type}-{$range}.pdf";
    return $pdf->download($filename);
}

}
