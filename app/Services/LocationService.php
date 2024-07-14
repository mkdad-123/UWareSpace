<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LocationService
{

    public function getCoordinatedLocation($address): bool|array
    {

        $response = Http::withOptions(['verify' => false])
            ->get("https://nominatim.openstreetmap.org/search", [
                'q' => $address,
                'format' => 'json'
            ]);

        if ($response->successful()) {
            $locationData = $response->json();
            if(! empty($locationData)){
                $latitude = $locationData[0]['lat'];
                $longitude = $locationData[0]['lon'];
                return [
                    "address" => $address,
                    "latitude" =>  $latitude,
                    "longitude" => $longitude
                ];
            }
        }

        return false;
    }

    public function transformAddress($location)
    {
        $country = $location['country'];
        $city = $location['city'];
        $region = $location['region'];
        $address = $region . ',' . $city . ',' . $country;

        if (array_key_exists('street', $location)){

            $street = $location['street'];
            $address = $street . ',' . $address;
            }

        return $this->getCoordinatedLocation($address);
    }

}
