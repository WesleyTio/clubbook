<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\TryCatch;
use SebastianBergmann\Environment\Console;

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

        } catch(QueryException $error){
            $success = false;
            $message = 'email já cadastrado';

        }

        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);

    }

    public function login(Request $request){


        $dados = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($dados)){
            $success = true;
            $message = 'Usuario logado com sucesso';
        }else{
            $success = false;
            $message = 'email ou login invalidos';
        }

        $response = [
            'user'    => Auth::user()->name,
            'userId'  => Auth::user()->id,
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);

    }

    public function logout(){

        try{
            Session::flush();
            $success = true;
            $message = 'Usuario deslogado com sucesso';
        } catch(QueryException $error){
            $success = false;
            $message = $error->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);

    }
    public function userbooks($id){

        $user = User::find($id);
        $list_books = array();

        foreach($user->books as $book){
            $item = array('id' => $book->id, 'name' => $book->name, 'author' => $book->author, 'description' => $book->description);
            array_push($list_books, $item);
        }
        return response()->json($list_books);

    }
    public function userReservations($id){

        $user = User::find($id);
        $list_reservations = array();

        foreach($user->reservations as $reservation){
            $item = array('id' => $reservation->id , 'name' => $reservation->name, 'date_reservation' => $reservation->pivot->date_reservation, 'date_devolution' => $reservation->pivot->date_devolution);
            array_push($list_reservations, $item);
        }
        return response()->json($list_reservations);
    }
}
