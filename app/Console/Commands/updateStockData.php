<?php

namespace App\Console\Commands;

use App\Pharmacy;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\Console\Helper\ProgressBar;

class updateStockData extends Command
{
    protected $signature = 'api:stock {method=redis}';

    protected $description = 'Update Stock information';

    public function handle()
    {
        $pharmacies = Pharmacy::all();
        $now = Carbon::now();
        if ($this->argument('method') == 'redis') {
            Redis::flushall();
        }

        ProgressBar::setFormatDefinition('custom', '%current%/%max% -- %message%');
        $bar = new ProgressBar($this->output, count($pharmacies));
        $bar->setFormat('custom');
        $bar->start();

        foreach ($pharmacies as $pharmacy) {
            $pharmacy->stock_information = $this->generateStockData($now);
            if ($this->argument('method') == 'redis') {
                Redis::geoadd('pharmacies', $pharmacy->lat, $pharmacy->lng, serialize($pharmacy->toArray()));
            } elseif ($this->argument('method') == 'sql') {
                $pharmacy->update();
            }
            $bar->advance();
            $bar->setMessage($pharmacy->name);
        }

        $bar->finish();
    }

    private function generateStockData(Carbon $now)
    {
        $sold = rand(10, 100);
        $remain = rand(0, 100);
        $stock = $sold + $remain;

        return [
            'stock_d' => $now->format('m-d'),
            'stock_t' => $now->subMinutes(rand(-120, 120))->format('H:i'),
            'stock_cnt' => $stock,
            'sold_cnt' => $sold,
            'remain_cnt' => $remain,
            'sold_out' => $remain === 0,
        ];
    }
}
