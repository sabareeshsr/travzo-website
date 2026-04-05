import { Search } from 'lucide-react';

export function Hero() {
  return (
    <section className="relative h-[90vh] min-h-[600px] flex items-center justify-center">
      {/* Background Image with Overlay */}
      <div className="absolute inset-0">
        <img
          src="https://images.unsplash.com/photo-1673505413397-0cd0dc4f5854?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxoaW1hbGF5YW4lMjBtb3VudGFpbiUyMHNjZW5pYyUyMGxhbmRzY2FwZXxlbnwxfHx8fDE3NzQ4NTE2MzF8MA&ixlib=rb-4.1.0&q=80&w=1080"
          alt="Hero background"
          className="w-full h-full object-cover"
        />
        <div className="absolute inset-0 bg-[#1A2A5E] opacity-50"></div>
      </div>

      {/* Content */}
      <div className="relative z-10 text-center px-4 max-w-4xl mx-auto">
        <div className="inline-block bg-[#C9A227] text-white px-4 py-2 rounded-full mb-6">
          Your Journey Begins Here
        </div>
        <h1 className="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
          Explore the World
          <br />
          With Travzo Holidays
        </h1>
        <p className="text-xl text-gray-200 mb-8">
          Curated experiences for the modern Indian traveler
        </p>

        {/* CTA Buttons */}
        <div className="flex flex-col sm:flex-row gap-4 justify-center mb-16">
          <button className="bg-[#C9A227] text-white px-8 py-4 rounded-lg hover:bg-[#b08f1f] transition-colors font-semibold">
            Explore Packages
          </button>
          <button className="border-2 border-white text-white px-8 py-4 rounded-lg hover:bg-white hover:text-[#1A2A5E] transition-all font-semibold">
            Contact Us
          </button>
        </div>
      </div>

      {/* Search Bar */}
      <div className="absolute bottom-0 left-0 right-0 translate-y-1/2 z-20 px-4">
        <div className="max-w-5xl mx-auto bg-white rounded-2xl shadow-2xl p-6">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
              <label className="block text-sm font-semibold text-[#1A2A5E] mb-2">
                Destination
              </label>
              <input
                type="text"
                placeholder="Where to?"
                className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C9A227]"
              />
            </div>
            <div>
              <label className="block text-sm font-semibold text-[#1A2A5E] mb-2">
                Package Type
              </label>
              <select className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C9A227]">
                <option>All Packages</option>
                <option>Honeymoon</option>
                <option>Group Tours</option>
                <option>Solo Trips</option>
                <option>Devotional</option>
              </select>
            </div>
            <div>
              <label className="block text-sm font-semibold text-[#1A2A5E] mb-2">
                Duration
              </label>
              <select className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C9A227]">
                <option>Any Duration</option>
                <option>3-5 Days</option>
                <option>6-10 Days</option>
                <option>10+ Days</option>
              </select>
            </div>
            <button className="bg-[#C9A227] text-white px-8 py-3 rounded-lg hover:bg-[#b08f1f] transition-colors font-semibold flex items-center justify-center gap-2">
              <Search className="w-5 h-5" />
              Search
            </button>
          </div>
        </div>
      </div>
    </section>
  );
}
