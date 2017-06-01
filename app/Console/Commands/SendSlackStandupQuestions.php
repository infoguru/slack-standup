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

        $hook = env("SLACK_INCOMING_HOOK_URL", false);

        if(!$hook)
        {
            return;
        }

        $this->settings["username"] = env("SLACK_INCOMING_USERNAME", "bot");

        $this->settings["channel"] = env("SLACK_CHANNEL", "#general");

        $this->slack = new SlackClient($hook, $this->settings);

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $msg = env("SLACK_QUESTION");
     
        $this->slack->send($msg);

    }
}