<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'barcode',
        'nik',
        'email',
        'phone',
        'mobile_phone',
        'organization_id',
        'location_id',
        'job_level_id',
        'division_id',
        'departement_id',
        'job_potition',
        'join_date',
        'resign_date',
        'status_employee',
        'end_date',
        'birth_date',
        'birth_place',
        'citizen_id_address',
        'resindtial_address',
        'NPWP',
        'PKTP_status',
        'employee_tax_status',
        'tax_config',
        'bank_name',
        'bank_account',
        'bank_account_holder',
        'bpjs_ketenagakerjaan',
        'bpjs_kesehatan',
        'citizen_id',
        'religion',
        'gender',
        'marital_status',
        'nationality_code',
        'currency',
        'length_of_service',
        'payment_schedule',
        'approval_line',
        'manager',
        'grade',
        'class',
        'password',
        'schedule_id',
        'photo_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id')->select(['id', 'name']);
    }
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id')->select(['id', 'name']);
    }
    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id', 'id')->select(['id', 'name']);
    }
    public function level()
    {
        return $this->belongsTo(Position::class, 'job_level_id', 'id')->select(['id', 'name']);
    }
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id')->select(['id', 'name','location','longitude','latitude','radius']);
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'id', 'manager')->select(['id', 'name']);
    }
    public function approval_line()
    {
        return $this->belongsTo(User::class, 'id', 'approval_line')->select(['id', 'name']);
    }
}
