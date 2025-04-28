<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Oauth2;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class GoogleController extends Controller
{
    public function redirect()
    {

        $client     = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_SIGNIN_URL'));
        $client->addScope("email");
        $client->addScope("profile");
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $authUrl    = $client->createAuthUrl();

        return redirect()->to($authUrl);
    }


    public function authCallBack(Request $request)
    {

        try {
            $client       = new Google_Client();
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setRedirectUri(env('GOOGLE_SIGNIN_URL'));

            if ($request->has('code')) {
                $token          = $client->fetchAccessTokenWithAuthCode($request->code);
                $client->setAccessToken($token);
                $google_oauth   = new Google_Service_Oauth2($client);
                $googleUser     = $google_oauth->userinfo->get();

                $user           = User::where('email', $googleUser->email)->first();

                if (!$user) {
                    $newUser = User::create([
                        'name'      => $googleUser->name,
                        'email'     => $googleUser->email,
                        'googleId'  => $googleUser->id,
                        'password'  => bcrypt('12345678'),
                    ]);

                    Auth::login($newUser);
                    return redirect('/dashboard');
                } elseif ($user->email == $googleUser->email && $user->googleId == '') {
                    $user->update([
                        'googleId' => $googleUser->id
                    ]);

                    Auth::login($user);
                    return redirect('/dashboard');
                } else {
                    Auth::login($user);
                    return redirect('/dashboard');
                }
            }
        } catch (\Exception $e) {
            return redirect('login');
        }
    }
}
