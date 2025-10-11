<div>
    <form wire:submit.prevent="save">
        <div wire:ignore.self class="modal" data-modal="true" id="modal_form" data-backdrop="static">
            <div class="modal-content max-w-[500px] top-[10%]">
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
                        <div class="flex flex-col space-y-3">
                            <label class="form-label flex items-center gap-1 max-w-32">
                            Banner <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-col justify-center gap-2">
                                <div class="flex items-center justify-center w-full h-60 mb-4 rounded-lg bg-gray-200 border border-gray-300 shadow-none">
                                    @if ($url)
                                    @php
                                        $path = $url instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile
                                                ? $url->temporaryUrl()
                                                : asset('storage/' . $url);
                                    @endphp
                                    <img src="{{ $path }}" class="h-full" alt="">
                                    @else
                                    <span class="text-sm text-secondary-inverse">Preview</span>
                                    @endif
                                </div>
                                <input type="file" wire:model="url" class="file-input w-full" accept=".jpg,.jpeg,.png,.webp">
                            </div>
                            @error('url') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                        </div>
                    </div>
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
        }, 200);
    });

    $wire.on('hideModal', () => {
        const modalEl = document.getElementById('modal_form');
        const modal = KTModal.getInstance(modalEl) || new KTModal(modalEl);

        modal.hide();
    });
</script>
@endscript