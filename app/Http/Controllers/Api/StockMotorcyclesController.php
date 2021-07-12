<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motorcycle;
use App\Models\Motorcycle_Stock;

use App\Http\Requests\StockMotorcycleRequest;

class StockMotorcyclesController extends Controller
{
    private $perPage = 10;

    public function listFromMotorcycle(Request $request)
    {
        $data = Motorcycle_Stock::where('motorcycle_id', $request->motorcycle_id)
        ->orderBy('created_at', 'desc')
        ->paginate($this->perPage);
        return response()->json($data);
    }

    public function store(StockMotorcycleRequest $request)
    {
        try {
            $motorcycle =  Motorcycle::find($request->motorcycle_id);

            if ($request->operation == 2) {
                if (($motorcycle->stock - $request->quantity) < 0) {
                    $result = array(
                        'error'=> 1 ,
                        'msg'=>'Quantity invalid. Stock can´t be negative',
                    );
                    return response()->json($result);
                }
            }

            Motorcycle_Stock ::create($request->all());

            $result = array(
                'error'=> 0,
                'msg'=>'New stok '. ($request->operation == 1 ? 'in': 'out') .' save.',
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
            $data = Motorcycle_Stock::find($id);
            $data->delete();

            $result = array(
                'error'=> 0,
                'msg'=>'Stock register deleted.',
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
