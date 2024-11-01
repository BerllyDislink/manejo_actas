<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AsistenciaMiembro
 * 
 * @property int $SESSION_IDSESION
 * @property int $MIEMBRO_IDMIEMBRO
 * @property string|null $ESTADO_ASISTENCIA
 * 
 * @property Miembro $miembro
 * @property Sesion $sesion
 *
 * @package App\Models
 */
class AsistenciaMiembro extends Model
{
	protected $table = 'asistencia_miembros';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'SESSION_IDSESION' => 'int',
		'MIEMBRO_IDMIEMBRO' => 'int'
	];

	protected $fillable = [
        'SESSION_IDSESION', 
        'MIEMBRO_IDMIEMBRO', 
        'ESTADO_ASISTENCIA'
    ];

	public function miembro()
	{
		return $this->belongsTo(Miembro::class, 'MIEMBRO_IDMIEMBRO');
	}

	public function sesion()
	{
		return $this->belongsTo(Sesion::class, 'SESSION_IDSESION');
	}
}
