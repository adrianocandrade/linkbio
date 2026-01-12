<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [
            [
                'name' => '10 Dicas para Otimizar seu Link na Bio',
                'location' => '10-dicas-otimizar-link-bio',
                'description' => '<p>Seu "Link na Bio" é o cartão de visitas digital mais importante que você tem. É a porta de entrada para todo o seu ecossistema online. Aqui estão 10 dicas essenciais para garantir que você esteja convertendo visitantes em seguidores e clientes:</p>
                <h3>1. Mantenha Simples</h3>
                <p>Não sobrecarregue seus visitantes. Mantenha as opções claras e diretas.</p>
                <h3>2. Use Chamadas para Ação (CTAs) Fortes</h3>
                <p>Em vez de "Meu Site", use "Visite meu Site Oficial" ou "Compre Agora".</p>
                <h3>3. Atualize Regularmente</h3>
                <p>Mantenha seus links frescos. Se você lançou um vídeo novo, coloque-o no topo.</p>
                <p>...</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?q=80&w=1000&auto=format&fit=crop',
                'author' => 'Time LinkBioTop',
                'ttr' => '5 min',
                'status' => 1,
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'name' => 'Como Monetizar sua Audiência no Instagram',
                'location' => 'como-monetizar-audiencia-instagram',
                'description' => '<p>O Instagram não é apenas para likes; é uma ferramenta de negócios poderosa. Descubra como transformar seguidores em renda.</p>
                <h3>Venda Produtos Digitais</h3>
                <p>E-books, presets, e cursos são ótimas formas de começar.</p>
                <h3>Ofereça Consultorias</h3>
                <p>Use seu link na bio para agendar chamadas e receber pagamentos diretamente.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1579621970563-ebec7560eb3e?q=80&w=1000&auto=format&fit=crop',
                'author' => 'Adriano Andrade',
                'ttr' => '7 min',
                'status' => 1,
                'created_at' => Carbon::now()->subDays(9),
            ],
            [
                'name' => 'A Importância de uma Identidade Visual Coesa',
                'location' => 'importancia-identidade-visual',
                'description' => '<p>Sua marca pessoal precisa ser reconhecível instantaneamente. Aprenda a personalizar seu LinkBioTop para combinar com seu feed.</p>
                <p>Cores, fontes e imagens consistentes criam confiança e profissionalismo.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?q=80&w=1000&auto=format&fit=crop',
                'author' => 'Design Team',
                'ttr' => '4 min',
                'status' => 1,
                'created_at' => Carbon::now()->subDays(8),
            ],
            [
                'name' => 'Analytics: O Segredo do Crescimento',
                'location' => 'analytics-segredo-crescimento',
                'description' => '<p>Você não pode melhorar o que não mede. Entenda como usar os dados do LinkBioTop para saber o que seu público quer.</p>
                <ul>
                    <li>Quais links recebem mais cliques?</li>
                    <li>De onde vêm seus visitantes?</li>
                    <li>Qual o melhor horário para postar?</li>
                </ul>',
                'thumbnail' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=1000&auto=format&fit=crop',
                'author' => 'Data Science',
                'ttr' => '6 min',
                'status' => 1,
                'created_at' => Carbon::now()->subDays(7),
            ],
            [
                'name' => 'Criando uma Loja Virtual no seu Link na Bio',
                'location' => 'criando-loja-virtual-link-bio',
                'description' => '<p>Você não precisa de um site complexo para começar a vender. Com o módulo de Loja do LinkBioTop, você pode vender produtos físicos e digitais em minutos.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1472851294608-415522f97817?q=80&w=1000&auto=format&fit=crop',
                'author' => 'Time LinkBioTop',
                'ttr' => '8 min',
                'status' => 1,
                'created_at' => Carbon::now()->subDays(6),
            ],
            [
                'name' => 'SEO para Links: Sendo Encontrado no Google',
                'location' => 'seo-para-links',
                'description' => '<p>Sim, seu LinkBioTop pode aparecer no Google! Configure títulos e descrições SEO para aumentar sua visibilidade orgânica.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?q=80&w=1000&auto=format&fit=crop',
                'author' => 'SEO Expert',
                'ttr' => '5 min',
                'status' => 1,
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Integrando Pagamentos: PayPal, Stripe e Pix',
                'location' => 'integrando-pagamentos-pix',
                'description' => '<p>Facilite a vida do seu cliente aceitando múltiplas formas de pagamento diretamente na sua página.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1556742049-0cfed4f7a07d?q=80&w=1000&auto=format&fit=crop',
                'author' => 'Finanças',
                'ttr' => '4 min',
                'status' => 1,
                'created_at' => Carbon::now()->subDays(4),
            ],
             [
                'name' => 'O Poder do Video Marketing',
                'location' => 'poder-video-marketing',
                'description' => '<p>Incorpore vídeos do YouTube ou Vimeo diretamente no seu LinkBioTop para aumentar o engajamento e o tempo de permanência na página.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1492619875057-d017a00e8438?q=80&w=1000&auto=format&fit=crop',
                'author' => 'Video Maker',
                'ttr' => '5 min',
                'status' => 1,
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'Capturando Leads e E-mails',
                'location' => 'capturando-leads-emails',
                'description' => '<p>Construa sua lista de e-mails usando nosso bloco de "Newsletter". O e-mail marketing ainda é uma das ferramentas com maior ROI.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1563986768494-4dee2763ff3f?q=80&w=1000&auto=format&fit=crop',
                'author' => 'Marketing Team',
                'ttr' => '6 min',
                'status' => 1,
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'O Futuro da "Creator Economy"',
                'location' => 'futuro-creator-economy',
                'description' => '<p>Para onde o mercado de criadores está indo? Discutimos tendências para 2026 e como você pode se preparar para sair na frente.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1000&auto=format&fit=crop',
                'author' => 'Adriano Andrade',
                'ttr' => '10 min',
                'status' => 1,
                'created_at' => Carbon::now()->subDays(1),
            ],
        ];

        foreach ($posts as $post) {
            DB::table('blog')->updateOrInsert(
                ['location' => $post['location']],
                $post
            );
        }
    }
}
