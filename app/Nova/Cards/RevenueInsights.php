<?php


namespace App\Nova\Cards;


use App\Booking;
use Coroowicaksono\ChartJsIntegration\BarChart;

class RevenueInsights
{
public function render(){
    {

        return (new BarChart())
            ->title('Revenue')
            ->model('\App\Booking')
            ->join('booking_pricings as bp', 'bookings.id', '=', 'bp.booking_id')
        ->series(array(
               [
                'label' => 'Amount',
                'filter' => [
                    'key' => 'amount', // State Column for Count Calculation Here
                    'value' => 'sum(bp.amount)'
                ],
            ], [
                    'label' => 'Tax Amount',
                    'filter' => [
                        'key' => 'tax_amount', // State Column for Count Calculation Here
                        'value' => 'sum(bp.tax_amount)'
                    ],
                ],[
                'label' => 'Discount Amount',
                'filter' => [
                    'key' => 'discount_amount', // State Column for Count Calculation Here
                    'value' => 'sum(bp.discount_amount)'
                ],
                ]
            ))
            ->options([

                'sum' => '-IFNULL(bp.discount_amount,0)+IFNULL(bp.amount,0)+IFNULL(bp.tax_amount,0)+IFNULL(bp.tip_amount,0)',
                'queryFilter' => array([
                    'key' => 'bp.active',
                    'operator' => '=',
                    'value' => '1'
                ]),
                'btnFilter' => true,
                'btnFilterDefault' => 'YTD',
                'btnFilterList' => [
                    'YTD'   => 'Year to Date',
                    'QTD'   => 'Quarter to Date',
                    'MTD'   => 'Month to Date',
                    '30'   => '30 Days', // numeric key will be set to days
                    '28'   => '28 Days', // numeric key will be set to days
                ],// Hide Show Total in Your Chart

            ])
            ->width('2/3');
    }

}

}
