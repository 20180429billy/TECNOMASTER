<?php
require_once('api/helpers/validator.php');
require_once('api/entities/dao/usuario_queries.php');

class usuario extends UsuarioQueries
{
    protected $id = null;
    protected $nombre = null;
    protected $apellido = null;
    protected $correo = null;
    protected $alias = null;
    protected $tipo_usuario = null;
    protected $estado_usuario = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombre($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombres = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellido($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->apellidos = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setAlias($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->alias = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipo_usuario($value)
    {
        if (validator::validateBoolean($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado_usuario($value)
    {
        if(validator::validateBoolean($value)) {
            $this->estado = value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getTipo_usuario()
    {
        return $this->tipo_usuario;
    }

    public function getEstado_usuario()
    {
        return $this->estado_usuario;
    }
}

