<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
    'student_id', 'name', 'citizenship', 'nic_number', 'certificate_name',
    'gender', 'contact_address', 'permanent_address', 'email', 'mobile',
    'whatsapp', 'course_id', 'branch_id', 'batch_id', 'status', 'isActive'
];
}
