<?php


namespace App\Nova\Exports;

use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserKPIExport implements FromArray, WithHeadings
{

    public function headings(): array
    {
        return [
            'year',
            'month',
            'sign ups',
            'bookings'
        ];
    }

    public function array(): array
    {
        return  DB::select("select year(u.created_at) as year, MONTHNAME(u.created_at) as month, count(*) as usersignup, count(b.id) as totalBookings from users u, bookings b where 
u.id=b.bookable_id and b.bookable_type='App\\\\User'
group by year, month
 UNION ALL
select year(g.created_at) as year, MONTHNAME(g.created_at) as month, count(*) as usersignup, count(b.id) as totalBookings from guests g, bookings b where 
g.id=b.bookable_id and b.bookable_type='App\\\\Guest'
group by year, month");
    }
}
