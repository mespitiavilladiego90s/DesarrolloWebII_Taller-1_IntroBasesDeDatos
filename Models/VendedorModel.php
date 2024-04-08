<?php

require_once 'includes/ActiveRecord.php';

class VendedorModel extends ActiveRecord {

    protected static $tabla = 'vendedor';
    protected static $columnasDB = ['id', 'nombre', 'email', 'telefono', 'direccion','departamento', 'salario', 'fecha_contratacion'];

    public $id;
    public $nombre;
    public $email;
    public $telefono;
    public $direccion;
    public $departamento;
    public $salario;
    public $fecha_contratacion;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->departamento = $args['departamento'] ?? '';
        $this->salario = $args['salario'] ?? '';
        $this->fecha_contratacion = $args['fecha_contratacion'] ?? '';
    }

    public static function validarDatos($datos) {
        $alertas = [];
    
        // Validamos los tipos de datos de los campos y sus longitudes máximas
        if (!is_string($datos['nombre']) || strlen($datos['nombre']) > 100) {
            $alertas['error'][] = 'El nombre debe ser una cadena con máximo 100 caracteres.';
        }
    
        if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL) || strlen($datos['email']) > 100) {
            $alertas['error'][] = 'El email debe ser una dirección de correo electrónico válida con máximo 100 caracteres.';
        }
    
        if (!is_string($datos['telefono']) || strlen($datos['telefono']) > 20) {
            $alertas['error'][] = 'El teléfono debe ser una cadena con máximo 20 caracteres.';
        }
    
        if (!is_string($datos['direccion']) || strlen($datos['direccion']) > 200) {
            $alertas['error'][] = 'La dirección debe ser una cadena con máximo 200 caracteres.';
        }
    
        if (!is_string($datos['departamento']) || strlen($datos['departamento']) > 100) {
            $alertas['error'][] = 'El departamento debe ser una cadena con máximo 100 caracteres.';
        }
    
        if (!is_numeric($datos['salario']) || $datos['salario'] <= 0) {
            $alertas['error'][] = 'El salario debe ser un valor numérico mayor que cero.';
        }
    
        if (!DateTime::createFromFormat('Y-m-d', $datos['fecha_contratacion'])) {
            $alertas['error'][] = 'La fecha de contratación debe tener el formato YYYY-MM-DD.';
        }
    
        return $alertas;
    }

    public static function checkDatos($datos) {
        $alertas = [];
        
        // Listamos los campos permitidos y sus reglas de validación
        $camposValidos = [
            'nombre' => ['tipo' => 'string', 'longitud_maxima' => 100],
            'email' => ['tipo' => 'email', 'longitud_maxima' => 100],
            'telefono' => ['tipo' => 'string', 'longitud_maxima' => 20],
            'direccion' => ['tipo' => 'string', 'longitud_maxima' => 200],
            'departamento' => ['tipo' => 'string', 'longitud_maxima' => 100],
            'salario' => ['tipo' => 'numerico', 'valor_minimo' => 0],
            'fecha_contratacion' => ['tipo' => 'fecha']
        ];
        
        // Verificamos la existencia y validamos cada campo presente en los datos
        foreach ($datos as $campo => $valor) {
            if (isset($camposValidos[$campo])) {
                switch ($camposValidos[$campo]['tipo']) {
                    case 'string':
                        if (!is_string($valor) || strlen($valor) > $camposValidos[$campo]['longitud_maxima']) {
                            $alertas['error'][] = "El campo '$campo' debe ser una cadena con máximo {$camposValidos[$campo]['longitud_maxima']} caracteres.";
                        }
                        break;
                    case 'email':
                        if (!filter_var($valor, FILTER_VALIDATE_EMAIL) || strlen($valor) > $camposValidos[$campo]['longitud_maxima']) {
                            $alertas['error'][] = "El campo '$campo' debe ser una dirección de correo electrónico válida con máximo {$camposValidos[$campo]['longitud_maxima']} caracteres.";
                        }
                        break;
                    case 'numerico':
                        if (!is_numeric($valor) || $valor <= $camposValidos[$campo]['valor_minimo']) {
                            $alertas['error'][] = "El campo '$campo' debe ser un valor numérico mayor que {$camposValidos[$campo]['valor_minimo']}.";
                        }
                        break;
                    case 'fecha':
                        if (!DateTime::createFromFormat('Y-m-d', $valor)) {
                            $alertas['error'][] = "El campo '$campo' debe tener el formato YYYY-MM-DD.";
                        }
                        break;
                    default:
                        // Manejamos otros tipos de campos si es necesario
                        break;
                }
            } else {
                $alertas['error'][] = "El campo '$campo' no es válido.";
            }
        }
        
        return $alertas;
    }
    
}
