<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;

class DeleteVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Video After 14 days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $videos=Video::where('status','archive')->get();
        foreach($videos as $video){
            $video->delete();
        }
        return 0;
    }
}
