<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portfolio Update Diagnostic Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">Portfolio Update Diagnostic</h1>
        
        <!-- CSRF Debug -->
        <div class="alert alert-info mb-4">
            <h5 class="mb-2">CSRF Information:</h5>
            <div>CSRF Token: <code>{{ csrf_token() }}</code></div>
            <div>CSRF Meta Tag: <code>{{ csrf_token() === $request->session()->token() ? 'Matches Session' : 'Does NOT match session' }}</code></div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5>Current Portfolio Data</h5>
            </div>
            <div class="card-body">
                <pre>{{ json_encode($portfolio->toArray(), JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Basic Form Test</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data" id="debugForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Portfolio Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $portfolio->title }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $portfolio->full_name }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="tagline" class="form-label">Tagline</label>
                        <input type="text" class="form-control" id="tagline" name="tagline" value="{{ $portfolio->tagline }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3">{{ $portfolio->bio }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $portfolio->email }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="experience_level" class="form-label">Experience Level</label>
                        <select class="form-select" id="experience_level" name="experience_level">
                            @foreach(['beginner', 'intermediate', 'advanced', 'expert'] as $level)
                                <option value="{{ $level }}" {{ $portfolio->experience_level == $level ? 'selected' : '' }}>
                                    {{ ucfirst($level) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="skills" class="form-label">Skills (comma-separated)</label>
                        <input type="text" class="form-control" id="skills_text" name="skills_text" 
                               value="{{ implode(', ', $portfolio->skills ?? []) }}">
                        <!-- Hidden skills array -->
                        @foreach($portfolio->skills ?? [] as $skill)
                            <input type="hidden" name="skills[]" value="{{ $skill }}">
                        @endforeach
                    </div>
                    
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100" id="submitFormBtn">
                            <i class="fa fa-save"></i> Update Portfolio
                        </button>
                        <div id="formSubmitStatus" class="mt-3"></div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-4">
            <h5>Debug Info</h5>
            <div>
                <h6>Session Flash Data:</h6>
                <pre>{{ json_encode(session()->all(), JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update hidden skills array when the text input changes
        document.getElementById('skills_text').addEventListener('input', function() {
            // Get the skills container and remove existing skill inputs
            const skillsContainer = this.parentNode;
            const skillInputs = skillsContainer.querySelectorAll('input[name="skills[]"]');
            skillInputs.forEach(input => input.remove());
            
            // Add new skill inputs based on the comma-separated text
            const skills = this.value.split(',').map(skill => skill.trim()).filter(skill => skill);
            skills.forEach(skill => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'skills[]';
                input.value = skill;
                skillsContainer.appendChild(input);
            });
        });
        
        // Debug form submission
        document.getElementById('debugForm').addEventListener('submit', function(e) {
            console.log('Form submission initiated', {
                action: this.action,
                method: this.method,
                enctype: this.enctype
            });
            
            const statusDiv = document.getElementById('formSubmitStatus');
            statusDiv.innerHTML = '<div class="alert alert-info">Form submitted. Waiting for response...</div>';
            
            // We allow the form to submit normally - don't prevent default
        });
        
        document.getElementById('submitFormBtn').addEventListener('click', function() {
            console.log('Update button clicked', {
                formAction: document.getElementById('debugForm').action,
                formMethod: document.getElementById('debugForm').method
            });
        });
    </script>
</body>
</html> 