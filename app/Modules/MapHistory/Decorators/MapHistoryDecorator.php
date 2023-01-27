<?php

namespace App\Modules\MapHistory\Decorators;

use App\Models\MapHistory;
use App\Models\Headquarter;
use Illuminate\Support\Facades\Log;
use App\Modules\MapHistory\Request\MapHistoryRequest;
use App\Modules\MapHistory\Interfaces\IMapHistoryDecorator;
use App\Modules\MapHistory\Repositories\MapHistoryRepository;
use Hash;

class MapHistoryDecorator implements IMapHistoryDecorator
{
    protected $_MapHistoryRepository;

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
    public function UpsertMapHistory(MapHistoryRequest $request, MapHistory $MapHistory = null)
    {
        try
        {
            $message = __('validation.update', ['attributes' => __('validation.attributes.MapHistory')]);

            if ($MapHistory == null) {

                $MapHistory = new MapHistory($request->all());
                $MapHistory->headquarter_id = Headquarter::first()->id;
                $MapHistory->password = Hash::make($MapHistory->password);
                $message =__('validation.success', ['attributes' => __('validation.attributes.MapHistory') ]);
            }
            else
            {
                $MapHistory->fill( $request->all()) ;
            }

            $this->_MapHistoryRepository->save($MapHistory);
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
    public function Delete(int $id)
    {
        try
        {
            $MapHistory = $this->Get($id);

            if( $this->_MapHistoryRepository->delete($MapHistory['data']))
            {
                return  [
                    'success' => true,
                    'code' => 200,
                    'data' => [
                        'message' => __('validation.delete',['attributes' => __('validation.attributes.MapHistory')])
                    ]
                ];
            }
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
