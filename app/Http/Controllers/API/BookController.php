<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;


class BookController extends Controller
{
    //
    public function index(){

        $books = Book::all()->toArray();
        return array($books);

    }
    

    public function lastadd(){
        $books = Book::all()->sortByDesc('id');
        $reverse = $books->values()->take(5);
        return $reverse;
    }
    public function add(Request $request){
        $book = new Book([
            'name' => $request->name,
            'author' => $request->author,
            'description' => $request->description,
            'fk_users' => $request->user_id
        ]);
        $book->save();
        return response()->json('O livro foi adcionado com sucesso');

    }

    public function edit($id, Request $request){

        $book = Book::find($id);
        if($request->user_id == $book->fk_users){
            return response()->json($book);
        }
        return response()->json('O livro não pode ser editado por esse usuario');
    }

    public function update($id, Request $request){

        $book = Book::find($id);
        if($request->user_id == $book->fk_users){
            $book->update($request->all());
            return response()->json("Livro editado com sucesso");
        }


    }

    public function delete($id, Request $request){
        $book = Book::find($id);
        if($request->user_id == $book->fk_users){
            $book->delete();
            return response()->json('Livro removido com sucesso');
        }
        return response()->json('Livro não pode ser removido por usuario');
    }

}
