@php
    $currentLocale = core()->getRequestedLocale();

    $selectedOptionIds = old('inventory_sources') ?? $category->channels->pluck('id')->toArray();
@endphp

<x-admin::layouts>
    <x-slot:title>
        @lang('blog::blog.edit-category')
    </x-slot>

    <x-admin::form
        :action="route('admin.blog.category.update', $category->id)"
        method="PUT"
        enctype="multipart/form-data"
    >

        {!! view_render_event('bagisto.admin.blog.category.edit.create_form_controls.before', ['category' => $category]) !!}

        <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
            <p class="text-xl text-gray-800 dark:text-white font-bold">
                @lang('blog::blog.edit-category')
            </p>

            <div class="flex gap-x-2.5 items-center">
                <!-- Cancel Button -->
                <a
                    href="{{ route('admin.blog.category.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white "
                >
                    @lang('admin::app.account.edit.back-btn')
                </a>

                <!-- Preview Button -->
                @if ($category->translate($currentLocale->code))
                    <a
                        href="{{ route('shop.blog.category.show', $category->translate($currentLocale->code)['slug']) }}"
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
                    @lang('blog::blog.save-category')
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

                {!! view_render_event('bagisto.admin.blog.category.edit.card.seo.before', ['category' => $category]) !!}

                <!-- SEO Input Fields -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                    <p class="text-base text-gray-800 dark:text-white font-semibold mb-4">
                        @lang('blog::blog.seo')
                    </p>

                    <!-- SEO Title & Description Blade Componnet -->
                    <x-admin::seo slug="blog/category"/>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('blog::blog.meta-title')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            id="meta_title"
                            name="{{$currentLocale->code}}[meta_title]"
                            :value="old($currentLocale->code)['meta_title'] ?? ($category->translate($currentLocale->code)['meta_title'] ?? '') "
                            :label="trans('blog::blog.meta-title')"
                            :placeholder="trans('blog::blog.meta-title')"
                        />

                        <x-admin::form.control-group.error control-name="{{$currentLocale->code}}[meta_title]" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::blog.slug')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            id="slug"
                            name="{{$currentLocale->code}}[slug]"
                            rules="required"
                            :value="old($currentLocale->code)['slug'] ?? ($category->translate($currentLocale->code)['slug'] ?? '')"
                            :label="trans('blog::blog.slug')"
                            :placeholder="trans('blog::blog.slug')"
                        />

                        <x-admin::form.control-group.error control-name="{{$currentLocale->code}}[slug]" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('blog::blog.meta-keywords')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            class="text-gray-600 dark:text-gray-300"
                            id="meta_keywords"
                            name="{{$currentLocale->code}}[meta_keywords]"
                            :value="old($currentLocale->code)['meta_keywords'] ?? ($category->translate($currentLocale->code)['meta_keywords'] ?? '')"
                            :label="trans('blog::blog.meta-keywords')"
                            :placeholder="trans('blog::blog.meta-keywords')"
                        />

                        <x-admin::form.control-group.error control-name="{{$currentLocale->code}}[meta_keywords]" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('blog::blog.meta-description')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            class="text-gray-600 dark:text-gray-300"
                            id="meta_description"
                            name="{{$currentLocale->code}}[meta_description]"
                            :value="old($currentLocale->code)['meta_description'] ?? ($category->translate($currentLocale->code)['meta_description'] ?? '')"
                            :label="trans('blog::blog.meta-description')"
                            :placeholder="trans('blog::blog.meta-description')"
                        />

                        <x-admin::form.control-group.error control-name="{{$currentLocale->code}}[meta_description]" />
                    </x-admin::form.control-group>
                </div>

                {!! view_render_event('bagisto.admin.blog.categories.edit.card.seo.after', ['category' => $category]) !!}

            </div>

            <!-- Right sub-component -->
            <div class="flex flex-col gap-2 w-[360px] max-w-full max-sm:w-full">
                <!-- General -->

                {!! view_render_event('bagisto.admin.blog.categories.edit.card.accordion.seo.before', ['category' => $category]) !!}

                <x-admin::accordion>
                    <x-slot:header>
                        <div class="flex items-center justify-between">
                            <p class="p-2.5 text-base text-gray-800 dark:text-white font-semibold">
                                @lang('blog::blog.general')
                            </p>
                        </div>
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
                                value="{{ old($currentLocale->code)['title'] ?? ($category->translate($currentLocale->code)['title'] ?? '') }}"
                                :label="trans('blog::blog.title')"
                                :placeholder="trans('blog::blog.title')"
                            />

                            <x-admin::form.control-group.error control-name="{{ $currentLocale->code }}[title]" />
                        </x-admin::form.control-group>

                        <!-- Select Channels -->
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::blog.channel')
                        </x-admin::form.control-group.label>

                        @foreach(core()->getAllChannels() as $channel)
                            <x-admin::form.control-group class="flex gap-2.5 !mb-2 last:!mb-0 select-none">
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

                {!! view_render_event('bagisto.admin.blog.categories.edit.card.accordion.seo.after', ['category' => $category]) !!}

            </div>
          </div>

        {!! view_render_event('bagisto.admin.blog.categories.edit.create_form_controls.after', ['category' => $category]) !!}

    </x-admin::form>
</x-admin::layouts>
