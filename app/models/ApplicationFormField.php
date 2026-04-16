<?php

//ApplicationFormField Model
 
class ApplicationFormField
{
    use Model;
    protected $table = 'application_form_fields';
    protected $allowedColumns = [
        'form_id',
        'field_category',
        'field_name',
        'field_label',
        'field_type',
        'field_options',
        'is_required',
        'is_enabled',
        'field_order',
        'validation_rules',
        'placeholder',
        'help_text'
    ];

    //Get all available field definitions
    //These are the fields that recruitment managers can choose from
    public static function getAvailableFields()
    {
        return [
            'personal_info' => [
                'category_label' => 'Personal Information',
                'fields' => [
                    [
                        'name' => 'first_name',
                        'label' => 'First Name',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'Enter your first name',
                        'validation' => 'required|min:2|max:50'
                    ],
                    [
                        'name' => 'last_name',
                        'label' => 'Last Name',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'Enter your last name',
                        'validation' => 'required|min:2|max:50'
                    ],
                    [
                        'name' => 'email',
                        'label' => 'Email Address',
                        'type' => 'email',
                        'required' => true,
                        'placeholder' => 'your.email@example.com',
                        'validation' => 'required|email'
                    ],
                    [
                        'name' => 'phone',
                        'label' => 'Phone Number',
                        'type' => 'tel',
                        'required' => true,
                        'placeholder' => '+94XXXXXXXXX',
                        'validation' => 'required|phone'
                    ],
                    [
                        'name' => 'city',
                        'label' => 'Current City',
                        'type' => 'select',
                        'required' => true,
                        'options' => [
                            'Colombo', 'Mount Lavinia', 'Kesbewa', 'Maharagama', 'Moratuwa', 
                            'Ratnapura', 'Negombo', 'Kandy', 'Sri Jayewardenepura Kotte', 
                            'Kalmunai', 'Trincomalee', 'Galle', 'Jaffna', 'Athurugiriya', 
                            'Weligama', 'Matara', 'Kolonnawa', 'Gampaha', 'Puttalam', 
                            'Badulla', 'Kalutara', 'Bentota', 'Mannar', 'Kurunegala'
                        ],
                        'validation' => 'required'
                    ],
                    [
                        'name' => 'province',
                        'label' => 'Province',
                        'type' => 'select',
                        'required' => true,
                        'options' => [
                            'Western', 'Central', 'Southern', 'Northern', 'Eastern', 
                            'North Western', 'North Central', 'Uva', 'Sabaragamuwa'
                        ],
                        'validation' => 'required'
                    ],
                    [
                        'name' => 'nationality',
                        'label' => 'Nationality',
                        'type' => 'text',
                        'required' => false,
                        'placeholder' => 'Ex : Sri Lankan',
                        'validation' => 'max:50'
                    ],
                    [
                        'name' => 'date_of_birth',
                        'label' => 'Date of Birth',
                        'type' => 'date',
                        'required' => false,
                        'validation' => 'date|before:today'
                    ],
                    [
                        'name' => 'gender',
                        'label' => 'Gender',
                        'type' => 'select',
                        'required' => false,
                        'options' => ['Male', 'Female', 'Other', 'Prefer not to say'],
                        'validation' => ''
                    ],
                    [
                        'name' => 'linkedin_url',
                        'label' => 'LinkedIn Profile URL',
                        'type' => 'url',
                        'required' => false,
                        'placeholder' => 'https://www.linkedin.com/in/yourprofile',
                        'validation' => 'url'
                    ],
                    [
                        'name' => 'portfolio_url',
                        'label' => 'Portfolio / GitHub / Website URL',
                        'type' => 'url',
                        'required' => false,
                        'placeholder' => 'https://yourportfolio.com or https://github.com/username',
                        'validation' => 'url'
                    ]
                ]
            ],
            'education' => [
                'category_label' => 'Education Details',
                'fields' => [
                    [
                        'name' => 'highest_qualification',
                        'label' => 'Highest Qualification',
                        'type' => 'select',
                        'required' => true,
                        'options' => ['High School', 'Diploma', 'Bachelor\'s Degree', 'Master\'s Degree', 'PhD', 'Professional Certification'],
                        'validation' => 'required'
                    ],
                    [
                        'name' => 'degree',
                        'label' => 'Degree / Field of Study',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'Ex: BSc Computer Science',
                        'validation' => 'required|max:200'
                    ]
                ]
            ],
            'work_experience' => [
                'category_label' => 'Work Experience',
                'description' => 'Repeatable section - applicants can add multiple entries',
                'fields' => [
                    [
                        'name' => 'job_title',
                        'label' => 'Job Title',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'Ex: Senior Software Engineer',
                        'validation' => 'required|max:200'
                    ],
                    [
                        'name' => 'company_name',
                        'label' => 'Company Name',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'Ex: ABC Technologies',
                        'validation' => 'required|max:200'
                    ],
                    [
                        'name' => 'employment_type',
                        'label' => 'Employment Type',
                        'type' => 'select',
                        'required' => false,
                        'options' => ['Full-time', 'Part-time', 'Contract', 'Internship', 'Freelance'],
                        'validation' => ''
                    ],
                    [
                        'name' => 'start_date',
                        'label' => 'Start Date',
                        'type' => 'date',
                        'required' => true,
                        'validation' => 'required|date'
                    ],
                    [
                        'name' => 'end_date',
                        'label' => 'End Date',
                        'type' => 'date',
                        'required' => false,
                        'validation' => 'date|after:start_date'
                    ],
                    [
                        'name' => 'currently_working',
                        'label' => 'Currently Working Here',
                        'type' => 'checkbox',
                        'required' => false,
                        'validation' => ''
                    ],
                    [
                        'name' => 'responsibilities',
                        'label' => 'Key Responsibilities / Achievements',
                        'type' => 'textarea',
                        'required' => false,
                        'placeholder' => 'Describe your key responsibilities and achievements',
                        'validation' => 'max:1000'
                    ]
                ]
            ],
            'skills' => [
                'category_label' => 'Skills & Competencies',
                'fields' => [
                    [
                        'name' => 'technical_skills',
                        'label' => 'Technical Skills',
                        'type' => 'textarea',
                        'required' => true,
                        'placeholder' => 'e.g., PHP, JavaScript, Python, SQL (comma separated)',
                        'help_text' => 'Enter skills separated by commas',
                        'validation' => 'required'
                    ],
                    [
                        'name' => 'tools_technologies',
                        'label' => 'Tools / Technologies',
                        'type' => 'textarea',
                        'required' => false,
                        'placeholder' => 'Ex: Git, Docker, AWS, VS Code (comma separated)',
                        'help_text' => 'Enter tools and technologies separated by commas',
                        'validation' => ''
                    ]
                ]
            ],
            'documents' => [
                'category_label' => 'Resume & Documents',
                'fields' => [
                    [
                        'name' => 'resume_upload',
                        'label' => 'Resume / CV Upload',
                        'type' => 'file',
                        'required' => true,
                        'accept' => '.pdf,.doc,.docx',
                        'help_text' => 'Accepted formats: PDF, DOC, DOCX (Max 5MB)',
                        'validation' => 'required|file|mimes:pdf,doc,docx|max:5120'
                    ]
                ]
            ],
            'availability' => [
                'category_label' => 'Availability & Expectations',
                'fields' => [
                    [
                        'name' => 'notice_period',
                        'label' => 'Notice Period',
                        'type' => 'select',
                        'required' => true,
                        'options' => ['Immediate', '1 Week', '2 Weeks', '1 Month', '2 Months', '3 Months'],
                        'validation' => 'required'
                    ],
                    [
                        'name' => 'expected_salary',
                        'label' => 'Expected Salary (Monthly)',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'Ex: LKR 100,000 - 150,000',
                        'help_text' => 'You can provide a range',
                        'validation' => 'required|max:100'
                    ]
                ]
            ],
            'declarations' => [
                'category_label' => 'Declarations & Consent',
                'fields' => [
                    [
                        'name' => 'terms_agreement',
                        'label' => 'I agree to the company\'s terms and conditions',
                        'type' => 'checkbox',
                        'required' => true,
                        'validation' => 'required|accepted'
                    ]
                ]
            ]
        ];
    }

