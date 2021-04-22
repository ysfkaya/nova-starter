<?php

namespace Tightenco\NovaGoogleAnalytics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;
use Illuminate\Support\Carbon;
use Laravel\Nova\Nova;
use Spatie\Analytics\AnalyticsFacade as Analytics;
use Spatie\Analytics\Period;

class TopCountries extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $request->range = 15;

        $period = $this->rangeConvertToPeriod($request);

        $data = Analytics::performQuery(
            $period,
            'ga:sessions',
            [
                'dimensions' => 'ga:country',
                'sort' => '-ga:sessions',
                'max-results' => 10,
            ]
        );

        $result = collect($data['rows'] ?? [])->mapWithKeys(function ($item) {
            return [$item[0] => $item[1]];
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
