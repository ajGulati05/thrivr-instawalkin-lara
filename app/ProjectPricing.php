<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectPricing extends Model
{

    protected $fillable = [
        'start_date', 'end_date', 'amount'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function taxes()
    {
        return $this->belongsToMany(Taxes::class, 'projectpricings_taxes', 'project_pricing_id', 'tax_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    public function scopeActivepricing($query)
    {
        $query->whereNull('end_date');
    }

     public function calculatetax()
    {
            //grab active taxes on a project 
            return $this->taxes()->activetaxes();
            //$query->whereMonth('created_at', Carbon::parse($month)->month);
    }

   

      public function concattitle()
    {
            $toReturn="";
          foreach ($this->calculatetax()->cursor() as $tax) {
                $toReturn= $tax->taxcode." ".$toReturn;
                }
            
            return $toReturn;
    }
}
