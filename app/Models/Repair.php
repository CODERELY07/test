<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['ticket_number','name','description','model', 'category','status','estimated_cost', 'actual_cost'])]
class Repair extends Model
{
    use HasFactory;
}
