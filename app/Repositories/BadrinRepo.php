<?php

namespace App\Repositories;

use App\Helpers\Qs;
use App\Models\Dorm;
use App\Models\Promotion;
use App\Models\BadrinRecord;

class BadrinRepo {


    public function findBadrinsByClass($class_id)
    {
        return $this->activeBadrins()->where(['my_class_id' => $class_id])->with(['my_class', 'user'])->get()->sortBy('user.name');
    }

    public function activeBadrins()
    {
        return BadrinRecord::where(['grad' => 0]);
    }

    public function gradBadrins()
    {
        return BadrinRecord::where(['grad' => 1])->orderByDesc('grad_date');
    }

    public function allGradBadrins()
    {
        return $this->gradBadrins()->with(['my_class', 'section', 'user'])->get()->sortBy('user.name');
    }

    public function findBadrinsBySection($sec_id)
    {
        return $this->activeBadrins()->where('section_id', $sec_id)->with(['user', 'my_class'])->get();
    }

    public function createRecord($data)
    {
        return BadrinRecord::create($data);
    }

    public function updateRecord($id, array $data)
    {
        return BadrinRecord::find($id)->update($data);
    }

    public function update(array $where, array $data)
    {
        return BadrinRecord::where($where)->update($data);
    }

    public function getRecord(array $data)
    {
        return $this->activeBadrins()->where($data)->with('user');
    }

    public function getRecordByUserIDs($ids)
    {
        return $this->activeBadrins()->whereIn('user_id', $ids)->with('user');
    }

    public function findByUserId($st_id)
    {
        return $this->getRecord(['user_id' => $st_id]);
    }

    public function getAll()
    {
        return $this->activeBadrins()->with('user');
    }

    public function getGradRecord($data=[])
    {
        return $this->gradBadrins()->where($data)->with('user');
    }

    public function getAllDorms()
    {
        return Dorm::orderBy('name', 'asc')->get();
    }

    public function exists($Badrin_id)
    {
        return $this->getRecord(['user_id' => $Badrin_id])->exists();
    }

    /************* Promotions *************/
    public function createPromotion(array $data)
    {
        return Promotion::create($data);
    }

    public function findPromotion($id)
    {
        return Promotion::find($id);
    }

    public function deletePromotion($id)
    {
        return Promotion::destroy($id);
    }

    public function getAllPromotions()
    {
        return Promotion::with(['badrin', 'fc', 'tc', 'fs', 'ts'])->where(['from_session' => Qs::getCurrentSession(), 'to_session' => Qs::getNextSession()])->get();
    }

    public function getPromotions(array $where)
    {
        return Promotion::where($where)->get();
    }

}
