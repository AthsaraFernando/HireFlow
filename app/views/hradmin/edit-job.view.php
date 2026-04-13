<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Edit Job Post</h1>
        <p class="page-description">Update job posting details and requirements</p>
        <div class="action-buttons">
            <a href="<?= ROOT ?>/hradmin/job-posts" class="btn btn-secondary">
                <i class="icon-back"></i>Back to Job Posts
            </a>
            <a href="<?= ROOT ?>/hradmin/view-job/<?= $job['id'] ?>" class="btn btn-outline">
                <i class="icon-eye"></i>Preview
            </a>
        </div>
    </div>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <?php $this->view('hradmin/partials/edit-job-form', $data); ?>
    </div>
</div>

<?php $this->view('components/footer') ?>