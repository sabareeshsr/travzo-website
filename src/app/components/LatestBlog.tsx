import { ArrowRight, Calendar } from 'lucide-react';

export function LatestBlog() {
  const blogs = [
    {
      title: 'Top 10 Honeymoon Destinations in 2026',
      excerpt:
        'Discover the most romantic and breathtaking locations perfect for your honeymoon journey this year.',
      category: 'Honeymoon',
      date: 'March 25, 2026',
      image: 'https://images.unsplash.com/photo-1699726258869-36dff6247fd3?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxwYXJpcyUyMGVpZmZlbCUyMHRvd2VyJTIwcm9tYW50aWN8ZW58MXx8fHwxNzc0NzgxNDg3fDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      title: 'Essential Travel Tips for First-Time Solo Travelers',
      excerpt:
        'Everything you need to know before embarking on your first solo adventure around the world.',
      category: 'Solo Travel',
      date: 'March 22, 2026',
      image: 'https://images.unsplash.com/photo-1571648393873-29bad2324860?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx0cmF2ZWwlMjBibG9nJTIwd3JpdGluZyUyMGpvdXJuYWx8ZW58MXx8fHwxNzc0ODUxNjM1fDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      title: 'Sacred Temples of India: A Spiritual Journey',
      excerpt:
        'Explore the divine architecture and spiritual significance of India\'s most revered temples.',
      category: 'Devotional',
      date: 'March 20, 2026',
      image: 'https://images.unsplash.com/photo-1761474415878-d256852d6415?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxpbmRpYW4lMjB0ZW1wbGUlMjBkZXZvdGlvbmFsJTIwcHJheWVyfGVufDF8fHx8MTc3NDg1MTYzMnww&ixlib=rb-4.1.0&q=80&w=1080',
    },
  ];

  return (
    <section className="py-24 bg-[#F5F5F5]">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-[#1A2A5E] mb-4">
            Travel Stories & Tips
          </h2>
          <div className="w-24 h-1 bg-[#C9A227] mx-auto"></div>
        </div>

        {/* Blog Grid */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {blogs.map((blog, index) => (
            <div
              key={index}
              className="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow"
            >
              {/* Image */}
              <div className="relative h-48 overflow-hidden">
                <img
                  src={blog.image}
                  alt={blog.title}
                  className="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                />
                <div className="absolute top-4 left-4 bg-[#C9A227] text-white px-3 py-1 rounded-full text-sm">
                  {blog.category}
                </div>
              </div>

              {/* Content */}
              <div className="p-6">
                <h3 className="text-xl font-bold text-[#1A2A5E] mb-3 hover:text-[#C9A227] transition-colors">
                  {blog.title}
                </h3>
                <p className="text-gray-600 mb-4 leading-relaxed">
                  {blog.excerpt}
                </p>

                {/* Date and Read More */}
                <div className="flex items-center justify-between">
                  <div className="flex items-center gap-2 text-gray-500 text-sm">
                    <Calendar className="w-4 h-4" />
                    <span>{blog.date}</span>
                  </div>
                  <a
                    href="#"
                    className="flex items-center gap-1 text-[#C9A227] font-semibold hover:gap-2 transition-all"
                  >
                    Read More <ArrowRight className="w-4 h-4" />
                  </a>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}