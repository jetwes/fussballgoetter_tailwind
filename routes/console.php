<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('practise:remind')->everyFifteenMinutes();
