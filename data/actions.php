<?php
/**
 * Processa todas as ações do jogo.
 * Retorna true se a ação foi processada (e deve redirecionar).
 */
function processAction($actionId) {
    $g = &$_SESSION['game'];
    $loc = $g['location'];
    $char = $g['character'];

    // ========== BUNKER ==========
    if ($loc === 'bunker') {
        switch ($actionId) {
            case 'research':
                if ($char !== 'sam') { logMsg('Só Sam consegue pesquisar com eficiência.', 'danger'); return true; }
                if (!flag('prolog_done')) {
                    logMsg('Você precisa investigar Black Creek primeiro.', 'info');
                    return true;
                }
                if (!flag('researched_order')) {
                    flag('researched_order', true);
                    $g['knowledge'] += 2;
                    addItem('old_documents');
                    logMsg('Sam encontrou registros da Ordem do Véu Negro e do Vazio Eterno.', 'success');
                    logMsg('Documentos Antigos adicionados ao inventário.', 'info');
                } else {
                    logMsg('Sam já pesquisou tudo o que havia nos arquivos por enquanto.', 'info');
                    $g['knowledge'] += 1;
                }
                return true;

            case 'armory':
                if ($char !== 'dean') { logMsg('Dean conhece melhor o arsenal.', 'danger'); return true; }
                if (!flag('armory_looted')) {
                    flag('armory_looted', true);
                    addItem('silver_knife');
                    addItem('iron_rod');
                    addItem('first_aid', 2);
                    logMsg('Dean equipou Faca de Prata, Barra de Ferro e kits médicos.', 'success');
                } else {
                    logMsg('O arsenal já foi verificado.', 'info');
                    heal('dean', 15);
                    heal('sam', 15);
                    logMsg('Vocês se reorganizaram. +15 HP.', 'success');
                }
                return true;

            case 'rest':
                heal('sam', 50);
                heal('dean', 50);
                logMsg('Vocês descansaram. Vida parcialmente restaurada.', 'success');
                return true;

            case 'check_seals':
                $count = count($g['seals']);
                if ($count === 0) {
                    logMsg('Nenhum selo recuperado ainda.', 'info');
                } else {
                    $names = array_map('sealName', $g['seals']);
                    logMsg("Selos em posse ($count/7): " . implode(', ', $names), 'seal');
                }
                return true;

            case 'travel':
                $g['scene'] = 'travel';
                return true;
        }
    }

    // Voltar da tela de viagem
    if ($actionId === 'back_from_travel') {
        $g['location'] = 'bunker';
        $g['scene'] = 'main';
        return true;
    }

    // ========== BLACK CREEK ==========
    if ($loc === 'black_creek') {
        switch ($actionId) {
            case 'enter_church':
                $g['scene'] = 'inside';
                logMsg('Vocês entram na igreja abandonada.', 'info');
                return true;
            case 'examine_marks':
                if ($char !== 'sam') { logMsg('Sam notaria mais detalhes.', 'info'); }
                logMsg('As marcas formam o mesmo símbolo das vítimas: sete linhas em círculo.', 'info');
                $g['knowledge'] += 1;
                return true;
            case 'scout':
                logMsg('Dean não vê ninguém nos arredores. Mas sente que está sendo observado.', 'info');
                return true;
            case 'search_wall':
                if (!flag('found_docs_church')) {
                    flag('found_docs_church', true);
                    addItem('old_documents');
                    logMsg('Sam encontrou documentos escondidos sobre o Vazio Eterno!', 'success');
                } else {
                    logMsg('Nada mais na parede.', 'info');
                }
                // Trigger combat chance
                if (!flag('church_creature_dead')) {
                    startCombat('church_creature');
                }
                return true;
            case 'check_altar':
                if (flag('church_creature_dead')) {
                    $g['scene'] = 'tunnel';
                    logMsg('Atrás do altar há uma passagem subterrânea.', 'info');
                } else {
                    logMsg('O altar está destruído. Algo se move nas sombras...', 'danger');
                    if (!flag('church_creature_dead')) startCombat('church_creature');
                }
                return true;
            case 'prepare_combat':
                if (!flag('church_creature_dead')) startCombat('church_creature');
                else logMsg('A criatura já foi derrotada.', 'info');
                return true;
            case 'back_outside':
                $g['scene'] = 'outside';
                return true;
            case 'touch_stone':
                if ($char !== 'sam') { logMsg('Sam sente uma conexão mais forte com o símbolo.', 'info'); }
                flag('prolog_done', true);
                flag('vision_seen', true);
                $g['knowledge'] += 3;
                logMsg('Sam tem uma visão: sete selos. Uma porta. Escuridão absoluta.', 'seal');
                logMsg('— Dean... isso não é uma porta. É um SELO.', 'info');
                logMsg('Nova localização desbloqueada: Floresta Isolada.', 'success');
                return true;
            case 'guard':
                logMsg('Dean fica de guarda. Nada se aproxima.', 'info');
                return true;
            case 'back_inside':
                $g['scene'] = 'inside';
                return true;
            case 'leave':
                $g['location'] = 'bunker';
                $g['scene'] = 'main';
                return true;
        }
    }

    // ========== FLORESTA ==========
    if ($loc === 'forest') {
        switch ($actionId) {
            case 'follow_tracks':
                $g['scene'] = 'cabin';
                logMsg('Os rastros levam a uma cabana antiga.', 'info');
                return true;
            case 'analyze_area':
                logMsg('Sam identifica marcas de garras e residual sobrenatural forte.', 'info');
                $g['knowledge'] += 1;
                return true;
            case 'search_cabin':
                if (!flag('cabin_searched')) {
                    flag('cabin_searched', true);
                    addItem('map_fragment');
                    addItem('ritual_chalk');
                    logMsg('Sam encontrou um Fragmento de Mapa e Giz Ritual.', 'success');
                } else logMsg('Nada mais de útil.', 'info');
                return true;
            case 'confront_creature':
                if (!flag('forest_creature_dead')) startCombat('forest_creature');
                else {
                    $g['scene'] = 'underground';
                    logMsg('A passagem subterrânea está aberta.', 'info');
                }
                return true;
            case 'use_salt':
                if (removeItem('salt')) {
                    logMsg('Círculo de sal criado. A criatura hesita.', 'success');
                    flag('salt_protection', true);
                }
                return true;
            case 'take_seal1':
                if (!flag('forest_creature_dead') && !flag('salt_protection')) {
                    logMsg('A criatura ainda protege o selo!', 'danger');
                    startCombat('forest_creature');
                    return true;
                }
                if (!in_array(1, $g['seals'])) {
                    addSeal(1);
                    flag('seal_1', true);
                    logMsg('Mensagem na parede: "Sete portas. Sete chaves. Quando a última abrir, nada permanecerá."', 'seal');
                } else logMsg('Você já possui este selo.', 'info');
                return true;
            case 'read_message':
                logMsg('"Sete portas. Sete chaves. Quando a última abrir, nada permanecerá." — Ordem do Véu Negro', 'seal');
                return true;
            case 'back_entrance':
                $g['scene'] = 'entrance';
                return true;
            case 'back_cabin':
                $g['scene'] = 'cabin';
                return true;
            case 'leave':
                $g['location'] = 'bunker';
                $g['scene'] = 'main';
                return true;
        }
    }

    // ========== CASA DOS MORTOS ==========
    if ($loc === 'haunted_house') {
        switch ($actionId) {
            case 'enter_house':
                $g['scene'] = 'living';
                logMsg('A temperatura cai assim que vocês entram.', 'info');
                return true;
            case 'circle_salt':
                if (removeItem('salt')) {
                    flag('house_salt', true);
                    logMsg('Círculo de sal na entrada. Espíritos terão mais dificuldade de sair.', 'success');
                }
                return true;
            case 'search_living':
                if (!flag('house_docs')) {
                    flag('house_docs', true);
                    $g['knowledge'] += 2;
                    logMsg('Sam encontrou diários de membros da Ordem. Eles esconderam o segundo selo aqui.', 'success');
                } else logMsg('Nada de novo.', 'info');
                return true;
            case 'check_portraits':
                logMsg('Os rostos nos retratos parecem seguir você com o olhar.', 'danger');
                return true;
            case 'go_basement':
                $g['scene'] = 'basement';
                return true;
            case 'go_upstairs':
                logMsg('O segundo andar está destruído. Só há mais espíritos inquietos.', 'info');
                if (!flag('house_spirits_dead')) {
                    damage($char, 10);
                    logMsg('Um espírito ataca de surpresa! -10 HP', 'danger');
                }
                return true;
            case 'fight_spirits':
                if (!flag('house_spirits_dead')) startCombat('spirits');
                else logMsg('Os espíritos já foram dispersados.', 'info');
                return true;
            case 'ritual_calm':
                if ($char !== 'sam') { logMsg('Sam é melhor em rituais.', 'info'); return true; }
                if (!hasItem('prayer_book')) { logMsg('Você precisa do Livro de Orações.', 'danger'); return true; }
                flag('house_spirits_dead', true);
                logMsg('Sam realiza o ritual. Os espíritos se acalmam e se dissipam.', 'success');
                $g['knowledge'] += 2;
                return true;
            case 'take_seal2':
                if (!flag('house_spirits_dead')) {
                    logMsg('Os espíritos ainda protegem o selo!', 'danger');
                    return true;
                }
                if (!in_array(2, $g['seals'])) {
                    addSeal(2);
                    flag('seal_2', true);
                    logMsg('Uma figura misteriosa observa de longe... e desaparece.', 'danger');
                    flag('watched', true);
                } else logMsg('Você já tem este selo.', 'info');
                return true;
            case 'back_living':
                $g['scene'] = 'living';
                return true;
            case 'back_outside':
                $g['scene'] = 'outside';
                return true;
            case 'leave':
                $g['location'] = 'bunker';
                $g['scene'] = 'main';
                return true;
        }
    }

    // ========== ESTRADA / CIDADE ==========
    if ($loc === 'roadside') {
        switch ($actionId) {
            case 'talk_bartender':
                logMsg('Barman: "Tem um cara estranho caçando os vampiros da região. Não é caçador comum."', 'info');
                flag('heard_bartender', true);
                return true;
            case 'listen_rumors':
                logMsg('Boatos: desaparecimentos perto do armazém velho. Sangue demais para ser só vampiro.', 'info');
                $g['knowledge'] += 1;
                return true;
            case 'go_warehouse':
                $g['scene'] = 'warehouse';
                return true;
            case 'investigate_bodies':
                logMsg('Sam: os vampiros foram mortos com precisão. Alguém da Ordem está usando criaturas para achar os selos.', 'info');
                $g['knowledge'] += 2;
                flag('know_order_method', true);
                return true;
            case 'search_seal3':
                $g['scene'] = 'underground_road';
                logMsg('Vocês encontram uma passagem para baixo.', 'info');
                return true;
            case 'ambush':
                logMsg('Dean prepara uma emboscada. Ninguém aparece... ainda.', 'info');
                return true;
            case 'take_seal3':
                if (!in_array(3, $g['seals'])) {
                    addSeal(3);
                    flag('seal_3', true);
                    logMsg('Ao voltar, descobrem que o bunker foi invadido. Uma mensagem: "Vocês procuram os selos. Nós procuramos a chave."', 'danger');
                    flag('bunker_invaded', true);
                } else logMsg('Já possui este selo.', 'info');
                return true;
            case 'fight_order':
                if (!flag('order_agents_dead')) startCombat('order_agents');
                else logMsg('Os agentes já foram derrotados.', 'info');
                return true;
            case 'back_bar':
                $g['scene'] = 'bar';
                return true;
            case 'back_warehouse':
                $g['scene'] = 'warehouse';
                return true;
            case 'leave':
                $g['location'] = 'bunker';
                $g['scene'] = 'main';
                return true;
        }
    }

    // ========== MINA ==========
    if ($loc === 'mine') {
        switch ($actionId) {
            case 'enter_mine':
                $g['scene'] = 'tunnels';
                logMsg('A escuridão engole a lanterna. Sussurros começam.', 'danger');
                return true;
            case 'resist_vision':
                if ($char !== 'sam') { logMsg('As visões miram Sam.', 'info'); return true; }
                if (!flag('resisted_void')) {
                    flag('resisted_void', true);
                    $g['knowledge'] += 3;
                    logMsg('O Vazio mostra um mundo sem dor... Sam resiste à manipulação.', 'success');
                    logMsg('O Vazio agora sabe quem Sam é.', 'danger');
                } else logMsg('Sam mantém a mente firme.', 'info');
                $g['scene'] = 'chamber';
                return true;
            case 'push_forward':
                $g['scene'] = 'chamber';
                damage('dean', 15);
                logMsg('Dean força o caminho. Criaturas nas sombras atacam. -15 HP', 'danger');
                return true;
            case 'use_holy':
                if (removeItem('holy_water')) {
                    logMsg('A água benta afasta as sombras temporariamente.', 'success');
                    $g['scene'] = 'chamber';
                }
                return true;
            case 'fight_shadow':
                if (!flag('shadow_dead')) startCombat('shadow_creature');
                else logMsg('A criatura já caiu.', 'info');
                return true;
            case 'take_seal4':
                if (!flag('shadow_dead')) {
                    logMsg('A criatura de sombra ainda protege o selo!', 'danger');
                    return true;
                }
                if (!in_array(4, $g['seals'])) {
                    addSeal(4);
                    flag('seal_4', true);
                    // Mercer já tem o 5º
                    flag('mercer_has_5', true);
                    logMsg('Sam sente: Mercer já possui o quinto selo. Faltam dois.', 'danger');
                } else logMsg('Já possui.', 'info');
                return true;
            case 'back_entrance':
                $g['scene'] = 'entrance';
                return true;
            case 'back_tunnels':
                $g['scene'] = 'tunnels';
                return true;
            case 'leave':
                $g['location'] = 'bunker';
                $g['scene'] = 'main';
                return true;
        }
    }

    // ========== BIBLIOTECA ==========
    if ($loc === 'library') {
        switch ($actionId) {
            case 'search_books':
                if ($char !== 'sam') { logMsg('Sam encontra mais sentido nos textos.', 'info'); }
                $g['knowledge'] += 2;
                logMsg('Sam descobre detalhes do ritual final e como restaurar os selos.', 'success');
                flag('know_ritual', true);
                return true;
            case 'find_seal6':
                if (!in_array(6, $g['seals'])) {
                    addSeal(6);
                    flag('seal_6', true);
                    logMsg('Sexto selo recuperado.', 'seal');
                    // Check if both 6 and 7
                    if (in_array(7, $g['seals'])) {
                        flag('mercer_has_all', true);
                        logMsg('Mercer já tem o sétimo! O ritual está começando!', 'danger');
                    }
                } else logMsg('Já possui.', 'info');
                return true;
            case 'leave':
                $g['location'] = 'bunker';
                $g['scene'] = 'main';
                return true;
        }
    }

    // ========== IGREJA DO NORTE ==========
    if ($loc === 'old_church') {
        switch ($actionId) {
            case 'take_seal7':
                if (!flag('mercer_fought')) {
                    logMsg('Quando Dean toca o selo, Mercer aparece!', 'danger');
                    startCombat('mercer');
                    return true;
                }
                // After fight Mercer steals it
                logMsg('Mercer rouba o sétimo selo durante o confronto!', 'danger');
                flag('mercer_has_all', true);
                logMsg('Ele possui todos os sete. O ritual começa esta noite.', 'danger');
                return true;
            case 'confront_mercer':
                if (!flag('mercer_fought')) startCombat('mercer');
                else logMsg('Mercer já foi enfrentado. Ele fugiu com o selo.', 'info');
                return true;
            case 'leave':
                $g['location'] = 'bunker';
                $g['scene'] = 'main';
                return true;
        }
    }

    // ========== RITUAL ==========
    if ($loc === 'ritual_site') {
        switch ($actionId) {
            case 'enter_ritual':
                $g['scene'] = 'ritual';
                return true;
            case 'stop_mercer':
                if (!flag('mercer_final_dead')) {
                    startCombat('mercer_final');
                } else {
                    logMsg('Mercer foi derrotado, mas o ritual já estava completo. O Vazio emerge!', 'danger');
                    $g['scene'] = 'void';
                }
                return true;
            case 'start_counter':
                if ($char !== 'sam') { logMsg('Sam precisa liderar o contra-ritual.', 'info'); return true; }
                if (!flag('know_ritual') && $g['knowledge'] < 8) {
                    logMsg('Sam ainda não sabe o suficiente sobre o ritual.', 'danger');
                    return true;
                }
                logMsg('Sam começa o contra-ritual. Os selos reagem!', 'success');
                flag('counter_started', true);
                $g['scene'] = 'void';
                return true;
            case 'restore_seals':
                if ($char !== 'sam') { logMsg('Sam é essencial neste momento.', 'info'); return true; }
                flag('seals_restoring', true);
                logMsg('Sam restaura os selos um a um. O Vazio enfraquece.', 'seal');
                return true;
            case 'hold_void':
                if ($char !== 'dean') { logMsg('Dean precisa segurar a linha!', 'info'); return true; }
                damage('dean', 20);
                logMsg('Dean segura o Vazio com pura força de vontade. -20 HP', 'danger');
                flag('void_held', true);
                return true;
            case 'final_seal':
                if (!flag('seals_restoring') || !flag('void_held')) {
                    logMsg('Vocês precisam trabalhar juntos: Sam restaura, Dean segura!', 'danger');
                    return true;
                }
                // Ending
                flag('void_sealed', true);
                $g['scene'] = 'ending';
                logMsg('Os sete selos brilham. A ruptura se fecha. O Vazio é puxado de volta.', 'seal');
                logMsg('— Acabou? — pergunta Dean.', 'info');
                logMsg('— Dessa vez... acho que sim. — responde Sam.', 'info');
                return true;
            case 'leave':
                if (flag('void_sealed')) {
                    $g['location'] = 'bunker';
                    $g['scene'] = 'main';
                } else {
                    logMsg('Não há para onde fugir agora.', 'danger');
                }
                return true;
        }
    }

    // Viagem
    if ($actionId === 'go_to' && isset($_GET['dest'])) {
        $dest = $_GET['dest'];
        $available = getAvailableLocations();
        if (isset($available[$dest])) {
            $g['location'] = $dest;
            // set default scene
            $firstScene = array_key_first($GLOBALS['LOCATIONS'][$dest]['scenes'] ?? ['main' => 1]);
            $g['scene'] = $firstScene ?: 'main';
            $g['visited'][$dest] = true;
            logMsg('Vocês viajam para: ' . $available[$dest], 'info');
        }
        return true;
    }

    // Usar item
    if ($actionId === 'use_item' && isset($_GET['item'])) {
        $item = $_GET['item'];
        if ($item === 'first_aid' && hasItem('first_aid')) {
            removeItem('first_aid');
            heal($char, 40);
            logMsg('Kit usado. +40 HP em ' . ($char === 'sam' ? 'Sam' : 'Dean'), 'success');
        } elseif ($item === 'holy_water' && hasItem('holy_water')) {
            logMsg('Água benta preparada para o próximo combate.', 'info');
            flag('holy_ready', true);
            removeItem('holy_water');
        } else {
            logMsg('Não é possível usar este item agora.', 'info');
        }
        return true;
    }

    // Trocar personagem
    if ($actionId === 'switch_char') {
        $g['character'] = ($g['character'] === 'sam') ? 'dean' : 'sam';
        logMsg('Agora controlando: ' . ($g['character'] === 'sam' ? 'Sam' : 'Dean'), 'info');
        return true;
    }

    return false;
}

