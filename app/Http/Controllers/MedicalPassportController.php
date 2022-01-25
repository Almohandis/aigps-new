<?php

namespace App\Http\Controllers;

use App\Models\MedicalPassport;
use App\Http\Requests\StoreMedicalPassportRequest;
use App\Http\Requests\UpdateMedicalPassportRequest;

class MedicalPassportController extends Controller
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
     * @param  \App\Http\Requests\StoreMedicalPassportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedicalPassportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalPassport  $medicalPassport
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalPassport $medicalPassport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalPassport  $medicalPassport
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalPassport $medicalPassport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMedicalPassportRequest  $request
     * @param  \App\Models\MedicalPassport  $medicalPassport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMedicalPassportRequest $request, MedicalPassport $medicalPassport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalPassport  $medicalPassport
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalPassport $medicalPassport)
    {
        //
    }
}
