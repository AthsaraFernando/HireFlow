// Job Posting Form JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializeForm();
});

function initializeForm() {
    // Set minimum date to today
    setMinimumDate();
    
    // Initialize form validation
    initializeValidation();
    
    // Initialize character counter
    initializeCharacterCounter();
    
    // Auto-hide alerts
    autoHideAlerts();
}

function setMinimumDate() {
    const deadlineInput = document.getElementById('deadline');
    if (deadlineInput) {
        const today = new Date().toISOString().split('T')[0];
        deadlineInput.min = today;
    }
}

function initializeValidation() {
    const form = document.getElementById('jobForm');
    if (form) {
        form.addEventListener('submit', validateForm);
        
        // Real-time validation
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => validateField(input));
            input.addEventListener('input', () => clearError(input));
        });
    }
}

function validateForm(event) {
    event.preventDefault();
    
    let isValid = true;
    const form = event.target;
    
    // Validate required fields
    const requiredFields = [
        { id: 'title', name: 'Job Title' },
        { id: 'company', name: 'Company' },
        { id: 'location', name: 'Location' },
        { id: 'salary', name: 'Salary' },
        { id: 'department', name: 'Department' },
        { id: 'deadline', name: 'Application Deadline' }
    ];
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field.id);
        if (!validateField(input)) {
            isValid = false;
        }
    });
    
    // Validate description length
    const description = document.getElementById('description');
    if (description && description.value.length < 50) {
        showError('description', 'Job description must be at least 50 characters long');
        isValid = false;
    }
    
    // Validate deadline is in the future
    const deadline = document.getElementById('deadline');
    if (deadline && deadline.value) {
        const selectedDate = new Date(deadline.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (selectedDate < today) {
            showError('deadline', 'Deadline must be in the future');
            isValid = false;
        }
    }
    
    if (isValid) {
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Job...';
        submitBtn.disabled = true;
        
        // Submit the form
        form.submit();
    } else {
        // Scroll to first error
        const firstError = document.querySelector('.error-message[style*="block"]');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
}

function validateField(input) {
    const value = input.value.trim();
    const fieldName = input.previousElementSibling.textContent.replace(' *', '');
    
    // Clear previous error
    clearError(input);
    
    // Check if required field is empty
    if (input.hasAttribute('required') && !value) {
        showError(input.id, `${fieldName} is required`);
        return false;
    }
    
    // Specific field validations
    switch (input.id) {
        case 'title':
            if (value.length < 3) {
                showError(input.id, 'Job title must be at least 3 characters long');
                return false;
            }
            break;
            
        case 'salary':
            if (!/^\d+(\.\d{2})?\s*(LKR|USD|EUR|GBP)?$/i.test(value)) {
                showError(input.id, 'Please enter a valid salary format (e.g., 50000 LKR)');
                return false;
            }
            break;
            
        case 'deadline':
            if (value) {
                const selectedDate = new Date(value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                if (selectedDate < today) {
                    showError(input.id, 'Deadline must be in the future');
                    return false;
                }
                
                // Check if deadline is too far in the future (1 year)
                const oneYearFromNow = new Date();
                oneYearFromNow.setFullYear(oneYearFromNow.getFullYear() + 1);
                
                if (selectedDate > oneYearFromNow) {
                    showError(input.id, 'Deadline cannot be more than 1 year from now');
                    return false;
                }
            }
            break;
    }
    
    return true;
}

function showError(fieldId, message) {
    const errorElement = document.getElementById(fieldId + 'Error');
    const inputElement = document.getElementById(fieldId);
    
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
    
    if (inputElement) {
        inputElement.style.borderColor = '#dc2626';
    }
}

function clearError(input) {
    const errorElement = document.getElementById(input.id + 'Error');
    
    if (errorElement) {
        errorElement.style.display = 'none';
    }
    
    input.style.borderColor = '#e5e7eb';
}

function initializeCharacterCounter() {
    const description = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    
    if (description && charCount) {
        description.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            // Update color based on requirement
            if (count < 50) {
                charCount.style.color = '#dc2626';
            } else {
                charCount.style.color = '#10b981';
            }
        });
    }
}

// Auto-hide alerts
function autoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
}

// Form auto-save functionality (optional)
function initializeAutoSave() {
    const form = document.getElementById('jobForm');
    if (!form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('input', debounce(saveFormData, 1000));
    });
    
    // Load saved data on page load
    loadFormData();
}

function saveFormData() {
    const form = document.getElementById('jobForm');
    const formData = new FormData(form);
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    localStorage.setItem('jobFormData', JSON.stringify(data));
}

function loadFormData() {
    const savedData = localStorage.getItem('jobFormData');
    if (!savedData) return;
    
    const data = JSON.parse(savedData);
    
    Object.keys(data).forEach(key => {
        const input = document.getElementById(key);
        if (input) {
            input.value = data[key];
        }
    });
}

function clearFormData() {
    localStorage.removeItem('jobFormData');
}

// Utility function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Clear saved data when form is successfully submitted
document.addEventListener('beforeunload', function() {
    // Only clear if form was successfully submitted
    if (document.querySelector('.alert-success')) {
        clearFormData();
    }
});
