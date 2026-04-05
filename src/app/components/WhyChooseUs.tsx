import { Pencil, DollarSign, Headphones } from 'lucide-react';

export function WhyChooseUs() {
  const features = [
    {
      icon: Pencil,
      title: 'Handcrafted Itineraries',
      description:
        'Every journey is uniquely designed to match your preferences and travel style.',
    },
    {
      icon: DollarSign,
      title: 'Best Price Guarantee',
      description:
        'We promise the most competitive rates without compromising on quality or experience.',
    },
    {
      icon: Headphones,
      title: '24/7 Support',
      description:
        'Our dedicated team is always available to assist you, no matter where you are.',
    },
  ];

  return (
    <section className="py-24 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-[#1A2A5E] mb-4">
            Why Travel With Travzo
          </h2>
        </div>

        {/* Features Grid */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-12">
          {features.map((feature, index) => (
            <div key={index} className="text-center">
              {/* Icon */}
              <div className="flex justify-center mb-6">
                <div className="w-20 h-20 bg-[#1A2A5E] rounded-full flex items-center justify-center">
                  <feature.icon className="w-10 h-10 text-[#C9A227]" />
                </div>
              </div>

              {/* Content */}
              <h3 className="text-2xl font-bold text-[#1A2A5E] mb-4">
                {feature.title}
              </h3>
              <p className="text-gray-600 leading-relaxed">
                {feature.description}
              </p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
