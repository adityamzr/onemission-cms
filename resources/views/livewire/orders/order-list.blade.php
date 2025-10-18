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
            {{-- <div class="flex items-center flex-wrap gap-1.5 lg:gap-3.5">
                <a class="btn btn-sm btn-light" href="html/demo6/account/home/get-started.html">
                    <i class="ki-filled ki-exit-down !text-base">
                    </i>
                    Export
                </a>
                <button type="button" wire:click="$dispatchTo('orders.order-form', 'openModal')" class="btn btn-dark">
                    <i class="ki-filled ki-plus-squared">
                    </i>
                    Add order
                </button>
            </div> --}}
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
                                            <th class="min-w-[200px] text-center" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Order Date/Time
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[200px] text-center" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Order Number
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[200px] text-center" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Name
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[200px] text-center" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Email
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[150px] text-center" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Phone
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[150px] text-center" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Order Items
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            {{-- <th class="min-w-[150px] text-center" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Discount
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[150px] text-center" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Subtotal
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[180px] text-center" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Shipping Provider
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[150px] text-center" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Shipping Cost
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th> --}}
                                            <th class="min-w-[150px] text-center" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Total Payment
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[150px] text-center" data-datatable-column="lastSession">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Order Status
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="min-w-[150px] text-center" data-datatable-column="ipAddress">
                                                <span class="sort">
                                                    <span class="sort-label">
                                                    Payment Status
                                                    </span>
                                                    <span class="sort-icon">
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="w-[100px] sticky right-0 border text-center" data-datatable-column="label">
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
                                        @if ($orders->isEmpty())
                                        <tr>
                                            <td colspan="14">
                                                <h3 class="text-lg text-center my-5">Empty Data</h3>
                                            </td>
                                        </tr>
                                        @endif
                                        @foreach ($orders as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $orders->firstItem() + $key }}</td>
                                            <td class="text-center">{{ $item->created_at }}</td>
                                            <td class="text-center">{{ $item->order_number }}</td>
                                            <td class="text-center">{{ $item->name }}</td>
                                            <td class="text-center">{{ $item->email }}</td>
                                            <td class="text-center">{{ $item->phone }}</td>
                                            <td class="text-center">{{ $item->orderItems->count() }}</td>
                                            {{-- <td class="text-center">
                                                @if (!empty($item->discount))
                                                    @if ($item->discount->type == 'percentage')
                                                        {{ $item->discount->value }}%
                                                    @else
                                                        {{ formatRupiah($item->discount->value) }}
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">{{ formatRupiah($item->subtotal) }}</td>
                                            <td class="text-center">{{ $item->shipping_provider }}</td>
                                            <td class="text-center">{{ formatRupiah($item->shipping_cost) }}</td> --}}
                                            <td class="text-center">{{ formatRupiah($item->total_amount) }}</td>
                                            <td class="text-center">
                                                @php
                                                    switch ($item->status) {
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
                                                        default:
                                                            $colorStatus = 'secondary';
                                                            break;
                                                    }
                                                @endphp
                                                <div class="badge badge-pill badge-outline badge-{{ $colorStatus }} capitalize">{{ $item->status }}</div>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    switch ($item->payment_status) {
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
                                                <div class="badge badge-pill badge-outline badge-{{ $color }} capitalize">{{ $item->payment_status }}</div>
                                            </td>
                                            <td class="flex items-center gap-2 sticky right-0 bg-white z-10 border-l">
                                                <button type="button"  wire:click="$dispatchTo('orders.order-detail', 'openModal', { id: {{ $item->id }} })" class="btn btn-primary btn-sm">
                                                    <i class="ki-filled ki-eye">
                                                    </i>
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
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
                                {{ $orders->links('vendor.livewire.tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end: table --}}
        </div>
        <!-- End of Container -->
        @livewire('orders.order-detail')
    </main>
</div>
