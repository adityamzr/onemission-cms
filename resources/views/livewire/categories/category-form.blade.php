<div>
    <form wire:submit.prevent="save">
        <div class="modal" data-modal="true" id="modal_form" data-backdrop="static">
            <div class="modal-content max-w-[600px] top-[10%]">
                <div class="modal-header">
                    <h3 class="modal-title">
                        {{ $title }} Form
                    </h3>
                    <button type="button" class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                        <i class="ki-filled ki-cross">
                        </i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="w-full py-5 md:py-10 px-4 md:px-8">
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="form-label max-w-32">
                            Name <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-col w-full gap-1">
                                <input class="input" wire:model="name" placeholder="Enter category name" type="text"/>
                                @error('name')
                                <span class="form-hint text-red-500">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-end">
                    <div class="flex gap-4">
                        <button type="button" class="btn btn-light" data-modal-dismiss="true">
                        Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                        Submit
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
        }, 200);
    });

    $wire.on('hideModal', () => {
        const modalEl = document.getElementById('modal_form');
        const modal = KTModal.getInstance(modalEl) || new KTModal(modalEl);

        modal.hide();
    });
</script>
@endscript