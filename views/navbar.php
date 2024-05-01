<nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Alterna navegação">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=users">Usuários</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=financial">Financeiro</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Aulas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="index.php?page=martialArts">Artes Marciais</a>
                    <a class="dropdown-item" href="#">Agendamento de Aulas</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Algo mais aqui</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
