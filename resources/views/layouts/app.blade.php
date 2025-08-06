<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('produtos.index') }}">CRUD Produtos</a>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit em mudanças de filtro
    const autoSubmitElements = document.querySelectorAll('#estoque, #sort, #data_inicio, #data_fim');
    autoSubmitElements.forEach(element => {
        element.addEventListener('change', function() {
            this.form.submit();
        });
    });
    
    // Busca em tempo real (com delay)
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Opcional: submeter automaticamente após 1 segundo
                // this.form.submit();
            }, 1000);
        });
    }
    
    // Atalho de teclado para busca (Ctrl/Cmd + K)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }
    });
    
    // Animação nos cards de resultado
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.1}s`;
        row.classList.add('fade-in');
    });
});
</script>

<style>
.fade-in {
    animation: fadeInUp 0.5s ease-out forwards;
    opacity: 0;
    transform: translateY(10px);
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Highlight nos termos de busca */
.highlight {
    background-color: yellow;
    padding: 0 2px;
    border-radius: 2px;
}

/* Melhorar aparência dos controles */
.form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn-group .btn {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}
</style>