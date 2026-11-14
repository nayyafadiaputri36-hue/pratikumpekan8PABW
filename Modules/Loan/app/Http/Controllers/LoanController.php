<?php
namespace Modules\Loan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Loan\Http\Requests\LoanRequest;
use Modules\Loan\Models\Loan;

class LoanController extends Controller
{
    public function index() { return view('loan::index'); }

    public function list() { return response()->json(Loan::latest()->get()); }

    public function store(LoanRequest $request)
    {
        $data = $request->safe()->except('bukti');
        if ($request->hasFile('bukti')) {
            $data['path'] = $request->file('bukti')->store('bukti', 'public');
        }
        $loan = Loan::create($data);
        return response()->json(['message' => 'Peminjaman berhasil ditambahkan.', 'data' => $loan], 201);
    }

    public function show(Loan $loan) { return response()->json($loan); }

    public function update(LoanRequest $request, Loan $loan)
    {
        $data = $request->safe()->except('bukti');
        if ($request->hasFile('bukti')) {
            if ($loan->path) Storage::disk('public')->delete($loan->path); // ganti file lama
            $data['path'] = $request->file('bukti')->store('bukti', 'public');
        }
        $loan->update($data);
        return response()->json(['message' => 'Peminjaman berhasil diperbarui.', 'data' => $loan->fresh()]);
    }

    public function destroy(Loan $loan)
    {
        if ($loan->path) Storage::disk('public')->delete($loan->path); // ikut terhapus dari storage
        $loan->delete();
        return response()->json(['message' => 'Peminjaman berhasil dihapus.']);
    }
}
