<?php
namespace Socialogin\Linkedin\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
class LinkedinController
{
    public function linkedinRedirect()
    {
        return Socialite::driver('linkedin')->redirect();
    }
       
    public function linkedinCallback()
    {
        try {
     
            $user = Socialite::driver('linkedin')->user();
      
            $linkedinUser = User::where('oauth_id', $user->id)->first();
      
            if($linkedinUser){
      
                Auth::login($linkedinUser);
     
                return redirect('/dashboard');
      
            }else{
                $user = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'oauth_id' => $user->id,
                    'oauth_type' => 'linkedin',
                    'password' => encrypt('admin12345')
                ]);
     
                Auth::login($user);
      
                return redirect('/dashboard');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}