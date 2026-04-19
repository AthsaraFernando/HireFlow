# Applicant Change Guide (Copy)

This version includes practical, easy-to-follow edit steps with real code examples.

## Example 1: Make work_experience.job_title optional

### What this means
You want applicants to be able to submit the form even when `Job Title` is empty.

### Which change path to use
1. Existing forms only: change DB row in `application_form_fields`.
2. Future newly created forms too: also change the model template in `ApplicationFormField.php`.

### Recommended minimum change (usually enough)
1. Run the SQL update for `job_title` in `application_form_fields`.
2. Verify DB values changed (`is_required = 0`, `validation_rules` no `required`).
3. Test the apply form by leaving `job_title` empty and submitting.

### When you must also edit code
1. Edit model template if you want all future generated forms to use optional `job_title` by default.
2. Edit controller only if there is a special hardcoded rule for `job_title` (normally not needed here).
3. Edit view only if there is a manual override forcing required (normally not needed here).

### Files to edit
- app/models/ApplicationFormField.php (for future forms)
- app/controllers/applicant/ApplyJob.php (only if custom hardcoded validation exists)
- app/views/applicant/apply.view.php (only if custom hardcoded required exists)

### SQL
```sql
UPDATE application_form_fields
SET is_required = 0,
  validation_rules = 'max:200'
WHERE field_name = 'job_title';
```

### Important note before running SQL
If you want to limit this change to one form only, include `form_id`:

```sql
UPDATE application_form_fields
SET is_required = 0,
  validation_rules = 'max:200'
WHERE form_id = 1
  AND field_name = 'job_title';
```

Without `form_id`, it updates all `job_title` rows across forms.

### DB verification query
```sql
SELECT field_name, is_required, validation_rules
FROM application_form_fields
WHERE field_name = 'job_title';
```

Expected after change:
1. `is_required` should be `0`.
2. `validation_rules` should not contain `required`.

### Model old (app/models/ApplicationFormField.php)
```php
[
  'name' => 'job_title',
  'label' => 'Job Title',
  'type' => 'text',
  'required' => true,
  'placeholder' => 'Ex: Senior Software Engineer',
  'validation' => 'required|max:200'
],
```

### Model new (example)
```php
[
  'name' => 'job_title',
  'label' => 'Job Title',
  'type' => 'text',
  'required' => false,
  'placeholder' => 'Ex: Senior Software Engineer',
  'validation' => 'max:200'
],
```

### Controller old (app/controllers/applicant/ApplyJob.php)
```php
if ($is_required && ($value === null || $value === '')) {
  $validation_errors[] = $field_label . " is required.";
  continue;
}
```

### Controller new (example)
```php
if ($field_name === 'job_title') {
  // optional now
} elseif ($is_required && ($value === null || $value === '')) {
  $validation_errors[] = $field_label . " is required.";
  continue;
}
```

Use this controller change only if your project has extra hardcoded logic for `job_title`.
For this HireFlow flow, DB-driven `is_required` is usually enough.

### View old (app/views/applicant/apply.view.php)
```php
$required = (int)$field['is_required'] === 1;
...
<?= $required ? 'required' : '' ?>
```

### View new (example)
```php
$required = (int)$field['is_required'] === 1;
if ($fname === 'job_title') { $required = false; }
...
<?= $required ? 'required' : '' ?>
```

Use this view override only if needed. In this project, view already reads `is_required` dynamically.

### Quick test
1. Open an applicant apply page for a form where `job_title` exists.
2. Leave `job_title` empty.
3. Fill other required fields.
4. Submit.
5. Confirm no `Job Title is required` error appears.
6. Confirm application is saved.

## Example 2: Prevent future start_date

### Exact steps
1. Update validation rule in DB and model definition.
2. Add controller-side guard for `start_date > today`.
3. Add `max` attribute in view input for browser-side prevention.
4. Keep both server-side and client-side checks.

