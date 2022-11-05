<?php

namespace App\Models;

use App\Libs\StringLib;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    public static function pushDataContact($data_request = []){
        $contact = new Contact();
        $contact->fullname = $data_request['fullname'];
        $contact->phone = $data_request['phone'];
        $contact->support = $data_request['support'];
//        $contact->product = $data_request['product'];
        $contact->status = 1;
        $contact->created_at = time();
        $contact->access_token = sha1(uniqid('', true) . StringLib::random(35) . $data_request['fullname'] . microtime(true));
        $contact->save();

        return $contact;
    }
}