<div class="blog_item">
    <div class="card blog_item_card">
        <a href="{{route('web.post',$post->slug)}}">
            <img src="{{asset('storage/uploads/blog/'.$post->feature_image)}}" class="card-img-top"
                 alt="{{$post->title}}">
        </a>
        <div class="blog_category">
            {{\Illuminate\Support\Str::upper(\Illuminate\Support\Str::lower($post->category->title))}}
        </div>

        <div class="card-body p-4">
            <h4 class="blog_title"><a href="{{route('web.post',$post->slug)}}">{{$post->title}}</a> </h4>
            <p class="card-text mb-5">
                {{$post->description}}
            </p>
            <a style="color: #ff5700; font-weight: bold" href="{{route('web.post',$post->slug)}}">READ MORE...</a>
        </div>
        <div class="card-footer blog_card_footer">
                           <span> {{$post->author->first_name}}
                               {{$post->author->last_name}}</span>

            <span>

                            {{\Carbon\Carbon::parse($post->created_at)->format("M d, Y")}}
                            </span>
        </div>
    </div>
</div>
