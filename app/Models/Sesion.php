<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sesion
 *
 * @property int $IDSESION
 * @property string $LUGAR
 * @property Carbon $FECHA
 * @property Carbon $HORARIO_INICIO
 * @property Carbon|null $HORARIO_FINAL
 * @property string $PRESIDENTE
 * @property string $SECRETARIO
 *
 * @property Collection|Acta[] $actas
 * @property Collection|AsistenciaInvitado[] $asistencia_invitados
 * @property Collection|AsistenciaMiembro[] $asistencia_miembros
 * @property Collection|OrdenSesion[] $orden_sesions
 * @property Collection|Proposicione[] $proposiciones
 * @property Collection|Solicitud[] $solicituds
 * @property Collection|Tarea[] $tareas
 *
 * @package App\Models
 */
class Sesion extends Model
{
	protected $table = 'sesion';
	protected $primaryKey = 'IDSESION';
	public $timestamps = false;

	protected $casts = [
		'FECHA' => 'datetime',
		'HORARIO_INICIO' => 'datetime',
		'HORARIO_FINAL' => 'datetime'
	];

	protected $fillable = [
		'LUGAR',
		'FECHA',
		'HORARIO_INICIO',
		'HORARIO_FINAL',
		'PRESIDENTE',
		'SECRETARIO'
	];

	   // Mutator para FECHA
	   public function getFECHAAttribute($value)
	   {
		   return Carbon::parse($value)->setTimezone('America/Bogota')->toDateString();
	   }

	   // Mutator para HORARIO_INICIO
	   public function getHORARIOINICIOAttribute($value)
	   {
		   return Carbon::parse($value)->setTimezone('America/Bogota')->toDateTimeString();
	   }

	   // Mutator para HORARIO_FINAL
	   public function getHORARIOFINALAttribute($value)
	   {
		   return Carbon::parse($value)->setTimezone('America/Bogota')->toDateTimeString();
	   }

	public function actas()
	{
		return $this->hasMany(Acta::class, 'SESION_IDSESION');
	}

	public function asistencia_invitados()
	{
		return $this->hasMany(AsistenciaInvitado::class, 'SESION_IDSESION');
	}

	public function asistencia_miembros()
	{
		return $this->hasMany(AsistenciaMiembro::class, 'SESSION_IDSESION');
	}

	public function orden_sesions()
	{
		return $this->hasMany(OrdenSesion::class, 'SESION_IDSESION');
	}

	public function proposiciones()
	{
		return $this->hasMany(Proposicione::class, 'SESION_IDSESION');
	}

	public function solicituds()
	{
		return $this->hasMany(Solicitud::class, 'SESION_IDSESION');
	}

	public function tareas()
	{
		return $this->hasMany(Tarea::class, 'SESION_IDSESION');
	}



}
