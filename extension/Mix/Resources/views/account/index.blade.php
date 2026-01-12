@extends('mix::layouts.master')
@section('title', __('Account'))

@section('content')
<div class="mix-padding-10">
    <div class="dashboard-header-banner relative mt-0 mb-10">
        <div class="card-container">
            
            <div class="text-lg font-bold">{{ __('Account') }}</div>
            <div class="side-cta">
                <img src="{{ gs('assets/image/emoji/Yellow-1/Nerdy.png') }}" alt="">
            </div>
        </div>
    </div>
    <div class="subtitle-border">{{ __('Basic') }}</div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2">
        <!-- Perfil -->
        <a class="settings-card" href="{{ route('user-mix-account-profile') }}">
            <div class="settings-card-avatar bg-highlight shadow-bg shadow-bg-l">
                <span>
                    <svg class="svg-icon orion-svg-icon w-4 h-4"><use xlink:href="{{ url('assets/image/svg/orion-svg-sprite.svg#avatar-1') }}"></use></svg>
                </span>
            </div>
            <div class="settings-card-info">
                <h4>{{ __('Perfil') }}</h4>
                <p>{{ __('Edite informações básicas sobre você.') }}</p>
            </div>
        </a>
        
        <!-- Métodos de Pagamento -->
        <a href="{{ route('user-mix-account-method') }}" class="settings-card">
            <div class="settings-card-avatar bg-lightgreen shadow-bg shadow-bg-l">
                <span>
                    <svg class="svg-icon orion-svg-icon w-4 h-4"><use xlink:href="{{ url('assets/image/svg/orion-svg-sprite.svg#credit-card-1') }}"></use></svg>
                </span>
            </div>
            <div class="settings-card-info">
                <h4>{{ __('Métodos de pagamento') }}</h4>
                <p>{{ __('Configure sua forma de pagamento.') }}</p>
            </div>
        </a>
        
        <!-- Meu Plano -->
        <a href="{{ route('user-mix-account-plan-history') }}" class="settings-card">
            <div class="settings-card-avatar bg-sandy-cream shadow-bg shadow-bg-l">
                <span>
                    <svg class="svg-icon orion-svg-icon w-4 h-4 stroke-current text-black"><use xlink:href="{{ url('assets/image/svg/orion-svg-sprite.svg#open-box-1') }}"></use></svg>
                </span>
            </div>
            <div class="settings-card-info">
                <h4>{{ __('Meu plano') }}</h4>
                <p>{{ __('Verifique o histórico de seus planos.') }}</p>
            </div>
        </a>
        
        <div class="subtitle-border mt-5 col-span-1 sm:col-span-2">{{ __('Segurança') }}</div>
        
        <!-- Atividades -->
        <a href="{{ route('user-mix-account-activities') }}" class="settings-card">
            <div class="settings-card-avatar bg-fade-mint shadow-bg shadow-bg-l">
                <span>
                    <svg class="svg-icon orion-svg-icon w-4 h-4 stroke-current text-black"><use xlink:href="{{ url('assets/image/svg/orion-svg-sprite.svg#news-website-1') }}"></use></svg>
                </span>
            </div>
            <div class="settings-card-info">
                <h4>{{ __('Atividades de autenticação') }}</h4>
                <p>{{ __('Acompanhe as atividades em sua conta.') }}</p>
            </div>
        </a>
        
        <!-- 2FA -->
        <a href="{{ route('user-mix-account-security') }}" class="settings-card">
            <div class="settings-card-avatar bg-blue-100 shadow-bg shadow-bg-l text-blue-500">
                <span>
                    <svg class="svg-icon orion-svg-icon w-4 h-4 stroke-current"><use xlink:href="{{ url('assets/image/svg/orion-svg-sprite.svg#shield-1') }}"></use></svg>
                </span>
            </div>
            <div class="settings-card-info">
                <h4>{{ __('Autenticação em 2 fatores') }}</h4>
                <p>{{ __('Proteja sua conta com 2FA.') }}</p>
            </div>
        </a>
        
        <!-- Senha -->
        <a href="{{ route('user-mix-account-password') }}" class="settings-card">
            <div class="settings-card-avatar bg-green-light shadow-bg shadow-bg-l">
                <span>
                    <svg class="svg-icon orion-svg-icon w-4 h-4"><use xlink:href="{{ url('assets/image/svg/orion-svg-sprite.svg#locked-1') }}"></use></svg>
                </span>
            </div>
            <div class="settings-card-info">
                <h4>{{ __('Senha') }}</h4>
                <p>{{ __('Altere a senha da sua conta') }}</p>
            </div>
        </a>
        
        <!-- Sair -->
        <a class="settings-card" href="{{ url('auth/logout') }}" app-sandy-prevent="" data-no-instant="true">
            <div class="settings-card-avatar bg-orange-dark shadow-bg shadow-bg-l">
                <span>
                    <svg class="svg-icon orion-svg-icon w-4 h-4"><use xlink:href="{{ url('assets/image/svg/orion-svg-sprite.svg#lock-opened-1') }}"></use></svg>
                </span>
            </div>
            <div class="settings-card-info">
                <h4>{{ __('Sair') }}</h4>
                <p>{{ __('Destrua a sessão de autenticação atual.') }}</p>
            </div>
        </a>
        
        <div class="subtitle-border mt-5 col-span-1 sm:col-span-2 text-red-500">{{ __('Zona de Perigo') }}</div>
        
        <!-- Excluir Conta -->
        <div class="settings-card cursor-pointer delete-account-modal-open">
            <div class="settings-card-avatar bg-red-500 shadow-bg shadow-bg-l text-white">
                <span class="text-white">
                    <svg class="svg-icon orion-svg-icon w-4 h-4 stroke-current text-white"><use xlink:href="{{ url('assets/image/svg/orion-svg-sprite.svg#close-1') }}"></use></svg>
                </span>
            </div>
            <div class="settings-card-info w-full">
                <h4 class="text-red-500">{{ __('Excluir Conta') }}</h4>
                <p>{{ __('Exclua permanentemente sua conta e todos os dados.') }}</p>
            </div>
        </div>
    </div>
</div>

<form id="delete-account-form" action="{{ route('user-mix-account-delete') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection
