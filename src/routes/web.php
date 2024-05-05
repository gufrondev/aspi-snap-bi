<?php

Route::group(['prefix' => 'snap-bi', 'middleware' => ['guest']], function() {
    Route::post('/payment', 'Api\SnapBiController@payment_webhook');
    Route::post('/va-inquiry', 'Api\SnapBiController@va_inquiry_webhook');
    Route::post('/va-payment', 'Api\SnapBiController@va_payment_webhook');
});
