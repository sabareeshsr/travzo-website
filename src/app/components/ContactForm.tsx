import { Phone, Mail, MapPin } from 'lucide-react';

export function ContactForm() {
  return (
    <section className="py-24 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
          {/* Left Column - Contact Info */}
          <div>
            <h2 className="text-4xl md:text-5xl font-bold text-[#1A2A5E] mb-6">
              Plan Your Dream Trip
            </h2>
            <p className="text-gray-600 text-lg mb-8 leading-relaxed">
              Let us know your travel preferences and our expert team will craft
              the perfect itinerary just for you. We're here to make your dream
              vacation a reality.
            </p>

            {/* Contact Details */}
            <div className="space-y-6">
              <div className="flex items-start gap-4">
                <div className="w-12 h-12 bg-[#C9A227] rounded-full flex items-center justify-center flex-shrink-0">
                  <Phone className="w-6 h-6 text-white" />
                </div>
                <div>
                  <h3 className="font-bold text-[#1A2A5E] mb-1">Phone</h3>
                  <p className="text-gray-600">+91 98765 43210</p>
                  <p className="text-gray-600">+91 98765 43211</p>
                </div>
              </div>

              <div className="flex items-start gap-4">
                <div className="w-12 h-12 bg-[#C9A227] rounded-full flex items-center justify-center flex-shrink-0">
                  <Mail className="w-6 h-6 text-white" />
                </div>
                <div>
                  <h3 className="font-bold text-[#1A2A5E] mb-1">Email</h3>
                  <p className="text-gray-600">info@travzoholidays.com</p>
                  <p className="text-gray-600">support@travzoholidays.com</p>
                </div>
              </div>

              <div className="flex items-start gap-4">
                <div className="w-12 h-12 bg-[#C9A227] rounded-full flex items-center justify-center flex-shrink-0">
                  <MapPin className="w-6 h-6 text-white" />
                </div>
                <div>
                  <h3 className="font-bold text-[#1A2A5E] mb-1">Address</h3>
                  <p className="text-gray-600">
                    123 Travel Street, Tourism District
                    <br />
                    Mumbai, Maharashtra 400001
                  </p>
                </div>
              </div>
            </div>
          </div>

          {/* Right Column - Form */}
          <div className="bg-[#F5F5F5] rounded-2xl p-8">
            <form className="space-y-6">
              <div>
                <label className="block text-[#1A2A5E] font-semibold mb-2">
                  Full Name
                </label>
                <input
                  type="text"
                  placeholder="Your name"
                  className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent"
                />
              </div>

              <div>
                <label className="block text-[#1A2A5E] font-semibold mb-2">
                  Email
                </label>
                <input
                  type="email"
                  placeholder="your@email.com"
                  className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent"
                />
              </div>

              <div>
                <label className="block text-[#1A2A5E] font-semibold mb-2">
                  Phone
                </label>
                <input
                  type="tel"
                  placeholder="+91 98765 43210"
                  className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent"
                />
              </div>

              <div>
                <label className="block text-[#1A2A5E] font-semibold mb-2">
                  Package Interest
                </label>
                <select className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent">
                  <option>Select a package type</option>
                  <option>Honeymoon</option>
                  <option>Group Tours</option>
                  <option>Solo Trips</option>
                  <option>Devotional Tours</option>
                  <option>Destination Wedding</option>
                  <option>International</option>
                </select>
              </div>

              <div>
                <label className="block text-[#1A2A5E] font-semibold mb-2">
                  Message
                </label>
                <textarea
                  rows={4}
                  placeholder="Tell us about your travel plans..."
                  className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] focus:border-transparent resize-none"
                ></textarea>
              </div>

              <button
                type="submit"
                className="w-full bg-[#C9A227] text-white py-4 rounded-lg hover:bg-[#b08f1f] transition-colors font-semibold"
              >
                Send Enquiry
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>
  );
}