### Files to edit
- app/models/ApplicationFormField.php
- app/controllers/applicant/ApplyJob.php
- app/views/applicant/apply.view.php

### SQL
```sql
UPDATE application_form_fields
SET validation_rules = 'required|date|before_or_equal:today'
WHERE field_name = 'start_date';
```

### DB verification query
```sql
SELECT field_name, validation_rules
FROM application_form_fields
WHERE field_name = 'start_date';
```

### Model old (app/models/ApplicationFormField.php)
```php
[
  'name' => 'start_date',
  'label' => 'Start Date',
  'type' => 'date',
  'required' => true,
  'validation' => 'required|date'
],
```

### Model new (example)
```php
[
  'name' => 'start_date',
  'label' => 'Start Date',
  'type' => 'date',
  'required' => true,
  'validation' => 'required|date|before_or_equal:today'
],
```

### Controller old (app/controllers/applicant/ApplyJob.php)
```php
$responses[$field_name] = $value;
```

### Controller new (example)
```php
if ($field_name === 'start_date' && !empty($value) && $value > date('Y-m-d')) {
  $validation_errors[] = "Start Date cannot be in the future.";
  continue;
}
$responses[$field_name] = $value;
```

### View old (app/views/applicant/apply.view.php)
```php
<input
  type="<?= esc($ftype) ?>"
  id="field_<?= esc($fname) ?>"
  name="form_fields[<?= esc($fname) ?>]"
  class="form-input"
  value="<?= esc($prefillValue) ?>"
  placeholder="<?= esc($field['placeholder'] ?? '') ?>"
  <?= $required ? 'required' : '' ?>
>
```

### View new (example)
```php
<input
  type="<?= esc($ftype) ?>"
  id="field_<?= esc($fname) ?>"
  name="form_fields[<?= esc($fname) ?>]"
  class="form-input"
  value="<?= esc($prefillValue) ?>"
  placeholder="<?= esc($field['placeholder'] ?? '') ?>"
  <?= ($fname === 'start_date') ? 'max="' . date('Y-m-d') . '"' : '' ?>
  <?= $required ? 'required' : '' ?>
>
```

### Quick test
1. Try selecting a future date.
2. Confirm browser blocks it.
3. Submit manually with a crafted future date request and confirm controller rejects it.

## Example 3: Move work_experience section before education

### Exact steps
1. No DB change needed.
2. Update category order array in the apply controller.
3. If edit page has its own ordering logic, align it too.

### Files to edit
- app/controllers/applicant/ApplyJob.php
- app/views/applicant/edit-application.view.php (only if it has separate ordering logic)

### SQL
```sql
-- no DB schema change
```

### Controller old (app/controllers/applicant/ApplyJob.php)
```php
$category_order = [
  'personal_info',
  'education',
  'work_experience',
  'skills',
  'documents',
  'availability',
  'declarations',
  'additional_info'
];
```

### Controller new (example)
```php
$category_order = [
  'personal_info',
  'work_experience',
  'education',
  'skills',
  'documents',
  'availability',
  'declarations',
  'additional_info'
];
```

### Quick test
1. Load apply page for a job that has both sections.
2. Confirm `Work Experience` appears before `Education`.

## Example 4: Add emergency_contact_name field

### Exact steps
1. Add new row in `application_form_fields` for a target form.
2. Add new field definition in `ApplicationFormField::getAvailableFields()` so future forms can select it.
3. Do not add custom controller/view code unless behavior is special.

### Files to edit
- app/models/ApplicationFormField.php
- app/controllers/applicant/ApplyJob.php (optional)
- app/views/applicant/apply.view.php (optional)

### SQL
```sql
INSERT INTO application_form_fields
  (form_id, field_category, field_name, field_label, field_type, field_options, is_required, is_enabled, field_order, validation_rules, placeholder, help_text)
VALUES
  (1, 'personal_info', 'emergency_contact_name', 'Emergency Contact Name', 'text', NULL, 1, 1, 99, 'required|max:100', 'Enter emergency contact name', NULL);
```

