/* ===================================
   PROFILE PAGE INTERACTIONS
   Enhanced file upload and UI behaviors
   =================================== */

document.addEventListener('DOMContentLoaded', function() {
    // File upload enhancement
    const fileInput = document.getElementById('profile_image');
    const fileLabel = document.querySelector('.file-input-label');
    const profileImg = document.querySelector('.profile-picture img');
    
    if (fileInput && fileLabel) {
        // Update label text when file is selected
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                fileLabel.textContent = `Selected: ${file.name}`;
                fileLabel.style.color = 'var(--accent-success)';
                fileLabel.style.borderColor = 'var(--accent-success)';
                
                // Preview the image
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (profileImg) {
                        profileImg.src = e.target.result;
                        profileImg.style.transform = 'scale(1.05)';
                        setTimeout(() => {
                            profileImg.style.transform = 'scale(1)';
                        }, 300);
                    }
                };
                reader.readAsDataURL(file);
            } else {
                fileLabel.textContent = 'Choose Profile Image';
                fileLabel.style.color = '';
                fileLabel.style.borderColor = '';
            }
        });
        
        // Drag and drop functionality
        const dropZone = fileLabel;
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        dropZone.addEventListener('drop', handleDrop, false);
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        function highlight() {
            dropZone.style.borderColor = 'var(--accent-primary)';
            dropZone.style.backgroundColor = 'rgba(99, 102, 241, 0.1)';
            dropZone.textContent = 'Drop image here';
        }
        
        function unhighlight() {
            dropZone.style.borderColor = '';
            dropZone.style.backgroundColor = '';
            if (!fileInput.files[0]) {
                dropZone.textContent = 'Choose Profile Image';
            }
        }
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0 && files[0].type.startsWith('image/')) {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change'));
            }
        }
    }
    
    // Add smooth animations to profile elements
    const profileInfo = document.querySelector('.profile-info');
    const profilePicture = document.querySelector('.profile-picture');
    
    // Stagger animation on load
    if (profileInfo) {
        profileInfo.style.opacity = '0';
        profileInfo.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            profileInfo.style.transition = 'all 0.6s ease-out';
            profileInfo.style.opacity = '1';
            profileInfo.style.transform = 'translateY(0)';
        }, 100);
    }
    
    if (profilePicture) {
        profilePicture.style.opacity = '0';
        profilePicture.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            profilePicture.style.transition = 'all 0.6s ease-out';
            profilePicture.style.opacity = '1';
            profilePicture.style.transform = 'translateY(0)';
        }, 300);
    }
    
    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('button, .navbar a');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
                border-radius: 50%;
                pointer-events: none;
                animation: ripple 0.6s ease-out;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Add CSS for ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            0% {
                transform: scale(0);
                opacity: 1;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
});

// Form validation and feedback
function validateImageUpload(input) {
    const file = input.files[0];
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    
    if (!file) {
        return false;
    }
    
    if (file.size > maxSize) {
        alert('File size must be less than 5MB');
        input.value = '';
        return false;
    }
    
    if (!allowedTypes.includes(file.type)) {
        alert('Please select a valid image file (JPEG, PNG, GIF, or WebP)');
        input.value = '';
        return false;
    }
    
    return true;
}

// Add validation to form
document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.querySelector('form[action*="uploadProfileImage"]');
    const fileInput = document.getElementById('profile_image');
    
    if (uploadForm && fileInput) {
        uploadForm.addEventListener('submit', function(e) {
            if (!validateImageUpload(fileInput)) {
                e.preventDefault();
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.textContent = 'Uploading...';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.7';
            }
        });
    }
});
