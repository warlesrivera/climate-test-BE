<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\City\Interfaces\ICityDecorator;

class CitiesController extends ApiController
{

    protected $_cityDecorator;


    public function __construct(ICityDecorator $cityDecorator)
    {
        $this->_cityDecorator = $cityDecorator;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cities()
    {
        try {
            $data = $this->_cityDecorator->all() ;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
