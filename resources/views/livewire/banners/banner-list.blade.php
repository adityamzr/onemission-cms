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
                <button type="button" wire:click="$dispatchTo('banners.banner-form', 'openModal')" class="btn btn-dark">
                    <i class="ki-filled ki-plus-squared">
                    </i>
                    Add Banner
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
                <!-- begin: cards -->
                <div id="projects_cards">
                    @if ($banners->isEmpty())
                        <h3 class="text-lg text-center">Empty Data</h3>
                    @endif
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 py-10">
                        {{-- begin: items --}}
                        @foreach ($banners as $item)
                        <div class="card p-2.5 justify-between gap-4">
                            <div class="gap-2.5 flex flex-col">
                                <div class="flex items-center justify-center relative w-full h-[180px] rounded-lg bg-gray-200 border border-gray-300 shadow-none">
                                    <img src="{{ asset('storage/'.$item->url) }}" class="h-[180px] shrink-0 cursor-pointer" alt="">
                                </div>
                                <span class="text-secondary-foreground text-sm"> {{ basename($item->url) }}</span>
                            </div>
                            <div class="flex items-center flex-wrap justify-between pb-1">
                                <div class="flex items-center flex-wrap gap-1.5">
                                    {{-- status --}}
                                    @if ($item->is_active)
                                    <button wire:click="toggleActive({{ $item->id }})" wire:confirm="Are you sure you want to deactivate this data?" class="badge badge-success badge-outline cursor-pointer">
                                    Active
                                    </button>
                                    @else
                                    <button wire:click="toggleActive({{ $item->id }})" wire:confirm="Are you sure you want to activate this data?" class="badge badge-danger badge-outline cursor-pointer">
                                    Inactive
                                    </button>
                                    @endif
    
                                    @if ($item->is_primary)
                                    <span class="badge badge-primary badge-outline">
                                    Primary
                                    </span>
                                    @else
                                    <button wire:click="togglePrimary({{ $item->id }})" wire:confirm="Are you sure you want to set this banner as primary?" class="badge badge-light badge-outline cursor-pointer">
                                    Non Primary
                                    </button>
                                    @endif
                                </div>
                                <div class="flex items-center flex-wrap gap-1.5">
                                    <div class="dropdown" data-dropdown="true" data-dropdown-placement="bottom-end" data-dropdown-placement-rtl="bottom-start" data-dropdown-trigger="click">
                                        <button class="dropdown-toggle btn btn-sm btn-icon btn-light">
                                            <i class="ki-filled ki-dots-vertical">
                                            </i>
                                        </button>
                                        <div class="dropdown-content menu-default w-full max-w-36">
                                            <div class="menu-item" data-dropdown-dismiss="true">
                                                <button wire:click="$dispatchTo('banners.banner-form', 'openModal', { id: {{ $item->id }} })" class="menu-link">
                                                    <span class="menu-icon">
                                                        <i class="ki-filled ki-pencil">
                                                        </i>
                                                    </span>
                                                    <span class="menu-title">
                                                    Edit
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="menu-item" data-dropdown-dismiss="true">
                                                <button type="button" wire:confirm="Are you sure you want to delete this data?" wire:click="destroy('{{ $item->id }}')" class="menu-link">
                                                    <span class="menu-icon">
                                                        <i class="ki-filled ki-trash">
                                                        </i>
                                                    </span>
                                                    <span class="menu-title">
                                                    Delete
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    {{-- end: items --}}
                    </div>
                    <div class="flex grow justify-center pt-5 lg:pt-7.5">
                    {{ $banners->links('vendor.livewire.tailwind') }}
                    </div>
                </div>
                <!-- end: cards -->
            </div>
            {{-- end: table --}}
        </div>
        <!-- End of Container -->
        @livewire('banners.banner-form')
    </main>
</div>