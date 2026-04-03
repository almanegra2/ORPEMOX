<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory, \Illuminate\Notifications\Notifiable;
    protected $table = "usuario";
    protected $primaryKey = "id_usuario";
    public $timestamps = false;
    protected $fillable = [
        "tipo_usuario", "nombre", "apellido", "usuario", "password", "correo", "estado"
    ];

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->correo;
    }
}
