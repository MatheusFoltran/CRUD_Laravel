@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Detalhes do Produto</h1>
    <div>
        <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $produto->nome }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>ID:</strong> {{ $produto->id }}</p>
                <p><strong>Nome:</strong> {{ $produto->nome }}</p>
                <p><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                <p><strong>Quantidade:</strong> {{ $produto->quantidade }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Data de Criação:</strong> {{ $produto->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Última Atualização:</strong> {{ $produto->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        
        @if($produto->descricao)
        <div class="mt-3">
            <strong>Descrição:</strong>
            <p class="mt-2">{{ $produto->descricao }}</p>
        </div>
        @endif
    </div>
</div>

<div class="mt-3">
    <form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
            Excluir Produto
        </button>
    </form>
</div>
@endsection