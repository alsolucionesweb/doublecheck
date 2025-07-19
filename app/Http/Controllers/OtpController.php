<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;

use Google\Service\Gmail;
use App\Models\User;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['error' => 'Usuario no existe']);
        }
        $user = User::find($user->id);

        //dd($email);
        if (!$email) {
            return response()->json(['error' => 'Email es requerido']);
        }

        $otp = rand(100000, 999999); // Generar OTP

        $user->otp = $otp; // Asignar OTP al usuario
        $user->save(); // Guardar el usuario con el OTP

        // Guardar el OTP en base de datos o sesión si lo necesitas
        // Configuración OAuth2
        $client = new Google_Client();
        $client->setClientId(env('GMAIL_CLIENT_ID'));
        $client->setClientSecret(env('GMAIL_CLIENT_SECRET'));
        $client->setAccessType('offline');
        $client->setIncludeGrantedScopes(true);
        $client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
        $client->setScopes(['https://www.googleapis.com/auth/gmail.send']);

        // Establece el token de acceso y refresh
        $client->setAccessToken([
            'access_token' => env('GMAIL_ACCESS_TOKEN'),
            'refresh_token' => env('GMAIL_REFRESH_TOKEN'),
            'expires_in' => 3600,
            'created' => time() - 3600 // para forzar refresh
        ]);

        // Refresca el token si es necesario
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            // Aquí puedes guardar el nuevo token en un archivo o BD si lo deseas
        }

        $gmail = new Google_Service_Gmail($client);

        $subject = 'Tu código OTP ✔️';
        $body = "Hola,\n\nTu código OTP es: $otp\n\nGracias,\nEquipo de Double Check";

        // Construir el mensaje RAW con cabeceras UTF-8
        $rawMessageString = "To: {$email}\r\n";
        $rawMessageString .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n"; // Codificar subject
        $rawMessageString .= "From: Double Check <me>\r\n";
        $rawMessageString .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $rawMessageString .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $rawMessageString .= $body;

        // Codificar mensaje base64 URL-safe
        $raw = base64_encode($rawMessageString);
        $raw = str_replace(['+', '/', '='], ['-', '_', ''], $raw);

        // Enviar
        $message = new \Google\Service\Gmail\Message();
        $message->setRaw($raw);
       
        try {
            $gmail->users_messages->send("me", $message);
            return response()->json(['message' => 'OTP enviado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error enviando el correo: ' . $e->getMessage()], 500);
        }
    }

    public function auth()
    {
        $client = new GoogleClient();
        $client->setAuthConfig(storage_path('oauth/credentials.json'));
        $client->setRedirectUri(url('/oauth-callback'));
        $client->addScope(Gmail::GMAIL_SEND);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        $authUrl = $client->createAuthUrl();
        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        $client = new GoogleClient();
        $client->setAuthConfig(storage_path('oauth/credentials.json'));
        $client->setRedirectUri(url('/oauth-callback'));

        if ($request->has('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($request->input('code'));
            file_put_contents(storage_path('oauth/token.json'), json_encode($token));
            return 'Token guardado correctamente. Puedes cerrar esta ventana.';
        }

        return 'Código no recibido';
    }
}
