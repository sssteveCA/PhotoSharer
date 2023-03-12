<div class="comments-list-container container">
    @foreach($comments as $comment)
    <div class="row align-items-center my-3">
        <div class="col-11">
            <div class="author-name">{{$comment['author_name']}}</div>
            <div class="comment-text">{{$comment['comment_text']}}</div>
        </div>
        <div class="col-1">
            <i class="bi bi-three-dots"></i>
        </div>
    </div>
    @endforeach
</div>