import { Link } from 'react-router';
import { useState } from 'react';
import { Calendar, ArrowRight } from 'lucide-react';
import { Newsletter } from '../components/Newsletter';

export default function BlogListPage() {
  const [activeCategory, setActiveCategory] = useState('all');

  const categories = ['All', 'Destinations', 'Travel Tips', 'Honeymoon', 'Group Tours', 'Devotional'];

  const featuredBlog = {
    id: 1,
    title: 'Top 10 Honeymoon Destinations in 2026',
    excerpt: 'Discover the most romantic and breathtaking locations perfect for your honeymoon journey. From pristine beaches to snow-capped mountains, we cover the best destinations that will make your honeymoon truly unforgettable.',
    category: 'Honeymoon',
    date: 'March 25, 2026',
    author: 'Priya Sharma',
    image: 'https://images.unsplash.com/photo-1699726258869-36dff6247fd3?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxwYXJpcyUyMGVpZmZlbCUyMHRvd2VyJTIwcm9tYW50aWN8ZW58MXx8fHwxNzc0NzgxNDg3fDA&ixlib=rb-4.1.0&q=80&w=1080',
  };

  const blogs = [
    {
      id: 2,
      title: 'Essential Travel Tips for First-Time Solo Travelers',
      excerpt: 'Everything you need to know before embarking on your first solo adventure around the world.',
      category: 'Travel Tips',
      date: 'March 22, 2026',
      image: 'https://images.unsplash.com/photo-1571648393873-29bad2324860?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx0cmF2ZWwlMjBibG9nJTIwd3JpdGluZyUyMGpvdXJuYWx8ZW58MXx8fHwxNzc0ODUxNjM1fDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      id: 3,
      title: 'Sacred Temples of India: A Spiritual Journey',
      excerpt: 'Explore the divine architecture and spiritual significance of India\'s most revered temples.',
      category: 'Devotional',
      date: 'March 20, 2026',
      image: 'https://images.unsplash.com/photo-1761474415878-d256852d6415?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxpbmRpYW4lMjB0ZW1wbGUlMjBkZXZvdGlvbmFsJTIwcHJheWVyfGVufDF8fHx8MTc3NDg1MTYzMnww&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      id: 4,
      title: 'Planning the Perfect Group Tour: A Complete Guide',
      excerpt: 'Tips and tricks for organizing memorable group tours that everyone will enjoy.',
      category: 'Group Tours',
      date: 'March 18, 2026',
      image: 'https://images.unsplash.com/photo-1768410318733-1e0925a1c9e4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxncm91cCUyMHRyYXZlbGVycyUyMGFkdmVudHVyZSUyMHRvdXJ8ZW58MXx8fHwxNzc0ODUxNjMxfDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      id: 5,
      title: 'Bali vs Maldives: Which is Right for Your Honeymoon?',
      excerpt: 'An in-depth comparison of two of the most popular honeymoon destinations.',
      category: 'Honeymoon',
      date: 'March 15, 2026',
      image: 'https://images.unsplash.com/photo-1730944524570-44f1c584fd54?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtYWxkaXZlcyUyMGJlYWNoJTIwdHJvcGljYWwlMjBwYXJhZGlzZXxlbnwxfHx8fDE3NzQ4NTE2MzR8MA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      id: 6,
      title: '10 Must-Visit Places in Switzerland',
      excerpt: 'From the Swiss Alps to charming villages, discover Switzerland\'s hidden gems.',
      category: 'Destinations',
      date: 'March 12, 2026',
      image: 'https://images.unsplash.com/photo-1615982653374-2a6312586ed2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzd2l0emVybGFuZCUyMGFscHMlMjBzY2VuaWN8ZW58MXx8fHwxNzc0ODUxNjM0fDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      id: 7,
      title: 'Budget Travel Tips: How to Travel More for Less',
      excerpt: 'Practical advice for stretching your travel budget without compromising on experiences.',
      category: 'Travel Tips',
      date: 'March 10, 2026',
      image: 'https://images.unsplash.com/photo-1528526938169-3e862c52e68a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzb2xvJTIwYmFja3BhY2tlciUyMHRyYXZlbGVyfGVufDF8fHx8MTc3NDg1MTYzMnww&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      id: 8,
      title: 'The Ultimate Dubai Travel Guide',
      excerpt: 'Everything you need to know for an amazing Dubai vacation - attractions, food, and culture.',
      category: 'Destinations',
      date: 'March 8, 2026',
      image: 'https://images.unsplash.com/photo-1768069794857-9306ac167c6e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxkdWJhaSUyMHNreWxpbmUlMjBsdXh1cnl8ZW58MXx8fHwxNzc0Nzk0OTgyfDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      id: 9,
      title: 'Char Dham Yatra: A Complete Pilgrimage Guide',
      excerpt: 'Plan your spiritual journey to the four sacred shrines of Uttarakhand.',
      category: 'Devotional',
      date: 'March 5, 2026',
      image: 'https://images.unsplash.com/photo-1673505413397-0cd0dc4f5854?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxoaW1hbGF5YW4lMjBtb3VudGFpbiUyMHNjZW5pYyUyMGxhbmRzY2FwZXxlbnwxfHx8fDE3NzQ4NTE2MzF8MA&ixlib=rb-4.1.0&q=80&w=1080',
    },
  ];

  return (
    <>
      {/* Page Hero */}
      <section className="relative h-[50vh] flex items-center justify-center">
        <div className="absolute inset-0">
          <img
            src="https://images.unsplash.com/photo-1571648393873-29bad2324860?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx0cmF2ZWwlMjBibG9nJTIwd3JpdGluZyUyMGpvdXJuYWx8ZW58MXx8fHwxNzc0ODUxNjM1fDA&ixlib=rb-4.1.0&q=80&w=1080"
            alt="Blog Hero"
            className="w-full h-full object-cover"
          />
          <div className="absolute inset-0 bg-[#1A2A5E] opacity-50"></div>
        </div>

        <div className="relative z-10 text-center px-4 max-w-4xl mx-auto">
          <h1 className="text-5xl md:text-6xl font-bold text-white mb-4">
            Travel Stories & Tips
          </h1>
          <p className="text-xl text-white/80">
            Inspiration, guides, and insights for your next adventure
          </p>
        </div>
      </section>

      {/* Category Filter */}
      <section className="py-12 bg-white border-b border-gray-200">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex flex-wrap gap-4 justify-center">
            {categories.map((category) => (
              <button
                key={category}
                onClick={() => setActiveCategory(category.toLowerCase())}
                className={`px-6 py-2 rounded-full transition-colors ${
                  activeCategory === category.toLowerCase()
                    ? 'bg-[#C9A227] text-[#1A2A5E]'
                    : 'bg-gray-100 text-[#1A2A5E] hover:bg-gray-200'
                }`}
              >
                {category}
              </button>
            ))}
          </div>
        </div>
      </section>

      {/* Featured Blog */}
      <section className="py-16 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div className="relative h-96 rounded-2xl overflow-hidden">
              <img
                src={featuredBlog.image}
                alt={featuredBlog.title}
                className="w-full h-full object-cover"
              />
              <div className="absolute top-4 left-4 bg-[#C9A227] text-[#1A2A5E] px-4 py-2 rounded-full font-semibold">
                {featuredBlog.category}
              </div>
            </div>
            <div>
              <div className="text-[#C9A227] text-sm font-bold uppercase tracking-wider mb-2">
                Featured Article
              </div>
              <h2 className="text-4xl font-bold text-[#1A2A5E] mb-4">
                {featuredBlog.title}
              </h2>
              <p className="text-gray-600 text-lg mb-6 leading-relaxed">
                {featuredBlog.excerpt}
              </p>
              <div className="flex items-center gap-4 text-sm text-gray-500 mb-6">
                <div className="flex items-center gap-1">
                  <Calendar className="w-4 h-4" />
                  {featuredBlog.date}
                </div>
                <span>•</span>
                <span>By {featuredBlog.author}</span>
              </div>
              <Link
                to={`/blog/${featuredBlog.id}`}
                className="inline-flex items-center gap-2 bg-[#C9A227] text-[#1A2A5E] px-8 py-3 rounded-lg hover:bg-[#b08f1f] transition-colors font-semibold"
              >
                Read Article <ArrowRight className="w-4 h-4" />
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* Blog Grid */}
      <section className="py-20 bg-[#F5F5F5]">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {blogs.map((blog) => (
              <div
                key={blog.id}
                className="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow"
              >
                {/* Image */}
                <div className="relative h-48 overflow-hidden">
                  <img
                    src={blog.image}
                    alt={blog.title}
                    className="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                  />
                  <div className="absolute top-4 left-4 bg-[#C9A227] text-[#1A2A5E] px-3 py-1 rounded-full text-sm font-semibold">
                    {blog.category}
                  </div>
                </div>

                {/* Content */}
                <div className="p-6">
                  <h3 className="text-xl font-bold text-[#1A2A5E] mb-3 hover:text-[#C9A227] transition-colors">
                    <Link to={`/blog/${blog.id}`}>{blog.title}</Link>
                  </h3>
                  <p className="text-gray-600 mb-4 leading-relaxed line-clamp-2">
                    {blog.excerpt}
                  </p>

                  {/* Date and Read More */}
                  <div className="flex items-center justify-between">
                    <div className="flex items-center gap-2 text-gray-500 text-sm">
                      <Calendar className="w-4 h-4" />
                      <span>{blog.date}</span>
                    </div>
                    <Link
                      to={`/blog/${blog.id}`}
                      className="flex items-center gap-1 text-[#C9A227] font-semibold hover:gap-2 transition-all text-sm"
                    >
                      Read More <ArrowRight className="w-4 h-4" />
                    </Link>
                  </div>
                </div>
              </div>
            ))}
          </div>

          {/* Pagination */}
          <div className="flex items-center justify-center gap-2 mt-12">
            <button className="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:border-[#C9A227] hover:text-[#C9A227] transition-colors">
              Previous
            </button>
            <button className="px-4 py-2 rounded-lg bg-[#C9A227] text-[#1A2A5E] font-semibold">
              1
            </button>
            <button className="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:border-[#C9A227] hover:text-[#C9A227] transition-colors">
              2
            </button>
            <button className="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:border-[#C9A227] hover:text-[#C9A227] transition-colors">
              3
            </button>
            <button className="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:border-[#C9A227] hover:text-[#C9A227] transition-colors">
              Next
            </button>
          </div>
        </div>
      </section>

      {/* Newsletter */}
      <Newsletter />
    </>
  );
}
