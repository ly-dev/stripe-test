<?php

namespace App\Stripe\Models;

use Illuminate\Database\Eloquent\Model;

class StripeConnectAccount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "strip_connect_accounts";

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
