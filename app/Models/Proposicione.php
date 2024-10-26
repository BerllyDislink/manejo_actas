<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Proposicione
 * 
 * @property int $ID_PROPOSICIONES
 * @property string $DESCRIPCION
 * @property string $DESICION
 * @property int $MIEMBRO_IDMIEMBRO
 * @property int $SESION_IDSESION
 * 
 * @property Miembro $miembro
 * @property Sesion $sesion
 *
 * @package App\Models
 */
class Proposicione extends Model
{
	protected $table = 'proposiciones';
	protected $primaryKey = 'ID_PROPOSICIONES';
	public $timestamps = false;

	protected $casts = [
		'MIEMBRO_IDMIEMBRO' => 'int',
		'SESION_IDSESION' => 'int'
	];

	protected $fillable = [
		'DESCRIPCION',
		'DESICION',
		'MIEMBRO_IDMIEMBRO',
		'SESION_IDSESION'
	];

	public function miembro()
	{
		return $this->belongsTo(Miembro::class, 'MIEMBRO_IDMIEMBRO');
	}

	public function sesion()
	{
		return $this->belongsTo(Sesion::class, 'SESION_IDSESION');
	}
}
