<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseMaintenanceController extends Controller
{
    public function renameWpTables()
    {
        return User::first();
    }
}
