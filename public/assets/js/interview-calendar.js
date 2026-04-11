/**
 * Enhanced Interview Calendar JavaScript
 * Provides interactive calendar functionality with CSS Grid layout
 */

class InterviewCalendar {
    constructor() {
        this.interviews = [];
        this.currentWeekStart = null;
        this.currentInterviewId = null;
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadInterviewData();
    }

    bindEvents() {
        // Modal close events
        const modal = document.getElementById('interviewModal');
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.closeModal();
                }
            });
        }

        const closeBtn = modal.querySelector('.modal-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.closeModal());
        }

        // View toggle events
        document.querySelectorAll('.view-toggle').forEach(button => {
            button.addEventListener('click', (e) => this.handleViewToggle(e));
        });

        // Sidebar toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => this.toggleSidebar());
        }

        // Keyboard events
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeModal();
            }
        });
    }

    loadInterviewData() {
        // Get interviews data from PHP (passed via global variable)
        if (window.interviewsData) {
            this.interviews = window.interviewsData;
            this.renderCalendar();
        }
    }

    renderCalendar() {
        // Clear existing interview blocks
        document.querySelectorAll('.interview-block').forEach(block => {
            block.remove();
        });

        // Render each interview
        this.interviews.forEach(interview => {
            this.renderInterviewBlock(interview);
        });
    }

    renderInterviewBlock(interview) {
        const dayColumn = document.querySelector(`.day-column[data-date="${interview.scheduledDate}"] .day-content`);
        
        if (!dayColumn) return;

        const interviewBlock = document.createElement('div');
        const stageClass = this.getStageClass(interview.interviewStage);
        
        interviewBlock.className = `interview-block ${stageClass}`;
        interviewBlock.dataset.interviewId = interview.id;

        // Calculate position and size
        const { topPosition, height } = this.calculateBlockPosition(interview);
        
        interviewBlock.style.top = `${topPosition}px`;
        interviewBlock.style.height = `${height}px`;
        
        // Set content
        const timeDisplay = this.formatTime(interview.scheduledTime);
        interviewBlock.innerHTML = `
            <div class="interview-time">${timeDisplay}</div>
            <div class="interview-candidate">${this.escapeHtml(interview.candidateName)}</div>
            <div class="interview-position">${this.escapeHtml(interview.jobTitle)}</div>
        `;

        // Add click event
        interviewBlock.addEventListener('click', () => {
            this.showInterviewDetails(interview);
        });

        // Add hover effects
        interviewBlock.addEventListener('mouseenter', () => {
            this.showQuickPreview(interview, interviewBlock);
        });

        dayColumn.appendChild(interviewBlock);
    }

    calculateBlockPosition(interview) {
        const [hours, minutes] = interview.scheduledTime.split(':').map(Number);
        
        // Each hour slot is 50px, starting from 8 AM
        const topPosition = ((hours - 8) * 50) + (minutes * 50 / 60);
        const height = Math.max(40, (interview.duration * 50 / 60));
        
        return { topPosition: Math.max(0, topPosition), height };
    }

    getStageClass(stage) {
        const stageClasses = {
            'Screening': 'screening',
            'Technical': 'technical', 
            'Managerial': 'managerial',
            'HR Review': 'hr-review',
            'Final': 'final'
        };
        return stageClasses[stage] || 'screening';
    }

    showInterviewDetails(interview) {
        this.currentInterviewId = interview.id;
        const modal = document.getElementById('interviewModal');
        const modalBody = document.getElementById('modalBody');
        
        if (!modal || !modalBody) return;

        const timeRange = this.getTimeRange(interview.scheduledTime, interview.duration);
        
        modalBody.innerHTML = this.generateModalContent(interview, timeRange);
        
        // Store interview data on modal for action buttons
        modal.dataset.interviewId = interview.id;
        
        // Show modal with animation
        modal.classList.add('show');
        
        // Focus management for accessibility
        setTimeout(() => {
            const closeButton = modal.querySelector('.modal-close');
            if (closeButton) closeButton.focus();
        }, 100);
    }

    generateModalContent(interview, timeRange) {
        return `
            <div class="interview-detail-grid">
                <div class="detail-group">
                    <div class="detail-label">Candidate</div>
                    <div class="detail-value">${this.escapeHtml(interview.candidateName)}</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Position</div>
                    <div class="detail-value">${this.escapeHtml(interview.jobTitle)}</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Date & Time</div>
                    <div class="detail-value">
                        ${this.formatDate(interview.scheduledDate)}<br>
                        <strong>${timeRange}</strong>
                    </div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Interview Type</div>
                    <div class="detail-value">${this.escapeHtml(interview.interviewType)}</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Interview Stage</div>
                    <div class="detail-value">
                        <span class="stage-badge ${this.getStageClass(interview.interviewStage)}">
                            ${this.escapeHtml(interview.interviewStage)}
                        </span>
                    </div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Interviewer</div>
                    <div class="detail-value">${this.escapeHtml(interview.interviewerName)}</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="status-badge ${interview.status.toLowerCase()}">
                            ${this.escapeHtml(interview.status)}
                        </span>
                    </div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Duration</div>
                    <div class="detail-value">${interview.duration} minutes</div>
                </div>
            </div>
            
            <div class="contact-section">
                <h4>Contact Information</h4>
                <div class="contact-grid">
                    <p><strong>Email:</strong> 
                        <a href="mailto:${interview.candidateEmail}">${this.escapeHtml(interview.candidateEmail)}</a>
                    </p>
                    <p><strong>Phone:</strong> 
                        <a href="tel:${interview.candidatePhone}">${this.escapeHtml(interview.candidatePhone)}</a>
                    </p>
                    ${interview.interviewerEmail ? `
                        <p><strong>Interviewer Email:</strong> 
                            <a href="mailto:${interview.interviewerEmail}">${this.escapeHtml(interview.interviewerEmail)}</a>
                        </p>
                    ` : ''}
                </div>
            </div>

            ${interview.location ? `
                <div class="location-section">
                    <h4>Location</h4>
                    <p>${this.escapeHtml(interview.location)}</p>
                </div>
            ` : ''}

            ${interview.meetingLink ? `
                <div class="meeting-section">
                    <h4>Meeting Link</h4>
                    <a href="${interview.meetingLink}" target="_blank" class="meeting-link">
                        📹 Join Meeting
                    </a>
                </div>
            ` : ''}

            ${interview.notes ? `
                <div class="notes-section">
                    <h4>Notes</h4>
                    <p>${this.escapeHtml(interview.notes)}</p>
                </div>
            ` : ''}
        `;
    }

    closeModal() {
        const modal = document.getElementById('interviewModal');
        if (modal) {
            modal.classList.remove('show');
            this.currentInterviewId = null;
        }
    }

    showQuickPreview(interview, element) {
        // Create a tooltip-style preview
        const tooltip = document.createElement('div');
        tooltip.className = 'interview-tooltip';
        tooltip.innerHTML = `
            <strong>${interview.candidateName}</strong><br>
            ${interview.jobTitle}<br>
            ${this.formatTime(interview.scheduledTime)} - ${this.getEndTime(interview.scheduledTime, interview.duration)}<br>
            <em>${interview.interviewStage}</em>
        `;
        
        document.body.appendChild(tooltip);
        
        // Position tooltip
        const rect = element.getBoundingClientRect();
        tooltip.style.position = 'absolute';
        tooltip.style.left = `${rect.right + 10}px`;
        tooltip.style.top = `${rect.top}px`;
        tooltip.style.zIndex = '1001';
        
        // Remove tooltip on mouse leave
        element.addEventListener('mouseleave', () => {
            if (tooltip.parentNode) {
                tooltip.remove();
            }
        }, { once: true });
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            if (tooltip.parentNode) {
                tooltip.remove();
            }
        }, 3000);
    }

    formatTime(timeString) {
        const [hours, minutes] = timeString.split(':').map(Number);
        const hour12 = hours === 0 ? 12 : hours > 12 ? hours - 12 : hours;
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const paddedHour = hour12.toString();
        const paddedMinutes = minutes.toString().padStart(2, '0');
        
        return `${paddedHour}:${paddedMinutes} ${ampm}`;
    }

    getEndTime(startTime, duration) {
        const [hours, minutes] = startTime.split(':').map(Number);
        const totalMinutes = hours * 60 + minutes + duration;
        const endHours = Math.floor(totalMinutes / 60);
        const endMinutes = totalMinutes % 60;
        
        const endTimeString = `${endHours.toString().padStart(2, '0')}:${endMinutes.toString().padStart(2, '0')}`;
        return this.formatTime(endTimeString);
    }

    getTimeRange(startTime, duration) {
        return `${this.formatTime(startTime)} - ${this.getEndTime(startTime, duration)}`;
    }

    formatDate(dateString) {
        return new Date(dateString + 'T00:00:00').toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    handleViewToggle(e) {
        document.querySelectorAll('.view-toggle').forEach(btn => btn.classList.remove('active'));
        e.target.classList.add('active');
        
        const view = e.target.dataset.view;
        
        if (view === 'day') {
            this.switchToDayView();
        } else if (view === 'week') {
            this.switchToWeekView();
        }
    }

    switchToDayView() {
        // Hide all day columns except today or selected day
        const today = new Date().toISOString().split('T')[0];
        document.querySelectorAll('.day-column').forEach((column, index) => {
            if (column.dataset.date === today || index === 0) {
                column.style.display = 'block';
            } else {
                column.style.display = 'none';
            }
        });
        
        // Adjust grid template
        document.querySelector('.calendar-grid').style.gridTemplateColumns = '80px 1fr';
    }

    switchToWeekView() {
        // Show all day columns
        document.querySelectorAll('.day-column').forEach(column => {
            column.style.display = 'block';
        });
        
        // Reset grid template
        document.querySelector('.calendar-grid').style.gridTemplateColumns = '80px repeat(7, 1fr)';
    }

    toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('collapsed');
        document.querySelector('.main-content').classList.toggle('expanded');
    }

    // Public methods for global access
    navigateWeek(direction) {
        const currentDate = new Date(this.currentWeekStart || new Date());
        currentDate.setDate(currentDate.getDate() + (direction * 7));
        const newWeekStart = currentDate.toISOString().split('T')[0];
        
        window.location.href = `${window.ROOT}/hradmin/interview-schedule?week_start=${newWeekStart}`;
    }

    goToToday() {
        window.location.href = `${window.ROOT}/hradmin/interview-schedule`;
    }

    scheduleNewInterview() {
        // You can implement a modal for scheduling or redirect to a form page
        window.location.href = `${window.ROOT}/hradmin/interview-schedule/schedule`;
    }

    editInterview() {
        if (this.currentInterviewId) {
            window.location.href = `${window.ROOT}/hradmin/interview-schedule/edit/${this.currentInterviewId}`;
        }
    }

    cancelInterview() {
        if (this.currentInterviewId && confirm('Are you sure you want to cancel this interview?')) {
            // Make AJAX request to cancel interview
            fetch(`${window.ROOT}/hradmin/interview-schedule/cancel/${this.currentInterviewId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.closeModal();
                    location.reload();
                } else {
                    alert('Failed to cancel interview. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    }

    joinInterview() {
        if (this.currentInterviewId) {
            const interview = this.interviews.find(i => i.id == this.currentInterviewId);
            if (interview && interview.meetingLink) {
                window.open(interview.meetingLink, '_blank');
            } else {
                alert('No meeting link available for this interview.');
            }
        }
    }
}

// Initialize calendar when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.interviewCalendar = new InterviewCalendar();
    
    // Set current week start for navigation
    if (window.currentWeekStart) {
        window.interviewCalendar.currentWeekStart = window.currentWeekStart;
    }
});

// Global functions for HTML onclick events
function navigateWeek(direction) {
    if (window.interviewCalendar) {
        window.interviewCalendar.navigateWeek(direction);
    }
}

function goToToday() {
    if (window.interviewCalendar) {
        window.interviewCalendar.goToToday();
    }
}

function scheduleNewInterview() {
    if (window.interviewCalendar) {
        window.interviewCalendar.scheduleNewInterview();
    }
}

function editInterview() {
    if (window.interviewCalendar) {
        window.interviewCalendar.editInterview();
    }
}

function cancelInterview() {
    if (window.interviewCalendar) {
        window.interviewCalendar.cancelInterview();
    }
}

function joinInterview() {
    if (window.interviewCalendar) {
        window.interviewCalendar.joinInterview();
    }
}

function closeInterviewModal() {
    if (window.interviewCalendar) {
        window.interviewCalendar.closeModal();
    }
}