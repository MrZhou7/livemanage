<?php
Route::rule('web/:controller/:function', 'api/web.:controller/:function'); //PC接口
Route::rule(':controller/:function', 'api/mini.:controller/:function'); //小程序接口
