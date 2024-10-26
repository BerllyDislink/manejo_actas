<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Descripcion
 * 
 * @property int $ID_DESCRIPCION
 * @property string $ESTU_IMPLICADOS
 * @property int $NUM_ESTU_IMPLICADOS
 * @property string $DOCEN_IMPLICADOS
 * @property int $NUM_DOCEN_IMPLICADOS
 * @property string $CIUDAD_IMPLICADA
 * @property string $PAIS_IMPLICADO
 * @property string $EVENTO
 * 
 * @property Collection|Solicitud[] $solicituds
 *
 * @package App\Models
 */
class Descripcion extends Model
{
	protected $table = 'descripcion';
	protected $primaryKey = 'ID_DESCRIPCION';
	public $timestamps = false;

	protected $casts = [
		'NUM_ESTU_IMPLICADOS' => 'int',
		'NUM_DOCEN_IMPLICADOS' => 'int'
	];

	protected $fillable = [
		'ESTU_IMPLICADOS',
		'NUM_ESTU_IMPLICADOS',
		'DOCEN_IMPLICADOS',
		'NUM_DOCEN_IMPLICADOS',
		'CIUDAD_IMPLICADA',
		'PAIS_IMPLICADO',
		'EVENTO'
	];

	public function solicituds()
	{
		return $this->hasMany(Solicitud::class, 'DESCRIPCION_IDDESCRIPCION');
	}
}