    /**
     * Save multiple fields for a form
     */
    public function saveFormFields($form_id, $selected_fields)
    {
        $success = true;
        $order = 1;

        foreach ($selected_fields as $category => $fields) {
            foreach ($fields as $field_name) {
                $fieldData = $this->getFieldDefinition($category, $field_name);
                
                if ($fieldData) {
                    $data = [
                        'form_id' => $form_id,
                        'field_category' => $category,
                        'field_name' => $field_name,
                        'field_label' => $fieldData['label'],
                        'field_type' => $fieldData['type'],
                        'field_options' => isset($fieldData['options']) ? json_encode($fieldData['options']) : null,
                        'is_required' => $fieldData['required'] ? 1 : 0,
                        'is_enabled' => 1,
                        'field_order' => $order,
                        'validation_rules' => $fieldData['validation'] ?? null,
                        'placeholder' => $fieldData['placeholder'] ?? null,
                        'help_text' => $fieldData['help_text'] ?? null
                    ];

                    if (!$this->insert($data)) {
                        $success = false;
                    }
                    $order++;
                }
            }
        }

        return $success;
    }

    /**
     * Get field definition by category and name
     */
    private function getFieldDefinition($category, $field_name)
    {
        $allFields = self::getAvailableFields();
        
        if (isset($allFields[$category]['fields'])) {
            foreach ($allFields[$category]['fields'] as $field) {
                if ($field['name'] === $field_name) {
                    return $field;
                }
            }
        }
        
        return null;
    }

    /**
     * Get fields by form ID
     */
    public function getFieldsByFormId($form_id, $enabled_only = true)
    {
        $query = "SELECT * FROM {$this->table} WHERE form_id = :form_id";
        
        if ($enabled_only) {
            $query .= " AND is_enabled = 1";
        }
        
        $query .= " ORDER BY field_category, field_order";
        
        return $this->query($query, ['form_id' => $form_id]);
    }

    /**
     * Get fields grouped by category
     */
    public function getFieldsGroupedByCategory($form_id)
    {
        $fields = $this->getFieldsByFormId($form_id);
        $grouped = [];

        foreach ($fields as $field) {
            $category = $field->field_category;
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][] = $field;
        }

        return $grouped;
    }

    /**
     * Update field
     */
    public function updateField($field_id, $data)
    {
        $query = "UPDATE {$this->table} SET ";
        $params = ['field_id' => $field_id];
        $updates = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $this->allowedColumns)) {
                $updates[] = "$key = :$key";
                $params[$key] = $value;
            }
        }

        if (empty($updates)) {
            return false;
        }

        $query .= implode(', ', $updates);
        $query .= " WHERE id = :field_id";

        return $this->query($query, $params);
    }

    /**
     * Delete fields by form ID
     */
    public function deleteFieldsByFormId($form_id)
    {
        $query = "DELETE FROM {$this->table} WHERE form_id = :form_id";
        return $this->query($query, ['form_id' => $form_id]);
    }

    /**
     * Toggle field enabled status
     */
    public function toggleField($field_id)
    {
        $query = "UPDATE {$this->table} 
                SET is_enabled = NOT is_enabled 
                WHERE id = :field_id";
        
        return $this->query($query, ['field_id' => $field_id]);
    }
}
