<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('legacy/webhook/virement', [\App\Http\Controllers\LegacyWebhookController::class, 'virementVerified']);

// Webhooks pour les statuts SMS
Route::post('sms/webhook/status', [\App\Http\Controllers\SmsWebhookController::class, 'handleTwilioStatus']);
Route::post('sms/webhook/infobip', [\App\Http\Controllers\SmsWebhookController::class, 'handleInfobipStatus']);
Route::post('sms/webhook/vonage', [\App\Http\Controllers\SmsWebhookController::class, 'handleVonageStatus']);
 
Route::post('/unlock-codes/consume', [\App\Http\Controllers\Api\UnlockCodeController::class, 'consume'])
	->name('api.unlock-codes.consume');
