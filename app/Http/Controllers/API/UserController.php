<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //
    public function register(Request $request){
        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $success = true;
            $message = 'Usuario registrado com sucesso';
            $response = [
                'success' => $success,
                'message' => $message,
            ];
            return response()->json($response, 200);
        } catch(QueryException $error){
            $success = false;
            $message = $error;

        }
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response, 200);

    }

    public function login(Request $request){


        $response = [];
        $dados = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($dados)){
            $response = [
                'user'    => Auth::user()->name,
                'userId'  => Auth::user()->id,
                'success' => true,
                'message' => "Usuario logado com sucesso"
            ];
            return response()->json($response, 200);
        }else{

            $success = false;
            $message = 'email ou login inválidos';
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response, 400);

    }

    public function logout(){

        $response = [];
        try{
            Session::flush();
            $success = true;
            $message = 'Usuario deslogado com sucesso';
            $response = [
                'success' => $success,
                'message' => $message,
            ];
            return response()->json($response, 200);
        } catch(QueryException $error){
            $success = false;
            $message = $error->getMessage();
            $response = [
                'success' => $success,
                'message' => $message,
            ];
            return response()->json($response, 500);
        }

    }
    public function update(Request $request){

        try {
            $user = User::find(Auth::user()->id);
            $user->update(['name' => $request->name, 'password' => Hash::make( $request->password)]);
            $this->logout();

            $response = [
                'success' => true,
                'message' => "Usuario atualizado com sucesso",
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {

            $response = [
                'success' => false,
                'message' => $th->getMessage(),
            ];
            return response()->json($response, 500);
        }


    }
    public function userbooks($id){

        $user = User::find($id);
        $list_books = array();

        foreach($user->books as $book){
            $item = ['id' => $book->id, 'name' => $book->name, 'author' => $book->author, 'description' => $book->description];
            array_push($list_books, $item);

        }
        return response()->json($list_books, 200);

    }
    public function userReservations($id){

        $dateToday = date_create();

        $user = User::find($id);
        $list_reservations = array();

        foreach($user->reservations as $reservation){

            $date_devolution = date_create($reservation->pivot->date_devolution);

            if($dateToday < $date_devolution){

                $item = ['id' => $reservation->pivot->id , 'name' => $reservation->name, 'date_reservation' => $reservation->pivot->date_reservation, 'date_devolution' => $reservation->pivot->date_devolution];
                array_push($list_reservations, $item);

            }

        }
        return response()->json($list_reservations, 200);
    }
    private function userListReservation($id){
        $dateToday = date_create();

        $user = User::find($id);
        $list_reservations = array();
        foreach($user->reservations as $reservation){

            $date_devolution = date_create($reservation->pivot->date_devolution);
            if($dateToday < $date_devolution){

                array_push($list_reservations, $reservation->id);

            }
        }
        return $list_reservations;
    }
    public function availableBooks($id){
        $books = Book::all()->toArray();

        $books_available = $books;
        $list_books_reservation = $this->userListReservation($id);
        foreach( $list_books_reservation as $book_id){
           foreach($books as $book){
              if($book['id'] === $book_id){
                $key = array_search($book, $books_available);
                unset($books_available[$key]);
              }
           }
        }
        return response()->json($books_available, 200);

    }
    private function listBooksReservation($id){
        $dateToday = date_create();

        $user = User::find($id);
        $list_reservations = array();
        foreach($user->reservations as $reservation){

            $date_devolution = date_create($reservation->pivot->date_devolution);
            if($dateToday < $date_devolution){
                $item = ['date_reservation' => $reservation->pivot->date_reservation, 'date_devolution' => $reservation->pivot->date_devolution];
                array_push($list_reservations, $item);

            }
        }
        return $list_reservations;
    }
    public function validateReservation(Request $request){

        $list_books_reservations = $this->listBooksReservation($request->fk_user_reservation);
        $dateR = date_create($request->date_reservation);
        $dateD = date_create($request->date_devolution);
        $validate = true;
        foreach($list_books_reservations as $reservation){
            $date_devolution = date_create($reservation['date_devolution']);
            $date_reservation = date_create($reservation['date_reservation']);
            if($dateR < $date_devolution){
                if($dateD > $date_reservation){
                    $validate = false;
                }
            }
        }
        if($validate){
            $reservation = new Reservation([
                'fk_user_reservation' => $request->fk_user_reservation,
                'fk_book_reservation' => $request->fk_book_reservation,
                'date_reservation' => $request->date_reservation,
                'date_devolution' => $request->date_devolution,

            ]);
            $reservation->save();
            $success = true;
            $message = 'Reserva realizada com sucesso';

        }else{
            $success = false;
            $message = 'Não é possivel reservar mais de um livro para mesma data';

        }
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);


    }
}
