<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Page Not Found - HireFlow</title>
	<link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/home.style.css">
	<link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
</head>

<body>
	<div class="container">
		<div class="signin-wrapper">
			<div class="signin-container">
				<div class="text-center mb-4">
					<h1 class="brand-title">Hire<span class="dark">Flow</span></h1>
					<p class="brand-subtitle">Recruitment Management System</p>
				</div>

				<div class="form-container">
					<div class="text-center mb-4">
						<h1 class="form-title mb-2">404 - Page Not Found</h1>
						<p class="text-muted">The page you are looking for doesn't exist, has been moved,
							or is temporarily unavailable.</p>
					</div>

					<div class="text-center mb-4">
						<a href="<?= ROOT ?>" class="btn btn-primary w-full" style="margin-bottom: 12px;">
							Go to Home
						</a>
						<br>
						<a href="javascript:history.back()" class="link link-secondary">
							Go back to previous page
						</a>
					</div>
				</div>

				<div class="signin-footer text-center mt-4">
					<p class="text-muted small">
					    &copy; <?= date('Y') ?> HireFlow. All rights reserved.
					</p>
				</div>
			</div>
		</div>
	</div>

</body>

</html>