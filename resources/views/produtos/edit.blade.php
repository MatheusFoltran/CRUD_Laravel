@extends('layouts.app')

@section('content')
<h1>Editar Produto</h1>

<form action="{{ route('produtos.update', $produto) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" 
               id="nome" name="nome" value="{{ old('nome', $produto->nome) }}" required>
        @error('nome')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                  id="descricao" name="descricao" rows="3">{{ old('descricao', $produto->descricao) }}</textarea>
        @error('descricao')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="preco" class="form-label">Preço</label>
        <input type="number" step="0.01" class="form-control @error('preco') is-invalid @enderror" 
               id="preco" name="preco" value="{{ old('preco', $produto->preco) }}" required>
        @error('preco')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="quantidade" class="form-label">Quantidade</label>
        <input type="number" class="form-control @error('quantidade') is-invalid @enderror" 
               id="quantidade" name="quantidade" value="{{ old('quantidade', $produto->quantidade) }}" required>
        @error('quantidade')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('produtos.show', $produto) }}" class="btn btn-info">Ver Produto</a>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
@endsection