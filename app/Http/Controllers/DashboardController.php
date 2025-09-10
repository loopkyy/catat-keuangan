<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total pemasukan
        $pemasukan = Transaction::where('type', 'income')->sum('amount');

        // Hitung total pengeluaran
        $pengeluaran = Transaction::where('type', 'expense')->sum('amount');

        // Hitung saldo
        $saldo = $pemasukan - $pengeluaran;

        return view('dashboard', compact('pemasukan', 'pengeluaran', 'saldo'));
    }
}
