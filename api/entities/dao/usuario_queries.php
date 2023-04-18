<?php
require_once('api/helpers/database.php');

class UsuarioQueries
{
    public function checkUser($alias)
    {
        $sql = 'SELECT id_usuario FROM usuario WHERE alias_usuario = ?';
        $params = array($alias);
        if($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_usuario'];
            $this->alias = $alias;
            return true;
        } else {
            return false;
        }
    }

    public function chechPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuario WHERE id_usuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        if(password_verify($password, $data['clave_usuario'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE usuario SET clave_usuario = ? WHERE id_usuario = ?';
        $params = array($this->clave, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }


    public function readProfile()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, id_tipo_usuario, id_estado_usuario
                FROM usuario
                WHERE id_usuario = ?';
        $params = array($_SESSION['id_usuario']);
        return Database::getRow($sql, $params);
    }

    public function editprofile()
    {
        $sql = 'UPDATE usuario
                SET nombre_usuario = ?, apellido_usuario = ?, alias_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->nombre, $this->apellido, $this->correo, $this->alias, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, id_tipo_usuario, id_estado_usuario
                FROM usuario
                WHERE apellido_usuario ILIKE ? OR nombre_usuario ILIKE ?
                ORDER BY apellido_usuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO usuario(nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, id_tipo_usuario, id_estado_usuario)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->apellido, $this->correo, $this->alias, $this->tipo_usuario, $this->estado_usuario);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, id_tipo_usuario, id_estado_usuario)
                FROM usuario
                ORDER BY apellido_usuario';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, id_tipo_usuario, id_estado_usuario)
                FROM usuario
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuario
                SET nombre_usuario = ?, apellido_usuario = ?, correo_usuario = ?, 
                WHERE id_usuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuario
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }



}