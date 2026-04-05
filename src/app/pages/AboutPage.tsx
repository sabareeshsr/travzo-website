import { Link } from 'react-router';
import { CheckCircle, Users, MapPin, Award, Target, Pencil, DollarSign, Headphones, Globe, Shield, Heart } from 'lucide-react';
import { Stats } from '../components/Stats';
import { Testimonials } from '../components/Testimonials';
import { Newsletter } from '../components/Newsletter';

export default function AboutPage() {
  const features = [
    {
      icon: Pencil,
      title: 'Handcrafted Itineraries',
      description: 'Every journey is uniquely designed to match your preferences and travel style.',
    },
    {
      icon: DollarSign,
      title: 'Best Price Guarantee',
      description: 'We promise the most competitive rates without compromising on quality.',
    },
    {
      icon: Headphones,
      title: '24/7 Support',
      description: 'Our dedicated team is always available to assist you, no matter where you are.',
    },
    {
      icon: Globe,
      title: 'Visa Assistance',
      description: 'Complete support with visa documentation and application processes.',
    },
    {
      icon: Shield,
      title: 'Group Expertise',
      description: 'Specializing in group travel coordination for families, friends, and corporates.',
    },
    {
      icon: Heart,
      title: 'Devotional Specialists',
      description: 'Expert guidance for spiritual journeys and temple tours across India.',
    },
  ];

  const awards = [
    { name: 'Best Travel Agency 2024', body: 'Tamil Nadu Tourism Board', year: '2024' },
    { name: 'Excellence in Customer Service', body: 'Travel Industry Awards', year: '2023' },
    { name: 'Top Rated Agency', body: 'TripAdvisor', year: '2023' },
    { name: 'Innovation in Travel', body: 'Indian Travel Congress', year: '2022' },
  ];

  const partners = [
    'Thailand Tourism',
    'Dubai Tourism',
    'Singapore Tourism',
    'Malaysia Tourism',
    'Maldives Tourism',
    'Australia Tourism',
    'Japan Tourism',
    'Kenya Tourism',
  ];

  return (
    <>
      {/* Page Hero */}
      <section className="relative h-[60vh] flex items-center justify-center">
        <div className="absolute inset-0">
          <img
            src="https://images.unsplash.com/photo-1774491816259-8bf12e6dafea?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx0cmF2ZWwlMjB0ZWFtJTIwb2ZmaWNlJTIwY29ycG9yYXRlfGVufDF8fHx8MTc3NDg1OTg0MHww&ixlib=rb-4.1.0&q=80&w=1080"
            alt="About Hero"
            className="w-full h-full object-cover"
          />
          <div className="absolute inset-0 bg-[#1A2A5E] opacity-50"></div>
        </div>

        <div className="relative z-10 text-center px-4 max-w-4xl mx-auto">
          <nav className="text-white/80 text-sm mb-4">
            <Link to="/" className="hover:text-white">Home</Link> &gt; About
          </nav>
          <h1 className="text-5xl md:text-6xl font-bold text-white mb-4">
            About Travzo Holidays
          </h1>
          <p className="text-xl text-white/80">
            Your trusted partner in creating unforgettable travel experiences
          </p>
        </div>
      </section>

      {/* Our Story */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
              <img
                src="https://images.unsplash.com/photo-1768410318733-1e0925a1c9e4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxncm91cCUyMHRyYXZlbGVycyUyMGFkdmVudHVyZSUyMHRvdXJ8ZW58MXx8fHwxNzc0ODUxNjMxfDA&ixlib=rb-4.1.0&q=80&w=1080"
                alt="Our Story"
                className="rounded-2xl shadow-lg w-full"
              />
            </div>
            <div>
              <div className="text-[#C9A227] text-sm font-bold uppercase tracking-wider mb-2">
                Our Story
              </div>
              <h2 className="text-4xl font-bold text-[#1A2A5E] mb-6">Who We Are</h2>
              <p className="text-gray-600 text-lg mb-6 leading-relaxed">
                Founded over a decade ago, Travzo Holidays has grown from a small local agency to Tamil Nadu's most trusted travel partner. Our passion for creating memorable journeys drives everything we do.
              </p>
              <p className="text-gray-600 text-lg mb-8 leading-relaxed">
                We specialize in handcrafted itineraries that cater to every type of traveler - from honeymooners seeking romance to families craving adventure, from devotees on spiritual quests to groups celebrating life's milestones.
              </p>

              {/* Mini Stats */}
              <div className="grid grid-cols-3 gap-6">
                <div>
                  <div className="text-3xl font-bold text-[#C9A227]">500+</div>
                  <div className="text-sm text-gray-600">Happy Travellers</div>
                </div>
                <div>
                  <div className="text-3xl font-bold text-[#C9A227]">50+</div>
                  <div className="text-sm text-gray-600">Destinations</div>
                </div>
                <div>
                  <div className="text-3xl font-bold text-[#C9A227]">10+</div>
                  <div className="text-sm text-gray-600">Years Experience</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Stats Bar */}
      <Stats />

      {/* Why Choose Us Expanded */}
      <section className="py-20 bg-[#F5F5F5]">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <div className="text-[#C9A227] text-sm font-bold uppercase tracking-wider mb-2">
              Why Choose Us
            </div>
            <h2 className="text-4xl md:text-5xl font-bold text-[#1A2A5E] mb-4">
              What Makes Us Different
            </h2>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {features.map((feature, index) => (
              <div key={index} className="bg-white rounded-xl p-8 shadow-sm hover:shadow-md transition-shadow">
                <div className="w-16 h-16 bg-[#C9A227] rounded-full flex items-center justify-center mb-6">
                  <feature.icon className="w-8 h-8 text-[#1A2A5E]" />
                </div>
                <h3 className="text-xl font-bold text-[#1A2A5E] mb-3">
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

      {/* Awards & Achievements */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-[#1A2A5E] mb-4">
              Awards & Achievements
            </h2>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {awards.map((award, index) => (
              <div key={index} className="bg-white rounded-xl p-6 border border-gray-200 hover:border-[#C9A227] transition-colors text-center">
                <div className="w-20 h-20 bg-[#F5F5F5] rounded-full flex items-center justify-center mx-auto mb-4">
                  <Award className="w-10 h-10 text-[#C9A227]" />
                </div>
                <h3 className="text-base font-bold text-[#1A2A5E] mb-2">
                  {award.name}
                </h3>
                <p className="text-sm text-gray-600 mb-1">{award.body}</p>
                <p className="text-sm text-[#C9A227] font-bold">{award.year}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Accreditation Partners */}
      <section className="py-16 bg-[#F5F5F5]">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-[#1A2A5E] mb-4">
              Our Accreditation Partners
            </h2>
          </div>

          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            {partners.map((partner, index) => (
              <div
                key={index}
                className="bg-white rounded-lg p-6 flex items-center justify-center hover:shadow-md transition-shadow"
              >
                <span className="text-gray-600 font-semibold text-sm text-center">
                  {partner}
                </span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <Testimonials />

      {/* CTA */}
      <section className="py-20 bg-[#1A2A5E]">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-4xl font-bold text-white mb-4">
            Ready to Start Your Journey?
          </h2>
          <p className="text-xl text-white/80 mb-8">
            Let us help you create memories that last a lifetime
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link
              to="/packages/group-tours"
              className="bg-[#C9A227] text-[#1A2A5E] px-8 py-4 rounded-lg hover:bg-[#b08f1f] transition-colors font-semibold"
            >
              Explore Packages
            </Link>
            <Link
              to="/contact"
              className="border-2 border-white text-white px-8 py-4 rounded-lg hover:bg-white hover:text-[#1A2A5E] transition-all font-semibold"
            >
              Contact Us
            </Link>
          </div>
        </div>
      </section>

      {/* Newsletter */}
      <Newsletter />
    </>
  );
}
