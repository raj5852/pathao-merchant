<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Xenon\MultiCourier\Provider\ECourier;
use Xenon\MultiCourier\Courier;

class OrderController extends Controller
{
    function index()
    {
        //place order


        $courier = Courier::getInstance();
        $courier->setProvider(ECourier::class, 'local'); /* local/production */
        $courier->setConfig([
            'API-KEY' => 'xxx',
            'API-SECRET' => 'xxx',
            'USER-ID' => 'xxx',
        ]);
        $orderData = array(
            'recipient_name' => 'XXXXX',
            'recipient_mobile' => '017XXXXX',
            'recipient_city' => 'Dhaka',
            'recipient_area' => 'Badda',
            'recipient_thana' => 'Badda',
            'recipient_address' => 'Full Address',
            'package_code' => '#XXXX',
            'product_price' => '1500',
            'payment_method' => 'COD',
            'recipient_landmark' => 'DBBL ATM',
            'parcel_type' => 'BOX',
            'requested_delivery_time' => '2019-07-05',
            'delivery_hour' => 'any',
            'recipient_zip' => '1212',
            'pick_hub' => '18490',
            'product_id' => 'DAFS',
            'pick_address' => 'Gudaraghat new mobile',
            'comments' => 'Please handle carefully',
            'number_of_item' => '3',
            'actual_product_price' => '1200',
            'pgwid' => 'XXX',
            'pgwtxn_id' => 'XXXXXX'
        );

        $courier->setParams($orderData);
        $response = $courier->placeOrder();
    }
}
