
-- make work_experience.job_title optional

-- SQL 
UPDATE application_form_fields
SET is_required = 0,
  validation_rules = 'max:200'
WHERE field_name = 'job_title';

 MODEL OLD (app/models/ApplicationFormField.php)
[
  'name' => 'job_title',
  'label' => 'Job Title',
  'type' => 'text',
  'required' => true,
  'placeholder' => 'Ex: Senior Software Engineer',
  'validation' => 'required|max:200'
],


 MODEL NEW (example)
[
  'name' => 'job_title',
  'label' => 'Job Title',
  'type' => 'text',
  'required' => false,
  'placeholder' => 'Ex: Senior Software Engineer',
  'validation' => 'max:200'
],


CONTROLLER OLD (app/controllers/applicant/ApplyJob.php)
if ($is_required && ($value === null || $value === '')) {
  $validation_errors[] = $field_label . " is required.";
  continue;
}


CONTROLLER NEW (example)
if ($field_name === 'job_title') {
  // optional now
} elseif ($is_required && ($value === null || $value === '')) {
  $validation_errors[] = $field_label . " is required.";
  continue;
}


 VIEW OLD (app/views/applicant/apply.view.php)
$required = (int)$field['is_required'] === 1;
...
<?= $required ? 'required' : '' ?>


VIEW NEW (example)
$required = (int)$field['is_required'] === 1;
if ($fname === 'job_title') { $required = false; }
...
<?= $required ? 'required' : '' ?>


-- prevent future start_date

-- SQL 
UPDATE application_form_fields
SET validation_rules = 'required|date|before_or_equal:today'
WHERE field_name = 'start_date';

 MODEL OLD (app/models/ApplicationFormField.php)
[
  'name' => 'start_date',
  'label' => 'Start Date',
  'type' => 'date',
  'required' => true,
  'validation' => 'required|date'
],


 MODEL NEW (example)
[
  'name' => 'start_date',
  'label' => 'Start Date',
  'type' => 'date',
  'required' => true,
  'validation' => 'required|date|before_or_equal:today'
],


CONTROLLER OLD (app/controllers/applicant/ApplyJob.php)
$responses[$field_name] = $value;


 CONTROLLER NEW (example)
if ($field_name === 'start_date' && !empty($value) && $value > date('Y-m-d')) {
  $validation_errors[] = "Start Date cannot be in the future.";
  continue;
}
$responses[$field_name] = $value;


 VIEW OLD (app/views/applicant/apply.view.php)
<input
  type="<?= esc($ftype) ?>"
  id="field_<?= esc($fname) ?>"
  name="form_fields[<?= esc($fname) ?>]"
  class="form-input"
  value="<?= esc($prefillValue) ?>"
  placeholder="<?= esc($field['placeholder'] ?? '') ?>"
  <?= $required ? 'required' : '' ?>
>


 VIEW NEW (example)
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


-- move work_experience section before education
-- SQL : no DB schema change.

CONTROLLER OLD (app/controllers/applicant/ApplyJob.php)

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


 CONTROLLER NEW (example)

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


-- add a new field (emergency_contact_name)

-- SQL 
INSERT INTO application_form_fields
  (form_id, field_category, field_name, field_label, field_type, field_options, is_required, is_enabled, field_order, validation_rules, placeholder, help_text)
VALUES
  (1, 'personal_info', 'emergency_contact_name', 'Emergency Contact Name', 'text', NULL, 1, 1, 99, 'required|max:100', 'Enter emergency contact name', NULL);

MODEL NEW (example in app/models/ApplicationFormField.php)
[
  'name' => 'emergency_contact_name',
  'label' => 'Emergency Contact Name',
  'type' => 'text',
  'required' => true,
  'placeholder' => 'Enter emergency contact name',
  'validation' => 'required|max:100'
],


 CONTROLLER OLD+NEW (app/controllers/applicant/ApplyJob.php)
-- no special change needed for normal text fields (already dynamic)


-- VIEW OLD+NEW (app/views/applicant/apply.view.php)
-- no special change needed for normal text fields (already dynamic)


-- add personal info field on applicant profile page: gender (text input)

-- SQL (users table)
ALTER TABLE users
ADD COLUMN gender VARCHAR(50) NULL AFTER address;


