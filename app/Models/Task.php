<?php

namespace App\Models;

use App\Traits\ModelBootingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, ModelBootingTrait;
}
