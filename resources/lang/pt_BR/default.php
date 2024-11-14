<?php

return [
    'users' => [
        'register' => [
            'accept_terms' => 'Eu aceito os <a href=":terms_url" class="underline">Termos de Uso</a> e as <a href=":policies_url" class="underline">Políticas</a>',
            'phone' => 'Telefone',
        ],
        'profile' => [
            'phone' => [
                'title' => 'Telefone',
                'description' => 'Adicione e atualize seu número de telefone',
                'submit' => 'Atualizar',
                'notify' => 'Perfil atualizado com sucesso!',
            ],
            'username' => [
                'title' => 'Nome de Usuário',
                'description' => 'Adicione e atualize seu nome de usuário',
                'submit' => 'Atualizar',
                'notify' => 'Senha atualizada com sucesso!',
            ],
        ],
    ],

    'features' => [
        'title' => 'Funcionalidades',
        'heading' => 'Funcionalidades',
        'subheading' => 'Essas são as principais funcionalidades do sistema.',
        'developer' => [
            'title' => 'Desenvolvedor',
            'webhooks' => [
                'title' => 'Webhooks',
                'help_text' => 'Habilitar página de webhooks.',
                'history' => [
                    'label' => 'Histórico de Webhooks',
                    'help_text' => 'Os eventos serão armazenados no banco de dados.',
                ],
                'poll_interval' => [
                    'label' => 'Intervalo de Polling de Webhooks',
                    'help_text' => 'Intervalo de tempo em segundos.',
                ],
                'models' => [
                    'label' => 'Modelos de Webhooks',
                    'help_text' => 'Os modelos que serão listados na página de webhooks.',
                ],
            ],
        ],
        'user' => [
            'title' => 'Usuário',
            'switch_language' => [
                'label' => 'Trocar Idioma',
                'help_text' => 'Habilitar opção de troca de idioma na barra superior.',
            ],
            'phone' => [
                'label' => 'Telefone',
                'help_text' => 'Habilitar telefone na página de registro e perfil.',
            ],
            'username' => [
                'label' => 'Nome de Usuário',
                'help_text' => 'Habilitar nome de usuário na página de registro e perfil.',
            ],
            'user_phone' => [
                'label' => 'Telefone do Usuário',
                'help_text' => 'Habilitar telefone na página de registro e perfil.',
            ],
        ],
        'terms_and_privacy_policy' => [
            'title' => 'Termos e Política de Privacidade',
            'help_text' => 'Habilitar página de termos e políticas.',
            'terms' => [
                'label' => 'Termos',
            ],
            'privacy_policy' => [
                'label' => 'Política de Privacidade',
            ],
        ],
    ],

    'settings' => [
        'title' => 'Configurações',
        'heading' => 'Configurações',
        'subheading' => 'Essas são as principais configurações do site.',
        'seo' => [
            'title' => 'SEO',
            'name' => [
                'label' => 'Nome',
            ],
            'keywords' => [
                'label' => 'Palavras-chave',
                'help_text' => 'Pressione Enter para adicionar palavras-chave.',
            ],
            'description' => [
                'label' => 'Descrição',
                'help_text' => 'HTML não é permitido.',
            ],
        ],
        'style' => [
            'title' => 'Estilo',
            'logo' => [
                'label' => 'Logo',
                'help_text' => 'Envie seu logo. Tamanho recomendado: proporção de 3x1.',
            ],
            'logo_size' => [
                'label' => 'Tamanho do Logo',
                'help_text' => 'Exemplo: 2rem',
            ],
            'favicon' => [
                'label' => 'Favicon',
            ],
        ],
        'security' => [
            'title' => 'Segurança',
            'restrict_ips' => [
                'label' => 'Restringir IPs',
                'help_text' => 'Cuidado: Se você bloquear seu próprio IP, será bloqueado do site e terá que remover o IP do banco de dados manualmente ou acessar de outro IP.',
            ],
            'restrict_users' => [
                'label' => 'Restringir Usuários',
                'help_text' => 'Cuidado: Se você bloquear seu próprio usuário, será bloqueado do site e terá que remover o usuário do banco de dados manualmente ou acessar com outro usuário.',
            ],
        ],
        'localization' => [
            'title' => 'Localização',
            'timezone' => [
                'label' => 'Fuso Horário',
                'help_text' => 'A hora atual é :time.',
            ],
            'locale' => [
                'label' => 'Idioma',
                'help_text' => 'Se você mudar o idioma, ele será exibido de acordo com a configuração.',
            ],
            'locales' => [
                'label' => 'Idiomas',
                'help_text' => 'Lista de idiomas disponíveis.',
            ],
        ],
    ],
];
