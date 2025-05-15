<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @group Usuarios
     * APIs para gestión de usuarios
     */

    /**
     * Obtener listado de usuarios.
     *
     * Retorna todos los usuarios registrados.
     *
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "username": "usuario1",
     *       "name": "Nombre Usuario",
     *       "email": "usuario@example.com",
     *       "biography": "Biografía del usuario",
     *       "role_id": 2
     *     }
     *   ]
     * }
     */
    public function index()
    {
        return response()->json(['data' => User::all()]);
    }

    /**
     * Crear un nuevo usuario.
     *
     * Crea un usuario nuevo. Solo accesible para usuarios con permiso Admin.
     *
     * @authenticated
     * @bodyParam username string required Nombre de usuario único. Example: "nuevoUsuario"
     * @bodyParam name string required Nombre completo del usuario. Example: "Juan Pérez"
     * @bodyParam email string required Correo electrónico único. Example: "juan@example.com"
     * @bodyParam password string required Contraseña (mínimo 6 caracteres). Example: "secreto123"
     * @bodyParam biography string Opcional. Biografía corta del usuario. Example: "Desarrollador Laravel"
     * @bodyParam role_id integer Opcional. ID del rol asignado. Example: 1
     *
     * @response 201 {
     *   "data": {
     *     "id": 10,
     *     "username": "nuevoUsuario",
     *     "name": "Juan Pérez",
     *     "email": "juan@example.com",
     *     "biography": "Desarrollador Laravel",
     *     "role_id": 1
     *   }
     * }
     *
     * @response 403 {
     *   "message": "Forbidden"
     * }
     */
    public function store(Request $request)
    {


        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'biography' => 'nullable|string',
            'role_id' => 'nullable|integer',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json(['data' => $user], 201);
    }

    /**
     * Obtener un usuario específico.
     *
     * Muestra la información de un usuario por su ID.
     *
     * @authenticated
     *
     * @urlParam id integer required ID del usuario. Example: 1
     *
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "username": "usuario1",
     *     "name": "Nombre Usuario",
     *     "email": "usuario@example.com",
     *     "biography": "Biografía del usuario",
     *     "role_id": 2
     *   }
     * }
     *
     * @response 404 {
     *   "message": "User not found"
     * }
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['data' => $user]);
    }

    /**
     * Actualizar un usuario existente.
     *
     * Actualiza la información de un usuario. Solo accesible para Admin.
     *
     * @authenticated
     * @urlParam id integer required ID del usuario a actualizar. Example: 1
     * @bodyParam username string Nombre de usuario único. Example: "usuarioActualizado"
     * @bodyParam name string Nombre completo. Example: "Juan Pérez Actualizado"
     * @bodyParam email string Correo electrónico único. Example: "juan.nuevo@example.com"
     * @bodyParam password string Contraseña (mínimo 6 caracteres). Example: "nuevoSecreto123"
     * @bodyParam biography string Biografía. Example: "Desarrollador Laravel Senior"
     * @bodyParam role_id integer ID del rol. Example: 2
     *
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "username": "usuarioActualizado",
     *     "name": "Juan Pérez Actualizado",
     *     "email": "juan.nuevo@example.com",
     *     "biography": "Desarrollador Laravel Senior",
     *     "role_id": 2
     *   }
     * }
     *
     * @response 403 {
     *   "message": "Forbidden"
     * }
     *
     * @response 404 {
     *   "message": "User not found"
     * }
     */
    public function update(Request $request, $id)
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'username' => 'sometimes|string|unique:users,username,' . $user->id,
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6',
            'biography' => 'nullable|string',
            'role_id' => 'nullable|integer',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json(['data' => $user]);
    }

    /**
     * Eliminar un usuario.
     *
     * Borra un usuario por ID. Solo accesible para Admin.
     *
     * @authenticated
     * @urlParam id integer required ID del usuario a eliminar. Example: 1
     *
     * @response 200 {
     *   "message": "User deleted"
     * }
     *
     * @response 403 {
     *   "message": "Forbidden"
     * }
     *
     * @response 404 {
     *   "message": "User not found"
     * }
     */
    public function destroy($id)
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
