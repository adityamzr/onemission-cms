<div>
    <form wire:submit.prevent="save">
        <div wire:ignore.self class="modal" data-modal="true" id="modal_form" data-backdrop="static">
            <div class="modal-content w-fit top-[10%]">
                <div class="modal-header">
                    <h3 class="modal-title">
                        {{ $title }}
                    </h3>
                    <button type="button" class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                        <i class="ki-filled ki-cross">
                        </i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- begin: grid -->
                    <div class="w-full">
                        <div class="card card-grid h-full min-w-full">
                            <div class="card-header">
                                <h3 class="card-title">
                                Variants
                                </h3>
                            <div class="input input-sm max-w-48">
                                <i class="ki-filled ki-magnifier">
                                </i>
                                <input wire:model.live="search" placeholder="Search Variants" type="text"/>
                            </div>
                        </div>
                        <div class="card-body">
                        <div data-datatable="true" data-datatable-page-size="5">
                        <div class="scrollable-x-auto">
                            <table class="table table-border" data-datatable-table="true">
                                <thead>
                                    <tr>
                                        <th class="w-[60px]">
                                            {{-- <input class="checkbox checkbox-sm" data-datatable-check="true" type="checkbox"/> --}}
                                        </th>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($variants->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center py-10">
                                                No variants found.
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach ($variants as $key => $item)
                                    <tr>
                                        <td>
                                            <input wire:model="selectedVariants" value="{{ $item->id }}" class="checkbox checkbox-sm cursor-pointer" type="checkbox"/>
                                        </td>
                                        <td class="text-center">
                                            @if (!empty($item->images) && isset($item->images[0]))
                                                <div class="flex items-center justify-center relative size-20 rounded-lg shadow-none">
                                                    <img src="{{ asset('storage/' . $item->images[0]->image_url) }}" class="h-full" alt="">
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $item->slug }}</td>
                                        <td>
                                            @if ($item->sizes->count() == 0)
                                                <span>Empty Stock</span>
                                            @else
                                                @foreach ($item->sizes as $key => $size)
                                                    {{ $size->size }} = {{ $size->stock }}{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $item->color }}</td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg" style="background-color: {{ $item->color_code }}"></div> {{ $item->color_code }}
                                            </div>
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
                                    <option value="3">3</option>
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
                            {{ $variants->links('vendor.livewire.tailwind') }}
                        </div>
                        </div>
                        </div>
                        </div>
                    </div>
                    <!-- end: grid -->
                </div>
                <div class="modal-footer justify-end">
                    <div class="flex gap-4">
                        <button type="button" class="btn btn-light" data-modal-dismiss="true">
                        Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                        Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@script
<script>
    $wire.on('showModal', () => {
        const modalEl = document.getElementById('modal_form');
        const modal = KTModal.getInstance(modalEl) || new KTModal(modalEl);
        setTimeout(() => {
            modal.show();
        }, 100);
    });

    $wire.on('keepModalOpen', () => {
        const modalEl = document.getElementById('modal_form');
        let modal = KTModal.getInstance(modalEl);

        if (!modal) {
            modal = new KTModal(modalEl);
        }

        setTimeout(() => {
            modal.show();
        }, 100);
    });

    $wire.on('hideModal', () => {
        const modalEl = document.getElementById('modal_form');
        const modal = KTModal.getInstance(modalEl) || new KTModal(modalEl);

        modal.hide();
    });
</script>
@endscript