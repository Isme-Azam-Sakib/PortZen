document.addEventListener('DOMContentLoaded', function() {
    // Utility function to show Bootstrap tooltip/alert
    function showAlert(message, type = 'warning') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        const form = document.querySelector('form');
        form.insertBefore(alertDiv, form.firstChild);

        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }

    // Function to create input group with remove button
    function createInputGroup(type, name, placeholder) {
        const wrapper = document.createElement('div');
        wrapper.className = 'input-group mb-2';

        const input = document.createElement('input');
        input.type = 'text';
        input.className = 'form-control';
        input.name = name;
        input.placeholder = placeholder;
        input.required = true;

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'btn btn-outline-danger';
        removeBtn.innerHTML = '×';
        removeBtn.addEventListener('click', () => wrapper.remove());

        wrapper.appendChild(input);
        wrapper.appendChild(removeBtn);

        return { wrapper, input };
    }

    // Handle Skills
    const skillInputs = document.querySelector('.skill-inputs');
    const addSkillBtn = skillInputs.querySelector('.add-skill');
    let skillCount = 1;

    addSkillBtn.addEventListener('click', function() {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = `skills[${skillCount}]`;
        input.className = 'form-control mb-2';
        input.placeholder = 'Enter a skill';
        
        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.className = 'btn btn-danger btn-sm position-absolute end-0 me-5';
        deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
        deleteBtn.style.top = '50%';
        deleteBtn.style.transform = 'translateY(-50%)';
        
        const wrapper = document.createElement('div');
        wrapper.className = 'position-relative';
        wrapper.appendChild(input);
        wrapper.appendChild(deleteBtn);
        
        skillInputs.insertBefore(wrapper, addSkillBtn);
        skillCount++;
        
        deleteBtn.addEventListener('click', function() {
            wrapper.remove();
        });
    });

    // Handle Tools
    const toolInputs = document.querySelector('.tool-inputs');
    const addToolBtn = toolInputs.querySelector('.add-tool');
    let toolCount = 1;

    addToolBtn.addEventListener('click', function() {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = `tools[${toolCount}]`;
        input.className = 'form-control mb-2';
        input.placeholder = 'Enter a tool';
        
        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.className = 'btn btn-danger btn-sm position-absolute end-0 me-5';
        deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
        deleteBtn.style.top = '50%';
        deleteBtn.style.transform = 'translateY(-50%)';
        
        const wrapper = document.createElement('div');
        wrapper.className = 'position-relative';
        wrapper.appendChild(input);
        wrapper.appendChild(deleteBtn);
        
        toolInputs.insertBefore(wrapper, addToolBtn);
        toolCount++;
        
        deleteBtn.addEventListener('click', function() {
            wrapper.remove();
        });
    });

    // Handle Social Links
    const socialInputs = document.querySelector('.social-inputs');
    const addSocialBtn = socialInputs.querySelector('.add-social');
    let socialCount = 1;

    addSocialBtn.addEventListener('click', function() {
        const socialGroup = document.createElement('div');
        socialGroup.className = 'input-group mb-2 position-relative';
        
        socialGroup.innerHTML = `
            <select class="form-select" name="social_links[${socialCount}][platform]" required>
                <option value="">Select Platform</option>
                <option value="behance"><i class="fab fa-behance"></i> Behance</option>
                <option value="dribbble"><i class="fab fa-dribbble"></i> Dribbble</option>
                <option value="linkedin"><i class="fab fa-linkedin"></i> LinkedIn</option>
                <option value="instagram"><i class="fab fa-instagram"></i> Instagram</option>
                <option value="twitter"><i class="fab fa-twitter"></i> Twitter</option>
            </select>
            <input type="url" class="form-control" 
                   name="social_links[${socialCount}][url]" 
                   placeholder="https://..."
                   pattern="https?://.+"
                   title="Include http:// or https:// in the URL">
            <button type="button" class="btn btn-danger delete-social">
                <i class="fas fa-trash"></i>
            </button>
        `;
        
        socialInputs.insertBefore(socialGroup, addSocialBtn);
        socialCount++;
        
        const deleteBtn = socialGroup.querySelector('.delete-social');
        deleteBtn.addEventListener('click', function() {
            socialGroup.remove();
        });
    });

    // Convert existing skills and tools inputs to input groups with remove buttons
    function convertExistingInputs() {
        const existingInputs = document.querySelectorAll('input[name="skills[]"], input[name="tools[]"]');
        existingInputs.forEach(input => {
            const currentValue = input.value;
            const { wrapper, input: newInput } = createInputGroup(
                'text',
                input.name,
                input.placeholder
            );
            newInput.value = currentValue;
            input.parentNode.replaceChild(wrapper, input);
        });
    }

    // Convert existing inputs when page loads
    convertExistingInputs();
}); 