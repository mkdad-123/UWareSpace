<?php

namespace App\Services\Item;

use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemUpdateService
{
    protected OperationResult $result;

    protected function updateItem($item , $data)
    {
        return $item->fill($data);
    }

    protected function updatePhoto($image ,$item )
    {
        if ($item->photo)
        {
            Storage::delete('public/'.$item->photo);
        }

        $photoName = time().'.'.$image->getClientOriginalExtension();
        $image->storeAs('images', $photoName, 'public');
        $item->photo = 'images/'.$photoName;

        return $item;
    }

    public function update($item , $request)
    {
        try {

            DB::beginTransaction();

            $item = $this->updateItem($item , $request->except('photo'));

            if ($request->hasFile('photo')){

                $item = $this->updatePhoto($request->file('photo') , $item);
            }

            $item->save();

            DB::commit();

            $this->result = new OperationResult('Item has been updated successfully',$item);

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
