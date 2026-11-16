<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'activo',
        'ultimo_acceso',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
            'ultimo_acceso' => 'datetime',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function proyectosCreados(): HasMany
    {
        return $this->hasMany(
            Proyecto::class,
            'creado_por_id'
        );
    }

    public function aprobacionesRegistradas(): HasMany
    {
        return $this->hasMany(
            Aprobacion::class,
            'registrado_por_id'
        );
    }

    public function acuerdosComoResponsable(): HasMany
    {
        return $this->hasMany(
            Aprobacion::class,
            'responsable_id'
        );
    }

    public function hitosResponsable(): HasMany
    {
        return $this->hasMany(Hito::class, 'responsable_id');
    }

    public function avancesRegistrados(): HasMany
    {
        return $this->hasMany(AvanceProyecto::class, 'registrado_por_id');
    }

    public function incidenciasRegistradas(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'registrado_por_id');
    }

    public function incidenciasAsignadas(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'responsable_id');
    }
}
