<?php
require_once 'config.php';
require_once 'data/items.php';
require_once 'data/locations.php';
require_once 'data/actions.php';

// ========== AÇÕES GLOBAIS ==========
if (isset($_GET['action'])) {
    $act = $_GET['action'];

    if ($act === 'start') {
        $_SESSION['game'] = initGame();
        header('Location: game.php');
        exit;
    }
    if ($act === 'reset') {
        session_destroy();
        header('Location: index.php');
        exit;
    }
    if ($act === 'do' && isset($_GET['id'])) {
        processAction($_GET['id']);
        header('Location: game.php');
        exit;
    }
    if ($act === 'combat' && isset($_GET['cmd'])) {
        processCombatAction($_GET['cmd']);
        header('Location: game.php');
        exit;
    }
    if ($act === 'go_to' && isset($_GET['dest'])) {
        processAction('go_to');
        header('Location: game.php');
        exit;
    }
    if ($act === 'use_item' && isset($_GET['item'])) {
        processAction('use_item');
        header('Location: game.php');
        exit;
    }
    if ($act === 'switch') {
        processAction('switch_char');
        header('Location: game.php');
        exit;
    }
}

$g = G();
if (empty($g['started'])) {
    header('Location: index.php');
    exit;
}

$locId = $g['location'];
$sceneId = $g['scene'];
$char = $g['character'];
$inCombat = !empty($g['combat']);
$inTravel = ($sceneId === 'travel');
$isEnding = ($sceneId === 'ending');

$loc = $LOCATIONS[$locId] ?? $LOCATIONS['bunker'];
$scene = $loc['scenes'][$sceneId] ?? ($loc['scenes'][array_key_first($loc['scenes'])] ?? null);

