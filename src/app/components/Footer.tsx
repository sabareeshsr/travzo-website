import { Facebook, Instagram, Twitter, Youtube, Mail, Phone, MapPin } from 'lucide-react';

export function Footer() {
  return (
    <footer className="bg-[#1A2A5E] text-white">
      {/* Main Footer Content */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {/* Column 1 - Brand */}
          <div>
            <h2 className="text-3xl font-bold mb-4">Travzo</h2>
            <p className="text-gray-300 mb-6 leading-relaxed">
              Creating unforgettable travel experiences for the modern Indian
              traveler. Your journey, our passion.
            </p>
            <div className="flex gap-4">
              <a
                href="#"
                className="w-10 h-10 bg-[#C9A227] rounded-full flex items-center justify-center hover:bg-[#b08f1f] transition-colors"
              >
                <Facebook className="w-5 h-5" />
              </a>
              <a
                href="#"
                className="w-10 h-10 bg-[#C9A227] rounded-full flex items-center justify-center hover:bg-[#b08f1f] transition-colors"
              >
                <Instagram className="w-5 h-5" />
              </a>
              <a
                href="#"
                className="w-10 h-10 bg-[#C9A227] rounded-full flex items-center justify-center hover:bg-[#b08f1f] transition-colors"
              >
                <Twitter className="w-5 h-5" />
              </a>
              <a
                href="#"
                className="w-10 h-10 bg-[#C9A227] rounded-full flex items-center justify-center hover:bg-[#b08f1f] transition-colors"
              >
                <Youtube className="w-5 h-5" />
              </a>
            </div>
          </div>

          {/* Column 2 - Quick Links */}
          <div>
            <h3 className="text-xl font-bold mb-4">Quick Links</h3>
            <ul className="space-y-3">
              <li>
                <a
                  href="#"
                  className="text-gray-300 hover:text-[#C9A227] transition-colors"
                >
                  About Us
                </a>
              </li>
              <li>
                <a
                  href="#"
                  className="text-gray-300 hover:text-[#C9A227] transition-colors"
                >
                  Our Team
                </a>
              </li>
              <li>
                <a
                  href="#"
                  className="text-gray-300 hover:text-[#C9A227] transition-colors"
                >
                  Testimonials
                </a>
              </li>
              <li>
                <a
                  href="#"
                  className="text-gray-300 hover:text-[#C9A227] transition-colors"
                >
                  Blog
                </a>
              </li>
              <li>
                <a
                  href="#"
                  className="text-gray-300 hover:text-[#C9A227] transition-colors"
                >
                  Contact Us
                </a>
              </li>
              <li>
                <a
                  href="#"
                  className="text-gray-300 hover:text-[#C9A227] transition-colors"
                >
                  Privacy Policy
                </a>
              </li>
            </ul>
          </div>

          {/* Column 3 - Package Types */}
          <div>
            <h3 className="text-xl font-bold mb-4">Package Types</h3>
            <ul className="space-y-3">
              <li>
                <a
                  href="#"
                  className="text-gray-300 hover:text-[#C9A227] transition-colors"
                >
                  Honeymoon Packages
                </a>
              </li>
              <li>
                <a
                  href="#"
                  className="text-gray-300 hover:text-[#C9A227] transition-colors"
                >
                  Group Tours
                </a>
              </li>
              <li>
                <a
                  href="#"
                  className="text-gray-300 hover:text-[#C9A227] transition-colors"
                >
                  Solo Trips
                </a>
              </li>
              <li>
                <a
                  href="#"
                  className="text-gray-300 hover:text-[#C9A227] transition-colors"
                >
                  Devotional Tours
                </a>
              </li>
              <li>
                <a
                  href="#"
                  className="text-gray-300 hover:text-[#C9A227] transition-colors"
                >
                  Destination Weddings
                </a>
              </li>
              <li>
                <a
                  href="#"
                  className="text-gray-300 hover:text-[#C9A227] transition-colors"
                >
                  International Packages
                </a>
              </li>
            </ul>
          </div>

          {/* Column 4 - Contact Details */}
          <div>
            <h3 className="text-xl font-bold mb-4">Contact Details</h3>
            <ul className="space-y-4">
              <li className="flex items-start gap-3">
                <Phone className="w-5 h-5 text-[#C9A227] flex-shrink-0 mt-1" />
                <div>
                  <p className="text-gray-300">+91 98765 43210</p>
                  <p className="text-gray-300">+91 98765 43211</p>
                </div>
              </li>
              <li className="flex items-start gap-3">
                <Mail className="w-5 h-5 text-[#C9A227] flex-shrink-0 mt-1" />
                <div>
                  <p className="text-gray-300">info@travzoholidays.com</p>
                </div>
              </li>
              <li className="flex items-start gap-3">
                <MapPin className="w-5 h-5 text-[#C9A227] flex-shrink-0 mt-1" />
                <div>
                  <p className="text-gray-300">
                    123 Travel Street, Tourism District
                    <br />
                    Mumbai, Maharashtra 400001
                  </p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      {/* Bottom Bar */}
      <div className="border-t border-[#C9A227]">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <p className="text-center text-gray-400 text-sm">
            © {new Date().getFullYear()} Travzo Holidays. All rights reserved.
            Crafted with passion for travelers.
          </p>
        </div>
      </div>
    </footer>
  );
}
