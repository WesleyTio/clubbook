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
        //
        $reservation = new Reservation([
            'fk_user_reservation' => $request->fk_user_reservation,
            'fk_book_reservation' => $request->fk_user_reservation,
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
        $reservation = Reservation::find($id);
        return response()->json($reservation);


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
        $reservation = Reservation::find($id);
        $reservation->update($request->all());

        return response()->json('Reserva alterada com sucesso');
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
        $reservation->delete();

        return response()->json('Reserva deletada com sucesso');
    }
}
