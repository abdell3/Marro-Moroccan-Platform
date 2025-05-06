@props(['class' => ''])

<div {{ $attributes->merge(['class' => $class]) }}>
    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
        <circle cx="50" cy="50" r="45" fill="url(#marro-gradient)" />
        <path d="M30 40 L30 65 L40 65 L40 50 L60 50 L60 65 L70 65 L70 40 L50 25 L30 40Z" fill="white" class="transform origin-center animate-bounce-slow"/>
        <path d="M45 55 L55 55 L55 65 L45 65 L45 55Z" fill="#8854d0" />
        
        <!-- Eyes for the logo -->
        <circle cx="40" cy="40" r="3" fill="white" />
        <circle cx="60" cy="40" r="3" fill="white" />
        
        <!-- Antenna -->
        <path d="M50 25 L50 15 M45 15 L55 15" stroke="white" stroke-width="2" />
        
        <defs>
            <linearGradient id="marro-gradient" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
                <stop offset="0%" stop-color="#8854d0" />
                <stop offset="100%" stop-color="#3b82f6" />
            </linearGradient>
        </defs>
    </svg>
</div>

<style>
    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-5%);
        }
    }
    .animate-bounce-slow {
        animation: bounce-slow 3s infinite;
    }
</style>