<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createCategory(Request $request){
        $request->validate([
         'name' => 'required|unique:categories',
         'descrition' => 'nullable'
        
        ]);
        $category = category::create($request->all());
        return response()->json([
          'status' => 'succes',
          'data' => $category
        ],201);
    }

    public function index(){
        // ASC : ngurutin dari A-z
        // DESC : ngurutin dari Z-A
        $categories = category::orderBy('name', 'ASC',)->get();
        return response()->json([
            'status' => 'Berhasil amnil data kategori',
            'data' => $categories
        ]);
    }

    public function updateCategory(Request $request,$id){
        $request->validate([
         'name' => 'required|unique:categories',
         'descrition' => 'nullable'
        
        ]);
        $category =category::findOrFail($id);
        if(!$category){
            return response()->json([
             'status'=> 'Error',
             'message'=> 'Kategori tidak di temukan'
            ],404);
        }
        $category->update($request->all());
        return response()->json([
            'status'=> 'succes',
            'data' => $category
        ],200);
    }

    public function deleteCategory($id){
        $category =category::findOrFail($id);
        if(!$category){
            return response()->json([
             'status'=> 'Error',
             'message'=> 'Kategori tidak di temukan'
            ],404);
        }
        $category->delete();
        return response()->json([
            'status'=> 'succes',
            'message' => 'kategori berhasil di hapus'
        ],200);
    }
}