-- CONTROLLER OLD (app/controllers/applicant/Profile.php)
$data['form_values'] = [
  'full_name' => $current_user['full_name'] ?? '',
  'email' => $current_user['email'] ?? '',
  'phone' => $current_user['phone'] ?? '',
  'address' => $current_user['address'] ?? ''
];


-- CONTROLLER NEW (example)
$data['form_values'] = [
  'full_name' => $current_user['full_name'] ?? '',
  'email' => $current_user['email'] ?? '',
  'phone' => $current_user['phone'] ?? '',
  'address' => $current_user['address'] ?? '',
  'gender' => $current_user['gender'] ?? ''
];


-- CONTROLLER OLD (update payload)
$data = [
  'full_name' => trim($_POST['full_name'] ?? ''),
  'email' => strtolower(trim($_POST['email'] ?? '')),
  'phone' => trim($_POST['phone'] ?? ''),
  'address' => trim($_POST['address'] ?? '')
];


-- CONTROLLER NEW (example)
$data = [
  'full_name' => trim($_POST['full_name'] ?? ''),
  'email' => strtolower(trim($_POST['email'] ?? '')),
  'phone' => trim($_POST['phone'] ?? ''),
  'address' => trim($_POST['address'] ?? ''),
  'gender' => trim($_POST['gender'] ?? '')
];


-- VIEW OLD (app/views/applicant/profile.view.php)
<div class="form-group">
  <label for="phone" class="form-label">Phone Number</label>
  <input type="tel" id="phone" name="phone" class="form-input" value="<?= esc($form_values['phone'] ?? '') ?>">
</div>


-- VIEW NEW (example)
<div class="form-group">
  <label for="phone" class="form-label">Phone Number</label>
  <input type="tel" id="phone" name="phone" class="form-input" value="<?= esc($form_values['phone'] ?? '') ?>">
</div>
<div class="form-group">
  <label for="gender" class="form-label">Gender</label>
  <input type="text" id="gender" name="gender" class="form-input" value="<?= esc($form_values['gender'] ?? '') ?>">
</div>


-- MODEL NOTE (app/models/User.php)
-- add validation for gender only if needed (length/allowed values).


-- make a personal info field required (example: phone on profile page)

-- SQL (optional, if DB-level required is needed)
ALTER TABLE users
MODIFY phone VARCHAR(20) NOT NULL;


-- VIEW OLD (app/views/applicant/profile.view.php)
<input type="tel" id="phone" name="phone" class="form-input" value="<?= esc($form_values['phone'] ?? '') ?>">


-- VIEW NEW (example)
<input type="tel" id="phone" name="phone" class="form-input" value="<?= esc($form_values['phone'] ?? '') ?>" required>


-- MODEL OLD (app/models/User.php validateProfileUpdate)
if (!empty($data['phone']) && !preg_match('/^[\+]?[1-9][\d]{0,15}$/', $data['phone'])) {
  $this->errors['phone'] = "Please enter a valid phone number";
}


-- MODEL NEW (example)
if (empty($data['phone'])) {
  $this->errors['phone'] = "Phone is required";
} elseif (!preg_match('/^[\+]?[1-9][\d]{0,15}$/', $data['phone'])) {
  $this->errors['phone'] = "Please enter a valid phone number";
}


-- CONTROLLER NOTE
-- no extra controller logic needed if model validation is updated.


-- alter table examples

-- add a new column
ALTER TABLE users
ADD COLUMN gender VARCHAR(50) NULL AFTER address;


-- change column to NOT NULL
ALTER TABLE users
MODIFY phone VARCHAR(20) NOT NULL;


-- change column to allow NULL
ALTER TABLE users
MODIFY address TEXT NULL;


-- change column type and keep it nullable
ALTER TABLE application_form_fields
MODIFY placeholder VARCHAR(255) NULL;


-- rename a column
ALTER TABLE users
RENAME COLUMN gender TO gender_text;


-- add a required-style column for a form field
ALTER TABLE application_form_fields
ADD COLUMN is_mandatory TINYINT(1) NOT NULL DEFAULT 0 AFTER is_required;


-- remove a column
ALTER TABLE users
DROP COLUMN gender_text;


