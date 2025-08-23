1. **Fully implemented UIs**  
2. **UML diagrams**  
3. **Authentication module (DB authentication)**  
4. **4CRUD operations**

**UIs**

|  | View name |
| :---- | :---- |
| **System**  | Home ✅ |
|  | Signup ✅ |
|  | 404 |
| **systemadmin** | dashboard Total user overview Quickstats(Active/Inactive accounts) Pending actions System health/status  |
|  | accesslogs Read user login/logout Filter logs Search logs Export logs as CSV/PDF |
|  | usermanage Create user form (HR Admin, Recruitment Manager) Update user form(Read \+ Update) Delete user |
|  | viewdata Read data (Users,Job postings, Applications,Interviews) Generate data report |
| **hradmin** | Dashboard Job posting overview Application statistics  Pending actions Upcoming interview Jobposting Create job form edit/update job form Delete job posting View job posting Applications View applications list Update application status View applicant details and documents Interviews Schedule interview form View schedule interviews Reschedule/cancel interviews |
|  |  |
|  |  |
|  |  |
| **recruitmanager** | Application forms Create/Update/Delete Applications Update the Applicant status Submitting the application feedback form Rate the applicant //–Short list the candidates Rejected applicants Offered applicants Schedule Interviews Cancel Interviews |
|  |  |
|  |  |
| **applicant** | **Applicant\_dashboard** \- Personal dashboard showing application overview **Job\_listings** \- Browse available jobs **Job\_details** \- Detailed job information **Application\_form** \- Apply for specific job **My\_applications** \- View all submitted applications **Application\_status** \- Track specific application progress **Withdraw\_application** \- Cancel application **Interview\_schedule** \- View scheduled interviews **Interview\_feedback** \- View feedback received (if policy allows) **Forgot\_password** \- Password recovery  |
|  |  |
|  |  |
|  |  |

**UML diagrams**

|  | systemadmin(Done /Todo) | hradmin(Done /Todo) | recruitmanager(Done /Todo)  | applicant(Done /Todo)  |
| :---- | ----- | :---- | :---- | :---- |
| Use case diagram and descriptions | Done | Done | Done | Done |
| Sequence diagram | Todo | Todo | Todo | Todo |
| Activity diagram | Todo | Todo | Todo | Todo |
| Component diagram | Todo |  |  |  |
| EER diagram | Todo |  |  |  |

**4CRUD operations**

|  | CREATE | READ | UPDATE | DELETE |
| :---- | :---- | :---- | :---- | :---- |
| **systemadmin** | Create user(HR Admin, Recruitment Manager) | Read user details  | Update user details | Delete user details |
|  |  |  |  |  |
|  |  |  |  |  |
|  |  |  |  |  |
| **hradmin** | Create job posting   | View job application | Update job posting | Delete Job posting |
|  |  |  |  |  |
|  |  |  |  |  |
|  |  |  |  |  |
| **recruitmanager** | Create Application form | View candidate filled application form | Update the applicant status | Remove an interview schedule |
|  |  |  |  |  |
|  |  |  |  |  |
| **applicant** | Submit Job Application | View (Job Postings, Interview schedule, Interview feedback) Track application process | Update Profile | Withdraw Application |
|  |  |  |  |  |
|  |  |  |  |  |
|  |  |  |  |  |

