<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Hashids\Hashids;

use App\Vehicle;

class VehicleController extends Controller {

    public function __construct() {

        $this->middleware('jsonwebtokenadmin');

    }

    private function decode_id($id) {

        $hashids = new Hashids('Gaano', 10);

        return $hashids->decode($id);

    }

    public function trymid() {

        return response()->json('Working', 200);

    }

    public function all() {

        $vehicles = Vehicle::orderBy('created_at', 'desc')->get();

        return response()->json($vehicles, 200);

    }

    public function search(Request $request) {

        $brand = $request->brand;
        $name = $request->name;
        $seat = $request->seats;
        $gas = $request->gas;
        $transmission = $request->transmission;

        $vehicles = Vehicle::where(function($que) use($brand, $name, $seat, $gas, $transmission) {

            if($brand !== null) {

                $que->where('brand', 'like', '%' . $brand . '%');

            }

            if($name !== null) {

                $que->where('name', 'like', '%' . $name . '%');

            }

            if($seat !== null) {

                $que->where('seats', $seat);

            }

            if($gas !== null) {

                $que->where('gas', $gas);

            }

            if($transmission !== null) {

                $que->where('transmission', $transmission);

            }

        })->get();

        return response()->json($vehicles, 200);

    }

    public function create(Request $request) {

        request()->validate([
              'image' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg'],
              'brand' => ['required', 'string', 'max:255'],
              'name' => ['required', 'string', 'max:255'],
              'seats' => ['required', 'integer'],
              'd_price' => ['required', 'string'],
              'w_price' => ['required', 'string'],
              'm_price' => ['required', 'string'],
              'gas' => ['required', 'integer'],
              'transmission' => ['required', 'integer'],

        ]);

        $file_data = $request->file('image');

        $file_name = Storage::disk('public')->put('vehicle', $file_data);

        $new_vehicle = new Vehicle();
        $new_vehicle->image = $file_name;
        $new_vehicle->brand = $request->brand;
        $new_vehicle->name = $request->name;
        $new_vehicle->seats = $request->seats;
        $new_vehicle->d_price = $request->d_price;
        $new_vehicle->w_price = $request->w_price;
        $new_vehicle->m_price = $request->m_price;
        $new_vehicle->gas = $request->gas;
        $new_vehicle->transmission = $request->transmission;
        $new_vehicle->save();

        if ($new_vehicle->save() == false) {

            Storage::disk('public')->delete($file_name);

            return response()->json("Something Went Wrong", 400);

        }

        return response()->json($new_vehicle, 200);

    }

    public function read($id) {

        $decode = $this->decode_id($id);

        $vehicle = Vehicle::whereId($id)->first();

        return response()->json($vehicle, 200);

    }

    public function update(Request $request) {

        request()->validate([
              'brand' => ['required', 'string', 'max:255'],
              'name' => ['required', 'string', 'max:255'],
              'seats' => ['required', 'integer'],
              'd_price' => ['required', 'string'],
              'w_price' => ['required', 'string'],
              'm_price' => ['required', 'string'],
              'gas' => ['required', 'integer'],
              'transmission' => ['required', 'integer'],
        ]);

        $image_has = false;

        $vehicle = Vehicle::whereId($request->vehicleid)->first();

        $current_image = $vehicle->image;

        if($request->hasFile('image')) {

            request()->validate([
                  'image' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg'],
            ]);

            $file_data = $request->file('image');

            $file_name = Storage::disk('public')->put('vehicle', $file_data);

            $vehicle->image = $file_name;

            $image_has = true;

        }

        $vehicle->brand = $request->brand;
        $vehicle->name = $request->name;
        $vehicle->seats = $request->seats;
        $vehicle->d_price = $request->d_price;
        $vehicle->w_price = $request->w_price;
        $vehicle->m_price = $request->m_price;
        $vehicle->gas = $request->gas;
        $vehicle->transmission = $request->transmission;
        $vehicle->save();

        if ($vehicle->save() && $image_has) {

            Storage::disk('public')->delete($current_image);

        }

        return response()->json($vehicle, 200);

    }

    public function delete($id) {

        $vehicle = Vehicle::whereId($id)->first();

        Storage::disk('public')->delete($vehicle->image);

        $vehicle->delete();

        return response()->json('Vehicle has been removed', 200);

    }

}
