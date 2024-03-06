<!-- SEO Meta Content -->
@if(isset($category))
    @push('meta')
        <meta name="title" content="{{ $category->meta_title }}" />

        <meta name="description" content="{{ $category->meta_description }}" />

        <meta name="keywords" content="{{ $category->meta_keywords }}" />
    @endPush
@endif

<!-- Post Layout -->
<x-shop::layouts>
    <!-- Post Title -->
    <x-slot:title>
        @if(isset($category))
            {{ __('blog::blog.category') }} {{$category->title}}
        @else
            {{ __('blog::blog.blog') }}
        @endif
    </x-slot>

    <!-- Post Content -->
    <div class="container mt-8 px-[60px] max-lg:px-8">
        <div class="w-full mb-8 text-2xl">
            <h1>
                @if(isset($category))
                    {{ __('blog::blog.category') }} {{$category->title}}
                @else
                    {{ __('blog::blog.blog') }}
                @endif
            </h1>
        </div>
        <div class="flex mt-5 mb-5">
            @foreach($blogs as $blog)
                <div class="lg:basis-1/4 md:basis-1/2 sm:w-full bg-gray-200 h-40 text-center rounded p-2 m-1">
                    <a href="{{route('shop.blog.show', $blog->slug)}}">
                    <h2 class="text-base font-large text-xl">{{$blog->title}}</h2>
                        <x-shop::media.images.lazy
                        class="m-auto rounded after:block after:pb-[calc(100%+9px)] bg-[#F5F5F5] group-hover:scale-105 transition-all duration-300"
                        :src="$blog->blog->image!=null ? $blog->blog->image->url : '/themes/shop/default/build/assets/medium-product-placeholder-3b1a7b7d.webp'"
                        width="291"
                        height="300"
                    />
                    </a>
                </div>
            @endforeach

        </div>
        <div class="w-full mb-2 mt-2 text-center">
            {{ $blogs->links() }}
        </div>
        <h2 class="text-base font-large text-xl">{{ __('blog::blog.blog-categories') }}</h2>
        <div class="flex mt-5 mb-2">
            @foreach ($categories as $cat)
            <a href="{{route('shop.blog.category.show', $cat->slug)}}" class="lg:w-1/6 md:w-1/2 primary-button">
                {{$cat->title}}
            </a>
            @endforeach
        </div>
    </div>
</x-shop::layouts>
