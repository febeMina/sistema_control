<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Maestros extends Controller
{
    public function index()
    {
        // Aquí puedes cargar todos los maestros desde la base de datos
        $db = \Config\Database::connect();
        $builder = $db->table('docente');
        $maestros = $builder->get()->getResult();

        // Puedes pasar los datos a la vista de index
        return view('index', ['maestros' => $maestros]);
        
    }

    public function create()
    {
        // Muestra el formulario para crear un nuevo maestro
        return view('maestros/create');
    }

    public function store()
{
    // Capturar los datos del formulario de creación
    $request = \Config\Services::request();
    $nombre_completo = $request->getVar('nombre_completo');
    $nip = $request->getVar('nip');
    $escalafon = $request->getVar('escalafon');
    $fecha_ingreso = $request->getVar('fecha_ingreso');
    $estado = $request->getVar('estado');

    // Guardar los datos en la base de datos
    $db = \Config\Database::connect();
    $builder = $db->table('docente');
    $data = [
        'nombre_completo' => $nombre_completo,
        'nip' => $nip,
        'escalafon' => $escalafon,
        'fecha_ingreso' => $fecha_ingreso,
        'estado' => $estado
    ];
    $builder->insert($data);


    $response = ['success' => true];
    return $this->response->setJSON($response);
        // Devolver una respuesta JSON
        return json_encode(['success' => true]);
    }

    public function edit($id)
    {
        // Aquí deberías cargar los datos del maestro a editar desde la base de datos
        $db = \Config\Database::connect();
        $builder = $db->table('docente');
        $maestro = $builder->getWhere(['idDocente' => $id])->getRow();

        // Puedes pasar los datos a la vista de edición
        return view('maestros/edit', ['maestro' => $maestro]);
    }

    public function update($id)
    {
        // Capturar los datos del formulario de edición
        $request = \Config\Services::request();
        $nombre_completo = $request->getVar('nombre_completo');
        $nip = $request->getVar('nip');
        $escalafon = $request->getVar('escalafon');
        $fecha_ingreso = $request->getVar('fecha_ingreso');
        $estado = $request->getVar('estado');
    
        // Actualizar los datos en la base de datos
        $db = \Config\Database::connect();
        $builder = $db->table('docente');
        $data = [
            'nombre_completo' => $nombre_completo,
            'nip' => $nip,
            'escalafon' => $escalafon,
            'fecha_ingreso' => $fecha_ingreso,
            'estado' => $estado
        ];
        $builder->where('idDocente', $id);
        $builder->update($data);
    
        // Redireccionar a la página principal o mostrar un mensaje de éxito
        return redirect()->to('/');
    }

    public function delete($id)
    {
        // Eliminar el maestro de la base de datos
        $db = \Config\Database::connect();
        $builder = $db->table('docente');
        $builder->where('idDocente', $id);
        $builder->delete();

        // Redireccionar a la página principal o mostrar un mensaje de éxito
        return redirect()->to('/');
    }
}
