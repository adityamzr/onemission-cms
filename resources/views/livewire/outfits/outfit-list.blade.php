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
                <div class="flex items-center gap-1 text-sm">
                    <a class="text-secondary-foreground hover:text-gray-900" href="{{ route('overview') }}">Home</a>
                    <span class="text-secondary-foreground text-sm"> / </span>
                    <span class="text-secondary-foreground hover:text-gray-900">{{ $title }}</span>
                </div>
            </div>
            <div class="flex items-center flex-wrap gap-1.5 lg:gap-3.5">
                {{-- <a class="btn btn-sm btn-light" href="html/demo6/account/home/get-started.html">
                    <i class="ki-filled ki-exit-down !text-base">
                    </i>
                    Export
                </a> --}}
                <a href="{{ route('outfits.create') }}" class="btn btn-dark">
                    <i class="ki-filled ki-plus-squared">
                    </i>
                    Add Outfit
                </a>
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
                                            <th class="min-w-[100px]" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Thumbnail
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[200px]" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Model Name
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[100px]" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Model Height
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[100px]" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Model Size
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[100px]" data-datatable-column="lastSession">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Show/Hide
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
                                        @foreach ($outfits as $key => $item)
                                        {{-- @dd($item) --}}
                                        <tr>
                                            <td class="text-center">{{ $outfits->firstItem() + $key }}</td>
                                            <td class="flex items-center justify-center">
                                                <div class="flex items-center justify-center relative w-fit h-[120px] mb-4 rounded-lg bg-white shadow-none">
                                                    <img src="{{ asset('storage/'.$item->images[0]->url) }}" class="h-[120px] shrink-0 cursor-pointer" alt="">
                                                </div>
                                            </td>
                                            <td>{{ $item->model_name }}</td>
                                            <td>{{ $item->model_height }}</td>
                                            <td>{{ $item->model_size }}</td>
                                            <td>
                                                <div class="flex items-center gap-2.5">
                                                    <div class="switch switch-sm">
                                                        <label class="switch-label" for="status">{{ $item->is_shown ? 'Shown' : 'Hidden' }}</label>
                                                        <input wire:click="updateStatus({{ $item->id }})" type="checkbox" @if ($item->is_shown) checked @endif />
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center space-y-2">
                                                <a href="{{ route('outfits.edit', [$item->id]) }}" class="btn btn-warning btn-sm">
                                                    <i class="ki-filled ki-pencil">
                                                    </i>
                                                    Edit
                                                </a>
                                                <button wire:click="delete('{{ $item->id }}')" wire:confirm="Are you sure you want to delete this data?" type="button" class="btn btn-danger btn-sm">
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
                                {{ $outfits->links('vendor.livewire.tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end: table --}}
        </div>
        <!-- End of Container -->
    </main>
</div>