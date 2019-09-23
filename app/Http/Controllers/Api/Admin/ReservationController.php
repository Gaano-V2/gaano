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

use App\User;
use App\Reservation;
use App\Walkin;
use App\Vehicle;

class ReservationController extends Controller {

    public function __construct() {

        $this->middleware('jsonwebtokenadmin');

    }

    private function decode_id($id) {

        $hashids = new Hashids('Gaano', 10);

        return $hashids->decode($id);

    }

    private function return_val($id) {

        $reservation = Reservation::with('customer_walkin', 'user_reserve', 'vehicle_reserve')->whereId($id)->first();

        return $reservation;

    }

    public function all() {

        $reservations = Reservation::with('customer_walkin', 'user_reserve', 'vehicle_reserve')->orderBy('created_at', 'desc')->paginate(1);

        return response()->json($reservations, 200);

    }

    public function vehicle_by_date(Request $request) {

        $start = $request->start;
        $end = $request->end;

        $vehicles = Vehicle::where(function($que) use($start, $end) {

            $que->whereDoesntHave('on_reserve', function($que) use($start, $end) {

                $que->where('status', 1);

                $que->where(function($que) use($start, $end) {

                    $que->where('start_date', '>=', Carbon::parse($start)->format('Y/m/d'));
                    $que->where('start_date', '<', Carbon::parse($end)->format('Y/m/d'));

                });

                $que->where(function($que) use($start, $end) {

                    $que->where('start_date', '>', Carbon::parse($start)->format('Y/m/d'));
                    $que->where('start_date', '<=', Carbon::parse($end)->format('Y/m/d'));

                });

                $que->orWhere(function($que) use($start, $end) {

                    $que->where('end_date', '>', Carbon::parse($start)->format('Y/m/d'));
                    $que->where('end_date', '<=', Carbon::parse($end)->format('Y/m/d'));

                });

                $que->orWhere(function($que) use($start, $end) {

                    $que->where('end_date', '>=', Carbon::parse($start)->format('Y/m/d'));
                    $que->where('end_date', '<', Carbon::parse($end)->format('Y/m/d'));

                });

                $que->where(function($que) use($start, $end) {

                    $que->where('end_date', '<=', Carbon::parse($start)->format('Y/m/d'));
                    $que->where('end_date', '>', Carbon::parse($end)->format('Y/m/d'));

                });

                $que->orWhere(function($que) use($start, $end) {

                    $que->where('start_date', '<=', Carbon::parse($start)->format('Y/m/d'));
                    $que->where('end_date', '>', Carbon::parse($end)->format('Y/m/d'));

                });

                $que->orWhere(function($que) use($start, $end) {

                    $que->where('start_date', '>=', Carbon::parse($start)->format('Y/m/d'));
                    $que->where('end_date', '<', Carbon::parse($end)->format('Y/m/d'));

                });


                $que->orWhere(function($que) use($start, $end) {

                    $que->where('start_date', '>=', Carbon::parse($start)->format('Y/m/d'));
                    $que->where('end_date', '<=', Carbon::parse($end)->format('Y/m/d'));

                });

                $que->orWhere(function($que) use($start, $end) {

                    $que->where('start_date', '<=', Carbon::parse($end)->format('Y/m/d'));
                    $que->where('end_date', '>=', Carbon::parse($start)->format('Y/m/d'));

                });

            });

        })->get();

        return response()->json($vehicles, 200);

    }

