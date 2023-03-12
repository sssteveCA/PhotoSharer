<div class="{{$attributes['classes']}}">
    <div class="bg-dark bg-gradient py-3 text-center">{{$title}}</div>
    <div class="item-data">
        @if(!$empty)
            @foreach($viewData as $item)
            <div class="py-1">{{$item}}</div>
            @endforeach
        @else
        <x-alert.message classes="alert alert-light" :message="$message" />
        @endif
    </div>
</div>