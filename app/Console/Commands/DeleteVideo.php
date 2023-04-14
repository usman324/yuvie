<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\User;
use App\Models\Video;
use App\Traits\Main;
use Illuminate\Console\Command;

class DeleteVideo extends Command
{
    use Main;
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
            $user = User::find($video->user_id);
            $this->notification('YuVie LLC', $video->title . ' Video Delete',$user);
            Notification::create([
                'user_id'=>$user->id,
                'video_id' => $video->id,
                'title'=>'Video Delete',
                'description' => $video->title . ' Video Delete',
            ]);
            $video->delete();
        }
        return 0;
    }
}
