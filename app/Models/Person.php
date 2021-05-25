<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = "persons";

    protected $fillable = [
        "nombre","apellidos", "dni", "direccion", "celular","cuenta","plan_id", "sede_id"
    ];

    protected $hidden = [
        "created_at", "updated_at"
    ];
}
