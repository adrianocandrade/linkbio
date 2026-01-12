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
        // ---------------------------------------------------------
        // 1. PRIMEIROS PASSOS (Começando)
        // ---------------------------------------------------------
        $catStart = DocsCategory::updateOrCreate(
            ['slug' => 'comecando'],
            [
                'name' => 'Começando com Meulinkbio',
                'media' => '<i class="bi bi-rocket-takeoff"></i>', // Bootstrap Icon class if applicable, or SVG
                'position' => 1
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'o-que-e-meulinkbio'], [
            'name' => 'O que é o Meulinkbio?',
            'docs_category' => $catStart->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                ['type' => 'text', 'data' => '<p>O <strong>Meulinkbio</strong> é a ferramenta definitiva para conectar sua audiência a todo o seu conteúdo com apenas um link. Ideal para biografias de redes sociais como Instagram, TikTok e Twitter.</p><p>Com ele, você cria uma página personalizada ("landing page") onde pode agrupar:</p><ul><li>Links para seus outros perfis sociais</li><li>Produtos da sua loja</li><li>Agendamento de serviços</li><li>Vídeos, músicas e muito mais</li></ul>']
            ]
        ]);

        DocsGuide::updateOrCreate(['slug' => 'como-criar-sua-pagina'], [
            'name' => 'Como criar sua primeira página',
            'docs_category' => $catStart->id,
            'status' => 1,
            'position' => 2,
            'content' => [
                ['type' => 'text', 'data' => '<p>Criar sua página é simples e rápido:</p><ol><li>Faça login no seu painel.</li><li>Clique no botão <strong>"Criar Página"</strong>.</li><li>Escolha um nome (URL) único para sua página (ex: <code>meulinkbio.com/seunome</code>).</li><li>Você será redirecionado para o editor visual onde poderá adicionar blocos e personalizar o design.</li></ol>']
            ]
        ]);

        // ---------------------------------------------------------
        // 2. GERENCIAMENTO DE CONTA
        // ---------------------------------------------------------
        $catAccount = DocsCategory::updateOrCreate(
            ['slug' => 'sua-conta'],
            [
                'name' => 'Gerenciamento de Conta',
                'media' => '<i class="bi bi-person-circle"></i>',
                'position' => 2
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'configuracoes-de-perfil'], [
            'name' => 'Atualizando seu Perfil',
            'docs_category' => $catAccount->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                ['type' => 'text', 'data' => '<p>Para alterar suas informações pessoais:</p><ol><li>Clique na sua foto de perfil no canto superior direito.</li><li>Vá em <strong>"Minha Conta"</strong>.</li><li>Aqui você pode alterar seu nome, e-mail e fazer o upload de uma nova foto de avatar.</li></ol>']
            ]
        ]);

        DocsGuide::updateOrCreate(['slug' => 'seguranca-2fa'], [
            'name' => 'Segurança e Autenticação em Dois Fatores (2FA)',
            'docs_category' => $catAccount->id,
            'status' => 1,
            'position' => 2,
            'content' => [
                ['type' => 'text', 'data' => '<p>Proteja sua conta ativando a Autenticação de Dois Fatores:</p><ul><li>Nas configurações da conta, navegue até a aba <strong>Segurança</strong>.</li><li>Ative a opção 2FA.</li><li>Escaneie o QR Code usando um aplicativo como Google Authenticator ou Authy.</li><li>Insira o código gerado para confirmar.</li></ul>']
            ]
        ]);

        DocsGuide::updateOrCreate(['slug' => 'excluir-conta'], [
            'name' => 'Como excluir minha conta',
            'docs_category' => $catAccount->id,
            'status' => 1,
            'position' => 3,
            'content' => [
                ['type' => 'text', 'data' => '<p>Lamentamos ver você partir. Se decidir excluir sua conta permanentemente:</p><div class="alert alert-danger"><strong>Atenção:</strong> Esta ação é irreversível. Todos os seus dados, páginas e links serão apagados.</div><ol><li>Acesse <strong>Minha Conta</strong>.</li><li>Role até o final da página.</li><li>Clique no botão vermelho <strong>"Excluir Conta"</strong>.</li><li>Será necessário confirmar sua senha para prosseguir com a exclusão.</li></ol>']
            ]
        ]);

        // ---------------------------------------------------------
        // 3. MÓDULOS E BLOCOS (Geral)
        // ---------------------------------------------------------
        $catModules = DocsCategory::updateOrCreate(
            ['slug' => 'modulos-e-blocos'],
            [
                'name' => 'Módulos e Blocos',
                'media' => '<i class="bi bi-grid-3x3-gap"></i>',
                'position' => 3
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'tipos-de-blocos'], [
            'name' => 'Visão Geral dos Blocos',
            'docs_category' => $catModules->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                ['type' => 'text', 'data' => '<p>Sua página é construída através de "Blocos". Cada bloco tem uma função específica:</p>
                <ul>
                    <li><strong>Link:</strong> Botões simples para redirecionar usuários.</li>
                    <li><strong>Texto:</strong> Títulos, parágrafos ou descrições.</li>
                    <li><strong>Imagem:</strong> Fotos únicas, avatares ou banners.</li>
                    <li><strong>Vídeo:</strong> Embeds do YouTube, Vimeo, etc.</li>
                    <li><strong>Slider:</strong> Carrossel de imagens rotativas.</li>
                    <li><strong>Listas:</strong> Listas de itens com ícones.</li>
                    <li><strong>Embed:</strong> Conteúdo de terceiros (Spotify, SoundCloud, Tweets, Maps).</li>
                </ul>']
            ]
        ]);

        // ---------------------------------------------------------
        // 4. LOJA VIRTUAL (SHOP)
        // ---------------------------------------------------------
        $catShop = DocsCategory::updateOrCreate(
            ['slug' => 'loja-virtual'],
            [
                'name' => 'Criando sua Loja Virtual',
                'media' => '<i class="bi bi-basket"></i>',
                'position' => 4
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'configurando-loja'], [
            'name' => 'Configurando a Loja',
            'docs_category' => $catShop->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                ['type' => 'text', 'data' => '<p>Transforme sua bio em um e-commerce:</p>
                <ol>
                    <li>No editor, adicione o bloco <strong>"Loja"</strong> (Shop).</li>
                    <li>Configure os métodos de pagamento (PayPal, Stripe, etc) nas configurações do bloco.</li>
                    <li>Defina a moeda e as opções de envio, se aplicável.</li>
                </ol>']
            ]
        ]);

        DocsGuide::updateOrCreate(['slug' => 'adicionando-produtos'], [
            'name' => 'Como adicionar Produtos',
            'docs_category' => $catShop->id,
            'status' => 1,
            'position' => 2,
            'content' => [
                ['type' => 'text', 'data' => '<p>Para vender produtos físicos ou digitais:</p>
                <ol>
                    <li>Dentro do bloco da Loja, clique em <strong>"Adicionar Item"</strong>.</li>
                    <li>Preencha o <strong>Nome</strong> e <strong>Preço</strong> do produto.</li>
                    <li>Faça upload de uma imagem atraente.</li>
                    <li>Adicione uma descrição detalhada.</li>
                    <li>Se for um produto digital, você pode fazer upload do arquivo que o cliente receberá após a compra.</li>
                    <li>Salve as alterações.</li>
                </ol>
                <p>O produto aparecerá instantaneamente na sua página!</p>']
            ]
        ]);

        // ---------------------------------------------------------
        // 5. AGENDAMENTOS (BOOKING)
        // ---------------------------------------------------------
        $catBooking = DocsCategory::updateOrCreate(
            ['slug' => 'agendamentos'],
            [
                'name' => 'Sistema de Agendamentos',
                'media' => '<i class="bi bi-calendar-check"></i>',
                'position' => 5
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'criando-agenda-servicos'], [
            'name' => 'Criando uma Agenda de Serviços (Ex: Cabeleireiro)',
            'docs_category' => $catBooking->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                ['type' => 'text', 'data' => '<p>Ideal para salões de beleza, consultores, barbearias e profissionais liberais.</p>
                <h3>Passo 1: Adicionar o Bloco</h3>
                <p>No editor da página, selecione o bloco <strong>"Booking"</strong> ou <strong>"Agendamento"</strong>.</p>
                
                <h3>Passo 2: Definir Horários de Atendimento</h3>
                <p>Nas configurações do bloco, defina seus dias e horários de trabalho (ex: Seg-Sex, das 09:00 às 18:00).</p>

                <h3>Passo 3: Criar Serviços</h3>
                <p>Adicione os serviços que você oferece. Exemplo para Salão:</p>
                <ul>
                    <li><strong>Corte de Cabelo:</strong> Duração 30 min, Preço R$ 50,00</li>
                    <li><strong>Coloração:</strong> Duração 120 min, Preço R$ 150,00</li>
                    <li><strong>Manicure:</strong> Duração 40 min, Preço R$ 40,00</li>
                </ul>
                
                <h3>Passo 4: Gestão</h3>
                <p>Você receberá notificações por e-mail quando um cliente agendar um horário. Você pode visualizar e gerenciar sua agenda diretamente pelo painel.</p>']
            ]
        ]);

        // ---------------------------------------------------------
        // 6. CURSOS (COURSES)
        // ---------------------------------------------------------
        $catCourse = DocsCategory::updateOrCreate(
            ['slug' => 'cursos-online'],
            [
                'name' => 'Venda de Cursos',
                'media' => '<i class="bi bi-mortarboard"></i>',
                'position' => 6
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'vendendo-cursos'], [
            'name' => 'Como criar e vender Cursos',
            'docs_category' => $catCourse->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                ['type' => 'text', 'data' => '<p>Monetize seu conhecimento:</p>
                <ol>
                    <li>Adicione o bloco <strong>"Curso"</strong>.</li>
                    <li>Crie o curso definindo NOME e PREÇO.</li>
                    <li>Adicione módulos e aulas. Você pode inserir vídeos (Youtube/Vimeo) ou textos como conteúdo da aula.</li>
                    <li>Os alunos compram o acesso e podem assistir ao conteúdo diretamente na sua página, em uma área restrita.</li>
                </ol>']
            ]
        ]);
        
        // ---------------------------------------------------------
        // 7. DESIGN E PERSONALIZAÇÃO
        // ---------------------------------------------------------
        $catDesign = DocsCategory::updateOrCreate(
            ['slug' => 'design'],
            [
                'name' => 'Design e Aparência',
                'media' => '<i class="bi bi-palette"></i>',
                'position' => 7
            ]
        );

         DocsGuide::updateOrCreate(['slug' => 'temas-e-cores'], [
            'name' => 'Temas e Cores',
            'docs_category' => $catDesign->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                ['type' => 'text', 'data' => '<p>Vá até a aba "Design" para transformar o visual da sua página.</p>
                <ul>
                    <li><strong>Temas Prontos:</strong> Escolha entre diversas opções profissionais pré-configuradas.</li>
                    <li><strong>Fundo Personalizado:</strong> Use cores sólidas, gradientes, imagens ou até vídeos de fundo.</li>
                    <li><strong>Fontes:</strong> Escolha a tipografia que melhor representa sua marca.</li>
                    <li><strong>Botões:</strong> Personalize o formato (arredondado, quadrado) e as cores dos seus botões de link.</li>
                </ul>']
            ]
        ]);

    }
}
