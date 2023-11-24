<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Todos los días controla los préstamos sin retirar
        $schedule->call('App\Http\Controllers\LoanController@liberateLoans')->dailyAt('08:00');
        $schedule->call('App\Http\Controllers\LoanController@checkPending')->dailyAt('08:00');
        $schedule->call('App\Http\Controllers\LoanController@dailySummary')->dailyAt('08:00');
        // Para testear reemplazar por esta linea
        // $schedule->call('App\Http\Controllers\LoanController@liberateLoans')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
