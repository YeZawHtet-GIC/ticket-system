<?php

namespace App\Http\Controllers;

use App\Models\Lable;
use App\Http\Requests\StoreLableRequest;
use App\Http\Requests\UpdateLableRequest;

class LableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreLableRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLableRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lable  $lable
     * @return \Illuminate\Http\Response
     */
    public function show(Lable $lable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lable  $lable
     * @return \Illuminate\Http\Response
     */
    public function edit(Lable $lable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLableRequest  $request
     * @param  \App\Models\Lable  $lable
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLableRequest $request, Lable $lable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lable  $lable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lable $lable)
    {
        //
    }
}
