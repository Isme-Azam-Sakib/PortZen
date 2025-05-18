@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="about-page-container">
    <div class="gradient-header">
        <div class="container">
            <h1 class="fade-in">About PortZen</h1>
            <p class="lead fade-in-delay">Your portfolio, reimagined. Simple, elegant, and powerful.</p>
        </div>
    </div>

    <div class="container">
        <div class="about-intro content-section">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="intro-content fade-in">
                        <h2>Why PortZen?</h2>
                        <p>PortZen was created with a simple mission: to help creatives showcase their work in the most compelling way possible. We believe that your portfolio should be as unique as your creative vision.</p>
                        <p>Whether you're a designer, photographer, developer, or artist, PortZen gives you the tools to create a stunning online presence without the complexity of traditional website builders.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="intro-image fade-in-delay">
                        <img src="{{ asset('images/about-intro.jpg') }}" alt="PortZen Dashboard" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </div>

        <div class="features-section">
            <h2 class="section-title text-center">Our Features</h2>
            
            <div class="row features-grid">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-paint-brush"></i>
                        </div>
                        <h3>Beautiful Templates</h3>
                        <p>Choose from a variety of professionally designed templates that make your work shine.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-sliders"></i>
                        </div>
                        <h3>Easy Customization</h3>
                        <p>Personalize your portfolio with intuitive controls - no coding required.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-mobile"></i>
                        </div>
                        <h3>Mobile Responsive</h3>
                        <p>Your portfolio looks great on any device, from desktops to smartphones.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-image"></i>
                        </div>
                        <h3>Gallery Management</h3>
                        <p>Easily upload, arrange, and showcase your work with our flexible gallery system.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-share-alt"></i>
                        </div>
                        <h3>Social Integration</h3>
                        <p>Connect your social profiles and extend your reach beyond your portfolio.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-rocket"></i>
                        </div>
                        <h3>Fast Setup</h3>
                        <p>Get your portfolio up and running in minutes with our streamlined setup process.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="team-section">
            <h2 class="section-title text-center">Meet Our Team</h2>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="team-card">
                        <div class="team-image">
                            <img src="{{ asset('images/team-placeholder.jpg') }}" alt="Team Member" class="img-fluid">
                        </div>
                        <h3>Jane Doe</h3>
                        <p class="position">Founder & CEO</p>
                        <p class="bio">Jane brings over 10 years of experience in design and product development.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="team-card">
                        <div class="team-image">
                            <img src="{{ asset('images/team-placeholder.jpg') }}" alt="Team Member" class="img-fluid">
                        </div>
                        <h3>John Smith</h3>
                        <p class="position">Lead Developer</p>
                        <p class="bio">John is a full-stack developer with a passion for creating seamless user experiences.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="team-card">
                        <div class="team-image">
                            <img src="{{ asset('images/team-placeholder.jpg') }}" alt="Team Member" class="img-fluid">
                        </div>
                        <h3>Emily Chen</h3>
                        <p class="position">Design Director</p>
                        <p class="bio">Emily oversees the design and aesthetics of all PortZen templates and features.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="cta-section text-center">
            <h2>Ready to create your portfolio?</h2>
            <p>Join thousands of creatives who have already discovered the power of PortZen.</p>
            <a href="{{ route('register') }}" class="cta-button">Get Started Today</a>
        </div>
    </div>
</div>

<style>
    .about-page-container {
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
        background: white;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 50px;
        margin-bottom: 60px;
    }
    
    .intro-content h2 {
        font-weight: 700;
        margin-bottom: 20px;
        color: #333;
    }
    
    .intro-content p {
        font-size: 16px;
        line-height: 1.7;
        color: #555;
        margin-bottom: 20px;
    }
    
    .intro-image img {
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .section-title {
        margin-bottom: 50px;
        position: relative;
        font-weight: 700;
        color: #333;
    }
    
    .section-title:after {
        content: "";
        display: block;
        width: 50px;
        height: 3px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 20px auto 0;
    }
    
    .features-section {
        margin-bottom: 70px;
    }
    
    .features-grid {
        margin-bottom: 20px;
    }
    
    .feature-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 30px;
        margin-bottom: 30px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .feature-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        color: white;
        font-size: 24px;
    }
    
    .feature-card h3 {
        margin-bottom: 15px;
        font-weight: 600;
        color: #333;
    }
    
    .feature-card p {
        color: #666;
        line-height: 1.6;
    }
    
    .team-section {
        margin-bottom: 70px;
    }
    
    .team-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 20px;
        text-align: center;
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
    }
    
    .team-image {
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
        overflow: hidden;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .team-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .team-card h3 {
        margin-bottom: 5px;
        font-weight: 600;
        color: #333;
    }
    
    .team-card .position {
        color: #764ba2;
        font-weight: 500;
        margin-bottom: 10px;
    }
    
    .team-card .bio {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
    }
    
    .cta-section {
        background: linear-gradient(135deg, #f5f7fa 0%, #e8eaf6 100%);
        padding: 60px 30px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .cta-section h2 {
        font-weight: 700;
        margin-bottom: 15px;
        color: #333;
    }
    
    .cta-section p {
        font-size: 18px;
        color: #555;
        max-width: 700px;
        margin: 0 auto 30px;
    }
    
    .cta-button {
        display: inline-block;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 30px;
        text-decoration: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 5px 15px rgba(118, 75, 162, 0.4);
    }
    
    .cta-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(118, 75, 162, 0.5);
        color: white;
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
        .intro-image {
            margin-top: 30px;
        }
        
        .content-section {
            padding: 30px;
        }
    }
</style>
@endsection