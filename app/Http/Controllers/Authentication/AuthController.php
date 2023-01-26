<?php

namespace App\Http\Controllers\Authentication;

use Log;
use Functions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Authentication\IssueTokenTrait;


class AuthController extends ApiController
{
    use  IssueTokenTrait;

    public function me()
    {

        try {
            if (!empty(auth()->user()) && !empty(auth()->user()->token())) {

                // fin validación de ccambio de contraseña pasado 90 dias

                $refreshToken = Functions::getRefreshToken();
                dd($refreshToken );
                if (auth()->user()->token()->expires_at > Carbon::now())
                    return response()->json(['get' => true, 'message' => 'La sesion existe']);
                else {

                    if (carbon::parse($refreshToken->expires_at) > Carbon::now())
                        return response()->json(['get' => true, 'message' => 'renueva la sesion.']);
                    else {
                        auth()->user()->token()->revoke();
                        Functions::revokeAccessAndRefreshTokens();
                        return response()->json(array('get' => false, 'errors' => 'la sesion ya expiro.'), 200);
                    }
                }
            } else
                return response()->json(array('get' => false, 'errors' => 'El login no existe'), 200);
        } catch (Exception $e) {
            Log::error($e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            return response()->json(['error' => __('validation.server.500')], 500);
        }
        catch(\Illuminate\Database\QueryException $ex){
            Log::error($ex->getMessage() );
            return response()->json(['error' => __('validation.server.500')], 500);
        }

    }
    public function refresh(Request $request)
    {
        try {
            $consult = $this->me();

            $content = $consult->getContent();
            $data = json_decode($content, true);

            if (isset($data['message'])) {

                $this->validate($request, [
                    'refresh_token' => 'required',
                ], [
                    "refresh_token.required" => "falta el refresh_token",
                ]);

                $tokenResponse = $this->issueToken($request, 'refresh_token');
                $content = $tokenResponse->getContent();
                $data = json_decode($content, true);

                if (isset($data['error'])) {

                    return response()->json([
                        "token" => false,
                        "data" => $data
                    ], 401);
                } else {

                    $data['expires_in'] = Carbon::now()->addSeconds($data['expires_in'])->format("d-m-Y H:i:s");

                    return response()->json([
                        "token" => $data
                    ], 200);
                }
            } else {
                return response()->json($data, 200);
            }
        }  catch (Exception $e) {
            Log::error($e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            return response()->json(['error' => __('validation.server.500')], 500);
        }
        catch(\Illuminate\Database\QueryException $ex){
            Log::error($ex->getMessage() );
            return response()->json(['error' => __('validation.server.500')], 500);
        }

    }
    public function logout()
    {
        try {
            Functions::logout();
            return response()->json(array(['logout' => true, 'message' => 'fin de la sesion']), 200);
        } catch (Exception $e) {
            Log::error($e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            return response()->json(['error' => __('validation.server.500')], 500);
        }
        catch(\Illuminate\Database\QueryException $ex){
            Log::error($ex->getMessage() );
            return response()->json(['error' => __('validation.server.500')], 500);
        }

    }

    public function perfilUser()
    {
        try {
            $perfil = auth()->user()->perfil()->select('idperfil', 'descripcion')->first();
            return response()->json(array('perfil' => true, 'data' => $perfil), 200);
        } catch (Exception $e) {
            Log::error($e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            return response()->json(['send' => false, 'error' => __('validation.server.500')], 500);
        }
    }

}
