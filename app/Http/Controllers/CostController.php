<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class CostController extends Controller
{
    public function getcost(Request $request){

    	$client = new Client();
    	$response = $client->post('http://api.rajaongkir.com/starter/cost', [
            'headers' => ['key' => '2b26e8530127063ecd2dc55e60fea7e9'],
            'form_params' => [
            	'origin' => $request['origin'], 
            	'destination' => $request['destination'],
            	'weight' => $request['weight'],
            	'courier' => $request['courier']
            ]
          ])->getBody(TRUE);
    	$data = json_decode($response, true);
    	print_r ($data ['rajaongkir']['results'][0]['costs'][0]['service']);
    	//echo ($request['origin']);
    }
}
