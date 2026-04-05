import { Users, MapPin, Award, Target } from 'lucide-react';

export function Stats() {
  const stats = [
    { icon: Users, number: '500+', label: 'Happy Travellers' },
    { icon: MapPin, number: '50+', label: 'Destinations' },
    { icon: Award, number: '10+', label: 'Years Experience' },
    { icon: Target, number: '100%', label: 'Customised Itineraries' },
  ];

  return (
    <section className="bg-[#1A2A5E] py-16">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-4">
          {stats.map((stat, index) => (
            <div key={index} className="text-center">
              <div className="flex justify-center mb-4">
                <stat.icon className="w-12 h-12 text-[#C9A227]" />
              </div>
              <div className="text-5xl font-bold text-[#C9A227] mb-2">
                {stat.number}
              </div>
              <div className="text-white text-lg">{stat.label}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
