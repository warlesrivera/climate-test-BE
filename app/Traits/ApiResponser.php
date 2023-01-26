<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;


trait ApiResponser
{
    /**
	 * Function success response
	 *
	 * @param array $data
	 * @param int $code
	 *
	 * @return \Illuminate\Http\JsonResponse
     *
     * @author  Ubarles Rivera
	 */
	protected function successResponse(array $data, int $code) : JsonResponse
    {

        return Response::json($data, $code);
    }


	/**
	 * Function  error de response
	 *
	 * @param string $message
	 * @param int $code
	 * @param array $payload
	 *
	 * @return \Illuminate\Http\JsonResponse
     *
     * @author  Sergio Benavides, Ubarles Rivera
	 */
	protected function errorResponse(string $message, int $code, array $payload = []) : JsonResponse
	{

		return Response::json(['error' => $message, 'code' => $code, 'payload' => $payload], $code);
	}

	/**
	 * Funcion de respuesta para una coleccion de datos
	 *
	 * @param Collection $collection
	 * @param int $code
	 *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author  Sergio Benavides, Ubarles Rivera
	 */
	protected function showAll(Collection $collection, int $code = 200) : JsonResponse
    {
		if ($collection->isEmpty()) {
			return $this->successResponse(['data' => $collection], $code);
		}

        //  acá podremos decorar por ultima vez la respuesta antes de retornar los datos al frontennd o clientes

		return $this->successResponse(['data' => $collection], $code);
	}

	/**
	 * Funcion de respuesta para una instancia de modelo
	 *
	 * @param Model $instance
	 * @param int $code
	 *
	 * @return \Illuminate\Http\JsonResponse
     *
     * @author  Sergio Benavides, Ubarles Rivera
	 */
	protected function showOne(Model $instance, int $code = 200) : JsonResponse
    {
        //  acá podremos decorar por ultima vez la respuesta antes de retornar los datos al frontennd o clientes

		return $this->successResponse(['data' => $instance], $code);
	}

	/**
	 * Funcion de respuesta exitosa de solo mensaje
	 *
	 * @param string $message
	 * @param int $code
	 *
	 * @return \Illuminate\Http\JsonResponse
     *
     * @author  Sergio Benavides, Ubarles Rivera
	 */
	protected function showMessage(string $message, int $code = 200) : JsonResponse
	{
		return $this->successResponse(['data' => $message], $code);
	}
}
