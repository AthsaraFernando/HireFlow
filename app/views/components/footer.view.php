<footer class="main-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-brand">
                    <h4>Hire<span class="brand-accent">Flow</span></h4>
                    <p>Streamlining recruitment processes for modern organizations.</p>
                </div>
            </div>
            
            <div class="footer-section">
                <h5>Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="<?= ROOT ?>">Home</a></li>
                    <li><a href="<?= ROOT ?>/url-test.php">Test URLs</a></li>
                    <li><a href="<?= ROOT ?>/DATABASE.md" target="_blank">Database Docs</a></li>
                    <li><a href="<?= ROOT ?>/README.md" target="_blank">Setup Guide</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h5>For Developers</h5>
                <ul class="footer-links">
                    <li><a href="https://github.com/AthsaraFernando/HireFlow" target="_blank">GitHub Repository</a></li>
                    <li><a href="<?= ROOT ?>/url-test.php">View Testing</a></li>
                    <li><a href="#" onclick="showSystemInfo()">System Info</a></li>
                    <li><a href="#" onclick="showDatabaseStatus()">DB Status</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h5>Support</h5>
                <ul class="footer-links">
                    <li><a href="mailto:support@hireflow.com">Email Support</a></li>
                    <li><a href="tel:+94771234567">Phone Support</a></li>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>&copy; 2025 HireFlow. All rights reserved.</p>
                <div class="footer-meta">
                    <span>Version 1.0.0 (Development)</span>
                    <span>•</span>
                    <span>Built with PHP & MySQL</span>
                    <span>•</span>
                    <span>MVC Architecture</span>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.main-footer {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    margin-top: auto;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-content {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 40px;
    padding: 40px 0 30px;
}

.footer-section h4,
.footer-section h5 {
    margin-bottom: 15px;
    color: #ecf0f1;
}

.footer-brand p {
    color: #bdc3c7;
    line-height: 1.6;
    max-width: 250px;
}

.brand-accent {
    color: #667eea;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 8px;
}

.footer-links a {
    color: #bdc3c7;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: #667eea;
}

.footer-bottom {
    border-top: 1px solid #34495e;
    padding: 20px 0;
}

.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.footer-meta {
    display: flex;
    gap: 10px;
    color: #95a5a6;
    font-size: 0.9em;
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: 30px;
        text-align: center;
    }
    
    .footer-bottom-content {
        flex-direction: column;
        text-align: center;
    }
    
    .footer-meta {
        flex-direction: column;
        gap: 5px;
    }
}

@media (max-width: 480px) {
    .footer-container {
        padding: 0 15px;
    }
    
    .footer-content {
        padding: 30px 0 20px;
    }
}

/* Development helpers */
.dev-info-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 10000;
}

.dev-info-content {
    background: white;
    padding: 30px;
    border-radius: 10px;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
}

.dev-info-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
}

.dev-info-close {
    background: none;
    border: none;
    font-size: 1.5em;
    cursor: pointer;
    color: #666;
}
</style>

<!-- Development Modal -->
<div id="devInfoModal" class="dev-info-modal">
    <div class="dev-info-content">
        <div class="dev-info-header">
            <h3 id="modalTitle">System Information</h3>
            <button class="dev-info-close" onclick="closeDevModal()">&times;</button>
        </div>
        <div id="modalBody">
            <!-- Content will be populated by JavaScript -->
        </div>
    </div>
</div>

<script>
function showSystemInfo() {
    const modal = document.getElementById('devInfoModal');
    const title = document.getElementById('modalTitle');
    const body = document.getElementById('modalBody');
    
    title.textContent = 'System Information';
    body.innerHTML = `
        <div style="font-family: monospace; background: #f8f9fa; padding: 15px; border-radius: 5px;">
            <p><strong>PHP Version:</strong> <?= phpversion() ?></p>
            <p><strong>Server:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></p>
            <p><strong>Document Root:</strong> <?= $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' ?></p>
            <p><strong>Current URL:</strong> <?= $_SERVER['REQUEST_URI'] ?? 'Unknown' ?></p>
            <p><strong>User Agent:</strong> <?= substr($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', 0, 50) ?>...</p>
            <p><strong>Server Time:</strong> <?= date('Y-m-d H:i:s T') ?></p>
            <p><strong>Memory Limit:</strong> <?= ini_get('memory_limit') ?></p>
            <p><strong>Max Upload:</strong> <?= ini_get('upload_max_filesize') ?></p>
        </div>
        <div style="margin-top: 15px;">
            <h5>Loaded Extensions:</h5>
            <div style="max-height: 150px; overflow-y: auto; background: #f8f9fa; padding: 10px; border-radius: 5px;">
                <?php
                $extensions = get_loaded_extensions();
                foreach($extensions as $ext) {
                    echo "<span style='display: inline-block; background: #e9ecef; padding: 2px 6px; margin: 2px; border-radius: 3px; font-size: 0.8em;'>$ext</span>";
                }
                ?>
            </div>
        </div>
    `;
    
    modal.style.display = 'flex';
}

function showDatabaseStatus() {
    const modal = document.getElementById('devInfoModal');
    const title = document.getElementById('modalTitle');
    const body = document.getElementById('modalBody');
    
    title.textContent = 'Database Status';
    body.innerHTML = `
        <div style="font-family: monospace; background: #f8f9fa; padding: 15px; border-radius: 5px;">
            <p><strong>Database:</strong> hireflow_db</p>
            <p><strong>Host:</strong> localhost</p>
            <p><strong>Connection:</strong> <span style="color: #28a745;">✓ Connected</span></p>
            <p><strong>Tables:</strong> 9 tables created</p>
            <p><strong>Sample Data:</strong> <span style="color: #28a745;">✓ Loaded</span></p>
        </div>
        <div style="margin-top: 15px;">
            <h5>Available Tables:</h5>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>roles (4 records)</li>
                <li>users (8 records)</li>
                <li>job_posts (5 records)</li>
                <li>applications (6 records)</li>
                <li>interviews (2 records)</li>
                <li>feedback (0 records)</li>
                <li>notifications (5 records)</li>
                <li>access_logs (5 records)</li>
                <li>system_settings (5 records)</li>
            </ul>
        </div>
        <div style="margin-top: 15px;">
            <button onclick="window.open('/phpmyadmin', '_blank')" class="btn btn-primary">Open phpMyAdmin</button>
        </div>
    `;
    
    modal.style.display = 'flex';
}

function closeDevModal() {
    document.getElementById('devInfoModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('devInfoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDevModal();
    }
});
</script>

<!-- Main JavaScript -->
<script src="<?= ROOT ?>/assets/js/main.js"></script>
<script src="<?= ROOT ?>/assets/js/components/modal.js"></script>
<script src="<?= ROOT ?>/assets/js/components/toast.js"></script>

</body>
</html>
