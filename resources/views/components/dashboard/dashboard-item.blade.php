<div class="{{$attributes['classes']}}">
    <div class="bg-dark bg-gradient py-3 text-center text-white text-uppercase fs-bold h6">{{$title}}</div>
    <div class="item-data">
        @if(!$empty)
            @if($listname != "tags")
                @foreach($viewData as $item)
                    <div class="my-2">
                        <div class="mb-1">{!! $item !!}</div>
                        <div class="d-flex justify-content-end">
                            <a href="#" class="mx-1">Elimina</a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="my-2">
                    @foreach($viewData as $item)
                        {!! $item !!}
                        @if(!$loop->last)
                        ,
                        @endif
                    @endforeach
                </div>
            @endif
        @else
        <x-alert.message classes="alert alert-light" :message="$message" />
        @endif
    </div>
</div>