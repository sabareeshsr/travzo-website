import { Star } from 'lucide-react';

export function Testimonials() {
  const testimonials = [
    {
      quote:
        "Our honeymoon to Maldives was absolutely magical! Travzo took care of every detail and made it a trip we'll never forget.",
      name: 'Priya & Raj Sharma',
      trip: 'Maldives Honeymoon Package',
      rating: 5,
    },
    {
      quote:
        'The group tour to Switzerland was well-organized and exceeded all our expectations. The itinerary was perfect!',
      name: 'Amit Patel',
      trip: 'Swiss Alps Adventure',
      rating: 5,
    },
    {
      quote:
        'As a solo traveler, I felt safe and supported throughout my journey. Travzo made my first solo trip an incredible experience.',
      name: 'Neha Reddy',
      trip: 'Solo Thailand Explorer',
      rating: 5,
    },
  ];

  return (
    <section className="py-24 bg-[#1A2A5E]">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-white mb-4">
            What Our Travellers Say
          </h2>
        </div>

        {/* Testimonials Grid */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {testimonials.map((testimonial, index) => (
            <div
              key={index}
              className="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-8"
            >
              {/* Stars */}
              <div className="flex gap-1 mb-4">
                {[...Array(testimonial.rating)].map((_, i) => (
                  <Star
                    key={i}
                    className="w-5 h-5 fill-[#C9A227] text-[#C9A227]"
                  />
                ))}
              </div>

              {/* Quote */}
              <p className="text-white text-lg italic mb-6 leading-relaxed">
                "{testimonial.quote}"
              </p>

              {/* Name and Trip */}
              <div>
                <p className="text-[#C9A227] font-bold text-lg">
                  {testimonial.name}
                </p>
                <p className="text-gray-300 text-sm">{testimonial.trip}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
