<div class="{{$attributes['classes']}}">
    <div class="mb-5">
        <div class="detail-header">AUTORE</div>
        <div class="detail-value">{{$author}}</div>
    </div>
    <div class="mb-5">
        <div class="detail-header">NOME</div>
        <div class="detail-value">{{$name}}</div>
    </div>
    <div class="mb-5">
        <div class="detail-header">DATA DI CARICAMENTO</div>
        <div class="detail-value">{{$photo->creation_date}}</div>
    </div>
    <div class="mb-5">
        <div class="detail-header">TAG</div>
        <div class="detail-value">
            @forelse($tags_list as $tag)
                <a href="#">{{$tag}}</a>
                @if(!$loop->last)
                ,
                @endif
            @empty
            Nessun tag
            @endforelse
        </div>
    </div>
</div>