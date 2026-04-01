<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return response()->json(Item::all());
    }

    public function store(Request $request)
    {
        $item = Item::create($request->all());
        return response()->json($item);
    }

    public function destroy($id)
    {
    $item = Item::find($id);
        if (!$item) {
            return response()->json([
                'message' => 'Item tidak ditemukan'
            ], 404);
        }
    $item->delete();
        return response()->json([
            'message' => 'Item berhasil dihapus'
        ]);
    }

    public function update(Request $request, $id)
{
    $item = Item::findOrFail($id);

    $data = $request->validate([
        'kode' => 'required',
        'nama' => 'required',
        'kategori' => 'nullable',
        'ruangan' => 'nullable',
        'stok' => 'required|integer',
        'stok_minimum' => 'required|integer',
        'satuan' => 'nullable'
    ]);

    $item->update($data);

    return response()->json([
        'message' => 'Item berhasil diupdate',
        'data' => $item
    ]);
}
}