<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'name' => 'Termos de Uso',
                'title' => 'Termos de Uso',
                'location' => 'termos-de-uso',
                'description' => '<h2>1. Aceitação dos Termos</h2>
<p>Ao acessar e usar o Meulinkbio, você aceita e concorda em estar vinculado aos termos e disposições deste acordo. Além disso, ao usar os serviços particulares deste site, você deve estar sujeito a todas as diretrizes ou regras publicadas aplicáveis a esses serviços. Qualquer participação neste serviço constituirá a aceitação deste acordo. Se você não concordar em cumprir o acima exposto, por favor, não o utilize.</p>

<h2>2. Descrição do Serviço</h2>
<p>O Meulinkbio fornece aos usuários ferramentas para criar uma página personalizada de "link na bio" para conectar suas audiências a todo o seu conteúdo com apenas um link.</p>

<h2>3. Responsabilidades do Usuário</h2>
<p>Você é responsável por manter a confidencialidade de sua conta e senha e por restringir o acesso ao seu computador, e concorda em aceitar a responsabilidade por todas as atividades que ocorram sob sua conta ou senha. O Meulinkbio reserva-se o direito de recusar o serviço, encerrar contas, remover ou editar conteúdo a seu critério exclusivo.</p>

<h2>4. Conteúdo Proibido</h2>
<p>É estritamente proibido usar o serviço para postar conteúdo que seja ilegal, ofensivo, ameaçador, calunioso, difamatório, pornográfico ou que viole a propriedade intelectual de qualquer parte ou estes Termos de Uso.</p>

<h2>5. Alterações nos Termos</h2>
<p>Reservamo-nos o direito de alterar estes termos de tempos em tempos, conforme nosso critério exclusivo. O uso continuado do site após quaisquer alterações constitui sua aceitação dos novos termos.</p>

