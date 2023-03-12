<div class="dashboard-user container-fluid">
    <div class="row">
        <h1 class="text-center">Benvenuto {{$username}}</h1>
    </div>
    <div class="row gx-3">
        <x-photo.user-photos-list :photos="$photos" :username="$username" />
    </div>
</div>