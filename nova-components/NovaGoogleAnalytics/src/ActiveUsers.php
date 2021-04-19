<?php

namespace Tightenco\NovaGoogleAnalytics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;
use Spatie\Analytics\AnalyticsFacade as Analytics;


class ActiveUsers extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $count = Analytics::getAnalyticsService()
            ->data_realtime
            ->get('ga:' . config('analytics.view_id'), 'rt:activeVisitors')
            ->totalsForAllResults['rt:activeVisitors'];

        return $this->result($count);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            'TODAY' => 'Today',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addMinutes(1);
    }
}
