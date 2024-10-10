<?php

namespace App\Http\Controllers;

use App\Responses\jsonResponse;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function criar(Request $request) {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'saldo_devedor' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Cliente::create($request->all());
        return JsonResponse::success('Customer created sucessfully', $customer);
    }

    public function editar(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'saldo_devedor' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Cliente::findOrFail(id: $id);
        $customer->update($request->all());

        return JsonResponse::success('Customer updated sucessfully', $customer);
    }

    public function excluir(Request $request, $id) {
        $customer = Cliente::findOrFail($id);
        $customer->delete();
        return JsonResponse::success('Customer deleted sucessfully', $customer);

    }

    public function listar() {
        $clientes = Cliente::all();

        return JsonResponse::success(data: $clientes);
    }

    public function exibirPeloId($id) {
            $cliente = Cliente::findOrFail($id);
            return JsonResponse::success('Customer found successfully', $cliente);
        }
        
}
