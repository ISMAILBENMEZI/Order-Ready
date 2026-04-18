@foreach ($messages as $message)
    <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }} mb-4">
        <div class="max-w-[80%] flex flex-col gap-1">
            
            @if($message->product_id && $message->product)
                <div class="flex items-center gap-3 p-2 bg-blue-50 border border-blue-100 rounded-t-2xl shadow-sm">
                    <img src="{{ $message->product->primaryImage->image_url ?? asset('placeholder.png') }}" 
                         class="w-10 h-10 rounded-lg object-cover border border-white">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-slate-800 truncate w-32">
                            {{ $message->product->name }}
                        </span>
                        <span class="text-[9px] text-blue-600 font-bold">
                            ${{ number_format($message->product->price, 2) }}
                        </span>
                    </div>
                </div>
            @endif

            <div class="px-4 py-2 rounded-2xl text-sm font-medium shadow-sm 
                {{ $message->sender_id == auth()->id() 
                    ? 'bg-blue-600 text-white ' . ($message->product_id ? 'rounded-t-none' : 'rounded-tr-none') 
                    : 'bg-white text-slate-700 border border-slate-200 ' . ($message->product_id ? 'rounded-t-none' : 'rounded-tl-none') }}">
                
                {{ $message->message }}
                
                <div class="text-[8px] mt-1 opacity-60 text-right">
                    {{ $message->created_at->format('g:i A') }}
                </div>
            </div>
        </div>
    </div>
@endforeach