### DB verification query
```sql
SELECT form_id, field_category, field_name, field_label, field_type, is_required
FROM application_form_fields
WHERE field_name = 'emergency_contact_name';
```

### Model new (example in app/models/ApplicationFormField.php)
```php
[
  'name' => 'emergency_contact_name',
  'label' => 'Emergency Contact Name',
  'type' => 'text',
  'required' => true,
  'placeholder' => 'Enter emergency contact name',
  'validation' => 'required|max:100'
],
```

### Controller old+new (app/controllers/applicant/ApplyJob.php)
```php
// no special change needed for normal text fields (already dynamic)
```

### View old+new (app/views/applicant/apply.view.php)
```php
// no special change needed for normal text fields (already dynamic)
```

### Quick test
1. Open job apply page for the target form.
2. Confirm `Emergency Contact Name` field appears.
3. Submit with empty value and confirm required behavior works.

## Example 5: Add new personal information field on applicant profile page (`gender` as text input)

### What this does
Adds a `gender` text field in Applicant Profile -> Personal Information and saves it in `users.gender`.

### Exact steps
1. Add `gender` column in `users` table.
2. Add `gender` to `form_values` in `Profile::index()`.
3. Add `gender` to update payload in `Profile::update()`.
4. Add a text input for `gender` in profile personal info view.
5. Optionally add model validation in `User::validateProfileUpdate()`.

### Files to edit
- app/controllers/applicant/Profile.php
- app/views/applicant/profile.view.php
- app/models/User.php (optional validation)

### SQL
```sql
ALTER TABLE users
ADD COLUMN gender VARCHAR(50) NULL AFTER address;
```

### DB verification query
```sql
SHOW COLUMNS FROM users LIKE 'gender';
```

### Controller old (app/controllers/applicant/Profile.php)
```php
$data['form_values'] = [
  'full_name' => $current_user['full_name'] ?? '',
  'email' => $current_user['email'] ?? '',
  'phone' => $current_user['phone'] ?? '',
  'address' => $current_user['address'] ?? ''
];
```

### Controller new (example)
```php
$data['form_values'] = [
  'full_name' => $current_user['full_name'] ?? '',
  'email' => $current_user['email'] ?? '',
  'phone' => $current_user['phone'] ?? '',
  'address' => $current_user['address'] ?? '',
  'gender' => $current_user['gender'] ?? ''
];
```

### Controller old (update payload)
```php
$data = [
  'full_name' => trim($_POST['full_name'] ?? ''),
  'email' => strtolower(trim($_POST['email'] ?? '')),
  'phone' => trim($_POST['phone'] ?? ''),
  'address' => trim($_POST['address'] ?? '')
];
```

### Controller new (example)
```php
$data = [
  'full_name' => trim($_POST['full_name'] ?? ''),
  'email' => strtolower(trim($_POST['email'] ?? '')),
  'phone' => trim($_POST['phone'] ?? ''),
  'address' => trim($_POST['address'] ?? ''),
  'gender' => trim($_POST['gender'] ?? '')
];
```

### View old (app/views/applicant/profile.view.php)
```php
<div class="form-group">
  <label for="phone" class="form-label">Phone Number</label>
  <input type="tel" id="phone" name="phone" class="form-input" value="<?= esc($form_values['phone'] ?? '') ?>">
</div>
```

### View new (example)
```php
<div class="form-group">
  <label for="phone" class="form-label">Phone Number</label>
  <input type="tel" id="phone" name="phone" class="form-input" value="<?= esc($form_values['phone'] ?? '') ?>">
</div>
<div class="form-group">
  <label for="gender" class="form-label">Gender</label>
  <input type="text" id="gender" name="gender" class="form-input" value="<?= esc($form_values['gender'] ?? '') ?>">
</div>
```

### Optional model validation example (app/models/User.php)
```php
if (!empty($data['gender']) && strlen($data['gender']) > 50) {
  $this->errors['gender'] = "Gender must be 50 characters or less";
}
```

