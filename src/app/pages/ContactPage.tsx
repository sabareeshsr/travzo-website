
`import { Link } from 'react-router';
import { Phone, Mail, MapPin, Clock, MessageSquare } from 'lucide-react';
import { Newsletter } from '../components/Newsletter';

export default function ContactPage() {
  const branches = [
    {
      city: 'Chennai',
      address: '123 Anna Salai, Mount Road, Chennai, Tamil Nadu 600002',
      phone: '+91 98765 43210',
    },
    {
      city: 'Coimbatore',
      address: '456 RS Puram, Coimbatore, Tamil Nadu 641002',
      phone: '+91 98765 43211',
    },
    {
      city: 'Madurai',
      address: '789 West Masi Street, Madurai, Tamil Nadu 625001',
      phone: '+91 98765 43212',
    },
    {
      city: 'Trichy',
      address: '321 Thillai Nagar, Tiruchirappalli, Tamil Nadu 620018',
      phone: '+91 98765 43213',
    },
  ];

  return (
    <>
      {/* Page Hero */}
      <section className="relative h-[60vh] flex items-center justify-center">
        <div className="absolute inset-0">
          <img
            src="https://images.unsplash.com/photo-1571648393873-29bad2324860?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx0cmF2ZWwlMjBibG9nJTIwd3JpdGluZyUyMGpvdXJuYWx8ZW58MXx8fHwxNzc0ODUxNjM1fDA&ixlib=rb-4.1.0&q=80&w=1080"
            alt="Contact Hero"
            className="w-full h-full object-cover"
          />
          <div className="absolute inset-0 bg-[#1A2A5E] opacity-50"></div>
        </div>

        <div className="relative z-10 text-center px-4 max-w-4xl mx-auto">
          <h1 className="text-5xl md:text-6xl font-bold text-white mb-4">
            Get In Touch
          </h1>
          <p className="text-xl text-white/80">
            We're here to help you plan your perfect journey
          </p>
        </div>
      </section>

      {/* Main Contact Section */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-5 gap-12">
            {/* Left Column - Contact Details */}
            <div className="lg:col-span-2">
              <div className="bg-[#1A2A5E] rounded-2xl p-8 text-white">
                <h2 className="text-2xl font-bold text-[#C9A227] mb-8">
                  Contact Details
                </h2>

                {/* Contact Info */}
                <div className="space-y-6 mb-8">
                  <div className="flex items-start gap-4">
                    <div className="w-12 h-12 bg-[#C9A227] rounded-full flex items-center justify-center flex-shrink-0">
                      <MapPin className="w-6 h-6 text-[#1A2A5E]" />
                    </div>
                    <div>
                      <h3 className="font-bold mb-1">Head Office</h3>
                      <p className="text-white/80 text-sm">
                        123 Travel Street, Tourism District
                        <br />
                        Chennai, Tamil Nadu 600001
                      </p>
                    </div>
                  </div>

                  <div className="flex items-start gap-4">
                    <div className="w-12 h-12 bg-[#C9A227] rounded-full flex items-center justify-center flex-shrink-0">
                      <Phone className="w-6 h-6 text-[#1A2A5E]" />
                    </div>
                    <div>
                      <h3 className="font-bold mb-1">Phone</h3>
                      <p className="text-white/80 text-sm">+91 98765 43210</p>
                      <p className="text-white/80 text-sm">+91 98765 43211</p>
                    </div>
                  </div>

                  <div className="flex items-start gap-4">
                    <div className="w-12 h-12 bg-[#C9A227] rounded-full flex items-center justify-center flex-shrink-0">
                      <Mail className="w-6 h-6 text-[#1A2A5E]" />
                    </div>
                    <div>
                      <h3 className="font-bold mb-1">Email</h3>
                      <p className="text-white/80 text-sm">info@travzoholidays.com</p>
                      <p className="text-white/80 text-sm">support@travzoholidays.com</p>
                    </div>
                  </div>

                  <div className="flex items-start gap-4">
                    <div className="w-12 h-12 bg-[#C9A227] rounded-full flex items-center justify-center flex-shrink-0">
                      <MessageSquare className="w-6 h-6 text-[#1A2A5E]" />
                    </div>
                    <div>
                      <h3 className="font-bold mb-1">WhatsApp</h3>
                      <a
                        href="https://wa.me/919876543210"
                        className="inline-block bg-[#C9A227] text-[#1A2A5E] px-4 py-2 rounded-full text-sm font-bold hover:bg-[#b08f1f] transition-colors"
                      >
                        Chat on WhatsApp
                      </a>
                    </div>
                  </div>

                  <div className="flex items-start gap-4">
                    <div className="w-12 h-12 bg-[#C9A227] rounded-full flex items-center justify-center flex-shrink-0">
                      <Clock className="w-6 h-6 text-[#1A2A5E]" />
                    </div>
                    <div>
                      <h3 className="font-bold mb-1">Working Hours</h3>
                      <p className="text-white/80 text-sm">Mon - Sat: 9:00 AM - 7:00 PM</p>
                      <p className="text-white/80 text-sm">Sunday: Closed</p>
                    </div>
                  </div>
                </div>

                {/* Google Maps Embed Placeholder */}
                <div className="rounded-xl overflow-hidden h-64 bg-gray-700">
                  <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3886.8415095198555!2d80.24797931482176!3d13.044550990811849!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5267a0c4e78dbf%3A0xa4ac1b08c2e21c98!2sChennai%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1234567890"
                    width="100%"
                    height="100%"
                    style={{ border: 0 }}
                    allowFullScreen
                    loading="lazy"
                    title="Travzo Holidays Location"
                  ></iframe>
                </div>
              </div>
            </div>

            {/* Right Column - Contact Form */}
            <div className="lg:col-span-3">
              <div className="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <h2 className="text-3xl font-bold text-[#1A2A5E] mb-6">
                  Send Us a Message
                </h2>

                <form className="space-y-6">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <label className="block text-[#1A2A5E] font-semibold mb-2">
                        Full Name *
                      </label>
                      <input
                        type="text"
                        placeholder="Your name"
                        className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent"
                        required
                      />
                    </div>

                    <div>
                      <label className="block text-[#1A2A5E] font-semibold mb-2">
                        City of Residence *
                      </label>
                      <input
                        type="text"
                        placeholder="Your city"
                        className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent"
                        required
                      />
                    </div>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <label className="block text-[#1A2A5E] font-semibold mb-2">
                        Email *
                      </label>
                      <input
                        type="email"
                        placeholder="your@email.com"
                        className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent"
                        required
                      />
                    </div>

                    <div>
                      <label className="block text-[#1A2A5E] font-semibold mb-2">
                        Phone Number *
                      </label>
                      <input
                        type="tel"
                        placeholder="+91 98765 43210"
                        className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent"
                        required
                      />
                    </div>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <label className="block text-[#1A2A5E] font-semibold mb-2">
                        WhatsApp Number
                      </label>
                      <input
                        type="tel"
                        placeholder="+91 98765 43210"
                        className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent"
                      />
                    </div>

                    <div>
                      <label className="block text-[#1A2A5E] font-semibold mb-2">
                        Destination of Interest
                      </label>
                      <input
                        type="text"
                        placeholder="e.g., Maldives, Bali"
                        className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent"
                      />
                    </div>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <label className="block text-[#1A2A5E] font-semibold mb-2">
                        Date of Travel
                      </label>
                      <input
                        type="date"
                        className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent"
                      />
                    </div>

                    <div>
                      <label className="block text-[#1A2A5E] font-semibold mb-2">
                        Number of People
                      </label>
                      <input
                        type="number"
                        placeholder="2"
                        min="1"
                        className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent"
                      />
                    </div>
                  </div>

                  <div>
                    <label className="block text-[#1A2A5E] font-semibold mb-2">
                      Trip Type *
                    </label>
                    <select
                      className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent"
                      required
                    >
                      <option value="">Select trip type</option>
                      <option>Honeymoon</option>
                      <option>Group Tour</option>
                      <option>Solo Trip</option>
                      <option>Devotional Tour</option>
                      <option>Destination Wedding</option>
                      <option>Family Trip</option>
                      <option>Corporate Trip</option>
                    </select>
                  </div>

                  <div>
                    <label className="block text-[#1A2A5E] font-semibold mb-2">
                      Message
                    </label>
                    <textarea
                      rows={5}
                      placeholder="Tell us about your travel plans..."
                      className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent resize-none"
                    ></textarea>
                  </div>

                  <button
                    type="submit"
                    className="w-full bg-[#C9A227] text-[#1A2A5E] py-4 rounded-lg hover:bg-[#b08f1f] transition-colors font-bold"
                  >
                    Send Enquiry
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Branch Offices */}
      <section className="py-20 bg-[#F5F5F5]">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-[#1A2A5E] mb-4">
              Our Branches Across Tamil Nadu
            </h2>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {branches.map((branch, index) => (
              <div
                key={index}
                className="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow"
              >
                <h3 className="text-xl font-bold text-[#1A2A5E] mb-3">
                  {branch.city}
                </h3>
                <p className="text-gray-600 text-sm mb-4 leading-relaxed">
                  {branch.address}
                </p>
                <p className="text-[#C9A227] font-bold mb-3">{branch.phone}</p>
                <a
                  href="#"
                  className="text-[#1A2A5E] text-sm font-semibold hover:text-[#C9A227] transition-colors inline-flex items-center gap-1"
                >
                  Get Directions →
                </a>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Newsletter */}
      <Newsletter />
    </>
  );
}
