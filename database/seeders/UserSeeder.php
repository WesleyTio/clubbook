<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $dados =[
            'name' =>"José Wesley",
            'login' =>"ChacalTio",
            'email' => "wesleymagnos@hotmail.com",
            'password' => bcrypt("123456")
        ];

        if(User::where('email','=',$dados['email'])->count()){
            $user = User::where('email','=',$dados['email'])->first();
            $user->update($dados);
            echo "usuario alterado \n";
        }else{
            User::create($dados);
            echo "usario criado \n";
        }
        //Outro tipo de usuario pra testes!
        $dados2 =[
            'name' =>"José Tio",
            'login' =>"WesleyTio",
            'email' => "wesleymagnos@gmail.com",
            'password' => bcrypt("123456")

        ];

        if(User::where('email','=',$dados2['email'])->count()){
            $user = User::where('email','=',$dados2['email'])->first();
            $user->update($dados2);
            echo "usuario 2 alterado";
        }else{
            User::create($dados2);
            echo "usuario 2 criado";
        }
        
    }
}
