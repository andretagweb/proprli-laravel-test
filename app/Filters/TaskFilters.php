<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TaskFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $query): Builder
    {
        return $query
            ->when($this->request->filled('status'), function ($query) {
                $query->where('status', $this->request->status);
            })
            ->when($this->request->filled('building_id'), function ($query) {
                $query->where('building_id', $this->request->building_id);
            })
            ->when($this->request->filled('assigned_user_id'), function ($query) {
                $query->where('assigned_user_id', $this->request->assigned_user_id);
            })
            ->when($this->request->filled('start_date') && $this->request->filled('end_date'), function ($query) {
                $query->whereBetween('created_at', [$this->request->start_date, $this->request->end_date]);
            });
    }
}
