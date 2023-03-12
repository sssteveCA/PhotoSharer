<div class="{{$attributes['classes']}}">
    <div class="bg-dark bg-gradient py-3 text-center text-white text-uppercase fs-bold h6">{{$title}}</div>
    <div class="item-data">
        @if(!$empty)
            @foreach($viewData as $item)
            <div class="my-2">
                <div class="mb-1">{!! $item !!}</div>
                <div class="d-flex justify-content-end">
                    @if(in_array($listname,['comments','photos','reported_comments','reported_photos']))
                    <!-- <a href="#" class="mx-1">
                        {{-- $data[$loop->index]['approved'] == 1 ? "Non approvare" : "Approva " --}}
                    </a> -->
                    @endif
                    <a href="#" class="mx-1">Elimina</a>
                </div>
            </div>
            @endforeach
        @else
        <x-alert.message classes="alert alert-light" :message="$message" />
        @endif
    </div>
</div>