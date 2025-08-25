<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:fetch-from-api')->hourly();
