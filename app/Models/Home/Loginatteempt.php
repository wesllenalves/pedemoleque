<?php

namespace App\Models\Home;

use Core\EloquentModel;
use App\Models\Home\Cliente;
use Core\Funcoes;

/**
 * Description of Loginatteempt
 *
 * @author laboratorio
 */
class Loginatteempt extends EloquentModel {

    public $table = "login_attempts";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = ['id', 'user_id', 'created_at'];

    public function cliente() {
        return $this->hasOne(Cliente::class);
    }

    public static function TotalDeTentativas($id) {        
        if (!is_null($id)) {
            $totalTentativas = Loginatteempt::all()->where('user_id', '=', $id);
            return count($totalTentativas);
        }
    }

    public static function RegistraTentativa($id) {        
        $dados = ['user_id' => $id, 'created_at' => Funcoes::dataAtual(2)];        
        $inserir = Loginatteempt::create($dados);
        return $inserir;
    }

    public static function LimparTentativa($id) {
        $delatar = Loginatteempt::where('user_id', '=', $id)->delete();
        return $delatar;
    }

}
