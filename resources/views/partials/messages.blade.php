@foreach ($messages as $message)
    <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
        <div
            class="max-w-[70%] px-4 py-2 rounded-2xl text-sm font-medium shadow-sm 
            {{ $message->sender_id == auth()->id()
                ? 'bg-blue-600 text-white rounded-tr-none'
                : 'bg-white text-slate-700 border border-slate-200 rounded-tl-none' }}">
            {{ $message->message }}
            <p class="text-[8px] mt-1 opacity-70">{{ $message->created_at->format('H:i') }}</p>
        </div>
    </div>
@endforeach
