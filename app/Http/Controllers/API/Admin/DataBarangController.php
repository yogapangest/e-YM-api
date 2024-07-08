<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use App\Models\DataBarang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataBarangController extends Controller
{
    public function index()
    {
        try {
            $databarangs = DataBarang::all();
            $url = '/admin/databarang';

            return response()->json([
                'status' => 'succes',
                'message' => 'Get data databarang successfull',
                'databarang' => $databarangs,
                'url' => $url,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get databarang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_barang' => 'required|string|max:255',
                'volume' => 'required|string',
                'satuan' => 'required|string',
                'harga_satuan' => 'required|string',
                'jumlah' => 'required|string',
            ]);
    
            $databarangs = DataBarang::create($validatedData);
            $url = '/admin/databarang';
    
            return response()->json([
                'status' => 'success',
                'message' => 'Add databarang successful',
                'databarang' => $databarangs,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add data barang',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function edit($id)
    {
        try {
            $databarangs = DataBarang::findOrFail($id);

            $url = sprintf('/admin/databarang/edit/%d', $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Get data barang successful',
                'databarang' => $databarangs,
                'url' => $url,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get data barang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $databarangs = DataBarang::findOrFail($id);

            $validatedData = $request->validate([
                'nama_barang' => 'required|string|max:255',
                'volume' => 'required|string',
                'satuan' => 'required|string',
                'harga_satuan' => 'required|string',
                'jumlah' => 'required|string',
            ]);
            
            $databarangs->update($validatedData);
            $url = '/admin/databarang';

            return response()->json([
                'status' => 'success',
                'message' => 'Update data barang successful',
                'databarang' => $databarangs,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update data barang',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $databarangs = DataBarang::findOrFail($id);

            $databarangs->delete();
            $url = '/admin/databarang';
            
            return response()->json([
                'status' => 'seccess',
                'message' => 'Data barang has been removed',
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove data barang',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}