### Quick test
1. Open `applicant/profile`.
2. Enter gender value and submit personal info.
3. Refresh page and confirm value is retained.

## Example 6: Make a personal information field required (example: `phone` in profile page)

### What this does
Makes `phone` mandatory in profile personal info update.

### Exact steps
1. Add `required` attribute in profile view input.
2. Add model validation in `User::validateProfileUpdate()` for empty phone.
3. Optionally enforce DB-level `NOT NULL` if business rule must be strict.

### Files to edit
- app/views/applicant/profile.view.php
- app/models/User.php
- database (optional strict enforcement)

### SQL (optional strict DB rule)
```sql
ALTER TABLE users
MODIFY phone VARCHAR(20) NOT NULL;
```

### View old (app/views/applicant/profile.view.php)
```php
<input type="tel" id="phone" name="phone" class="form-input" value="<?= esc($form_values['phone'] ?? '') ?>">
```

### View new (example)
```php
<input type="tel" id="phone" name="phone" class="form-input" value="<?= esc($form_values['phone'] ?? '') ?>" required>
```

### Model old (app/models/User.php)
```php
if (!empty($data['phone']) && !preg_match('/^[\+]?[1-9][\d]{0,15}$/', $data['phone'])) {
  $this->errors['phone'] = "Please enter a valid phone number";
}
```

### Model new (example)
```php
if (empty($data['phone'])) {
  $this->errors['phone'] = "Phone is required";
} elseif (!preg_match('/^[\+]?[1-9][\d]{0,15}$/', $data['phone'])) {
  $this->errors['phone'] = "Please enter a valid phone number";
}
```

### Quick test
1. Open `applicant/profile`.
2. Clear phone field and submit.
3. Confirm validation error appears.
4. Enter valid phone and submit again.
5. Confirm update succeeds.

---

## Hacks & Strategies: Trace View -> Controller -> Model Fast

Use this when you know the page URL, but not the connected controller/model.

### 1) Start from URL path
1. Remove domain/root. Example: `/applicant/applications/apply?job_id=17`.
2. Convert route to likely controller path. Example guess: `app/controllers/applicant/ApplyJob.php`.
3. Open controller and find the `view(...)` call.

### 2) From view, find controller immediately
1. In the view, search the `<form action="...">` target.
2. Track the route in that action to a controller method.
3. In controller, find where `$data` is built and passed to `view(...)`.

### 3) From controller, find model links
1. Search for `new Something()` inside the controller method.
2. Each `new ModelName()` maps to a file in `app/models/ModelName.php`.
3. Follow method calls like `getFormWithFields`, `submitApplication`, `where`, `insert`, `update`.

### 4) High-value search terms
Use ripgrep quickly from project root:

```bash
rg "view\('applicant/apply'|view\(\"applicant/apply\"" app/controllers
rg "form_fields|is_required|validation_rules|start_date|job_title" app/controllers app/models app/views
rg "new ApplicationFormField|new ApplicationForm|new Application" app/controllers
rg "function index|function processJobApplication" app/controllers/applicant/ApplyJob.php
```

### 5) Reliable call-chain method
1. URL -> controller file/method.
2. Controller method -> `view('...')` to identify template.
3. Same controller method -> model objects and model methods.
4. Model methods -> SQL/query behavior.
5. Return to view -> confirm field names match controller keys.

### 6) For required-field changes specifically
1. Check view for required marker: `$required` and `required` attribute.
2. Check controller for server-side guard: `if ($is_required && ...)`.
3. Check model/DB source of required truth: `is_required`, `validation_rules`.
4. If all three align, the change is stable.

### 7) Debug shortcut when unsure
Add temporary logs in controller right before submit:

```php
error_log('Field: ' . $field_name . ' required=' . (int)$is_required . ' value=' . print_r($value, true));
```

Then remove log lines after verification.
