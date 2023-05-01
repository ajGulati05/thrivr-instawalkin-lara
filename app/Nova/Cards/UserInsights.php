<?php
namespace App\Nova\Cards;

use Coroowicaksono\ChartJsIntegration\StackedChart;

class UserInsights{
    public function render()
    {
        return (new StackedChart())
            ->title('Users')
            ->model('\App\User')
            ->series(array([
                'label' => 'Organic',
                'filter' => [
                    'key' => 'provider', // State Column for Count Calculation Here
                    'operator' => 'IS NULL'
                ],
            ],[
                'label' => 'facebook',
                'filter' => [
                    'key' => 'provider', // State Column for Count Calculation Here
                    'value' => 'facebook'
                ],
            ],[
                'label' => 'Google',
                'filter' => [
                    'key' => 'provider', // State Column for Count Calculation Here
                    'value' => 'Google'
                ],
            ]))
            ->options([
                'showTotal' => true,
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