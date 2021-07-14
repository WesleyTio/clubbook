<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $reservations = Reservation::all()->toArray();
        return array($reservations);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {

        $reservation = new Reservation([
            'fk_user_reservation' => $request->fk_user_reservation,
            'fk_book_reservation' => $request->fk_book_reservation,
            'date_reservation' => $request->date_reservation,
            'date_devolution' => $request->date_devolution,

        ]);
        $reservation->save();

        return response()->json('Reserva realizada com sucesso');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        try {
            //code...
            $reservation = Reservation::find($id);
            $response =[
                'book_id'               =>  $reservation->fk_book_reservation,
                'date_reservation'      =>  $reservation->date_reservation,
                'date_devolution'       =>  $reservation->date_devolution
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        var_dump($id);
        $list_user_books_reservations = $this->listReservationsUser($request->id_user);
        $dateR = date_create($request->date_reservation);
        $dateD = date_create($request->date_devolution);
        $validate = true;
        foreach($list_user_books_reservations as $reservation){
            $date_devolution = date_create($reservation['date_devolution']);
            $date_reservation = date_create($reservation['date_reservation']);
            if($dateR < $date_devolution && ($reservation['id'] =! $id)){
                if($dateD > $date_reservation){
                    $validate = false;
                }
            }
        }
        if($validate){
            $reservation = Reservation::find($id);
            $reservation->update(['date_reservation' => $request->date_reservation, 'date_devolution' =>  $request->date_devolution]);
            $success = true;
            $message = 'Reserva atualizada com sucesso';
        }else{
            $success = false;
            $message = 'Não é possivel reservar mais de um livro para mesma data';
        }
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $reservation = Reservation::find($id);
        try {
            //code...
            $reservation->delete();
            $response =[
                'success'   =>  true,
                'message'   =>  'Reserva deletada com sucesso'
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $response =[
                'success'   =>  true,
                'message'   =>  $th->getMessage()
            ];
            return response()->json($response, 500);
        }

    }

    private function listReservationsUser($id){
        $dateToday = date_create();
        $list_reservations = array();
        try {
            //code...
            $list_reservation_user = Reservation::UserListReservation($id)->get();
            foreach( $list_reservation_user as $reservation){
                $date_devolution = date_create($reservation->date_devolution);
                if($dateToday < $date_devolution){
                    $item = ['date_reservation' => $reservation->date_reservation, 'date_devolution' => $reservation->date_devolution];
                    array_push($list_reservations, $item);
                }
            }

        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }

        return $list_reservations;
    }
}
