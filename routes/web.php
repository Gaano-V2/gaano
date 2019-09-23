<?php


Route::get('{any}', 'ViewController@index')->where('any', '.*');
