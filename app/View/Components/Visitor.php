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
            'all' => Cache::remember('visitor.all', now()->addDay(), function () {
                return Model::query()->withTotalVisitCount()->first()->visit_count_total ?? 0;
            }),
            'month' => Cache::remember('visitor.month', now()->addDay(), function () {
                return Model::query()->popularThisMonth()->first()->visit_count_total ?? 0;
            }),
            'week' => Cache::remember('visitor.week', now()->addDay(), function () {
                return Model::query()->popularThisWeek()->first()->visit_count_total ?? 0;
            }),
            'now' => Cache::remember('visitor.now', now()->addDay(), function () {
                return Model::query()->popularToday()->first()->visit_count_total ?? 0;
            })
        ];

        return view('components.visitor', $data);
    }
}