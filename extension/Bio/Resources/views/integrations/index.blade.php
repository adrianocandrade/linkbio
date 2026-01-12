@if (user('integrations.tidio.enable', $bio->id))
    <script src="https://code.tidio.co/{{ user('integrations.tidio.api', $bio->id) }}.js" async></script>
@endif