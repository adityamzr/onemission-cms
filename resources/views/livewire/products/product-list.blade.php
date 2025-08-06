<div>
    <main class="grow" role="content">
       <!-- Toolbar -->
       <div class="pb-5">
        <!-- Container -->
        <div class="container-fixed">
            <div class="flex items-center justify-between flex-wrap gap-3 mb-5">
                <div class="flex items-center flex-wrap gap-1 lg:gap-5">
                    <h1 class="font-medium text-lg text-gray-900">
                        {{ $title }}
                    </h1>
                </div>
                <div class="flex items-center flex-wrap gap-1.5 lg:gap-3.5">
                    {{-- <a class="btn btn-sm btn-light" href="html/demo6/account/home/get-started.html">
                        <i class="ki-filled ki-exit-down !text-base">
                        </i>
                        Export
                    </a> --}}
                    <a href="{{ route('products.create') }}" type="button" wire:navigate  class="btn btn-dark">
                        <i class="ki-filled ki-plus-squared">
                        </i>
                        Add Product
                    </a>
                </div>
            </div>
            <!-- begin: toolbar -->
            <div class="flex flex-wrap items-center gap-5 justify-between">
            <h3 class="text-sm text-mono font-medium">
            {{ $products->firstItem() }} - {{ $products->lastItem() }} over {{ $products->total() }} results
            </h3>
            <div class="flex items-center justify-end space-x-4 grow">
            <div class="input input-sm max-w-64">
                <i class="ki-filled ki-magnifier">
                </i>
                <input placeholder="Search {{ $title }}" type="text" wire:model.live.debounce.500ms="search"/>
            </div>
            <div class="menu menu-default" data-menu="true">
                <div class="menu-item" data-menu-item-offset="0, 0" data-menu-item-placement="bottom-end" data-menu-item-toggle="dropdown" data-menu-item-trigger="hover">
                    <button class="menu-toggle btn btn-light btn-sm flex-nowrap">
                    <span class="flex items-center me-1">
                    <i class="ki-filled ki-calendar !text-md">
                    </i>
                    </span>
                    <span class="hidden md:inline text-nowrap">
                    September, 2024
                    </span>
                    <span class="inline md:hidden text-nowrap">
                    Sep, 2024
                    </span>
                    <span class="flex items-center lg:ms-4">
                    <i class="ki-filled ki-down !text-xs">
                    </i>
                    </span>
                    </button>
                    <div class="menu-dropdown w-48 py-2 scrollable-y max-h-[250px]">
                    <div class="menu-item">
                    <a class="menu-link" href="#">
                    <span class="menu-title">
                        January, 2024
                    </span>
                    </a>
                    </div>
                    <div class="menu-item">
                    <a class="menu-link" href="#">
                    <span class="menu-title">
                        February, 2024
                    </span>
                    </a>
                    </div>
                    <div class="menu-item active">
                    <a class="menu-link" href="#">
                    <span class="menu-title">
                        March, 2024
                    </span>
                    </a>
                    </div>
                    </div>
                </div>
                </div>
            <div class="btn-tabs" data-tabs="true">
                <a class="btn btn-icon active" data-tab-toggle="#projects_cards" href="#">
                    <i class="ki-filled ki-category">
                    </i>
                    </a>
                    <a class="btn btn-icon" data-tab-toggle="#projects_list" href="#">
                    <i class="ki-filled ki-row-horizontal">
                    </i>
                </a>
            </div>
            </div>
            </div>
             <!-- end: toolbar -->
        </div>
        <!-- End of Container -->
       </div>
       <!-- End of Toolbar -->
       <!-- Container -->
       <div class="container-fixed">
        <!-- begin: projects -->
        <div class="flex flex-col items-stretch gap-5">
         
         <!-- begin: cards -->
         <div id="projects_cards">
          <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-5 lg:gap-7.5">
            {{-- begin: items --}}
            @foreach ($products as $item)
            <div class="card p-2.5 justify-between gap-5">
             <div class="mb-2.5">
                 <div class="flex items-center justify-center relative w-full h-[180px] mb-4 rounded-lg bg-gray-200 border border-gray-300 shadow-none">
                     <img src="{{ asset('storage/'.$item->image) }}" class="h-[180px] shrink-0 cursor-pointer" alt="">
                 </div>
                 <a href="" class="hover:text-primary text-sm font-bold text-mono px-1 leading-5.5 block">{{ $item->name }}</a>
                 <span class="badge badge-warning badge-sm rounded-full gap-1 my-2">
                     <i class="ki-solid ki-star text-white -mt-0.5"></i>
                     5.0
                 </span>
                 <div class="flex flex-wrap items-center gap-3">
                     <div class="flex items-center flex-wrap gap-2 lg:gap-4">
                         <span class="text-xs text-gray-700">
                          SKU: <span class="text-xs font-bold">SH-001-Black</span>
                         </span>
                         <span class="text-xs text-gray-700">
                          Stock: <span class="text-xs font-bold">128</span>
                         </span>
                     </div>
                </div>
             </div>
             <div class="flex items-center flex-wrap justify-between pb-1">
                 <span class="badge badge-success badge-outline">
                 Active
                 </span>
                 <div class="flex items-center flex-wrap gap-1.5">
                    @if($item->originalPrice != null)
                     <span class="text-xs font-normal text-secondary-foreground line-through pt-[1px]">{{ formatRupiah($item->originalPrice) }}</span>
                    @endif
                     <span class="text-sm font-medium text-mono">{{ formatRupiah($item->price) }}</span>
                     <div class="dropdown" data-dropdown="true" data-dropdown-placement="bottom-end" data-dropdown-placement-rtl="bottom-start" data-dropdown-trigger="click">
                         <button class="dropdown-toggle btn btn-sm btn-icon btn-light">
                             <i class="ki-filled ki-dots-vertical">
                             </i>
                         </button>
                         <div class="dropdown-content menu-default w-full max-w-36">
                             <div class="menu-item" data-dropdown-dismiss="true">
                                 <a href="/products/{{ $item->id }}/edit" wire:navigate class="menu-link">
                                     <span class="menu-icon">
                                         <i class="ki-filled ki-pencil">
                                         </i>
                                     </span>
                                     <span class="menu-title">
                                     Edit
                                     </span>
                                 </a>
                             </div>
                             <div class="menu-item" data-dropdown-dismiss="true">
                                 <button type="button" wire:click="destroy('{{ $item->id }}')" class="menu-link">
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
           <a class="btn btn-link" href="#">
            Show more products
           </a>
          </div>
         </div>
         <!-- end: cards -->
         <!-- begin: list -->
         
        <div class="hidden" id="projects_list">
            <div class="flex flex-col gap-5">
                @foreach ($products as $item)
                <div class="card p-2 pr-5">
                <div class="flex items-center flex-wrap justify-end md:justify-between gap-5">
                    <div class="flex items-center gap-3.5">
                    <div class="border border-gray-300 bg-gray-200 rounded-xl flex items-center justify-center bg-accent/50 h-[70px] w-[90px] shadow-none">
                    <img alt="" class="h-[70px] cursor-pointer" src="{{ asset('storage/'.$item->image) }}"/>
                    </div>
                    <div class="flex flex-col gap-2">
                    <a class="text-sm font-media/brand font-bold text-gray-900 hover:text-primary-active mb-px" href="#">
                    {{ $item->name }}
                    </a>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="badge badge-warning badge-sm rounded-full gap-1">
                            <i class="ki-solid ki-star text-white -mt-0.5"></i>
                            5.0
                        </span>
                        <div class="flex items-center flex-wrap gap-2 lg:gap-4">
                            <span class="text-xs text-gray-700">
                                SKU: <span class="text-xs font-bold">SH-001-Black</span>
                            </span>
                            <span class="text-xs text-gray-700">
                                Category: <span class="text-xs font-bold">{{ $item->category->name }}</span>
                            </span>
                            <span class="text-xs text-gray-700">
                                Stock: <span class="text-xs font-bold">128</span>
                            </span>
                        </div>
                    </div>
                    </div>
                    </div>
                    <div class="flex items-center flex-wrap gap-4">
                        <div class="flex items-center flex-wrap gap-2">
                            @if ($item->originalPrice != null)
                            <span class="text-xs font-normal text-secondary-foreground line-through pt-[1px]">{{ formatRupiah($item->originalPrice) }}</span>
                            @endif
                            <span class="text-sm font-bold">{{ formatRupiah($item->price) }}</span>
                            <span class="badge badge-success badge-outline">
                            Active
                            </span>
                        </div>
                    <div class="flex items-center gap-5 lg:gap-14">
                    <div class="menu" data-menu="true">
                    <div class="menu-item" data-menu-item-offset="0, 10px" data-menu-item-placement="bottom-end" data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:click">
                        <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                        <i class="ki-filled ki-dots-vertical">
                        </i>
                        </button>
                        <div class="menu-dropdown menu-default w-full max-w-36" data-menu-dismiss="true">
                        <div class="menu-item">
                        <a href="/products/{{ $item->id }}/edit" wire:navigate class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-filled ki-pencil">
                            </i>
                        </span>
                        <span class="menu-title">
                            Edit
                        </span>
                        </a>
                        </div>
                        <div class="menu-item">
                        <button type="button" wire:click="destroy('{{ $item->id }}')" class="menu-link">
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
                </div>
                </div>
                @endforeach
            </div>
            <div class="flex grow justify-center pt-5 lg:pt-7.5">
            <a class="btn btn-link" href="#">
            Show more projects
            </a>
            </div>
        </div>
         
         <!-- end: list -->
        </div>
        <!-- end: projects -->
       </div>
       <!-- End of Container -->
      </main>
</div>