    public function search(Request $request) {

        $walkin = $request->walkin;

        $start_date = $request->start_date;

        $end_date = $request->end_date;

        $fname = $request->fname;

        $mname = $request->mname;

        $lname = $request->lname;

        $email = $request->email;

        $vehicle = $request->vehicle;

        $brand = $request->brand;

        $status = $request->status;


        $reservations = Reservation::with('customer_walkin', 'user_reserve', 'vehicle_reserve')->where(function($que)
        use($walkin, $start_date, $end_date, $fname, $mname, $lname, $email, $vehicle, $brand, $status) {

            if($start_date !== 'null' && $end_date !== 'null') {

                $que->whereBetween('start_date', [$start_date, $end_date]);
                $que->WhereBetween('end_date', [$start_date, $end_date]);

            }

            if($status !== 'null') {

                $que->where('status', $status);

            }

            if($walkin === 'false') {

                if($fname !== 'null' || $mname !== 'null' || $lname !== 'null' || $email !== 'null') {

                    $que->whereHas('user_reserve.profile', function($que) use($fname, $mname, $lname, $email) {

                        if($fname !== 'null') {
                            $que->where('fname', 'LIKE', '%' . $fname . '%');
                        }

                        if($mname !== 'null') {
                            $que->where('mname', 'LIKE', '%' . $mname. '%');
                        }

                        if($lname !== 'null') {
                            $que->where('lname', 'LIKE', '%' . $lname . '%');
                        }

                        if($email !== 'null') {
                            $que->where('email', 'LIKE', '%' . $email . '%');
                        }


                    });

                }


            } else {

                if($fname !== 'null' || $mname !== 'null' || $lname !== 'null' || $email !== 'null') {

                    $que->whereHas('customer_walkin', function($que) use($fname, $mname, $lname, $email) {

                      if($fname !== 'null') {
                          $que->where('fname', 'LIKE', '%' . $fname . '%');
                      }

                      if($mname !== 'null') {
                          $que->where('mname', 'LIKE', '%' . $mname. '%');
                      }

                      if($lname !== 'null') {
                          $que->where('lname', 'LIKE', '%' . $lname . '%');
                      }

                      if($email !== 'null') {
                          $que->where('email', 'LIKE', '%' . $email . '%');
                      }

                    });

                }

            }

            if($vehicle !== 'null' || $brand !== 'null') {

                $que->whereHas('vehicle_reserve', function($que) use($vehicle, $brand) {

                    if($vehicle !== 'null') {
                        $que->where('name', 'LIKE', '%' . $vehicle . '%');
                    }

                    if($brand !== 'null') {
                        $que->where('brand', 'LIKE', '%' . $brand . '%');
                    }


                });

            }

        })->orderBy('created_at', 'desc')->paginate(1);

        return response()->json($reservations, 200);

    }

    public function create(Request $request) {

        $request->validate([
            'email' => ['required', 'email', 'max:150'],
            'fname' => ['required', 'string', 'max:150'],
            'mname' => ['max:150'],
            'lname' => ['required', 'string', 'max:150'],
            'gender' => ['required', 'max:2'],
            'bday' => ['required', 'string', 'before:-18 years', 'max:15'],
            'phone' => ['required', 'string', 'max:12'],
        ]);

        $new_reservation = new Reservation();
        $new_reservation->vehicle_id = $request->vehicle_id;
        $new_reservation->start_date = $request->start_date;
        $new_reservation->end_date = $request->end_date;
        $new_reservation->time = $request->time;
        $new_reservation->is_walkin = true;
        $new_reservation->save();

        if ($new_reservation->save()) {

            $new_walkin = new Walkin();
            $new_walkin->reservation_id = $new_reservation->id;
            $new_walkin->email = $request->email;
            $new_walkin->fname = $request->fname;
            $new_walkin->mname = $request->mname;
            $new_walkin->lname = $request->lname;
            $new_walkin->gender = $request->gender;
            $new_walkin->phone = $request->phone;
            $new_walkin->bday = $request->bday;

            if($request->hasFile('government_id')) {

                request()->validate([
                      'government_id' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg'],
                ]);

                $file_data = $request->file('government_id');

                $file_name = Storage::disk('public')->put('government', $file_data);

                $new_walkin->government_id = $file_name;
            }

            if($request->hasFile('license')) {

                request()->validate([
                      'license' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg'],
                ]);

                $file_data = $request->file('license');

                $file_name = Storage::disk('public')->put('license', $file_data);

                $new_walkin->license = $file_name;
            }

            if ($new_walkin->save() === false) {

                $delete_reservation = Reservation::whereId($new_reservation->user_id)->first();
                $delete_reservation->save();

                return response()->json("Something went wrong", 401);
            }

            $new_walkin->save();

        }

        return response()->json($this->return_val($new_reservation->id), 201);

    }

    public function read($id) {

        $decode = $this->decode_id($id);

        return response()->json($this->return_val($decode[0]), 200);

    }

    public function update_dates(Request $request) {

        $decode = $this->decode_id($request->reservationid);

        $reservation = Reservation::whereId($decode[0])->first();
        $reservation->start_date = $request->start;
        $reservation->end_date = $request->end;
        $reservation->time = $request->time;
        $reservation->save();

        return response()->json($reservation, 200);


    }

    public function update_vehicle(Request $request) {

        $decode = $this->decode_id($request->reservationid);

        $reservation = Reservation::select(['id'])->whereId($decode[0])->first();
        $reservation->vehicle_id = $request->vehicleid;
        $reservation->save();

        $new_val = Reservation::whereId($reservation->id)->with('vehicle_reserve')->first();

        return response()->json($new_val, 200);

    }

    public function update_walkin(Request $request) {

      return $request->all();

        $walkin = Walkin::whereId($request->walkinid)->first();
        $walkin->email = $request->email;
        $walkin->fname = $request->fname;
        $walkin->mname = $request->mname;
        $walkin->lname = $request->lname;
        $walkin->gender = $request->gender;
        $walkin->bday = $request->bday;
        $walkin->phone = $request->phone;
        $walkin->save();

        return response()->json($walkin, 200);

    }

