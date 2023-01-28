<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Modules\MapHistory\Interfaces\IMapHistoryDecorator;

class MapHistoryController extends ApiController
{

    protected $_mapHistoryDecorator;


    public function __construct(IMapHistoryDecorator $mapHistoryDecorator)
    {
        $this->_mapHistoryDecorator = $mapHistoryDecorator;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->_mapHistoryDecorator->all() ;
            return  $data['success']
            ? $this->showAll($data['data'], $data['code'])
            : $this->errorResponse($data['data']['message'], $data['code']);
        } catch (\Illuminate\Database\QueryException $ex) {
            Log::error($ex->getMessage());
            throw new \Exception(__('validation.server.500'));
        } catch (Exception $e) {
            Log::error($e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history(int $id, int $size)
    {
        try {
            $data = $this->_mapHistoryDecorator->history($id,$size) ;

            return  $data['success']
            ? $this->showAll($data['data'], $data['code'])
            : $this->errorResponse($data['data']['message'], $data['code']);
        } catch (\Illuminate\Database\QueryException $ex) {
            Log::error($ex->getMessage());
            throw new \Exception(__('validation.server.500'));
        } catch (Exception $e) {
            Log::error($e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

}