-- example: required means NOT NULL
ALTER TABLE users
MODIFY email VARCHAR(255) NOT NULL;


-- example: optional means NULL allowed
ALTER TABLE users
MODIFY profile_picture VARCHAR(255) NULL;

-----
INSERT INTO users (name, email)
VALUES 
  ('John', 'john@email.com'),
  ('Jane', 'jane@email.com');

UPDATE users
SET status = 'inactive'
WHERE id = 5;

UPDATE users
SET name = 'New Name',
    updated_at = NOW()
WHERE email = 'john@email.com';

-- Country drop down

INSERT INTO application_form_fields (
    form_id,
    field_category,
    field_name,
    field_label,
    field_type,
    field_options,
    is_required,
    is_enabled,
    field_order,
    validation_rules,
    placeholder,
    help_text,
    created_at,
    updated_at
)
SELECT
    af.id,
    'personal_info',
    'country',
    'Country',
    'select',
    '["Sri Lanka","India","Bangladesh","Pakistan","Nepal","Maldives","Other"]',
    1,
    1,
    COALESCE((
        SELECT MAX(aff.field_order) + 1
        FROM application_form_fields aff
        WHERE aff.form_id = af.id
          AND aff.field_category = 'personal_info'
    ), 1),
    'required',
    NULL,
    NULL,
    NOW(),
    NOW()
FROM application_forms af
WHERE NOT EXISTS (
    SELECT 1
    FROM application_form_fields ex
    WHERE ex.form_id = af.id
      AND ex.field_name = 'country'
);

-- applicant/applications - model -> applicationformfield , view-> apply.vew
INSERT INTO application_form_fields (
    form_id,
    field_category,
    field_name,
    field_label,
    field_type,
    field_options,
    is_required,
    is_enabled,
    field_order,
    validation_rules,
    placeholder,
    help_text,
    created_at,
    updated_at
) VALUES (
    12,
    'personal_info',
    'country',
    'Country',
    'select',
    '["Sri Lanka","India","Bangladesh","Pakistan","Nepal","Maldives","Other"]',
    1,
    1,
    99,
    'required',
    NULL,
    NULL,
    NOW(),
    NOW()
);


-- SELECT / ORDER / fetch display

-- add L185 apply.view.php
    sort($options, SORT_NATURAL | SORT_FLAG_CASE); //alphetical order

-- 1) Basic fetch: applicant profile list
SELECT id, full_name, email, phone, status
FROM users
WHERE role_id = 4;


-- 2) Sort newest applicants first
SELECT id, full_name, email, created_at
FROM users
WHERE role_id = 4
ORDER BY created_at DESC;


-- 3) Sort alphabetically by name
SELECT id, full_name, email
FROM users
WHERE role_id = 4
ORDER BY full_name ASC;


-- 4) Fetch only active applicants
SELECT id, full_name, email, status
FROM users
WHERE role_id = 4
  AND status = 'active'
ORDER BY full_name ASC;


-- 5) Search-like fetch for table filters
SELECT id, full_name, email, phone
FROM users
WHERE role_id = 4
  AND (
    full_name LIKE '%john%'
    OR email LIKE '%john%'
    OR phone LIKE '%john%'
  )
ORDER BY full_name ASC;


-- 6) Display with aliases (clean table headers)
SELECT
  u.id AS applicant_id,
  u.full_name AS applicant_name,
  u.email AS applicant_email,
  u.phone AS applicant_phone,
  u.created_at AS registered_on
FROM users u
WHERE u.role_id = 4
ORDER BY u.created_at DESC;


-- 7) Join example: applicant + applications count
SELECT
  u.id,
  u.full_name,
  u.email,
  COUNT(a.id) AS application_count
FROM users u
LEFT JOIN applications a ON a.applicant_id = u.id
WHERE u.role_id = 4
GROUP BY u.id, u.full_name, u.email
ORDER BY application_count DESC, u.full_name ASC;


-- 8) Join example: application listing for display page
SELECT
  a.id AS application_id,
  u.full_name AS applicant_name,
  jp.title AS job_title,
  a.status AS application_status,
  a.applied_at
FROM applications a
JOIN users u ON u.id = a.applicant_id
JOIN job_posts jp ON jp.id = a.job_id
ORDER BY a.applied_at DESC;


