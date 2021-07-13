<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
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
    public function booksName(){
        $books = Book::all('name');
        if(empty($books)){
            $success = false;
            $message = 'Lista de livros vazia';

        }else{
            $success = true;
            $message = $books;
        }
        $response = [
            'success' => $success,
            'message' => $message,

        ];
        return response()->json($response, 200);

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
        // verificar se existe uma reserva associada
        $list_Reservations = $this->listReservations($id);
        if(empty($list_Reservations)){
            try {
                //code...
                //$book->reservationsBook()->delete();
                //$user = $book->user();
                //$user->reservations()->delete();
                $book->delete();
                //$reservation = Reservation::find($id);
                ///$reservation->delete();
                $response = [
                    'success' => true,
                    'message' => 'Livro removido com sucesso',

                ];
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json($th->getMessage(), 500);
            }
        }else{
            $response = [
                'success' => false,
                'message' => 'Este livro ainda possui reservas',

            ];
            return response()->json($response, 200);
        }



    }

    private function listReservations($id){

        $dateToday = date_create();
        $book = Book::find($id);

        $list_reservation = array();

        foreach($book->reservationsBook as $reservation){

            $date_devolution = date_create($reservation->pivot->date_devolution);
            if($dateToday < $date_devolution){

                $item= ['name' => $reservation->name, 'date_reservation' => $reservation->pivot->date_reservation, 'date_devolution' => $reservation->pivot->date_devolution];
                array_push($list_reservation, $item);
            }
        }

        return $list_reservation;
    }

    public function reservations($id){

        $dateToday = date_create();
        $book = Book::find($id);

        $list_reservation = array();

        foreach($book->reservationsBook as $reservation){

            $date_devolution = date_create($reservation->pivot->date_devolution);
            if($dateToday < $date_devolution){

                $item= ['id' => $reservation->pivot->id,'name' => $reservation->name, 'date_reservation' => $reservation->pivot->date_reservation, 'date_devolution' => $reservation->pivot->date_devolution];
                array_push($list_reservation, $item);
            }
        }

        return response()->json($list_reservation, 200);
    }
    public function searchBook($search){

        $books = Book::all()->toArray();

        $findBooks = array();

        foreach($books as $book){

            if(preg_match("/{$search}/i", $book['name'])){

                array_push($findBooks, $book);

            }else if(preg_match("/{$search}/i", $book['author'])){

                array_push($findBooks, $book);

            }else if(preg_match("/{$search}/i", $book['description'])){

                array_push($findBooks, $book);
            }
        }
        if(empty($findBooks)){
            $success    = false;
            $message    = 'Nemhum livro foi encontrado';
            $table      = null;
        }else{
            $success    = true;
            $message    = 'Livros encontrados';
            $table      = $findBooks;
        }
        $response = [
            'success' => $success,
            'message' => $message,
            'table'   => $table
        ];
        return response()->json($response);
    }

}
