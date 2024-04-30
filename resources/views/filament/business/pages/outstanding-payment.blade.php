<x-filament-panels::page>
    @php
        $currentRowId = session('current_row_id');
        $job = \App\Models\JobDetail::where('job_id','=',$currentRowId)->first();
        $business = \App\Models\User::where('id','=', auth()->id())->first();
    @endphp
    <form action="{{ route('vnpay_payment') }}" class="grid dark:bg-black/50 sm:px-10 lg:grid-cols-2 lg:px-20 xl:px-32" method="post">
        @csrf
        <div class="px-4 pt-8 flex">
            <div class="mt-8 space-y-3 rounded-lg border bg-white px-2 py-4 sm:px-6">
                <div class="flex flex-col rounded-lg bg-white sm:flex-row">
                    <img width="150px" class="m-2 rounded-md border object-cover object-center"
                         src="/images/item-pay-job.png"
                         alt=""/>
                    <div class="flex w-full flex-col px-4 py-4">
                        <span class="font-semibold">{{ $job['title'] }}</span>
                        <span class="float-right text-gray-400">SL: 1</span>
                        <p class="text-lg font-bold">20.000đ</p>
                        <input type="hidden" name="amount" value="20000">
                    </div>
                </div>
            </div>
            <div class="mt-10 bg-gray-50 px-4 pt-8 lg:mt-0">
                <p class="text-xl font-medium">Thông Tin Thanh Toán</p>
                <p class="text-gray-400">Hoàn tất đơn đặt hàng của bạn bằng cách cung cấp chi tiết thanh toán của bạn.</p>
                <div class="py-5">
                    <label for="email" class="mt-4 mb-2 block text-sm font-medium">Mã Đơn Hàng</label>
                    <div class="relative">
                        <input type="text" id="order_id" name="order_id" readonly value="<?=random_int(1000000, 9999999)?>"
                               class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"/>
                    </div>
                    <br>
                    <label for="email" class="mt-4 mb-2 block text-sm font-medium">Tên Sản Phẩm</label>
                    <div class="relative">
                        <input type="text" id="order_id" name="order_desc" value="DANG KY TIN NOI BAT" readonly
                               class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"/>
                    </div>
                    <br>
                    <label for="email" class="mt-4 mb-2 block text-sm font-medium">Email</label>
                    <div class="relative">
                        <input type="text" id="email" name="email" value="{{ $business['email'] }}" readonly
                               class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"/>
                        <div class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-900">Tổng</p>
                        <p class="text-2xl font-semibold text-gray-900">20.000đ</p>
                    </div>
                </div>
                <button name="redirect" style="background-color: green; color: white" class="border bold mt-4 mb-8 w-full rounded-md bg-gray-900 px-6 py-3 font-medium">Thanh Toán
                </button>
            </div>
        </div>

</x-filament-panels::page>