$logs = $g['log'] ?? [];
$sealsCount = count($g['seals']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($loc['name'] ?? 'Jogo') ?> | <?= GAME_TITLE ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Crimson+Pro:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
</head>
<body class="immersive <?= $inCombat ? 'mode-combat' : '' ?>">
<!-- Fundo do cenário em tela cheia -->
<div class="world-bg" style="background-image: url('assets/img/locations/<?= htmlspecialchars($loc['bg'] ?? 'bunker.jpg') ?>')"></div>
<div class="world-overlay"></div>
<div class="world-vignette"></div>
<div class="world-grain"></div>

<div class="app">

    <!-- ===== TOP BAR ===== -->
    <header class="topbar">
        <div class="brand">
            <span class="brand-main">SUPERNATURAL</span>
            <span class="brand-sub">O Último Selo</span>
        </div>
        <div class="top-stats">
            <div class="stat seals-stat" title="Selos recuperados">
                <span class="stat-icon">✦</span>
                <span><?= $sealsCount ?>/7</span>
            </div>
            <div class="stat" title="Conhecimento">
                <span class="stat-icon">📖</span>
                <span><?= $g['knowledge'] ?></span>
            </div>
            <div class="stat" title="Criaturas derrotadas">
                <span class="stat-icon">💀</span>
                <span><?= $g['kills'] ?></span>
            </div>
        </div>
        <div class="top-actions">
            <a href="game.php?action=switch" class="btn-icon" title="Trocar personagem">⇄</a>
            <a href="game.php?action=reset" class="btn-icon danger" title="Reiniciar" onclick="return confirm('Reiniciar o jogo?')">↻</a>
        </div>
    </header>

    <!-- ===== CHARACTERS ===== -->
    <section class="chars">
        <?php foreach (['sam' => 'Sam Winchester', 'dean' => 'Dean Winchester'] as $cid => $cname): 
            $active = ($char === $cid);
            $hp = $g['hp'][$cid];
            $max = $g['max_hp'][$cid];
            $pct = max(0, min(100, ($hp / $max) * 100));
            $role = $cid === 'sam' ? 'Investigação · Rituais · Estratégia' : 'Combate · Armas · Proteção';
        ?>
        <div class="char-card <?= $cid ?> <?= $active ? 'active' : '' ?> <?= $hp <= 0 ? 'down' : '' ?>">
            <div class="char-avatar">
                <img src="assets/img/characters/<?= $cid ?>.png" alt="<?= $cname ?>"
                     onerror="this.parentElement.innerHTML='<div class=\'avatar-fallback\'><?= strtoupper($cid) ?></div>'">
            </div>
            <div class="char-body">
                <div class="char-name"><?= $cname ?></div>
                <div class="char-role"><?= $role ?></div>
                <div class="hp-track">
                    <div class="hp-fill" style="width:<?= $pct ?>%"></div>
                </div>
                <div class="hp-text"><?= $hp ?>/<?= $max ?></div>
            </div>
            <?php if ($active): ?><div class="active-tag">ATIVO</div><?php endif; ?>
        </div>
        <?php endforeach; ?>
    </section>

    <!-- ===== MAIN ===== -->
    <main class="main">

        <?php if ($inCombat): 
            $c = $g['combat'];
            $en = $c['enemy'];
            $epct = max(0, ($en['hp'] / $en['max_hp']) * 100);
        ?>
        <!-- COMBATE -->
        <div class="panel combat-panel">
            <div class="combat-header">
                <h2>⚔️ COMBATE</h2>
                <p class="combat-desc"><?= htmlspecialchars($en['desc']) ?></p>
            </div>
            <div class="enemy-box">
                <div class="enemy-name"><?= htmlspecialchars($en['name']) ?></div>
                <div class="hp-track enemy">
                    <div class="hp-fill enemy-fill" style="width:<?= $epct ?>%"></div>
                </div>
                <div class="hp-text"><?= $en['hp'] ?>/<?= $en['max_hp'] ?></div>
            </div>
            <div class="combat-log">
                <?php foreach (array_slice($c['log'] ?? [], -6) as $line): ?>
                    <div class="clog-line"><?= htmlspecialchars($line) ?></div>
                <?php endforeach; ?>
            </div>
            <div class="combat-actions">
                <a href="game.php?action=combat&cmd=attack" class="cbtn attack">⚔️ Atacar</a>
                <a href="game.php?action=combat&cmd=defend" class="cbtn defend">🛡️ Defender</a>
                <a href="game.php?action=combat&cmd=special" class="cbtn special">
                    <?= $char === 'sam' ? '📖 Ritual' : '💥 Tiro Poderoso' ?>
                </a>
                <?php if (hasItem('salt')): ?>
                <a href="game.php?action=combat&cmd=item_salt" class="cbtn item">🧂 Sal</a>
                <?php endif; ?>
                <a href="game.php?action=combat&cmd=flee" class="cbtn flee">🏃 Fugir</a>
            </div>
        </div>

        <?php elseif ($inTravel): ?>
        <!-- VIAGEM -->
        <div class="panel travel-panel">
            <h2>🚗 Para onde vamos?</h2>
            <p class="muted">Escolha o destino no Impala.</p>
            <div class="travel-grid">
                <?php foreach (getAvailableLocations() as $tid => $tname): ?>
                    <a href="game.php?action=go_to&dest=<?= urlencode($tid) ?>" 
                       class="travel-card <?= $tid === $locId ? 'current' : '' ?>">
                        <span class="tname"><?= htmlspecialchars($tname) ?></span>
                        <?php if ($tid === $locId): ?><span class="tcur">atual</span><?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <a href="game.php?action=do&id=back_from_travel" class="btn-secondary">← Ficar no bunker</a>
        </div>
        <?php
            // fix travel back
            if ($sceneId === 'travel') {
                // show travel, but allow returning
            }
        ?>

        <?php elseif ($isEnding): ?>
        <!-- FINAL -->
        <div class="panel ending-panel">
            <h2>✦ O Vazio foi selado</h2>
            <div class="story-text ending-text">
                Alguns dias depois, Sam e Dean estão novamente no bunker.<br><br>
                Os sete selos estão guardados em local seguro.<br><br>
                Dean aparece com as chaves do Impala.<br>
                — Pronto?<br><br>
                Sam fecha o computador. Os dois saem.<br><br>
                O Impala percorre a estrada. O rádio toca.<br>
                Dean dirige. Sam olha a próxima caçada.<br><br>
                <em>"Algumas histórias terminam. As caçadas, nunca."</em>
            </div>
            <div class="ending-stats">
                <div>Selos: <?= $sealsCount ?>/7</div>
                <div>Conhecimento: <?= $g['knowledge'] ?></div>
                <div>Derrotas: <?= $g['kills'] ?></div>
            </div>
            <a href="game.php?action=reset" class="btn-start">Jogar Novamente</a>
        </div>

        <?php else: ?>
        <!-- CENA NORMAL — imersiva -->
        <div class="panel scene-panel glass">
            <div class="location-hero">
                <div class="loc-bg" style="background-image:url('assets/img/locations/<?= htmlspecialchars($loc['bg'] ?? '') ?>')"></div>
                <div class="loc-gradient"></div>
                <div class="loc-info">
                    <div class="loc-name"><?= htmlspecialchars($loc['name']) ?></div>
                    <div class="scene-title"><?= htmlspecialchars($scene['title'] ?? '') ?></div>
                    <?php if (!empty($loc['desc'])): ?>
                    <div class="loc-desc"><?= htmlspecialchars($loc['desc']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="scene-body">
                <div class="story-text">
                    <?= nl2br(htmlspecialchars($scene['text'] ?? 'Você está aqui.')) ?>
                </div>

                <?php if (!empty($logs)): ?>
                <div class="game-log">
                    <?php foreach (array_reverse($logs) as $l): ?>
                        <div class="log-item <?= htmlspecialchars($l['type']) ?>">
                            <?= htmlspecialchars($l['text']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="actions-grid">
                    <?php
                    $actions = $scene['actions'] ?? [];
                    foreach ($actions as $a):
                        if (isset($a['req_char']) && $a['req_char'] !== $char && $a['req_char'] !== 'both') continue;
                        if (isset($a['req_item']) && !hasItem($a['req_item'])) continue;
                        $hint = '';
                        if (isset($a['char']) && $a['char'] !== 'both' && $a['char'] !== $char) {
                            $hint = ' dim';
                        }
                    ?>
                        <a href="game.php?action=do&id=<?= urlencode($a['id']) ?>" 
                           class="action-btn<?= $hint ?>">
                            <?= htmlspecialchars($a['label']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- INVENTÁRIO (sidebar) -->
        <aside class="inventory-panel">
            <h3>Inventário</h3>
            <div class="inv-list">
                <?php if (empty($g['inventory'])): ?>
                    <div class="inv-empty">Vazio</div>
                <?php else: ?>
                    <?php foreach ($g['inventory'] as $iid => $qty): 
                        $item = $ITEMS[$iid] ?? ['name' => $iid, 'icon' => '❓', 'desc' => ''];
                    ?>
                    <div class="inv-item" title="<?= htmlspecialchars($item['desc']) ?>">
                        <span class="inv-icon"><?= $item['icon'] ?></span>
                        <span class="inv-name"><?= htmlspecialchars($item['name']) ?></span>
                        <span class="inv-qty">×<?= $qty ?></span>
                        <?php if (in_array($item['type'] ?? '', ['consumable'])): ?>
                            <a href="game.php?action=use_item&item=<?= urlencode($iid) ?>" class="inv-use">usar</a>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <h3 style="margin-top:20px">Selos</h3>
            <div class="seals-row">
                <?php for ($i = 1; $i <= 7; $i++): ?>
                    <div class="seal-dot <?= in_array($i, $g['seals']) ? 'got' : '' ?>" title="<?= sealName($i) ?>">
                        <?= in_array($i, $g['seals']) ? '✦' : $i ?>
                    </div>
                <?php endfor; ?>
            </div>
        </aside>
    </main>

    <footer class="footer">
        Supernatural: O Último Selo · v<?= GAME_VERSION ?> · 
        Personagem ativo: <strong><?= $char === 'sam' ? 'Sam' : 'Dean' ?></strong>
    </footer>
</div>
</body>
</html>
<?php
// limpa log depois de mostrar (mantém os últimos na sessão até próxima ação limpar via clear? 
// na verdade vamos manter e só adicionar novos; opcionalmente limitar
if (count($g['log']) > 6) {
    $_SESSION['game']['log'] = array_slice($g['log'], -6);
}
?>