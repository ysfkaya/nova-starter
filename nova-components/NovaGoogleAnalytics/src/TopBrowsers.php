<?php

namespace Tightenco\NovaGoogleAnalytics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;
use Illuminate\Support\Carbon;
use Laravel\Nova\Nova;
use Spatie\Analytics\AnalyticsFacade as Analytics;
use Spatie\Analytics\Period;

class TopBrowsers extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $request->range = 7;

        $period = $this->rangeConvertToPeriod($request);

        $result = Analytics::fetchTopBrowsers($period)->mapWithKeys(function ($item) {
            return [$item['browser'] => $item['sessions']];
        })->toArray();

        return $this->result($result);
    }

    protected function rangeConvertToPeriod($request)
    {
        $timezone = Nova::resolveUserTimezone($request);

        $currentRange = $this->currentRange($request->range, $timezone);

        return Period::create($currentRange[0], $currentRange[1]);
    }

    /**
     * Calculate the current range and calculate any short-cuts.
     *
     * @param  string|int  $range
     * @param  string  $timezone
     * @return array
     */
    protected function currentRange($range, $timezone)
    {
        return [
            now($timezone)->subDays($range),
            now($timezone),
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
}
