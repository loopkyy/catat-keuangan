<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Source;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

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

        // Hitung total global
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

private function filterTransactions($type, $range)
{
    $today = Carbon::today();

    if ($range === 'today') {
        $start = $today->copy()->startOfDay();
        $end   = $today->copy()->endOfDay();
    } elseif ($range === 'weekly') {
        $start = $today->copy()->startOfWeek();
        $end   = $today->copy()->endOfWeek();
    } elseif ($range === 'monthly') {
        $start = $today->copy()->startOfMonth();
        $end   = $today->copy()->endOfMonth();
    } else {
        $start = null;
        $end   = null;
    }

    $query = Transaction::with(['category','source']);

    if ($start && $end) {
        $query->whereBetween('date', [$start, $end]);
    }

    if ($type !== 'all') {
        $query->where('type', $type);
    }

    $transactions = $query->orderBy('date','desc')->get();

    // Total di periode
    $totalIncome  = $transactions->where('type','income')->sum('amount');
    $totalExpense = $transactions->where('type','expense')->sum('amount');

    // Saldo awal (sebelum periode)
    if ($start) {
        $incomeBefore  = Transaction::where('type','income')
                        ->where('date', '<', $start)->sum('amount');
        $expenseBefore = Transaction::where('type','expense')
                        ->where('date', '<', $start)->sum('amount');
        $saldoAwal = $incomeBefore - $expenseBefore;
    } else {
        $saldoAwal = 0;
    }

    // Saldo akhir (sampai akhir periode)
    if ($end) {
        $incomeUntil  = Transaction::where('type','income')
                        ->where('date', '<=', $end)->sum('amount');
        $expenseUntil = Transaction::where('type','expense')
                        ->where('date', '<=', $end)->sum('amount');
        $saldoAkhir = $incomeUntil - $expenseUntil;
    } else {
        $incomeAll  = Transaction::where('type','income')->sum('amount');
        $expenseAll = Transaction::where('type','expense')->sum('amount');
        $saldoAkhir = $incomeAll - $expenseAll;
    }

    return [
        $transactions, 
        $totalIncome, 
        $totalExpense, 
        $saldoAwal, 
        $saldoAkhir, 
        $start, 
        $end
    ];
}

public function exportPdf($type, $range)
{
    [
        $transactions,
        $totalIncome,
        $totalExpense,
        $saldoAwal,
        $saldoAkhir,
        $start,
        $end
    ] = $this->filterTransactions($type, $range);

    $pdf = Pdf::loadView('transactions.export', [
        'transactions' => $transactions,
        'type' => $type,
        'range' => $range,
        'totalIncome' => $totalIncome,
        'totalExpense' => $totalExpense,
        'saldoAwal' => $saldoAwal,
        'saldoAkhir' => $saldoAkhir,
        'start' => $start,
        'end' => $end,
    ]);

    $filename = "laporan-{$type}-{$range}.pdf";
    return $pdf->download($filename);
}

public function exportExcel($type, $range)
{
    [
        $transactions,
        $totalIncome,
        $totalExpense,
        $saldoAwal,
        $saldoAkhir,
        $start,
        $end
    ] = $this->filterTransactions($type, $range);

    return Excel::download(
        new TransactionsExport(
            $transactions,
            $totalIncome,
            $totalExpense,
            $saldoAwal,
            $saldoAkhir,
            $type
        ),
        "laporan-{$type}-{$range}.xlsx"
    );
}

}
