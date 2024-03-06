<!-- SEO Meta Content -->
@push('meta')
    <meta name="title" content="{{ $blog->meta_title }}" />

    <meta name="description" content="{{ $blog->meta_description }}" />

    <meta name="keywords" content="{{ $blog->meta_keywords }}" />
@endPush

<!-- Post Layout -->
<x-shop::layouts>
    <!-- Post Title -->
    <x-slot:title>
        {{ $blog->meta_title }}
    </x-slot>
    <!-- Post Content -->
    <div class="container mt-8 px-[60px] max-lg:px-8">
        <article class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
            <header class="mb-4 lg:mb-6 text-center">
                <h1 class="mb-4 text-3xl font-extrabold text-sky-950 lg:mb-6 lg:text-4xl dark:text-white"> {{ $blog->title }}</h1>
                @if($blogRaw->category)
                    <p class="text-base text-sky-950 dark:text-gray-400">{{$blogRaw->category->title}}</p>
                @endif
                <p class="text-base text-sky-950 dark:text-gray-400"><time pubdate datetime="{{$blogRaw->created_at}}" title="{{$blogRaw->created_at}}">{{$blogRaw->created_at}}</time></p>
                @if($blogRaw->image)
                    <img class="m-auto bg-cover bg-center rounded" src="{{$blogRaw->image->url}}">
                @endif
            </header>
            <p class="lead text-justify">
                {!! $blog->content !!}
            </p>
        </article>
        <nav class=" flex justify-center mx-auto">
            @if($prevBlog)
                <a class="flex items-center py-2 px-5 secondary-button"
                    href="{{route('shop.blog.show', $prevBlog)}}">
                    @lang('blog::blog.previous-post')
                </a>
            @endif
            @if($nextBlog)
            <a class="flex items-center py-2 px-5 secondary-button"
                href="{{route('shop.blog.show', $nextBlog)}}">
                @lang('blog::blog.next-post')
            </a>
            @endif
        </nav>
    </div>
</x-shop::layouts>
