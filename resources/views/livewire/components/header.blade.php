<!-- ===== NAVBAR ===== -->
  <header class="fixed top-0 left-0 right-0 z-50 nav-blur border-b border-white/5">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-16">
      <a href="#" class="font-display text-xl font-bold text-white tracking-tight flex items-center gap-2">
        <span class="w-8 h-8 rounded-lg bg-brand flex items-center justify-center text-white font-bold text-sm">M</span>
        Mind Share Connect
      </a>
      <nav class="hidden md:flex items-center gap-8 text-sm text-slate-300">
        <a href="{{route('home')}}" class="hover:text-white transition-colors">Home</a>
        <a href="{{route('about-us')}}" class="hover:text-white transition-colors">About Us</a>
        <a href="{{route('our-services')}}" class="hover:text-white transition-colors">Our Services</a>
        <a href="{{route('our-teams')}}"         class="hover:text-white transition-colors">Team</a>
        <a href="{{route('clientele')}}"      class="hover:text-white transition-colors">Clientele</a>
        <a href="#testimonials" class="hover:text-white transition-colors">Testimonials</a>
      </nav>
      <a href="#contact" class="hidden md:inline-flex items-center gap-2 px-5 py-2 rounded-full bg-brand text-white text-sm font-medium hover:bg-brand-dark transition-colors">
        Contact Us
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </a>
      <button id="menu-btn" class="md:hidden text-slate-300 hover:text-white">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
    </div>
    <div id="mobile-menu" class="hidden md:hidden px-6 pb-4 flex-col gap-1 text-sm text-slate-300 border-t border-white/5">
      <a href="#about"        class="block py-2 hover:text-white">About Us</a>
      <a href="#services"     class="block py-2 hover:text-white">Our Services</a>
      <a href="#team"         class="block py-2 hover:text-white">Team</a>
      <a href="#clients"      class="block py-2 hover:text-white">Clientele</a>
      <a href="#testimonials" class="block py-2 hover:text-white">Testimonials</a>
      <a href="#contact"      class="block py-2 hover:text-white">Contact Us</a>
    </div>
  </header>

