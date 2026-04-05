import { Phone, Mail, ChevronDown, Menu, X, Facebook, Instagram, Youtube } from 'lucide-react';
import { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router';

export function EnhancedHeader() {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [activeDropdown, setActiveDropdown] = useState<string | null>(null);
  const [isScrolled, setIsScrolled] = useState(false);
  const location = useLocation();

  const isActive = (path: string) => location.pathname === path;

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 10);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const megaMenus = {
    'group-tours': {
      columns: [
        {
          heading: 'India',
          items: ['Kerala', 'Rajasthan', 'Himachal', 'Kashmir', 'Goa', 'Northeast', 'Andaman'],
        },
        {
          heading: 'International',
          items: ['Bali', 'Thailand', 'Singapore', 'Malaysia', 'Dubai', 'Europe', 'USA'],
        },
        {
          heading: 'Africa',
          items: ['Kenya', 'Tanzania', 'Morocco', 'South Africa', 'Seychelles'],
        },
        {
          heading: 'America',
          items: ['USA', 'Canada', 'South America', 'Central America'],
        },
      ],
      cta: 'View All Group Tours',
      link: '/packages/group-tours',
    },
    honeymoon: {
      columns: [
        {
          heading: 'Island Escapes',
          items: ['Maldives', 'Bali', 'Mauritius', 'Seychelles', 'Sri Lanka', 'Andaman'],
        },
        {
          heading: 'Asia',
          items: ['Thailand', 'Phuket', 'Krabi', 'Singapore', 'Malaysia', 'Vietnam'],
        },
        {
          heading: 'Europe',
          items: ['Paris', 'Switzerland', 'Italy', 'Greece', 'Croatia', 'Spain'],
        },
        {
          heading: 'Middle East',
          items: ['Dubai', 'Abu Dhabi', 'Jordan', 'Oman'],
        },
      ],
      cta: 'View All Honeymoon Packages',
      link: '/packages/honeymoon',
    },
    devotional: {
      columns: [
        {
          heading: 'South India',
          items: ['Tirupati', 'Rameshwaram', 'Madurai', 'Sabarimala', 'Kanchipuram'],
        },
        {
          heading: 'North India',
          items: ['Varanasi', 'Haridwar', 'Rishikesh', 'Char Dham', 'Ayodhya', 'Shirdi'],
        },
      ],
      cta: 'View All Devotional Tours',
      link: '/packages/devotional',
    },
    'destination-wedding': {
      columns: [
        {
          heading: 'India Venues',
          items: ['Rajasthan', 'Goa', 'Kerala', 'Udaipur', 'Jaipur'],
        },
        {
          heading: 'International',
          items: ['Bali', 'Thailand', 'Maldives', 'Sri Lanka', 'Malaysia'],
        },
      ],
      cta: 'View All Wedding Packages',
      link: '/packages/destination-wedding',
    },
  };

  const soloTrips = [
    'Solo Kerala',
    'Solo Himachal',
    'Solo Northeast',
    'Solo Bali',
    'Solo Thailand',
    'Solo Europe',
  ];

  return (
    <header className={`sticky top-0 z-50 bg-white transition-shadow ${isScrolled ? 'shadow-lg' : ''}`}>
      {/* Top Utility Bar - Hidden on Mobile */}
      <div className="hidden md:block bg-[#1A2A5E] text-white">
        <div className="px-8">
          <div className="flex items-center justify-between h-9">
            <p className="text-[11px] text-white">Tamil Nadu's Most Trusted Travel Partner</p>
            <div className="flex items-center gap-4">
              <a href="mailto:hello@travzoholidays.com" className="text-[11px] text-white hover:text-[#C9A227] transition-colors">
                hello@travzoholidays.com
              </a>
              <div className="flex items-center gap-4">
                <a href="#" className="text-white hover:text-[#C9A227] transition-colors">
                  <Instagram className="w-[14px] h-[14px]" />
                </a>
                <a href="#" className="text-white hover:text-[#C9A227] transition-colors">
                  <Facebook className="w-[14px] h-[14px]" />
                </a>
                <a href="#" className="text-white hover:text-[#C9A227] transition-colors">
                  <Youtube className="w-[14px] h-[14px]" />
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Main Navigation Bar */}
      <div className="bg-white border-b border-[#E5E7EB]">
        <div className="px-4 sm:px-8">
          <div className="flex items-center justify-between h-[72px]">
            {/* Logo - Far Left */}
            <Link to="/" className="ml-0 mr-4 sm:mr-12">
              <span className="text-[24px] sm:text-[32px] font-bold text-[#1A2A5E]" style={{ fontFamily: 'Playfair Display, serif' }}>
                Travzo
              </span>
            </Link>

            {/* Desktop Navigation - Center Group */}
            <nav className="hidden lg:flex items-center gap-6 flex-1 justify-center">
              <Link
                to="/"
                className={`text-[13px] font-semibold uppercase tracking-[1.5px] transition-colors whitespace-nowrap ${
                  isActive('/') ? 'text-[#C9A227]' : 'text-[#1A2A5E] hover:text-[#C9A227]'
                }`}
                style={{ fontFamily: 'Inter, sans-serif' }}
              >
                Home
              </Link>
              <Link
                to="/about"
                className={`text-[13px] font-semibold uppercase tracking-[1.5px] transition-colors whitespace-nowrap ${
                  isActive('/about') ? 'text-[#C9A227]' : 'text-[#1A2A5E] hover:text-[#C9A227]'
                }`}
                style={{ fontFamily: 'Inter, sans-serif' }}
              >
                About
              </Link>

              {/* Group Tours Dropdown */}
              <div
                className="relative"
                onMouseEnter={() => setActiveDropdown('group-tours')}
                onMouseLeave={() => setActiveDropdown(null)}
              >
                <button className="flex items-center text-[13px] font-semibold uppercase tracking-[1.5px] text-[#1A2A5E] hover:text-[#C9A227] transition-colors whitespace-nowrap" style={{ fontFamily: 'Inter, sans-serif' }}>
                  Group Tours
                  <ChevronDown className="w-[10px] h-[10px] text-[#C9A227] ml-1" />
                </button>
                {activeDropdown === 'group-tours' && (
                  <div className="absolute top-full left-1/2 -translate-x-1/2 pt-4 w-screen max-w-5xl">
                    <div className="bg-white border-t-[3px] border-t-[#C9A227] shadow-xl rounded-b-lg p-8">
                      <div className="grid grid-cols-4 gap-8">
                        {megaMenus['group-tours'].columns.map((column, idx) => (
                          <div key={idx}>
                            <h3 className="text-xs font-bold uppercase text-[#1A2A5E] mb-3">
                              {column.heading}
                            </h3>
                            <ul className="space-y-2">
                              {column.items.map((item) => (
                                <li key={item}>
                                  <a
                                    href="#"
                                    className="text-[13px] text-[#1A2A5E] hover:text-[#C9A227] hover:translate-x-1 transition-all inline-flex items-center gap-1 group"
                                  >
                                    {item}
                                    <span className="opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                                  </a>
                                </li>
                              ))}
                            </ul>
                          </div>
                        ))}
                      </div>
                      <div className="mt-6 flex justify-end">
                        <Link
                          to={megaMenus['group-tours'].link}
                          className="bg-[#C9A227] text-[#1A2A5E] px-6 py-2 rounded-lg hover:bg-[#b08f1f] transition-colors font-semibold text-sm"
                        >
                          {megaMenus['group-tours'].cta} →
                        </Link>
                      </div>
                    </div>
                  </div>
                )}
              </div>

              {/* Honeymoon Dropdown */}
              <div
                className="relative"
                onMouseEnter={() => setActiveDropdown('honeymoon')}
                onMouseLeave={() => setActiveDropdown(null)}
              >
                <button className="flex items-center text-[13px] font-semibold uppercase tracking-[1.5px] text-[#1A2A5E] hover:text-[#C9A227] transition-colors whitespace-nowrap" style={{ fontFamily: 'Inter, sans-serif' }}>
                  Honeymoon
                  <ChevronDown className="w-[10px] h-[10px] text-[#C9A227] ml-1" />
                </button>
                {activeDropdown === 'honeymoon' && (
                  <div className="absolute top-full left-1/2 -translate-x-1/2 pt-4 w-screen max-w-5xl">
                    <div className="bg-white border-t-[3px] border-t-[#C9A227] shadow-xl rounded-b-lg p-8">
                      <div className="grid grid-cols-4 gap-8">
                        {megaMenus.honeymoon.columns.map((column, idx) => (
                          <div key={idx}>
                            <h3 className="text-xs font-bold uppercase text-[#1A2A5E] mb-3">
                              {column.heading}
                            </h3>
                            <ul className="space-y-2">
                              {column.items.map((item) => (
                                <li key={item}>
                                  <a
                                    href="#"
                                    className="text-[13px] text-[#1A2A5E] hover:text-[#C9A227] hover:translate-x-1 transition-all inline-flex items-center gap-1 group"
                                  >
                                    {item}
                                    <span className="opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                                  </a>
                                </li>
                              ))}
                            </ul>
                          </div>
                        ))}
                      </div>
                      <div className="mt-6 flex justify-end">
                        <Link
                          to={megaMenus.honeymoon.link}
                          className="bg-[#C9A227] text-[#1A2A5E] px-6 py-2 rounded-lg hover:bg-[#b08f1f] transition-colors font-semibold text-sm"
                        >
                          {megaMenus.honeymoon.cta} →
                        </Link>
                      </div>
                    </div>
                  </div>
                )}
              </div>

              {/* Devotional Dropdown */}
              <div
                className="relative"
                onMouseEnter={() => setActiveDropdown('devotional')}
                onMouseLeave={() => setActiveDropdown(null)}
              >
                <button className="flex items-center text-[13px] font-semibold uppercase tracking-[1.5px] text-[#1A2A5E] hover:text-[#C9A227] transition-colors whitespace-nowrap" style={{ fontFamily: 'Inter, sans-serif' }}>
                  Devotional
                  <ChevronDown className="w-[10px] h-[10px] text-[#C9A227] ml-1" />
                </button>
                {activeDropdown === 'devotional' && (
                  <div className="absolute top-full left-1/2 -translate-x-1/2 pt-4 w-screen max-w-3xl">
                    <div className="bg-white border-t-[3px] border-t-[#C9A227] shadow-xl rounded-b-lg p-8">
                      <div className="grid grid-cols-2 gap-8">
                        {megaMenus.devotional.columns.map((column, idx) => (
                          <div key={idx}>
                            <h3 className="text-xs font-bold uppercase text-[#1A2A5E] mb-3">
                              {column.heading}
                            </h3>
                            <ul className="space-y-2">
                              {column.items.map((item) => (
                                <li key={item}>
                                  <a
                                    href="#"
                                    className="text-[13px] text-[#1A2A5E] hover:text-[#C9A227] hover:translate-x-1 transition-all inline-flex items-center gap-1 group"
                                  >
                                    {item}
                                    <span className="opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                                  </a>
                                </li>
                              ))}
                            </ul>
                          </div>
                        ))}
                      </div>
                      <div className="mt-6 flex justify-end">
                        <Link
                          to={megaMenus.devotional.link}
                          className="bg-[#C9A227] text-[#1A2A5E] px-6 py-2 rounded-lg hover:bg-[#b08f1f] transition-colors font-semibold text-sm"
                        >
                          {megaMenus.devotional.cta} →
                        </Link>
                      </div>
                    </div>
                  </div>
                )}
              </div>

              {/* Destination Wedding Dropdown */}
              <div
                className="relative"
                onMouseEnter={() => setActiveDropdown('destination-wedding')}
                onMouseLeave={() => setActiveDropdown(null)}
              >
                <button className="flex items-center text-[13px] font-semibold uppercase tracking-[1.5px] text-[#1A2A5E] hover:text-[#C9A227] transition-colors whitespace-nowrap" style={{ fontFamily: 'Inter, sans-serif' }}>
                  Destination Wedding
                  <ChevronDown className="w-[10px] h-[10px] text-[#C9A227] ml-1" />
                </button>
                {activeDropdown === 'destination-wedding' && (
                  <div className="absolute top-full left-1/2 -translate-x-1/2 pt-4 w-screen max-w-2xl">
                    <div className="bg-white border-t-[3px] border-t-[#C9A227] shadow-xl rounded-b-lg p-8">
                      <div className="grid grid-cols-2 gap-8">
                        {megaMenus['destination-wedding'].columns.map((column, idx) => (
                          <div key={idx}>
                            <h3 className="text-xs font-bold uppercase text-[#1A2A5E] mb-3">
                              {column.heading}
                            </h3>
                            <ul className="space-y-2">
                              {column.items.map((item) => (
                                <li key={item}>
                                  <a
                                    href="#"
                                    className="text-[13px] text-[#1A2A5E] hover:text-[#C9A227] hover:translate-x-1 transition-all inline-flex items-center gap-1 group"
                                  >
                                    {item}
                                    <span className="opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                                  </a>
                                </li>
                              ))}
                            </ul>
                          </div>
                        ))}
                      </div>
                      <div className="mt-6 flex justify-end">
                        <Link
                          to={megaMenus['destination-wedding'].link}
                          className="bg-[#C9A227] text-[#1A2A5E] px-6 py-2 rounded-lg hover:bg-[#b08f1f] transition-colors font-semibold text-sm"
                        >
                          {megaMenus['destination-wedding'].cta} →
                        </Link>
                      </div>
                    </div>
                  </div>
                )}
              </div>

              {/* Solo Trips Dropdown */}
              <div
                className="relative"
                onMouseEnter={() => setActiveDropdown('solo-trips')}
                onMouseLeave={() => setActiveDropdown(null)}
              >
                <button className="flex items-center text-[13px] font-semibold uppercase tracking-[1.5px] text-[#1A2A5E] hover:text-[#C9A227] transition-colors whitespace-nowrap" style={{ fontFamily: 'Inter, sans-serif' }}>
                  Solo Trips
                  <ChevronDown className="w-[10px] h-[10px] text-[#C9A227] ml-1" />
                </button>
                {activeDropdown === 'solo-trips' && (
                  <div className="absolute top-full right-0 pt-4 w-64">
                    <div className="bg-white border-t-[3px] border-t-[#C9A227] shadow-xl rounded-b-lg p-6">
                      <ul className="space-y-2">
                        {soloTrips.map((item) => (
                          <li key={item}>
                            <a
                              href="#"
                              className="text-[13px] text-[#1A2A5E] hover:text-[#C9A227] hover:translate-x-1 transition-all inline-flex items-center gap-1 group"
                            >
                              {item}
                              <span className="opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                            </a>
                          </li>
                        ))}
                      </ul>
                      <Link
                        to="/packages/solo-trips"
                        className="block mt-4 text-[#C9A227] font-semibold text-sm hover:underline"
                      >
                        Explore Solo Trips →
                      </Link>
                    </div>
                  </div>
                )}
              </div>

              <Link
                to="/blog"
                className={`text-[13px] font-semibold uppercase tracking-[1.5px] transition-colors whitespace-nowrap ${
                  isActive('/blog') ? 'text-[#C9A227]' : 'text-[#1A2A5E] hover:text-[#C9A227]'
                }`}
                style={{ fontFamily: 'Inter, sans-serif' }}
              >
                Blog
              </Link>
              <Link
                to="/contact"
                className={`text-[13px] font-semibold uppercase tracking-[1.5px] transition-colors whitespace-nowrap ${
                  isActive('/contact') ? 'text-[#C9A227]' : 'text-[#1A2A5E] hover:text-[#C9A227]'
                }`}
                style={{ fontFamily: 'Inter, sans-serif' }}
              >
                Contact
              </Link>
            </nav>

            {/* Phone Button - Far Right */}
            <div className="hidden lg:flex items-center ml-12 mr-0">
              <a
                href="tel:+919876543210"
                className="flex items-center gap-2 bg-[#C9A227] text-[#1A2A5E] rounded-[999px] hover:bg-[#b08f1f] transition-colors whitespace-nowrap"
                style={{ padding: '14px 24px' }}
              >
                <Phone className="w-[14px] h-[14px]" />
                <span className="text-[14px] font-bold">+91 98765 43210</span>
              </a>
            </div>

            {/* Mobile Menu Button */}
            <button
              onClick={() => setIsMenuOpen(!isMenuOpen)}
              className="lg:hidden text-[#1A2A5E] p-2"
            >
              {isMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile Menu */}
      {isMenuOpen && (
        <div className="lg:hidden fixed inset-0 top-[72px] bg-white z-50 overflow-y-auto">
          <nav className="flex flex-col p-6 space-y-4">
            <Link
              to="/"
              className="text-[#1A2A5E] hover:text-[#C9A227] transition-colors font-medium py-2"
              onClick={() => setIsMenuOpen(false)}
            >
              Home
            </Link>
            <Link
              to="/about"
              className="text-[#1A2A5E] hover:text-[#C9A227] transition-colors font-medium py-2"
              onClick={() => setIsMenuOpen(false)}
            >
              About
            </Link>
            <Link
              to="/packages/group-tours"
              className="text-[#1A2A5E] hover:text-[#C9A227] transition-colors font-medium py-2"
              onClick={() => setIsMenuOpen(false)}
            >
              Group Tours
            </Link>
            <Link
              to="/packages/honeymoon"
              className="text-[#1A2A5E] hover:text-[#C9A227] transition-colors font-medium py-2"
              onClick={() => setIsMenuOpen(false)}
            >
              Honeymoon
            </Link>
            <Link
              to="/packages/devotional"
              className="text-[#1A2A5E] hover:text-[#C9A227] transition-colors font-medium py-2"
              onClick={() => setIsMenuOpen(false)}
            >
              Devotional
            </Link>
            <Link
              to="/packages/destination-wedding"
              className="text-[#1A2A5E] hover:text-[#C9A227] transition-colors font-medium py-2"
              onClick={() => setIsMenuOpen(false)}
            >
              Destination Wedding
            </Link>
            <Link
              to="/packages/solo-trips"
              className="text-[#1A2A5E] hover:text-[#C9A227] transition-colors font-medium py-2"
              onClick={() => setIsMenuOpen(false)}
            >
              Solo Trips
            </Link>
            <Link
              to="/blog"
              className="text-[#1A2A5E] hover:text-[#C9A227] transition-colors font-medium py-2"
              onClick={() => setIsMenuOpen(false)}
            >
              Blog
            </Link>
            <Link
              to="/contact"
              className="text-[#1A2A5E] hover:text-[#C9A227] transition-colors font-medium py-2"
              onClick={() => setIsMenuOpen(false)}
            >
              Contact
            </Link>
            <a
              href="tel:+919876543210"
              className="bg-[#C9A227] text-[#1A2A5E] px-6 py-3 rounded-full hover:bg-[#b08f1f] transition-colors font-bold text-center mt-4"
            >
              Call Us Now
            </a>
          </nav>
        </div>
      )}
    </header>
  );
}