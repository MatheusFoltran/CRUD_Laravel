<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::query();
        
        // Busca por nome ou descrição
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nome', 'like', '%' . $searchTerm . '%')
                  ->orWhere('descricao', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Filtro por preço mínimo
        if ($request->filled('min_preco')) {
            $query->where('preco', '>=', $request->min_preco);
        }
        
        // Filtro por preço máximo
        if ($request->filled('max_preco')) {
            $query->where('preco', '<=', $request->max_preco);
        }
        
        // Filtro por quantidade em estoque
        if ($request->filled('estoque')) {
            switch ($request->estoque) {
                case 'disponivel':
                    $query->where('quantidade', '>', 0);
                    break;
                case 'baixo':
                    $query->where('quantidade', '>', 0)->where('quantidade', '<=', 5);
                    break;
                case 'esgotado':
                    $query->where('quantidade', '=', 0);
                    break;
            }
        }
        
        // Filtro por data
        if ($request->filled('data_inicio')) {
            $query->where('created_at', '>=', $request->data_inicio);
        }
        
        if ($request->filled('data_fim')) {
            $query->where('created_at', '<=', $request->data_fim . ' 23:59:59');
        }
        
        // Ordenação
        $sortField = $request->get('sort', 'nome');
        $sortDirection = $request->get('direction', 'asc');
        
        // Validar campos de ordenação permitidos
        $allowedSorts = ['nome', 'preco', 'quantidade', 'created_at'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'nome';
        }
        
        $query->orderBy($sortField, $sortDirection);
        
        $produtos = $query->paginate(10)->withQueryString();
        
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0'
        ]);

        Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'quantidade' => $request->quantidade
        ]);
        
        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
    }

    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0'
        ]);

        $produto->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'quantidade' => $request->quantidade
        ]);
        
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
}