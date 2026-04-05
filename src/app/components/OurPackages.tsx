import { Link } from 'react-router';

export function OurPackages() {
  const packages = [
    {
      name: 'Group Tours',
      count: '12 Tours',
      link: '/packages/group-tours',
      image: 'https://images.unsplash.com/photo-1768410318733-1e0925a1c9e4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxncm91cCUyMHRyYXZlbGVycyUyMGFkdmVudHVyZSUyMHRvdXJ8ZW58MXx8fHwxNzc0ODUxNjMxfDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      name: 'Honeymoon Packages',
      count: '18 Tours',
      link: '/packages/honeymoon',
      image: 'https://images.unsplash.com/photo-1648538923547-074724ca7a18?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxyb21hbnRpYyUyMGhvbmV5bW9vbiUyMGNvdXBsZSUyMGJlYWNofGVufDF8fHx8MTc3NDg1MTYzMnww&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      name: 'Solo Trips',
      count: '8 Tours',
      link: '/packages/solo-trips',
      image: 'https://images.unsplash.com/photo-1528526938169-3e862c52e68a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzb2xvJTIwYmFja3BhY2tlciUyMHRyYXZlbGVyfGVufDF8fHx8MTc3NDg1MTYzMnww&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      name: 'Devotional Tours',
      count: '15 Tours',
      link: '/packages/devotional',
      image: 'https://images.unsplash.com/photo-1761474415878-d256852d6415?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxpbmRpYW4lMjB0ZW1wbGUlMjBkZXZvdGlvbmFsJTIwcHJheWVyfGVufDF8fHx8MTc3NDg1MTYzMnww&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      name: 'Destination Weddings',
      count: '10 Venues',
      link: '/packages/destination-wedding',
      image: 'https://images.unsplash.com/photo-1768777278495-5ffe24f9e3a8?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsdXh1cnklMjBkZXN0aW5hdGlvbiUyMHdlZGRpbmclMjB2ZW51ZXxlbnwxfHx8fDE3NzQ4NTE2MzN8MA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      name: 'International Packages',
      count: '25 Tours',
      link: '/packages/group-tours',
      image: 'https://images.unsplash.com/photo-1765019529158-ccc6a6e8098a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxpbnRlcm5hdGlvbmFsJTIwdHJhdmVsJTIwYWlycGxhbmV8ZW58MXx8fHwxNzc0ODUxNjMzfDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
  ];

  return (
    <section className="py-24 bg-white mt-32">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-[#1A2A5E] mb-4">
            Our Packages
          </h2>
          <div className="w-24 h-1 bg-[#C9A227] mx-auto"></div>
        </div>

        {/* Package Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {packages.map((pkg, index) => (
            <Link
              key={index}
              to={pkg.link}
              className={`relative group overflow-hidden rounded-xl cursor-pointer ${
                index === 0 ? 'md:row-span-2 h-[500px]' : 'h-[240px]'
              }`}
            >
              {/* Image */}
              <img
                src={pkg.image}
                alt={pkg.name}
                className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
              />

              {/* Gradient Overlay */}
              <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

              {/* Content */}
              <div className="absolute bottom-0 left-0 right-0 p-6 text-white">
                <div className="inline-block bg-[#C9A227] text-white px-3 py-1 rounded-full text-sm mb-3">
                  {pkg.count}
                </div>
                <h3 className="text-2xl font-bold">{pkg.name}</h3>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
}