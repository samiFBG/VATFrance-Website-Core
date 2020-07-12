<?php

namespace App\Models\Users;

use App\Models\Admin\Staff;
use App\Models\ATC\AtcRosterMember;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vatsim_id', 'fname', 'lname', 'email', 
        'atc_rating', 'atc_rating_short', 'atc_rating_long', 'pilot_rating', 
        'division_id', 'division_name', 'region_id', 'region_name', 'subdiv_id', 'subdiv_name',
        'is_staff', 'staff_level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    // Relationships

    public function settings()
    {
        return $this->hasOne(UserSetting::class, 'vatsim_id', 'vatsim_id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'vatsim_id', 'vatsim_id');
    }

    public function atcroster()
    {
        return $this->hasOne(AtcRosterMember::class, 'vatsim_id', 'vatsim_id');
    }
}
