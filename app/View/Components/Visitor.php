<?php

namespace App\View\Components;

use Closure;
use App\Models\RefSetting as Model;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Visitor extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $data = [
            'all' => Model::query()->withTotalVisitCount()->first()->visit_count_total ?? 0,
            'month' => Model::query()->popularThisMonth()->first()->visit_count_total ?? 0,
            'week' => Model::query()->popularThisWeek()->first()->visit_count_total ?? 0,
            'now' => Model::query()->popularToday()->first()->visit_count_total ?? 0
        ];

        return view('components.visitor', $data);
    }
}