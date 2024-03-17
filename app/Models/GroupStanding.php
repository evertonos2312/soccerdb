<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupStanding extends Model
{
    use HasFactory, UuidTrait;
    public $incrementing = false;
    protected $keyType = 'uuid';
}
