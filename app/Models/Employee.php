<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employeeId',
        'firstName',
        'lastName',
        'phone',
        'email',
        'password',
        'photo',
        'gender',
        'birthDate',
        'address',
        'city',
        'nation',
        'roleId',
        'isActive',
        'emailVerifiedAt',
        'joinedAt',
        'resignedAt',
        'statusHireId',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $primaryKey = 'employeeId';

    public function role()
    {
        return $this->hasOne(Role::class, 'roleId', 'roleId');
    }

    public function statusHire()
    {
        return $this->hasOne(StatusHire::class, 'statusHireId', 'statusHireId');
    }
}
