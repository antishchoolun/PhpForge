@props([
    'message' => 'Generating Code',
    'showParticles' => true
])

<div 
    x-data="{ 
        progress: 0,
        particleCount: 30,
        particles: [],
        init() {
            if ({{ $showParticles ? 'true' : 'false' }}) {
                this.particles = Array.from({ length: this.particleCount }, () => ({
                    x: Math.random() * 100,
                    y: Math.random() * 100,
                    size: Math.random() * 3 + 1,
                    speedX: Math.random() * 2 - 1,
                    speedY: Math.random() * 2 - 1
                }));
                this.animateParticles();
            }
            this.animateProgress();
        },
        animateParticles() {
            const canvas = this.$refs.particleCanvas;
            const ctx = canvas.getContext('2d');
            const animate = () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = '#6366f1';
                
                this.particles.forEach(particle => {
                    particle.x += particle.speedX;
                    particle.y += particle.speedY;
                    
                    if (particle.x < 0 || particle.x > 100) particle.speedX *= -1;
                    if (particle.y < 0 || particle.y > 100) particle.speedY *= -1;
                    
                    ctx.beginPath();
                    ctx.arc(
                        particle.x * canvas.width / 100,
                        particle.y * canvas.height / 100,
                        particle.size,
                        0,
                        Math.PI * 2
                    );
                    ctx.fill();
                });
                
                requestAnimationFrame(animate);
            };
            animate();
        },
        animateProgress() {
            const interval = setInterval(() => {
                this.progress = (this.progress + 1) % 100;
            }, 50);
            
            this.$watch('progress', value => {
                if (value === 99) clearInterval(interval);
            });
        }
    }"
    class="fixed inset-0 flex items-center justify-center z-[9999] bg-gray-900/80 backdrop-blur-sm"
>
    <!-- Background particles -->
    @if($showParticles)
        <canvas 
            x-ref="particleCanvas"
            class="absolute inset-0 w-full h-full"
            width="400"
            height="400"
        ></canvas>
    @endif

    <!-- Main loader -->
    <div class="relative flex flex-col items-center">
        <!-- Quantum circle -->
        <div class="relative w-32 h-32">
            <!-- Outer rotating ring -->
            <div class="absolute inset-0 rounded-full border-4 border-transparent animate-[spin_3s_linear_infinite]"
                style="border-top-color: #6366f1; border-right-color: #818cf8;">
            </div>
            
            <!-- Middle pulsing ring -->
            <div class="absolute inset-2 rounded-full border-4 border-indigo-500/50 animate-[pulse_2s_cubic-bezier(0.4,0,0.6,1)_infinite]">
            </div>
            
            <!-- Inner spinning quantum bits -->
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-2 h-2 bg-indigo-400 rounded-full animate-[bounce_1s_infinite]"
                    style="animation-delay: 0.1s"></div>
                <div class="w-2 h-2 bg-indigo-400 rounded-full animate-[bounce_1s_infinite]"
                    style="animation-delay: 0.2s"></div>
                <div class="w-2 h-2 bg-indigo-400 rounded-full animate-[bounce_1s_infinite]"
                    style="animation-delay: 0.3s"></div>
            </div>
            
            <!-- Progress indicator -->
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-xl font-bold text-indigo-400" x-text="`${progress}%`"></span>
            </div>
        </div>
        
        <!-- Message with typing effect -->
        <div class="mt-6 text-center">
            <h3 class="text-xl font-semibold text-white mb-2">{{ $message }}</h3>
            <div class="flex items-center justify-center gap-1">
                <div class="w-1 h-1 bg-indigo-400 rounded-full animate-[pulse_1s_infinite]"></div>
                <div class="w-1 h-1 bg-indigo-400 rounded-full animate-[pulse_1s_infinite]" style="animation-delay: 0.2s"></div>
                <div class="w-1 h-1 bg-indigo-400 rounded-full animate-[pulse_1s_infinite]" style="animation-delay: 0.4s"></div>
            </div>
        </div>
    </div>
</div>