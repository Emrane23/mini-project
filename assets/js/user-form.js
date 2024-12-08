document.addEventListener('DOMContentLoaded', () => {
    const roleRadios = document.querySelectorAll('[name="user[roles]"]');
    const teacherFields = document.getElementById('teacher-fields');
    const studentFields = document.getElementById('student-fields');
    const allFields = document.querySelectorAll('.role-fields .form-control');

    // Function to clear and update required fields
    const clearFields = (container) => {
        if (!container) return;
        const inputs = container.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.type !== 'hidden') {
                input.value = '';
                input.removeAttribute('required'); 
            }
        });
    };

    // Function to set fields required based on role
    const setFieldsRequired = (container, required) => {
        const inputs = container.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (required) {
                if(input.id!='user_cvFile_delete' && input.id!='user_cvFile_file' ){
                input.setAttribute('required', 'required');
                }
            } else {
                input.removeAttribute('required');
            }
        });
    };

    roleRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            const selectedRole = radio.value;

            // Reset all fields' required attributes and values
            allFields.forEach(field => field.removeAttribute('required'));

            if (selectedRole === 'ROLE_TEACHER') {
                clearFields(studentFields);
                setFieldsRequired(teacherFields, true);
                teacherFields.classList.remove('d-none');
                studentFields.classList.add('d-none');
            } else if (selectedRole === 'ROLE_STUDENT') {
                clearFields(teacherFields);
                setFieldsRequired(studentFields, true);
                studentFields.classList.remove('d-none');
                teacherFields.classList.add('d-none');
            }
        });
    });

    // Trigger role-based field visibility and required field handling on page load
    const selectedRole = document.querySelector('[name="user[roles]"]:checked');
    if (selectedRole) {
        selectedRole.dispatchEvent(new Event('change'));
    }
});