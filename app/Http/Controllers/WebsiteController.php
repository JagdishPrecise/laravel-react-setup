<?php

namespace App\Http\Controllers;

use App\Models\SearchConsoleAccount;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Google_Client;
use Google_Service_Oauth2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WebsiteController extends Controller
{


    public function index(Request $request)
    {
        $data   = SearchConsoleAccount::where('userId', Auth::user()->id)->get();
        return Inertia::render('website', ['data'  => $data]);
    }

    public function add()
    {
        $client     = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope("email");
        $client->addScope("profile");
        $client->addScope('https://www.googleapis.com/auth/webmasters.readonly');
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $authUrl    = $client->createAuthUrl();

        return redirect()->to($authUrl);
    }
    /**
     * Handle the callback from Google after user authorization.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function handleCallback(Request $request)
    {
        Log::info('Callback request received.', ['request' => $request->all()]);
    
        $data   = SearchConsoleAccount::where('userId', Auth::user()->id)->get();

        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        if ($request->has('code')) {
            Log::info('Authorization code found, fetching access token.');
            
            try {
                
                $token = $client->fetchAccessTokenWithAuthCode($request->code);
                Log::info('Access token fetched successfully.', ['token' => $token]);

                // Set the access token for the client
                $client->setAccessToken($token['access_token']);
    
                $google_oauth = new Google_Service_Oauth2($client);
                $user_info = $google_oauth->userinfo->get();
                Log::info('User info retrieved from Google API.', ['user_info' => $user_info]);
    
                $checkUser = SearchConsoleAccount::where('email', $user_info['email'])
                    ->where('userId', Auth::user()->id)
                    ->first();
    
                if ($checkUser == null) {
                    Log::info('No user found, creating a new account.', ['email' => $user_info['email']]);
    
                    $info = new SearchConsoleAccount();
                    $info->name = $user_info['name'];
                    $info->email = $user_info['email'];
                    $info->access_token = $token['access_token'];
                    $info->expires_in = $token['expires_in'];
                    $info->refresh_token = $token['refresh_token'];
                    $info->scope = $token['scope'];
                    $info->token_type = $token['token_type'];
                    $info->id_token = $token['id_token'];
                    $info->created = $token['created'];
                    $info->userId = Auth::user()->id;
                    $info->save();
    
                    Log::info('Account successfully connected for user.', ['user_id' => Auth::user()->id]);
                    return redirect()->route('website')->with('success', 'Account has been connected successfully');
                } else {
                    Log::info('User already exists with email: ' . $user_info['email']);
    
                    if ($checkUser->hasError == '1') {
                        Log::info('User has an error, updating account with new tokens.', ['email' => $user_info['email']]);
    
                        $checkUser->access_token = $token['access_token'];
                        $checkUser->expires_in = $token['expires_in'];
                        $checkUser->refresh_token = isset($token['refresh_token']) ? $token['refresh_token'] : $checkUser->refresh_token;
                        $checkUser->scope = $token['scope'];
                        $checkUser->token_type = $token['token_type'];
                        $checkUser->id_token = $token['id_token'];
                        $checkUser->created = $token['created'];
                        $checkUser->hasError = '0';
                        $checkUser->status = '1';
                        $checkUser->save();
    
                        Log::info('User account updated successfully.', ['email' => $user_info['email']]);
    
                        return redirect()->route('website')->with('success', 'Your email updated successfully');
                    }
    
                    Log::info('User email already connected, no changes made.', ['email' => $user_info['email']]);
                    return redirect()->route('website')->with('success', 'This email has been already connected');
                }
            } catch (\Exception $e) {
                Log::error('Error occurred while handling callback.', ['error' => $e->getMessage()]);
                return redirect()->route('website')->with('error', 'Something went wrong');
            }
        } else {
            Log::warning('Authorization code missing in the request.');
            return redirect()->route('website')->with('error', 'Something went wrong');
        }
    }
    
}
