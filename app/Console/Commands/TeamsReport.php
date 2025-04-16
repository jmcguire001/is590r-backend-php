<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Team;
use App\Mail\TeamsReport as TeamsReportMail;

class TeamsReport extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'report:teams-report {--email=}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Returns a list of all teams to the specified email';

    /**
    * Execute the console command.
    *
    * @return int
    */
    public function handle()
    {
        $sendToEmail = $this->option('email');

        if (!$sendToEmail) {
            $this->error('Please provide an email address using the --email option.');
            return Command::FAILURE;
        }

        $teams = Team::all();

        Mail::to($sendToEmail)->send(new TeamsReportMail($teams));

        dd($teams);

        return Command::SUCCESS;
    }
}