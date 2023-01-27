<?php

namespace App\Modules\MapHistory\Decorators;

use App\Models\MapHistory;
use App\Models\Headquarter;
use Illuminate\Support\Facades\Log;
use App\Modules\MapHistory\Request\MapHistoryRequest;
use App\Modules\MapHistory\Interfaces\IMapHistoryDecorator;
use App\Modules\MapHistory\Repositories\MapHistoryRepository;
use Http;

class MapHistoryDecorator implements IMapHistoryDecorator
{
    protected $_MapHistoryRepository;
    private const API_KEY = 'e0747514d5f27693d0331f725e844e45';
    private const URL = 'https://api.openweathermap.org/data/3.0/onecall';

    public function __construct(MapHistoryRepository $MapHistoryRepository)
    {
        $this->_MapHistoryRepository = $MapHistoryRepository;
    }

    public function All()
    {
        try
        {
            $MapHistorys = $this->_MapHistoryRepository->All();
            return  [
                'success' => true,
                'code' => 200,
                'data' => $MapHistorys
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
    public function InsertMapHistory( MapHistory $mapHistory = null)
    {
        try
        {
            $message = __('validation.update', ['attributes' => __('validation.attributes.MapHistory')]);


            $this->_MapHistoryRepository->save($mapHistory);
            return  [
                'success' => true,
                'code' => 200,
                'data' =>['message' => $message]

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
                'message' => __('validation.delete', ['attributes' => 'MapHistory'])
            ];
        }
    }
    public function Get(int $id)
    {
        try
        {
            $MapHistory = $this->_MapHistoryRepository->get($id);
            return  [
                'success' => true,
                'code' => 200,
                'data' => $MapHistory
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

    private function getApiHumidity ($lat, $long)
    {
        $url ="{URL}?lon={$long}&appid={API_KEY}&last={$lat}";
        $apiReq = Http::get($url);
        $apiRes = $apiReq->json();
        dd($apiRes);
    }

}
