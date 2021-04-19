<?php

namespace Davidpiesse\NovaMaintenanceMode\Http\Controllers;

use Davidpiesse\NovaMaintenanceMode\File;
use Davidpiesse\NovaMaintenanceMode\MaintenanceMode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ToolController extends Controller
{
    public function up(Request $request)
    {
        MaintenanceMode::up();

        return response([
            'message' => __('Application is now live'),
            'currentlyInMaintenance' => app()->isDownForMaintenance(),
        ], 200);
    }

    public function down(Request $request)
    {
        MaintenanceMode::down($request);

        return response([
            'message' => __('Application is now in maintenance mode'),
            'currentlyInMaintenance' => app()->isDownForMaintenance(),
        ], 200);
    }
}