// ========== COMBATE ==========
function startCombat($enemyId) {
    $enemies = [
        'church_creature' => [
            'name' => 'Criatura da Igreja',
            'hp' => 60, 'max_hp' => 60,
            'atk' => 12, 'def' => 3,
            'desc' => 'Uma figura deformada feita de sombra e ossos.',
            'flag_on_death' => 'church_creature_dead',
            'reward_msg' => 'A criatura se dissolve. A passagem atrás do altar se revela.',
        ],
        'forest_creature' => [
            'name' => 'Guardião da Floresta',
            'hp' => 80, 'max_hp' => 80,
            'atk' => 15, 'def' => 5,
            'desc' => 'Uma besta coberta de runas. Protege o primeiro selo.',
            'flag_on_death' => 'forest_creature_dead',
            'reward_msg' => 'A besta cai. O caminho para o selo está livre.',
        ],
        'spirits' => [
            'name' => 'Espíritos Inquietos',
            'hp' => 50, 'max_hp' => 50,
            'atk' => 10, 'def' => 2,
            'desc' => 'Vários espíritos atacando em conjunto.',
            'flag_on_death' => 'house_spirits_dead',
            'reward_msg' => 'Os espíritos se dissipam. O cofre do selo se abre.',
        ],
        'order_agents' => [
            'name' => 'Agentes da Ordem',
            'hp' => 70, 'max_hp' => 70,
            'atk' => 14, 'def' => 4,
            'desc' => 'Homens mascarados com símbolos do Véu Negro.',
            'flag_on_death' => 'order_agents_dead',
            'reward_msg' => 'Os agentes caem. Vocês podem pegar o selo.',
        ],
        'shadow_creature' => [
            'name' => 'Criatura de Sombra',
            'hp' => 90, 'max_hp' => 90,
            'atk' => 18, 'def' => 6,
            'desc' => 'Uma manifestação parcial do Vazio.',
            'flag_on_death' => 'shadow_dead',
            'reward_msg' => 'A sombra se desfaz. O quarto selo está ao alcance.',
        ],
        'mercer' => [
            'name' => 'Elias Mercer',
            'hp' => 100, 'max_hp' => 100,
            'atk' => 16, 'def' => 5,
            'desc' => 'O líder da Ordem do Véu Negro. Ex-Homem de Letras.',
            'flag_on_death' => 'mercer_fought',
            'reward_msg' => 'Mercer é forçado a recuar — mas leva o sétimo selo consigo.',
        ],
        'mercer_final' => [
            'name' => 'Elias Mercer (Ritual)',
            'hp' => 120, 'max_hp' => 120,
            'atk' => 20, 'def' => 7,
            'desc' => 'Mercer no auge do poder do ritual.',
            'flag_on_death' => 'mercer_final_dead',
            'reward_msg' => 'Mercer cai. Mas o ritual já foi concluído. O Vazio emerge...',
        ],
    ];

    if (!isset($enemies[$enemyId])) return;

    $_SESSION['game']['combat'] = [
        'enemy' => $enemies[$enemyId],
        'enemy_id' => $enemyId,
        'turn' => 'player',
        'log' => [],
    ];
}

