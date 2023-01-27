<?php

namespace App\Modules\City\Decorators;

use Illuminate\Support\Facades\Log;
use App\Modules\City\Interfaces\ICityDecorator;
use App\Modules\City\Repositories\CityRepository;

class CityDecorator implements ICityDecorator
{
    protected $_cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->_cityRepository = $cityRepository;
    }

    public function All()
    {
        try
        {
            $cities = $this->_cityRepository->All();
            return  [
                'success' => true,
                'code' => 200,
                'data' => $cities
            ];
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            Log::error($e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            throw new \Exception(__('validation.server.500'));
        }
        catch (\Exception $ex)
        {
            Log::error($ex->getMessage());

            return [
                'success' => false,
                'code' => 500,
                'data' => [
                    'message' => __('validation.server.500')
                ]
            ];
        }
    }

    public function Get(int $id)
    {
        try
        {
            $city = $this->_cityRepository->get($id);
            return  [
                'success' => true,
                'code' => 200,
                'data' => $city
            ];
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            Log::error($e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            throw new \Exception(__('validation.server.500'));
        }
        catch (\Exception $ex)
        {
            Log::error($ex->getMessage());

            return [
                'success' => false,
                'code' => 500,
                'data' => [
                    'message' => __('validation.server.500')
                ]
            ];
        }
    }

}
