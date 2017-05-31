<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maknz\Slack\Client as SlackClient;


class SendSlackStandupQuestions extends Command
{
   

    protected $signature = 'slack:standup';

    protected $description = '';

    protected $slack;

    protected $settings = [
        'link_names' => true,
        'icon'  => ':cop:'
    ];


    public function __construct()
    {
        parent::__construct();

        $this->settings["username"] = env("SLACK_INCOMING_USERNAME", "bot");

        $this->settings["channel"] = env("SLACK_CHANNEL", "#general");

        $this->slack = new SlackClient(env("SLACK_INCOMING_HOOK_URL"), $this->settings);

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $format = env("SLACK_QUESTION");

        $nicks = explode(",", env("SLACK_NICKS"));

        shuffle($nicks);

        foreach($nicks AS $nick)
        {
            $msg = sprintf($format, $nick);

            sleep(5);

            $this->slack->send($msg);
        }



    }
}