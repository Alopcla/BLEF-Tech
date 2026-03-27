<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Summary of getPositionAttribute: Funcion que trata de buscar al empleado mediante su email (es unico)
     * y devuelve la posicion de su cargo de trabajo.
     * En caso de que no se encuentre el email del empleado, sera un cliente.
     */
    public function getPositionAttribute()
    {

        // Se busca al empleado en la tabla Employee usando el email del usuario logueado
        $employee = \App\Models\Employee::where('email', $this->email)->first();

        // Si lo encuentra, se devuelve el cargo del empleado
        if ($employee)
            return $employee->position;


        // En caso de que en la tabla no se encuentre, por descarte es un cliente
        return 'Clientes';
    }
}
