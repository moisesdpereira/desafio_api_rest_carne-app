<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Carne;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CarneController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'valor_total'               => 'required|numeric|min:0.01',
                'qtd_parcelas'              => 'required|integer|min:1',
                'data_primeiro_vencimento'  => 'required|date',
                'periodicidade'             => 'required|in:mensal,semanal',
                'valor_entrada'             => 'nullable|numeric|min:0'
            ]);

            $data = $request->only(['valor_total', 'qtd_parcelas', 'data_primeiro_vencimento', 'periodicidade', 'valor_entrada']);
            $carne = Carne::create($data);

            // Geração das parcelas
            $parcelas = $this->gerarParcelas($carne);

            return response()->json([
                'total'         => $carne->valor_total,
                'valor_entrada' => $carne->valor_entrada,
                'parcelas'      => $parcelas,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação',
                'errors'  => $e->errors(),
            ], 422); // 422 Unprocessable Entity
        }
    }

    public function getParcelas($id)
    {
        $carne = Carne::findOrFail($id);
        $parcelas = $this->gerarParcelas($carne);

        return response()->json($parcelas);
    }

    private function gerarParcelas(Carne $carne)
    {
        $parcelas = [];
        $valor_restante  = $carne->valor_total - $carne->valor_entrada;
        $valor_parcela   = $valor_restante / $carne->qtd_parcelas;
        $data_vencimento = Carbon::parse($carne->data_primeiro_vencimento);

        // Adicionar entrada (se houver)
        if ($carne->valor_entrada > 0) {
            $parcelas[] = [
                'numero' => 0,
                'data_vencimento' => Carbon::parse($carne->created_at)->format('Y-m-d'),
                'valor' => $carne->valor_entrada,
                'entrada' => true
            ];
        }

        // Gerar as parcelas normais
        for ($i = 1; $i <= $carne->qtd_parcelas; $i++) {
            $parcelas[] = [
                'numero' => $i,
                'data_vencimento' => $data_vencimento->format('Y-m-d'),
                'valor' => round($valor_parcela, 2),
            ];

            if ($carne->periodicidade == 'mensal') {
                $data_vencimento->addMonth();
            } elseif ($carne->periodicidade == 'semanal') {
                $data_vencimento->addWeek();
            }
        }

        return $parcelas;
    }
}