-- 9) Pagination example (page size 10, page 1)
SELECT id, full_name, email, created_at
FROM users
WHERE role_id = 4
ORDER BY created_at DESC
LIMIT 10 OFFSET 0;


-- 10) Pagination example (page size 10, page 2)
SELECT id, full_name, email, created_at
FROM users
WHERE role_id = 4
ORDER BY created_at DESC
LIMIT 10 OFFSET 10;


-- 11) Display only selected form fields (from JSON form_data)
-- Note: works in MySQL 8+ with JSON columns
SELECT
  a.id,
  JSON_UNQUOTE(JSON_EXTRACT(a.form_data, '$.first_name')) AS first_name,
  JSON_UNQUOTE(JSON_EXTRACT(a.form_data, '$.last_name')) AS last_name,
  JSON_UNQUOTE(JSON_EXTRACT(a.form_data, '$.job_title')) AS job_title
FROM applications a
ORDER BY a.applied_at DESC;


-- 12) Count rows for table footer/stat card
SELECT COUNT(*) AS total_applicants
FROM users
WHERE role_id = 4;


-- 13) Grouping example for dashboard chart/table
SELECT status, COUNT(*) AS total
FROM applications
GROUP BY status
ORDER BY total DESC;


-- 14) Latest 5 records quick preview
SELECT id, full_name, email, created_at
FROM users
WHERE role_id = 4
ORDER BY id DESC
LIMIT 5;

DELETE FROM application_form_fields
WHERE form_id = 12
AND field_category = 'personal_info'
AND field_name = 'country'
AND field_label = 'Country'
AND field_type = 'select'
AND field_order = 99;


-- Normal text field 

INSERT INTO application_form_fields (
    form_id,
    field_category,
    field_name,
    field_label,
    field_type,
    field_options,
    is_required,
    is_enabled,
    field_order,
    validation_rules,
    placeholder,
    help_text,
    created_at,
    updated_at
) VALUES (
    12,
    'personal_info',
    'current_address',
    'Current Address',
    'text',
    NULL,
    0,
    1,
    100,
    'max:255',
    'Enter your current address',
    NULL,
    NOW(),
    NOW()
);


DELETE FROM application_form_fields
WHERE form_id = 12
  AND field_category = 'personal_info'
  AND field_name = 'current_address'
  AND field_label = 'Current Address'
  AND field_type = 'text'
  AND field_order = 100;

-- End date field - for recruiter views-> recruitment/applications.view
INSERT INTO application_form_fields (
    form_id,
    field_category,
    field_name,
    field_label,
    field_type,
    field_options,
    is_required,
    is_enabled,
    field_order,
    validation_rules,
    placeholder,
    help_text,
    created_at,
    updated_at
) VALUES (
    12,
    'work_experience',
    'end_date',
    'End Date',
    'date',
    NULL,
    0,
    1,
    101,
    'date|after:start_date',
    NULL,
    NULL,
    NOW(),
    NOW()
);

DELETE FROM application_form_fields
WHERE form_id = 12
  AND field_category = 'work_experience'
  AND field_name = 'end_date'
  AND field_label = 'End Date'
  AND field_type = 'date'
  AND field_order = 101;


view L396 just before, function renderField
        /* */
        
        function formatDuration(startDateStr, endDateStr) {
            const start = new Date(startDateStr);
            const end = new Date(endDateStr);

            if (isNaN(start.getTime()) || isNaN(end.getTime()) || end < start) {
                return null;
            }

            let months = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth());
            if (end.getDate() < start.getDate()) {
                months -= 1;
            }

            if (months < 0) {
                return null;
            }

            const years = Math.floor(months / 12);
            const remMonths = months % 12;

            if (years > 0 && remMonths > 0) return years + " years " + remMonths + " months";
            if (years > 0) return years + " years";
            return remMonths + " months";
        }
        /* */

view L461
            /* */
            
            const duration = formatDuration(topLevelFields.start_date, topLevelFields.end_date);
            if (duration) {
                topLevelFields.experience_duration = duration;
            }
            /* */


-- file upload section

