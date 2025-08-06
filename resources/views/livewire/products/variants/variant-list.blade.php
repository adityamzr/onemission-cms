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
            </div>
        </div>
        <!-- End of Container -->
        </div>
        <!-- End of Toolbar -->
        <!-- Container -->
        <div class="container-fixed">
            {{-- begin: table --}}
            <div class="card min-w-full">
                <div class="card-header gap-2">
                    <h3 class="card-title">
                    Spesification
                    </h3>
                    <div class="flex items-center gap-3">
                        <label class="switch switch-sm">
                            <input wire:click="publish" type="checkbox" @if($product->is_active) checked @endif/>
                        </label>
                        <span class="text-sm badge badge-outline {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $product->is_active ? 'Published' : 'Unpublished' }}
                        </span>
                        <a href="/products/{{ $product->id }}/edit" wire:navigate class="btn btn-dark">
                            <span class="menu-icon">
                                <i class="ki-filled ki-pencil">
                                </i>
                            </span>
                            <span class="menu-title">
                            Edit
                            </span>
                        </a>
                    </div>
            </div>
            <div class="card-body lg:py-7.5 py-5">
                <div class="flex flex-wrap w-full">
                    <div class="flex flex-col md:flex-row gap-5 w-full">
                        <div class="flex items-center justify-center relative w-full md:w-[40%] h-72 mb-4 rounded-lg bg-gray-200 border border-gray-300 shadow-none">
                            <img src="{{ asset('storage/'.$product->image) }}" class="h-72 border border-gray-200 float-none md:float-left" alt="">
                        </div>
                        <div class="card-table scrollable-x-auto pb-3 w-full md:w-[60%]">
                            <table class="table align-middle text-sm text-gray-500" id="general_info_table">
                                <tr>
                                    <td class="min-w-56 text-gray-600 font-normal">
                                        Name
                                    </td>
                                    <td class="min-w-48 w-full text-gray-800 font-normal">
                                        {{ $product->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="min-w-56 text-gray-600 font-normal">
                                        Category
                                    </td>
                                    <td class="min-w-48 w-full text-gray-800 font-normal">
                                        {{ $product->category->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="min-w-56 text-gray-600 font-normal">
                                        Description
                                    </td>
                                    <td class="min-w-48 w-full text-gray-800 font-normal">
                                        {{ $product->description }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="min-w-56 text-gray-600 font-normal">
                                        Price
                                    </td>
                                    <td class="min-w-48 w-full text-gray-800 font-normal">
                                        {{ formatRupiah($product->price) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="min-w-56 text-gray-600 font-normal">
                                        Original Price
                                    </td>
                                    <td class="min-w-48 w-full text-gray-800 font-normal">
                                        {{ formatRupiah($product->originalPrice) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="min-w-56 text-gray-600 font-normal">
                                        Tags
                                    </td>
                                    <td class="min-w-48 w-full text-gray-800 font-normal">
                                        <div class="flex flex-wrap gap-3 w-full">
                                            @foreach ($product->tags as $item)
                                            <span class="badge badge-outline badge-dark rounded-full">
                                                {{ $item->name }}
                                            </span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-200 my-5">
                </div>
                <div class="flex flex-col md:flex-row w-full">
                    <div class="w-full md:w-1/2">
                        <div class="card-group flex items-center justify-between py-4 gap-2.5">
                            <div class="flex items-center gap-3.5">
                                <div class="relative size-[50px] shrink-0">
                                    <svg class="w-full h-full stroke-gray-300 fill-gray-100" fill="none" height="48" viewbox="0 0 44 48" width="44" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506 
                                18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937 
                                39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z" fill="">
                                    </path>
                                    <path d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506 
                                18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937 
                                39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z" stroke="">
                                    </path>
                                    </svg>
                                    <div class="absolute leading-none start-2/4 top-2/4 -translate-y-2/4 -translate-x-2/4 rtl:translate-x-2/4">
                                    <i class="ki-filled ki-tab-tablet text-1.5xl text-gray-500">
                                    </i>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-0.5">
                                    <span class="flex items-center gap-1.5 leading-none font-medium text-sm text-gray-900">
                                    Usage
                                    </span>
                                    <span class="text-2sm text-gray-700">
                                    {{ @$proudct->usage }}
                                    </span>
                                </div>
                                </div>
                                <div class="flex items-center gap-2 lg:gap-5">
                                <div class="flex items-center gap-2.5">
                                    <div class="switch switch-sm">
                                        <label class="switch-label" for="usage">{{ $product->us_status ? 'On' : 'Off' }}</label>
                                        <input wire:click="updateStatus('us_status')" type="checkbox" @if ($product->us_status) checked @endif />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-group flex items-center justify-between py-4 gap-2.5">
                            <div class="flex items-center gap-3.5">
                            <div class="relative size-[50px] shrink-0">
                                <svg class="w-full h-full stroke-gray-300 fill-gray-100" fill="none" height="48" viewbox="0 0 44 48" width="44" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506 
                            18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937 
                            39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z" fill="">
                                </path>
                                <path d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506 
                            18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937 
                            39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z" stroke="">
                                </path>
                                </svg>
                                <div class="absolute leading-none start-2/4 top-2/4 -translate-y-2/4 -translate-x-2/4 rtl:translate-x-2/4">
                                <i class="ki-filled ki-technology-4 text-1.5xl text-gray-500">
                                </i>
                                </div>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="flex items-center gap-1.5 leading-none font-medium text-sm text-gray-900">
                                Technology
                                </span>
                                <span class="text-2sm text-gray-700">
                                {{ @$product->technology }}
                                </span>
                            </div>
                            </div>
                            <div class="flex items-center gap-2 lg:gap-5">
                            <div class="flex items-center gap-2.5">
                                <div class="switch switch-sm">
                                    <label class="switch-label" for="technology">{{ $product->tec_status ? 'On' : 'Off' }}</label>
                                    <input wire:click="updateStatus('tec_status')" type="checkbox" @if ($product->tec_status) checked @endif />
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card-group flex items-center justify-between py-4 gap-2.5">
                            <div class="flex items-center gap-3.5">
                            <div class="relative size-[50px] shrink-0">
                                <svg class="w-full h-full stroke-gray-300 fill-gray-100" fill="none" height="48" viewbox="0 0 44 48" width="44" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506 
                            18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937 
                            39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z" fill="">
                                </path>
                                <path d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506 
                            18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937 
                            39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z" stroke="">
                                </path>
                                </svg>
                                <div class="absolute leading-none start-2/4 top-2/4 -translate-y-2/4 -translate-x-2/4 rtl:translate-x-2/4">
                                <i class="ki-filled ki-rocket text-1.5xl text-gray-500">
                                </i>
                                </div>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="flex items-center gap-1.5 leading-none font-medium text-sm text-gray-900">
                                Features
                                </span>
                                <span class="text-2sm text-gray-700">
                                {{ @$product->features }}
                                </span>
                            </div>
                            </div>
                            <div class="flex items-center gap-2 lg:gap-5">
                            <div class="flex items-center gap-2.5">
                                <div class="switch switch-sm">
                                    <label class="switch-label" for="features">{{ $product->ft_status ? 'On' : 'Off' }}</label>
                                    <input wire:click="updateStatus('ft_status')" type="checkbox" @if ($product->ft_status) checked @endif />
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="card-group flex items-center justify-between py-4 gap-2.5">
                            <div class="flex items-center gap-3.5">
                                <div class="relative size-[50px] shrink-0">
                                    <svg class="w-full h-full stroke-gray-300 fill-gray-100" fill="none" height="48" viewbox="0 0 44 48" width="44" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506 
                                18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937 
                                39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z" fill="">
                                    </path>
                                    <path d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506 
                                18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937 
                                39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z" stroke="">
                                    </path>
                                    </svg>
                                    <div class="absolute leading-none start-2/4 top-2/4 -translate-y-2/4 -translate-x-2/4 rtl:translate-x-2/4">
                                    <i class="ki-filled ki-share text-1.5xl text-gray-500">
                                    </i>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-0.5">
                                    <span class="flex items-center gap-1.5 leading-none font-medium text-sm text-gray-900">
                                    Composition
                                    </span>
                                    <span class="text-2sm text-gray-700">
                                    {{ @$product->composition }}
                                    </span>
                                </div>
                                </div>
                                <div class="flex items-center gap-2 lg:gap-5">
                                <div class="flex items-center gap-2.5">
                                    <div class="switch switch-sm">
                                        <label class="switch-label" for="composition">{{ $product->com_status ? 'On' : 'Off' }}</label>
                                    <input wire:click="updateStatus('com_status')" type="checkbox" @if ($product->com_status) checked @endif />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-group flex items-center justify-between py-4 gap-2.5">
                            <div class="flex items-center gap-3.5">
                            <div class="relative size-[50px] shrink-0">
                                <svg class="w-full h-full stroke-gray-300 fill-gray-100" fill="none" height="48" viewbox="0 0 44 48" width="44" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506 
                            18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937 
                            39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z" fill="">
                                </path>
                                <path d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506 
                            18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937 
                            39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z" stroke="">
                                </path>
                                </svg>
                                <div class="absolute leading-none start-2/4 top-2/4 -translate-y-2/4 -translate-x-2/4 rtl:translate-x-2/4">
                                <i class="ki-filled ki-lock-2 text-1.5xl text-gray-500">
                                </i>
                                </div>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="flex items-center gap-1.5 leading-none font-medium text-sm text-gray-900">
                                Sustainability
                                </span>
                                <span class="text-2sm text-gray-700">
                                {{ @$product->sustainability }}
                                </span>
                            </div>
                            </div>
                            <div class="flex items-center gap-2 lg:gap-5">
                            <div class="flex items-center gap-2.5">
                                <div class="switch switch-sm">
                                    <label class="switch-label" for="sustainability">{{ $product->sus_status ? 'On' : 'Off' }}</label>
                                    <input wire:click="updateStatus('sus_status')" type="checkbox" @if ($product->sus_status) checked @endif />
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card-group flex items-center justify-between py-4 gap-2.5">
                            <div class="flex items-center gap-3.5">
                            <div class="relative size-[50px] shrink-0">
                                <svg class="w-full h-full stroke-gray-300 fill-gray-100" fill="none" height="48" viewbox="0 0 44 48" width="44" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506 
                            18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937 
                            39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z" fill="">
                                </path>
                                <path d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506 
                            18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937 
                            39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z" stroke="">
                                </path>
                                </svg>
                                <div class="absolute leading-none start-2/4 top-2/4 -translate-y-2/4 -translate-x-2/4 rtl:translate-x-2/4">
                                <i class="ki-filled ki-award text-1.5xl text-gray-500">
                                </i>
                                </div>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="flex items-center gap-1.5 leading-none font-medium text-sm text-gray-900">
                                Warranty
                                </span>
                                <span class="text-2sm text-gray-700">
                                {{ @$product->warranty }}
                                </span>
                            </div>
                            </div>
                            <div class="flex items-center gap-2 lg:gap-5">
                            <div class="flex items-center gap-2.5">
                                <div class="switch switch-sm">
                                    <label class="switch-label" for="warranty">{{ $product->war_status ? 'On' : 'Off' }}</label>
                                    <input wire:click="updateStatus('war_status')" type="checkbox" @if ($product->war_status) checked @endif />
                                </div>
                            </div>
                            </div>
                        </div>
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
