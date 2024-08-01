<?php

namespace App\Services\Item;

use App\Models\Item;
use App\Models\Warehouse;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemStoreService
{

    protected OperationResult $result;

    /*
     * Store Warehouse in database
     */
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

            DB::commit();

            $this->result = new OperationResult('Item has been created in your warehouse successfully',$item , 201);

        } catch (QueryException $e) {

            DB::rollBack();

            return $this->result = new OperationResult('Database error: ' . $e->getMessage(), response(), 500);

        } catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult('An error occurred: ' . $e->getMessage(), response(), 500);
        }

        return $this->result;
    }

    /*
     * Store items in warehouse
     */

    protected function createItemInWarehouse($item ,$warehouseId, $data)
    {
        $item->warehouses()->attach($warehouseId,[
            'real_qty' => $data['real_quantity'],
            'available_qty' => $data['available_quantity'],
            'min_qty' => $data['min_quantity']
        ]);
    }

    public function storeInWarehouse($request , $item)
    {
        try {

            DB::beginTransaction();

            $this->createItemInWarehouse(
                $item ,
                $request->input('warehouse_id') ,
                $request->except(['warehouse_id']) ,
            );

            $warehouse = Warehouse::find($request->input('warehouse_id'));

            $itemCapacity =  $warehouse->items()->where('id' , $item->id)->get();

            $percent = calculate_capacity($warehouse->size_cubic_meters,$itemCapacity);

            $capacity = $warehouse->current_capacity + $percent;

            $capacity = round($capacity ,2);

            if($capacity > 100)
            {
                return $this->result = new OperationResult(
                    'The warehouse capacity is not enough, the capacity becomes '. $capacity,
                    response(),
                    400);
            }

            $warehouse->current_capacity += $percent;

            $warehouse->save();



            DB::commit();

            $this->result = new OperationResult('Items have been created in your warehouse successfully',$warehouse,201);

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
