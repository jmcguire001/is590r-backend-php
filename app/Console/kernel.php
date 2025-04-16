<!-- /**
    * Define the application's command schedule.
    *
    * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
    * @return void
    */
   protected function schedule(Schedule $schedule)
   {
       //Adding for testing frequency,  change to weekly or depending on what is instructed.
       $schedule->command('auto:overdue-books --email=[[youremailhere]]@gmail.com')->everyMinute();
   } -->