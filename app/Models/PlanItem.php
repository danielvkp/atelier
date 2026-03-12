<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanItem extends Model
{
    use HasFactory;

    protected $table = 'items_plan';

    protected $fillable = [    
      'tipo',
      'descripcion',
      'orden'
    ];

    public function plan(){
      return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
}
