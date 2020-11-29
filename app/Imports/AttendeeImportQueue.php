<?php

namespace App\Imports;

use App\Models\Attendee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;


class AttendeeImportQueue implements ToModel, WithHeadingRow, ShouldQueue, WithChunkReading
{
    private $event_id;

    public function __construct($event_id)
    {
        $this->event_id = $event_id;
    }

    // HELPERS
    protected function addCountryCodeToGSM($mobile)
    {
        $mobile = (substr($mobile,0,1) == 0) ? '234'.substr($mobile,1) : $mobile;
        return $mobile;
    }

    protected function generateToken()
    {
        $token = strtoupper(substr(md5(uniqid(true)), 20, 7));
        return $token;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $uid = uniqid(true) .time();
        return new Attendee([
            'name'          =>  strtoupper($row['name']),  
            'uid'           =>  $uid,
            'email'         =>  strtolower($row['email']),
            'mobile'        =>  $this->addCountryCodeToGSM($row['mobile']),
            'misc'          =>  $row['misc'],
            'misc1'         =>  $row['misc1'],
            'misc2'         =>  $row['misc2'],
            'misc3'         =>  $row['misc3'],
            'misc4'         =>  $row['misc4'],
            'misc5'         =>  $row['misc5'],
            'event_id'      =>  $this->event_id
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
