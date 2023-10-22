<?php

return [
    'user' => [
        'register' => [
            'accept_terms' => 'Aceito os <a href=":terms_url" class="underline">Termos de Uso</a> e <a href=":policies_url" class="underline">Políticas</a>',
            'phone' => 'Telefone',
        ],
        'profile' => [
            'phone' => [
                'title' => 'Telefone',
                'description' => 'Adicione e atualize seu número de telefone celular',
                'submit' => 'Atualizar',
                'notify' => __('filament-breezy::default.profile.personal_info.notify'),
            ],
            'username' => [
                'title' => 'Nome de usuário',
                'description' => 'Adicione e atualize seu username',
                'submit' => 'Atualizar',
                'notify' => __('filament-breezy::default.profile.personal_info.notify'),
            ],
        ],
    ],
];
