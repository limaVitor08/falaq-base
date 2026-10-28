<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModeracaoRequest;
use App\Models\Evento;
use App\Models\Moderacao;
use App\Models\Pergunta;
use Illuminate\Http\Request;

class ModeracaoController extends Controller
{
    public function store(StoreModeracaoRequest $request, Pergunta $pergunta)
    {
        $pergunta->moderacoes()->create($request->validated());

        return back()->with('status', 'Denúncia registrada com sucesso!');
    }

    public function index(Evento $evento)
    {
        $this->authorize('moderate', $evento);

        $moderacoes = Moderacao::with('pergunta')
            ->whereRelation('pergunta', 'evento_id', $evento->id)
            ->latest()
            ->paginate(15);

        return $moderacoes;
    }

    public function updateStatus(Request $request, Moderacao $moderacao)
    {
        $this->authorize('moderate', $moderacao->pergunta->evento);

        $request->validate([
            'status' => 'required|in:aprovada,rejeitada',
        ]);

        $moderacao->update(['status' => $request->status]);

        return back()->with('status', 'Status da moderação atualizado!');
    }
}
