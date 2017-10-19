<?php

Route::get('/{key}', 'LinkTrackingController@redirectToLink')->where(['key' => '^(?!home|links).*']);
