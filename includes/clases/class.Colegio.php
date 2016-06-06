<?php
include_once("class.Database.php");

class Colegio
{
	public $id_colegio;
	public $imagen;
	
	function __construct($id_colegio)
    {
        $colegio = Database::select("SELECT * FROM colegio WHERE colegio.IDColegio = $id_colegio LIMIT 1;");
        $colegio = $colegio[0];
        $this->id_colegio = $colegio['IDColegio'];
		$this->imagen = $colegio['Imagen'];
    }
	
	function getCiudad()
    {
        $query = "SELECT Ciudad FROM colegio WHERE IDColegio = $this->id_colegio";
        return Database::select($query);
    }
	
	function getEstado()
    {
        $query = "SELECT Estado FROM colegio WHERE IDColegio = $this->id_colegio";
        return Database::select($query);
    }
	
	function getNombre()
    {
        $query = "SELECT Nombre FROM colegio WHERE IDColegio = $this->id_colegio";
        return Database::select($query);
    }
	
	function getDireccion()
    {
        $query = "SELECT Direccion FROM colegio WHERE IDColegio = $this->id_colegio";
        return Database::select($query);
    }
	
	function getTelefono()
    {
        $query = "SELECT Telefono FROM colegio WHERE IDColegio = $this->id_colegio";
        return Database::select($query);
    }
	
	function getImagen()
	{
		$query = "SELECT Imagen FROM colegio WHERE IDColegio = $this->id_colegio";
        $resultado = Database::select($query);
		return $resultado[0]["Imagen"];
	}
	
	function updateNombre($nombre)
    {
        $query = "UPDATE colegio SET Nombre = '$nombre' WHERE IDColegio = $this->id_colegio";
        return Database::update($query);
    }
	
	function updateDireccion($direccion)
    {
        $query = "UPDATE colegio SET Direccion = '$direccion' WHERE IDColegio = $this->id_colegio";
        return Database::update($query);
    }
	
	function updateTelefono($telefono)
    {
        $query = "UPDATE colegio SET Telefono = '$telefono' WHERE IDColegio = $this->id_colegio";
        return Database::update($query);
    }
	
	function subirImagen($imagen)
	{
		$query = "UPDATE colegio SET Imagen = '$imagen' WHERE IDColegio = $this->id_colegio";
        return Database::update($query);
	}
	
    # Método estáticos

    static function getLista()
    {
        return Database::select("SELECT * FROM colegio");
    }

    public static function insert($ciudad, $estado, $nombre, $direccion, $telefono)
    {
      $query = "INSERT INTO colegio (Ciudad,Estado,Nombre,Direccion,Telefono,Imagen)VALUES
            ('$ciudad', '$estado', '$nombre', '$direccion', '$telefono','null')";
        return Database::insert($query);
    }
}
?>