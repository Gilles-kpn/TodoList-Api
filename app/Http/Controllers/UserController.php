<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

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

    //update user password
    //get new password and old password from request
    //validate request
    //update password in database
    public function updatePassword(Request $request,int $userId){
        $request->validate([
            'oldPassword' => 'required|min:6|max:20',
            'newPassword' => 'required|min:6|max:20',
        ]);
        $user = User::find($userId);
        if(is_null($user))
            return $this->error('Modification du mot de passe impossible');
        else{
            if(password_verify($request->input('oldPassword'),$user->password)){
                $user->password = password_hash($request->input('newPassword'),PASSWORD_DEFAULT);
                $user->save();
                return response()->json(["response"=>true,"message"=>"Mot de passe modifie","result"=>$user]);
            }
         return $this->error('Mot de passe incorrect');
        }
    }

    //mettre a jour les champs name , email et password de l'utilisateur
    public function updateUser(Request $request){
        $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6|max:20'
        ]);
        $user = User::where('email',$request->input('email'))->first();
        if(is_null($user))
            return $this->error('Cette addresse email n\'est pas enregistree');
        else{
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = password_hash($request->input('password'),PASSWORD_DEFAULT);
            $user->save();
            return response()->json(["response"=>true,"message"=>"Utilisateur modifie","result"=>$user]);
        }
    }


    //generer un mot de passe alpha-numerique entre 6 et 20 caracteres
    private function randomPassword($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    //effacer utilisateur
    //soumettre mot de passe et email
    //verifier si l'email existe
    //verifier si le mot de passe est bon
    //effacer l'utilisateur
    public function deleteUser(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:20'
        ]);
        $user = User::where('email',$request->input('email'))->first();
        if(is_null($user))
            return $this->error('Cette addresse email n\'est pas enregistree');
        else{
            if(password_verify($request->input('password'),$user->password)){
                $user->delete();
                return response()->json(["response"=>true,"message"=>"Utilisateur efface","result"=>'Utilisateur efface']);
            }
            else
                return $this->error('Mot de passe incorrect');
        }
    }
}
