<?php

namespace App\Filament\Widgets;

use App\Services\WidgetService;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\PieChartWidget;

class TopClients extends PieChartWidget
{
    protected static ?string $heading = 'Top clients';

    protected function getData(): array
    {
        // top clients by amount spent 
        $clients = DB::table('sales')->join('clients', 'sales.client_id', '=', 'clients.id')->selectRaw('clients.id, clients.name, sum(sales.total_paid) as total')->groupBy(['clients.id','clients.name'])->get();
        
        $data = [];
        $labels = [];
        
        foreach ($clients as $client) {
            $data[] = $client->total;
            $labels[] = $client->name;
        }
        
        $colors = WidgetService::generateRandomColors(count($data));
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $data,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels
        ];
    }
}
