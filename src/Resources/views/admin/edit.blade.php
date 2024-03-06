@php
    $currentLocale = core()->getRequestedLocale();

    $selectedOptionIds = old('inventory_sources') ?? $blog->channels->pluck('id')->toArray();
@endphp
<x-admin::layouts>
    <!--Page title -->
    <x-slot:title>
        @lang('blog::blog.edit-blog')
    </x-slot>

    <!--Create Page Form -->
    <x-admin::form
        :action="route('admin.blog.update', $blog->id)"
        method="PUT"
        enctype="multipart/form-data"
    >

        {!! view_render_event('bagisto.admin.blog.create.create_form_controls.before') !!}

        <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
            <p class="text-xl text-gray-800 dark:text-white font-bold">
                @lang('blog::blog.edit-blog')
            </p>


            <div class="flex gap-x-2.5 items-center">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.blog.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white"
                >
                    @lang('admin::app.account.edit.back-btn')
                </a>

                <!-- Preview Button -->
                @if ($blog->translate($currentLocale->code))
                    <a
                        href="{{ route('shop.blog.category.show', $blog->translate($currentLocale->code)['slug']) }}"
                        class="secondary-button"
                        target="_blank"
                    >
                        @lang('blog::blog.preview')
                    </a>
                @endif

                <!--Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('blog::blog.save-blog')
                </button>
            </div>
        </div>

        <div class="flex  gap-4 justify-between items-center mt-7 max-md:flex-wrap">
            <div class="flex gap-x-1 items-center">
                <!-- Locale Switcher -->
                <x-admin::dropdown :class="core()->getAllLocales()->count() <= 1 ? 'hidden' : ''">
                    <!-- Dropdown Toggler -->
                    <x-slot:toggle>
                        <button
                            type="button"
                            class="transparent-button px-1 py-1.5 hover:bg-gray-200 dark:hover:bg-gray-800 focus:bg-gray-200 dark:focus:bg-gray-800 dark:text-white"
                        >
                            <span class="icon-language text-2xl"></span>

                            {{ $currentLocale->name }}

                            <input type="hidden" name="locale" value="{{ $currentLocale->code }}"/>

                            <span class="icon-sort-down text-2xl"></span>
                        </button>
                    </x-slot>

                    <!-- Dropdown Content -->
                    <x-slot:content class="!p-0">
                        @foreach (core()->getAllLocales() as $locale)
                            <a
                                href="?{{ Arr::query(['locale' => $locale->code]) }}"
                                class="flex gap-2.5 px-5 py-2 text-base  cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-950 dark:text-white {{ $locale->code == $currentLocale->code ? 'bg-gray-100 dark:bg-gray-950' : ''}}"
                            >
                                {{ $locale->name }}
                            </a>
                        @endforeach
                    </x-slot>
                </x-admin::dropdown>
            </div>
        </div>

        <!-- body content -->
        <div class="flex gap-2.5 mt-3.5 max-xl:flex-wrap">
            <!-- Left sub-component -->
            <div class="flex flex-col gap-2 flex-1 max-xl:flex-auto">

                {!! view_render_event('bagisto.admin.blog.create.card.description.before') !!}

                <!--Content -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                    <p class="text-base text-gray-800 dark:text-white font-semibold mb-4">
                        @lang('blog::blog.details')
                    </p>

                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::blog.content')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                        type="textarea"
                        id="content"
                        name="{{ $currentLocale->code }}[content]"
                        rules="required"
                        :value="old($currentLocale->code)['content'] ?? ($blog->translate($currentLocale->code)['content'] ?? '')"
                        :label="trans('blog::blog.content')"
                        :placeholder="trans('blog::blog.content')"
                        :tinymce="true"
                        :prompt="core()->getConfigData('general.magic_ai.content_generation.cms_page_content_prompt')"
                        />

                        <x-admin::form.control-group.error control-name="content" />
                    </x-admin::form.control-group>
                </div>

                {!! view_render_event('bagisto.admin.blog.create.card.description.after') !!}

                {!! view_render_event('bagisto.admin.blog.create.card.seo.before') !!}

                <!-- SEO Input Fields -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                    <p class="text-base text-gray-800 dark:text-white font-semibold mb-4">
                        @lang('blog::blog.seo')
                    </p>

                    <!-- SEO Title & Description Blade Componnet -->
                    <x-admin::seo slug="blog"/>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('blog::blog.meta-title')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            id="meta_title"
                            name="{{$currentLocale->code}}[meta_title]"
                            :value="old($currentLocale->code)['meta_title'] ?? ($blog->translate($currentLocale->code)['meta_title'] ?? '') "
                            :label="trans('blog::blog.meta-title')"
                            :placeholder="trans('blog::blog.meta-title')"
                        />

                        <x-admin::form.control-group.error control-name="meta_title" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::blog.slug')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            id="slug"
                            rules="required"
                            name="{{$currentLocale->code}}[slug]"
                            :value="old($currentLocale->code)['slug'] ?? ($blog->translate($currentLocale->code)['slug'] ?? '') "
                            :label="trans('blog::blog.slug')"
                            :placeholder="trans('blog::blog.slug')"
                        />

                        <x-admin::form.control-group.error control-name="slug" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('blog::blog.meta-keywords')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            id="meta_keywords"
                            name="{{$currentLocale->code}}[meta_keywords]"
                            :value="old($currentLocale->code)['meta_keywords'] ?? ($blog->translate($currentLocale->code)['meta_keywords'] ?? '') "
                            :label="trans('blog::blog.meta-keywords')"
                            :placeholder="trans('blog::blog.meta-keywords')"
                        />

                        <x-admin::form.control-group.error control-name="meta_keywords" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('blog::blog.meta-description')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            id="meta_description"
                            name="{{$currentLocale->code}}[meta_description]"
                            :value="old($currentLocale->code)['meta_description'] ?? ($blog->translate($currentLocale->code)['meta_description'] ?? '') "
                            :label="trans('blog::blog.meta-description')"
                            :placeholder="trans('blog::blog.meta-description')"
                        />

                        <x-admin::form.control-group.error control-name="meta_description" />
                    </x-admin::form.control-group>
                </div>

                {!! view_render_event('bagisto.admin.blog.create.card.seo.after') !!}
            </div>

            <!-- Right sub-component -->
            <div class="flex flex-col gap-2 w-[360px] max-w-full max-sm:w-full">
                <!-- General -->

                {!! view_render_event('bagisto.admin.blog.create.card.accordion.general.before') !!}

                <x-admin::accordion>
                    <x-slot:header>
                        <p class="p-2.5 text-gray-800 dark:text-white text-base font-semibold">
                            @lang('blog::blog.general')
                        </p>
                    </x-slot>

                    <x-slot:content>
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::blog.title')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                id="{{ $currentLocale->code }}[title]"
                                name="{{ $currentLocale->code }}[title]"
                                rules="required"
                                value="{{ old($currentLocale->code)['title'] ?? ($blog->translate($currentLocale->code)['title'] ?? '') }}"
                                :label="trans('blog::blog.title')"
                                :placeholder="trans('blog::blog.title')"
                            />

                            <x-admin::form.control-group.error control-name="{{ $currentLocale->code }}[title]" />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::blog.blog-category')
                            </x-admin::form.control-group.label>
                            @php $selectedOption = old('blog_category_id') ?: $blog->blog_category_id @endphp
                            <x-admin::form.control-group.control
                                type="select"
                                name="blog_category_id"
                                rules="required"
                                :value="$selectedOption"
                                :label="trans('blog::blog.blog-category')"
                            >
                                @foreach ($categories as $id => $category)
                                    <option value="{{ $id }}">
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>


                        <x-admin::form.control-group>
                                <x-admin::form.control-group.label>
                                    @lang('blog::blog.image')
                                </x-admin::form.control-group.label>

                                <x-admin::media.images
                                    name="image"
                                    :uploaded-images="$blog->image ? [['id' => 'path', 'url' => $blog->image->url]] : []"
                                />
                        </x-admin::form.control-group>

                         <!-- Status -->
                         <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                @lang('blog::blog.status')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="switch"
                                name="status"
                                value="{{ old($currentLocale->code)['status'] ?? $blog->status }}"
                                :label="trans('admin::app.marketing.promotions.catalog-rules.create.status')"
                                :checked="(boolean) $blog->status"
                            />

                            <x-admin::form.control-group.error control-name="status" />
                        </x-admin::form.control-group>

                        <!-- Select Channels -->
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::blog.channel')
                        </x-admin::form.control-group.label>

                        @foreach(core()->getAllChannels() as $channel)
                            <x-admin::form.control-group class="flex items-center gap-2.5 !mb-2 last:!mb-0 select-none">
                                <x-admin::form.control-group.control
                                type="checkbox"
                                :id="'channels_' . $channel->id"
                                name="channels[]"
                                rules="required"
                                :value="$channel->id"
                                :for="'channels_' . $channel->id"
                                :label="trans('blog::blog.channel')"
                                :checked="in_array($channel->id, $selectedOptionIds)"
                            />

                                <label
                                    class="text-xs text-gray-600 dark:text-gray-300 font-medium cursor-pointer"
                                    for="channels_{{ $channel->id }}"
                                >
                                    {{ core()->getChannelName($channel) }}
                                </label>
                            </x-admin::form.control-group>
                        @endforeach

                        <x-admin::form.control-group.error control-name="channels[]" />
                    </x-slot>
                </x-admin::accordion>

                {!! view_render_event('bagisto.admin.blog.create.card.accordion.general.after') !!}

            </div>
        </div>

        {!! view_render_event('bagisto.admin.blog.create.create_form_controls.after') !!}

    </x-admin::form>
</x-admin::layouts>
