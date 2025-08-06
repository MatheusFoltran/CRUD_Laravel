@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Produtos</h1>
    <a href="{{ route('produtos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Produto
    </a>
</div>

<!-- Formulário de Busca -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-search"></i> Busca e Filtros
            <button class="btn btn-sm btn-outline-secondary float-end" type="button" data-bs-toggle="collapse" data-bs-target="#searchForm">
                <i class="fas fa-filter"></i> Filtros Avançados
            </button>
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('produtos.index') }}">
            <!-- Busca Principal -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Buscar por nome ou descrição...">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary me-2">Buscar</button>
                    <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Limpar</a>
                </div>
            </div>
            
            <!-- Filtros Avançados -->
            <div class="collapse {{ request()->hasAny(['min_preco', 'max_preco', 'estoque', 'sort', 'data_inicio', 'data_fim']) ? 'show' : '' }}" id="searchForm">
                <hr>
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="min_preco" class="form-label">Preço Mínimo</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" step="0.01" class="form-control" 
                                   id="min_preco" name="min_preco" 
                                   value="{{ request('min_preco') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="max_preco" class="form-label">Preço Máximo</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" step="0.01" class="form-control" 
                                   id="max_preco" name="max_preco" 
                                   value="{{ request('max_preco') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="estoque" class="form-label">Estoque</label>
                        <select class="form-control" id="estoque" name="estoque">
                            <option value="">Todos</option>
                            <option value="disponivel" {{ request('estoque') == 'disponivel' ? 'selected' : '' }}>
                                Disponível
                            </option>
                            <option value="baixo" {{ request('estoque') == 'baixo' ? 'selected' : '' }}>
                                Estoque Baixo (≤5)
                            </option>
                            <option value="esgotado" {{ request('estoque') == 'esgotado' ? 'selected' : '' }}>
                                Esgotado
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" class="form-control" 
                               id="data_inicio" name="data_inicio" 
                               value="{{ request('data_inicio') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" class="form-control" 
                               id="data_fim" name="data_fim" 
                               value="{{ request('data_fim') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="sort" class="form-label">Ordenar por</label>
                        <select class="form-control" id="sort" name="sort" onchange="this.form.submit()">
                            <option value="nome" {{ request('sort') == 'nome' ? 'selected' : '' }}>Nome</option>
                            <option value="preco" {{ request('sort') == 'preco' ? 'selected' : '' }}>Preço</option>
                            <option value="quantidade" {{ request('sort') == 'quantidade' ? 'selected' : '' }}>Quantidade</option>
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Data de Criação</option>
                        </select>
                        <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Resultados -->
@if(request()->hasAny(['search', 'min_preco', 'max_preco', 'estoque', 'data_inicio', 'data_fim']))
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> 
    Encontrados <strong>{{ $produtos->total() }}</strong> produto(s) 
    @if(request('search'))
        para "<strong>{{ request('search') }}</strong>"
    @endif
    @if(request()->hasAny(['min_preco', 'max_preco', 'estoque', 'data_inicio', 'data_fim']))
        com os filtros aplicados
    @endif
    
    @if($produtos->hasPages())
        | Página {{ $produtos->currentPage() }} de {{ $produtos->lastPage() }}
    @endif
</div>
@endif

<!-- Controles de Ordenação -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <small class="text-muted">
            Mostrando {{ $produtos->firstItem() ?? 0 }} - {{ $produtos->lastItem() ?? 0 }} 
            de {{ $produtos->total() }} produtos
        </small>
    </div>
    <div class="btn-group btn-group-sm">
        <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort', 'nome'), 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
           class="btn btn-outline-secondary">
            <i class="fas fa-sort"></i>
            {{ request('direction') === 'asc' ? 'Crescente' : 'Decrescente' }}
        </a>
    </div>
</div>

<!-- Tabela de Produtos -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="text-center">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'nome', 'direction' => request('sort') === 'nome' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                           class="text-decoration-none text-dark">
                            Nome 
                            @if(request('sort') === 'nome')
                                <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'preco', 'direction' => request('sort') === 'preco' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                           class="text-decoration-none text-dark">
                            Preço 
                            @if(request('sort') === 'preco')
                                <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'quantidade', 'direction' => request('sort') === 'quantidade' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                           class="text-decoration-none text-dark">
                            Quantidade 
                            @if(request('sort') === 'quantidade')
                                <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produtos as $produto)
                <tr>
                    <td>
                        <div>
                            <strong>{{ $produto->nome }}</strong>
                            @if($produto->descricao)
                                <br><small class="text-muted">{{ Str::limit($produto->descricao, 50) }}</small>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="fw-bold text-success">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge fs-6 {{ $produto->quantidade > 5 ? 'bg-success' : ($produto->quantidade > 0 ? 'bg-warning' : 'bg-danger') }}">
                            {{ $produto->quantidade }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($produto->quantidade > 5)
                            <span class="badge bg-success">Disponível</span>
                        @elseif($produto->quantidade > 0)
                            <span class="badge bg-warning">Estoque Baixo</span>
                        @else
                            <span class="badge bg-danger">Esgotado</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('produtos.show', $produto) }}" class="btn btn-outline-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-outline-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="Excluir"
                                        onclick="return confirm('Tem certeza?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">
                            @if(request()->hasAny(['search', 'min_preco', 'max_preco', 'estoque', 'data_inicio', 'data_fim']))
                                Nenhum produto encontrado com os filtros aplicados.
                                <br><a href="{{ route('produtos.index') }}">Ver todos os produtos</a>
                            @else
                                Nenhum produto cadastrado.
                                <br><a href="{{ route('produtos.create') }}">Cadastrar primeiro produto</a>
                            @endif
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Paginação -->
@if($produtos->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $produtos->links() }}
</div>
@endif

<style>
.card-header .btn {
    font-size: 0.875rem;
}

.table th a:hover {
    text-decoration: underline !important;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

.badge {
    font-size: 0.75em;
    min-width: 2.5rem;
    padding: 0.5rem 0.75rem;
}

.badge.fs-6 {
    font-size: 0.9rem !important;
    min-width: 3rem;
    padding: 0.6rem 0.8rem;
    font-weight: 600;
}

.alert {
    border-left: 4px solid #0d6efd;
}

/* Centralização das colunas */
.table th.text-center,
.table td.text-center {
    text-align: center !important;
    vertical-align: middle;
}
</style>
@endsection