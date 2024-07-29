<?php

namespace App\Services;

use App\Models\Phone;

class PhoneService{

    static public function storePhones($user , $phones)
    {
        foreach ($phones as $phoneData){
            $phone = new Phone();

            $phone->number = $phoneData['number'];

            $user->phones()->save($phone);
        }
        return $user;
    }

    protected function update($phones)
    {
        foreach ($phones as $phoneData) {

            $phone = Phone::find($phoneData['id']);

            $phone?->update($phoneData);
        }
    }

    protected function getInValidPhones($user , $phones)
    {
        $currentPhones = $user->phones;

        $phoneIdsToKeep = collect($phones)->pluck('id')->all();

        return $currentPhones->whereNotIn('id' , $phoneIdsToKeep);

    }
    protected function delete($phones)
    {
        foreach ($phones as $phone){
            $phone->delete();
        }
    }

    public function updatePhones($phones , $user)
    {
        $this->update($phones);

        $phonesToDelete = $this->getInValidPhones($user , $phones);

        $this->delete($phonesToDelete);

        return $user;
    }
}
