<div>
    <main class="grow" role="content">
        <!-- Toolbar -->
        <div class="pb-5">
        <!-- Container -->
        <div class="container-fixed flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center flex-wrap gap-1 lg:gap-5">
            <h1 class="font-medium text-lg text-gray-900">
            {{ $id ? 'Edit' : 'Create'  }} {{ $title ?? 'Onemission' }}
            </h1>
            </div>
        </div>
        <!-- End of Container -->
        </div>
        <!-- End of Toolbar -->
        <!-- Container -->
        <div class="container-fixed">
            {{-- begin: table --}}
            <form wire:submit.prevent="save">
                <div class="grid">
                    <div class="card card-grid min-w-full">
                        <div class="card-header py-5 flex-wrap">
                            <h3 class="card-title">
                                Form {{ $id ? 'Edit' : 'Create'  }} {{ $title }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="p-10 space-y-5">
                                <div class="w-full">
                                    <style>
                                        .upgrade-bg {
                                            background-image: url('{{ url('') }}/assets/media/images/2600x1200/bg-14.png');
                                            }
                                            .dark .upgrade-bg {
                                                    background-image: url('{{ url('') }}/assets/media/images/2600x1200/bg-14-dark.png');
                                            }
                                    </style>
                                    <div class="card rounded-xl">
                                        <div class="flex items-center flex-wrap md:flex-nowrap justify-between grow gap-5 p-5 rtl:bg-[center_left_-8rem] bg-[center_right_-8rem] bg-no-repeat bg-[length:700px] upgrade-bg">
                                            @if (!empty($images))
                                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-5">
                                                @foreach ($images as $index => $item)
                                                @php
                                                    $itemId = is_array($item) ? ($item['id'] ?? null) : ($item->id ?? null);
                                                @endphp
                                                <div class="flex items-center justify-center relative size-[140px] mb-4 rounded-lg bg-gray-200 border border-gray-300 shadow-none">
                                                    @if ($id)
                                                    <button wire:click="removeImage({{ $index }}, '{{ $itemId }}', '{{ @$id }}')" wire:confirm="Are you sure you want to remove this item?" type="button" class="absolute -right-3 -top-3">
                                                    @else
                                                    <button wire:click="removeImage({{ $index }})" type="button" class="absolute -right-3 -top-3">
                                                    @endif
                                                        <i class="ki-solid ki-cross-circle text-danger text-2xl"></i>
                                                    </button>
                                                    @php
                                                        $url = $item instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile
                                                                ? $item->temporaryUrl()
                                                                : (is_array($item) ? asset('storage/' . $item['url']) : asset('storage/' . $item));
                                                    @endphp
                                                    <img src="{{ $url }}" class="h-full" alt="">
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                            <div class="flex items-center gap-4">
                                                <div class="relative size-[50px] shrink-0">
                                                    <svg class="w-full h-full stroke-primary-clarity fill-primary-light" fill="none" height="48" viewbox="0 0 44 48" width="44" xmlns="http://www.w3.org/2000/svg">
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
                                                        <i class="ki-filled ki-picture text-1.5xl text-primary">
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col gap-2">
                                                    <div class="flex items-center flex-wrap sm:flex-nowrap gap-2.5">
                                                        <span class="text-base font-medium text-gray-900 hover:text-primary-active">
                                                            Upload outfit images here
                                                        </span>
                                                    </div>
                                                    <div class="text-2sm text-gray-700">
                                                    Select the images you want to upload. Only JPG, JPEG, WEBP, AVIFF, and PNG formats are allowed.
                                                    <br/>
                                                    Click the button to upload (up to 5 photos).
                                                    <br/>
                                                    @error('newImages.*')
                                                        <p class="text-red-500 text-2sm">Error Upload: {{ $message }}</p>
                                                    @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="flex items-center gap-1.5 shrink-0">
                                                <button wire:click="resetImages" type="button" class="btn btn-danger btn-clear">
                                                Reset
                                                </button>
                                                <input type="file" id="upload" wire:model="newImages" class="hidden" accept=".jpg,.jpeg,.png,.webp,.aviff" multiple>
                                                <label for="upload">
                                                    <button type="button" class="btn btn-dark btnUpload">
                                                    Upload Images
                                                    </button>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 w-full">
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                        Model Name <span class="text-danger">*</span>
                                        </label>
                                        <input wire:model="modelName" class="input" placeholder="Enter model name" type="text" required/>
                                        @error('modelName') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                        Model Height (cm) <span class="text-danger">*</span>
                                        </label>
                                        <input wire:model="modelHeight" class="input" placeholder="Enter model height" type="number" required/>
                                        @error('color_code') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 w-full">
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                        Model Size <span class="text-danger">*</span>
                                        </label>
                                        <select wire:model="modelSize" class="select" placeholder="Pick model size">
                                            <option value="">Select model size</option>
                                            <option value="XS">XS</option>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                            <option value="2XL">2XL</option>
                                            <option value="3XL">3XL</option>
                                        </select>
                                        @error('status') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                        Status <span class="text-danger">*</span>
                                        </label>
                                        <select wire:model="status" class="select" placeholder="Pick status">
                                            <option value="">Select a status</option>
                                            <option value="true">Show</option>
                                            <option value="false">Hide</option>
                                        </select>
                                        @error('status') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @if (!empty($id))
                                <div class="card rounded-xl">
                                    <div class="card-header py-5 flex-wrap justify-between">
                                        <h3 class="card-title">
                                            Outfit Items
                                        </h3>
                                        <button type="button" wire:click="$dispatchTo('outfits.variants-modal', 'openModal')" class="btn btn-dark">Add Outfit Item</button>
                                    </div>
                                    <div data-datatable="true" data-datatable-page-size="5">
                                        <div class="scrollable-x-auto">
                                            <table class="table table-border" data-datatable-table="true">
                                                <thead>
                                                    <tr>
                                                        <th class="min-w-[80px]">
                                                            <span class="sort">
                                                                <span class="sort-label">
                                                                Image
                                                                </span>
                                                                <span class="sort-icon">
                                                                </span>
                                                            </span>
                                                        </th>
                                                        <th class="min-w-[200px]">
                                                            <span class="sort">
                                                                <span class="sort-label">
                                                                Name / Slug
                                                                </span>
                                                                <span class="sort-icon">
                                                                </span>
                                                            </span>
                                                        </th>
                                                        <th class="min-w-[150px]">
                                                            <span class="sort">
                                                                <span class="sort-label">
                                                                Sizes & Stock
                                                                </span>
                                                                <span class="sort-icon">
                                                                </span>
                                                            </span>
                                                        </th>
                                                        <th class="min-w-[150px]" >
                                                            <span class="sort">
                                                                <span class="sort-label">
                                                                Color
                                                                </span>
                                                                <span class="sort-icon">
                                                                </span>
                                                            </span>
                                                        </th>
                                                        <th class="min-w-[120px]">
                                                            <span class="sort">
                                                                <span class="sort-label">
                                                                Color Code
                                                                </span>
                                                                <span class="sort-icon">
                                                                </span>
                                                            </span>
                                                        </th>
                                                        <th class="w-[100px] text-center">
                                                            <span class="sort">
                                                                <span class="sort-label">
                                                                Action
                                                                </span>
                                                                <span class="sort-icon">
                                                                </span>
                                                            </span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($outfitItems->isEmpty())
                                                        <tr>
                                                            <td colspan="7" class="text-center py-10">
                                                                No variants found.
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @foreach ($outfitItems as $key => $item)
                                                    <tr>
                                                        <td class="text-center">
                                                            @if (!empty($item->variant->images) && isset($item->variant->images[0]))
                                                                <div class="flex items-center justify-center relative size-20 rounded-lg shadow-none">
                                                                    <img src="{{ asset('storage/' . $item->variant->images[0]->image_url) }}" class="h-full" alt="">
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->variant->slug }}</td>
                                                        <td>
                                                            @if ($item->variant->sizes->count() == 0)
                                                                <span>Empty Stock</span>
                                                            @else
                                                                @foreach ($item->variant->sizes as $key => $size)
                                                                    {{ $size->size }} = {{ $size->stock }}{{ !$loop->last ? ', ' : '' }}
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->variant->color }}</td>
                                                        <td>
                                                            <div class="flex items-center gap-2">
                                                                <div class="w-8 h-8 rounded-lg" style="background-color: {{ $item->variant->color_code }}"></div> {{ $item->variant->color_code }}
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <button wire:click="removeOutfitItem('{{ $item->variant->id }}')" wire:confirm="Are you sure you want to remove this data?" type="button" class="btn btn-danger btn-sm">
                                                                <i class="ki-filled ki-trash">
                                                                </i>
                                                                Remove
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-gray-600 text-2sm font-medium">
                                            <div class="flex items-center gap-2 order-2 md:order-1">
                                                Show
                                                <select class="select select-sm w-16" wire:model.change="perpage">
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                </select>
                                                per page
                                            </div>
                                            <div class="flex items-center gap-4 order-1 md:order-2">
                                                <span data-datatable-info="true">
                                                </span>
                                                <div class="pagination" data-datatable-pagination="true">
                                                </div>
                                            </div>
                                            {{ $outfitItems->links('vendor.livewire.tailwind') }}
                                        </div>
                                    </div>
                                </div>    
                                @endif
                            </div>
                        </div>
                        <div class="card-footer justify-between md:justify-end flex-col md:flex-row gap-3 text-gray-600 text-2sm font-medium">
                            @if (empty($id))
                            <button type="button" wire:click="cancel" wire:confirm="Are you sure you want to cancel this {{ $id ? 'Edit' : 'Create'  }} {{ $title }}?" class="btn btn-light">
                                Cancel
                            </button>
                            @endif
                            <button type="submit" class="btn btn-primary">
                                Save {{ $title }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            {{-- end: table --}}
        </div>
        <!-- End of Container -->
        @livewire('outfits.variants-modal')
    </main>
</div>

@script
<script>
    $('.btnUpload').on('click', function() {
        $('#upload').click()
    })
</script>
@endscript