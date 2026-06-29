<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PelamarWebhookController;

Route::post('/pelamar-webhook', [PelamarWebhookController::class, 'store']);