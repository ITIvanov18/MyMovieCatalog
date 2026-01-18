
window.playConfetti = function() {
    // настройки
    const colors = ['#a864fd', '#29cdff', '#78ff44', '#ff718d', '#fdff6a'];
    const particleCount = 150;
    
    // canvas елемент динамично
    const canvas = document.createElement('canvas');
    canvas.style.position = 'fixed';
    canvas.style.top = '0';
    canvas.style.left = '0';
    canvas.style.width = '100%';
    canvas.style.height = '100%';
    canvas.style.pointerEvents = 'none'; // да не пречи на кликането
    canvas.style.zIndex = '9999';
    document.body.appendChild(canvas);

    const ctx = canvas.getContext('2d');
    
    // оразмеряване
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const particles = [];

    // клас за 1 частица
    class Particle {
        constructor() {
            //this.x = canvas.width / 2; // започват от средата (хоризонтално)
            //this.y = canvas.height / 2; // започват от средата (вертикално)
            this.x = Math.random() * canvas.width;
            this.y = canvas.height + 10;
            
            this.color = colors[Math.floor(Math.random() * colors.length)];
            this.size = Math.random() * 5 + 5;
            this.speedX = Math.random() * 6 - 3; // наляво/надясно
            this.speedY = Math.random() * -6 - 3; // нагоре
            this.gravity = 0.1;
            this.rotation = Math.random() * 360;
            this.rotationSpeed = Math.random() * 10 - 5;
        }

        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            this.speedY += this.gravity;
            this.rotation += this.rotationSpeed;
            this.size *= 0.98; // намаляват постепенно
        }

        draw() {
            ctx.save();
            ctx.translate(this.x, this.y);
            ctx.rotate((this.rotation * Math.PI) / 180);
            ctx.fillStyle = this.color;
            ctx.fillRect(-this.size / 2, -this.size / 2, this.size, this.size);
            ctx.restore();
        }
    }

    // инициализация на частиците
    for (let i = 0; i < particleCount; i++) {
        const p = new Particle();
        p.x = Math.random() * canvas.width; 
        p.y = canvas.height + 10;
        p.speedY = (Math.random() * -15) - 5;
        particles.push(p);
    }

    // анимационен цикъл
    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
            
            // ако станат твърде малки, се премахват
            if (particles[i].size <= 0.5) {
                particles.splice(i, 1);
                i--;
            }
        }

        if (particles.length > 0) {
            requestAnimationFrame(animate);
        } else {
            // чисти, когато всичко свърши
            document.body.removeChild(canvas);
        }
    }

    animate();
};