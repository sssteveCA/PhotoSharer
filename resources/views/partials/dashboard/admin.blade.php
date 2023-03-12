<div class="dashboard-admin container-fluid">
    <div class="row py-3">
        <h1 class="text-center">Pannello amministrazione</h1>
    </div>
    <div class="row gy-2 gx-0 gx-md-2">
        <x-components.dashboard.dashboard-item classes="col-12 col-md-6" :data="$users_subscribed" listname="users_subscribed" title="Utenti registrati" />
        <x-components.dashboard.dashboard-item classes="col-12 col-md-6" :data="$comments" listname="comments" title="Tutti i commenti" />
    </div>
    <div class="row gy-2 gx-0 gx-md-2">
        <x-components.dashboard.dashboard-item classes="col-12 col-md-6" :data="$photos" listname="photos" title="Tutte le foto" />
        <x-components.dashboard.dashboard-item classes="col-12 col-md-6" :data="$reported_photos" listname="reported_photos" title="Foto segnalate" />
    </div>
    <div class="row gy-2 gx-0 gx-md-2">
        <x-components.dashboard.dashboard-item classes="col-12 col-md-6" :data="$reported_comments" listname="reported_comments" title="Commenti segnalati" />
        <x-components.dashboard.dashboard-item classes="col-12 col-md-6" :data="$tags" listname="tags" title="Tutti i tag" />
    </div>
</div>