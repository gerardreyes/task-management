<?php

namespace App\Models;

use App\Events\NewMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'user_id',
    ];

    protected $dispatchesEvents = [
        'created' => NewMessage::class,
    ];
}
