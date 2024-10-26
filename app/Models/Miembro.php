<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Miembro
 * 
 * @property int $IDMIEMBRO
 * @property string $NOMBRE
 * @property string $CARGO
 * 
 * @property Collection|AsistenciaMiembro[] $asistencia_miembros
 * @property Collection|EncargadosTarea[] $encargados_tareas
 * @property Collection|Proposicione[] $proposiciones
 *
 * @package App\Models
 */
class Miembro extends Model
{
	protected $table = 'miembros';
	protected $primaryKey = 'IDMIEMBRO';
	public $timestamps = false;

	protected $fillable = [
		'NOMBRE',
		'CARGO'
	];

	public function asistencia_miembros()
	{
		return $this->hasMany(AsistenciaMiembro::class, 'MIEMBRO_IDMIEMBRO');
	}

	public function encargados_tareas()
	{
		return $this->hasMany(EncargadosTarea::class, 'MIEMBROS_IDMIEMBROS');
	}

	public function proposiciones()
	{
		return $this->hasMany(Proposicione::class, 'MIEMBRO_IDMIEMBRO');
	}
}
