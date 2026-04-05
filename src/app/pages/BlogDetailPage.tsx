import { Link, useParams } from 'react-router';
import { Calendar, User, ArrowLeft, Facebook, Twitter, Linkedin, Share2 } from 'lucide-react';
import { Newsletter } from '../components/Newsletter';

export default function BlogDetailPage() {
  const { id } = useParams<{ id: string }>();

  // Mock blog data - in real app, this would come from an API
  const article = {
    id: 1,
    title: 'Top 10 Honeymoon Destinations in 2026',
    category: 'Honeymoon',
    date: 'March 25, 2026',
    author: 'Priya Sharma',
    readTime: '8 min read',
    image: 'https://images.unsplash.com/photo-1699726258869-36dff6247fd3?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxwYXJpcyUyMGVpZmZlbCUyMHRvd2VyJTIwcm9tYW50aWN8ZW58MXx8fHwxNzc0NzgxNDg3fDA&ixlib=rb-4.1.0&q=80&w=1080',
    content: `
      <p>Planning your honeymoon is one of the most exciting parts of getting married. It's your chance to celebrate your new life together in a destination that reflects your dreams and desires. After helping hundreds of couples plan their perfect romantic getaway, we've compiled the ultimate list of honeymoon destinations for 2026.</p>

      <h2>1. Maldives - Paradise on Earth</h2>
      <p>The Maldives remains the quintessential honeymoon destination, and for good reason. Imagine waking up in an overwater villa, surrounded by crystal-clear turquoise waters, with nothing but pristine beaches and luxury at your fingertips. The Maldives offers unparalleled privacy, world-class resorts, and some of the most romantic sunsets you'll ever witness.</p>
      <p><strong>Best Time to Visit:</strong> November to April<br />
      <strong>Average Budget:</strong> ₹2,50,000 - ₹5,00,000 for 5 nights<br />
      <strong>Perfect For:</strong> Beach lovers, water sports enthusiasts, luxury seekers</p>

      <h2>2. Bali, Indonesia - Island of Gods</h2>
      <p>Bali offers a perfect blend of culture, adventure, and romance. From the terraced rice fields of Ubud to the pristine beaches of Seminyak, this Indonesian paradise has something for every couple. The island's spiritual energy, combined with its natural beauty and affordable luxury, makes it an ideal honeymoon destination.</p>
      <p><strong>Best Time to Visit:</strong> April to October<br />
      <strong>Average Budget:</strong> ₹1,50,000 - ₹3,00,000 for 6 nights<br />
      <strong>Perfect For:</strong> Culture enthusiasts, adventure couples, budget-conscious romantics</p>

      <h2>3. Switzerland - Alpine Romance</h2>
      <p>For couples who dream of snow-capped mountains, charming villages, and chocolate-box scenery, Switzerland is unbeatable. Whether you're taking a scenic train ride through the Alps, enjoying fondue in a cozy chalet, or exploring the beautiful cities of Zurich and Lucerne, Switzerland offers romance at every turn.</p>
      <p><strong>Best Time to Visit:</strong> June to September (summer), December to February (winter)<br />
      <strong>Average Budget:</strong> ₹4,00,000 - ₹7,00,000 for 7 nights<br />
      <strong>Perfect For:</strong> Mountain lovers, luxury travelers, winter sports enthusiasts</p>

      <h2>4. Santorini, Greece - Aegean Elegance</h2>
      <p>With its iconic white-washed buildings, blue-domed churches, and breathtaking caldera views, Santorini is the epitome of Mediterranean romance. Watch the sunset from Oia, explore ancient ruins, indulge in Greek cuisine, and soak in the island's timeless beauty.</p>
      <p><strong>Best Time to Visit:</strong> April to November<br />
      <strong>Average Budget:</strong> ₹3,00,000 - ₹5,50,000 for 6 nights<br />
      <strong>Perfect For:</strong> Photography lovers, wine enthusiasts, sunset chasers</p>

      <h2>5. Paris, France - City of Love</h2>
      <p>Paris needs no introduction as one of the world's most romantic cities. From strolling along the Seine to picnicking at the Eiffel Tower, from exploring world-class museums to savoring French cuisine, Paris offers an unforgettable honeymoon experience steeped in culture and romance.</p>
      <p><strong>Best Time to Visit:</strong> April to June, September to October<br />
      <strong>Average Budget:</strong> ₹3,50,000 - ₹6,00,000 for 6 nights<br />
      <strong>Perfect For:</strong> Art lovers, foodies, classic romantics</p>

      <h2>Planning Tips for Your Perfect Honeymoon</h2>
      <ul>
        <li><strong>Book Early:</strong> Popular honeymoon destinations book up quickly, especially during peak season. Start planning at least 6-8 months in advance.</li>
        <li><strong>Set a Realistic Budget:</strong> Include flights, accommodation, meals, activities, and shopping in your budget calculation.</li>
        <li><strong>Consider the Season:</strong> Research the best time to visit your chosen destination to avoid monsoons or extreme weather.</li>
        <li><strong>Mix Activities:</strong> Balance relaxation with exploration. Plan some lazy days and some adventure-filled ones.</li>
        <li><strong>Inform Hotels:</strong> Let your accommodation know it's your honeymoon – many offer complimentary upgrades or special touches.</li>
      </ul>

      <h2>Why Book with Travzo Holidays?</h2>
      <p>At Travzo Holidays, we understand that your honeymoon is a once-in-a-lifetime trip. Our expert team specializes in creating customized romantic getaways that match your dreams and budget. We handle all the details – from flights and hotels to special experiences and surprises – so you can focus on celebrating your love.</p>
      <p>With over 500 happy couples and 10+ years of experience, we're Tamil Nadu's most trusted travel partner for honeymoons. Contact us today to start planning your perfect romantic escape!</p>
    `,
  };

  const relatedArticles = [
    {
      id: 2,
      title: 'Essential Travel Tips for First-Time Solo Travelers',
      category: 'Travel Tips',
      date: 'March 22, 2026',
      image: 'https://images.unsplash.com/photo-1571648393873-29bad2324860?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx0cmF2ZWwlMjBibG9nJTIwd3JpdGluZyUyMGpvdXJuYWx8ZW58MXx8fHwxNzc0ODUxNjM1fDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      id: 3,
      title: 'Sacred Temples of India: A Spiritual Journey',
      category: 'Devotional',
      date: 'March 20, 2026',
      image: 'https://images.unsplash.com/photo-1761474415878-d256852d6415?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxpbmRpYW4lMjB0ZW1wbGUlMjBkZXZvdGlvbmFsJTIwcHJheWVyfGVufDF8fHx8MTc3NDg1MTYzMnww&ixlib=rb-4.1.0&q=80&w=1080',
    },
    {
      id: 4,
      title: 'Planning the Perfect Group Tour: A Complete Guide',
      category: 'Group Tours',
      date: 'March 18, 2026',
      image: 'https://images.unsplash.com/photo-1768410318733-1e0925a1c9e4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxncm91cCUyMHRyYXZlbGVycyUyMGFkdmVudHVyZSUyMHRvdXJ8ZW58MXx8fHwxNzc0ODUxNjMxfDA&ixlib=rb-4.1.0&q=80&w=1080',
    },
  ];

  return (
    <>
      {/* Article Header */}
      <section className="relative py-32 bg-[#1A2A5E]">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <Link
            to="/blog"
            className="inline-flex items-center gap-2 text-white/80 hover:text-white mb-8 transition-colors"
          >
            <ArrowLeft className="w-4 h-4" />
            Back to Blog
          </Link>

          <div className="inline-block bg-[#C9A227] text-[#1A2A5E] px-4 py-2 rounded-full font-semibold mb-4">
            {article.category}
          </div>

          <h1 className="text-4xl md:text-5xl font-bold text-white mb-6">
            {article.title}
          </h1>

          <div className="flex flex-wrap items-center gap-6 text-white/80">
            <div className="flex items-center gap-2">
              <User className="w-5 h-5" />
              <span>{article.author}</span>
            </div>
            <div className="flex items-center gap-2">
              <Calendar className="w-5 h-5" />
              <span>{article.date}</span>
            </div>
            <div>
              <span>{article.readTime}</span>
            </div>
          </div>
        </div>
      </section>

      {/* Featured Image */}
      <section className="relative -mt-16">
        <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="aspect-video rounded-2xl overflow-hidden shadow-2xl">
            <img
              src={article.image}
              alt={article.title}
              className="w-full h-full object-cover"
            />
          </div>
        </div>
      </section>

      {/* Article Content */}
      <section className="py-16 bg-white">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-12 gap-12">
            {/* Main Content */}
            <article className="lg:col-span-8 prose prose-lg max-w-none">
              <div
                className="article-content text-gray-700 leading-relaxed"
                dangerouslySetInnerHTML={{ __html: article.content }}
              />
            </article>

            {/* Sidebar */}
            <aside className="lg:col-span-4">
              <div className="sticky top-32 space-y-8">
                {/* Share Section */}
                <div className="bg-[#F5F5F5] rounded-xl p-6">
                  <h3 className="text-lg font-bold text-[#1A2A5E] mb-4 flex items-center gap-2">
                    <Share2 className="w-5 h-5 text-[#C9A227]" />
                    Share Article
                  </h3>
                  <div className="flex gap-3">
                    <button className="flex-1 bg-[#1877F2] text-white p-3 rounded-lg hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                      <Facebook className="w-5 h-5" />
                    </button>
                    <button className="flex-1 bg-[#1DA1F2] text-white p-3 rounded-lg hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                      <Twitter className="w-5 h-5" />
                    </button>
                    <button className="flex-1 bg-[#0A66C2] text-white p-3 rounded-lg hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                      <Linkedin className="w-5 h-5" />
                    </button>
                  </div>
                </div>

                {/* CTA Box */}
                <div className="bg-[#1A2A5E] rounded-xl p-6 text-white">
                  <h3 className="text-xl font-bold mb-3">Ready to Plan Your Honeymoon?</h3>
                  <p className="text-white/80 mb-6 text-sm">
                    Let our experts create the perfect romantic getaway for you
                  </p>
                  <Link
                    to="/contact"
                    className="block w-full bg-[#C9A227] text-[#1A2A5E] text-center py-3 rounded-lg hover:bg-[#b08f1f] transition-colors font-bold"
                  >
                    Get Free Quote
                  </Link>
                </div>

                {/* Author Box */}
                <div className="bg-white border border-gray-200 rounded-xl p-6">
                  <h3 className="text-lg font-bold text-[#1A2A5E] mb-3">About the Author</h3>
                  <div className="flex items-center gap-3 mb-3">
                    <div className="w-12 h-12 bg-[#C9A227] rounded-full flex items-center justify-center text-[#1A2A5E] font-bold">
                      PS
                    </div>
                    <div>
                      <h4 className="font-bold text-[#1A2A5E]">{article.author}</h4>
                      <p className="text-sm text-gray-600">Travel Expert</p>
                    </div>
                  </div>
                  <p className="text-sm text-gray-600">
                    Priya is a seasoned travel expert with over 8 years of experience in curating dream honeymoon packages. She has personally visited 30+ countries and loves sharing insider tips.
                  </p>
                </div>
              </div>
            </aside>
          </div>
        </div>
      </section>

      {/* Related Articles */}
      <section className="py-20 bg-[#F5F5F5]">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-[#1A2A5E] mb-12">Related Articles</h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {relatedArticles.map((relatedArticle) => (
              <Link
                key={relatedArticle.id}
                to={`/blog/${relatedArticle.id}`}
                className="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow"
              >
                <div className="relative h-48 overflow-hidden">
                  <img
                    src={relatedArticle.image}
                    alt={relatedArticle.title}
                    className="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                  />
                  <div className="absolute top-4 left-4 bg-[#C9A227] text-[#1A2A5E] px-3 py-1 rounded-full text-sm font-semibold">
                    {relatedArticle.category}
                  </div>
                </div>
                <div className="p-6">
                  <h3 className="text-lg font-bold text-[#1A2A5E] mb-3 hover:text-[#C9A227] transition-colors">
                    {relatedArticle.title}
                  </h3>
                  <div className="flex items-center gap-2 text-gray-500 text-sm">
                    <Calendar className="w-4 h-4" />
                    <span>{relatedArticle.date}</span>
                  </div>
                </div>
              </Link>
            ))}
          </div>
        </div>
      </section>

      {/* Newsletter */}
      <Newsletter />

      <style>{`
        .article-content h2 {
          font-size: 1.875rem;
          font-weight: bold;
          color: #1A2A5E;
          margin-top: 2.5rem;
          margin-bottom: 1rem;
        }
        
        .article-content p {
          margin-bottom: 1.5rem;
          line-height: 1.8;
        }
        
        .article-content ul {
          list-style-type: disc;
          margin-left: 1.5rem;
          margin-bottom: 1.5rem;
        }
        
        .article-content li {
          margin-bottom: 0.75rem;
          line-height: 1.8;
        }
        
        .article-content strong {
          color: #1A2A5E;
          font-weight: 600;
        }
      `}</style>
    </>
  );
}
