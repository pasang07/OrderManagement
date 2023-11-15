<?php

namespace App\Models\Model\SuperAdmin\ReferCustomer;

use App\Models\Model\SuperAdmin\User\User;
use Illuminate\Database\Eloquent\Model;

class ReferCustomer extends Model
{
    protected $fillable=['agent_id','name','email','phone','address','is_approve','approve_by','approve_date', 'order'];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}

