<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

use function PHPUnit\Framework\throwException;

class UserController extends Controller
{
    public function registerUser(Request $request){
        if(is_null(User::where('email',$request->input('email'))->first()))
        try{
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password'=> password_hash($request->input('password'),PASSWORD_BCRYPT)
            ]);
            if(is_null($user))  return $this->error('Erreur l\'hors de l\'inscription');
            return response()->json(["response"=>true,"message"=>"utilisateur cree","result"=>$user]);
        }catch(Exception $e){
            return $this->error($e->getMessage());
        }
        else
            return $this->error('Cette addresse email est deja enregistree');
    }

    public function loginUser(Request $request){
        $user = User::where('email',$request->input('email'))->first();
        if(is_null($user))
            return $this->error('Ce utilisateur n\'existe pas');
        else{
            if(password_verify($request->input('password'),$user->password))
                return response()->json(["response"=>true,"message"=>"utilisateur existant","result"=>$user]);
            else
                return $this->error('Mot de passe incorrect');
        }

    }

    public function resetPassword(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);
        $user = User::where('email',$request->input('email'))->first();
        if(is_null($user))
            return $this->error('Cette addresse email n\'est pas enregistree');
        MailController::sendPasswordForgetMailTo($user->email, $this->randomPassword(10));
        return response()->json([
            "response"=>true,
            "message"=>"Mot de passe reinitialise",
            "result"=>"Consulter votre email. Le code de reinitialisation de votre compte y a ete envoye"
        ]);
    }

    public function updatePassword(Request $request){

    }

    private function randomPassword(int $length = 10){
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
}
