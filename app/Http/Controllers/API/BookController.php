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

    public function edit($id){

        $book = Book::find($id);
        return response()->json($book);


    }

    public function update($id, Request $request){

        $book = Book::find($id);
        $book->update($request->all());
        return response()->json("Livro editado com sucesso");


    }

    public function delete($id){
        $book = Book::find($id);
        $book->delete();
        return response()->json('Livro removido com sucesso');


    }
    public function reservations($id){
        $book = Book::find($id);

        $list_reservation = array();

        foreach($book->reservationsBook as $reservation){

            $item= array('name' => $reservation->name, 'date_reservation' => $reservation->pivot->date_reservation, 'date_devolution' => $reservation->pivot->date_devolution);

            array_push($list_reservation, $item);
        }
        
        return response()->json($list_reservation);

    }

}
