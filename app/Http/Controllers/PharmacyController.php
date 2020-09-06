<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PharmacyController extends Controller
{
    public function getSpots(Request $request)
    {
        $pharmacies = Redis::georadius('pharmacies', $request->get('latitude'), $request->get('longitude'), $request->get('radius'), 'm');

        $result = [];

        foreach ($pharmacies as $pharmacy) {
            $pharmacy = unserialize($pharmacy);
            $pharmacy = array_merge($pharmacy, $pharmacy['stock_information']);
            unset($pharmacy['id'], $pharmacy['stock_information'], $pharmacy['created_at'], $pharmacy['updated_at']);
            $result[] = $pharmacy;
        }

        return response()->json($result);
    }
}
