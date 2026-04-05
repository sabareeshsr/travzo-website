import { Link } from 'react-router';
import { useState } from 'react';
import { Clock, Users, MapPin, Check, X, Download, Shield, Lock, Headphones, ChevronDown, ChevronUp, Calendar, Star } from 'lucide-react';

export default function PackageDetailPage() {
  const [activeTab, setActiveTab] = useState('overview');
  const [expandedDay, setExpandedDay] = useState<number | null>(1);

  const itinerary = [
    {
      day: 1,
      title: 'Arrival in Bali',
      activities: [
        'Airport pickup and transfer to hotel',
        'Welcome drink and check-in',
        'Evening at leisure - explore nearby areas',
        'Welcome dinner at hotel restaurant',
      ],
      meals: 'Dinner',
      accommodation: 'Bali Resort & Spa',
    },
    {
      day: 2,
      title: 'Ubud Temple Tour',
      activities: [
        'Breakfast at hotel',
        'Visit Tirta Empul Temple',
        'Explore Tegallalang Rice Terraces',
        'Traditional Balinese lunch',
        'Visit Ubud Monkey Forest',
        'Return to hotel',
      ],
      meals: 'Breakfast, Lunch',
      accommodation: 'Bali Resort & Spa',
    },
    {
      day: 3,
      title: 'Water Sports & Beach Day',
      activities: [
        'Breakfast at hotel',
        'Water sports at Tanjung Benoa Beach',
        'Lunch at beachside restaurant',
        'Uluwatu Temple visit',
        'Kecak Dance performance at sunset',
        'Dinner at Jimbaran Bay',
      ],
      meals: 'Breakfast, Lunch, Dinner',
      accommodation: 'Bali Resort & Spa',
    },
  ];

  const inclusions = [
    'Round-trip flights from Chennai',
    'Airport transfers',
    '4 nights accommodation in 4-star hotel',
    'Daily breakfast',
    'All sightseeing as per itinerary',
    'English-speaking guide',
    'All entry fees and permits',
    'Travel insurance',
  ];

  const exclusions = [
    'Visa fees',
    'Personal expenses',
    'Lunch and dinner (except specified)',
    'Tips and gratuities',
    'Optional activities',
    'Travel insurance excess',
  ];

  const similarPackages = [
    {
      id: 2,
      name: 'Thailand Paradise',
      location: 'Phuket & Bangkok',
      duration: '5N / 6D',
      price: '54,999',
      rating: 4.7,
      image: 'https://images.unsplash.com/photo-1528526938169-3e862c52e68a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzb2xvJTIwYmFja3BhY2tlciUyMHRyYXZlbGVyfGVufDF8fHx8MTc3NDg1MTYzMnww&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      id: 3,
      name: 'Singapore Highlights',
      location: 'Singapore',
      duration: '4N / 5D',
      price: '64,999',
      rating: 4.8,
      image: 'https://images.unsplash.com/photo-1768069794857-9306ac167c6e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxkdWJhaSUyMHNreWxpbmUlMjBsdXh1cnl8ZW58MXx8fHwxNzc0Nzk0OTgyfDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      id: 4,
      name: 'Malaysia Explorer',
      location: 'Kuala Lumpur & Langkawi',
      duration: '6N / 7D',
      price: '59,999',
      rating: 4.6,
      image: 'https://images.unsplash.com/photo-1730944524570-44f1c584fd54?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtYWxkaXZlcyUyMGJlYWNoJTIwdHJvcGljYWwlMjBwYXJhZGlzZXxlbnwxfHx8fDE3NzQ4NTE2MzR8MA&ixlib=rb-4.1.0&q=80&w=1080',
    },
  ];

  return (
    <>
      {/* Package Hero */}
      <section className="relative h-[65vh] flex items-center justify-center">
        <div className="absolute inset-0">
          <img
            src="https://images.unsplash.com/photo-1613278435217-de4e5a91a4ee?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiYWxpJTIwdGVtcGxlJTIwc3Vuc2V0fGVufDF8fHx8MTc3NDc5NDk4MXww&ixlib=rb-4.1.0&q=80&w=1080"
            alt="Bali Package"
            className="w-full h-full object-cover"
          />
          <div className="absolute inset-0 bg-gradient-to-t from-[#1A2A5E]/80 to-transparent"></div>
        </div>

        <div className="relative z-10 text-center px-4 max-w-5xl mx-auto">
          <h1 className="text-5xl md:text-6xl font-bold text-white mb-8">
            Magical Bali Temple Tour
          </h1>

          <div className="flex flex-wrap gap-4 justify-center">
            <div className="flex items-center gap-2 bg-white/90 text-[#1A2A5E] px-6 py-3 rounded-full">
              <Clock className="w-5 h-5 text-[#C9A227]" />
              <span className="font-semibold">5 Nights / 6 Days</span>
            </div>
            <div className="flex items-center gap-2 bg-white/90 text-[#1A2A5E] px-6 py-3 rounded-full">
              <MapPin className="w-5 h-5 text-[#C9A227]" />
              <span className="font-semibold">Bali, Indonesia</span>
            </div>
            <div className="flex items-center gap-2 bg-white/90 text-[#1A2A5E] px-6 py-3 rounded-full">
              <Users className="w-5 h-5 text-[#C9A227]" />
              <span className="font-semibold">2-15 People</span>
            </div>
            <div className="flex items-center gap-2 bg-[#C9A227] text-[#1A2A5E] px-6 py-3 rounded-full">
              <span className="font-bold">Starting from ₹79,999</span>
            </div>
          </div>
        </div>
      </section>

      {/* Main Content */}
      <section className="py-12 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {/* Main Content (Left 2/3) */}
            <div className="lg:col-span-2">
              {/* Tabs */}
              <div className="border-b-2 border-gray-200 mb-8">
                <div className="flex gap-8">
                  {['overview', 'itinerary', 'inclusions', 'hotels'].map((tab) => (
                    <button
                      key={tab}
                      onClick={() => setActiveTab(tab)}
                      className={`pb-4 text-sm font-semibold uppercase tracking-wider transition-colors ${
                        activeTab === tab
                          ? 'text-[#1A2A5E] border-b-2 border-[#C9A227] -mb-0.5'
                          : 'text-gray-500 hover:text-[#1A2A5E]'
                      }`}
                    >
                      {tab}
                    </button>
                  ))}
                </div>
              </div>

              {/* Overview Tab */}
              {activeTab === 'overview' && (
                <div className="space-y-8">
                  <div>
                    <h3 className="text-2xl font-bold text-[#1A2A5E] mb-4">Package Overview</h3>
                    <p className="text-gray-600 leading-relaxed mb-4">
                      Experience the magic of Bali with our carefully curated temple tour package. This 6-day journey takes you through the spiritual heart of Bali, visiting ancient temples, pristine beaches, and lush rice terraces.
                    </p>
                    <p className="text-gray-600 leading-relaxed mb-4">
                      Perfect for couples, families, and groups seeking a blend of culture, adventure, and relaxation. Our expert guides will ensure you experience the authentic Balinese way of life while enjoying modern comforts.
                    </p>
                  </div>

                  <div>
                    <h3 className="text-xl font-bold text-[#1A2A5E] mb-4">Package Highlights</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
                      {[
                        'Visit 10+ sacred temples',
                        'Traditional Balinese ceremonies',
                        'Water sports at Tanjung Benoa',
                        'Ubud rice terraces trek',
                        'Kecak fire dance performance',
                        'Beachside seafood dinner',
                        'Professional English guide',
                        'All entry tickets included',
                      ].map((highlight, idx) => (
                        <div key={idx} className="flex items-start gap-2">
                          <Check className="w-5 h-5 text-[#C9A227] flex-shrink-0 mt-0.5" />
                          <span className="text-gray-700">{highlight}</span>
                        </div>
                      ))}
                    </div>
                  </div>

                  {/* Photo Gallery Placeholder */}
                  <div>
                    <h3 className="text-xl font-bold text-[#1A2A5E] mb-4">Photo Gallery</h3>
                    <div className="grid grid-cols-3 gap-2">
                      {[1, 2, 3, 4, 5, 6].map((i) => (
                        <div key={i} className="aspect-square rounded-lg overflow-hidden">
                          <img
                            src="https://images.unsplash.com/photo-1613278435217-de4e5a91a4ee?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiYWxpJTIwdGVtcGxlJTIwc3Vuc2V0fGVufDF8fHx8MTc3NDc5NDk4MXww&ixlib=rb-4.1.0&q=80&w=1080"
                            alt={`Gallery ${i}`}
                            className="w-full h-full object-cover hover:scale-110 transition-transform duration-300"
                          />
                        </div>
                      ))}
                    </div>
                  </div>
                </div>
              )}

              {/* Itinerary Tab */}
              {activeTab === 'itinerary' && (
                <div className="space-y-4">
                  {itinerary.map((day) => (
                    <div key={day.day} className="border border-gray-200 rounded-lg overflow-hidden">
                      <button
                        onClick={() => setExpandedDay(expandedDay === day.day ? null : day.day)}
                        className="w-full flex items-center justify-between p-6 bg-white hover:bg-gray-50 transition-colors"
                      >
                        <div className="flex items-center gap-4">
                          <div className="w-12 h-12 bg-[#C9A227] rounded-full flex items-center justify-center text-[#1A2A5E] font-bold">
                            {day.day}
                          </div>
                          <div className="text-left">
                            <h4 className="text-lg font-bold text-[#1A2A5E]">Day {day.day}</h4>
                            <p className="text-gray-600">{day.title}</p>
                          </div>
                        </div>
                        {expandedDay === day.day ? (
                          <ChevronUp className="w-5 h-5 text-[#C9A227]" />
                        ) : (
                          <ChevronDown className="w-5 h-5 text-[#C9A227]" />
                        )}
                      </button>

                      {expandedDay === day.day && (
                        <div className="p-6 bg-[#F5F5F5] border-t border-gray-200">
                          <ul className="space-y-2 mb-4">
                            {day.activities.map((activity, idx) => (
                              <li key={idx} className="flex items-start gap-2">
                                <Clock className="w-4 h-4 text-[#C9A227] flex-shrink-0 mt-1" />
                                <span className="text-gray-700">{activity}</span>
                              </li>
                            ))}
                          </ul>
                          <div className="flex items-center gap-4 text-sm">
                            <span className="text-gray-600">
                              <strong>Meals:</strong> {day.meals}
                            </span>
                            <span className="text-gray-600">
                              <strong>Accommodation:</strong> {day.accommodation}
                            </span>
                          </div>
                        </div>
                      )}
                    </div>
                  ))}
                </div>
              )}

              {/* Inclusions Tab */}
              {activeTab === 'inclusions' && (
                <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                  <div>
                    <h3 className="text-xl font-bold text-[#1A2A5E] mb-4 flex items-center gap-2">
                      <Check className="w-6 h-6 text-green-600" />
                      What's Included
                    </h3>
                    <ul className="space-y-3">
                      {inclusions.map((item, idx) => (
                        <li key={idx} className="flex items-start gap-2">
                          <Check className="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                          <span className="text-gray-700">{item}</span>
                        </li>
                      ))}
                    </ul>
                  </div>
                  <div>
                    <h3 className="text-xl font-bold text-[#1A2A5E] mb-4 flex items-center gap-2">
                      <X className="w-6 h-6 text-red-600" />
                      What's Not Included
                    </h3>
                    <ul className="space-y-3">
                      {exclusions.map((item, idx) => (
                        <li key={idx} className="flex items-start gap-2">
                          <X className="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" />
                          <span className="text-gray-700">{item}</span>
                        </li>
                      ))}
                    </ul>
                  </div>
                </div>
              )}

              {/* Hotels Tab */}
              {activeTab === 'hotels' && (
                <div className="space-y-6">
                  <div className="border border-gray-200 rounded-lg p-6">
                    <div className="flex items-start gap-6">
                      <img
                        src="https://images.unsplash.com/photo-1613278435217-de4e5a91a4ee?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiYWxpJTIwdGVtcGxlJTIwc3Vuc2V0fGVufDF8fHx8MTc3NDc5NDk4MXww&ixlib=rb-4.1.0&q=80&w=1080"
                        alt="Hotel"
                        className="w-48 h-32 object-cover rounded-lg"
                      />
                      <div className="flex-1">
                        <h4 className="text-lg font-bold text-[#1A2A5E] mb-2">
                          Bali Resort & Spa
                        </h4>
                        <div className="flex items-center gap-1 mb-2">
                          {[...Array(4)].map((_, i) => (
                            <Star key={i} className="w-4 h-4 fill-[#C9A227] text-[#C9A227]" />
                          ))}
                        </div>
                        <p className="text-sm text-gray-600 mb-2">Seminyak, Bali</p>
                        <p className="text-sm text-gray-700 mb-3">
                          Deluxe Room with Garden View (Twin/Double Sharing)
                        </p>
                        <div className="flex gap-2">
                          <span className="text-xs bg-[#F5F5F5] text-gray-700 px-2 py-1 rounded">
                            Free WiFi
                          </span>
                          <span className="text-xs bg-[#F5F5F5] text-gray-700 px-2 py-1 rounded">
                            Breakfast Included
                          </span>
                          <span className="text-xs bg-[#F5F5F5] text-gray-700 px-2 py-1 rounded">
                            Pool Access
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              )}
            </div>

            {/* Sidebar (Right 1/3) - Sticky */}
            <div className="lg:col-span-1">
              <div className="sticky top-32">
                <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                  <h3 className="text-xl font-bold text-[#C9A227] mb-4">Book This Package</h3>
                  <div className="text-3xl font-bold text-[#C9A227] mb-6">
                    ₹79,999
                    <span className="text-sm font-normal text-gray-600"> per person</span>
                  </div>

                  <form className="space-y-4 mb-6">
                    <input
                      type="text"
                      placeholder="Your Name"
                      className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227]"
                    />
                    <input
                      type="tel"
                      placeholder="Phone Number"
                      className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227]"
                    />
                    <input
                      type="date"
                      placeholder="Travel Date"
                      className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227]"
                    />
                    <input
                      type="number"
                      placeholder="No. of People"
                      min="1"
                      className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C9A227]"
                    />
                    <button
                      type="submit"
                      className="w-full bg-[#C9A227] text-[#1A2A5E] py-3 rounded-lg hover:bg-[#b08f1f] transition-colors font-bold"
                    >
                      Enquire Now
                    </button>
                  </form>

                  <button className="w-full bg-transparent border-2 border-[#1A2A5E] text-[#1A2A5E] py-3 rounded-lg hover:bg-[#1A2A5E] hover:text-white transition-all font-semibold mb-6 flex items-center justify-center gap-2">
                    <Download className="w-4 h-4" />
                    Download Itinerary PDF
                  </button>

                  {/* Trust Badges */}
                  <div className="space-y-3">
                    <div className="flex items-center gap-2 text-sm text-gray-700">
                      <Lock className="w-4 h-4 text-[#C9A227]" />
                      <span>Secure Booking</span>
                    </div>
                    <div className="flex items-center gap-2 text-sm text-gray-700">
                      <Shield className="w-4 h-4 text-[#C9A227]" />
                      <span>Best Price Guarantee</span>
                    </div>
                    <div className="flex items-center gap-2 text-sm text-gray-700">
                      <Headphones className="w-4 h-4 text-[#C9A227]" />
                      <span>24/7 Support</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Similar Packages */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-[#1A2A5E] mb-12">You May Also Like</h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {similarPackages.map((pkg) => (
              <div key={pkg.id} className="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                <div className="relative h-48 overflow-hidden">
                  <img
                    src={pkg.image}
                    alt={pkg.name}
                    className="w-full h-full object-cover"
                  />
                </div>
                <div className="p-5">
                  <h3 className="text-lg font-bold text-[#1A2A5E] mb-2">{pkg.name}</h3>
                  <p className="text-sm text-gray-600 mb-2">{pkg.location}</p>
                  <div className="flex items-center justify-between mb-3">
                    <span className="text-sm text-gray-600">{pkg.duration}</span>
                    <div className="flex items-center gap-1">
                      <Star className="w-4 h-4 fill-[#C9A227] text-[#C9A227]" />
                      <span className="text-sm">{pkg.rating}</span>
                    </div>
                  </div>
                  <div className="text-xl font-bold text-[#C9A227] mb-3">₹{pkg.price}</div>
                  <Link
                    to={`/package/${pkg.id}`}
                    className="block w-full bg-[#1A2A5E] text-white text-center py-2 rounded-lg hover:bg-[#C9A227] hover:text-[#1A2A5E] transition-colors font-semibold"
                  >
                    View Details
                  </Link>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    </>
  );
}
