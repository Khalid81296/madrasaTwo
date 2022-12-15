<?php

namespace App\Repositories;

use App\Models\Nationality;
use App\Models\Division;
use App\Models\District;
use App\Models\State;
use App\Models\Lga;

class LocationRepo
{
    public function getDivisions()
    {
        return Division::all();
    }
    public function getDistricts()
    {
        return District::all();
    }
    public function getDistrictsByDivision($division_id)
    {
        return District::where('division_id', $division_id)->orderBy('name', 'asc')->get();
    }
    
    public function getStates()
    {
        return State::all();
    }

    public function getAllStates()
    {
        return State::orderBy('name', 'asc')->get();
    }

    public function getAllNationals()
    {
        return Nationality::orderBy('name', 'asc')->get();
    }

    public function getLGAs($state_id)
    {
        return Lga::where('state_id', $state_id)->orderBy('name', 'asc')->get();
    }

}