<h2>6. Contato</h2>
<p>Se você tiver alguma dúvida sobre estes Termos, entre em contato conosco através do nosso suporte.</p>',
                'author' => 'Admin',
                'ttr' => '5 min'
            ],
            [
                'name' => 'Política de Privacidade',
                'title' => 'Política de Privacidade',
                'location' => 'politica-de-privacidade',
                'description' => '<h2>1. Coleta de Informações</h2>
<p>Coletamos informações quando você se registra em nosso site, faz login em sua conta, faz uma compra, participa de um concurso e/ou sai do sistema. As informações coletadas incluem seu nome, endereço de e-mail, número de telefone e/ou cartão de crédito.</p>

<h2>2. Uso das Informações</h2>
<p>Qualquer informação que coletamos de você pode ser usada para:</p>
<ul>
    <li>Personalizar sua experiência e responder às suas necessidades individuais</li>
    <li>Fornecer conteúdo publicitário personalizado</li>
    <li>Melhorar nosso site</li>
    <li>Melhorar o atendimento ao cliente e suas necessidades de suporte</li>
    <li>Contatar você por e-mail</li>
    <li>Administrar um concurso, promoção ou pesquisa</li>
</ul>

<h2>3. Privacidade do E-commerce</h2>
<p>Nós somos os únicos proprietários das informações coletadas neste site. Suas informações, sejam públicas ou privadas, não serão vendidas, trocadas, transferidas ou dadas a qualquer outra empresa por qualquer motivo, sem o seu consentimento, exceto para o propósito expresso de entregar o produto ou serviço adquirido.</p>

<h2>4. Divulgação a Terceiros</h2>
<p>Nós não vendemos, trocamos ou transferimos de outra forma para terceiros suas informações de identificação pessoal. Isso não inclui terceiros de confiança que nos auxiliam na operação de nosso site, na condução de nossos negócios ou no atendimento a você, desde que essas partes concordem em manter essas informações confidenciais.</p>

<h2>5. Segurança das Informações</h2>
<p>Implementamos uma variedade de medidas de segurança para manter a segurança de suas informações pessoais. Usamos criptografia de ponta a ponta para proteger informações sensíveis transmitidas online.</p>

<h2>6. Consentimento</h2>
<p>Ao usar nosso site, você concorda com nossa política de privacidade.</p>',
                'author' => 'Admin',
                'ttr' => '5 min'
            ],
            [
                'name' => 'Política de Cookies',
                'title' => 'Política de Cookies',
                'location' => 'politica-de-cookies',
                'description' => '<h2>1. O que são Cookies?</h2>
<p>Cookies são pequenos arquivos de texto que são armazenados no seu computador ou dispositivo móvel quando você visita um site. Eles são amplamente utilizados para fazer os sites funcionarem, ou funcionarem de forma mais eficiente, bem como para fornecer informações aos proprietários do site.</p>

<h2>2. Como usamos os Cookies?</h2>
<p>Utilizamos cookies para:</p>
<ul>
    <li>Entender e salvar as preferências do usuário para visitas futuras.</li>
    <li>Compilar dados agregados sobre o tráfego e as interações no site para oferecer melhores experiências e ferramentas no futuro.</li>
    <li>Permitir o funcionamento de certos recursos do serviço, como autenticação e segurança.</li>
</ul>

<h2>3. Tipos de Cookies que usamos</h2>
<p><strong>Cookies Essenciais:</strong> Necessários para que o site funcione corretamente. Eles permitem que você navegue e use recursos essenciais.</p>
<p><strong>Cookies de Desempenho:</strong> Coletam informações sobre como os visitantes usam o site, quais páginas visitam com mais frequência e se recebem mensagens de erro. Eles nos ajudam a melhorar o funcionamento do site.</p>
<p><strong>Cookies de Funcionalidade:</strong> Permitem que o site lembre as escolhas que você faz (como seu nome de usuário, idioma ou região) e forneça recursos aprimorados e mais pessoais.</p>

<h2>4. Gerenciamento de Cookies</h2>
<p>Você pode optar por desativar os cookies através das configurações do seu navegador. No entanto, desativar os cookies pode afetar a funcionalidade de algumas partes do nosso serviço.</p>',
                'author' => 'Admin',
                'ttr' => '3 min'
            ],
            [
                'name' => 'Sobre Nós',
                'title' => 'Sobre Nós',
                'location' => 'sobre-nos',
                'description' => '<h2>Nossa Missão</h2>
<p>No Meulinkbio, nossa missão é simplificar a forma como criadores, influenciadores e empresas compartilham seu conteúdo. Acreditamos que você deve ter controle total sobre sua presença online, sem barreiras técnicas.</p>

<h2>O que fazemos</h2>
<p>Oferecemos uma plataforma intuitiva e poderosa que permite criar uma página de aterrissagem (landing page) personalizada em minutos. Com apenas um link, você pode direcionar seus seguidores para todos os seus perfis de mídia social, produtos, vídeos, músicas e muito mais.</p>

<h2>Por que escolher o Meulinkbio?</h2>
<ul>
    <li><strong>Simplicidade:</strong> Interface fácil de usar, sem necessidade de codificação.</li>
    <li><strong>Personalização:</strong> Temas, cores e fontes para combinar com sua marca.</li>
    <li><strong>Análises:</strong> Acompanhe cliques e visualizações para entender seu público.</li>
    <li><strong>Crescimento:</strong> Ferramentas projetadas para ajudar você a crescer sua audiência e monetizar seu conteúdo.</li>
</ul>

<h2>Junte-se a nós</h2>
<p>Junte-se a milhares de usuários que já estão usando o Meulinkbio para centralizar sua presença digital. Crie sua conta hoje e comece a compartilhar!</p>',
                'author' => 'Admin',
                'ttr' => '2 min'
            ]
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['location' => $page['location']], // Check to avoid duplicates
                [
                    'name' => $page['name'],
                    'title' => $page['title'],
                    'description' => $page['description'],
                    'type' => 'internal',
                    'status' => 1,
                    'postedBy' => 1, // Assign to Admin ID 1
                    'author' => $page['author'],
                    'ttr' => $page['ttr'],
                    'total_views' => 0,
                    'order' => 0
                ]
            );
        }
    }
}
