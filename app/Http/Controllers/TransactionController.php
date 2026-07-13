<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private const CAT_COLORS = [
        '#B98B4E', '#33613F', '#9C3B2B', '#7A6A3F',
        '#5A7A6B', '#8C5A3C', '#4E6A8C', '#6B5A8C',
    ];

    public function index(Request $request)
    {
        $filter = $request->query('filter', 'semua');

        // Totals
        $masuk  = Transaction::where('type', 'masuk')->sum('amount');
        $keluar = Transaction::where('type', 'keluar')->sum('amount');
        $saldo  = $masuk - $keluar;

        // Category breakdown (top 5 pengeluaran)
        $catBreak = Transaction::where('type', 'keluar')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(function ($item, $index) {
                return [
                    'cat'   => $item->category,
                    'amt'   => $item->total,
                    'color' => self::CAT_COLORS[$index % count(self::CAT_COLORS)],
                ];
            });

        $maxCat = $catBreak->isNotEmpty() ? $catBreak->first()['amt'] : 1;

        // Transactions list with filter
        $query = Transaction::orderBy('date', 'desc')->orderBy('id', 'desc');
        if ($filter !== 'semua') {
            $query->where('type', $filter);
        }
        $transactions = $query->get();

        return view('transactions.index', compact(
            'transactions', 'masuk', 'keluar', 'saldo',
            'catBreak', 'maxCat', 'filter'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'        => 'required|in:masuk,keluar',
            'date'        => 'required|date',
            'category'    => 'required|string|max:60',
            'description' => 'nullable|string|max:60',
            'amount'      => 'required|numeric|min:1',
        ]);

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('stamped', true);
    }

    public function destroy(int $id)
    {
        Transaction::findOrFail($id)->delete();

        return redirect()->back()
            ->with('filter', request()->query('filter', 'semua'));
    }
}
