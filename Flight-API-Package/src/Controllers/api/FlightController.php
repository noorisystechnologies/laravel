<?php
namespace Flight\Aerodatabox\Controllers\api;
use Flight\Aerodatabox\Services\AeroDataBoxService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class FlightController
{
    public function flight(Request $req)
    {
        $data = $req->only('searchby','parameter');
        $validator = Validator::make($data, [
            'searchby'   => 'required|string',//any no or string according to parameter
            'parameter' => 'required'//it should be a number,reg,callsign or icao24
            
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status'    => 'failed',
                    'errors'    =>  $validator->errors(),
                    'message'   =>  trans('validation.custom.input.invalid'),
                ],
                400
            );
        } 
        else
        {
            try
            {
                //Service class
                $AeroDataBoxService = new AeroDataBoxService;
                $searchby = $req->searchby;
                $parameter = $req->parameter;
                $flight_info = $AeroDataBoxService->getNearestFlight($searchby,$parameter);
                if($flight_info == null)
                {
                    return response()->json([
                        'status'  => 'failed',
                        'message' => trans('validation.custom.invalid.request'),
                    ],400);
                }
                else
                {
                    return response()->json([
                        'status'  => 'success',
                        'message' => trans('validation.custom.valid.request'),
                        'flight-info' => json_decode($flight_info)
                    ],200);
                }
            
            }
            catch (\Throwable $e)
            {
                return response()->json([
                    'status'  => 'failed',
                    'message' => trans('validation.custom.invalid.request'),
                    'error'   => $e->getMessage()
                ],500);
            }
        }

    }
    public function flightbyDate(Request $req)
    {
        $data = $req->only('searchby','parameter','date');
        $validator = Validator::make($data, [
            'searchby'   => 'required|string',
            'parameter' => 'required',
            'date' => 'required'
            
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status'    => 'failed',
                    'errors'    =>  $validator->errors(),
                    'message'   =>  trans('validation.custom.input.invalid'),
                ],
                400
            );
        } 
        else
        {
            try
            {
                //Service class
                $AeroDataBoxService = new AeroDataBoxService;
                $searchby = $req->searchby;
                $parameter = $req->parameter;
                $date = date('Y-m-d',strtotime($req->date));
                $flight_info = $AeroDataBoxService->getflightbyDate($searchby,$parameter,$date);
                if($flight_info == null)
                {
                    return response()->json([
                        'status'  => 'failed',
                        'message' => trans('validation.custom.invalid.request'),
                    ],400);
                }
                else
                {
                    return response()->json([
                        'status'  => 'success',
                        'message' => trans('validation.custom.valid.request'),
                        'flight-info' => json_decode($flight_info)
                    ],200);
                }
            
            }
            catch (\Throwable $e)
            {
                return response()->json([
                    'status'  => 'failed',
                    'message' => trans('validation.custom.invalid.request'),
                    'error'   => $e->getMessage()
                ],500);
            }
        }

    }
    public function flightdeparturedate(Request $req)
    {
        $data = $req->only('searchby','parameter','fromdate','todate');
        $validator = Validator::make($data, [
            'searchby'   => 'required|string',
            'parameter' => 'required',
            'fromdate' => 'required',
            'todate' => 'required'
            
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status'    => 'failed',
                    'errors'    =>  $validator->errors(),
                    'message'   =>  trans('validation.custom.input.invalid'),
                ],
                400
            );
        } 
        else
        {
            try
            {
                //Service class
                $AeroDataBoxService = new AeroDataBoxService;
                $searchby = $req->searchby;
                $parameter = $req->parameter;
                $fromdate = date('Y-m-d',strtotime($req->fromdate));
                $todate = date('Y-m-d',strtotime($req->todate));
                $flight_info = $AeroDataBoxService->departureDate($searchby,$parameter,$fromdate,$todate);
                if($flight_info == null)
                {
                    return response()->json([
                        'status'  => 'failed',
                        'message' => trans('validation.custom.invalid.request'),
                    ],400);
                }
                else
                {
                    return response()->json([
                        'status'  => 'success',
                        'message' => trans('validation.custom.valid.request'),
                        'flight-info' => json_decode($flight_info)
                    ],200);
                }
            
            }
            catch (\Throwable $e)
            {
                return response()->json([
                    'status'  => 'failed',
                    'message' => trans('validation.custom.invalid.request'),
                    'error'   => $e->getMessage()
                ],500);
            }
        }
    }
    public function delaybyflightno(Request $req)
    {
        $data = $req->only('flightno');
        $validator = Validator::make($data, [
            'flightno'   => 'required',
            
            
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status'    => 'failed',
                    'errors'    =>  $validator->errors(),
                    'message'   =>  trans('validation.custom.input.invalid'),
                ],
                400
            );
        } 
        else
        {
            try
            {
                //Service class
                $AeroDataBoxService = new AeroDataBoxService;
                $flightno = $req->flightno;
                $flight_info = $AeroDataBoxService->delaybyflightno($flightno);
                if($flight_info == null)
                {
                    return response()->json([
                        'status'  => 'failed',
                        'message' => trans('validation.custom.invalid.request'),
                    ],400);
                }
                else
                {
                    return response()->json([
                        'status'  => 'success',
                        'message' => trans('validation.custom.valid.request'),
                        'flight-info' => json_decode($flight_info)
                    ],200);
                }
            
            }
            catch (\Throwable $e)
            {
                return response()->json([
                    'status'  => 'failed',
                    'message' => trans('validation.custom.invalid.request'),
                    'error'   => $e->getMessage()
                ],500);
            }
        }
    }
    public function AirportDepArr(Request $req)
    {
        $data = $req->only('parameter','fromdate','todate');
        $validator = Validator::make($data, [
            'parameter'   => 'required',
            'fromdate' => 'required',
            'todate' => 'required'
            
            
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status'    => 'failed',
                    'errors'    =>  $validator->errors(),
                    'message'   =>  trans('validation.custom.input.invalid'),
                ],
                400
            );
        } 
        else
        {
            try
            {
                //Service class
                $AeroDataBoxService = new AeroDataBoxService;
                $parameter = $req->parameter;
                // $fromdate = \Carbon\Carbon::parse($req->fromdate)->format('YYYY-MM-DDThh:mm:ssTZD');
                // $todate = \Carbon\Carbon::parse($req->todate)->format('YYYY-MM-DDThh:mm:ssTZD');
                $fromdate = $req->fromdate;
                $todate = $req->todate;
                $flight_info = $AeroDataBoxService->airportDepartureArrival($parameter,$fromdate,$todate);
                if($flight_info == null)
                {
                    return response()->json([
                        'status'  => 'failed',
                        'message' => trans('validation.custom.invalid.request'),
                    ],400);
                }
                else
                {
                    return response()->json([
                        'status'  => 'success',
                        'message' => trans('validation.custom.valid.request'),
                        'flight-info' => json_decode($flight_info)
                    ],200);
                }
            
            }
            catch (\Throwable $e)
            {
                return response()->json([
                    'status'  => 'failed',
                    'message' => trans('validation.custom.invalid.request'),
                    'error'   => $e->getMessage()
                ],500);
            }
        }
    }
}