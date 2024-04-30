<x-filament-panels::page>
    @if (request('vnp_ResponseCode'))
        <div class="border flex flex-col justify-center items-center rounded-md py-5">
            @if(request('vnp_ResponseCode') == '00')
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color: #00bb00" class="w-32">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="title font-bold py-5" style="font-size: 45px">
                    THANH TOÁN THÀNH CÔNG
                </div>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color: red" class="w-32">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="title font-bold py-5" style="font-size: 45px">
                    THANH TOÁN THẤT BẠI
                </div>
            @endif
            <div class="info">
                <p><strong>Dịch Vụ:</strong> {{ request('vnp_OrderInfo') }}</p>
                <p><strong>Tổng Tiền:</strong> {{ number_format(request('vnp_Amount') / 100) }} VND</p>
                <p><strong>Ngân Hàng:</strong> {{ request('vnp_BankCode') }}</p>
                <p><strong>Mã Hóa Đơn Ngân Hàng:</strong> {{ request('vnp_BankTranNo') }}</p>
                <p><strong>Trạng Thái:</strong> {{ request('vnp_ResponseCode') === '00' ? 'Thành Công' : 'Thất Bại' }}</p>
            </div>
        </div>
            <?php
            $paymentHistory = \App\Models\PaymentHistory::where('order_id', request('vnp_TxnRef'))->first();

            if (!$paymentHistory) {
                \App\Models\PaymentHistory::create([
                    'order_id' => request('vnp_TxnRef'),
                    'order_desc' => request('vnp_OrderInfo'),
                    'amount' => request('vnp_Amount') / 100,
                    'user_id' => auth()->id(),
                    'status' => request('vnp_ResponseCode') === '00' ? 'Thành Công' : 'Thất Bại'
                ]);

                \App\Models\JobAttribute::where('job_id', session('current_row_id'))
                    ->update(['is_featured' => 1]);
            }

            session()->forget('current_row_id');
            ?>
    @endif

</x-filament-panels::page>
