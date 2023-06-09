<?php

namespace App\Repos;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SystemUserRepo
{
    //
    public $query;

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function filter($query, $request)
    {
        $this->query = $query;

        $this->applyFilterOtcmUser($request);

        return $this->query;
    }

    public function applyFilterOtcmUser($request)
    {
        $locations = getUserLocations();
        $this->query = $this->query->where('user_type', 'SYSTEM-USER');
        $this->query = $this->query->whereIn('unit_id', $locations);
    }
}
