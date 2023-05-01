<?php


namespace App\Nova\Cards;


use App\Booking;
use Coroowicaksono\ChartJsIntegration\StackedChart;

class BookingInsights
{
    public function render()
    {
        return (new StackedChart())
            ->title('Bookings')
            ->model('\App\Booking')
            ->series(array([
                'label' => 'Confirmed',
                'filter' => [
                    'key' => 'booking_status', // State Column for Count Calculation Here
                    'operator' => 'IS NULL'
                ],
            ],[
                'label' => 'Cancelled',
                'filter' => [
                    'key' => 'booking_status', // State Column for Count Calculation Here
                    'value' => Booking::CANCELLED_BOOKING_STATUS
                ],
            ],[
                'label' => 'Rescheduled',
                'filter' => [
                    'key' => 'booking_status', // State Column for Count Calculation Here
                    'value' => Booking::RESCHEDULED_BOOKING_STATUS
                ]
            ],

                [
                    'label' => 'Deleted',
                    'filter' => [
                        'key' => 'booking_status', // State Column for Count Calculation Here
                        'value' => Booking::DELETED_BOOKING_STATUS
                    ],
                ]
            ))
            ->options([
                'showTotal' => false,
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