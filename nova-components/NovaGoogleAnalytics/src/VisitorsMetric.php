<?php

namespace Tightenco\NovaGoogleAnalytics;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;

class VisitorsMetric extends Value
{
    public $name = 'Visitors';

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $lookups = [
            1 => $this->visitorsOneDay(),
            'MTD' => $this->visitorsOneMonth(),
            'YTD' => $this->visitorsOneYear(),
        ];

        $data = Arr::get($lookups, $request->get('range'), ['result' => 0, 'previous' => 0]);

        return $this->result($data['result'])
            ->previous($data['previous']);
    }

    private function visitorsOneDay()
    {
        $analyticsData = app(Analytics::class)
            ->fetchTotalVisitorsAndPageViews(Period::days(1));

        return [
            'result' => ($analyticsData && $analyticsData->last())
                ? $analyticsData->last()['visitors']
                : 0,
            'previous' => ($analyticsData && $analyticsData->first())
                ? $analyticsData->first()['visitors']
                : 0,
        ];
    }

    private function visitorsOneMonth()
    {
        // First get the results for the current month to date.
        $currentAnalyticsData = app(Analytics::class)->performQuery(
            Period::create(Carbon::today()->startOfMonth(), Carbon::today()),
            'ga:users',
            [
                'metrics' => 'ga:users',
                'dimensions' => 'ga:yearMonth',
            ]
        );
        $currentResults = collect($currentAnalyticsData->getRows());

        // Then get the total results of last month to compare.
        $previousAnalyticsData = app(Analytics::class)->performQuery(
            Period::create(Carbon::today()->subMonths(1)->startOfMonth(), Carbon::today()->subMonths(1)->endOfMonth()),
            'ga:users',
            [
                'metrics' => 'ga:users',
                'dimensions' => 'ga:yearMonth',
            ]
        );
        $previousResults = collect($previousAnalyticsData->getRows());

        return [
            'previous' => ($previousResults && $previousResults->last())
                ? $previousResults->last()[1]
                : 0,
            'result' => ($currentResults && $currentResults->last())
                ? $currentResults->last()[1]
                : 0,
        ];
    }

    private function visitorsOneYear()
    {
        // First get the results for the current year to date.
        $currentAnalyticsData = app(Analytics::class)->performQuery(
            Period::create(Carbon::today()->startOfYear(), Carbon::today()),
            'ga:users',
            [
                'metrics' => 'ga:users',
                'dimensions' => 'ga:year',
            ]
        );
        $currentResults = collect($currentAnalyticsData->getRows());

        // Then get the total results of last month to compare.
        $previousAnalyticsData = app(Analytics::class)->performQuery(
            Period::create(Carbon::today()->subYears(1)->startOfYear(), Carbon::today()->subYears(1)->endOfYear()),
            'ga:users',
            [
                'metrics' => 'ga:users',
                'dimensions' => 'ga:year',
            ]
        );
        $previousResults = collect($previousAnalyticsData->getRows());


        return [
            'previous' => ($previousResults && $previousResults->last())
                ? $previousResults->last()[1]
                : 0,
            'result' => ($currentResults && $currentResults->last())
                ? $currentResults->last()[1]
                : 0,
        ];
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            1 => 'Today',
            // 30 => '30 Days',
            // 60 => '60 Days',
            // 365 => '365 Days',
            'MTD' => 'This month (to date)',
            // 'QTD' => 'Quarter To Date',
            'YTD' => 'This year (to date)',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addMinutes(10);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'visitors';
    }
}
