<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Hashids\Hashids;
use Carbon\Carbon;
use DB;
use App\Quotation;

use App\Repair;

class RepairController extends Controller {

    public function __construct() {

        $this->middleware('jsonwebtokenadmin');

    }

    private function decode_id($id) {

        $hashids = new Hashids('Gaano', 10);

        return $hashids->decode($id);

    }

    public function all() {

        $repairs = Repair::orderBy('created_at', 'desc')->get();

        return response()->json($repairs, 200);

    }

    public function create(Request $request) {

        $decode_id = $this->decode_id($request->vehicleid);

        $new_repair = new Repair();
        $new_repair->vehicle_id = $decode_id;
        $new_repair->report = $request->report;
        $new_repair->save();

        return response()->json($new_repair, 201);
    }

    public function update_status(Request $request) {

        $decode_id = $this->decode_id($request->vehicleid);

        $repair = Repair::whereId($decode_id)->first();
        $repair->status = $request->status;
        $repair->save();

        return response()->json($repair, 200)

    }

}
