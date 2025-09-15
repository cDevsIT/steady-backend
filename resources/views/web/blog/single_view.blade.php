@extends('web.layouts.master')
@push('title')
@endpush
@push('css')
    <style>


        .single_blog_hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .single_blog {
            padding: 30px;
            background: #eee;
        }

        .post_content {
            padding: 30px 0px;
        }

        .post_content_items {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .post_content_item2 {
            /*background-color: #f0f0f0;*/
            padding: 20px;
        }


        .table-of-contents {
            position: sticky;
            top: 100px;
            padding: 10px;
            background: #fff;
            color: #7c7c7c;
            border: 1px solid #eee;
        }

        .table-of-contents li {
            list-style: none;
            line-height: 30px;
        }

        .table-of-contents ul {
            margin: 0px;
            padding: 0px;
        }

        .table-of-categories {
            padding: 10px;
            background: #fff;
            border: 1px solid #eee;
            margin-top: 20px;
        }

        a.post_tag:hover {
            color: #FF5700;
        }
        .related_posts{
            background: #eee;
            padding: 30px;
        }

        .blogs_items{
            padding: 10px 0px;
        }

        @media (max-width: 900px) {
            .single_blog_hero{
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .single_item2{
                order: 1;
            }
            .single_item{
                order: 2;
            }

            .post_content_items{
                grid-template-columns:1fr;
                gap: 10px;
            }
            .table-of-contents{
                position: static;
            }
            .post_content{
                padding: 30px;
            }



        }

    </style>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endpush
@section('content')
    <div class="single_blog">
        <div class="container">
            <div class="single_blog_hero">
                <div class="single_item">
                    <h1 style="font-weight: bold">{{$post->title}}</h1>
                    <p>{{$post->description}}</p>
                    <div class="d-flex align-items-center gap-3">
                        <?php
                        $auth_slug = $post->author ? ($post->author->slug ?: "Nai") : "Nai";
                        ?>
                        <a href="{{route('web.authorPosts', $auth_slug )}}" class="post_tag"> <i
                                class="fas fa-user"></i> {{$post->author ? $post->author->first_name : ''}} {{$post->author? $post->author->last_name : ''}}
                        </a>
                        <p class="m-0">
                            <i class="fas fa-calendar"></i> {{\Carbon\Carbon::parse($post->created_at)->format("M d, Y")}}
                        </p>
                        <p class="m-0"><a class="post_tag"
                                          href="{{route('web.categoryPosts',$post->category->slug)}}"># {{$post->category? $post->category->title : ''}}</a>
                        </p>
                    </div>
                </div>
                <div class="single_item2">
                    <img src="{{asset('storage/uploads/blog/'.$post->feature_image)}}"
                         style="width: 100%; border-radius: 15px;"
                         alt="{{$post->title}}">
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="post_content">
            <div class="post_content_items">
                <div class="post_content_item">
                    @contentWithIds($post->content)
                    @if($post->tags && count($post->tags))
                        <div class="tags" style="display: flex; gap:15px;">
                            @foreach($post->tags as $tag) <a class="post_tag" href="{{route('web.tagPosts',$tag->slug)}}"><i class="fas fa-tags"></i>  {{$tag->title}} </a> @endforeach
                        </div>
                    @endif


                </div>
                <div class="post_content_item2">
                    <div class="table-of-contents">
                        <h2 style="color: black">Table of Contents</h2>
                        @toc($post->content)
                    </div>


                    <div class="table-of-categories">
                        <h2>Categories</h2>
                        <ul>
                            @foreach($categories as $category)
                                <li><a href="{{route('web.categoryPosts',$category->slug)}}">{{$category->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="related_posts">
        <div class="container">
            <h2 style="font-weight: bold">Related Posts</h2>
            @if(count($relatedPosts))
                <div class="blogs_items">
                    @foreach($relatedPosts as $post)
                        @include('web.blog.item')
                    @endforeach


                </div>
            @endif
        </div>
    </div>

    @include('web.layouts.footer')
@endsection
@push('js')
@endpush
