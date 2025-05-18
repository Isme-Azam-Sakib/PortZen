@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="contact-page-container">
    <div class="gradient-header">
        <div class="container">
            <h1 class="fade-in">Get in Touch</h1>
            <p class="lead fade-in-delay">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
        </div>
    </div>

    <div class="container content-section">
        <div class="row">
            <div class="col-md-5">
                <div class="contact-info-card">
                    <h2>Contact Information</h2>
                    <div class="contact-item">
                        <i class="fa fa-envelope"></i>
                        <p>support@portzen.com</p>
                    </div>
                    <div class="contact-item">
                        <i class="fa fa-map-marker"></i>
                        <p>123 Portfolio Lane<br>Design District, Creative City</p>
                    </div>
                    <div class="contact-item">
                        <i class="fa fa-clock-o"></i>
                        <p>Monday - Friday: 9am - 5pm</p>
                    </div>

                    <div class="social-links">
                        <a href="#" class="social-icon"><i class="fa fa-facebook fa-2x"></i></a>
                        <a href="#" class="social-icon"><i class="fa fa-twitter fa-2x"></i></a>
                        <a href="#" class="social-icon"><i class="fa fa-instagram fa-2x"></i></a>
                        <a href="#" class="social-icon"><i class="fa fa-linkedin fa-2x"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="contact-form-card">
                    <h2>Send a Message</h2>
                    <form id="contactForm" method="POST" action="{{ route('contact.send') }}" class="contact-form">
                        @csrf
                        <div class="form-row">
                            <div class="form-col">
                                <input type="text" name="name" placeholder="Your Name" required>
                            </div>
                            <div class="form-col">
                                <input type="email" name="email" placeholder="Your Email" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col-full">
                                <input type="text" name="subject" placeholder="Subject" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col-full">
                                <textarea name="message" placeholder="Your Message" required></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col-full">
                                <button type="submit" class="button">Send Message</button>
                                <div id="form-status" class="mt-3" style="display: none;"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .contact-page-container {
        padding-bottom: 80px;
    }
    
    .gradient-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 100px 0 80px;
        margin-bottom: 60px;
        text-align: center;
    }
    
    .gradient-header h1 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .gradient-header .lead {
        font-size: 20px;
        max-width: 700px;
        margin: 0 auto;
    }
    
    .content-section {
        margin-top: -40px;
    }
    
    .contact-info-card, 
    .contact-form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 40px;
        height: 100%;
    }
    
    .contact-info-card h2,
    .contact-form-card h2 {
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid rgba(118, 75, 162, 0.1);
        font-weight: 600;
    }
    
    .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
    }
    
    .contact-item i {
        color: #764ba2;
        margin-right: 15px;
        font-size: 20px;
        min-width: 24px;
        margin-top: 3px;
    }
    
    .social-links {
        margin-top: 40px;
        display: flex;
        gap: 15px;
    }
    
    .social-icon {
        color: #764ba2;
        transition: transform 0.3s ease;
    }
    
    .social-icon:hover {
        transform: translateY(-5px);
        color: #667eea;
    }
    
    /* Animation classes */
    .fade-in {
        opacity: 0;
        animation: fadeIn 1s forwards;
    }
    
    .fade-in-delay {
        opacity: 0;
        animation: fadeIn 1s 0.3s forwards;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .contact-info-card {
            margin-bottom: 30px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const formStatus = document.getElementById('form-status');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Disable submit button
            const submitButton = contactForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';
            
            // Clear previous status
            formStatus.innerHTML = '';
            formStatus.className = '';
            formStatus.style.display = 'none';
            
            // Get form data
            const formData = new FormData(contactForm);
            
            // Send form data
            fetch(contactForm.getAttribute('action'), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Show status message
                formStatus.style.display = 'block';
                
                if (data.success) {
                    formStatus.innerHTML = `<div class="success-message">${data.message || 'Message sent successfully!'}</div>`;
                    formStatus.className = 'text-success';
                    contactForm.reset();
                } else {
                    formStatus.innerHTML = `<div class="error-message">${data.message || 'Failed to send message.'}</div>`;
                    formStatus.className = 'text-danger';
                }
                
                // Re-enable submit button
                submitButton.disabled = false;
                submitButton.textContent = 'Send Message';
            })
            .catch(error => {
                // Show error message
                formStatus.style.display = 'block';
                formStatus.innerHTML = '<div class="error-message">An error occurred. Please try again later.</div>';
                formStatus.className = 'text-danger';
                
                // Re-enable submit button
                submitButton.disabled = false;
                submitButton.textContent = 'Send Message';
            });
        });
    }
});
</script>
@endsection
