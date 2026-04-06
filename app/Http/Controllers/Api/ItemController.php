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
        try {
            $data = $request->validate([
                'kode' => 'required|unique:items,kode',
                'nama' => 'required',
                'kategori' => 'nullable',
                'ruangan' => 'nullable',
                'satuan' => 'nullable',
                'stok' => 'required|integer',
                'stok_minimum' => 'required|integer',
                'harga_beli' => 'nullable|numeric',
                'harga_jual' => 'nullable|numeric'
            ]);

            $data['harga_beli'] = $data['harga_beli'] ?? 0;
            $data['harga_jual'] = $data['harga_jual'] ?? 0;

            $item = Item::create($data);

            return response()->json([
                'message' => 'Item berhasil ditambahkan',
                'data' => $item
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error server',
                'error' => $e->getMessage()
            ], 500);
        }
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
        try {
            $item = Item::findOrFail($id);

            $data = $request->validate([
                'kode' => 'required',
                'nama' => 'required',
                'kategori' => 'nullable',
                'ruangan' => 'nullable',
                'satuan' => 'nullable',
                'stok' => 'required|integer',
                'stok_minimum' => 'required|integer',
                'harga_beli' => 'nullable|numeric',
                'harga_jual' => 'nullable|numeric'
            ]);

            $data['harga_beli'] = $data['harga_beli'] ?? 0;
            $data['harga_jual'] = $data['harga_jual'] ?? 0;

            $item->update($data);

            return response()->json([
                'message' => 'Item berhasil diupdate',
                'data' => $item
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error server',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}