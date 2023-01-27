<?php

namespace App\Modules\MapHistory\Decorators;

use Http;
use App\Models\MapHistory;
use App\Modules\City\Repositories\CityRepository;
use Illuminate\Support\Facades\Log;
use App\Modules\MapHistory\Interfaces\IMapHistoryDecorator;
use App\Modules\MapHistory\Repositories\MapHistoryRepository;

class MapHistoryDecorator implements IMapHistoryDecorator
{
    protected $_mapHistoryRepository;
    protected $_cityRepository;


    public function __construct(MapHistoryRepository $MapHistoryRepository, CityRepository $cityRepository)
    {
        $this->_mapHistoryRepository = $MapHistoryRepository;
        $this->_cityRepository = $cityRepository;
    }

    public function All()
    {
        try
        {
            $cities = $this->_cityRepository->All();
            $histories = array();
            foreach ($cities as $key => $city) {
                $data = $this->getApiHumidity($city->lat,$city->long, $city->id);
                $map = $this->InsertMapHistory($data);
                $map->city =$city;
                array_push($histories, $map);
            }
            return  [
                'success' => true,
                'code' => 200,
                'data' => collect($histories)
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
            $data = $this->_mapHistoryRepository->save($mapHistory);
            return   $data;
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
    public function history(int $id)
    {
        try
        {
            $MapHistory = $this->_mapHistoryRepository->historyUser($id);

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

    private function getApiHumidity ($lat, $long, $idCity)
    {
        $map = new MapHistory();
        $url = $map::URL;
        $key =$map::API_KEY;

        $endpoint ="{$url}?lon={$long}&appid={$key}&lat={$lat}";
        $apiReq = Http::get($endpoint);
        $apiRes = $apiReq->json();

        $map->humidity = $apiRes['current']['humidity'];
        $map->alerts =isset($apiRes['alerts'])?$apiRes['alerts']:null;
        $map->weather =$apiRes['current']['weather'];
        $map->user_id =auth()->id();
        $map->city_id =$idCity;

        return $map;
    }

}
