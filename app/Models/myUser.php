<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class myUser extends Model
{

    use HasFactory;

    protected $table = 'my_users';  // Nombre de la tabla que quieres usar

    // Definir campos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'lastname',
        'role',
        'phone',
        'password',
        'verified_at',
    ];

    // Ocultar campos sensibles
    protected $hidden = [
        'password',
    ];

    // Si no usas un campo de timestamps, desactívalo:
    public $timestamps = true;

    // Si los roles van a ser almacenados como texto en la base de datos, puedes agregar una constante
    const ROLE_CLIENTE = 'CLIENTE';
    const ROLE_ADMIN = 'ADMIN';
    const ROLE_AXULIAR = 'AUXILIAR';

    // Método para obtener los roles
    public function getRoleAttribute($value)
    {
        return ucfirst($value);  // Convierte el rol a mayúscula inicial
    }

    // Agregar validación de la estructura de los datos, si es necesario
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->password = bcrypt($user->password);
        });
    }
}
