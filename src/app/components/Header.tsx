import { Phone, Menu } from 'lucide-react';
import { useState } from 'react';

export function Header() {
  const [isMenuOpen, setIsMenuOpen] = useState(false);

  const navLinks = [
    'Home',
    'About',
    'Group Tours',
    'Honeymoon',
    'Devotional',
    'Destination Wedding',
    'Solo Trips',
    'Blog',
    'Contact',
  ];

  return (
    <header className="sticky top-0 z-50 bg-white shadow-sm">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-20">
          {/* Logo */}
          <div className="flex-shrink-0">
            <h1 className="text-3xl font-bold text-[#1A2A5E]">Travzo</h1>
          </div>

          {/* Desktop Navigation */}
          <nav className="hidden lg:flex space-x-8">
            {navLinks.map((link) => (
              <a
                key={link}
                href={`#${link.toLowerCase().replace(/\s+/g, '-')}`}
                className="text-[#1A2A5E] hover:text-[#C9A227] transition-colors font-medium"
              >
                {link}
              </a>
            ))}
          </nav>

          {/* Phone Button */}
          <div className="hidden lg:flex items-center">
            <a
              href="tel:+919876543210"
              className="flex items-center gap-2 bg-[#C9A227] text-white px-6 py-3 rounded-full hover:bg-[#b08f1f] transition-colors"
            >
              <Phone className="w-4 h-4" />
              <span>+91 98765 43210</span>
            </a>
          </div>

          {/* Mobile Menu Button */}
          <button
            onClick={() => setIsMenuOpen(!isMenuOpen)}
            className="lg:hidden text-[#1A2A5E] p-2"
          >
            <Menu className="w-6 h-6" />
          </button>
        </div>

        {/* Mobile Menu */}
        {isMenuOpen && (
          <div className="lg:hidden py-4 border-t border-gray-200">
            <nav className="flex flex-col space-y-4">
              {navLinks.map((link) => (
                <a
                  key={link}
                  href={`#${link.toLowerCase().replace(/\s+/g, '-')}`}
                  className="text-[#1A2A5E] hover:text-[#C9A227] transition-colors font-medium"
                  onClick={() => setIsMenuOpen(false)}
                >
                  {link}
                </a>
              ))}
              <a
                href="tel:+919876543210"
                className="flex items-center gap-2 bg-[#C9A227] text-white px-6 py-3 rounded-full hover:bg-[#b08f1f] transition-colors w-fit"
              >
                <Phone className="w-4 h-4" />
                <span>+91 98765 43210</span>
              </a>
            </nav>
          </div>
        )}
      </div>
    </header>
  );
}
