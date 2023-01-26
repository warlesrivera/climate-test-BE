<?php
namespace App\Helpers;


use Illuminate\Support\Facades\DB as DB;
use App\Http\Controllers\Interconnection\SmtpTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\User;


class Functions {

    use SmtpTrait;

    public static function  getB64Image($base64_image){
            // Obtener el String base-64 de los datos
            $image_service_str = substr($base64_image, strpos($base64_image, ",")+1);
            // Decodificar ese string y devolver los datos de la imagen
            $image = base64_decode($image_service_str);
            // Retornamos el string decodificado
            return $image;
    }

    public static function  getB64Extension($base64_image, $full=null){
        // Obtener mediante una expresión regular la extensión imagen y guardarla
        // en la variable "img_extension"
        preg_match("/^data:image\/(.*);base64/i",$base64_image, $img_extension);
        // Dependiendo si se pide la extensión completa o no retornar el arreglo con
        // los datos de la extensión en la posición 0 - 1
        return ($full) ?  $img_extension[0] : $img_extension[1];
    }

    public static function  fileName($extension = ''){
        //Create new file name
        $characters = 'ABCDEFHJKLMNPQRTUWXYZABCDEFHJKLMNPQRTUWXYZ';
        $unique = substr(str_shuffle($characters), 0, 10);
        $epoch = date('YmdHis');
        $fileName = $unique . '_' . $epoch . '.' . $extension;
        return $fileName;
    }

    public static function env(){
         return config('app.env');
    }

    public static function revokeAccessTokens() {
        $user = auth()->user()->token();
        $user->revoke();
    }

    public static function getRefreshToken(){
        return DB::table('oauth_refresh_tokens')->where('access_token_id',auth()->user()->token()->id)->where('revoked',0)->first();
    }

    public static function logout($oldEmail =null)
    {
            Functions::revokeAccessTokens();
            return response()->json(array(['logout'=>true,'message'=>'fin de la sesion']), 200);
    }

    public static function createDataEmail($email,$datos=[],$asunto,$endpoint=null,$type){
        if(isset($endpoint)){
            $url = Config::get('constants.URL').'/'.$endpoint;
            $datos = [  'url' => $url ];

        }
            $fn = new Funciones();
            $fn->SendingMessages($asunto,$email,$type,$datos);
            return true;
    }
    public static function crearPin(User $usuario,$tipo){
        $numeroPin = rand(111111,999999);
        $pin= new UsuarioPin;
        $pinOld =$pin->existePinUsuario($usuario->idusuario)->get();

        foreach ($pinOld as $key => $value) {
            $value->idestado = Config::get('constants.ESTADO_PENDIENTE');
            $value->fechauso =  \Carbon\Carbon::now();
            $value->save();
        }

        $pin = $usuario->pin()->create([
            'pin'          => $numeroPin,
            'fechacreacion'=> \Carbon\Carbon::now(),
            'idestado'     => Config::get('constants.ESTADO_ACTIVO'),
            'tipo'=>$tipo
        ]);
        return $pin;
    }
    public static function cambiarPin($usuario,$tipo){


        if(isset($usuario)){
            $validPin= new UsuarioPin;
            if($validPin->crearPinTiempo($usuario->idusuario))
                 return response()->json(['cambioPin'=>false,'message'=>__('validation.auth.pinTiempoNo')],401);
            $pin=Funciones::crearPin($usuario,$tipo);
            if($usuario->email){
                $datos=[];
                if($usuario->comercio->idtipopersona===Config::get('constants.PERSONA_JURIDICA'))
                    $datos ["nombre"]= $usuario->razonSocial;
                else
                    $datos ["nombre"]= $usuario->comercio->name." ".$usuario->comercio->lastname;

                $datos["pin"]=$pin->pin;
                $email = $usuario->email;
                $asunto='reeenvio Codigo de verificación, '.$usuario->razonSocial;
                $fn = new Funciones();
                $fn->createDataEmail($usuario->email,$datos,$asunto,null,'code-verfication');

                return ['enviado'=>true,'message'=>'hemos enviado un nuevo pin. Por favor verifica tu correo'];

            }
        }

    }
    public static function saveUserLogin($email, $state){
        $token = Str::random(60);
        $user_login = new UsuarioIngreso;
        $user_login->login = $email;
        $user_login->ip = \request()->ip();
        $user_login->fechaingreso = Carbon::now();
        $user_login->estado = $state;
        $user_login->token = $token;
        $user_login->save();
        return $user_login;
    }
    private function sendMessage($email,$asunto,$datos,$type){
        $this->SendingMessages($asunto,$email,$type,$datos);
    }



}
