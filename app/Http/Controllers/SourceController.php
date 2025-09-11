<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index()
    {
        $sources = Source::paginate(10);

        return view('sources.index', compact('sources'));
    }
    

    public function create()
    {
        return view('sources.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z\s]+$/'
            ],
        ], [
            'name.regex' => 'Nama sumber hanya boleh huruf dan spasi.'
        ]);

        // format huruf pertama kapital
        $name = ucfirst(strtolower($request->name));

        Source::create([
            'name' => $name,
        ]);

        return redirect()->route('sources.index')->with('success', 'Sumber pemasukan berhasil ditambahkan');
    }

    public function edit(Source $source)
    {
        return view('sources.edit', compact('source'));
    }

    public function update(Request $request, Source $source)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z\s]+$/'
            ],
        ], [
            'name.regex' => 'Nama sumber hanya boleh huruf dan spasi.'
        ]);

        // format huruf pertama kapital
        $name = ucfirst(strtolower($request->name));

        $source->update([
            'name' => $name,
        ]);

        return redirect()->route('sources.index')->with('success', 'Sumber pemasukan berhasil diupdate');
    }

    public function destroy(Source $source)
    {
        $source->delete();
        return redirect()->route('sources.index')->with('success', 'Sumber pemasukan berhasil dihapus');
    }
}
