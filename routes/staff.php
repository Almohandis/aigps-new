<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// all routes for staff will be here

Route::get('/clerk', 'CampaignClerkController@index');