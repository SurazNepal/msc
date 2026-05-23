<div>
    <livewire:Components.Header />

    <livewire:Home.Sections.HeroSection />
    <livewire:Home.Sections.ClientMarqueeSection />
    <livewire:Home.Sections.AboutSection />
    <livewire:Home.Sections.ServiceSection />
    <livewire:Home.Sections.HowWeWorkSection />
    <livewire:Home.Sections.ProjectSection />
    <livewire:Home.Sections.TeamSection />
    <livewire:Home.Sections.TestimonialSection />
    <livewire:Home.Sections.FAQSection />
    <livewire:Home.Sections.ClienteleSection />
    <livewire:Home.Sections.ContactSection />

    <livewire:Components.Footer />

    <script>
    // Mobile menu
    document.getElementById('menu-btn').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
        menu.classList.toggle('flex');
    });

    // FAQ accordion
    function toggleFaq(btn) {
        const answer = btn.nextElementSibling;
        const icon = btn.querySelector('.faq-icon');
        const isOpen = answer.classList.contains('open');
        document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('open'));
        document.querySelectorAll('.faq-icon').forEach(i => i.classList.remove('open'));
        if (!isOpen) {
            answer.classList.add('open');
            icon.classList.add('open');
        }
    }
    // Scroll nav effect
    window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        header.style.borderBottomColor = window.scrollY > 50 ? 'rgba(255,255,255,0.08)' : 'rgba(255,255,255,0.05)';
    });
    </script>
</div>
