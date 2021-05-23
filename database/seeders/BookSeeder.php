<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $dadosLivro = [
            'name' => "O Senhor dos Anéis: A sociedade do anel",
            'author' => "J.R.R Tolkien",
            'description' => "A aventura de frodo bolseiro e seus amigos",
            'fk_users' => 1
        ];
        $dadosLivro2 = [
            'name' => "O Senhor dos Anéis: As Duas Torres",
            'author' => "J.R.R Tolkien",
            'description' => "A aventura de frodo bolseiro e seus amigos",
            'fk_users' => 1
        ];
        $dadosLivro3 = [
            'name' => "O Senhor dos Anéis: O Retorno do Rei",
            'author' => "J.R.R Tolkien",
            'description' => "A aventura de frodo bolseiro e seus amigos",
            'fk_users' => 1
        ];
        Book::create($dadosLivro);
        echo "livro criado 1 \n";
        Book::create($dadosLivro2);
        echo "livro criado 2 \n";
        Book::create($dadosLivro3);
        echo "livro criado 3 \n";


    }
}
