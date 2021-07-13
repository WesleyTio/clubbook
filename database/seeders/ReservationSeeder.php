<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $dadosReserva = [
            'fk_user_reservation' => 1,
            'fk_book_reservation' => 2,
            'date_reservation' => "2021-07-21",
            'date_devolution' => "2021-07-23"
        ];
        Reservation::create($dadosReserva);
        echo "Reserva do livro 2 criada \n";
        
        $dadosReserva2 = [
            'fk_user_reservation' => 2,
            'fk_book_reservation' => 1,
            'date_reservation' => "2021-07-19",
            'date_devolution' => "2021-07-21"
        ];
        Reservation::create($dadosReserva2);
        echo "Reserva do livro 1 criada \n";
    }
}
