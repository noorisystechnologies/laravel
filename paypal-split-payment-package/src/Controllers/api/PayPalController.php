<?php

namespace Noorisys\PaypalSplitPayment\Controllers\api;

use App\Http\Controllers\Controller;
use Noorisys\PaypalSplitPayment\Models\Bookings;
use Illuminate\Http\Request;

use Noorisys\PaypalSplitPayment\Models\Products;
use Noorisys\PaypalSplitPayment\Models\Payouts;
use Noorisys\PaypalSplitPayment\Models\Transactions;
use Noorisys\PaypalSplitPayment\Models\User;
use function Noorisys\PaypalSplitPayment\Helpers\generateInvoicePdf;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    private $provider;

    public function __construct() {
        // Multiligual
        $lang = (isset($_POST['language']) && !empty($_POST['language'])) ? $_POST['language'] : 'en';
        App::setlocale($lang);

        // Set the API credentials
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $paypalToken = $this->provider->getAccessToken();
    }

    public function createPayout(Request $request)
    {
        // Input validation
        $validator = Validator::make($request->all(), [
            'language' => [
                'required' ,
                Rule::in(['en','hi','ur','bn','ar','in','ms','tr','fa','fr','de','es']),
            ],
            'user_id'   => 'required||numeric',
            'product_id' =>'required',
            'unit_amount'     => 'required',
            'quantity'   => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.Validation Failed!'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            $user_id = $request->user_id;
            $product_id = $request->product_id;
            $unit_amount = $request->unit_amount;
            $quantity = $request->quantity;

            $paid_amount = $unit_amount * $quantity;
            $commission = ($paid_amount) * 0.2;
            $unit_commission = $unit_amount * 0.2;

            // Fetch a Product object based on the given 'product_id' from the 'Products' model
            $product = Products::where('id', '=', $product_id)->first();
            
            // if product does not exists, throw an erorr
            if (!$product || empty($product)) {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.paypal.order.invalid'),
                ],400);
            }
          
            // Fetch a user based on the given 'user_id' from the 'Users' model
            $user = User::where('id', '=', $user_id)->first();

            // if user does not exists, throw an erorr
            if (!$user || empty($user)) {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.paypal.order.not-found'),
                ],400);
            }

            // Set the success and cancel URLs for the checkout session
            $return_url = url('api/paypal/paymentSuccess');
            $cancel_url = url('api/paypal/paymentFail');

            // Create an order for multi-seller payments
            $data = array(
                'intent' => 'CAPTURE',
                'application_context' => array(
                    "return_url" => $return_url,
                    "cancel_url" => $cancel_url,
                ),
                'purchase_units' => array(
                    array(
                        'reference_id'=> "Seller-1",
                        'amount' => array(
                            'currency_code' => 'USD',
                            'value' => ($unit_amount - $unit_commission) * $quantity,
                            'breakdown' => array(
                                'item_total' => array(
                                    'currency_code' => 'USD',
                                    'value' => ($unit_amount - $unit_commission) * $quantity
                                )
                            )
                        ),
                        'payee' => array(
                            'email_address' => 'javeriya@business.example.com'
                        ),
                        'items' => array(
                            array(
                                "name" => $product->name,
                                "description" => "Product description",
                                'unit_amount' => array(
                                    'currency_code' => 'USD',
                                    'value' => $unit_amount - $unit_commission
                                ),
                                'quantity' => $quantity,
                            )
                        )
                    ),
                    array(
                        'reference_id'=> "Seller-2",
                        'amount' => array(
                            'currency_code' => 'USD',
                            'value' => $unit_commission * $quantity,
                            'breakdown' => array(
                                'item_total' => array(
                                    'currency_code' => 'USD',
                                    'value' => $unit_commission * $quantity
                                )
                            )
                        ),
                        'payee' => array(
                            'email_address' => 'javeriya.noorisys@business.example.com'
                        ),
                        'items' => array(
                            array(
                                "name" => $product->name,
                                "description" => "Product description",
                                'unit_amount' => array(
                                    'currency_code' => 'USD',
                                    'value' => $unit_commission
                                ),
                                'quantity' => $quantity,
                            )
                        )
                    )
                )
            );
            
            $response = $this->provider->createOrder($data);

            if (isset($response['id']) && $response['id'] != null && $response['status'] == 'CREATED') {
                $booking_data = [
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'order_id' => $response['id'],
                    'product_price' => $product->price,
                    'currency' => 'USD',
                    'quantity' => $quantity,
                    'amount_paid' => $unit_amount * $quantity,
                    'created_at' => Carbon::now(),
                ];

                // Insert the data into the Bookings and Transactions tables
                $booking_id = Bookings::insertGetId($booking_data);
                
                if($booking_id){
                    return response()->json([
                        'status'    => 'success',
                        'message'   => trans('msg.paypal.order.success'),
                        'data'      => $response['links'][1]
                    ],200);
                }else{
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => trans('msg.paypal.order.failure'),
                    ],400);
                }
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.paypal.order.failure'),
                ],400);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        // Input validation
        $validator = Validator::make($request->all(), [
            'language' => [
                'required' ,
                Rule::in(['en','hi','ur','bn','ar','in','ms','tr','fa','fr','de','es']),
            ],
            'token'   => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.Validation Failed!'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            $token = $request->token;

            // get booking details from database
            $booking = Bookings::where('order_id', '=', $token)->first();

            // capture payment using order_id (token)
            $order = $this->provider->capturePaymentOrder($token);

            if (!empty($order) && $order['status'] == 'COMPLETED') {
                
                // update booking status
                $booking_data = [
                    'status' => 'completed',
                    'updated_at' => Carbon::now(),
                ];
                Bookings::where('order_id', '=', $order['id'])->update($booking_data);

                // Insert the data into the Transactions table
                $trxn_data = [
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'order_id' => $booking->order_id,
                    'paypal_url' => $order['links'][0]['href'],
                    'product_id' => $booking->product_id,
                    'product_price' => $booking->product_price,
                    'quantity' => $booking->quantity,
                    'amount_paid' => $booking->amount_paid,
                    'currency' => $booking->currency,
                    'payment_status' => $order['status'],
                    'created_at' => Carbon::now(),
                ];
    
                $trxn = Transactions::insertGetId($trxn_data);

                // send invoice to customer
                $user = User::find($booking->user_id);

                // get product details
                $product = Products::where('id', '=', $booking->product_id)->first();

                $invoice_data = [
                    'trxn_id' => $trxn,
                    'invoice_number' => (string) rand('99999','999999'),
                    'user_name' => $user ? $user->name : '',
                    'user_email' => $user ? $user->email : '',
                    'product_name' => $product ? $product->name : '',
                    'product_price' => $product ? $product->price : '',
                    'quantity' => $booking->quantity,
                    'amount_paid' => $booking->amount_paid,
                    'currency' => $booking->currency,
                    'date' => Carbon::now()->format('d.m.Y')
                ];

               generateInvoicePdf($invoice_data);

                foreach ($order['purchase_units'] as $purchase_units) {
                    $payout_data = [
                        'receiver' => $purchase_units['reference_id'],
                        'capture_id' => $purchase_units['payments']['captures'][0]['id'],
                        'amount' => $purchase_units['payments']['captures'][0]['amount']['value'],
                        'currency' => $purchase_units['payments']['captures'][0]['amount']['currency_code'],
                        'status' => $purchase_units['payments']['captures'][0]['status'],
                        'created_at' => Carbon::now(),
                    ];
    
                    Payouts::insert($payout_data);
                }

                // update user_type in users table
                $user_data = [
                    'user_type'   => 'paid',
                    'updated_at'  => Carbon::now(),
                ];
                User::where('id', '=', $booking->user_id)->update($user_data);

                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.paypal.success'),
                ],200);
            }elseif (!empty($order) && $order['status'] == 'COMPLETED') {

                // check authorization status
                $auth_status = $order['purchase_units'][0]['payments']['authorizations'][0]['status'];
                if ($auth_status == 'CAPTURED') {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => trans('msg.paypal.paid'),
                    ],200);
                }else{
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => trans('msg.paypal.invalid'),
                    ],200);
                }
            }elseif (!empty($order) && $order['status'] == 'CREATED') {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.paypal.failure'),
                ],200);
            }else{
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.paypal.invalid'),
                ],200);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }

    public function paymentFail(Request $request)
    {
        // Input validation
        $validator = Validator::make($request->all(), [
            'language' => [
                'required' ,
                Rule::in(['en','hi','ur','bn','ar','in','ms','tr','fa','fr','de','es']),
            ],
            'token'   => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.Validation Failed!'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            $token = $request->token;

            // get booking details from database
            $booking = Bookings::where('order_id', '=', $token)->first();

            // capture order from paypal using order_id (token)
            $order = $this->provider->showOrderDetails($token);
            
            if (!empty($order) && $order['status'] == 'CREATED') {

                $trxn_data = [
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'order_id' => $booking->order_id,
                    'paypal_url' => $order['links'][0]['href'],
                    'product_id' => $booking->product_id,
                    'product_price' => $booking->product_price,
                    'quantity' => $booking->quantity,
                    'amount_paid' => $booking->amount_paid,
                    'currency' => $booking->currency,
                    'payment_status' => 'FAILED',
                    'created_at' => Carbon::now(),
                ];
    
                $trxn = Transactions::insertGetId($trxn_data);
    
                $booking_data = [
                    'status' => 'completed',
                    'updated_at' => Carbon::now(),
                ];

                Bookings::where('order_id', '=', $booking->order_id)->update($booking_data);

                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.paypal.failure'),
                ],400);
            }elseif (!empty($order) && $order['status'] == 'COMPLETED') {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.paypal.paid'),
                ],200);
            }else{
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.paypal.invalid'),
                ],200);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }
}
