<!DOCTYPE html>
<html lang="en">
<head><script src="https://static.readdy.ai/static/e.js"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AI Prompt Optimizer </title>
<script src="https://cdn.tailwindcss.com/3.4.16"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
<script>
tailwind.config = {
theme: {
extend: {
colors: {
primary: '#667eea',
secondary: '#764ba2',
accent: '#fbbf24'
},
borderRadius: {
'none': '0px',
'sm': '4px',
DEFAULT: '8px',
'md': '12px',
'lg': '16px',
'xl': '20px',
'2xl': '24px',
'3xl': '32px',
'full': '9999px',
'button': '8px'
},
fontFamily: {
'inter': ['Inter', 'sans-serif']
}
}
}
}
</script>
<style>
:where([class^="ri-"])::before {
content: "\f3c2";
}
body {
font-family: 'Inter', sans-serif;
}
.gradient-bg {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.gradient-text {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}
.glass-effect {
backdrop-filter: blur(10px);
background: rgba(255, 255, 255, 0.9);
}
.hero-bg {
background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
}
.stats-counter {
animation: countUp 2s ease-out;
}
@keyframes countUp {
from { opacity: 0; transform: translateY(20px); }
to { opacity: 1; transform: translateY(0); }
}
.feature-card {
transition: all 0.3s ease;
}
.feature-card:hover {
transform: translateY(-5px);
}
.code-block {
background: #1e293b;
border-radius: 8px;
padding: 1rem;
font-family: 'Monaco', 'Menlo', monospace;
}
.testimonial-card {
background: rgba(255, 255, 255, 0.95);
backdrop-filter: blur(10px);
}
</style>
</head>
<body class="font-inter">
<!-- Header -->
@include('home.body.header')
<!-- Hero Section -->
@yield('home')
<!-- Footer -->
@include('home.body.footer')

<script id="smooth-scroll">
document.addEventListener('DOMContentLoaded', function() {
const links = document.querySelectorAll('a[href^="#"]');
links.forEach(link => {
link.addEventListener('click', function(e) {
e.preventDefault();
const targetId = this.getAttribute('href');
const targetElement = document.querySelector(targetId);
if (targetElement) {
targetElement.scrollIntoView({
behavior: 'smooth',
block: 'start'
});
}
});
});
});
</script>
<script id="stats-animation">
document.addEventListener('DOMContentLoaded', function() {
const observer = new IntersectionObserver((entries) => {
entries.forEach(entry => {
if (entry.isIntersecting) {
entry.target.classList.add('stats-counter');
}
});
});
document.querySelectorAll('.stats-counter').forEach(el => {
observer.observe(el);
});
});
</script>
<script id="mobile-menu">
document.addEventListener('DOMContentLoaded', function() {
const header = document.querySelector('header');
let lastScrollY = window.scrollY;
window.addEventListener('scroll', () => {
if (window.scrollY > 100) {
header.classList.add('shadow-lg');
} else {
header.classList.remove('shadow-lg');
}
});
});
</script>
 
<script src="https://static.readdy.ai/static/share.js"></script></body>
</html>