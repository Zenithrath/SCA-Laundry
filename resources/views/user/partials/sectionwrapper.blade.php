@props([
    'id' => '',
    'class' => '',     // Menggantikan className
    'noSnap' => false  // Default false (snap aktif)
])

<section
    id="{{ $id }}"
    class="w-full min-h-screen {{ $noSnap ? '' : 'snap-start' }} 
           flex flex-col justify-center items-center relative px-6 md:px-16 py-20 
           transition-colors duration-500 animate-on-scroll 
           section-wrapper {{ $class }}"
>
    {{ $slot }}
</section>