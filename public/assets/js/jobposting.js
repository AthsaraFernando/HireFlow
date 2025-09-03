// Job Posting Management JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializeJobPosting();
});

function initializeJobPosting() {
    // Initialize search functionality
    initializeSearch();
    
    // Initialize filters
    initializeFilters();
    
    // Auto-hide alerts
    autoHideAlerts();
}

// Search functionality
function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(performSearch, 300));
    }
}

function performSearch() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const tableRows = document.querySelectorAll('#jobTableBody tr');
    
    tableRows.forEach(row => {
        if (row.querySelector('.no-data-message')) return;
        
        const title = row.querySelector('.job-title strong')?.textContent.toLowerCase() || '';
        const company = row.cells[1]?.textContent.toLowerCase() || '';
        const location = row.cells[2]?.textContent.toLowerCase() || '';
        const department = row.querySelector('.job-title small')?.textContent.toLowerCase() || '';
        
        const matches = title.includes(searchTerm) || 
                       company.includes(searchTerm) || 
                       location.includes(searchTerm) || 
                       department.includes(searchTerm);
        
        row.style.display = matches ? '' : 'none';
    });
    
    updateNoResultsMessage();
}

// Filter functionality
function initializeFilters() {
    const statusFilter = document.getElementById('statusFilter');
    const sortBy = document.getElementById('sortBy');
    
    if (statusFilter) {
        statusFilter.addEventListener('change', applyFilters);
    }
    
    if (sortBy) {
        sortBy.addEventListener('change', applySorting);
    }
}

function applyFilters() {
    const statusFilter = document.getElementById('statusFilter').value;
    const tableRows = document.querySelectorAll('#jobTableBody tr');
    
    tableRows.forEach(row => {
        if (row.querySelector('.no-data-message')) return;
        
        const statusBadge = row.querySelector('.status-badge');
        if (!statusBadge) return;
        
        const rowStatus = statusBadge.textContent.trim();
        
        if (statusFilter === '' || rowStatus === statusFilter) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    updateNoResultsMessage();
}

function applySorting() {
    const sortBy = document.getElementById('sortBy').value;
    const tableBody = document.getElementById('jobTableBody');
    const rows = Array.from(tableBody.querySelectorAll('tr')).filter(row => 
        !row.querySelector('.no-data-message')
    );
    
    rows.sort((a, b) => {
        let aValue, bValue;
        
        switch (sortBy) {
            case 'title':
                aValue = a.querySelector('.job-title strong')?.textContent || '';
                bValue = b.querySelector('.job-title strong')?.textContent || '';
                return aValue.localeCompare(bValue);
                
            case 'deadline':
                aValue = a.cells[4]?.textContent.trim() || '';
                bValue = b.cells[4]?.textContent.trim() || '';
                return new Date(aValue) - new Date(bValue);
                
            case 'created_at':
            default:
                // For created_at, we'll use the row order as proxy
                return 0;
        }
    });
    
    // Re-append sorted rows
    rows.forEach(row => tableBody.appendChild(row));
}

function updateNoResultsMessage() {
    const tableBody = document.getElementById('jobTableBody');
    const visibleRows = Array.from(tableBody.querySelectorAll('tr')).filter(row => 
        row.style.display !== 'none' && !row.querySelector('.no-data-message')
    );
    
    let noResultsRow = tableBody.querySelector('.no-results-row');
    
    if (visibleRows.length === 0) {
        if (!noResultsRow) {
            noResultsRow = document.createElement('tr');
            noResultsRow.className = 'no-results-row';
            noResultsRow.innerHTML = `
                <td colspan="7" class="no-data">
                    <div class="no-data-message">
                        <i class="fas fa-search"></i>
                        <h3>No Results Found</h3>
                        <p>Try adjusting your search criteria or filters</p>
                    </div>
                </td>
            `;
            tableBody.appendChild(noResultsRow);
        }
    } else {
        if (noResultsRow) {
            noResultsRow.remove();
        }
    }
}

// Job actions
function editJob(jobId) {
    window.location.href = `${ROOT}/hradmin/jobposting/edit/${jobId}`;
}

function deleteJob(jobId) {
    if (confirm('Are you sure you want to delete this job posting? This action cannot be undone.')) {
        // Show loading state
        const deleteBtn = event.target.closest('button');
        const originalText = deleteBtn.innerHTML;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
        deleteBtn.disabled = true;
        
        // Redirect to delete endpoint
        window.location.href = `${ROOT}/hradmin/jobposting/delete/${jobId}`;
    }
}

// Utility functions
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

// Add slideOut animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
