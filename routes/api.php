<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

# API to save all tags
Route::get('saveAllTags', 'Api\CourseTagsController@saveAllTags');
Route::post('module_reminder_assigner', 'Api\CourseTagsController@assignModuleReminder');