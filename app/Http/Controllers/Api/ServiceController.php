<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Provider;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->get();
        return response()->json(['services' => $services], 200);
    }

    public function show($id)
    {
        $service = Service::with('category')->findOrFail($id);
        return response()->json(['service' => $service], 200);
    }
    public function providersByService(Request $request)
    {
        $serviceName = $request->input('service_name');

        $providers = Provider::whereHas('service', function ($query) use ($serviceName) {
            $query->where('name', 'like', '%' . $serviceName . '%');
        })->orWhereHas('service.category', function ($query) use ($serviceName) {
            $query->where('name', 'like', '%' . $serviceName . '%');
        })->get();
        

        return response()->json(['providers' => $providers], 200);
    }

    public function providerDetails($id)
    {
        $provider = Provider::with('service.category')->findOrFail($id);
        return response()->json(['provider' => $provider], 200);
    }
    public function providersNearMe(Request $request)
    {
        $userAddress = $request->input('user_address');

        // Geocode user address to get latitude and longitude
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $userAddress,
            'key' => 'YOUR_GOOGLE_MAPS_API_KEY',
        ]);

        $data = $response->json();

        if ($data['status'] === 'OK') {
            $location = $data['results'][0]['geometry']['location'];
            $userLat = $location['lat'];
            $userLng = $location['lng'];

            // Dummy logic to find nearby providers within 10km radius
            $nearbyProviders = Provider::select('*')
                ->selectRaw('(6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) AS distance', [$userLat, $userLng, $userLat])
                ->having('distance', '<', 10) // 10km radius
                ->get();

            return response()->json(['providers' => $nearbyProviders], 200);
        }

        return response()->json(['error' => 'Geocoding failed'], 500);
    }

    public function getProvidersNearMe(Request $request)
{
    $pincode = $request->input('zipcode');

    // Find providers matching the given pincode
    $providers = Provider::where('zipcode', $pincode)->get();

    return response()->json(['providers' => $providers], 200);
}

}
