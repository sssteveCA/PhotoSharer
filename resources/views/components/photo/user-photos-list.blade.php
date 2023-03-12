<table class="table table-striped table-responsive">
    <thead>
        <th scope="col">MINIATURA</th>
        <th scope="col">NOME</th>
        <th scope="col">DATA DI CARICAMENTO</th>
        <th scope="col">TAG</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </thead>
    <tbody>
        @foreach($photos as $photo)
        <tr>
            <td>
                <img src="{{ /resources_photo/$username/$photo['name'] }}" alt="{{$photo['name']}}" title="{{$photo['title']}}">
            </td>
            <td>
                <a href="{{ /photos/$photo['id'] }}">{{$photo['name']}}</a>
            </td>
            <td>
                {{$photo['creation_date']}}
            </td>
            <td>
                @forelse($photo['tags'] as $tag)
                @empty
                Nessun tag
                @endforelse
            </td>
            <td>
                <button type="button" class="btn btn-secondary">MODIFICA</button>
            </td>
            <td>
                <button type="button" class="btn btn-danger">ELIMINA</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>