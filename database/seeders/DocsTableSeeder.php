<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocsCategory;
use App\Models\DocsGuide;

class DocsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Category "Primeiros Passos"
        $category = DocsCategory::firstOrCreate(
            ['slug' => 'primeiros-passos'],
            [
                'name' => 'Primeiros Passos',
                'media' => null,
                'position' => 1
            ]
        );

        // Guide 1: Como criar uma página
        DocsGuide::updateOrCreate(
            ['slug' => 'como-criar-uma-pagina'],
            [
                'name' => 'Como criar uma página',
                'docs_category' => $category->id,
                'status' => 1,
                'media' => null,
                'position' => 1,
                'content' => [
                    [
                        'type' => 'text',
                        'data' => '<p>Para criar uma nova página em seu LinkBio, siga os passos abaixo:</p><ol><li>Acesse o painel do usuário.</li><li>Clique no botão "Criar Nova Página" ou "New Page".</li><li>Escolha um nome para sua página (ex: "Meu Perfil").</li><li>Defina a URL personalizada.</li><li>Personalize o design e adicione seus links.</li></ol><p>É simples e rápido!</p>'
                    ]
                ]
            ]
        );

        // Guide 2: Como adicionar links
        DocsGuide::updateOrCreate(
            ['slug' => 'como-adicionar-links'],
            [
                'name' => 'Como adicionar links',
                'docs_category' => $category->id,
                'status' => 1,
                'media' => null,
                'position' => 2,
                'content' => [
                    [
                        'type' => 'text',
                        'data' => '<p>Após criar sua página, você pode adicionar quantos links quiser:</p><ul><li>No editor da página, clique em "Adicionar Bloco".</li><li>Selecione o tipo "Link".</li><li>Insira o título do link e a URL de destino.</li><li>Você pode adicionar ícones, imagens ou destacar o link para chamar mais atenção.</li></ul>'
                    ]
                ]
            ]
        );
         
         // Guide 3: Personalizando o Design
        DocsGuide::updateOrCreate(
            ['slug' => 'personalizando-design'],
            [
                'name' => 'Personalizando o Design',
                'docs_category' => $category->id,
                'status' => 1,
                'media' => null,
                'position' => 3,
                'content' => [
                    [
                        'type' => 'text',
                        'data' => '<p>Deixe sua página com a sua cara:</p><p>Vá até a aba "Aparência" ou "Design" no editor. Você pode escolher temas pré-definidos, alterar as cores de fundo, botões e textos, e até mesmo usar uma imagem ou vídeo de fundo.</p>'
                    ]
                ]
            ]
        );
    }
}
