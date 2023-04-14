<?php
namespace Flight\Aerodatabox\Services;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class AeroDataBoxService
{

    public function getNearestFlight($searchby,$parameter)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://aerodatabox.p.rapidapi.com/flights/'.$searchby.'/'.$parameter, [
            'headers' => [
                'X-RapidAPI-Key' => env('RAPID_API_KEY'),
            ],
        ]);
        $data = $response->getBody()->getContents();
        return $data;
    }
    public function getflightbyDate($searchby,$parameter,$date)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://aerodatabox.p.rapidapi.com/flights/'.$searchby.'/'.$parameter.'/'.$date, [
            'headers' => [
                'X-RapidAPI-Key' => env('RAPID_API_KEY'),
            ],
        ]);
        $data = $response->getBody()->getContents();
        return $data;
    }
    public function departureDate($searchby,$parameter,$fromdate,$todate)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://aerodatabox.p.rapidapi.com/flights/'.$searchby.'/'.$parameter.'/dates'.'/'.$fromdate.'/'.$todate, [
            'headers' => [
                'X-RapidAPI-Key' => env('RAPID_API_KEY'),
            ],
        ]);
        $data = $response->getBody()->getContents();
        return $data;
    }
    public function delaybyflightno($flightno)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://aerodatabox.p.rapidapi.com/flights/'.$flightno.'/delays', [
            'headers' => [
                'X-RapidAPI-Key' => env('RAPID_API_KEY'),
            ],
        ]);
        $data = $response->getBody()->getContents();
        return $data;
    }
    public function airportDepartureArrival($parameter,$fromdate,$todate)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://aerodatabox.p.rapidapi.com/flights/airports/icao/'.$parameter.'/'.$fromdate.'/'.$todate, [
            'headers' => [
                'X-RapidAPI-Key' => env('RAPID_API_KEY'),
            ],
        ]);
        $data = $response->getBody()->getContents();
        return $data;
    }
}