<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasUuids;

    protected $fillable = ['first_name', 'last_name', 'company_id', 'email', 'phone'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }
}
