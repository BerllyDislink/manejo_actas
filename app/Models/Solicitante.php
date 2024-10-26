<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Solicitante
 * 
 * @property int $ID_SOLICITANTE
 * @property string $NOMBRE
 * @property string $TIPO_DE_SOLICITANTE
 * @property string $EMAIL
 * @property string $CELULAR
 * 
 * @property Collection|Solicitud[] $solicituds
 *
 * @package App\Models
 */
class Solicitante extends Model
{
	protected $table = 'solicitantes';
	protected $primaryKey = 'ID_SOLICITANTE';
	public $timestamps = false;

	protected $fillable = [
		'NOMBRE',
		'TIPO_DE_SOLICITANTE',
		'EMAIL',
		'CELULAR'
	];

	public function solicituds()
	{
		return $this->hasMany(Solicitud::class, 'SOLICITANTE_IDSOLICITANTE');
	}
}
