<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTokenViaSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    protected $attendees;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($attendees)
    {
        $this->attendees = $attendees;
    }

    /**
     * HELPERS
     */
    protected function generateToken($attendee)
    {
        $token = strtoupper(substr(md5(uniqid(true)), 20, 7));
        return $token;
    }

    protected function callSMSAPI($payload)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => config('electionapp.sms.advanced_api'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization:" . config('electionapp.sms.financial_token')."",
            "content-type: application/json"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        echo $response;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // if ($this->attendees != null) {
            $bulkMessage = '';
            // $size = count($attendees) - 1;
            $size = count($this->attendees) - 1;
            foreach ($this->attendees as $key => $attendee) {
                $token = $this->generateToken($attendee);
                $attendee->update([
                    'token' => $token
                    ]);

                    // Generate SMS
                    if ($key < $size) {
                            
                        $job1 = "{\"from\" : \"AFRIPRUD\", \"destinations\":[{\"to\" : \"{$attendee->mobile}\"}], \"text\" : \"Dear {$attendee->name}, {$attendee->event->title} starts at 2PM today & will only be open for 1 hour. Your code is {$attendee->token}. To vote online, click {$attendee->event->vote_online}.Thank you.\"},";
                        // $job1 = preg_replace("!\r?\n!", "", $job1);
                        $bulkMessage .= $job1;
                    }else{
                        $job1 = "{\"from\" : \"AFRIPRUD\", \"destinations\":[{\"to\" : \"{$attendee->mobile}\"}], \"text\" : \"Dear {$attendee->name}, {$attendee->event->title} starts at 2PM today & will only be open for 1 hour. Your code is {$attendee->token}. To vote online, click {$attendee->event->vote_online}.Thank you.\"}";
                        // $job1 = preg_replace("!\r?\n!", "", $job1);
                        $bulkMessage .= $job1;
                    }

            }
            // Build JSON SMS payload for each chunk
            $payload = "{\"messages\" : [$bulkMessage], \"bulkId\": \"Bulk-ID-990123\"}";
            $this->callSMSAPI($payload);
    }
}
