document.addEventListener('DOMContentLoaded', function() {
    // Particle Effect
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

    // Form Input Effects
    const inputs = document.querySelectorAll('.form-group input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });

    // Button Loading Animation
    const buttons = document.querySelectorAll('.btn-add, .btn-save');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!this.closest('form').checkValidity()) return;
            const originalText = this.textContent;
            this.textContent = 'กำลังบันทึก...';
            this.disabled = true;
            setTimeout(() => {
                this.textContent = originalText;
                this.disabled = false;
            }, 2000); // จำลองการโหลด
        });
    });

    // Sidebar Toggle for Mobile (Optional)
    const sidebar = document.querySelector('aside');
    if (window.innerWidth <= 768) {
        sidebar.style.transform = 'translateX(-100%)';
        const toggleBtn = document.createElement('button');
        toggleBtn.textContent = '☰';
        toggleBtn.className = 'fixed top-4 left-4 z-50 p-2 bg-blue-500 text-white rounded-lg';
        document.body.appendChild(toggleBtn);

        toggleBtn.addEventListener('click', () => {
            sidebar.style.transform = sidebar.style.transform === 'translateX(-100%)' ? 'translateX(0)' : 'translateX(-100%)';
        });
    }

    // Loading Overlay
    const loadingOverlay = document.getElementById('loading-overlay');
    if (loadingOverlay) {
        loadingOverlay.classList.remove('hidden');
        setTimeout(() => {
            loadingOverlay.classList.add('hidden');
        }, 1000);
    }

    // Dark Mode Toggle
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark');
            const icon = this.querySelector('i');
            if (document.body.classList.contains('dark')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        });
    }
});

// Edit Form Functions (Already in your HTML, just ensuring compatibility)
function showEditForm(id, ...args) {
    const editForm = document.getElementById('edit-form');
    const fields = ['id', 'image_url', 'alt_text', 'title', 'list_item1', 'list_item2', 'list_item3'];
    document.getElementById(`edit-${fields[0]}`).value = id;
    for (let i = 1; i < args.length + 1; i++) {
        document.getElementById(`edit-${fields[i]}`).value = args[i - 1];
    }
    editForm.style.display = 'block';
}

function hideEditForm() {
    document.getElementById('edit-form').style.display = 'none';
}

// Logo Edit Form
function showLogoEditForm(id, image_url, alt_text) {
    document.getElementById('logo-edit-id').value = id;
    document.getElementById('logo-edit-image_url').value = image_url;
    document.getElementById('logo-edit-alt_text').value = alt_text;
    document.getElementById('logo-edit-form').classList.remove('hidden');
}

function hideLogoEditForm() {
    document.getElementById('logo-edit-form').classList.add('hidden');
}

// Service Edit Form
function showServiceEditForm(id, icon_url, title, list_item1, list_item2, list_item3) {
    document.getElementById('service-edit-id').value = id;
    document.getElementById('service-edit-icon_url').value = icon_url;
    document.getElementById('service-edit-title').value = title;
    document.getElementById('service-edit-list_item1').value = list_item1;
    document.getElementById('service-edit-list_item2').value = list_item2;
    document.getElementById('service-edit-list_item3').value = list_item3;
    document.getElementById('service-edit-form').classList.remove('hidden');
}

function hideServiceEditForm() {
    document.getElementById('service-edit-form').classList.add('hidden');
}

// Work Edit Form
function showWorkEditForm(id, image_url, title, list_item1, list_item2, list_item3) {
    document.getElementById('work-edit-id').value = id;
    document.getElementById('work-edit-image_url').value = image_url;
    document.getElementById('work-edit-title').value = title;
    document.getElementById('work-edit-list_item1').value = list_item1;
    document.getElementById('work-edit-list_item2').value = list_item2;
    document.getElementById('work-edit-list_item3').value = list_item3;
    document.getElementById('work-edit-form').classList.remove('hidden');
}

function hideWorkEditForm() {
    document.getElementById('work-edit-form').classList.add('hidden');
}

// SweetAlert2 Confirmation
function confirmDelete(message) {
    return Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff6b6b',
        cancelButtonColor: '#1e90ff',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => result.isConfirmed);
}

// เพิ่มในส่วนท้ายของไฟล์
function showMessageDetail(id, name, email, subject, message, submitted_at, is_read) {
    document.getElementById('detail-name').textContent = name;
    document.getElementById('detail-email').textContent = email;
    document.getElementById('detail-subject').textContent = subject;
    document.getElementById('detail-message').textContent = message;
    document.getElementById('detail-submitted_at').textContent = submitted_at;
    document.getElementById('message-detail-modal').classList.remove('hidden');

    if (!is_read) {
        fetch(`index.php?page=contact_messages&action=mark_read&id=${id}`).then(() => {
            document.querySelector(`tr[data-id="${id}"] .bg-green-500`)?.remove();
        });
    }
}

function hideMessageDetail() {
    document.getElementById('message-detail-modal').classList.add('hidden');
}

function showReplyModal(id) {
    document.getElementById('reply-message-id').value = id;
    document.getElementById('reply-message-modal').classList.remove('hidden');
}

function hideReplyModal() {
    document.getElementById('reply-message-modal').classList.add('hidden');
}