function processCombatAction($action) {
    $g = &$_SESSION['game'];
    if (!$g['combat']) return;

    $c = &$g['combat'];
    $enemy = &$c['enemy'];
    $char = $g['character'];
    $atkBonus = ($char === 'dean') ? 8 : 3;
    $defBonus = ($char === 'dean') ? 4 : 2;

    if ($action === 'attack') {
        $dmg = max(5, rand(10, 18) + $atkBonus - $enemy['def']);
        if (flag('holy_ready')) {
            $dmg += 10;
            flag('holy_ready', false);
            $c['log'][] = 'Água benta causa dano extra!';
        }
        if (hasItem('demon_blade') || hasItem('silver_knife')) $dmg += 5;
        $enemy['hp'] = max(0, $enemy['hp'] - $dmg);
        $c['log'][] = ($char === 'sam' ? 'Sam' : 'Dean') . " ataca causando $dmg de dano!";
    }
    elseif ($action === 'defend') {
        flag('defending', true);
        $c['log'][] = ($char === 'sam' ? 'Sam' : 'Dean') . ' se defende.';
    }
    elseif ($action === 'special') {
        if ($char === 'sam') {
            // Sam: ritual / knowledge attack
            $dmg = max(8, 12 + intval($g['knowledge'] / 2));
            $enemy['hp'] = max(0, $enemy['hp'] - $dmg);
            $c['log'][] = "Sam usa conhecimento ritual! $dmg de dano espiritual.";
        } else {
            // Dean: powerful shot
            $dmg = max(12, rand(16, 25));
            $enemy['hp'] = max(0, $enemy['hp'] - $dmg);
            $c['log'][] = "Dean dispara com tudo! $dmg de dano.";
        }
    }
    elseif ($action === 'item_salt' && hasItem('salt')) {
        removeItem('salt');
        $enemy['hp'] = max(0, $enemy['hp'] - 15);
        $c['log'][] = 'Sal abençoado queima a criatura! 15 de dano.';
    }
    elseif ($action === 'flee') {
        $g['combat'] = null;
        logMsg('Vocês recuaram do combate.', 'info');
        return;
    }

    // Check enemy dead
    if ($enemy['hp'] <= 0) {
        $c['log'][] = $enemy['name'] . ' foi derrotado!';
        flag($enemy['flag_on_death'], true);
        logMsg($enemy['reward_msg'], 'success');
        $g['kills']++;
        $g['combat'] = null;
        return;
    }

    // Enemy turn
    $edmg = max(3, $enemy['atk'] - $defBonus - (flag('defending') ? 6 : 0));
    flag('defending', false);
    damage($char, $edmg);
    $c['log'][] = $enemy['name'] . " ataca! $edmg de dano em " . ($char === 'sam' ? 'Sam' : 'Dean') . '.';

    // Check player dead
    if (!isAlive('sam') && !isAlive('dean')) {
        $c['log'][] = 'Vocês foram derrotados...';
        // soft fail - respawn bunker with low hp
        $g['hp']['sam'] = 20;
        $g['hp']['dean'] = 20;
        $g['location'] = 'bunker';
        $g['scene'] = 'main';
        $g['combat'] = null;
        logMsg('Vocês acordam no bunker, gravemente feridos. A caçada continua.', 'danger');
    } elseif (!isAlive($char)) {
        // switch to other
        $other = $char === 'sam' ? 'dean' : 'sam';
        if (isAlive($other)) {
            $g['character'] = $other;
            $c['log'][] = ($char === 'sam' ? 'Sam' : 'Dean') . ' caiu! ' . ($other === 'sam' ? 'Sam' : 'Dean') . ' assume.';
        }
    }
}
?>