document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const errorElement = document.querySelector('.error');
    const button = document.querySelector('.btn-login');

    // เพิ่ม particle effect พื้นหลัง
    const particles = document.createElement('div');
    particles.className = 'particles';
    document.body.appendChild(particles);

    for (let i = 0; i < 50; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + 'vw';
        particle.style.top = Math.random() * 100 + 'vh';
        particle.style.animationDuration = Math.random() * 10 + 5 + 's';
        particles.appendChild(particle);
    }

    // การตรวจสอบและส่งฟอร์ม
    form.addEventListener('submit', function(e) {
        let errors = [];

        if (!emailInput.value.trim()) {
            errors.push('กรุณากรอกอีเมล');
            emailInput.classList.add('error-input');
        } else if (!isValidEmail(emailInput.value)) {
            errors.push('รูปแบบอีเมลไม่ถูกต้อง');
            emailInput.classList.add('error-input');
        } else {
            emailInput.classList.remove('error-input');
        }

        if (!passwordInput.value.trim()) {
            errors.push('กรุณากรอกรหัสผ่าน');
            passwordInput.classList.add('error-input');
        } else {
            passwordInput.classList.remove('error-input');
        }

        if (errors.length > 0) {
            e.preventDefault(); // หยุดการส่งฟอร์มถ้ามีข้อผิดพลาด
            if (!errorElement) {
                const newError = document.createElement('p');
                newError.className = 'error';
                newError.textContent = errors[0];
                newError.style.opacity = '0';
                form.insertBefore(newError, form.firstChild);
                setTimeout(() => newError.style.opacity = '1', 10);
            }
        } else {
            // ถ้าผ่านการตรวจสอบ แสดงสถานะโหลด
            button.textContent = 'กำลังเข้าสู่ระบบ...';
            button.disabled = true;
            // ปล่อยให้ฟอร์มส่งไปยัง PHP โดยไม่ต้องรีเซ็ตปุ่มที่นี่
        }
    });

    // ลบ error และเพิ่มลูกเล่น
    [emailInput, passwordInput].forEach(input => {
        input.addEventListener('input', function() {
            input.classList.remove('error-input');
            if (errorElement) {
                errorElement.style.opacity = '0';
                setTimeout(() => errorElement.remove(), 300);
            }
        });

        input.addEventListener('focus', function() {
            input.parentElement.style.transform = 'scale(1.02)';
        });

        input.addEventListener('blur', function() {
            input.parentElement.style.transform = 'scale(1)';
        });
    });

    // ตรวจสอบ email
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});

// ปรับ CSS สำหรับ particle effect
const style = document.createElement('style');
style.textContent = `
    .particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }

    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(30, 144, 255, 0.3);
        border-radius: 50%;
        animation: float infinite linear;
    }

    @keyframes float {
        0% { transform: translateY(0); opacity: 0.8; }
        50% { opacity: 0.4; }
        100% { transform: translateY(-100vh); opacity: 0; }
    }

    .form-group {
        transition: transform 0.3s ease;
    }
`;
document.head.appendChild(style);