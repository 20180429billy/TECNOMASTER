<?php
require_once('api/libraries/fpdf182/fpdf.php');

class Report extends FPDF
{
    const CLIENT_URL = 'http://localhost/tecnomaster/views/dashboard/';

    public function startReport($title)
    {
        ini_set('date.timezone', 'America/El_Salvador');
        session_start();
        if (isset($_SESSION['id_usuario'])) {
            $this->title = $title;
            $this->setTitle('Dashboard - Reporte', true);
            $this->setMargins(15, 15, 15);
            $this->addPage('p', 'letter');
            $this->aliasNbPages();
        } else {
            header('location:' . self::CLIENT_URL);
        }
    }

    public function encodeString($string)
    {
        return mb_convert_encoding($string, 'ISO-8859-1', 'utf-8');
    }

}