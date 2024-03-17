<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChampionshipPhase extends Model
{
    use HasFactory, SoftDeletes, UuidTrait;

    public $incrementing = false;
    protected $keyType = 'uuid';
}
