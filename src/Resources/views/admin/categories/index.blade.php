<x-admin::layouts>

    <!-- Title of the page -->
    <x-slot:title>
        @lang('blog::blog.category')
    </x-slot>

    <!-- Page Content -->
    <div class="flex justify-between items-center">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('blog::blog.category')
        </p>

        <div class="flex gap-x-2.5 items-center">
            <!-- Dropdown -->
            <x-admin::dropdown position="bottom-right">
                <x-slot:toggle>
                    <span class="flex icon-setting p-1.5 rounded-md text-2xl cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800"></span>
                </x-slot>

                <x-slot:content class="w-[174px] max-w-full !p-2 border dark:border-gray-800 rounded z-10 bg-white dark:bg-gray-900 shadow-[0px_8px_10px_0px_rgba(0,_0,_0,_0.2)]">
                    <div class="grid gap-0.5">
                        <!-- Current Channel -->
                        <div class="p-1.5 items-center cursor-pointer transition-all hover:bg-gray-100 dark:hover:bg-gray-950 hover:rounded-md">
                            <p class="text-gray-600 dark:text-gray-300  font-semibold leading-6">
                                Channel - {{ core()->getCurrentChannel()->name }}
                            </p>
                        </div>

                        <!-- Current Locale -->
                        <div class="p-1.5 items-center cursor-pointer transition-all hover:bg-gray-100 dark:hover:bg-gray-950 hover:rounded-md">
                            <p class="text-gray-600 dark:text-gray-300 font-semibold leading-6">
                                Language - {{ core()->getCurrentLocale()->name }}
                            </p>
                        </div>
                    </div>
                </x-slot>
            </x-admin::dropdown>

            <!-- Export Modal -->
            <x-admin::datagrid.export src="{{ route('admin.blog.category.index') }}" />

            <!-- Create New Pages Button -->
            @if (bouncer()->hasPermission('blog.category.create'))
                <a
                    href="{{ route('admin.blog.category.create') }}"
                    class="primary-button"
                >
                    @lang('blog::blog.add-category')
                </a>
            @endif
        </div>
    </div>

    {!! view_render_event('bagisto.admin.blog.list.before') !!}

    <x-admin::datagrid src="{{ route('admin.blog.category.index') }}" />

    {!! view_render_event('bagisto.admin.blog.list.after') !!}


</x-admin::layouts>
