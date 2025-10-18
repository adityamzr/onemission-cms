<div>
    <div class="modal" data-modal="true" id="modal_form" data-modal-backdrop-static="true">
        <div class="modal-content max-w-[600px] max-h-[90%] top-[5%]">
            <div class="modal-header">
                <h3 class="modal-title font-bold text-lg">
                    {{ $title }} - {{ $order->order_number ?? '' }}
                </h3>
                <button type="button" class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                    <i class="ki-filled ki-cross">
                    </i>
                </button>
            </div>
            <div class="modal-body px-0 scrollable-y-auto max-h-[600px]">
                <div class="w-full py-5 px-4 md:px-8">
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2">
                        <h5 class="font-semibold text-sm">Order Information</h5>
                        @php
                            switch ($order?->status) {
                                case 'pending':
                                    $colorStatus = 'dark';
                                    break;
                                case 'waiting payment':
                                    $colorStatus = 'warning';
                                    break;
                                case 'paid':
                                    $colorStatus = 'success';
                                    break;
                                case 'processing':
                                    $colorStatus = 'info';
                                    break;
                                case 'shipped':
                                    $colorStatus = 'primary';
                                    break;
                                case 'delivered':
                                    $colorStatus = 'success';
                                    break;
                                case 'cancelling':
                                    $colorStatus = 'danger';
                                    break;
                                case 'cancelled':
                                    $colorStatus = 'danger';
                                    break;
                                default:
                                    $colorStatus = 'secondary';
                                    break;
                            }
                        @endphp
                        <div class="badge badge-pill badge-outline badge-{{ $colorStatus }} capitalize">{{ $order->status ?? '-' }}</div>
                    </div>
                    <div class="border-b border-gray-300 mb-3"></div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label">
                        Order Date
                        </label>
                        <label class="form-label justify-end font-semibold">
                            {{ $order->created_at ?? '-' }}
                        </label>
                    </div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label">
                        Email
                        </label>
                        <label class="form-label justify-end font-semibold">
                            {{ $order->email ?? '-' }}
                        </label>
                    </div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label">
                        Payment Status
                        </label>
                        <label class="form-label justify-end font-semibold">
                            @php
                                switch ($order?->payment_status) {
                                    case 'unpaid':
                                        $color = 'danger';
                                        break;
                                    case 'paid':
                                        $color = 'success';
                                        break;
                                    case 'failed':
                                        $color = 'danger';
                                        break;
                                    case 'refunded':
                                        $color = 'dark';
                                        break;
                                    default:
                                        $color = 'secondary';
                                        break;
                                }
                            @endphp
                            <div class="badge badge-pill badge-outline badge-{{ $color }} capitalize">{{ $order->payment_status ?? '-' }}</div>
                        </label>
                    </div>
                </div>
                <div class="h-2 bg-gray-300"></div>
                <div class="w-full py-5 px-4 md:px-8">
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2">
                        <h5 class="font-semibold text-sm">Order Items</h5>
                        <h5 class="font-semibold text-sm">{{ $orderQty ?? '' }} Item{{ $order?->orderItems->count() > 1 ? 's' : '' }}</h5>
                    </div>
                    <div class="border-b border-gray-300 mb-3"></div>
                    @foreach ($order?->orderItems ?? [] as $item)
                    <div class="flex justify-between items-start flex-wrap lg:flex-nowrap mb-4">
                        <div class="flex items-start gap-3 w-full">
                            <div class="flex items-center justify-center relative size-[5rem] rounded-lg shadow-none">
                                <img src="{{ asset('storage/' . $item->image_url) }}" class="h-full" alt="">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="form-label">
                                {{ $item->product_name }}
                                </label>
                                <span class="text-gray-700 text-xs">{{ $item->size }} - {{ $item->color }}</span>
                                <span class="text-gray-700 text-xs">Qty: {{ $item->quantity }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col h-[5rem] items-end w-full justify-between">
                            <span class="text-gray-700 text-[0.8125rem] leading-[1.125rem] font-semibold">
                                {{ $item->quantity }} x {{ formatRupiah($item->price) }}
                            </span>
                            <span class="text-gray-700 text-[0.8125rem] leading-[1.125rem] font-bold">
                                <span class="text-xs font-normal">Total {{ $item->quantity }} item{{ $item->quantity > 1 ? 's:' : ':' }}</span> {{ formatRupiah($item->subtotal) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="h-2 bg-gray-300"></div>
                <div class="w-full py-5 px-4 md:px-8">
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2">
                        <h5 class="font-semibold text-sm">Shipping Information</h5>
                    </div>
                    <div class="border-b border-gray-300 mb-3"></div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label">
                        Courier
                        </label>
                        <label class="form-label justify-end font-semibold">
                            {{ $order?->shipping_provider ?? '-' }}
                        </label>
                    </div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label">
                        Tracking Number
                        </label>
                        <label class="form-label justify-end font-semibold">
                            {{ $order?->shipmentTracking?->tracking_number ?? '-' }}
                        </label>
                    </div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label">
                        Recipient Name
                        </label>
                        <label class="form-label justify-end font-semibold">
                            {{ $order?->name ?? '-' }}
                        </label>
                    </div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label">
                        Phone
                        </label>
                        <label class="form-label justify-end font-semibold">
                            {{ $order?->phone ?? '-' }}
                        </label>
                    </div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label">
                        Address
                        </label>
                        <label class="form-label justify-end font-semibold text-right">
                            {{ $address ?? '-' }}
                        </label>
                    </div>
                </div>
                <div class="h-2 bg-gray-300"></div>
                <div class="w-full py-5 px-4 md:px-8">
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2">
                        <h5 class="font-semibold text-sm">Payment Details</h5>
                    </div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label">
                        Payment Method
                        </label>
                        <label class="form-label justify-end font-semibold capitalize">
                            {{ $order?->payment->payment_method ?? '-' }}
                        </label>
                    </div>
                    <div class="border-b border-gray-300 mb-3"></div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label">
                        Subtotal Items
                        </label>
                        <label class="form-label justify-end font-semibold">
                            {{ formatRupiah($order?->subtotal) ?? '-' }}
                        </label>
                    </div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label">
                        Total Discount
                        </label>
                        <label class="form-label justify-end font-semibold">
                            {{ formatRupiah($order?->total_discount) ?? '-' }}
                        </label>
                    </div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label">
                        Shipping Cost
                        </label>
                        <label class="form-label justify-end font-semibold">
                            {{ formatRupiah($order?->shipping_cost) ?? '-' }}
                        </label>
                    </div>
                    <div class="border-b border-gray-300 mb-3"></div>
                    <div class="flex justify-between items-baseline flex-wrap lg:flex-nowrap mb-2">
                        <label class="form-label text-md font-bold">
                        Total Payment
                        </label>
                        <label class="form-label justify-end text-md font-bold">
                            {{ formatRupiah($order?->total_amount) ?? '-' }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <div class="flex my-2 gap-4">
                    @if ($order?->status == 'pending' || $order?->status == 'waiting payment' || $order?->status == 'cancelling')
                        <button wire:click="cancelOrder({{ $order?->id }})" wire:confirm="Are you sure you want to cancel this order?" type="button" class="btn btn-danger">
                        Cancel Order
                        </button>
                    @elseif($order?->status == 'paid')
                        <button wire:click="processOrder({{ $order?->id }})" wire:confirm="Are you sure you want to process this order?" type="button" class="btn btn-primary">
                        Process Order
                        </button>
                    @elseif($order?->status == 'processing')
                        <button wire:click="showModalTracking" type="button" class="btn btn-primary">
                        Deliver Order
                        </button>
                    @elseif($order?->status == 'delivered' || $order?->status == 'shipped')
                        <button wire:click="completeOrder({{ $order?->id }})" wire:confirm="Are you sure you want to complete this order?" type="button" class="btn btn-success" {{ $order?->status == 'shipped' ? 'disabled' : '' }}>
                        Complete Order
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <form wire:submit.prevent="shipOrder({{ $order?->id }})">
        <div wire:ignore.self class="modal" data-modal="true" id="modal_tracking_number" data-modal-backdrop-static="true">
            <div class="modal-content modal-center max-w-[600px]">
            <div class="modal-header">
            <h3 class="modal-title">
                Input Tracking Number
            </h3>
            <button wire:click="openModal({{ $order?->id }})" class="btn btn-xs btn-icon btn-light">
                <i class="ki-filled ki-cross"></i>
            </button>
            </div>
                <div class="modal-body">
                <div class="w-full py-5 md:py-10 px-4 md:px-8">
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-3">
                            <label class="form-label max-w-32">
                            Tracking Number <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-col w-full gap-1">
                                <input class="input" wire:model="tracking_number" placeholder="Enter tracking number" type="text" required/>
                                @error('tracking_number')
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
                        <button wire:click="openModal({{ $order?->id }})" class="btn btn-light">
                        Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                        Save Tracking Number
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

    $wire.on('showModalTracking', () => {
        const modalEl = document.getElementById('modal_tracking_number');
        const modal = KTModal.getInstance(modalEl) || new KTModal(modalEl);

        setTimeout(() => {
            modal.show();
        }, 200);
    });

    $wire.on('hideModalTracking', () => {
        const modalEl = document.getElementById('modal_tracking_number');
        const modal = KTModal.getInstance(modalEl) || new KTModal(modalEl);

        modal.hide();
    });
</script>
@endscript