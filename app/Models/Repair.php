<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['ticket_number','name','description','model', 'category','status','estimated_cost', 'actual_cost', 'downpayment'])]
class Repair extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
}
