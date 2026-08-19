<?php
session_start();

define('GAME_TITLE', 'Supernatural: O Último Selo');
define('GAME_VERSION', '2.0');

function initGame() {
    return [
        'started'       => true,
        'location'      => 'bunker',
        'scene'         => 'main',
        'character'     => 'dean',
        'hp'            => ['sam' => 100, 'dean' => 100],
        'max_hp'        => ['sam' => 100, 'dean' => 100],
        'inventory'     => ['prayer_book' => 1, 'salt' => 3, 'holy_water' => 2],
        'seals'         => [],
        'flags'         => [],
        'log'           => [],
        'combat'        => null,
        'visited'       => ['bunker' => true],
        'chapter'       => 0,
        'knowledge'     => 0,   // pontos de investigação (Sam)
        'kills'         => 0,
    ];
}

if (!isset($_SESSION['game']) || !is_array($_SESSION['game'])) {
    $_SESSION['game'] = ['started' => false];
}

function G() { return $_SESSION['game']; }
function S($data) { $_SESSION['game'] = $data; }

function flag($key, $val = null) {
    if ($val === null) return !empty($_SESSION['game']['flags'][$key]);
    $_SESSION['game']['flags'][$key] = $val;
}

function hasItem($id, $qty = 1) {
    return ($_SESSION['game']['inventory'][$id] ?? 0) >= $qty;
}

function addItem($id, $qty = 1) {
    $_SESSION['game']['inventory'][$id] = ($_SESSION['game']['inventory'][$id] ?? 0) + $qty;
}

function removeItem($id, $qty = 1) {
    if (!hasItem($id, $qty)) return false;
    $_SESSION['game']['inventory'][$id] -= $qty;
    if ($_SESSION['game']['inventory'][$id] <= 0) unset($_SESSION['game']['inventory'][$id]);
    return true;
}

function addSeal($id) {
    if (!in_array($id, $_SESSION['game']['seals'])) {
        $_SESSION['game']['seals'][] = $id;
        logMsg("✦ Selo obtido: " . sealName($id), 'seal');
    }
}

function sealName($id) {
    $names = [
        1 => 'Selo da Floresta', 2 => 'Selo da Casa', 3 => 'Selo do Sangue',
        4 => 'Selo da Mina', 5 => 'Selo Perdido', 6 => 'Selo da Biblioteca', 7 => 'Selo da Igreja'
    ];
    return $names[$id] ?? "Selo #$id";
}

function logMsg($text, $type = 'info') {
    $_SESSION['game']['log'][] = ['text' => $text, 'type' => $type, 'time' => time()];
    if (count($_SESSION['game']['log']) > 8) {
        array_shift($_SESSION['game']['log']);
    }
}

function clearLog() {
    $_SESSION['game']['log'] = [];
}

function heal($who, $amount) {
    $g = &$_SESSION['game'];
    $g['hp'][$who] = min($g['max_hp'][$who], $g['hp'][$who] + $amount);
}

function damage($who, $amount) {
    $g = &$_SESSION['game'];
    $g['hp'][$who] = max(0, $g['hp'][$who] - $amount);
    if ($g['hp'][$who] <= 0) {
        logMsg(($who === 'sam' ? 'Sam' : 'Dean') . ' caiu inconsciente!', 'danger');
    }
}

function isAlive($who) {
    return ($_SESSION['game']['hp'][$who] ?? 0) > 0;
}
?>