<?php

namespace App\Services\Item;

use App\Models\Item;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemStoreService
{

    protected OperationResult $result;

    protected function storePhoto($photo , $data)
    {
        $photoName = time().'.'.$photo->getClientOriginalExtension();
        $photo->storeAs('images', $photoName, 'public');
        $data['photo'] = 'images/'.$photoName;

        return $data;
    }

    protected function storeItem($data)
    {
         return Item::create([
             'admin_id' => $data['admin_id'],
             'SKU' => $data['SKU'],
             'name' => $data['name'],
             'sell_price' => $data['sell_price'],
             'pur_price' => $data['pur_price'],
             'str_price' => $data['start_price'],
             'weight' => $data['weight'],
             'size_cubic_meters' => $data['size_cubic_meters'],
             'total_qty' => $data['total_quantity'],
             'photo' => $data['photo'],
             'unit' => $data['unit']
         ]);
    }

    protected function storeItemInWarehouse($item , $data)
    {
        $item->warehouses()->attach($data['warehouse_id'],[
            'real_qty' => $data['real_quantity'],
            'available_qty' => $data['available_quantity'],
            'min_qty' => $data['min_quantity']
        ]);
    }

    public function store(Request $request)
    {

        try {

            DB::beginTransaction();

            $adminId = auth('employee')->user()->admin_id;

            $data = $request->except([
                'warehouse_id',
                'photo' ,
                'available_quantity' ,
                'min_quantity',
                'real_quantity'
            ]);

            $data['admin_id'] = $adminId;
            $data['photo'] = null;

            if($request->hasFile('photo')) {

                $data = $this->storePhoto($request->file('photo'),$data);
            }

            $item = $this->storeItem($data);

            $this->storeItemInWarehouse($item ,
                $request->only(
                    'warehouse_id' ,
                    'real_quantity',
                    'available_quantity',
                    'min_quantity'
                ));

            DB::commit();

            $this->result = new OperationResult('Item has been created in your warehouse successfully',$data);

        } catch (QueryException $e) {

            DB::rollBack();

            return $this->result = new OperationResult('Database error: ' . $e->getMessage(), response(), 500);

        } catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult('An error occurred: ' . $e->getMessage(), response(), 500);
        }

        return $this->result;
    }
}
