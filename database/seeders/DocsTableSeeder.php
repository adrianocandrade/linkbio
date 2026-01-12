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
                'media' => '<i class="bi bi-rocket-takeoff"></i>',
                'position' => 1
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'o-que-e-meulinkbio'], [
            'name' => 'O que é o Meulinkbio?',
            'docs_category' => $catStart->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                'subdes' => 'Sua identidade digital em um único link.',
                'content' => '<p>O <strong>Meulinkbio</strong> é a ferramenta definitiva para conectar sua audiência a todo o seu conteúdo com apenas um link. Ideal para biografias de redes sociais como Instagram, TikTok e Twitter.</p><p>Com ele, você cria uma página personalizada ("landing page") onde pode agrupar:</p><ul><li>Links para seus outros perfis sociais</li><li>Produtos da sua loja</li><li>Agendamento de serviços</li><li>Vídeos, músicas e muito mais</li></ul>'
            ]
        ]);

        DocsGuide::updateOrCreate(['slug' => 'como-criar-sua-pagina'], [
            'name' => 'Como criar sua primeira página',
            'docs_category' => $catStart->id,
            'status' => 1,
            'position' => 2,
            'content' => [
                'subdes' => 'Passo a passo para lançar seu link na bio.',
                'content' => '<p>Criar sua página é simples e rápido:</p><ol><li>Faça login no seu painel.</li><li>Clique no botão <strong>"Criar Página"</strong> no menu lateral ou dashboard.</li><li>Escolha um nome (URL) único para sua página (ex: <code>meulinkbio.com/seunome</code>).</li><li>Você será redirecionado para o editor visual onde poderá adicionar blocos e personalizar o design.</li></ol>'
            ]
        ]);

        // ---------------------------------------------------------
        // 2. DESIGN E PERSONALIZAÇÃO
        // ---------------------------------------------------------
        $catDesign = DocsCategory::updateOrCreate(
            ['slug' => 'design'],
            [
                'name' => 'Design e Aparência',
                'media' => '<i class="bi bi-palette"></i>',
                'position' => 2
            ]
        );

         DocsGuide::updateOrCreate(['slug' => 'temas-e-cores'], [
            'name' => 'Temas, Cores e Fontes',
            'docs_category' => $catDesign->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                'subdes' => 'Deixe sua página com a identidade da sua marca.',
                'content' => '<p>No menu <strong>Configurações > Aparência</strong>, você tem total controle visual:</p>
                <ul>
                    <li><strong>Temas Prontos:</strong> Selecione um dos nossos temas profissionais para começar rápido.</li>
                    <li><strong>Fundo:</strong> Use cores sólidas, gradientes modernos, faça upload de uma imagem ou use um vídeo em loop como background.</li>
                    <li><strong>Botões:</strong> Defina o formato (redondo, quadrado, pílula), cor do fundo, cor do texto e bordas.</li>
                    <li><strong>Fontes:</strong> Escolha entre dezenas de fontes do Google Fonts para títulos e textos.</li>
                </ul>'
            ]
        ]);

        // ---------------------------------------------------------
        // 3. BLOCOS E ELEMENTOS (Expandido)
        // ---------------------------------------------------------
        $catModules = DocsCategory::updateOrCreate(
            ['slug' => 'blocos-e-elementos'],
            [
                'name' => 'Blocos e Elementos',
                'media' => '<i class="bi bi-grid-3x3-gap"></i>',
                'position' => 3
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'blocos-essenciais'], [
            'name' => 'Blocos Essenciais',
            'docs_category' => $catModules->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                'subdes' => 'Links, Textos, Imagens e Vídeos.',
                'content' => '<p>Os blocos fundamentais para qualquer página:</p>
                <ul>
                    <li><strong>Incorporar Link:</strong> O bloco mais comum. Adicione um botão com link para qualquer site, WhatsApp, Telegram, etc.</li>
                    <li><strong>Cabeçalho e Texto:</strong> Adicione títulos para organizar seções ou parágrafos sobre você.</li>
                    <li><strong>Avatar e Imagens:</strong> Sua foto de perfil ou banners promocionais.</li>
                    <li><strong>Redes Sociais:</strong> Ícones clicáveis para seus perfis (Insta, Twitter, LinkedIn).</li>
                </ul>'
            ]
        ]);

        DocsGuide::updateOrCreate(['slug' => 'blocos-interacao'], [
            'name' => 'Interação e Engajamento',
            'docs_category' => $catModules->id,
            'status' => 1,
            'position' => 2,
            'content' => [
                'subdes' => 'Votações, Perguntas e Mensagens.',
                'content' => '<p>Engaje sua audiência diretamente na bio:</p>
                <ul>
                    <li><strong>Votação (Enquete):</strong> Faça perguntas e deixe seus seguidores votarem nas opções.</li>
                    <li><strong>Perguntas e Respostas (Q&A):</strong> Permita que visitantes enviem perguntas para você.</li>
                    <li><strong>Mensagem Anônima:</strong> Receba feedback ou segredos da sua audiência de forma anônima.</li>
                    <li><strong>Livro de Visitas:</strong> Um espaço para seus fãs deixarem recados públicos.</li>
                    <li><strong>Avaliação da Página:</strong> Deixe os visitantes darem uma nota (estrelas) para seu conteúdo.</li>
                </ul>'
            ]
        ]);

        DocsGuide::updateOrCreate(['slug' => 'blocos-conteudo-vip'], [
            'name' => 'Conteúdo VIP e Monetização Rápida',
            'docs_category' => $catModules->id,
            'status' => 1,
            'position' => 3,
            'content' => [
                'subdes' => 'Venda acesso a fotos, vídeos e arquivos.',
                'content' => '<p>Monetize itens individuais sem criar um curso completo:</p>
                <ul>
                    <li><strong>Desbloquear Imagem/Vídeo:</strong> O visitante vê um "borrão" ou capa e precisa pagar para liberar o conteúdo completo. Ótimo para packs de fotos ou vídeos exclusivos.</li>
                    <li><strong>Arquivos para Download:</strong> Venda e-books, presets, templates ou planilhas. O link de download é liberado após o pagamento.</li>
                    <li><strong>Sistema de Doação:</strong> Adicione um botão para receber apoio financeiro (cafézinho) via PayPal/Stripe.</li>
                </ul>'
            ]
        ]);

        DocsGuide::updateOrCreate(['slug' => 'blocos-utilitarios'], [
            'name' => 'Ferramentas Úteis (QR Code, WhatsApp, Sorteio)',
            'docs_category' => $catModules->id,
            'status' => 1,
            'position' => 4,
            'content' => [
                'subdes' => 'Recursos práticos para o dia a dia.',
                'content' => '<p>Funcionalidades extras para potenciar sua bio:</p>
                <ul>
                    <li><strong>Link WhatsApp:</strong> Botão direto que abre a conversa no app com uma mensagem pré-definida.</li>
                    <li><strong>QR Code:</strong> Gere e exiba um QR Code para compartilhar sua página ou outro link.</li>
                    <li><strong>Coleta para Sorteio:</strong> Capture Nome e Telefone/Email de visitantes para realizar sorteios.</li>
                    <li><strong>Barra de Habilidade:</strong> Mostre suas competências (ex: Design 90%, PHP 80%) de forma visual.</li>
                </ul>'
            ]
        ]);

        // ---------------------------------------------------------
        // 4. CONFIGURAÇÕES AVANÇADAS
        // ---------------------------------------------------------
        $catSettings = DocsCategory::updateOrCreate(
            ['slug' => 'configuracoes-avancadas'],
            [
                'name' => 'Configurações Avançadas',
                'media' => '<i class="bi bi-gear-wide-connected"></i>',
                'position' => 4
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'seo-e-pixel'], [
            'name' => 'SEO e Pixels de Rastreamento',
            'docs_category' => $catSettings->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                'subdes' => 'Otimização para buscadores e marketing.',
                'content' => '<h3>SEO Personalizado</h3><p>Configure o Título da Página (Meta Title) e a Descrição (Meta Description) para aparecerem corretamente no Google e ao compartilhar o link no WhatsApp/Facebook.</p>
                <h3>Pixels</h3><p>Instale pixels de rastreamento para criar públicos de remarketing:</p>
                <ul><li>Facebook Pixel</li><li>Google Analytics (GA4)</li><li>TikTok Pixel</li></ul>'
            ]
        ]);

        DocsGuide::updateOrCreate(['slug' => 'dominio-proprio'], [
            'name' => 'Conectando Domínio Próprio',
            'docs_category' => $catSettings->id,
            'status' => 1,
            'position' => 2,
            'content' => [
                'subdes' => 'Use seu próprio endereço .com ou .com.br',
                'content' => '<p>Para usar um domínio como <code>suamarca.com</code> ao invés de <code>meulinkbio.com/voce</code>:</p>
                <ol>
                    <li>Vá em <strong>Configurações > Domínio</strong>.</li>
                    <li>Digite seu domínio.</li>
                    <li>No registro do seu domínio (Godaddy, Registro.br, etc), crie um apontamento <strong>CNAME</strong> ou <strong>A Record</strong> conforme as instruções na tela.</li>
                    <li>Aguarde a propagação (pode levar até 24h).</li>
                </ol>'
            ]
        ]);

        // ---------------------------------------------------------
        // 5. ESTATÍSTICAS E AUDIÊNCIA
        // ---------------------------------------------------------
        $catAnalytics = DocsCategory::updateOrCreate(
            ['slug' => 'estatisticas-audiencia'],
            [
                'name' => 'Análise e Audiência',
                'media' => '<i class="bi bi-graph-up-arrow"></i>',
                'position' => 5
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'entendendo-estatisticas'], [
            'name' => 'Entendendo suas Estatísticas',
            'docs_category' => $catAnalytics->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                'subdes' => 'Monitore o desempenho da sua página.',
                'content' => '<p>O painel de estatísticas oferece dados em tempo real:</p>
                <ul>
                    <li><strong>Visitas Únicas:</strong> Quantas pessoas diferentes acessaram.</li>
                    <li><strong>Cliques Totais:</strong> Quantas vezes clicaram nos seus links.</li>
                    <li><strong>CTR (Taxa de Cliques):</strong> Porcentagem de visitantes que clicaram em algum link.</li>
                    <li><strong>Geolocalização:</strong> Países e cidades de onde vêm seus acessos.</li>
                    <li><strong>Dispositivos:</strong> Se usam Celular, Desktop, Chrome, Safari, etc.</li>
                </ul>'
            ]
        ]);

        DocsGuide::updateOrCreate(['slug' => 'gerenciando-audiencia'], [
            'name' => 'Gerenciando sua Audiência',
            'docs_category' => $catAnalytics->id,
            'status' => 1,
            'position' => 2,
            'content' => [
                'subdes' => 'Visualize e exporte seus leads.',
                'content' => '<p>Na aba <strong>Audiência</strong>, você vê todos os usuários que:</p>
                <ul>
                    <li>Assinaram sua Newsletter (bloco de coleta de e-mail).</li>
                    <li>Compraram produtos na sua loja.</li>
                    <li>Se cadastraram em sorteios.</li>
                </ul>
                <p>Você pode ver o nome, e-mail, data de cadastro e exportar essa lista para usar em ferramentas de e-mail marketing.</p>'
            ]
        ]);

        // ---------------------------------------------------------
        // 6. LOJA VIRTUAL (SHOP)
        // ---------------------------------------------------------
        $catShop = DocsCategory::updateOrCreate(
            ['slug' => 'loja-virtual'],
            [
                'name' => 'Loja e Produtos',
                'media' => '<i class="bi bi-bag-check"></i>',
                'position' => 6
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'criando-loja'], [
            'name' => 'Configurando sua Loja',
            'docs_category' => $catShop->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                'subdes' => 'Venda produtos físicos e digitais.',
                'content' => '<p>Adicione o bloco <strong>Loja</strong> para começar a vender. Configure gateways de pagamento nas configurações e cadastre produtos com foto, descrição e preço. Para produtos digitais, faça o upload do arquivo e o cliente receberá automaticamente após pagar.</p>'
            ]
        ]);

        // ---------------------------------------------------------
        // 7. MEMBROS E ASSINATURAS
        // ---------------------------------------------------------
        $catMembers = DocsCategory::updateOrCreate(
            ['slug' => 'membros'],
            [
                'name' => 'Área de Membros',
                'media' => '<i class="bi bi-people"></i>',
                'position' => 7
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'planos-de-assinatura'], [
            'name' => 'Criando Planos de Assinatura',
            'docs_category' => $catMembers->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                'subdes' => 'Receita recorrente com conteúdo exclusivo.',
                'content' => '<p>Na seção <strong>Membros</strong>, você pode criar Planos de Assinatura (ex: Mensal, Anual).</p>
                <p>1. Crie um Plano (defina nome e preço recorrente).</p>
                <p>2. Ao adicionar blocos na sua página (como vídeos, posts ou downloads), você pode restringir o acesso apenas para "Assinantes do Plano X".</p>
                <p>Isso permite criar um clube de membros VIP dentro do seu próprio link na bio.</p>'
            ]
        ]);
        
        // ---------------------------------------------------------
        // 8. GERENCIAMENTO DE CONTA
        // ---------------------------------------------------------
        $catAccount = DocsCategory::updateOrCreate(
            ['slug' => 'sua-conta'],
            [
                'name' => 'Sua Conta',
                'media' => '<i class="bi bi-person-badge"></i>',
                'position' => 8
            ]
        );

        DocsGuide::updateOrCreate(['slug' => 'seguranca-conta'], [
            'name' => 'Perfil e Segurança',
            'docs_category' => $catAccount->id,
            'status' => 1,
            'position' => 1,
            'content' => [
                'subdes' => '2FA, Senha e Dados Pessoais.',
                'content' => '<p>Mantenha seus dados atualizados em <strong>Conta</strong>. Recomendamos ativar a <strong>Autenticação de Dois Fatores (2FA)</strong> para proteger seus ganhos e dados. Use apps como Google Authenticator.</p>'
            ]
        ]);
    }
}
