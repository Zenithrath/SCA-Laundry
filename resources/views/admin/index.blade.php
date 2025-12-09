@extends('app')

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors duration-500">
    

    @include('admin.partials.sidebar')


    <div class="flex-1 ml-20 md:ml-64 p-8 relative z-0 w-auto">

        <h1 class="text-2xl font-bold mb-8 text-slate-800 dark:text-white">
            {{ $title ?? 'Admin Panel' }}
        </h1>
        
        @if($page === 'dashboard')
            @include('admin.partials.dashboard')
        
        @elseif($page === 'customers')
            @include('admin.partials.customers')
        
        @elseif($page === 'services')
            @include('admin.partials.services')
        
        @elseif($page === 'finance')
            @include('admin.partials.finance')
        
        @endif
        
    </div>
</div>
@endsection