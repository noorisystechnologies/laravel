<?php

namespace Noorisys\PaypalSubscription\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Noorisys\PaypalSubscription\Models\Plans;
use Noorisys\PaypalSubscription\Models\Subscriptions;
use Noorisys\PaypalSubscription\Models\User;
use function Noorisys\PaypalSubscription\Helpers\generateInvoicePdf;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
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

    public function subscribe(Request $request)
    {
        // Input validation
        $validator = Validator::make($request->all(), [
            'language' => [
                'required' ,
                Rule::in(['en','hi','ur','bn','ar','in','ms','tr','fa','fr','de','es']),
            ],
            'user_id'   => 'required||numeric',
            'plan_id' =>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.Validation Failed!'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            // set return and cancel urls
            $return_url = url('api/success');
            $cancel_url = url('api/cancel');

            // Check if the user exists in the database, if not throw error
            $user = User::where('id', '=', $request->user_id)->first();
            if (empty($user)) {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.User Not Found!'),
                ],400);
            }

            // Check if the plan exists, if not throw error
            $plan_id = $request->plan_id;
            $plan = Plans::where('plan_id', '=', $plan_id)->first();
            if (empty($plan)) {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.Invalid Plan!'),
                ],400);
            }

            // Call the provider and add the product, daily plan and setup subscription
            $response = $this->provider->addProductById($plan->product_id)
                                        ->addBillingPlanById($plan->plan_id)
                                        ->setReturnAndCancelUrl($return_url, $cancel_url)
                                        ->setupSubscription($user->name, $user->email, Carbon::now()->addMinutes(5));
            
            // Check the response and redirect to the approval page if successful
            if ($response && !empty($response)) {
                $data = [
                    'user_id'   => $request->user_id,
                    'paypal_url' => $response['links'][0]['href'],
                    'subscription_id' => $response['id'],
                    'plan_id'   => $plan->plan_id,
                    'plan_name' => $plan->name,
                    'currency'  => $plan->currency,
                    'price'     => $plan->price,
                    'status'    => $response['status'],
                    'created_at' => Carbon::now()	
                ];

                // insert subscription details in subscription table
                $insert = Subscriptions::insert($data);

                if ($insert) {
                    return response()->json([
                        'status'    => 'success',
                        'message'   => trans('msg.Subscription Created!'),
                        'data'      => $response
                    ],200);
                } else {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => trans('msg.error'),
                    ],400);
                }
            }else{
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.Unable to Subscribe, Please Try again...'),
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

    public function success(Request $request)
    {
        // Input validation
        $validator = Validator::make($request->all(), [
            'language' => [
                'required' ,
                Rule::in(['en','hi','ur','bn','ar','in','ms','tr','fa','fr','de','es']),
            ],
            'subscription_id'   => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.Validation Failed!'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
             
            $subscription_id = $request->subscription_id;

            // retrive subscription details
            $response = $this->provider->showSubscriptionDetails($subscription_id);

            if (!empty($response) && $response['status'] == 'ACTIVE') {

                // upadate subscription details in table
                $data = [
                    'status' => $response['status'],
                    'start_date' => date('Y-m-d h:i:s',strtotime($response['start_time'])),
                    'end_date'   => date('Y-m-d h:i:s',strtotime($response['billing_info']['next_billing_time'])),
                    'updated_at' => Carbon::now()
                ];

                $update = Subscriptions::where('subscription_id', '=', $subscription_id)->update($data);

                if ($update) {
                    return response()->json([
                        'status'    => 'success',
                        'message'   => trans('msg.Subscription Succesful!'),
                    ],200);
                } else {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => trans('msg.error'),
                    ],400);
                }
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.error'),
                    'data'      => $response['links']
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

    public function cancel(Request $request)
    {
        // Input validation
        $validator = Validator::make($request->all(), [
            'language' => [
                'required' ,
                Rule::in(['en','hi','ur','bn','ar','in','ms','tr','fa','fr','de','es']),
            ],
            'subscription_id'   => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.Validation Failed!'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            
            $subscription_id = $request->subscription_id;

            // retrive subscription details
            $response = $this->provider->showSubscriptionDetails($subscription_id);

            if (!empty($response) && $response['status'] == 'APPROVAL_PENDING') {

                // cancel subscription
                // $cancel = $this->provider->cancelSubscription($subscription_id, 'cancel');
                // return $cancel;

                // upadate subscription details in table
                $data = [
                    'status' => 'CANCELED',
                ];

                $update = Subscriptions::where('subscription_id', '=', $subscription_id)->update($data);

                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.Subscription Canceled'),
                ],400);
                
            } elseif(!empty($response) && $response['status'] == 'ACTIVE') {
                // if subscription is already activated, throw error
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.Already Subscribed'),
                ],400);
            }else{
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.error'),
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

    public function webhook(Request $request)
    {
        // Get the request payload from the incoming webhook request
        $payload = json_decode($request->getContent(), true);

        switch ($payload['event_type']) {
            case 'PAYMENT.SALE.COMPLETED':
                $subscriptionId = $payload['resource']['billing_agreement_id'];
                $response = $this->provider->showSubscriptionDetails($subscriptionId);
                $subscription = Subscriptions::where('subscription_id', $subscriptionId)->first();

                if ($subscription) {
                    $data = [
                        'status' => $response['status'],
                        'start_date' => date('Y-m-d h:i:s',strtotime($response['update_time'])),
                        'end_date'   => date('Y-m-d h:i:s',strtotime($response['billing_info']['next_billing_time'])),
                        'updated_at' => Carbon::now()
                    ];

                    $update = Subscriptions::where('subscription_id', '=', $subscriptionId)->update($data);
                    if ($update) {
                        $user = User::find($subscription->user_id);
                        $invoice_data = [
                            'subscription_id' => $subscriptionId,
                            'invoice_number' => (string)rand(10000, 20000),
                            'user_name' => $user ? $user->name : '',
                            'user_email' => $user ? $user->email : '',
                            'plan_name' => $subscription->plan_name,
                            'plan_price' => $subscription->price,
                            'start_date' => date('d M Y',strtotime($response['update_time'])),
                            'end_date'   => date('d M Y',strtotime($response['billing_info']['next_billing_time'])),
                            'amount_paid' => $subscription->price,
                            'currency' => $subscription->currency,
                        ];
                        generateInvoicePdf($invoice_data);
                    }
                }
                break;
            case 'BILLING.SUBSCRIPTION.UPDATED':
                $subscriptionId = $payload['resource']['id'];
                $subscription = Subscriptions::where('subscription_id', $subscriptionId)->first();

                if ($subscription) {
                    $status = $payload['resource']['status'];
                    $start_date = $payload['resource']['update_time'];
                    $end_date = $payload['resource']['next_billing_time'];

                    if ($status === 'SUSPENDED' || $status === 'CANCELLED') {
                        $subscription->status = $status;
                        $subscription->save();
                    }

                    if ($status === 'ACTIVE') {
                        $subscription->status = $status;
                        $subscription->start_date = $start_date;
                        $subscription->end_date = $end_date;
                        $subscription->save();
                    }
                }
                break;

            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $payload['event_type'];
        }

        http_response_code(200);
    }
}
