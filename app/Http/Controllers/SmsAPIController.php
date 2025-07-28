<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use Illuminate\Http\Request;

class SmsAPIController extends Controller
{
    public function getDATA()
    {
        return response()->json(Sms::where('status', 'created')->first());
    }
    public function update($id, $status)
    {
        return Sms::where('id', $id)->update(['status'=>$status]);
    }    
}
