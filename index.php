<?php
require_once 'config.php';
if (!empty($_SESSION['game']['started'])) {
    header('Location: game.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= GAME_TITLE ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Crimson+Pro:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
</head>
<body class="start-body">
    <div class="start-wrapper">
        <div class="start-content">
            <div class="start-badge">CAMPANHA NARRATIVA</div>
            <h1 class="start-title">SUPERNATURAL</h1>
            <h2 class="start-subtitle">O Último Selo</h2>
            <p class="start-tagline">
                Dois irmãos. Sete selos. Uma entidade que quer apagar a realidade.
            </p>
            <div class="start-features">
                <div class="feat">🔍 Investigação</div>
                <div class="feat">⚔️ Combate</div>
                <div class="feat">🗺️ Exploração</div>
                <div class="feat">📖 Escolhas</div>
            </div>
            <a href="game.php?action=start" class="btn-start">INICIAR CAÇADA</a>
            <p class="start-note">Sam & Dean Winchester · Versão <?= GAME_VERSION ?></p>
        </div>
        <div class="start-fog"></div>
    </div>
</body>
</html>