    public function delete($id) {

    }

    public function update_status_reservation(Request $request) {

        $decode = $this->decode_id($request->reservationid);

        $reservation = Reservation::whereId($decode[0])->first();
        $reservation->status = $request->status;
        $reservation->save();

        switch ($request->status) {

            case 1:

                $current_id = $reservation->id;
                $vehicle = $reservation->vehicle_id;
                $start = $reservation->start_date;
                $end = $reservation->end_date;

                $pending_reservation = Reservation::where(function($que) use($current_id, $vehicle, $start, $end)  {

                    $que->where('id', '!=', $current_id);

                    $que->where('vehicle_id', $vehicle);

                    $que->where('status', 0);

                    $que->where(function($que) use($start, $end) {

                      $que->where(function($que) use($start, $end) {

                          $que->where('start_date', '>=', Carbon::parse($start)->format('Y/m/d'));
                          $que->where('start_date', '<', Carbon::parse($end)->format('Y/m/d'));

                      });

                      $que->where(function($que) use($start, $end) {

                          $que->where('start_date', '>', Carbon::parse($start)->format('Y/m/d'));
                          $que->where('start_date', '<=', Carbon::parse($end)->format('Y/m/d'));

                      });

                      $que->orWhere(function($que) use($start, $end) {

                          $que->where('end_date', '>', Carbon::parse($start)->format('Y/m/d'));
                          $que->where('end_date', '<=', Carbon::parse($end)->format('Y/m/d'));

                      });

                      $que->orWhere(function($que) use($start, $end) {

                          $que->where('end_date', '>=', Carbon::parse($start)->format('Y/m/d'));
                          $que->where('end_date', '<', Carbon::parse($end)->format('Y/m/d'));

                      });

                      $que->where(function($que) use($start, $end) {

                          $que->where('end_date', '<=', Carbon::parse($start)->format('Y/m/d'));
                          $que->where('end_date', '>', Carbon::parse($end)->format('Y/m/d'));

                      });

                      $que->orWhere(function($que) use($start, $end) {

                          $que->where('start_date', '<=', Carbon::parse($start)->format('Y/m/d'));
                          $que->where('end_date', '>', Carbon::parse($end)->format('Y/m/d'));

                      });

                      $que->orWhere(function($que) use($start, $end) {

                          $que->where('start_date', '>=', Carbon::parse($start)->format('Y/m/d'));
                          $que->where('end_date', '<', Carbon::parse($end)->format('Y/m/d'));

                      });


                      $que->orWhere(function($que) use($start, $end) {

                          $que->where('start_date', '>=', Carbon::parse($start)->format('Y/m/d'));
                          $que->where('end_date', '<=', Carbon::parse($end)->format('Y/m/d'));

                      });

                      $que->orWhere(function($que) use($start, $end) {

                          $que->where('start_date', '<=', Carbon::parse($end)->format('Y/m/d'));
                          $que->where('end_date', '>=', Carbon::parse($start)->format('Y/m/d'));

                      });

                    });

                })->update(['status' => 2]);

                break;

            case 3:

                $reservation = Reservation::whereId($reservation->id)->first();
                $reservation->total = $request->total;
                $reservation->save();

                break;

            default:
                echo "None";

        }

        return response()->json($reservation, 200);

    }

    public function get_vehicle_reservations($id, $key) {

        $reservation_dates = [];

        $decode = $this->decode_id($id);
        $decode_key = $this->decode_id($key);

        $reservations = Reservation::where(function($que) use($decode) {
            $que->where('vehicle_id', $decode[0]);
            $que->where('status', 1);
        })->select(['id', 'start_date', 'end_date'])->get();

        foreach ($reservations as $reservation) {

            if($decode_key[0] !== $reservation->id) {

                $date_from = strtotime($reservation->start_date);
                $date_to = strtotime($reservation->end_date);

                for ($i=$date_from; $i<=$date_to; $i+=86400) {
                    array_push($reservation_dates, date("Y-m-d", $i));
                }

            }

        }

        return response()->json($reservation_dates, 200);

    }

    public function near_date_reservation(Request $request) {

        $inserted_date = $request->start;

        $vehicleid = $request->vehicleid;

        $reservationid = $this->decode_id($request->reservationid)[0];

        $reservation = Reservation::where(function($que) use($reservationid, $vehicleid, $inserted_date) {

            $que->whereNotIn('id', [$reservationid]);
            $que->where('status', 1);
            $que->where('vehicle_id', $vehicleid);
            $que->where('start_date', '>=', $inserted_date);

        })->select(['id', 'start_date'])->orderBy('start_date', 'asc')->first();

        return response()->json($reservation, 200);


    }

}
