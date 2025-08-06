@extends('layouts.app')

@section('content')
<h1>Novo Produto</h1>

<form action="{{ route('produtos.store') }}" method="POST">
    @csrf
    
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" 
               id="nome" name="nome" value="{{ old('nome') }}" required>
        @error('nome')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ old('descricao') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="preco" class="form-label">Preço</label>
        <input type="number" step="0.01" class="form-control @error('preco') is-invalid @enderror" 
               id="preco" name="preco" value="{{ old('preco') }}" required>
        @error('preco')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="quantidade" class="form-label">Quantidade</label>
        <input type="number" class="form-control @error('quantidade') is-invalid @enderror" 
               id="quantidade" name="quantidade" value="{{ old('quantidade') }}" required>
        @error('quantidade')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection