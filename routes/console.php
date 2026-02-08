<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:fetch-latest-news')->hourly();
