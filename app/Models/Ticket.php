<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TicketStatus;
use App\Enums\TicketPriority;

class Ticket extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
			'title',
			'description',
			'priority',
			'status',
			'files',
			'agent_id',
			'categories',
			'labels',
    ];
    protected $casts = [
		'priority' => TicketPriority::class,
		'status' => TicketStatus::class,
    // those columns can be array
    'files'=>'object',
    'categories'=>'object',
    'labels'=>'object',
	];
}
