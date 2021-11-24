<?php

namespace App\Http\Controllers;

use App\Models\Recharge;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class RechargeController extends Controller
{
    //
    public function index() {
        return view('recharge.index');
    }

    public function datatable (Request $request, Recharge $recharge) {
        if ($request->ajax()) {

            $data = $recharge->where('status', 0)->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (Str::contains(Str::lower($row['user_name']), Str::lower($request->get('search')))) {
                            return true;
                        }
                        return false;
                    });
                }
            })
            ->editColumn('user_name', function($data) {
                return $data->user->username;
            })
            ->addColumn('action', function($data){
                $id = $data->id;

                $urlAceept = route('recharges.handle', 1);
                // $urlReject = route('recharges.handle', 0);
         
                return "
                    <a href=".$urlAceept." class='btn btn-success waves-effect waves-light btn-sm btn-accept' data-id=".$id." title='Accept'><i class='fas fa-check'></i></a>
                ";
                
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
        }
    }

    public function handleRequest(Request $request, $type) {
        $recharge = Recharge::find($request->id);

        $result = $recharge->update([
            'status' => 1
        ]);

        User::where('id', $recharge->user_id)->increment('coin', $recharge->coin);
        
        if ($result) {
            return response()->json(['success' => true, 'message' => __('app.accept_request_success')]);
        }
    }
}
