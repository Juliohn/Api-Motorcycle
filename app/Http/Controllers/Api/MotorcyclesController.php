<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motorcycle;
use App\Models\Motorcycle_Stock;

use Illuminate\Support\Facades\Validator;

use App\Http\Requests\MotorcycleRequest;

class MotorcyclesController extends Controller
{
    private $perPage = 10;

    public function index()
    {
        $data = Motorcycle::with(['stock_entries' => function ($query) {
            $query->select(['id','motorcycle_id','created_at','operation', 'quantity']);
        }])->paginate($this->perPage);

        return response()->json($data);
    }

    public function store(MotorcycleRequest $request)
    {
        try {
            $random = Str::random(10). uniqid().".jpg";
            \File::put(storage_path('app/public'). '/' . $random, base64_decode($request['avatar']));

            $data = (object) $request->except(['avatar','quantity']);
            $data->avatar = $random;
            $data->code = uniqid();

            $rs =  Motorcycle::create((array)$data);

            Motorcycle_Stock ::create(array(
                'motorcycle_id' => $rs->id,
                'quantity' => $request->quantity,
                'operation' => 1
            ));

            $result = array(
                'error'=> 0,
                'msg'=>'New motorcycle save.',
            );

            return response()->json($result);
        } catch (\Exception  $e) {
            $result = array(
                'error'=> 1 ,
                'msg'=>$e->getMessage(),
            );
            return response()->json($result);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $data = Motorcycle::find($id);
            return response()->json($data);
        } catch (\Exception  $e) {
            $result = array(
                'error'=> 1 ,
                'msg'=>$e->getMessage(),
            );
            return response()->json($result);
        }
    }

    public function update(MotorcycleRequest $request, $id)
    {
        try {
            $data = Motorcycle::find($id);


            if ($request->avatar) {
                if (file_exists(storage_path('app/public/').$data->avatar)) {
                    unlink(storage_path('app/public/').$data->avatar);
                }

                $random = Str::random(10). uniqid().".jpg";
                \File::put(storage_path('app/public'). '/' . $random, base64_decode($request['avatar']));
                $data->avatar = $random;
            }

            $data->name = $request->name;
            $data->price = $request->price;
            $data->update();

            $result = array(
                'error'=> 0,
                'msg'=>'Motorcycle update.',
            );

            return response()->json($result);
        } catch (\Exception  $e) {
            $result = array(
                'error'=> 1 ,
                'msg'=>$e->getMessage(),
            );
            return response()->json($result);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $data = Motorcycle::find($id);
            $data->delete();

            Motorcycle_Stock::where('motorcycle_id', $id)->delete();

            $result = array(
                'error'=> 0,
                'msg'=>'Motorcycle deleted.',
            );

            return response()->json($result);
        } catch (\Exception  $e) {
            $result = array(
                'error'=> 1 ,
                'msg'=>$e->getMessage(),
            );
            return response()->json($result);
        }
    }
}
