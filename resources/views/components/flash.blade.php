{{-- フラッシュメッセージ --}}
@if (session('alert') || session('info'))
@php
  if (session('alert')) {
    $message_color1 = 'bg-red-100';
    $message_color2 = 'border-red-500';
    $message_color3 = 'text-red-700';
    $role = 'alert';
    $message = session('alert');
  } else {
    $message_color1 = 'bg-teal-100';
    $message_color2 = 'border-teal-500';
    $message_color3 = 'text-teal-700';
    $role = 'info';
    $message = session('info');
  }
@endphp

<div class="{{ $message_color1 }} border-l-4 {{ $message_color2 }} {{ $message_color3 }} p-4 mb-4">
  <p class="font-bold">{{ $message }}</p>
</div>
@endif