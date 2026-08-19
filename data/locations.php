<?php
/**
 * Cada local tem:
 * - name, desc, bg
 * - scenes: cenas/áreas internas
 * - actions: lista de ações disponíveis (filtradas por flags)
 */

$LOCATIONS = [

    // =========================================================
    // BUNKER (hub principal)
    // =========================================================
    'bunker' => [
        'name' => 'Bunker dos Homens de Letras',
        'desc' => 'Seu refúgio. Arquivos, armas e um pouco de segurança.',
        'bg' => 'bunker.jpg',
        'chapter' => 0,
        'scenes' => [
            'main' => [
                'title' => 'Salão Principal',
                'text' => "O bunker está em silêncio. Prateleiras de livros antigos, uma mesa cheia de arquivos e o cheiro familiar de metal e café.\n\nSam costuma ficar na área de pesquisa. Dean, perto do arsenal.",
                'actions' => [
                    ['id' => 'research', 'label' => '📚 Pesquisar arquivos (Sam)', 'char' => 'sam', 'req_char' => 'sam'],
                    ['id' => 'armory', 'label' => '🔫 Verificar arsenal (Dean)', 'char' => 'dean', 'req_char' => 'dean'],
                    ['id' => 'rest', 'label' => '😴 Descansar e se curar', 'char' => 'both'],
                    ['id' => 'check_seals', 'label' => '✦ Verificar os Selos', 'char' => 'both'],
                    ['id' => 'travel', 'label' => '🚗 Sair com o Impala', 'char' => 'both'],
                ]
            ],
        ]
    ],

    // =========================================================
    // BLACK CREEK - Igreja
    // =========================================================
    'black_creek' => [
        'name' => 'Black Creek — Igreja Abandonada',
        'desc' => 'Onde tudo começou. Três mortes. Um símbolo.',
        'bg' => 'church.jpg',
        'chapter' => 1,
        'scenes' => [
            'outside' => [
                'title' => 'Exterior da Igreja',
                'text' => "A igreja está em ruínas. O telhado cedeu em alguns pontos. A chuva fina deixa tudo mais sombrio.\n\nHá marcas recentes no chão — alguém esteve aqui.",
                'actions' => [
                    ['id' => 'enter_church', 'label' => '🚪 Entrar na igreja', 'char' => 'both'],
                    ['id' => 'examine_marks', 'label' => '🔍 Examinar as marcas no chão', 'char' => 'sam'],
                    ['id' => 'scout', 'label' => '👀 Observar os arredores', 'char' => 'dean'],
                    ['id' => 'leave', 'label' => '← Voltar ao bunker', 'char' => 'both'],
                ]
            ],
            'inside' => [
                'title' => 'Interior da Igreja',
                'text' => "Bancos quebrados. Um altar destruído. O ar está pesado.\n\nSam nota uma parede rachada atrás do altar.",
                'actions' => [
                    ['id' => 'search_wall', 'label' => '🧱 Investigar a parede rachada', 'char' => 'sam'],
                    ['id' => 'check_altar', 'label' => '✝️ Examinar o altar', 'char' => 'both'],
                    ['id' => 'prepare_combat', 'label' => '⚔️ Preparar-se para combate', 'char' => 'dean'],
                    ['id' => 'back_outside', 'label' => '← Sair da igreja', 'char' => 'both'],
                ]
            ],
            'tunnel' => [
                'title' => 'Passagem Subterrânea',
                'text' => "Um túnel úmido e estreito. No final, uma pedra negra com o símbolo de sete linhas.",
                'actions' => [
                    ['id' => 'touch_stone', 'label' => '✋ Tocar a pedra negra (Sam)', 'char' => 'sam'],
                    ['id' => 'guard', 'label' => '🛡️ Ficar de guarda (Dean)', 'char' => 'dean'],
                    ['id' => 'back_inside', 'label' => '← Voltar para a igreja', 'char' => 'both'],
                ]
            ],
        ]
    ],

    // =========================================================
    // FLORESTA
    // =========================================================
    'forest' => [
        'name' => 'Floresta Isolada',
        'desc' => 'Desaparecimentos noturnos. Algo protege o primeiro selo.',
        'bg' => 'forest_night.jpg',
        'chapter' => 2,
        'scenes' => [
            'entrance' => [
                'title' => 'Entrada da Floresta',
                'text' => "Árvores densas. O som de galhos quebrando ao longe. Moradores locais relatam gritos durante a noite.",
                'actions' => [
                    ['id' => 'follow_tracks', 'label' => '🐾 Seguir os rastros', 'char' => 'dean'],
                    ['id' => 'analyze_area', 'label' => '🔬 Analisar a área', 'char' => 'sam'],
                    ['id' => 'leave', 'label' => '← Voltar ao bunker', 'char' => 'both'],
                ]
            ],
            'cabin' => [
                'title' => 'Cabana Abandonada',
                'text' => "Uma cabana antiga no meio da floresta. Símbolos iguais aos de Black Creek cobrem as paredes internas.",
                'actions' => [
                    ['id' => 'search_cabin', 'label' => '🔎 Vasculhar a cabana', 'char' => 'sam'],
                    ['id' => 'confront_creature', 'label' => '⚔️ Enfrentar a criatura guardiã', 'char' => 'dean'],
                    ['id' => 'use_salt', 'label' => '🧂 Usar sal para proteção', 'char' => 'both', 'req_item' => 'salt'],
                    ['id' => 'back_entrance', 'label' => '← Voltar à entrada', 'char' => 'both'],
                ]
            ],
            'underground' => [
                'title' => 'Estrutura Subterrânea',
                'text' => "Abaixo da cabana, uma câmara antiga. No centro, o Primeiro Selo pulsa com uma luz fraca.",
                'actions' => [
                    ['id' => 'take_seal1', 'label' => '✦ Recuperar o Primeiro Selo', 'char' => 'both'],
                    ['id' => 'read_message', 'label' => '📜 Ler a mensagem na parede', 'char' => 'sam'],
                    ['id' => 'back_cabin', 'label' => '← Voltar à cabana', 'char' => 'both'],
                ]
            ],
        ]
    ],

    // =========================================================
    // CASA DOS MORTOS
    // =========================================================
    'haunted_house' => [
        'name' => 'A Casa dos Mortos',
        'desc' => 'Construída sobre um cemitério. Espíritos protegem o segundo selo.',
        'bg' => 'haunted_house.jpg',
        'chapter' => 3,
        'scenes' => [
            'outside' => [
                'title' => 'Frente da Casa',
                'text' => "Janelas quebradas. O vento faz as portas rangerem. Vizinhos juram ouvir vozes vindo de dentro.",
                'actions' => [
                    ['id' => 'enter_house', 'label' => '🚪 Entrar na casa', 'char' => 'both'],
                    ['id' => 'circle_salt', 'label' => '🧂 Criar círculo de sal na entrada', 'char' => 'both', 'req_item' => 'salt'],
                    ['id' => 'leave', 'label' => '← Voltar ao bunker', 'char' => 'both'],
                ]
            ],
            'living' => [
                'title' => 'Sala de Estar',
                'text' => "Móveis cobertos de poeira. Retratos virados para a parede. Um frio antinatural preenche o ambiente.",
                'actions' => [
                    ['id' => 'search_living', 'label' => '🔍 Procurar pistas', 'char' => 'sam'],
                    ['id' => 'check_portraits', 'label' => '🖼️ Examinar os retratos', 'char' => 'both'],
                    ['id' => 'go_basement', 'label' => '⬇️ Descer ao porão', 'char' => 'both'],
                    ['id' => 'go_upstairs', 'label' => '⬆️ Subir ao segundo andar', 'char' => 'dean'],
                    ['id' => 'back_outside', 'label' => '← Sair da casa', 'char' => 'both'],
                ]
            ],
            'basement' => [
                'title' => 'Porão / Cemitério Antigo',
                'text' => "O porão revela lápides antigas. O segundo selo está selado em um cofre de pedra protegido por espíritos.",
                'actions' => [
                    ['id' => 'fight_spirits', 'label' => '⚔️ Enfrentar os espíritos', 'char' => 'dean'],
                    ['id' => 'ritual_calm', 'label' => '📖 Ritual de acalmamento (Sam)', 'char' => 'sam', 'req_item' => 'prayer_book'],
                    ['id' => 'take_seal2', 'label' => '✦ Pegar o Segundo Selo', 'char' => 'both'],
                    ['id' => 'back_living', 'label' => '← Voltar à sala', 'char' => 'both'],
                ]
            ],
        ]
    ],

    // =========================================================
    // CIDADE / ESTRADA (vampiros / terceiro selo)
    // =========================================================
    'roadside' => [
        'name' => 'Estrada & Cidade Vizinha',
        'desc' => 'Desaparecimentos. Vampiros sendo caçados por alguém.',
        'bg' => 'road_bar.jpg',
        'chapter' => 4,
        'scenes' => [
            'bar' => [
                'title' => 'Bar Roadhouse',
                'text' => "Um bar sujo na beira da estrada. Conversas baixas. Alguém aqui sabe sobre os desaparecimentos.",
                'actions' => [
                    ['id' => 'talk_bartender', 'label' => '🍺 Conversar com o barman', 'char' => 'dean'],
                    ['id' => 'listen_rumors', 'label' => '👂 Ouvir boatos', 'char' => 'sam'],
                    ['id' => 'go_warehouse', 'label' => '🏭 Ir ao armazém abandonado', 'char' => 'both'],
                    ['id' => 'leave', 'label' => '← Voltar ao bunker', 'char' => 'both'],
                ]
            ],
            'warehouse' => [
                'title' => 'Armazém Abandonado',
                'text' => "O cheiro de sangue velho. Corpos de vampiros empilhados. Alguém está limpando a área — e procurando o terceiro selo.",
                'actions' => [
                    ['id' => 'investigate_bodies', 'label' => '🔬 Examinar os corpos', 'char' => 'sam'],
                    ['id' => 'search_seal3', 'label' => '🔍 Procurar o terceiro selo', 'char' => 'both'],
                    ['id' => 'ambush', 'label' => '⚔️ Preparar emboscada', 'char' => 'dean'],
                    ['id' => 'back_bar', 'label' => '← Voltar ao bar', 'char' => 'both'],
                ]
            ],
            'underground_road' => [
                'title' => 'Construção Subterrânea',
                'text' => "Abaixo do armazém, uma câmara. O terceiro selo está aqui — mas a Ordem também.",
                'actions' => [
                    ['id' => 'take_seal3', 'label' => '✦ Recuperar o Terceiro Selo', 'char' => 'both'],
                    ['id' => 'fight_order', 'label' => '⚔️ Enfrentar agentes da Ordem', 'char' => 'dean'],
                    ['id' => 'back_warehouse', 'label' => '← Voltar', 'char' => 'both'],
                ]
            ],
        ]
    ],

    // =========================================================
    // MINA (quarto selo + visões)
    // =========================================================
    'mine' => [
        'name' => 'Antiga Mina',
        'desc' => 'O quarto selo. O Vazio começa a falar com Sam.',
        'bg' => 'mine.jpg',
        'chapter' => 5,
        'scenes' => [
            'entrance' => [
                'title' => 'Entrada da Mina',
                'text' => "Trilhos enferrujados. Escuridão profunda. Você sente que está sendo observado de dentro.",
                'actions' => [
                    ['id' => 'enter_mine', 'label' => '🔦 Entrar na mina', 'char' => 'both'],
                    ['id' => 'leave', 'label' => '← Voltar ao bunker', 'char' => 'both'],
                ]
            ],
            'tunnels' => [
                'title' => 'Túneis',
                'text' => "Labirinto de túneis. Sam começa a ouvir sussurros. O Vazio está tentando entrar na mente dele.",
                'actions' => [
                    ['id' => 'resist_vision', 'label' => '🧠 Resistir às visões (Sam)', 'char' => 'sam'],
                    ['id' => 'push_forward', 'label' => '➡️ Avançar com força (Dean)', 'char' => 'dean'],
                    ['id' => 'use_holy', 'label' => '💧 Usar água benta no caminho', 'char' => 'both', 'req_item' => 'holy_water'],
                    ['id' => 'back_entrance', 'label' => '← Voltar à entrada', 'char' => 'both'],
                ]
            ],
            'chamber' => [
                'title' => 'Câmara do Selo',
                'text' => "Uma câmara circular. O quarto selo flutua no centro. Uma criatura de sombra o protege.",
                'actions' => [
                    ['id' => 'fight_shadow', 'label' => '⚔️ Combater a criatura de sombra', 'char' => 'dean'],
                    ['id' => 'take_seal4', 'label' => '✦ Recuperar o Quarto Selo', 'char' => 'both'],
                    ['id' => 'back_tunnels', 'label' => '← Voltar aos túneis', 'char' => 'both'],
                ]
            ],
        ]
    ],

    // =========================================================
    // BIBLIOTECA + IGREJA (selos 6 e 7)
    // =========================================================
    'library' => [
        'name' => 'Biblioteca Subterrânea',
        'desc' => 'Conhecimento proibido. O sexto selo.',
        'bg' => 'library.jpg',
        'chapter' => 6,
        'scenes' => [
            'hall' => [
                'title' => 'Salão da Biblioteca',
                'text' => "Prateleiras infinitas de livros proibidos. O ar cheira a mofo e segredos antigos.",
                'actions' => [
                    ['id' => 'search_books', 'label' => '📚 Procurar nos livros (Sam)', 'char' => 'sam'],
                    ['id' => 'find_seal6', 'label' => '✦ Localizar o Sexto Selo', 'char' => 'both'],
                    ['id' => 'leave', 'label' => '← Voltar ao bunker', 'char' => 'both'],
                ]
            ],
        ]
    ],

    'old_church' => [
        'name' => 'Igreja Abandonada do Norte',
        'desc' => 'O sétimo e último selo. Mercer está perto.',
        'bg' => 'old_church.jpg',
        'chapter' => 6,
        'scenes' => [
            'nave' => [
                'title' => 'Nave da Igreja',
                'text' => "Vitrais quebrados. O sétimo selo está no altar. Você sente a presença de Mercer.",
                'actions' => [
                    ['id' => 'take_seal7', 'label' => '✦ Pegar o Sétimo Selo', 'char' => 'dean'],
                    ['id' => 'confront_mercer', 'label' => '👤 Confrontar Elias Mercer', 'char' => 'both'],
                    ['id' => 'leave', 'label' => '← Voltar ao bunker', 'char' => 'both'],
                ]
            ],
        ]
    ],

    // =========================================================
    // RITUAL FINAL
    // =========================================================
    'ritual_site' => [
        'name' => 'Black Creek — Local do Ritual',
        'desc' => 'Onde o Vazio será libertado... ou selado para sempre.',
        'bg' => 'ritual_site.jpg',
        'chapter' => 7,
        'scenes' => [
            'approach' => [
                'title' => 'Aproximação',
                'text' => "O céu está errado. As ruas de Black Creek estão vazias. O silêncio é absoluto.\n\nNo centro, uma estrutura formada pelos sete selos. Mercer está lá.",
                'actions' => [
                    ['id' => 'enter_ritual', 'label' => '➡️ Entrar no local do ritual', 'char' => 'both'],
                    ['id' => 'leave', 'label' => '← Recuar (não recomendado)', 'char' => 'both'],
                ]
            ],
            'ritual' => [
                'title' => 'O Ritual',
                'text' => "Mercer está no centro. Os selos brilham. A ruptura já começou a se abrir.",
                'actions' => [
                    ['id' => 'stop_mercer', 'label' => '⚔️ Interromper Mercer', 'char' => 'dean'],
                    ['id' => 'start_counter', 'label' => '📖 Iniciar contra-ritual (Sam)', 'char' => 'sam'],
                ]
            ],
            'void' => [
                'title' => 'O Vazio Eterno',
                'text' => "A realidade se desfaz. O Vazio emerge. Você precisa restaurar os sete selos enquanto luta para não ser consumido.",
                'actions' => [
                    ['id' => 'restore_seals', 'label' => '✦ Restaurar os Selos (Sam)', 'char' => 'sam'],
                    ['id' => 'hold_void', 'label' => '🛡️ Segurar o Vazio (Dean)', 'char' => 'dean'],
                    ['id' => 'final_seal', 'label' => '✦ Completar o Último Selo', 'char' => 'both'],
                ]
            ],
        ]
    ],
];

// Locais disponíveis para viagem (desbloqueados por flags)
function getAvailableLocations() {
    $all = [
        'bunker'        => ['name' => 'Bunker', 'req' => null],
        'black_creek'   => ['name' => 'Black Creek (Igreja)', 'req' => null],
        'forest'        => ['name' => 'Floresta Isolada', 'req' => 'prolog_done'],
        'haunted_house' => ['name' => 'Casa dos Mortos', 'req' => 'seal_1'],
        'roadside'      => ['name' => 'Estrada / Cidade', 'req' => 'seal_2'],
        'mine'          => ['name' => 'Antiga Mina', 'req' => 'seal_3'],
        'library'       => ['name' => 'Biblioteca Subterrânea', 'req' => 'seal_4'],
        'old_church'    => ['name' => 'Igreja do Norte', 'req' => 'seal_4'],
        'ritual_site'   => ['name' => 'Local do Ritual', 'req' => 'mercer_has_all'],
    ];
    $available = [];
    foreach ($all as $id => $info) {
        if ($info['req'] === null || flag($info['req'])) {
            $available[$id] = $info['name'];
        }
    }
    return $available;
}
?>