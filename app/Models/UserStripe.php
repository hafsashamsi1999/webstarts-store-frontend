<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStripe extends Model
{
    //use HasFactory;

    public $timestamps = false;

    protected $table = 'user_stripe';
    
    protected $fillable = [
		'userid',
		'stripe_id',
		'last_four',
		'live',
	];

    protected $casts = [
        'live' => 'boolean',
    ];

    public function user()
	{
		return $this->belongsTo(User::class, 'userid');
	}
}
