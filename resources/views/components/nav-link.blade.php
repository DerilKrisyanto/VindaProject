@props(['active' => false])

<a {{ $attributes }}
   class="group relative flex items-center gap-2 px-4 py-2.5 rounded-2xl text-sm font-medium smooth-transition
   focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2
   {{ $active
        ? 'bg-gradient-to-r from-blue-400 to-blue-500 text-blue shadow-md shadow-blue-400/25'
        : 'text-slate-600 hover:text-blue-600 hover:bg-white/60 hover:shadow-md hover:shadow-blue-400/10'
   }}"
   aria-current="{{ $active ? 'page' : null }}">
    
    <!-- Hover Glow -->
    <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-blue-400/10 to-blue-500/10 opacity-0 group-hover:opacity-100 smooth-transition"></div>
    
    <span class="relative z-10 flex items-center gap-2">
        {{ $slot }}
    </span>
</a>
