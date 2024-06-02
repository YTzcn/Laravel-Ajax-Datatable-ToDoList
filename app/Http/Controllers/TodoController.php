<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TodoController extends Controller
{
    public function list(Request $request)
    {

        $todos = Todo::all();
        $table = DataTables::make($todos)
            ->addColumn('Güncelle', function ($data) {
            return '<a class=\'btn btn-warning\' onclick="guncelle('.$data->id.')">Güncelle</a>';
        })
            ->addColumn('Sil', function ($data) {
            return '<a class=\'btn btn-danger\' onclick="sil('.$data->id.')">Sil</a>';
        })
            ->rawColumns(['Güncelle','Sil'])->make(true);
        return $table;

    }

    public function get($id)
    {
        $todo = Todo::find($id);
        return $todo;
    }

    public function add(Request $request)
    {
        Todo::create([
            'Title' => $request->Title,
            'Content' => $request->Content,
            'Status' => $request->Status,
        ]);
    }
    public function update(Request $request){
        $todo = Todo::find($request->id);
        $todo->Title = $request->Title;
        $todo->Content = $request->Content;
        $todo->Status = $request->Status;
        $todo->save();
    }
    public function delete(Request $request){
        $todo = Todo::find($request->id);
        $todo->delete();
    }
}
