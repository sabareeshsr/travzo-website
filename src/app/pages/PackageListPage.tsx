import { Link, useParams } from 'react-router';
import { Star, Clock, Users, MapPin, Filter } from 'lucide-react';
import { useState } from 'react';
import { Newsletter } from '../components/Newsletter';

export default function PackageListPage() {
  const { category } = useParams<{ category: string }>();
  const [activeFilter, setActiveFilter] = useState('all');

  const categoryInfo: Record<string, { title: string; subtitle: string; image: string; count: number }> = {
    'group-tours': {
      title: 'Group Tours',
      subtitle: 'Join like-minded travelers on exciting group adventures',
      image: 'https://images.unsplash.com/photo-1768410318733-1e0925a1c9e4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxncm91cCUyMHRyYXZlbGVycyUyMGFkdmVudHVyZSUyMHRvdXJ8ZW58MXx8fHwxNzc0ODUxNjMxfDA&ixlib=rb-4.1.0&q=80&w=1080',
      count: 22,
    },
    honeymoon: {
      title: 'Honeymoon Packages',
      subtitle: 'Romantic getaways for your perfect honeymoon',
      image: 'https://images.unsplash.com/photo-1648538923547-074724ca7a18?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxyb21hbnRpYyUyMGhvbmV5bW9vbiUyMGNvdXBsZSUyMGJlYWNofGVufDF8fHx8MTc3NDg1MTYzMnww&ixlib=rb-4.1.0&q=80&w=1080',
      count: 18,
    },
    devotional: {
      title: 'Devotional Tours',
      subtitle: 'Spiritual journeys to sacred destinations',
      image: 'https://images.unsplash.com/photo-1761474415878-d256852d6415?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxpbmRpYW4lMjB0ZW1wbGUlMjBkZXZvdGlvbmFsJTIwcHJheWVyfGVufDF8fHx8MTc3NDg1MTYzMnww&ixlib=rb-4.1.0&q=80&w=1080',
      count: 15,
    },
    'destination-wedding': {
      title: 'Destination Weddings',
      subtitle: 'Celebrate your special day in paradise',
      image: 'https://images.unsplash.com/photo-1768777278495-5ffe24f9e3a8?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsdXh1cnklMjBkZXN0aW5hdGlvbiUyMHdlZGRpbmclMjB2ZW51ZXxlbnwxfHx8fDE3NzQ4NTE2MzN8MA&ixlib=rb-4.1.0&q=80&w=1080',
      count: 10,
    },
    'solo-trips': {
      title: 'Solo Trips',
      subtitle: 'Discover yourself through solo adventures',
      image: 'https://images.unsplash.com/photo-1528526938169-3e862c52e68a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzb2xvJTIwYmFja3BhY2tlciUyMHRyYXZlbGVyfGVufDF8fHx8MTc3NDg1MTYzMnww&ixlib=rb-4.1.0&q=80&w=1080',
      count: 8,
    },
  };

  const info = categoryInfo[category || 'group-tours'];

  const packages = [
    {
      id: 1,
      name: 'Magical Maldives',
      location: 'Maldives',
      duration: '4N / 5D',
      groupSize: '2-15',
      price: '89,999',
      rating: 4.8,
      image: 'https://images.unsplash.com/photo-1730944524570-44f1c584fd54?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtYWxkaXZlcyUyMGJlYWNoJTIwdHJvcGljYWwlMjBwYXJhZGlzZXxlbnwxfHx8fDE3NzQ4NTE2MzR8MA&ixlib=rb-4.1.0&q=80&w=1080',
      category: 'Honeymoon',
    },
    {
      id: 2,
      name: 'Swiss Alps Adventure',
      location: 'Switzerland',
      duration: '7N / 8D',
      groupSize: '6-20',
      price: '1,49,999',
      rating: 4.9,
      image: 'https://images.unsplash.com/photo-1615982653374-2a6312586ed2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzd2l0emVybGFuZCUyMGFscHMlMjBzY2VuaWN8ZW58MXx8fHwxNzc0ODUxNjM0fDA&ixlib=rb-4.1.0&q=80&w=1080',
      category: 'Group Tours',
    },
    {
      id: 3,
      name: 'Dubai Luxury Experience',
      location: 'Dubai, UAE',
      duration: '4N / 5D',
      groupSize: '2-12',
      price: '69,999',
      rating: 4.7,
      image: 'https://images.unsplash.com/photo-1768069794857-9306ac167c6e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxkdWJhaSUyMHNreWxpbmUlMjBsdXh1cnl8ZW58MXx8fHwxNzc0Nzk0OTgyfDA&ixlib=rb-4.1.0&q=80&w=1080',
      category: 'International',
    },
    {
      id: 4,
      name: 'Bali Temple Tour',
      location: 'Bali, Indonesia',
      duration: '6N / 7D',
      groupSize: '4-16',
      price: '79,999',
      rating: 4.8,
      image: 'https://images.unsplash.com/photo-1613278435217-de4e5a91a4ee?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiYWxpJTIwdGVtcGxlJTIwc3Vuc2V0fGVufDF8fHx8MTc3NDc5NDk4MXww&ixlib=rb-4.1.0&q=80&w=1080',
      category: 'Devotional',
    },
    {
      id: 5,
      name: 'Romantic Paris',
      location: 'Paris, France',
      duration: '5N / 6D',
      groupSize: '2-10',
      price: '1,29,999',
      rating: 4.9,
      image: 'https://images.unsplash.com/photo-1699726258869-36dff6247fd3?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxwYXJpcyUyMGVpZmZlbCUyMHRvd2VyJTIwcm9tYW50aWN8ZW58MXx8fHwxNzc0NzgxNDg3fDA&ixlib=rb-4.1.0&q=80&w=1080',
      category: 'Honeymoon',
    },
    {
      id: 6,
      name: 'Kerala Backwaters',
      location: 'Kerala, India',
      duration: '3N / 4D',
      groupSize: '2-8',
      price: '24,999',
      rating: 4.6,
      image: 'https://images.unsplash.com/photo-1673505413397-0cd0dc4f5854?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxoaW1hbGF5YW4lMjBtb3VudGFpbiUyMHNjZW5pYyUyMGxhbmRzY2FwZXxlbnwxfHx8fDE3NzQ4NTE2MzF8MA&ixlib=rb-4.1.0&q=80&w=1080',
      category: 'Group Tours',
    },
  ];

  return (
    <>
      {/* Page Hero */}
      <section className="relative h-[50vh] flex items-center justify-center">
        <div className="absolute inset-0">
          <img
            src={info.image}
            alt={info.title}
            className="w-full h-full object-cover"
          />
          <div className="absolute inset-0 bg-[#1A2A5E] opacity-50"></div>
        </div>

        <div className="relative z-10 text-center px-4 max-w-4xl mx-auto">
          <nav className="text-white/80 text-sm mb-4">
            <Link to="/" className="hover:text-white">Home</Link> &gt; {info.title}
          </nav>
          <h1 className="text-5xl md:text-6xl font-bold text-white mb-6">
            {info.title}
          </h1>
          <p className="text-xl text-white/90 mb-8">{info.subtitle}</p>

          {/* Stat Pills */}
          <div className="flex flex-wrap gap-4 justify-center">
            <div className="border-2 border-[#C9A227] text-white px-6 py-2 rounded-full">
              {info.count} Packages Available
            </div>
            <div className="border-2 border-[#C9A227] text-white px-6 py-2 rounded-full">
              3–14 Days
            </div>
            <div className="border-2 border-[#C9A227] text-white px-6 py-2 rounded-full">
              Starting ₹15,000
            </div>
          </div>
        </div>
      </section>

      {/* Filter Bar */}
      <div className="sticky top-[108px] z-40 bg-white border-b border-gray-200 shadow-sm">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between h-[72px] overflow-x-auto">
            <div className="flex items-center gap-4">
              <button
                onClick={() => setActiveFilter('all')}
                className={`px-4 py-2 rounded-full transition-colors whitespace-nowrap ${
                  activeFilter === 'all'
                    ? 'bg-[#C9A227] text-[#1A2A5E]'
                    : 'bg-gray-100 text-[#1A2A5E] hover:bg-gray-200'
                }`}
              >
                All
              </button>
              <button className="flex items-center gap-2 px-4 py-2 rounded-full bg-gray-100 text-[#1A2A5E] hover:bg-gray-200 transition-colors whitespace-nowrap">
                <Filter className="w-4 h-4" />
                By Destination
              </button>
              <button className="flex items-center gap-2 px-4 py-2 rounded-full bg-gray-100 text-[#1A2A5E] hover:bg-gray-200 transition-colors whitespace-nowrap">
                By Duration
              </button>
              <button className="flex items-center gap-2 px-4 py-2 rounded-full bg-gray-100 text-[#1A2A5E] hover:bg-gray-200 transition-colors whitespace-nowrap">
                By Budget
              </button>
            </div>
            <div>
              <select className="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227] text-sm">
                <option>Sort by: Price Low–High</option>
                <option>Sort by: Price High–Low</option>
                <option>Sort by: Duration</option>
                <option>Sort by: Rating</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      {/* Package Grid */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {packages.map((pkg) => (
              <div
                key={pkg.id}
                className="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow"
              >
                {/* Image */}
                <div className="relative h-56 overflow-hidden">
                  <img
                    src={pkg.image}
                    alt={pkg.name}
                    className="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                  />
                  <div className="absolute top-4 left-4 bg-[#C9A227] text-[#1A2A5E] px-3 py-1 rounded-full text-sm font-semibold">
                    {pkg.category}
                  </div>
                </div>

                {/* Content */}
                <div className="p-5">
                  <h3 className="text-xl font-bold text-[#1A2A5E] mb-2">
                    {pkg.name}
                  </h3>

                  <div className="flex items-center gap-2 text-gray-600 mb-3">
                    <MapPin className="w-4 h-4" />
                    <span className="text-sm">{pkg.location}</span>
                  </div>

                  <div className="flex items-center gap-4 mb-3">
                    <div className="flex items-center gap-1 text-gray-600">
                      <Clock className="w-4 h-4" />
                      <span className="text-sm">{pkg.duration}</span>
                    </div>
                    <div className="flex items-center gap-1 text-gray-600">
                      <Users className="w-4 h-4" />
                      <span className="text-sm">{pkg.groupSize} Pax</span>
                    </div>
                  </div>

                  <div className="flex items-center justify-between mb-4">
                    <div>
                      <p className="text-xs text-gray-500">Starting from</p>
                      <p className="text-2xl font-bold text-[#C9A227]">
                        ₹{pkg.price}
                      </p>
                    </div>
                    <div className="flex items-center gap-1">
                      <Star className="w-4 h-4 fill-[#C9A227] text-[#C9A227]" />
                      <span className="text-sm font-semibold">{pkg.rating}</span>
                    </div>
                  </div>

                  <Link
                    to={`/package/${pkg.id}`}
                    className="block w-full bg-[#1A2A5E] text-white text-center py-3 rounded-lg hover:bg-[#C9A227] hover:text-[#1A2A5E] transition-colors font-semibold"
                  >
                    View Details
                  </Link>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Quick Enquiry Strip */}
      <section className="py-20 bg-[#C9A227]">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
            <div className="lg:col-span-2">
              <h2 className="text-3xl font-bold text-[#1A2A5E] mb-2">
                Can't find the perfect package?
              </h2>
              <p className="text-[#1A2A5E]/80">
                Let us create a customized itinerary just for you
              </p>
            </div>
            <div className="flex gap-4">
              <a
                href="tel:+919876543210"
                className="flex-1 bg-[#1A2A5E] text-white text-center px-6 py-3 rounded-lg hover:bg-[#0f1a3d] transition-colors font-semibold"
              >
                Call Us Now
              </a>
              <Link
                to="/contact"
                className="flex-1 border-2 border-[#1A2A5E] text-[#1A2A5E] text-center px-6 py-3 rounded-lg hover:bg-[#1A2A5E] hover:text-white transition-all font-semibold"
              >
                Send Enquiry
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* Newsletter */}
      <Newsletter />
    </>
  );
}
