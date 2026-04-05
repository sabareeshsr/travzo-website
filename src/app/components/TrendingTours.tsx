import { Star, Clock, DollarSign } from 'lucide-react';

export function TrendingTours() {
  const tours = [
    {
      name: 'Maldives Paradise',
      category: 'Honeymoon',
      duration: '5 Days / 4 Nights',
      price: '₹89,999',
      rating: 4.8,
      image: 'https://images.unsplash.com/photo-1730944524570-44f1c584fd54?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtYWxkaXZlcyUyMGJlYWNoJTIwdHJvcGljYWwlMjBwYXJhZGlzZXxlbnwxfHx8fDE3NzQ4NTE2MzR8MA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      name: 'Swiss Alps Adventure',
      category: 'Group Tours',
      duration: '7 Days / 6 Nights',
      price: '₹1,49,999',
      rating: 4.9,
      image: 'https://images.unsplash.com/photo-1615982653374-2a6312586ed2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzd2l0emVybGFuZCUyMGFscHMlMjBzY2VuaWN8ZW58MXx8fHwxNzc0ODUxNjM0fDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      name: 'Dubai Luxury Experience',
      category: 'International',
      duration: '4 Days / 3 Nights',
      price: '₹69,999',
      rating: 4.7,
      image: 'https://images.unsplash.com/photo-1768069794857-9306ac167c6e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxkdWJhaSUyMHNreWxpbmUlMjBsdXh1cnl8ZW58MXx8fHwxNzc0Nzk0OTgyfDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      name: 'Bali Temple Tour',
      category: 'Devotional',
      duration: '6 Days / 5 Nights',
      price: '₹79,999',
      rating: 4.8,
      image: 'https://images.unsplash.com/photo-1613278435217-de4e5a91a4ee?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiYWxpJTIwdGVtcGxlJTIwc3Vuc2V0fGVufDF8fHx8MTc3NDc5NDk4MXww&ixlib=rb-4.1.0&q=80&w=1080',
    },
  ];

  return (
    <section className="py-24 bg-[#F5F5F5]">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-[#1A2A5E] mb-4">
            Trending Right Now
          </h2>
          <div className="w-24 h-1 bg-[#C9A227] mx-auto"></div>
        </div>

        {/* Tours Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {tours.map((tour, index) => (
            <div
              key={index}
              className="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow"
            >
              {/* Image */}
              <div className="relative h-48 overflow-hidden">
                <img
                  src={tour.image}
                  alt={tour.name}
                  className="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                />
                <div className="absolute top-4 left-4 bg-[#C9A227] text-white px-3 py-1 rounded-full text-sm">
                  {tour.category}
                </div>
              </div>

              {/* Content */}
              <div className="p-5">
                <h3 className="text-xl font-bold text-[#1A2A5E] mb-3">
                  {tour.name}
                </h3>

                <div className="flex items-center gap-2 text-gray-600 mb-2">
                  <Clock className="w-4 h-4" />
                  <span className="text-sm">{tour.duration}</span>
                </div>

                <div className="flex items-center gap-2 text-[#C9A227] font-bold text-lg mb-3">
                  <DollarSign className="w-5 h-5" />
                  <span>{tour.price}</span>
                </div>

                {/* Rating */}
                <div className="flex items-center gap-1 mb-4">
                  {[...Array(5)].map((_, i) => (
                    <Star
                      key={i}
                      className={`w-4 h-4 ${
                        i < Math.floor(tour.rating)
                          ? 'fill-[#C9A227] text-[#C9A227]'
                          : 'text-gray-300'
                      }`}
                    />
                  ))}
                  <span className="text-sm text-gray-600 ml-1">
                    ({tour.rating})
                  </span>
                </div>

                {/* Button */}
                <button className="w-full bg-[#1A2A5E] text-white py-3 rounded-lg hover:bg-[#C9A227] transition-colors font-semibold">
                  View Package
                </button>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
