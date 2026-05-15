<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mind Share Connect – Ideas Innovation Inspiration</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet" />
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            display: ['Syne', 'sans-serif'],
            body: ['DM Sans', 'sans-serif'],
          },
          colors: {
            brand: {
              DEFAULT: '#E05C1A',
              light: '#F07840',
              dark: '#B84610',
            },
            dark: {
              900: '#080A0E',
              800: '#0F1318',
              700: '#161C24',
              600: '#1E2733',
              500: '#263040',
            },
          },
          animation: {
            'marquee': 'marquee 32s linear infinite',
            'pulse-slow': 'pulse 4s ease-in-out infinite',
          },
          keyframes: {
            marquee: {
              '0%': { transform: 'translateX(0%)' },
              '100%': { transform: 'translateX(-50%)' },
            },
          },
        },
      },
    }
  </script>
  <style>
    body { font-family: 'DM Sans', sans-serif; background-color: #080A0E; color: #e2e8f0; }
    h1,h2,h3,h4,h5,h6,.font-display { font-family: 'Syne', sans-serif; }
    .gradient-text {
      background: linear-gradient(135deg, #fff 20%, #E05C1A 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }
    .card-glow { box-shadow: 0 0 40px rgba(224,92,26,0.1); }
    .hero-glow { background: radial-gradient(ellipse 60% 50% at 50% 0%, rgba(224,92,26,0.15) 0%, transparent 70%); }
    .pill { background: rgba(224,92,26,0.10); border: 1px solid rgba(224,92,26,0.3); }
    .nav-blur { backdrop-filter: blur(16px); background: rgba(8,10,14,0.85); }
    .service-card:hover { transform: translateY(-4px); border-color: rgba(224,92,26,0.5); }
    .project-card:hover .project-overlay { opacity: 1; }
    .project-overlay { opacity: 0; transition: opacity 0.3s ease; }
    .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.35s ease, padding 0.2s ease; }
    .faq-answer.open { max-height: 600px; padding-top: 0.75rem; }
    .faq-icon { transition: transform 0.3s ease; }
    .faq-icon.open { transform: rotate(45deg); }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
    .float { animation: float 5s ease-in-out infinite; }
    .testimonial-card { background: linear-gradient(135deg, rgba(30,39,51,0.8) 0%, rgba(22,28,36,0.8) 100%); }
    .team-img { width:100%; height:100%; object-fit:cover; }
  </style>
</head>
<body class="antialiased">
        {{$slot}}
  </body>
</html>
