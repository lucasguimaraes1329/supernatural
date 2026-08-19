<?php
// data/story.php - Todo o roteiro do jogo

$story = [

    // ==================== PRÓLOGO ====================
    'prolog' => [
        'title' => 'Prólogo — O Primeiro Caso',
        'location' => 'Estrada / Black Creek',
        'bg' => 'road_night.jpg',
        'scenes' => [
            0 => [
                'character' => 'dean',
                'text' => "É uma noite chuvosa. O Impala corta a estrada molhada enquanto o rádio toca baixinho uma clássica de rock.\n\nDean dirige, como sempre. Sam está no banco do passageiro, olhando o notebook com fotos de um caso recente.\n\nTrês mortes em menos de uma semana na pequena cidade de Black Creek. A polícia diz que foram acidentes.\n\nMas Sam notou algo nas fotografias...",
                'choices' => [
                    ['text' => 'Continuar dirigindo e ouvir Sam', 'next' => ['prolog', 1]],
                ]
            ],
            1 => [
                'character' => 'sam',
                'text' => "Sam vira a tela para Dean.\n\n— Dean... olha isso. Todas as vítimas têm a mesma marca no corpo. Um símbolo circular formado por sete pequenas linhas.\n\nDean freia o olhar da estrada por um segundo.\n\n— Isso não é acidente. E não é um símbolo comum.",
                'choices' => [
                    ['text' => 'Chegar a Black Creek', 'next' => ['prolog', 2]],
                ]
            ],
            2 => [
                'character' => 'both',
                'text' => "Vocês chegam a Black Creek. A cidade parece quieta demais.\n\nDurante o dia, vocês conversam com moradores, analisam os locais das mortes e procuram informações sobre as vítimas.\n\nÀ noite, decidem explorar o primeiro local onde uma das mortes aconteceu: uma antiga igreja abandonada nos arredores.",
                'choices' => [
                    ['text' => 'Entrar na igreja abandonada', 'next' => ['prolog', 3]],
                ]
            ],
            3 => [
                'character' => 'sam',
                'text' => "Dentro da igreja, o cheiro de mofo e madeira podre é forte. Sam encontra documentos antigos escondidos atrás de uma parede rachada.\n\nOs papéis falam de uma entidade chamada **Vazio Eterno**.\n\nAntes que possam ler mais, as luzes se apagam.\n\nUma criatura emerge das sombras.",
                'choices' => [
                    ['text' => 'Enfrentar a criatura (combate)', 'next' => ['prolog', 4], 'combat' => true],
                ]
            ],
            4 => [
                'character' => 'dean',
                'text' => "A criatura é derrotada após um combate intenso. Mas ela não estava atacando aleatoriamente — estava protegendo alguma coisa.\n\nAtrás do altar existe uma passagem subterrânea.\n\nVocês descem.",
                'choices' => [
                    ['text' => 'Descer pelo túnel', 'next' => ['prolog', 5]],
                ]
            ],
            5 => [
                'character' => 'sam',
                'text' => "No final do túnel, uma enorme pedra negra contém o mesmo símbolo das vítimas.\n\nQuando Sam toca a pedra, uma visão o toma:\n\nSete objetos espalhados por diferentes lugares.\nUma enorme porta sendo aberta.\nDo outro lado... apenas escuridão.\n\nSam acorda assustado.\n\n— Dean... isso não é uma porta. É um **selo**.",
                'choices' => [
                    ['text' => 'Voltar ao bunker e investigar', 'next' => ['chapter1', 0]],
                ]
            ],
        ]
    ],

    // ==================== CAPÍTULO I ====================
    'chapter1' => [
        'title' => 'Capítulo I — O Véu Negro',
        'location' => 'Bunker dos Homens de Letras',
        'bg' => 'bunker.jpg',
        'scenes' => [
            0 => [
                'character' => 'sam',
                'text' => "De volta ao bunker, Sam passa horas vasculhando os arquivos dos Homens de Letras.\n\nFinalmente encontra referências a uma organização secreta: a **Ordem do Véu Negro**.\n\nEles existiam há séculos e acreditavam que o mundo sobrenatural era a raiz de todos os males da humanidade.\n\nSua conclusão extrema: para eliminar monstros, demônios e fantasmas, seria necessário eliminar o próprio sobrenatural.",
                'choices' => [
                    ['text' => 'Continuar a pesquisa', 'next' => ['chapter1', 1]],
                ]
            ],
            1 => [
                'character' => 'both',
                'text' => "A Ordem descobriu a existência do **Vazio Eterno** — uma entidade que existia antes de tudo. Antes do Inferno. Antes do Céu.\n\nOs antigos Homens de Letras a aprisionaram usando **sete selos**, escondidos em diferentes partes do mundo.\n\nSam percebe: alguém está tentando quebrá-los.\n\nDean conclui: as mortes em Black Creek foram apenas o começo.",
                'choices' => [
                    ['text' => 'Seguir a primeira pista do selo', 'next' => ['chapter2', 0]],
                ]
            ],
        ]
    ],

    // ==================== CAPÍTULO II ====================
    'chapter2' => [
        'title' => 'Capítulo II — O Primeiro Selo',
        'location' => 'Floresta Isolada',
        'bg' => 'forest_night.jpg',
        'scenes' => [
            0 => [
                'character' => 'dean',
                'text' => "A primeira pista leva vocês a uma floresta isolada. Moradores relatam desaparecimentos durante a noite.\n\nApós seguir rastros, encontram uma antiga cabana. Dentro dela, os mesmos símbolos de Black Creek.",
                'choices' => [
                    ['text' => 'Investigar a cabana', 'next' => ['chapter2', 1]],
                ]
            ],
            1 => [
                'character' => 'both',
                'text' => "Uma criatura está sendo usada para proteger o primeiro selo.\n\nApós a batalha, vocês encontram o artefato dentro de uma estrutura subterrânea.\n\nSam percebe: o selo **não deve ser destruído**. Ele precisa ser protegido.\n\nVocês recuperam o primeiro selo.",
                'choices' => [
                    ['text' => 'Recuperar o Primeiro Selo', 'next' => ['chapter2', 2], 'gain_seal' => true],
                ]
            ],
            2 => [
                'character' => 'both',
                'text' => "Antes de saírem, encontram uma mensagem deixada pela Ordem:\n\n**\"Sete portas. Sete chaves. Quando a última abrir, nada permanecerá.\"**\n\nA mensagem confirma que existem outros seis selos.",
                'choices' => [
                    ['text' => 'Seguir para a próxima pista', 'next' => ['chapter3', 0]],
                ]
            ],
        ]
    ],

    // ==================== CAPÍTULO III ====================
    'chapter3' => [
        'title' => 'Capítulo III — A Casa dos Mortos',
        'location' => 'Casa Abandonada sobre Cemitério',
        'bg' => 'haunted_house.jpg',
        'scenes' => [
            0 => [
                'character' => 'sam',
                'text' => "A segunda pista leva a uma casa abandonada. Pessoas afirmam ouvir vozes vindas do interior.\n\nA casa foi construída sobre um antigo cemitério. O local está tomado por manifestações sobrenaturais.\n\nSam precisa encontrar objetos, analisar documentos e descobrir a história da casa.",
                'choices' => [
                    ['text' => 'Investigar a casa (Sam)', 'next' => ['chapter3', 1]],
                ]
            ],
            1 => [
                'character' => 'sam',
                'text' => "Sam descobre que antigos membros da Ordem usaram o local para esconder informações sobre o segundo selo.\n\nOs espíritos protegem o local. Após enfrentá-los, vocês encontram o segundo selo.",
                'choices' => [
                    ['text' => 'Recuperar o Segundo Selo', 'next' => ['chapter3', 2], 'gain_seal' => true],
                ]
            ],
            2 => [
                'character' => 'dean',
                'text' => "Antes de saírem, uma figura misteriosa aparece ao longe. Observa vocês... e desaparece.\n\nDean percebe: alguém está acompanhando seus passos.",
                'choices' => [
                    ['text' => 'Continuar a investigação', 'next' => ['chapter4', 0]],
                ]
            ],
        ]
    ],

    // ==================== CAPÍTULO IV ====================
    'chapter4' => [
        'title' => 'Capítulo IV — Sangue na Estrada',
        'location' => 'Cidade / Estradas / Bares',
        'bg' => 'road_bar.jpg',
        'scenes' => [
            0 => [
                'character' => 'both',
                'text' => "Vocês seguem para outra cidade após notícias de desaparecimentos. O caso parece relacionado a vampiros.\n\nApós várias pistas falsas, descobrem que os vampiros estão sendo eliminados por alguém — e essa pessoa procura o terceiro selo.\n\nSam conclui: a Ordem está usando criaturas sobrenaturais para localizar os artefatos.",
                'choices' => [
                    ['text' => 'Encontrar o terceiro selo', 'next' => ['chapter4', 1]],
                ]
            ],
            1 => [
                'character' => 'both',
                'text' => "O terceiro selo está escondido em uma antiga construção subterrânea. Após enfrentar diversos inimigos, vocês o recuperam.\n\nMas ao voltarem ao Impala, descobrem que o bunker foi invadido.\n\nUma única página foi deixada sobre a mesa:\n\n**\"Vocês estão procurando os selos. Nós estamos procurando a chave.\"**",
                'choices' => [
                    ['text' => 'Recuperar o Terceiro Selo e voltar ao bunker', 'next' => ['chapter5', 0], 'gain_seal' => true],
                ]
            ],
        ]
    ],

    // ==================== CAPÍTULO V ====================
    'chapter5' => [
        'title' => 'Capítulo V — O Homem por Trás do Véu',
        'location' => 'Bunker / Encontro',
        'bg' => 'bunker_dark.jpg',
        'scenes' => [
            0 => [
                'character' => 'sam',
                'text' => "Sam finalmente identifica o líder da Ordem: **Elias Mercer**.\n\nMercer era um antigo pesquisador dos Homens de Letras. Desapareceu anos atrás depois de começar a estudar o Vazio Eterno.\n\nEle acredita que os Winchester são responsáveis por manter o ciclo sobrenatural.\n\nSeu plano: eliminar tudo. Humanos. Monstros. Anjos. Demônios. Tudo.",
                'choices' => [
                    ['text' => 'Tentar confrontar a lógica de Mercer', 'next' => ['chapter5', 1]],
                ]
            ],
            1 => [
                'character' => 'both',
                'text' => "Sam tenta convencê-lo de que o plano destruiria a própria humanidade.\n\nMercer responde que a humanidade já está condenada.\n\nEle revela que já possui **três dos sete selos**.\n\nVocês precisam agir rapidamente.",
                'choices' => [
                    ['text' => 'Ir atrás do quarto selo', 'next' => ['chapter6', 0]],
                ]
            ],
        ]
    ],

    // ==================== CAPÍTULO VI ====================
    'chapter6' => [
        'title' => 'Capítulo VI — O Quarto Selo',
        'location' => 'Antiga Mina',
        'bg' => 'mine.jpg',
        'scenes' => [
            0 => [
                'character' => 'sam',
                'text' => "O quarto selo está escondido em uma antiga mina repleta de criaturas.\n\nDurante a exploração, Sam começa a ter visões. O Vazio Eterno fala diretamente com ele.\n\nNão ameaça. Tenta convencer. Mostra um mundo sem guerras, sem monstros, sem sofrimento.\n\nSam percebe a manipulação e resiste.",
                'choices' => [
                    ['text' => 'Resistir às visões e avançar', 'next' => ['chapter6', 1]],
                ]
            ],
            1 => [
                'character' => 'both',
                'text' => "Após enfrentar a criatura guardiã da mina, vocês recuperam o quarto selo.\n\nMas Sam sente que algo mudou.\n\nO Vazio agora sabe quem ele é.",
                'choices' => [
                    ['text' => 'Recuperar o Quarto Selo', 'next' => ['chapter7', 0], 'gain_seal' => true],
                ]
            ],
        ]
    ],

    // ==================== CAPÍTULO VII ====================
    'chapter7' => [
        'title' => 'Capítulo VII — A Queda',
        'location' => 'Construção Abandonada',
        'bg' => 'abandoned_building.jpg',
        'scenes' => [
            0 => [
                'character' => 'both',
                'text' => "A Ordem localiza vocês. O ataque os separa.\n\nDean precisa atravessar a construção abandonada para encontrar Sam.\n\nSam descobre que Mercer já possui o quinto selo.",
                'choices' => [
                    ['text' => 'Controlar Dean — abrir caminho', 'next' => ['chapter7', 1]],
                    ['text' => 'Controlar Sam — coletar informações', 'next' => ['chapter7', 2]],
                ]
            ],
            1 => [
                'character' => 'dean',
                'text' => "Dean avança pela construção, enfrentando membros da Ordem e criaturas. Ele abre caminho com força e determinação.\n\nFinalmente encontra Sam.",
                'choices' => [
                    ['text' => 'Reencontrar Sam', 'next' => ['chapter7', 3]],
                ]
            ],
            2 => [
                'character' => 'sam',
                'text' => "Sam investiga enquanto se esconde. Coleta informações importantes sobre o ritual e a localização dos próximos selos.\n\nDean chega logo depois.",
                'choices' => [
                    ['text' => 'Reencontrar Dean', 'next' => ['chapter7', 3]],
                ]
            ],
            3 => [
                'character' => 'both',
                'text' => "Vocês se reencontram e enfrentam juntos os membros da Ordem.\n\nMercer aparece.\n\n— Só faltam dois selos. E eu não pretendo esperar. O ritual começa esta noite.",
                'choices' => [
                    ['text' => 'Ir atrás dos dois últimos selos', 'next' => ['chapter8', 0]],
                ]
            ],
        ]
    ],

    // ==================== CAPÍTULO VIII ====================
    'chapter8' => [
        'title' => 'Capítulo VIII — Os Dois Últimos Selos',
        'location' => 'Biblioteca Subterrânea / Igreja Abandonada',
        'bg' => 'split_locations.jpg',
        'scenes' => [
            0 => [
                'character' => 'both',
                'text' => "Os dois últimos selos estão em locais diferentes. Vocês precisam se dividir.\n\nSam vai para a antiga biblioteca subterrânea.\nDean vai para a igreja abandonada.",
                'choices' => [
                    ['text' => 'Controlar Sam — buscar o sexto selo', 'next' => ['chapter8', 1]],
                    ['text' => 'Controlar Dean — buscar o sétimo selo', 'next' => ['chapter8', 2]],
                ]
            ],
            1 => [
                'character' => 'sam',
                'text' => "Sam encontra o sexto selo dentro da biblioteca subterrânea, entre livros proibidos e armadilhas antigas.\n\nEle o recupera com sucesso.",
                'choices' => [
                    ['text' => 'Recuperar o Sexto Selo e juntar-se a Dean', 'next' => ['chapter8', 3], 'gain_seal' => true],
                ]
            ],
            2 => [
                'character' => 'dean',
                'text' => "Dean encontra o sétimo selo na igreja abandonada.\n\nQuando o recupera, Mercer aparece.\n\nO confronto termina com Mercer roubando o sétimo selo.\n\nAgora ele possui todos os sete.",
                'choices' => [
                    ['text' => 'Tentar impedir Mercer (falha)', 'next' => ['chapter8', 3]],
                ]
            ],
            3 => [
                'character' => 'sam',
                'text' => "Sam sente que o ritual já começou.\n\nO céu começa a mudar. As criaturas desaparecem. Um silêncio antinatural toma conta de tudo.",
                'choices' => [
                    ['text' => 'Correr para Black Creek', 'next' => ['chapter9', 0]],
                ]
            ],
        ]
    ],

    // ==================== CAPÍTULO IX ====================
    'chapter9' => [
        'title' => 'Capítulo IX — O Ritual',
        'location' => 'Black Creek — Local do Ritual',
        'bg' => 'ritual_site.jpg',
        'scenes' => [
            0 => [
                'character' => 'both',
                'text' => "Vocês retornam a Black Creek. O mesmo local onde tudo começou.\n\nO céu está errado. As ruas vazias. O silêncio é absoluto.\n\nSam percebe: o Vazio está começando a atravessar a realidade.\n\nVocês entram no local do ritual e encontram Mercer diante de uma enorme estrutura formada pelos sete selos.",
                'choices' => [
                    ['text' => 'Interromper o ritual', 'next' => ['chapter9', 1]],
                ]
            ],
            1 => [
                'character' => 'dean',
                'text' => "Dean tenta impedir Mercer. Uma batalha intensa acontece.\n\nMercer é derrotado.\n\nPorém... o ritual já foi concluído.\n\nUma enorme ruptura aparece. O Vazio Eterno começa a emergir.\n\nMercer percebe tarde demais que não consegue controlá-lo. Ele é consumido pelo próprio ritual.",
                'choices' => [
                    ['text' => 'Enfrentar o Vazio Eterno', 'next' => ['chapter10', 0]],
                ]
            ],
        ]
    ],

    // ==================== CAPÍTULO X ====================
    'chapter10' => [
        'title' => 'Capítulo X — O Vazio Eterno',
        'location' => 'Ruptura da Realidade',
        'bg' => 'void.jpg',
        'scenes' => [
            0 => [
                'character' => 'both',
                'text' => "A realidade começa a desaparecer. Partes da construção são destruídas. Objetos sumam. A escuridão consome o ambiente.\n\nSam descobre que destruir a entidade diretamente é impossível. Ela precisa ser aprisionada novamente.\n\nPara isso, os sete selos precisam ser restaurados.\n\nDean deve manter a criatura afastada enquanto Sam realiza o ritual.",
                'choices' => [
                    ['text' => 'Alternar: Dean protege / Sam restaura os selos', 'next' => ['chapter10', 1]],
                ]
            ],
            1 => [
                'character' => 'both',
                'text' => "A cada selo restaurado, a criatura fica mais fraca.\n\nMas o Vazio começa a atacar Sam diretamente. Ele perde a concentração.\n\nDean percebe o perigo, chega até o irmão e o ajuda.\n\nJuntos, vocês completam o ritual.",
                'choices' => [
                    ['text' => 'Completar o ritual', 'next' => ['climax', 0]],
                ]
            ],
        ]
    ],

    // ==================== CLÍMAX ====================
    'climax' => [
        'title' => 'Clímax — O Último Selo',
        'location' => 'Ruptura da Realidade',
        'bg' => 'void_closing.jpg',
        'scenes' => [
            0 => [
                'character' => 'both',
                'text' => "O Vazio Eterno começa a ser puxado de volta para a ruptura.\n\nEntretanto, o último selo está danificado.\n\nSam precisa reconstruí-lo enquanto Dean segura a entidade.\n\nA criatura tenta convencer Dean de que não existe saída.\n\nDean se recusa a desistir.",
                'choices' => [
                    ['text' => 'Segurar a entidade (Dean) enquanto Sam termina', 'next' => ['climax', 1]],
                ]
            ],
            1 => [
                'character' => 'both',
                'text' => "Sam termina o ritual.\n\nOs sete selos brilham simultaneamente.\n\nA ruptura começa a desaparecer.\n\nO Vazio é finalmente puxado de volta.\n\nA porta se fecha.\n\nO silêncio retorna.\n\nPor alguns segundos, Sam e Dean permanecem parados.\n\nDean olha para Sam:\n— Acabou?\n\nSam olha para os selos:\n— Dessa vez... acho que sim.\n\nDean:\n— Então vamos embora antes que alguma coisa mude de ideia.",
                'choices' => [
                    ['text' => 'Sair de Black Creek', 'next' => ['ending', 0]],
                ]
            ],
        ]
    ],

    // ==================== FINAL ====================
    'ending' => [
        'title' => 'Final — A Estrada Continua',
        'location' => 'Bunker / Estrada',
        'bg' => 'road_day.jpg',
        'scenes' => [
            0 => [
                'character' => 'both',
                'text' => "Alguns dias depois, Sam e Dean estão novamente no bunker.\n\nOs sete selos estão guardados em um local seguro.\n\nSam termina de organizar os arquivos do caso.\n\nDean aparece com as chaves do Impala.\n\n— Pronto?\n\nSam fecha o computador.\n\nOs dois saem do bunker.\n\nO Impala começa a percorrer a estrada.\n\nO rádio toca.\n\nDean dirige.\n\nSam observa os arquivos da próxima caçada.\n\nUma nova ocorrência aparece.\n\nDean olha para Sam.\n\nSam sorri.\n\nO carro continua seguindo pela estrada.",
                'choices' => [
                    ['text' => 'FIM', 'next' => ['ending', 1]],
                ]
            ],
            1 => [
                'character' => 'both',
                'text' => "**SUPERNATURAL: O ÚLTIMO SELO**\n\n\"Algumas histórias terminam. As caçadas, nunca.\"\n\nObrigado por jogar.",
                'choices' => [
                    ['text' => 'Jogar novamente', 'next' => ['reset', 0]],
                ]
            ],
        ]
    ],
];

// Lista de capítulos para navegação
$chapters_order = [
    'prolog', 'chapter1', 'chapter2', 'chapter3', 'chapter4',
    'chapter5', 'chapter6', 'chapter7', 'chapter8', 'chapter9',
    'chapter10', 'climax', 'ending'
];
?>