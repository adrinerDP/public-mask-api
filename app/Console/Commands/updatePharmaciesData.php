<?php

namespace App\Console\Commands;

use App\Imports\PharmacyImport;
use App\Pharmacy;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class updatePharmaciesData extends Command
{
    protected $signature = 'api:pharmacy';

    protected $description = 'Updates Pharmacies data from hira';

    public function handle()
    {
        Pharmacy::truncate();
        Excel::import(new PharmacyImport, 'pharmacies.xlsx');
    }
}
