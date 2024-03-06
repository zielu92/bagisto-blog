<x-admin::layouts>
    <!--Page title -->
    <x-slot:title>
        @lang('blog::blog.add-category')
    </x-slot>

    <!--Create Page Form -->
    <x-admin::form
        :action="route('admin.blog.category.store')"
        enctype="multipart/form-data"
    >

        {!! view_render_event('bagisto.admin.blog.create.create_form_controls.before') !!}

        <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
            <p class="text-xl text-gray-800 dark:text-white font-bold">
                @lang('blog::blog.add-category')
            </p>

            <div class="flex gap-x-2.5 items-center">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.blog.category.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white"
                >
                    @lang('admin::app.account.edit.back-btn')
                </a>

                <!--Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('blog::blog.save-category')
                </button>
            </div>
        </div>

        <!-- body content -->
        <div class="flex gap-2.5 mt-3.5 max-xl:flex-wrap">
            <!-- Left sub-component -->
            <div class="flex flex-col gap-2 flex-1 max-xl:flex-auto">

                {!! view_render_event('bagisto.admin.blog.category.create.card.seo.before') !!}

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
                            name="meta_title"
                            :value="old('meta_title')"
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
                            name="slug"
                            rules="required"
                            :value="old('slug')"
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
                            name="meta_keywords"
                            :value="old('meta_keywords')"
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
                            name="meta_description"
                            :value="old('meta_description')"
                            :label="trans('blog::blog.meta-description')"
                            :placeholder="trans('blog::blog.meta-description')"
                        />

                        <x-admin::form.control-group.error control-name="meta-description" />
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
                                id="title"
                                name="title"
                                rules="required"
                                :value="old('title')"
                                :label="trans('blog::blog.title')"
                                :placeholder="trans('blog::blog.title')"
                            />

                            <x-admin::form.control-group.error control-name="title" />
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