INSERT INTO application_form_fields (
    form_id,
    field_category,
    field_name,
    field_label,
    field_type,
    field_options,
    is_required,
    is_enabled,
    field_order,
    validation_rules,
    placeholder,
    help_text,
    created_at,
    updated_at
) VALUES (
    12,
    'documents',
    'certificate_upload',
    'Certificate Upload',
    'file',
    '[".pdf",".doc",".docx"]',
    0,
    1,
    102,
    'file|mimes:pdf,doc,docx|max:5120',
    NULL,
    'Upload relevant certificates (PDF/DOC/DOCX, max 5MB)',
    NOW(),
    NOW()
);

DELETE FROM application_form_fields
WHERE form_id = 12
  AND field_category = 'documents'
  AND field_name = 'certificate_upload'
  AND field_label = 'Certificate Upload'
  AND field_type = 'file'
  AND field_order = 102;


-- auto increment field_order

INSERT INTO application_form_fields (
form_id,
field_category,
field_name,
field_label,
field_type,
field_options,
is_required,
is_enabled,
field_order,
validation_rules,
placeholder,
help_text,
created_at,
updated_at
)
SELECT
12,
'personal_info',
'current_address',
'Current Address',
'text',
NULL,
0,
1,
COALESCE(MAX(field_order), 0) + 1,
'max:255',
'Enter your current address',
NULL,
NOW(),
NOW()
FROM application_form_fields
WHERE form_id = 12
AND field_category = 'personal_info';


-- application form validation model -> applicationformfield
--resume type core/applicantbasetrait

-- profile edit model-> user.php controller-> profile.php,  view -> profile.view.php

--add new field to profile personal

ALTER TABLE users
ADD COLUMN country VARCHAR(100) NULL AFTER address;

-- spefic value validation 

        if (empty($data['country'])) {
            $this->errors['country'] = "Country is required";
        } elseif (strcasecmp(trim($data['country']), 'Canada') !== 0) {
            $this->errors['country'] = "Country must be Canada";
        }


-- if dropdown needed
<div class="form-group">
    <label for="country" class="form-label">Country</label>
    <select id="country" name="country" class="form-input" required>
        <option value="">Select country</option>
        <option value="Canada" <?= (($form_values['country'] ?? '') === 'Canada') ? 'selected' : '' ?>>Canada</option>
        <option value="Sri Lanka" <?= (($form_values['country'] ?? '') === 'Sri Lanka') ? 'selected' : '' ?>>Sri Lanka</option>
        <option value="India" <?= (($form_values['country'] ?? '') === 'India') ? 'selected' : '' ?>>India</option>
        <option value="Other" <?= (($form_values['country'] ?? '') === 'Other') ? 'selected' : '' ?>>Other</option>
    </select>
</div>

-- reverse
ALTER TABLE users
DROP COLUMN country;


-- checkbox 

ALTER TABLE users
ADD COLUMN willing_to_relocate TINYINT(1) NOT NULL DEFAULT 0;

add in model -> profile.php in $data['form_values'] = [
    'willing_to_relocate' => (int)($current_user['willing_to_relocate'] ?? 0),

add in model -> profile.php  in $data = [
    'willing_to_relocate' => isset($_POST['willing_to_relocate']) ? 1 : 0,

add in controller -> user.php
    'willing_to_relocate',

add in view - profile.view.php

    <div class="form-group form-group-full">
        <label class="form-label" for="willing_to_relocate">Willing to relocate</label>
        <label>
            <input
                type="checkbox"
                id="willing_to_relocate"
                name="willing_to_relocate"
                value="1"
                <?= !empty($form_values['willing_to_relocate']) ? 'checked' : '' ?>
            >
            Yes
        </label>
    </div>


-- display in ui add near mobile

<span class="contact-item">🚚 Relocate: <?= !empty($user['willing_to_relocate']) ? 'Yes' : 'No' ?></span>

-- reverse

ALTER TABLE users
DROP COLUMN willing_to_relocate;

-- how fetch happen in profile - core/model.php has query (limit), model-> user.php has $_session['user'], 


-- saved jobs - order

ORDER BY sj.saved_at DESC
ORDER BY jp.title ASC
ORDER BY LOWER(jp.title) ASC

-- saved jobs order ui check jobpost.php model, order by L182

