<div>
    <main class="grow" role="content">
        <!-- Toolbar -->
        <div class="pb-5">
        <!-- Container -->
        <div class="container-fixed flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center flex-wrap gap-1 lg:gap-5">
            <h1 class="font-medium text-lg text-gray-900">
            Create {{ $title ?? 'Onemission' }}
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
                                Form Create {{ $title }}
                            </h3>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            @endif
                            <div class="p-10 space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 w-full">
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                        Name <span class="text-danger">*</span>
                                        </label>
                                        <input wire:model="form.name" class="input" placeholder="Enter product name" type="text" value="" required/>
                                        @error('form.name') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                        Category <span class="text-danger">*</span>
                                        </label>
                                        <select wire:model="form.categoryId" class="select" placeholder="Enter product category" type="text">
                                            <option value="">Select a category</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.categoryId') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 w-full">
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                        Price <span class="text-danger">*</span>
                                        </label>
                                        <input wire:model="form.price" class="input" placeholder="Enter product price" type="number" value="" required/>
                                        @error('form.price') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1">
                                        Original Price <span class="text-gray-500">(Optional)</span>
                                        </label>
                                        <input wire:model="form.originalPrice" class="input" placeholder="Enter product original price" type="number" value=""/>
                                        @error('form.originalPrice') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 w-full">
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                        Image <span class="text-danger">*</span>
                                        </label>
                                        <input wire:model="form.image" class="file-input" placeholder="Enter product image" type="file" value="" required/>
                                        @error('form.image') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1">
                                        Description <span class="text-gray-500">(Optional)</span>
                                        </label>
                                        <textarea wire:model="form.description" class="textarea" placeholder="Enter product description" rows="4" type="text" value=""></textarea>
                                        @error('form.description') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 w-full">
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                        Usage <span class="text-gray-500">(Optional)</span>
                                        </label>
                                        <input wire:model="form.usage" class="input" placeholder="Enter product usage" type="text" value=""/>
                                        @error('form.usage') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1">
                                        Technology <span class="text-gray-500">(Optional)</span>
                                        </label>
                                        <input wire:model="form.technology" class="input" placeholder="Enter product technology" type="text" value=""/>
                                        @error('form.technology') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 w-full">
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                        Features <span class="text-gray-500">(Optional)</span>
                                        </label>
                                        <input wire:model="form.features" class="input" placeholder="Enter product features" type="text" value=""/>
                                        @error('form.features') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1">
                                        Composition <span class="text-gray-500">(Optional)</span>
                                        </label>
                                        <input wire:model="form.composition" class="input" placeholder="Enter product composition" type="text" value=""/>
                                        @error('form.composition') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 w-full">
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                        Sustainability <span class="text-gray-500">(Optional)</span>
                                        </label>
                                        <input wire:model="form.sustainability" class="input" placeholder="Enter product sustainability" type="text" value=""/>
                                        @error('form.sustainability') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1">
                                        Warranty <span class="text-gray-500">(Optional)</span>
                                        </label>
                                        <input wire:model="form.warranty" class="input" placeholder="Enter product warranty" type="text" value=""/>
                                        @error('form.warranty') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div wire:ignore class="grid grid-cols-1 gap-5 w-full">
                                    <div class="flex flex-col space-y-3">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                        Tags <span class="text-gray-500">(Optional)</span>
                                        </label>
                                        <select wire:model="selectedTags" class="select2-multiple bg-light-active border border-gray-300 focus:border-blue-500" placeholder="Enter product tags" type="text" value="" multiple="multiple">
                                            @foreach ($tags as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('selectedTags') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer justify-between md:justify-end flex-col md:flex-row gap-3 text-gray-600 text-2sm font-medium">
                            <a href="{{ route('products') }}" type="button" wire:confirm="Are you sure you want to cancel this {{ $title }}?" class="btn btn-light">
                                Cancel
                            </a>
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
    </main>
</div>

@script
<script>
$(document).ready(function() {
    $('.select2-multiple').select2();
    $('.select2-multiple').on('change', function() {
        let data = $(this).val()
        $wire.set('selectedTags', data)
    });
});
</script>
@endscript