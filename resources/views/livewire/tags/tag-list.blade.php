<div>
    <main class="grow" role="content">
        <!-- Toolbar -->
        <div class="pb-5">
        <!-- Container -->
        <div class="container-fixed flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center flex-wrap gap-1 lg:gap-5">
            <h1 class="font-medium text-lg text-gray-900">
            {{ $title ?? 'Onemission' }}
            </h1>
            </div>
            <div class="flex items-center flex-wrap gap-1.5 lg:gap-3.5">
                {{-- <a class="btn btn-sm btn-light" href="html/demo6/account/home/get-started.html">
                    <i class="ki-filled ki-exit-down !text-base">
                    </i>
                    Export
                </a> --}}
                <button type="button" wire:click="$dispatchTo('tags.tag-form', 'openModal')" class="btn btn-dark">
                    <i class="ki-filled ki-plus-squared">
                    </i>
                    Add Tag
                </button>
            </div>
        </div>
        <!-- End of Container -->
        </div>
        <!-- End of Toolbar -->
        <!-- Container -->
        <div class="container-fixed">
            {{-- begin: table --}}
            <div class="grid">
                <div class="card card-grid min-w-full">
                    <div class="card-header py-5 flex-wrap">
                        <h3 class="card-title">
                            Data List
                        </h3>
                        <div class="input input-sm max-w-48">
                            <i class="ki-filled ki-magnifier">
                            </i>
                            <input placeholder="Search {{ $title }}" type="text" wire:model.live.debounce.500ms="search"/>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_remote_table">
                            <div class="scrollable-x-auto">
                                <table class="table table-auto table-border align-middle text-gray-700 font-medium text-sm" data-datatable-table="true">
                                    <thead>
                                        <tr>
                                            <th class="w-[100px] text-center" data-datatable-column="status">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    No
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[250px]" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Name
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[250px]" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Info
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[100px]" data-datatable-column="lastSession">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Created At
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="w-[185px]" data-datatable-column="label">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Action
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                        </tr>
                                        @foreach ($tags as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $tags->firstItem() + $key }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->info }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td class="flex items-center gap-2">
                                                <button type="button"  wire:click="$dispatchTo('tags.tag-form', 'openModal', { id: {{ $item->id }} })" class="btn btn-warning btn-sm">
                                                    <i class="ki-filled ki-pencil">
                                                    </i>
                                                    Edit
                                                </button>
                                                <button type="button" wire:confirm="Are you sure you want to delete this data?" wire:click="$dispatchTo('tags.tag-form', 'destroy', { id: {{ $item->id }} })" class="btn btn-danger btn-sm">
                                                    <i class="ki-filled ki-trash">
                                                    </i>
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </thead>
                                </table>
                            </div>
                            <div class="card-footer justify-between flex-col md:flex-row gap-3 text-gray-600 text-2sm font-medium">
                                <div class="flex items-center gap-2">
                                    Show
                                    <select class="select select-sm w-16" wire:model.change="perpage">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                    per page
                                </div>
                                <div class="flex items-center gap-4">
                                    <span data-datatable-info="true">
                                    </span>
                                    <div class="pagination" data-datatable-pagination="true">
                                    </div>
                                </div>
                                {{ $tags->links('vendor.livewire.tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end: table --}}
        </div>
        <!-- End of Container -->
        @livewire('tags.tag-form')
    </main>
</div>
